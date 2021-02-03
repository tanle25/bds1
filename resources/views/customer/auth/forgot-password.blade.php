<div class="modal modal-login fade" id="forgot-password" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content p-3">
        <div class="logo-login text-center">
            <img height="70px" src="{{Str::replaceLast(',', '', $theme_options['logo'] ?? '')}}" alt="">
        </div>
        <div class="pt-2 text-center">
            <strong class="text-blue-dark font-13">Quên mật khẩu?</strong>
            <p class="text-secondary font10">Nhập địa chỉ email bạn đã đăng ký, chúng tôi sẽ giúp bạn lấy lại mật khẩu</p>
        </div>
        <form action="/forgot-password" method="POST" id="forgotPassword" class="forgotPassword">
          @csrf
          <div class="form-group">
            <div class="bl-div div-email">
              <input id="forgot_input" name="email_reset" title="Vui lòng nhập giá trị" type="text" class="form-control" placeholder="Nhập Email">
              @error('email_reset')
              <div class="errors_input text-danger">
                {{__($message)}}
              </div>
              @enderror

              @if (session()->has('status'))
              <div class="errors_input text-success">
                {{__(session()->get('status'))}}
              </div>
              @endif
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn login-btn w-100" id="continue-forgot-password">Gửi mật khẩu cho tôi</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@section('script')
    @parent
    @if ($errors->has('email_reset') || session()->has('status'))
        <script>
        $(document).ready(function(){
        $('#forgot-password').modal('toggle');
        });
        </script>
    @endif
@endsection
