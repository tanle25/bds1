<div class="modal modal-login fade" id="popup-login" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content px-4 pb">
      <div class="modal-body">
        <div class="logo-login text-center">
          <img height="70px" src="{{Str::replaceLast(',', '', $theme_options['logo'] ?? '')}}" alt="">
        </div>
        <div class="pt-2 mb-3 text-center">
            <strong class="text-blue-dark font-13">Đăng nhập vào tại khoản của bạn</strong>
        </div>
        <form action="/login" method="POST" id="form-login" class="form-login font-9">
          @csrf
          <div class="form-group">
            <div class="bl-div div-phone">
                <label for="username">Số điện thoại / Email</label>
              <input type="text" name="username" class="form-control font-9" value="" placeholder="Email">
            </div>
          </div>
          <div class="form-group">
            <div class="bl-div div-password">
                <label for="username">Mật khẩu</label>
                <input data-type="password" type="password" name="password" value="" class="form-control font-9" placeholder="Mật khẩu">
                <span class="span-eyes"></span>
            </div>
            <div class="errors_input text-danger">
              @error('login_fail')
                {{$message}}
              @enderror
            </div>
          </div>
          <div class="bl-remember font-9">
            <div class="d-flex justify-content-between align-items-center">
              <div class="checkbox bl-checkbox">
                <input id="remenber_pass_1" class="requestType" type="checkbox" name="remenber" value="1">
                <label for="remenber_pass_1">Ghi nhớ tài khoản</label>
              </div>
              <div class=""><a href="#" id="myforgot-password" data-toggle="modal" data-target="#forgot-password"><strong>Quên mật khẩu?</strong> </a></div>
            </div>

          </div>
          <div class="form-group mt-3">
            <button type="submit" class="btn login-btn w-100" id="login-normal">ĐĂNG NHẬP</button>
          </div>
          <div class="bl-creat-account font-9 text-center"><span>Chưa có tài khoản?</span> <a href="#" id="myregister" data-toggle="modal" data-target="#register" class="color-blue">Đăng ký ngay</a></div>
        </form>
      </div>
    </div>

  </div>
</div>


@section('script')
  @parent
  @if ($errors->has('login_fail'))
    <script>
      $(document).ready(function(){
        $('#popup-login').modal('toggle')
      });
    </script>
  @endif
@endsection
