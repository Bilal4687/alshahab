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
                    {{-- <div class="form-group">
                        <label>Parent Category</label>
                        <select name="parent_id" id="parent_id" class="form-control form-control-user">
                            <option selected disabled>Select Category</option>
                            @foreach ($data as $item)
                            <option value="{{ $item->category_id}}">{{ $item->category_name}}</option>
                            @endforeach
                        </select>
                    </div> --}}
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
// Declare dataTable in a higher scope
let dataTable;

$(document).ready(function() {
    // Initialize an empty DataTable
    dataTable = $("#DataTable").DataTable({
        columns: [
            {
                data: 'category_name'
            },
            {
                data: 'category_id',
                render: (id, type, row) => {
                    return `
                        <button class="btn btn-primary mx-1" onclick="FetchSubCategory('${id}')">
                            Sub Category
                        </button>
                    `;
                }
            }
        ]
    });

    // Fetch initial data
    fetchAndLoadData();
});

function fetchAndLoadData() {
    $.ajax({
        type: "GET",
        url: "{{ route('CategoryShow') }}",
        dataType: "json",
        success: function(data) {
            // Update DataTable with the fetched data
            dataTable.clear().rows.add(data).draw();
        },
        error: function(error) {
            console.log('Error fetching data: ', error);
        }
    });
}

function FetchSubCategory(categoryId) {
    const url = `{{ route('Category') }}/${categoryId}`;


    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            // Update DataTable with the fetched subcategories
            dataTable.clear().rows.add(data).draw();

            // Change the browser URL
            window.history.pushState({categoryId: categoryId}, null, `/alshahab/Admin/Category/${categoryId}`);
        },
        error: function (error) {
            console.log('Error fetching categories and subcategories: ', error);
        }
    });
}

</script>
@endsection
