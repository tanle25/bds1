<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\RechargeSuccess;
use App\Models\Bank;
use App\Models\Bill;
use App\Models\VnPay;
use App\Models\WebConfig;
use App\Services\BillService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mail;
use Spatie\Activitylog\Models\Activity;

class CustomerRechargeController extends Controller
{
    public function __construct(BillService $bill_service)
    {
        $this->bill_service = $bill_service;
    }

    public function showForm()
    {
        $bank = WebConfig::where('key', 'bank')->first();
        if ($bank) {
            $bank_list = json_decode($bank->value);
        } else {
            $bank_list = [];
        }
        $vnpay_banks = Bank::all();
        return view('customer.pages.user_profile.recharge', compact('bank_list', 'vnpay_banks'));
    }

    public function showAccountBalance()
    {
        $user = Auth::user();
        $wallet = $user->wallet;
        $history = Activity::where(['causer_id' => $user->id, 'subject_type' => 'App\Models\AccountBalance'])->get();
        return view('customer.pages.user_profile.account_balance', compact('wallet', 'history'));
    }

    public function recharge(\App\Http\Requests\RechargeRequest $request)
    {
        $is_human = $this->checkRecapcha($request);

        if (!$is_human) {
            return redirect()->back()->with('fail', 'Lỗi xác thực từ google capcha bạn có phải con người?');
        }
        session(['prev_url' => url()->previous()]); // gắn url cũ vào session
        // Kiểm tra ví  người dùng có tồn tại k
        $user = Auth::user();
        $wallet = $user->wallet;
        if (!$wallet) {
            dd("Tài khoản chưa có ví");
        }
        //Tạo hóa đơn nạp tiền
        $bill_data = [
            'amount_of_money' => $request->amount_of_money,
            'owner_name' => $request->customer_name,
            'owner_email' => $request->customer_email,
            'owner_phone' => $request->customer_phone,
            'owner_confirm_message' => $request->custome_message,
        ];

        $new_bill = $this->bill_service->storeBillFromCustomer($user->id, $bill_data);
        if ($request->payment_method == 1) {
            //Tạo vn pay bill để quản lý
            $new_vnpay_bill = VnPay::create([
                'merchant_bill_id' => $new_bill->id,
                'merchant_bill_code' => $new_bill->bill_code,
                // 'bank_code' => $request->bank_code,
            ]);
            return $this->vnPayCharge($new_bill, $new_vnpay_bill);
        }

        if ($request->payment_method == 5) {
            return redirect()->route('customer.bill.confirm', $new_bill->id);
        }
    }

    public function thirdPartyCallback(Request $request)
    {
        $payment_details = $this->vnPayCallback($request);
        $owner = $payment_details['bill']->owner;
        $bill = $payment_details['bill'];
        if (!$owner) {
            return "Không xác định được chủ hóa đơn";
        }
        // Nhận thông tin về trạng thái thanh toán từ bên thứ 3
        $wallet = $owner->wallet;
        $url = session('prev_url', '/');
        //Xác nhận thông tin có hợp lệ chưa
        switch ($payment_details['RspCode']) {
            case '00':
                $wallet->main_account = $wallet->main_account + $bill->amount_of_money;
                $wallet->save();
                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($wallet)
                    ->withProperties([
                        'amount_of_money' => $bill->amount_of_money,
                        'main_account' => $wallet->main_account,
                    ])
                    ->log('Nạp tiền vào tài khoản');
                Mail::to($owner->email)->send(new RechargeSuccess($owner, $bill));

                return redirect()->route('customer.profile.account_balance.index')->with('success', 'Đã thanh toán phí dịch vụ');
                break;
            case '24':
                return redirect()->route('customer.profile.account_balance.index')->with('warning', 'Bạn đã thoát khỏi quá trình thanh toán!');
            case '02':
                return 'Hóa đơn này đã được thanh toán vui lòng kiểm tra lại tài khoản';
            default:
                return $payment_details['Message'] ?? 'Lỗi không xác định';
                break;
        }
    }

