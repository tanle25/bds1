 <!-- POpup RE-PASSWORD Phone -->
<div class="modal fade modal-popup"
    data-backdrop="static"
    data-keyboard="false"
    id="popup-re-password-email"
    tabindex="-1"
    role="dialog"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="logo-login text-center mt-3">
                <img height="70px" src="{{Str::replaceLast(',', '', $theme_options['logo'] ?? '')}}" alt="">
            </div>
            <div class="modal-body">
                <p class="p-text text-center">Nhập lại mật khẩu mới và xác nhận để thay đổi</p>
                <form class="form-user-re-pass" id="form-user-re-pass" action="{{ route('customer.password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ old('token') ?? session()->get('reset_token')}}">

                    <div class="form-group">
                        <div class="bl-div div-email">
                          <input type="email" name="reset_email" class="form-control" value="{{old('reset_email')}}" placeholder="Email">
                        </div>
                        <div class="errors_input text-danger">
                            @error('reset_email')
                              {{$message}}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="bl-div div-password"> <input id="user_pass" name="reset_password"
                                type="reset_password" class="form-control" placeholder="Mật khẩu mới" /> <span
                                class="span-eyes"></span> </div>
                        <div class="errors_input text-danger">
                            @error('reset_password')
                                {{$message}}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="bl-div div-password"> <input id="user_repass" name="reset_password_confirmation"
                                type="password" class="form-control"
                                placeholder="Nhập lại mật khẩu mới" /> <span class="span-eyes"></span>
                        </div>
                        <div class="errors_input text-danger">
                            @error('reset_password_confirmation')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group text-center"> <button id="save-user-change-pass" class="btn btn-info">Thay đổi mật khẩu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- end -->

@if(session()->has('reset_token') ||  $errors->has('reset_password') ||  $errors->has('password_reset') || $errors->has('reset_password_confirmation') ||  $errors->has('reset_email') )
    @section('script')
    @parent
        <script>
        $(document).ready(function(){
            $('#popup-re-password-email').modal('toggle');
        });
        </script>
    @endsection
@endif

