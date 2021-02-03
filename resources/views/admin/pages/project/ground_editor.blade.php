@isset($project)
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-ground-create" data-toggle="modal" data-target="#groundModel">
        Thêm mặt bằng mới
    </button>

    <table class="table table-ground table-bordered mt-5">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Tên mặt bằng</th>
            <th scope="col">Ảnh</th>
            <th scope="col">Thao tác</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($project->grounds as $item)
            <tr>
                <td scope="col">#</td>
                <td scope="col">{{$item->name}}</td>
                <td scope="col">
                    @foreach ($item->thumbs as $thumb)
                    <img src="{{$thumb}}" alt="" style="width: 60px; height: 60px">
                    @endforeach
                </td>
                <td scope="col">
                    <a data-toggle-for="tooltip" title="Sửa thông tin" data-ground-id="{{$item->id}}" class="btn text-info ground-edit"><i class="fas fa-edit"></i></a>

                    <a data-toggle-for="tooltip" title="Xóa" data-ground-id="{{$item->id}}" class="btn text-danger ground-destroy"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>

    <!-- Modal -->


    @section('script')
    @parent
    <div class="modal fade" id="groundModel" tabindex="-1" role="dialog" aria-labelledby="groundModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="groundModelLabel">Thêm mặt bằng mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/ground/store" method="post">
                    <div class="col-md-12 form-group">
                        <label for="">Tên mặt bằng</label>
                        <input
                        id="ground_name"
                        type="text"
                        class="form-control "
                        name="ground_name"
                        placeholder="Tên mặt bằng"
                        >
                    </div>

                    <div class="form-group ">
                        <label class="control-label">Ảnh slider chính</label>
                        <div class="input-group file-btn-wraper">
                            <input type="hidden" name="ground_images" value="" class="form-field stand-alone-input">
                            <div class="image-holder">
                            {{--image holder--}}
                            </div>
                            <span class="input-group-btn">
                                <a id="ground_images"
                                data-input="thumbnail"
                                data-preview="holder"
                                class="d-block"
                                style=" border: 1px dashed gray;">
                                    <img style="height:8rem; width:8rem; cursor: pointer;" src="{{asset('/images/placeholder.png')}}">
                                    <button type="button" class="p-1 d-block btn btn-link text-red mx-auto">Thêm mới</button>
                                </a>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary " data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary btn-store-ground">Lưu</button>
                <button type="button" data-ground-id="" class="btn btn-primary btn-update-ground">Cập nhật</button>

            </div>
            </div>
        </div>
    </div>
    <script>
        lfm("ground_images", 'image', { prefix: '/admin/laravel-filemanager' });

        $(document).on('click', '.btn-ground-create', function (){
            $('.btn-update-ground').hide();
            $('.btn-store-ground').show();
        })

        $(document).on('click', '.ground-edit', function (){
            $('.btn-update-ground').show();
            $('.btn-store-ground').hide();
        })

        function storeNewGround(data){
            return $.ajax({
                url: '{{route("admin.ground.store")}}',
                type: 'POST',
                data: data
            })
        }

        function clearGroundForm(){
            $('#ground_name').val('');
            $('[name=ground_images]').val('');
            $('#groundModel .image-holder').html('');
        }

        $(document).on('click', '.btn-store-ground', function(e){
            var projectId = {{$project->id}};
            data = {
                name: $('#ground_name').val(),
                images: $('[name=ground_images]').val(),
                project_id: projectId,
            }
            storeNewGround(data)
            .done(function(data){
                swalToast(data.msg);
                clearGroundForm();
                getGrounds()
                .done(function(list){
                    renderGroundtable(list);
                });
            })
            .fail(function(errors){
                swalToast(errors.msg, 'error');
            });
        })

        function renderImage(data){
            $('[name=ground_images]').val(data.images);

            var thumbs = data.thumbs;

            thumbs.forEach(function (item) {
                var image = `<div class="d-inline-block image-wraper text-center p-2 mr-1 mb--2" style="border: 1px dashed gray;">
                            <div class="img" style="object-fit: contain; height:8rem; width:8rem">
                                <img style="width: 100%" src="${item}">
                            </div>
                            <button style="cursor-pointer" type="button" class="stand-alone-image-delete p-1 d-block btn btn-link text-red mx-auto" data-image="${item.replace('/thumbs', '')}">Xóa hình ảnh</button>
                        </div>`
                    $('#groundModel .image-holder').append(image)
            });
        }

        function getGround(groundId){
            return $.ajax({
                url: '/admin/ground/edit/' + groundId,
                type: 'get',
            })
        }

        $(document).on('click', '.ground-edit', function(e){
            e.preventDefault();
            var groundId = $(this).data('ground-id');
            $('.btn-update-ground').data('ground-id', groundId);
            clearGroundForm();
            getGround(groundId)
            .done(function(data){
                $('#groundModel').modal('show');
                $('#ground_name').val(data.name);
                renderImage(data);

            })
            .fail(function(errors){
                swalToast(errors.msg, 'error');
            });
        })


        $('#groundModel').on('hidden.bs.modal', function (e) {
            clearGroundForm();
        })

        function updateGround(groundId, data) {
            return $.ajax({
                url: '/admin/ground/edit/' + groundId,
                type: 'post',
                data: data
            })
        }

        $(document).on('click', '.btn-update-ground', function(){
            groundId = $(this).data('ground-id');
            console.log($('[name=ground_images]').val());
            data = {
                name: $('#ground_name').val(),
                images: $('[name=ground_images]').val(),
            };
            updateGround(groundId, data)
            .done(function(data){
                swalToast(data.msg);
                getGrounds()
                .done(function(list){
                    renderGroundtable(list);
                });
            })
        })

        function destroyGround(groundId){
            return $.ajax({
                url: '/admin/ground/destroy/' + groundId,
                type: 'post',
            })
        }

        function getGrounds(){
            return $.ajax({
                url: "{{route('admin.ground.index', $project->id)}}",
                type: 'get',
            })
        }

        function renderGroundtable(data){
            var listItems = '';
            data.forEach(item => {
                var thumbImg = '';
                item.thumbs.forEach(thumb => {
                    thumbImg += `<img src="${thumb}" alt="" style="width: 60px; height: 60px">`
                })
                listItems += `
                <tr>
                    <td scope="col">#</td>
                    <td scope="col">${item.name}</td>
                    <td scope="col">
                        ${thumbImg}
                    </td>
                    <td scope="col">
                        <a data-toggle-for="tooltip" title="Sửa thông tin" data-ground-id="${item.id}" class="btn text-info ground-edit"><i class="fas fa-edit"></i></a>
                        <a data-toggle-for="tooltip" title="Xóa" data-ground-id="${item.id}" class="btn text-danger ground-destroy"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                `
            });

            $('.table-ground tbody').html(listItems);
        }

        $(document).on('click', '.ground-destroy', function(){
            var groundId = $(this).data('ground-id');

            swalConfirm('Xóa mặt bằng này!').then((result) => {
                if (result.value) {
                    destroyGround(groundId)
                    .done(function(data){
                        swalToast(data.msg);

                        getGrounds()
                        .done(function(list){
                            console.log(list);
                            renderGroundtable(list);
                        });

                    })
                    .fail(function(error){

                    });
                }
            });

        })

    </script>
    @endsection

@endisset