    protected function checkRecapcha($request)
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('GOOGLE_RECAPCHA_SECRET_KEY'),
            'response' => $request->recaptcha,
            'remoteip' => $request->ip(),
        ]);
        $result = $response->json();
        if (isset($result['score']) && $result['score'] >= 0.3) {
            return true;
        }

        return false;
    }

    protected function vnPayCharge($order, $vnpay_bill)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('customer.payment.callback_from_online_payment');
        $vnp_TmnCode = env('VNP_TMNCODE');//Mã website tại VNPAY
        $vnp_HashSecret = env('VNP_HASHSECRET'); //Chuỗi bí mật

        $vnp_TxnRef = $order->bill_code; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'nap tien vao tai khoan ' . $order->owner_id;

        $vnp_Amount = $order->amount_of_money * 100;
        $vnp_Locale = 'vi';
        $vnp_IpAddr = request()->ip();
        //Add Params of 2.0.1 Version
        //Billing
        $vnp_Bill_Mobile = $order->owner->phone_number;
        $vnp_Bill_Email = $order->owner->email;
        $fullName = trim($order->owner->name);
        if (isset($fullName) && trim($fullName) != '') {
            $name = explode(' ', $fullName);
            $vnp_Bill_FirstName = array_shift($name);
            $vnp_Bill_LastName = array_pop($name);
        }
        // $vnp_Bill_Address=$order->owner->phone_number;
        // $vnp_Bill_City='hoang hoa';
        // $vnp_Bill_Country='viet nam';
        // $vnp_Bill_State='thanh hoa';
        // Invoice
        $vnp_Inv_Phone=$order->owner->phone_number;
        $vnp_Inv_Email=$order->owner->email;
        $vnp_Inv_Customer=$order->owner->name;
        // $vnp_Inv_Address='hoang thang';
        // $vnp_Inv_Company='hoang hoa';
        // $vnp_Inv_Taxcode='thanh hoa';
        $vnp_Inv_Type='thanh toan hoa don';
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,

            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
            "vnp_Bill_Email"=>$vnp_Bill_Email,
            "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
            "vnp_Bill_LastName"=>$vnp_Bill_LastName,
            // "vnp_Bill_Address"=>$vnp_Bill_Address,
            // "vnp_Bill_City"=>$vnp_Bill_City,
            // "vnp_Bill_Country"=>$vnp_Bill_Country,
            "vnp_Inv_Phone"=>$vnp_Inv_Phone,
            "vnp_Inv_Email"=>$vnp_Inv_Email,
            "vnp_Inv_Customer"=>$vnp_Inv_Customer,
            // "vnp_Inv_Address"=>$vnp_Inv_Address,
            // "vnp_Inv_Company"=>$vnp_Inv_Company,
            // "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
            "vnp_Inv_Type"=>$vnp_Inv_Type
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return redirect($vnp_Url);
    }

    protected function vnPayCallback(Request $request)
    {
        $inputData = array();
        $returnData = array();

        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, env('VNP_HASHSECRET'));
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount']/100; // Số tiền thanh toán VNPAY phản hồi

        $status = 0;
        $orderId = $request->vnp_TxnRef;

        $order = Bill::with('vnpay_bill')->where('bill_code', $request->vnp_TxnRef)->first();
        $returnData['bill'] = $order;

        try {
            //Check Orderid
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);
                // dd("thanh toán thành công");
                if ($order != null) {
                    $order->vnpay_bill->update([
                        'card_type' => $request->vnp_CardType,
                        'response_code' => $request->vnp_ResponseCode,
                        'order_info' => $request->vnp_OrderInfo,
                    ]);
                    if ($order->status != null && $order->status == 1) {

                        if ($inputData['vnp_ResponseCode'] == '00') {
                            $status = 2;
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        } else {
                            $status = 3;
                            $returnData['RspCode'] = $inputData['vnp_ResponseCode'];
                            $returnData['Message'] = '';
                        }
                        $order->status = $status;
                        $order->save();
                    } else {
                        $returnData['RspCode'] = '02';
                        $returnData['Message'] = 'Order already confirmed';
                    }

                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }

            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Chu ky khong hop le';
            }
        } catch (Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }

        return $returnData;
    }

}
