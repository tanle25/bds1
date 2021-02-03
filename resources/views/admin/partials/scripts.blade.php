<!-- jQuery -->
<script src="{{asset('template/AdminLTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('template/AdminLTE/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('template/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('template/AdminLTE/plugins/chart.js/Chart.min.js')}}"></script>

<script src="{{asset('template/AdminLTE/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('template/AdminLTE/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('template/AdminLTE/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script
    src="{{asset('template/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('template/AdminLTE/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('template/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('template/AdminLTE/dist/js/adminlte.js')}}"></script>

<script src="{{asset('template\AdminLTE\plugins\sweetalert2\sweetalert2.all.min.js')}}"></script>
<!-- Select 2 -->
<script src="{{asset('template\AdminLTE\plugins\select2\js\select2.full.min.js')}}"></script>
<!-- Bootstrap Switch -->
<script src="{{asset('template/AdminLTE/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}} "></script>

@include('admin.partials.alert')
<!-- Page script -->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.custom-file-input').on('change',function(){
        var fileName = $(this).val();
        $(this).next('.custom-file-label').html(fileName);
    })

    // laravel filemanager image
    var lfm = function (id, type, options) {
        let button = document.getElementById(id);
        var parent_element = $('#' + id).closest('.file-btn-wraper');
        var input = parent_element.children('.stand-alone-input');
        var img_holder = parent_element.children('.image-holder');
        button.addEventListener('click', function () {
            var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
            var target_preview = img_holder.get(0);

            window.open(route_prefix + '?type=' + type || 'file', 'FileManager', 'width=900,height=600');
            window.SetUrl = function (items) {

                var file_path = items.map(function (item) {
                    var url = item.url.replace("{{config('app.url')}}", '');
                    return url;
                }).join(',');

                // Change imput value
                var newVal = input.val() + file_path + ',';
                newVal = newVal.replace(/^,+/g, '').replace(/,+/g, ',');
                console.log(newVal);
                input.val(newVal);

                var thumb_path = items.map(function (item) {
                    var thumb_url = item.thumb_url.replace("{{config('app.url')}}", '');
                    var url = item.url.replace("{{config('app.url')}}", '');
                    return {
                        thumb_url: thumb_url,
                        url: url,
                    };
                });
                // set the value of the desired input to image url
                // target_input.value = file_path;
                // target_input.dispatchEvent(new Event('change'));
                // clear previous preview
                target_preview.innerHtml = '';
                // set or change the preview image src
                thumb_path.forEach(function (item) {
                    var image = `<div class="d-inline-block image-wraper text-center p-2 mr-1 mb--2" style="border: 1px dashed gray;">
                                <div class="img" style="object-fit: contain; height:8rem; width:8rem">
                                    <img style="width: 100%" src="${item.thumb_url}">
                                </div>
                                <button style="cursor-pointer" type="button" class="stand-alone-image-delete p-1 d-block btn btn-link text-red mx-auto" data-image="${item.url}">Xóa hình ảnh</button>
                            </div>`
                    img_holder.append(image)
                });
                // trigger change event
                target_preview.dispatchEvent(new Event('change'));
                input.trigger('change');
            };
        });

        $(document).on('click', '.stand-alone-image-delete', function () {
            var wraper = $(this).closest('.image-wraper');
            var current_input = $(this).closest('.file-btn-wraper').children('.stand-alone-input');
            var newVal = current_input.val().replace($(this).data('image') + ',', '').replace($(this).data('image'), '');
            newVal = newVal.replace(/^,+/g, '').replace(/,+/g, ',');
            current_input.val(newVal);
            current_input.trigger('change');
            wraper.remove();
        });
    };
    // file input
    var fileInput = function (id, type, options) {
        let button = document.getElementById(id);
        var parent_element = $('#' + id).closest('.file-btn-wraper');
        var input = parent_element.children('.stand-alone-input');
        var img_holder = parent_element.children('.image-holder');
        button.addEventListener('click', function () {
            var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
            var target_preview = img_holder.get(0);

            window.open(route_prefix + '?type=' + type || 'file', 'FileManager', 'width=900,height=600');
            window.SetUrl = function (items) {

                var file_path = items.map(function (item) {
                    var url = item.url.replace("{{config('app.url')}}", '');
                    return url;
                }).join(',');

                // Change imput value
                input.val(file_path);

                // trigger change event
                input.trigger('change');
            };
        });

        $(document).on('click', '.stand-alone-image-delete', function () {
            var wraper = $(this).closest('.image-wraper');
            var current_input = $(this).closest('.file-btn-wraper').children('.stand-alone-input');
            var newVal = current_input.val().replace($(this).data('image') + ',', '').replace($(this).data('image'), '');
            current_input.val(newVal);
            current_input.trigger('change');
            wraper.remove();
        });
    };
    // ckeditor config

    @php
        $font_list = '';
        for ($i = 8; $i <= 72; $i++) {
            $font_list .= "{$i}/{$i}px;";
        }
    @endphp

    var ckeditor_options = {
        filebrowserImageBrowseUrl: '/admin/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/admin/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/admin/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/admin/laravel-filemanager/upload?type=Files&_token=',
        extraPlugins: 'lineheight',

        height: "500px",
        allowedContent: true,
        fontSize_sizes:  "{{$font_list}}",


    };

    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })

    function swalToast(message, type = 'success', position = 'top-end') {
        Swal.mixin({
            toast: true,
            position: position,
            showConfirmButton: false,
            timer: 3000
        }).fire({
            type: type,
            icon: type,
            title: message,
        })
    }

    function swalConfirm(message = 'Xóa bản ghi này', action = "Vẫn xóa"){
        return Swal.fire({
            title: message,
            text: "Bạn không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: action,
        })
    }

    function auto_grow(element) {
        element.style.height = "5px";
        element.style.height = (element.scrollHeight) + "px";
    }

    $('[data-toggle-for="tooltip"]').tooltip({
            placement: 'auto',
        });

    $('.table').on('draw.dt', function () {
        $('[data-toggle-for="tooltip"]').tooltip({
            placement: 'auto',
        });
    });

    function checkCurrentLocaionMenu() {
        var currentUrl = window.location.href;
        $('.sidebar .nav-link').each(function () {
            if (currentUrl.indexOf($(this).attr('href')) !== -1) {
                $(this).closest('.nav-item.has-treeview').addClass('menu-open');
            }
        })
    }

    checkCurrentLocaionMenu();

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    function getSlug(type, string, output){
        $.post({
            url: "{{route('admin.slug.create')}}",
            data: {
                type: type,
                string: string,
            },
            success(data){
                output.val(data);
            }
        })
    }

    $('.date-picker').each(function(){
        $(this).daterangepicker({
            singleDatePicker: true,
            timePicker24Hour: true,
            locale: {
                "format": 'DD/MM/YYYY',
                "applyLabel": "Ok",
                "cancelLabel": "Thoát",
                "fromLabel": "Từ",
                "toLabel": "Đến",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "CN",
                    "T2",
                    "T3",
                    "T4",
                    "T5",
                    "T6",
                    "T7"
                ],
                "monthNames": [
                    "Tháng 1",
                    "Tháng 2",
                    "Tháng 3",
                    "Tháng 4",
                    "Tháng 5",
                    "Tháng 6",
                    "Tháng 7",
                    "Tháng 8",
                    "Tháng 9",
                    "Tháng 10",
                    "Tháng 11",
                    "Tháng 12"
                ],
            },
        })
    })

    $('.date-range-picker').each(function(){
        $(this).daterangepicker({
            timePicker24Hour: true,
            locale: {
                "format": 'DD/MM/YYYY',
                "applyLabel": "Ok",
                "cancelLabel": "Thoát",
                "fromLabel": "Từ",
                "toLabel": "Đến",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "CN",
                    "T2",
                    "T3",
                    "T4",
                    "T5",
                    "T6",
                    "T7"
                ],
                "monthNames": [
                    "Tháng 1",
                    "Tháng 2",
                    "Tháng 3",
                    "Tháng 4",
                    "Tháng 5",
                    "Tháng 6",
                    "Tháng 7",
                    "Tháng 8",
                    "Tháng 9",
                    "Tháng 10",
                    "Tháng 11",
                    "Tháng 12"
                ],
            },
        })
    })

    function shortText(string, max){
        var arr = string.split(' ');
        output = string;
        for (let i = 0; i < arr.length; i++) {
            if (output.length > max) {
                arr[i] = arr[i].slice(0, 1);
                output.join(' ');
            }else{
                return output;
            }
        }
    }
</script>
@yield('script')
