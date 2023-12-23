@extends('Admin.AdminLayout')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12 my-2">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Brand</div>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#brand_modal" id="AddBtn">Add</button>
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
                                <th>Id</th>
                                <th>Brand Name</th>
                                <th>Brand Image</th>
                                <th>language</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="brand_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Brand</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="brand_form">
                        @csrf
                        <input type="text" style="display: none" id="brand_id" name="brand_id">
                        <div class="form-group">
                            <label>Brand Name</label>
                            <input type="text" class="form-control form-control-user required " name="brand_name"
                                id="brand_name" placeholder="Enter Brand Name">
                        </div>
                        <div class="form-group">
                            <label>Language</label>
                            <input type="text" class="form-control form-control-user required " name="lang"
                                id="lang" placeholder="Enter Language">
                        </div>
                        <div class="form-group mb-3">
                            <label>Brand Image</label>
                            <input type="file" accept="image/*" class="form-control" name="brand_image"
                                id="brand_image">
                            <div class="mt-3" id="image_preview"
                                style="width: 100%; height: 300px; background: rgb(151, 151, 151) center / contain no-repeat;">
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <span id="error" style="display: none;" class="m-auto"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" onclick="BrandStore()" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>

$(document).ready(function() {
            GetDataTable("#DataTable", '{{route('BrandShow')}}', [
                {data: 'brand_id'},
                {data: 'brand_name'},
                {data: 'brand_image', render: (img)=>{return `<img class ="datable-img" src="{{url('public/Files/Brands')}}/${img}">`}},
                {data: 'lang'},
                {data: 'brand_id', render: (id) => {return `<button class="btn btn-primary mx-1" onclick="BrandEdit('${id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="BrandRemove('${id}')"><i class="fa fa-trash"></i></button>`;}
            }
            ])
        });

         function BrandStore() {
            $("#btnSubmit").prop("disabled", true);
            var formData = new FormData($('#brand_form')[0]);
            $.ajax({
                url: "{{ 'BrandStore' }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: (res) => {
                    if (res.success) {
                        $('#brand_form')[0].reset();
                        $('#brand_modal').modal('hide');
                        $("#home_brand_description").summernote('code', "")
                        $('#image_preview').css('background-image', `url('')`);
                        swal("Success!", res.message, "success");
                        location.reload();
                    } else if (res.validate) {
                        alertmsg(res.message, "warning")
                    } else {
                        swal("Error!", res.message, "error");
                    }
                    DataTable.ajax.reload();
                }
            });
            $("#btnSubmit").prop('disabled', false)

    }
    function BrandEdit(id){
        $('#brand_form')[0].reset();
        $('#brand_modal').modal('show');
        $.get("{{ route('BrandEdit') }}",{
            brand_id: id
            }, (data)=>{
                $('#brand_id').val(data.data[0]['brand_id']);
                $('#brand_name').val(data.data[0]['brand_name']);
                $('#lang').val(data.data[0]['lang']);
                $("#image_preview").css("background-image",
                        `url('{{ url("public/Files/Brands") }}/${data.data[0]["brand_image"]}`);s
            });
    }

    function BrandRemove(id) {
        confirmdlt(() => {
            $.get("{{ route('BrandRemove') }}", {brand_id: id},
                (res) => {
                    swal({title: "Successful...", text: res.message, icon: "success"})
                    DataTable.ajax.reload();
                });
        })
    }
    $('#brand_image').on('change', (e) => {
            $('#image_preview').css({'background-image': ``});
            const reader = new FileReader();
            const file = e.target.files[0];
            if (!file.type.match('image.*')) {
                swal("Warning", "Please select an image file.", "warning");
                return $('#brand_image').val('');
            }
            reader.onload = function(e) {
                // $('#image_preview').css({'background-image': ``});

                $('#image_preview').css('background-image', `url(${e.target.result})`);
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection
