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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Variations</div>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#variation_modal" id="AddBtn">Add</button>
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
                                <th>Variation Name</th>
                                <th>Variation Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="variation_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Variation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="variation_form">
                        @csrf
                        <input type="text" style="display: none" id="variation_id" name="variation_id">
                        <div class="form-group">
                            <label>Variation Name</label>
                            <input type="text" class="form-control form-control-user required " name="variation_name"
                                id="variation_name" placeholder="Enter Variation Name">
                        </div>
                        <div class="form-group mb-3">
                            <label>Variation Note</label>
                            <textarea type="text" class="form-control" required name="variation_description" id="variation_description"
                                rows="10"></textarea>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <span id="error" style="display: none;" class="m-auto"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" onclick="VariationStore()" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>

$(function() {
        GetDataTable("#DataTable", "{{ route('VariationShow') }}",
        [{
            data: 'variation_id'
        }, {
            data: 'variation_name'
        }, {
            data: 'variation_description'
        }, {
            data: 'variation_id',
            render: (id) => {
                return `<button class="btn btn-primary mx-1" onclick="VariationEdit('${id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="VariationRemove('${id}')"><i class="fa fa-trash"></i></button>`;
            }
        }], )
        $('#variation_description').summernote({
                tabDisable: true,
                height: 200,
            });
        imagepreview('#brand_image_input', '#image_preview')
    });
         function VariationStore() {


        $("#btnSubmit").prop("disabled", true);
            var formData = new FormData($('#variation_form')[0]);
            $.ajax({
                url: "{{ 'VariationStore' }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: (res) => {
                    if (res.success) {
                        $('#variation_form')[0].reset();
                        $('#variation_modal').modal('hide');
                        $("#product_variation_description").summernote('code', "")
                        swal("Success!", res.message, "success");
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
    function VariationEdit(id){
        $('#variation_form')[0].reset();
        $('#variation_modal').modal('show');
        $.get("{{ route('VariationEdit') }}",{
            variation_id: id
            }, (data)=>{
                $('#product_variation_name').val(data.data[0]['product_variation_name']);
                $('#product_variation_description').summernote('code', data.data[0]['product_variation_description']);
            });
    }

    function VariationRemove(id) {
        confirmdlt(() => {
            $.get("{{ route('VariationRemove') }}", {variation_id: id},
                (res) => {
                    swal({title: "Successful...", text: res.message, icon: "success"})
                    DataTable.ajax.reload();
                });
        })
    }
    </script>
@endsection
