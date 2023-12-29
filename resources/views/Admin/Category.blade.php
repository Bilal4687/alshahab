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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <a href="{{ route('Category') }}" style="color: black">Category</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#CategoryStoreModal" id="AddBtn" onclick="ClearFormFields()">Add</button>
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
                    @if(isset($subData))
                        <div class="form-group">
                            <label>Parent Category</label>
                            <select name="parent_id" id="parent_id" class="form-control form-control-user" disabled>
                                 <option value="{{ $SelectedCategory[0]->category_name }}" selected>{{ $SelectedCategory[0]->category_name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" class="form-control form-control-user required " name="category_name"
                                id="category_name" placeholder="Enter Category">
                        </div>
                    @else

                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="form-control form-control-user required " name="category_name" id="category_name" placeholder="Enter Category">
                    </div>
                    @endif

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

function ClearFormFields(){
    $("#CategoryStoreForm")[0].reset();
}

$(document).ready(function() {

    initializeDataTable();

    const currentCategoryId = getCategoryFromUrl();
    console.log('currentCategoryId', currentCategoryId);
    if (currentCategoryId) {
        fetchAndLoadData(currentCategoryId);
    } else {
        fetchAndLoadData();
    }
});

function initializeDataTable() {
    dataTable = $("#DataTable").DataTable({
        columns: [
            {
                data: 'category_name'
            },
            {
                data: 'category_id',
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-primary mx-1" onclick="FetchSubCategory('${data}')">
                            Sub Category
                        </button>
                    `;
                }
            }
        ]
    });
}

function getCategoryFromUrl() {

    const urlParts = window.location.href.split('/');

    const categoryIdIndex = urlParts.indexOf('Category') + 1;

    if (categoryIdIndex < urlParts.length) {
        return urlParts[categoryIdIndex];
    }

    return null;
}

function fetchAndLoadData(categoryId = null) {

    const url = categoryId ? `{{ route('CategoryShow') }}/${categoryId}` : "{{ route('CategoryShow') }}";

    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        success: function(data) {
            if (dataTable) {
                dataTable.destroy();
            }

            initializeDataTable();
            dataTable.clear().rows.add(data).draw();

        },
        error: function(error) {
            console.log('Error fetching data: ', error);
        }
    });
}

function FetchSubCategory(categoryId) {

    fetchAndLoadData(categoryId);
    window.history.pushState({categoryId: categoryId}, null, `/alshahab/Admin/Category/${categoryId}`);
}


function CategoryStore() {
            $("#btnSubmit").prop("disabled", true);
            $.post("{{ route('CategoryStore') }}", $('#CategoryStoreForm').serialize())
                .done((res) => {
                    if (res.success) {
                        alertmsg(res.message, "success");
                        $('#CategoryStoreForm')[0].reset();
                        DataTable.ajax.reload();
                        $("#CategoryStoreModal").modal('hide');
                        location.reload();
                    } else if (res.validate) {
                        alertmsg(res.message, "warning")
                    } else {
                        alertmsg(res.message, "danger")
                    }
                })
                    $("#btnSubmit").prop("disabled", false); // Enable the button regardless of success or failure

        }


</script>
@endsection
