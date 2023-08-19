@extends('Admin.AdminLayout')

@section('content')
    <link rel="stylesheet" href="{{ url('public/plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <script src="{{ url('public/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12 my-2">
                <div class="card shadow">
                    <div class="card-body">
                        <form id="general_form">
                            @csrf
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" required>
                            </div>
                            <div class="form-group">
                                <label for="product_description">Product Description</label>
                                <textarea class="form-control" id="product_description" name="product_description" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="brand_id">Brand</label>
                                <select class="form-control" id="brand_id" name="brand_id" required>
                                    <option value="">Select a brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->brand_id }}">{{ $brand->brand_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Select a brand</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_status">Product Status</label>
                                <select class="form-control" id="product_status" name="product_status">
                                    <option value="0">Select a Status</option>
                                    <option value="0">All product</option>
                                    <option value="1">Weekly Future</option>
                                    <option value="2">New Arrivals</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_thumbnail">Product Thumbnail</label>
                                <input type="file" class="form-control" id="product_thumbnail" name="product_thumbnail"
                                    required>
                            </div>
                            <div id="image_preview"></div>
                        </form>
                        <button type="button" id="submitbtn" class="btn btn-lg btn-primary mt-2" onclick="SaveProduct()"
                        style="width: 100%">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#product_description').summernote({
                    tabDisable: true,
                    height: 200,
                });
            })

            imagepreview('#product_thumbnail', '#image_preview', 3)

            function SaveProduct() {
                $("#submitbtn").prop('disabled', true)
                var formData = new FormData($('#general_form')[0]);
                $.ajax({
                    url: "{{ 'ProductStore' }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: (res) => {
                        if (res.success) {
                            $('#general_form')[0].reset();
                            $("#product_description").summernote('code', "")
                            $('#image_preview').css('background-image', `url('')`);
                            swal("Success!", res.message, "success");
                            window.location.href='{{route('Product')}}'

                        } else if (res.validate) {
                            alertmsg(res.message, "warning")
                        } else {
                            swal("Error!", res.message, "error");
                        }
                    }
                });
                $("#submitbtn").prop('disabled', false)
            }
        </script>
    @endsection
