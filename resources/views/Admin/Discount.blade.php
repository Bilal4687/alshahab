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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Discount</div>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#DiscountStoreModal" id="AddBtn">Add</button>
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
                                <th>Discount Coupon</th>
                                <th>Discount Type</th>
                                <th>Discount Value</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="DiscountStoreModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Discount</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="DiscountStoreForm">
                        @csrf
                        <input type="text" style="display: none" id="discount_id" name="discount_id">
                        <div class="form-group">
                            <label>Discount Coupon</label>
                            <input type="text" class="form-control form-control-user required " name="discount_coupon"
                                id="discount_coupon" placeholder="Enter Discount Coupon">
                        </div>
                        <div class="form-group">
                            <label>Discount Type</label>
                            <input type="text" class="form-control form-control-user required " name="discount_type"
                                id="discount_type" placeholder="Enter Discount Type">
                        </div>
                        <div class="form-group">
                            <label>Discount Value</label>
                            <input type="number" class="form-control form-control-user required " name="discount_value"
                                id="discount_type" placeholder="Enter Discount Value">
                        </div>
                        <div class="form-group">
                            <label>Discount Threshold</label>
                            <input type="number" class="form-control form-control-user required " name="discount_threshold"
                                id="discount_type" placeholder="Enter Discount Threshold">
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <span id="error" style="display: none;" class="m-auto"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" onclick="DiscountStore()" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>

$(function() {
        GetDataTable("#DataTable", "{{ route('DiscountShow') }}",
        [{
            data: 'discount_id'
        }, {
            data: 'discount_coupon'
        }, {
            data: 'discount_type'
        }, {
            data: 'discount_value'
        }, {
            data: 'discount_id',
            render: (id) => {
                return `<button class="btn btn-primary mx-1" onclick="DiscountEdit('${id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="DiscountRemove('${id}')"><i class="fa fa-trash"></i></button>`;
            }
        }], )
    });

         function DiscountStore() {
        $("#btnSubmit").prop("disabled", true);
        $.post("{{ route('DiscountStore') }}", $('#DiscountStoreForm').serialize())
            .done((res) => {
                if (res.success) {
                    alertmsg(res.message, "success");
                    DataTable.ajax.reload();
                    $("#DiscountStoreModal").modal('hide');
                    $('#DiscountStoreForm')[0].reset();
                } else if (res.validate) {
                    alertmsg(res.message, "warning")
                } else {
                    alertmsg(res.message, "danger")
                }
            });
            $("#btnSubmit").prop("disabled", false);

    }
    function DiscountEdit(id){
        $('#DiscountStoreForm')[0].reset();
        $('#DiscountStoreModal').modal('show');
        $.get("{{ route('DiscountEdit') }}",{
            discount_id: id
            }, (data)=>{
                filledit(data.data[0])
            });
    }

    function DiscountRemove(id) {
        confirmdlt(() => {
            $.get("{{ route('DiscountRemove') }}", {discount_id: id},
                (res) => {
                    swal({title: "Successful...", text: res.message, icon: "success"})
                    DataTable.ajax.reload();
                });
        })
    }
    </script>
@endsection
