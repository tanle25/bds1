<div class="home-contact">
    <div class="row no-gutters">
        <div class="col-md-8">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3754.724904678656!2d105.7967239153196!3d19.766839135028896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313657c90990e667%3A0xffa377ff1994b0c5!2zQ8O0bmcgVHkgSMOgbSBS4buTbmcgTWVkaWEgLSBUaGnhur90IGvhur8gd2Vic2l0ZSBUaGFuaCBIw7Nh!5e0!3m2!1svi!2s!4v1609204667861!5m2!1svi!2s" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
        <div class="col-md-4">
            <form action="/online-class-request/store" method="POST" class="bg-secondary px-5 pt-5 pb-3">
                @csrf
                <div class="form-group">
                  <input type="text" name="contact_name" id="" class="form-control py-2 px-3 font-14 letter-spacing-1" placeholder="Họ và tên">
                    @error('contact_name')
                        <small class="text-danger"> {{$message}} </small>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="text" name="contact_email" id="" class="form-control py-2 px-3 font-14 letter-spacing-1" placeholder="Email">
                    @error('contact_email')
                        <small class="text-danger"> {{$message}} </small>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="text" name="contact_phone" id="" class="form-control py-2 px-3 font-14 letter-spacing-1" placeholder="Số điện thoại">
                    @error('contact_phone')
                        <small class="text-danger"> {{$message}} </small>
                    @enderror
                </div>
                <div class="form-group">
                    <textarea name="contact_message" id="" class="form-control  py-2 px-3 font-14 letter-spacing-1" cols="30" rows="3" placeholder="Nội dung"></textarea>
                    @error('contact_message')
                        <small class="text-danger"> {{$message}} </small>
                    @enderror
                </div>

                <button type="submit" class="font-14 letter-spacing-1 font-weight-400 btn btn-primary my-4 w-100 rounded-0 p-3">Gửi lời nhắn</button>
            </form>
        </div>
    </div>
</div>
