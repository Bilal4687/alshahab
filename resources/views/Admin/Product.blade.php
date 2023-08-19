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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Product</div>
                        </div>
                        <div class="col-auto">
                            <a href="{{route('ProductForm')}}" class="btn btn-primary" target="_blank" id="AddBtn">Add</a>
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
                            <th>Product Thumbnail</th>
                            <th>Product Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
         {{--    <div class="card shadow mb-4">
                <div class="card-body collapse elevation-4 " id="ProductEditPanel" style="    bottom: 0;
                padding: 0;
                float: none;
                right: 0;
                position: fixed;
                overflow-y: hidden;
                z-index: 1038;
                transition: margin-left .3s ease-in-out,width .3s ease-in-out;
                width: 350px;
                top: 0;
                    }">
                    <!-- Add your content for the right side panel here -->
                    <!-- For example, a form for editing product details -->
                    <div class="card" style=" height: 100vh;">
                        <div class="card-header">Add Product Information <button type="button" onclick=" $('#ProductEditPanel').collapse('hide');" class="close" >
                            <span aria-hidden="true">×</span>
                            </button></div>
                        <div class="card-body">
                            <label for="">Categories</label>
                            <div class="row">
                                <div class="col-10">

                                    <select name="categories" class="form-control" id="">
                                        <option value="Brand1">Brand 1</option>
                                        <option value="Brand2">Brand 2</option>
                                        <option value="Brand3">Brand 3</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-primary"> +</button>
                                </div>
                                <div class="col-12 mt-2">

                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>Category</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Brand 1</th>
                                                <th><button class="btn btn-danger"><i class="fa fa-trash"></i></button></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <label for="">Attributes</label>
                            <div class="row">
                                <div class="col-10">

                                    <select name="categories" class="form-control" id="">
                                        <option value="Attribute1">Attribute 1</option>
                                        <option value="Attribute2">Attribute 2</option>
                                        <option value="Attribute3">Attribute 3</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-primary"> +</button>
                                </div>
                                <div class="col-12 mt-2">

                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>Attribute</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Attribute 1</th>
                                                <th><button class="btn btn-danger"><i class="fa fa-trash"></i></button></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

</div>


<script>

$(function() {
    GetDataTable("#DataTable", "{{ route('ProductShow') }}",
    [{
        data: 'product_id'
    }, {
        data: 'product_thumbnail', render: (img)=>{
            return `<center><img class ="datable-img" src="{{url('public/Files/Products')}}/${img}"  onerror="this.onerror=null;this.src='{{ url('public/errorimage.png') }}';"></center>`;
        }
    }, {
        data: 'product_name'
    }, {
        data: 'product_id',
        render: (id) => {
            return `<a class="btn btn-primary mx-1" href = "{{ url('Admin/ProductData') }}/${id}"><i class="fa fa-edit"></i></a><button class="btn btn-danger mx-1" onclick="ProductRemove('${id}')"><i class="fa fa-trash"></i></button>`;
        }
    }], )
});

    function ProductStore() {
        $("#btnSubmit").prop("disabled", true);
        $.post("{{ route('ProductStore') }}", $('#ProductStoreForm').serialize())
            .done((res) => {
                if (res.success) {
                    alertmsg(res.message, "success");
                    DataTable.ajax.reload();
                    $("#ProductStoreModal").modal('hide');
                    $('#ProductStoreForm')[0].reset();
                } else if (res.validate) {
                    alertmsg(res.message, "warning")
                } else {
                    alertmsg(res.message, "danger")
                }
            });
            $("#btnSubmit").prop("disabled", false);

    }
function ProductEdit(id){
    return false
    $('#ProductStoreForm')[0].reset();
    $('#ProductStoreModal').modal('show');
    $.get("{{ route('ProductEdit') }}",{
        product_id: id
        }, (data)=>{
            filledit(data.data[0])
        });
}

function ProductRemove(id) {
    confirmdlt(() => {
        $.get("{{ route('ProductRemove') }}", {product_id: id},
            (res) => {
                swal({title: "Successful...", text: res.message, icon: "success"})
                DataTable.ajax.reload();
            });
    })
}
</script>
@endsection
