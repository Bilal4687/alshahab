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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Attribute</div>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#AttributeStoreModal" id="AddBtn">Add</button>
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
                                <th>Attribute Name</th>
                                <th>Attribute Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="AttributeStoreModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Attribute</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="AttributeStoreForm">
                        @csrf
                        <input type="text" style="display: none" id="attribute_id" name="attribute_id">
                        <div class="form-group">
                            <label>Attribute Name</label>
                            <input type="text" class="form-control form-control-user required " name="attribute_name"
                                id="attribute_name" placeholder="Enter Attribute Name">
                        </div>
                        <div class="form-group">
                            <label>Attribute Type</label>
                            <input type="text" class="form-control form-control-user required " name="attribute_type"
                                id="attribute_type" placeholder="Enter Attribute Type">
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <span id="error" style="display: none;" class="m-auto"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" onclick="AttributeStore()" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>

$(function() {
        GetDataTable("#DataTable", "{{ route('AttributeShow') }}",
        [{
            data: 'attribute_id'
        }, {
            data: 'attribute_name'
        }, {
            data: 'attribute_type'
        }, {
            data: 'attribute_id',
            render: (id) => {
                return `<button class="btn btn-primary mx-1" onclick="AttributeEdit('${id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="AttributeRemove('${id}')"><i class="fa fa-trash"></i></button>`;
            }
        }], )
    });

         function AttributeStore() {
        $("#btnSubmit").prop("disabled", true);
        $.post("{{ route('AttributeStore') }}", $('#AttributeStoreForm').serialize())
            .done((res) => {
                if (res.success) {
                    alertmsg(res.message, "success");
                    DataTable.ajax.reload();
                    $("#AttributeStoreModal").modal('hide');
                    $('#AttributeStoreForm')[0].reset();
                } else if (res.validate) {
                    alertmsg(res.message, "warning")
                } else {
                    alertmsg(res.message, "danger")
                }
            });
            $("#btnSubmit").prop("disabled", false);

    }
    function AttributeEdit(id){
        $('#AttributeStoreForm')[0].reset();
        $('#AttributeStoreModal').modal('show');
        $.get("{{ route('AttributeEdit') }}",{
            attribute_id: id
            }, (data)=>{
                filledit(data.data[0])
            });
    }

    function AttributeRemove(id) {
        confirmdlt(() => {
            $.get("{{ route('AttributeRemove') }}", {attribute_id: id},
                (res) => {
                    swal({title: "Successful...", text: res.message, icon: "success"})
                    DataTable.ajax.reload();
                });
        })
    }
    </script>
@endsection
