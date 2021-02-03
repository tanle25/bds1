<div class="modal modal-login fade" id="register" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content px-3 pb-2">
      <div class="modal-body">
        <div class="logo-login text-center">
            <img height="70px" src="{{Str::replaceLast(',', '', $theme_options['logo'] ?? '')}}" alt="">
        </div>
        <div class="pt-2 text-center mb-3">
            <strong class="text-blue-dark font-13">Đăng ký tài khoản mới</strong>
        </div>
        <form action="/register" method="POST" id="form-login" class="form-login font-9">
          @csrf
          <div class="form-group">
            <div class="bl-div div-fullname">
                <label for="">Họ và tên</label>
              <input type="text" name="register_fullname" id="fullname_register" value="{{old('register_fullname')}}"  class="form-control font-9" placeholder="Họ và tên" required="required">
              <div class="errors_input text-danger">
                @error('register_fullname')
                  {{$message}}
                @enderror
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="bl-div div-phone">
                <label for="">Số điện thoại</label>
              <input type="text" name="register_phone_number" class="form-control font-9" value="{{old('register_phone_number')}}" placeholder="Số điện thoại">
              <div class="errors_input text-danger">
                @error('register_phone_number')
                  {{$message}}
                @enderror
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="bl-div div-email">
                <label for="">Email</label>
              <input type="email" name="register_email" class="form-control font-9" value="{{old('register_email')}}" placeholder="Email">
              <div class="errors_input text-danger">
                @error('register_email')
                  {{$message}}
                @enderror
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="bl-div div-password">
                <label for="">Mật khẩu</label>
              <input data-type="password" type="text" name="register_password" value="{{old('register_password')}}" class="form-control" placeholder="Mật khẩu">
              <span class="span-eyes"></span>
            </div>
            <div class="errors_input text-danger">
              @error('register_password')
                {{$message}}
              @enderror
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn login-btn w-100" id="register-normal">ĐĂNG KÝ</button>
          </div>
          {{-- <p class="p-text text-center font-9">-Hoặc-</p>
            <div class="text-center row m-0">
                <div class="col-6 pl-2">
                    <a href="/auth/facebook" class="d-block  py-2 px-3 facebook-btn rounded"><i class="mr-1 fab fa-facebook-square"></i>Facebook</a>
                </div>
                <div class="col-6 pr-2">
                    <a href="/auth/facebook" class="d-block m py-2 px-3 google-btn rounded"><i class="fab fa-google"></i> Google</a>
                </div>
            </div> --}}
        <div class="bl-creat-account font-8 text-center mt-3"><span>Bằng việc đăng ký, bạn đã đồng ý với chúng tôi về </span> <a href="#" class="color-blue">Điều khoản và chính sách</a></div>
        </form>
      </div>
    </div>
  </div>
</div>

@section('script')
  @parent
  @if ($errors->has('register_fullname') || $errors->has('register_password') || $errors->has('register_phone_number') || $errors->has('register_email'))
    <script>
      $(document).ready(function(){
        $('#register').modal('toggle')
      });
    </script>
  @endif
@endsection
