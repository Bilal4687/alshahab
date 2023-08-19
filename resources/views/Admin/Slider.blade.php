@extends('Admin.AdminLayout')
@section('content')
    <style>
        .left-col {
            display: flex;
        }
    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12 my-2">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Slider</div>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary mt-2" style="float: right"
                                    onclick="$('#slider_modal').modal('show');$('#slider_form')[0].reset();$('#home_slider_description').summernote('code', '')">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="DataTable" class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Slider Id</th>
                                <th>Slider Image</th>
                                <th>Slider Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="slider_modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Slider</h3>
                </div>
                <div class="modal-body">
                    <form id="slider_form">
                        @csrf
                        <input type="text" style="display: none" class="form-control" value="" name="home_slider_id" id="home_slider_id">
                        <div class="form-group mb-3">
                            <label>Title</label>
                            <input type="text" class="form-control" name="home_slider_title" id="home_slider_title">
                        </div>

                        <div class="form-group mb-3">
                            <label>Description</label>
                            <textarea type="text" class="form-control" required name="home_slider_description" id="home_slider_description"
                                rows="10"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Slider Web URL</label>
                            <input type="text" class="form-control" name="home_slider_web_url" id="home_slider_web_url">
                        </div>
                        <div class="form-group mb-3">
                            <label>Slider Mob URL</label>
                            <input type="text" class="form-control" name="home_slider_mob_url" id="home_slider_mob_url">
                        </div>

                        <div class="form-group mb-3">
                            <label>Slider Image</label>
                            <input type="file" accept="image/*" class="form-control" name="slider_image"
                                id="slider_image_input">
                            <div class="mt-3" id="image_preview">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <span id="error" style="display: none; width:100%"></span>
                    <button type="button" id="submitbtn" class="btn btn-lg btn-primary" onclick="SaveSlider()"
                        style="width: 100%">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            GetDataTable("#DataTable", '{{route('SliderShow')}}', [
                {data: 'home_slider_id'},
                {data: 'home_slider_path', render: (img)=>{return `<img class ="datable-img" src="{{url('public/Files/Home-Slider')}}/${img}">`}},
                {data: 'home_slider_title'},
                {data: 'home_slider_id', render: (id) => {return `<button class="btn btn-primary mx-1" onclick="SliderEdit('${id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="SliderDelete('${id}')"><i class="fa fa-trash"></i></button>`;}
            }
            ])
            product_variation_name
        });

        imagepreview('#slider_image_input', '#image_preview');

        function SaveSlider() {
            $("#submitbtn").prop('disabled', true)
            var formData = new FormData($('#slider_form')[0]);
            $.ajax({
                url: "{{ route('SliderStore') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: (res) => {
                    if (res.success) {
                        $('#slider_form')[0].reset();
                        $('#slider_modal').modal('hide');
                        $("#home_slider_description").summernote('code', "")
                        $('#image_preview').css('background-image', `url('')`);
                        swal("Success!", res.message, "success");
                    } else if (res.validate) {
                        alertmsg(res.message, "warning")
                    } else {
                        swal("Error!", res.message, "error");
                    }
                    DataTable.ajax.reload();
                }
            });
            $("#submitbtn").prop('disabled', false)
        }
        function SliderRemove(id) {
            $.get("{{ 'SliderDelete' }}", {
                    id: id
                },
                function(data) {
                    DataTable.ajax.reload()
                }
            );
        }

        function SliderEdit(id) {
            $('#slider_modal').modal('show');

            $.get("{{ route('SliderEdit') }}",{
                slider_id : id
            },function(data){
                $('#home_slider_id').val(data.data[0]['home_slider_id']);
                $('#home_slider_title').val(data.data[0]['home_slider_title']);
                $('#home_slider_web_url').val(data.data[0]['home_slider_web_url']);
                $('#home_slider_mob_url').val(data.data[0]['home_slider_mob_url']);
                $('#home_slider_description').summernote('code', data.data[0]['home_slider_description']);
                $("#image_preview").css("background-image",
                        `url('{{ url("public/Files/Home-Slider") }}/${data.data[0]["home_slider_path"]}`);
            });
        }

        function SliderDelete(slider_id) {
            confirmdlt(() => {
                $.get("{{ route('SliderDelete') }}", {slider_id: slider_id},
                    (res) => {
                        swal({title: "Successful...", text: res.message, icon: "success"})
                        DataTable.ajax.reload();
                    });
            })
        }

        $('#slider_modal').on('hidden.bs.modal', function () {
            $('#slider_form')[0].reset();
            $("#home_slider_description").summernote('code', "");
            $('#image_preview').css('background-image', `url('')`);
        });
    </script>
@endsection
