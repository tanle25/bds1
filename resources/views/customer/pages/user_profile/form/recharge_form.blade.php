@php
    $user = auth()->user();
@endphp

<form class="bg-white" action="/tai-khoan/nap-tien" method="post">
    @csrf
    <div class="col-12 p-2 bg-white mb-2 d-flex align-items-center justify-content-between">
        <h3 class=" text-secondary m-0">Nạp tiền vào tài khoản</h3>
    </div>

    <div class="row payment-info p-3">
            <div class="form-group col-md-6">
                <label class="control-label" for="amount_of_money">Số tiền muốn nạp:</label>
                <input type="amount_of_money" class="form-control @error('amount_of_money') is-invalid @enderror" id="amount_of_money" placeholder="Tối thiểu 10.000đ" name="amount_of_money">
                @error('amount_of_money')
                <div id="" class="error invalid-feedback d-block">
                        {{$message}}
                </div>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label class="control-label" for="customer_name">Tên khách hàng: </label>
                <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" placeholder="Nhập tên khách hàng" name="customer_name"
                value="{{$user->name ?? ''}}"
                >
                @error('customer_name')
                <div id="" class="error invalid-feedback d-block">
                        {{$message}}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label class="control-label" for="customer_email">Email:</label>
                <input type="text" class="form-control @error('customer_email') is-invalid @enderror" id="customer_email" placeholder="Nhập email" name="customer_email"
                value="{{$user->email ?? ''}}"
                >
                @error('customer_email')
                <div id="" class="error invalid-feedback d-block">
                        {{$message}}
                </div>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label class="control-label" for="customer_phone">Số điện thoại:</label>
                <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" id="customer_phone" placeholder="Số điện thoại" name="customer_phone"
                value="{{$user->phone_number ?? ''}}"
                >
                @error('customer_phone')
                <div id="" class="error invalid-feedback d-block">
                        {{$message}}
                </div>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label class="control-label" for="customer_message">Nội dung giao dịch:</label>
                <textarea  class="form-control @error('customer_message') is-invalid @enderror" id="customer_message" placeholder="Nhập nội dung giao dịch" name="customer_message" cols="30" rows="7"></textarea>
                @error('customer_message')
                <div id="" class="error invalid-feedback d-block">
                        {{$message}}
                </div>
                @enderror
            </div>
    </div>
    <div class="p-3">
        <div class="payment-wraper">
            @error('payment_method')
                <div id="" class="error invalid-feedback d-block">
                        {{$message}}
                </div>
            @enderror
            @error('bank_code')
                <div id="" class="error invalid-feedback d-block">
                        {{$message}}
                </div>
            @enderror
            <div class="payment-method">
                <div class="method-image">
                    <img src="/images/Logo-VNPAYQR.png" alt="" srcset="">
                </div>
                <div class="method-content">
                    <strong>Chọn hình thức thanh toán online</strong> <br>
                    <span>Sử dụng điện thoại quét mã QR hoặc nạp trược tiếp trên ứng dụng VnPay.</span>
                </div>
                <div>
                    <div class="method-checkbox"><input type="radio" checked name="payment_method" value="1"></div>
                </div>
            </div>
            {{-- <div class="bank-list payment-body p-2 w-100">
                <div class="row p-0 m-0 bg-white ">
                    @foreach ($vnpay_banks as $bank)
                    <div class="col-lg-2 col-md-3 col-4 bank-select border p-0 m-md-1">
                        <input class="d-none" type="radio" id="{{$bank->code}}" value="{{$bank->code}}" name="bank_code">
                        <label class="d-block m-0 p-2 w-100 h-100" for="{{$bank->code}}"><img class="img-fluid" src="{{$bank->avatar}}" alt=""></label>
                    </div>
                    @endforeach
                </div>
            </div> --}}
        </div>

        <div class="payment-wraper">
            <div class="payment-method">
                <div class="method-image">
                    <img src="https://sosanhnha.com/quanly/images/bank.jpg" alt="" srcset="">
                </div>
                <div  class="method-content">
                    <strong>Chọn hình nạp qua chuyển khoản trực tiếp</strong> <br>
                    <span>Sử dụng phương thức chuyển tiền qua tài khoản cá nhân của quản trị viên</span>
                </div>
                <div>
                    <div class="method-checkbox"><input type="radio" @if(old('payment_method') == 5) checked @endif name="payment_method" value="5"></div>
                </div>
            </div>
            <div class="bank-list payment-body p-3">
                @foreach ($bank_list as $bank)
                    <div class="bank-details p-2">
                        <div class="bank-details-head">
                            <div style="width: 60px">
                                <img src="{{explode(',',$bank->bank_avatar)[0] ?? ''}}" alt="">
                            </div>
                            <div class="pl-3"><strong>{{$bank->bank_name}}</strong></div>
                        </div>
                        <div class="bank-content">
                            <div><label>Số tài khoản: </label><span>{{$bank->bank_account ?? ''}}</span></div>
                            <div><label>Chủ tài khoản: </label><span>{{$bank->bank_owner ?? ''}}</span></div>
                            <div><label>Chi nhánh: </label><span>{{$bank->bank_branch ?? ''}}</span></div>
                            <div><label>Số điện thoại: </label><span>{{$bank->owner_phone ?? ''}}</span></div>
                            <div><label>Email: </label><span>{{$bank->owner_email ?? ''}}</span></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <input type="hidden" name="recaptcha" id="recaptcha">
    <button type="submit" class="btn btn-success w-100 rounded-0 mb-0"><strong>NẠP TIỀN</strong></button>
</form>

@section('script')
@parent
<script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPCHA_CLIENT') }}"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('{{ env('GOOGLE_RECAPCHA_CLIENT') }}', {action: 'contact'}).then(function(token) {
            if (token) {
                document.getElementById('recaptcha').value = token;
            }
        });
    });
    $('[name=payment_method]').on('change', function(){
        $('.payment-wraper').removeClass('active');
        $('[name=payment_method]:checked').closest('.payment-wraper').addClass('active');
    });
    $('[name=payment_method]:checked').closest('.payment-wraper').addClass('active');
</script>
@endsection
