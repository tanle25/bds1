<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerInfomationUpdateRequest;
use Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Image;
use Str;

class CustomerProfileController extends Controller
{
    public function showInformation()
    {
        return view('customer.pages.user_profile.infomation');
    }

    public function updateInformation(CustomerInfomationUpdateRequest $request)
    {
        $path = auth()->user()->profile_image_path;
        if ($request->hasFile('profile_image_path')) {
            $save_path = storage_path('app/public/user_avatar');
            $image_name = Str::random(15) . '.jpg';
            if (!file_exists($save_path)) {
                mkdir($save_path, 0775, true);
            }
            Image::make($request->file('profile_image_path'))->save(storage_path('app/public/user_avatar/' . $image_name));
            if (!file_exists($save_path . '/thumbs')) {
                mkdir($save_path . '/thumbs', 0775, true);
            }
            Image::make($request->file('profile_image_path'))
                ->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/user_avatar/thumbs/' . $image_name));
            $path = Storage::url('user_avatar/' . $image_name);
        }

        $new_data = [
            'name' => $request->name,
            'birthday' => Carbon::createFromFormat('d/m/Y', $request->birthday)->format('Y-m-d H:i:s'),
            'gender' => $request->gender,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'profile_image_path' => $path,
        ];
        $user = auth()->user();
        $user->update($new_data);
        if ($request->new_password) {
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_pasword);
                $user->save();
            } else {
                return redirect()->back()->with('error', 'Mật khẩu cũ không chính xác!');
            }
        }
        return redirect()->back()->with('success', 'Cập nhật thành công thông tin!');

    }
}