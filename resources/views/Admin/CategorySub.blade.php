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
                                <th>Sub Category Name</th>
                                <th>Category Name</th>
                                <th>Date</th>
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
                        <input type="text" style="display: none" id="categories_sub_id" name="categories_sub_id">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" class="form-control form-control-user required " name="categories_sub_name"
                                id="categories_sub_name" placeholder="Enter Category">
                        </div>
                          <div class="form-group">
                            <label>Select Category</label>
                            <select name="category_id" id="category_id" class="form-control form-control-user">
                                <option selected disabled>Select Category</option>
                            @foreach ($categories as $item)
                            <option value="{{ $item->category_id}}">{{ $item->category_name}}</option>
                            @endforeach
                        </select>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <span id="error" style="display: none;" class="m-auto"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" onclick="CategorySubStore()" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function(){
            Getdata()
        });

        function Getdata(){
            var Datatable = $('#DataTable').DataTable({
                dom: '<"top"<"left-col"B><"right-col"f>>r<"table table-striped"t>ip',
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                "responsive": true,
                buttons: [
                    'pageLength'
                ],
                ajax: {
                    url: "{{ route('CategorySubFetch') }}",
                    dataSrc: '',
                },
                columns: [{
                        data: 'categories_sub_id',
                    },
                    {
                        data: 'categories_sub_name',
                    },
                    {
                        data: 'category_name',
                    },
                    {
                        data: 'created_date',
                    },
                    {
                        data: 'categories_sub_id',
                        render: (categories_sub_id) => {
                                return `<button class="btn btn-primary mx-1" data-toggle="modal" data-target="#Blog_modal" onclick="SubCategoryEdit('${categories_sub_id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="SubCategoryRemove('${categories_sub_id}')"><i class="fa fa-trash"></i></button>`;
                            }
                    }

                ]
            })
        }

        function CategorySubStore() {
            $("#btnSubmit").prop("disabled", true);
            $.post("{{route('CategorySubStore')}}", $('#CategoryStoreForm').serialize())
                .done((res) => {
                    if (res.success) {
                         alertmsg(res.message, "success");
                        DataTable.ajax.reload();
                        $('#CategoryStoreForm')[0].reset();
                        $("#CategoryStoreModal").modal('hide');
                    }else if (res.validate) {
                        alertmsg(res.message, "warning")
                    } else {
                        alertmsg(res.message, "danger")
                    }
                });
                $("#btnSubmit").prop("disabled", false);
        }

        function SubCategoryEdit(id){
            $('#CategoryStoreForm')[0].reset();
            $('#CategoryStoreModal').modal('show');
            $.get("{{ route('CategorySubEdit') }}", {
                categories_sub_id: id
            }, (data)=>{
                filledit(data.data[0])
            });
        }

        function SubCategoryRemove(id){
            confirmdlt(() => {
                $.get("{{ route('SubCategoryDelete') }}", {categories_sub_id: id},
                    (res) => {
                        swal({title: "Successful...", text: res.message, icon: "success"})
                        DataTable.ajax.reload();
                    });
            })
        }
    </script>
@endsection
