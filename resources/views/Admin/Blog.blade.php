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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Blog</div>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#Blog_modal" id="AddBtn">Add</button>
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
                                <th>Title</th>
                                <th>Description</th>
                                <th>Short Description</th>
                                <th>Image</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="Blog_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Blog</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="Blog_Form">
                        @csrf
                        <input type="text" style="display: none" id="blog_id" name="blog_id">
                        <div class="form-group">
                            <label>Blog Title</label>
                            <input type="text" class="form-control form-control-user required " name="blog_title"
                                id="blog_title" placeholder="Enter Category">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control form-control-user required " name="blog_description"
                                id="blog_description" placeholder="Enter Category">
                        </div>
                        <div class="form-group">
                            <label>Short Description</label>
                            <input type="text" class="form-control form-control-user required " name="blog_short_description"
                                id="blog_short_description" placeholder="Enter Category">
                        </div>
                         <div class="form-group mb-3">
                            <label>Image</label>
                            <input type="file" accept="image/*" class="form-control" name="image"
                                id="image_input">
                            <div class="mt-3" id="image_preview">
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <span id="error" style="display: none;" class="m-auto"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" onclick="BlogStore()" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            Getdata();
         });

        function Getdata() {
                var DataTable = $("#DataTable").DataTable({
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
                    url: "{{ route('BlogFetch') }}",
                    dataSrc: '',
                },
                columns: [{
                        data: 'blog_id',
                    },
                    {
                        data: 'blog_title',
                    },
                    {
                        data: 'blog_description',
                    },
                    {
                        data: 'blog_short_description',
                    },
                    {
                        data: 'image',render: (img)=>{return `<img class ="datable-img" src="{{url('public/Files/Blog')}}/${img}">`},
                    },
                    {
                        data: 'created_date',
                    },
                    {
                        data: 'blog_id',
                        render: (blog_id) => {
                                return `<button class="btn btn-primary mx-1" data-toggle="modal" data-target="#Blog_modal" onclick="BlogEdit('${blog_id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="BlogRemove('${blog_id}')"><i class="fa fa-trash"></i></button>`;
                            }
                    }

                ]
                });
        }

        imagepreview('#image_input', '#image_preview');

        function BlogStore(){
            $("#btnSubmit").prop('disabled', true)
            var formData = new FormData($('#Blog_Form')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('BlogStore')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: (res) => {
                    if (res.success) {
                        console.log(res);
                        $("#Blog_Form")[0].reset();
                        $("#Blog_modal").modal('hide');
                        $("#image_preview").css('background-image', `url('')`);
                        swal("Success!", res.message, "success");
                    }else if(res.validate) {
                        alertmsg(res.message, "warning");
                    }else{
                        console.log(res);
                        swal("Error!", res.message, "error");
                    }
                     DataTable.ajax.reload();
                }
            });
            $("#btnSubmit").prop('disabled', false)
        }

        function BlogEdit(id){
            $('#Blog_modal').modal('show');

            $.get("{{route('BlogEdit')}}",{
                blog_id : id
            }, function (data) {
                console.log(data.data[0]['blog_title']);
                $('#blog_id').val(data.data[0]['blog_id']);
                $('#blog_title').val(data.data[0]['blog_title']);
                $('#blog_description').val(data.data[0]['blog_description']);
                $('#blog_short_description').val(data.data[0]['blog_short_description']);
                $('#image_preview').css("background-image", `url('{{ url("public/Files/Blog") }}/${data.data[0]["image"]}`)
            });
        }

        function BlogRemove(id){
           confirmdlt(() => {
                $.get("{{ route('BlogDelete') }}", {blog_id: id},
                    (res) => {
                        swal({title: "Successful...", text: res.message, icon: "success"})
                        DataTable.ajax.reload();
                    });
            })
        }
    </script>
@endsection
