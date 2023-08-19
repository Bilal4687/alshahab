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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Category</div>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#CategoryStoreModal" id="AddBtn">Add</button>
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
                                <th>Category Id</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="CategoryStoreModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="CategoryStoreForm">
                        @csrf
                        <input type="text" style="display: none" id="category_id" name="category_id">
                        <div class="form-group">
                            <label>Parent Category</label>
                            <select name="parent_id" id="parent_id" class="form-control form-control-user">
                                <option selected disabled>Select Category</option>
                            @foreach ($data as $item)
                            <option value="{{ $item->category_id}}">{{ $item->category_name}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" class="form-control form-control-user required " name="category_name"
                                id="category_name" placeholder="Enter Category">
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <span id="error" style="display: none;" class="m-auto"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" onclick="CategoryStore()" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(function() {
            GetDataTable("#DataTable", "{{ route('CategoryShow') }}",
            [{
                data: 'category_id'
            }, {
                data: 'category_name'
            }, {
                data: 'category_id',
                render: (id) => {
                    return `<button class="btn btn-primary mx-1" onclick="CategoryEdit('${id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="CategoryRemove('${id}')"><i class="fa fa-trash"></i></button>`;
                }
            }], )
        });


        function CategoryStore() {
            $("#btnSubmit").prop("disabled", true);
            $.post("{{ route('CategoryStore') }}", $('#CategoryStoreForm').serialize())
                .done((res) => {
                    if (res.success) {
                        alertmsg(res.message, "success");
                        DataTable.ajax.reload();
                        $('#CategoryStoreForm')[0].reset();
                        $("#CategoryStoreModal").modal('hide');
                    } else if (res.validate) {
                        alertmsg(res.message, "warning")
                    } else {
                        alertmsg(res.message, "danger")
                    }
                });
                $("#btnSubmit").prop("disabled", false);

        }

        function CategoryEdit(category_id) {
            $('#CategoryStoreForm')[0].reset();
            $('#CategoryStoreModal').modal('show');
            $.get("{{ route('CategoryEdit') }}", {
                category_id: category_id
            }, (data)=>{
                filledit(data.data[0])
            });
        }

        function CategoryRemove(category_id) {
            confirmdlt(() => {
                $.get("{{ route('CategoryRemove') }}", {category_id: category_id},
                    (res) => {
                        swal({title: "Successful...", text: res.message, icon: "success"})
                        DataTable.ajax.reload();
                    });
            })
        }


        $('#CategoryStoreModal').on('hidden.bs.modal', function () {
            $('#CategoryStoreForm')[0].reset();
        });
    </script>
@endsection
