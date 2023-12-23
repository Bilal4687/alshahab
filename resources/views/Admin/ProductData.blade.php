@extends('Admin.AdminLayout')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.11/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.11/cropper.min.js"></script>
<style>
    .list-group-item:hover .delete-attr {display: block;}
    .list-group-item .delete-attr {display: none;}
    .list-group-item .chevron-icon {transition: transform 0.3s ease;}
    .list-group-item.collapsed .chevron-icon {transform: rotate(0deg);}
    .list-group-item:not(.collapsed) .chevron-icon {transform: rotate(180deg);}

    .imagecard {position: relative;}

    .imagecard-buttons {
        position: absolute;
        top: 0;
        right: 0;
        padding: 0.5rem;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .imagecard:hover .imagecard-buttons {opacity: 1;}

    /* Custom CSS for cropper modal */

    .modal-dialog.modal-lg {
      max-width: calc(100% - 1.75rem);
      margin: 1.75rem auto;
    }
    #imageContainer {
      max-height: 80vh;
      overflow: hidden;
    }
    #imageContainer img {
      max-width: 100%;
      max-height: 100%;
      display: block;
      margin: 0 auto;
    }
</style>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12 my-2">
            <div class="card shadow">
                <div class="card-body" style="min-height:100vh; ">
                    @section('heading', $product[0]->product_name." - Product Details" )
                    <div class="row">
                        <div class="col-2">
                            <div class="nav flex-column nav-pills" id="tab" role="tablist"
                                aria-orientation="vertical"><a class="nav-link" id="variations-tab" data-toggle="pill" href="#variations"
                                    role="tab" aria-controls="variations">Variations</a>
                                <a class="nav-link active" id="attributes-tab" data-toggle="pill" href="#attributes"
                                    role="tab" aria-controls="attributes">Attributes</a>
                                <a class="nav-link" id="images-tab" data-toggle="pill" href="#images" role="tab"
                                    aria-controls="images">Images</a>
                                {{-- <a class="nav-link" id="discounts-tab" data-toggle="pill" href="#discounts"
                                    role="tab" aria-controls="discounts">Discounts</a> --}}
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="tab-content mx-2" id="tabContent">

                                <div class="tab-pane fade" id="variations" role="tabpanel" aria-labelledby="variations-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4>Variation Data</h4>
                                            <form id="variation_form">
                                                <div class="row" style="width: 100%;">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Variation</label>
                                                            <select class="form-select" name="variation_id"
                                                                id="variation">
                                                                @foreach ($variations as $row)
                                                                    <option value="{{ $row->variation_id }}">{{ $row->variation_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label for="">Variations Value</label>
                                                            <input type="text" class="form-control" name="variation_value" id="variation_value">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label for="">Sale Price</label>
                                                            <input type="number" class="form-control" name="sale_price" id="sale_price">
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="form-group">
                                                            <label for="">MRP Price</label>
                                                            <input type="number" class="form-control" name="mrp_price" id="mrp_price">
                                                        </div>
                                                    </div>
                                                    <div class="col-1">
                                                        <a class="btn btn-success " onclick="VariationAdd()" style="position: absolute; bottom: 17px;"> <i class="fa fa-plus" ></i> </a>
                                                    </div>

                                                </div>
                                            </form>
                                            <div id="listAccordion">
                                                <div class="list-group">
                                                    @if (!count($variationsData))
                                                        <p>Not Variation Found for this Product</p>
                                                    @else
                                                        @foreach ($variationsData as $row)
                                                            <a href="#variation{{ $row->product_variation_id }}" class="list-group-item list-group-item-action collapsed"  data-toggle="collapse">{{$row->variation_value}}  ({{ $row->variation_name }})
                                                                <i class="fas fa-chevron-down chevron-icon" style="float: right"></i>
                                                                <span style="float: right; color: red; text-decoration: underline;" onclick="VariationDelete(event, {{ $row->product_variation_id }})" class="delete-attr mx-4">Remove</span>
                                                            </a>
                                                            <div id="variation{{ $row->product_variation_id }}" class="collapse">
                                                                <div class="card card-body">
                                                                    <div class="row w-100">
                                                                        <div class="col-3">
                                                                            Name :
                                                                            {{ $row->variation_name }}
                                                                        </div>
                                                                        <div class="col-3">
                                                                            MRP Price:
                                                                            {{ $row->mrp_price }}
                                                                        </div>
                                                                        <div class="col-3">
                                                                            MRP Price:
                                                                            {{ $row->discount_percentage }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="row w-100">
                                                                        <div class="col-3">
                                                                            Value :
                                                                            {{ $row->variation_value }}
                                                                        </div>
                                                                        <div class="col-3">
                                                                            Sale Price :
                                                                            {{ $row->sale_price }}
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                 <div class="tab-pane fade show active" id="attributes" role="tabpanel" aria-labelledby="attributes-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4>Attributes Data</h4>
                                            <form id="attribute_form">
                                                <div class="row" style="width: 100%;">
                                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Attribute</label>
                                                            <select class="form-select" name="attribute_id"
                                                                id="attribute">
                                                                @foreach ($attributes as $row)
                                                                    <option value="{{ $row->attribute_id }}">{{ $row->attribute_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                          <div class="form-group">
                                                           <label>Variation</label>
                                                            <select class="form-select" name="variation_id"
                                                                id="variation">
                                                                @foreach ($variationsData as $row)
                                                                    <option value="{{ $row->product_variation_id }}">{{ $row->variation_value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <div class="form-group">
                                                            <label for="">Attributes Value</label>
                                                            <input type="text" class="form-control" name="attribute_value" id="attribute_value">
                                                        </div>
                                                    </div>
                                                    <div class="col-1">
                                                        <a class="btn btn-success " onclick="AttributeAdd()" style="position: absolute; bottom: 17px;"> <i class="fa fa-plus" ></i> </a>
                                                    </div>
                                                </div>
                                            </form>
                                            <div id="listAccordion">
                                                <div class="list-group">
                                                    @if (!count($attributesData))
                                                        <p>Not Attributes Found for this Product</p>
                                                    @else
                                                        @foreach ($attributesData as $row)
                                                            <a href="#attribute{{ $row->product_attribute_id }}" class="list-group-item list-group-item-action collapsed"  data-toggle="collapse">{{ $row->attribute_value }} ({{ $row->attribute_name }})
                                                                <i class="fas fa-chevron-down chevron-icon" style="float: right"></i>
                                                                <span style="float: right; color: red; text-decoration: underline;" onclick="AttributeDelete(event, {{ $row->product_attribute_id }})" class="delete-attr mx-4">Remove</span>
                                                            </a>
                                                            <div id="attribute{{ $row->product_attribute_id }}" class="collapse">
                                                                <div class="card card-body">
                                                                    <div class="row w-100">
                                                                        <div class="col-4">
                                                                            Name :<br />
                                                                            {{ $row->attribute_name }}
                                                                        </div>
                                                                        <div class="col-4">
                                                                            Value :<br />
                                                                            {{ $row->attribute_value }}
                                                                        </div>
                                                                        <div class="col-4">
                                                                            Variation :<br />
                                                                            {{ $row->variation_value }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4>Images</h4>
                                            <form id="image_form">
                                                <div class="row" style="width: 100%;">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                                    <div class="col-3">
                                                      <div class="form-group">
                                                        <label for="">Select Image</label>
                                                        <input type="file" class="form-control" id="product_image" >
                                                      </div>
                                                    </div>
                                                    {{-- {{dd($attributes)}} --}}
                                                    <div class="col-4">
                                                    <div class="form-group">

                                                            <label>Variation</label>
                                                            <select name="variation_id" id="variation_id" class="form-select form-control-user">
                                                                <option selected disabled>Select Variation</option>
                                                                @foreach ($variationsData as $item)
                                                                    <option value="{{$item->product_variation_id}}">{{$item->variation_value}}</option>
                                                                @endforeach
                                                                {{-- <option value="1">Complete</option> --}}
                                                            {{-- <option value="test">test</option> --}}
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class=" col-4">
                                                    <div class="form-group">

                                                        <label>Attribute</label>
                                                        <select name="attribute_id" id="attribute_id" class="form-select form-control-user">
                                                            <option selected disabled>Select Attribute</option>
                                                            @foreach ($attributesData as $item)
                                                                <option value="{{$item->product_attribute_id}}">{{$item->attribute_value}}</option>
                                                            @endforeach
                                                            {{-- <option value="1">Complete</option> --}}
                                                        {{-- <option value="test">test</option> --}}
                                                    </select>
                                                    </div>
                                                </div>
                                                    <div class="col-1 ">
                                                      <a class="btn btn-success" onclick="ImageAdd()" style="position: absolute; bottom: 17px;"><i class="fa fa-plus" ></i></a>
                                                    </div>
                                                  </div>
                                            </form>

                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="card-columns">

                                                        @if (!count($imagesData))
                                                            <p>Not Images Found for this Product</p>
                                                        @else
                                                            @foreach ($imagesData as $row)
                                                            <div class="card imagecard position-relative">
                                                                <img src="{{ url('public/Files/Products-Images/')."/". $row->product_image_path }}" class="card-img-top" alt="Image">
                                                                <div class="imagecard-buttons">
                                                                    <button class="btn btn-danger btn-sm delete-image" onclick="ImageDelete(event,{{ $row->product_image_id }})" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                    <button class="btn btn-primary btn-sm set-thumbnail" onclick="setThumbnail('{{ $row->product_image_path }}', {{$id}})" data-toggle="tooltip" data-placement="top" title="Set as Thumbnail">
                                                                        <i class="fa fa-star"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        @endif

                                                        <!-- Add more cards with images here -->
                                                      </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        var lastSelectedTab = localStorage.getItem('lastSelectedTab');
        if (lastSelectedTab) {
            // Show the last selected tab
            $('.nav-link').removeClass('active');
            $('.tab-pane').removeClass('show active');
            try {
                $(lastSelectedTab).addClass('active');
                $(lastSelectedTab + '-tab').tab('show');
            } catch(error) {
                $('#attributes').addClass('active');
                $('#attributes-tab').tab('show');
            }
        }
    });

    function setThumbnail(image,id){
        // console.log(image);
        $.get("{{ route('UpdateProductThambnail')}}",{product_id: id, thumbnail_path: image}, function(data){
            if (data.success == true) {
                    swal("Success!", data.message, "success");
                    // window.location.href = '{{ route('ProductData', ['id' => $id]) }}'
                }else{
                    swal("Error!", data.message, "warning");
                }
        });
    }

    $('#product_image').change(()=>{openCropperModal('product_image')});

    // Store the selected tab in local storage
    $('.nav-link').on('click', function() {
        var selectedTab = '#' + $(this).attr('href').substring(1);
        localStorage.setItem('lastSelectedTab', selectedTab);
    });


    document.querySelectorAll('#listAccordion .list-group-item').forEach(function(item) {
        item.addEventListener('click', function() {
            var chevronIcon = item.querySelector('.chevron-icon');
            item.classList.toggle('collapsed');
            chevronIcon.classList.toggle('rotate');
        });
    });

    function AttributeAdd() {
        $.get("{{ route('ProductAttributeAdd') }}", $('#attribute_form').serialize(), function(data) {
                if (data.success == true) {
                    // alert(data);
                    swal("Success!", data.message, "success");

                    // window.location.href = '{{ route('ProductData', ['id' => $id]) }}'
                }else{
                    // alert("kk")
                    swal("Error!", data.message, "warning");
                }
            }
        );
    }

    function AttributeDelete(e, id) {
        e.stopPropagation();
        $.get("{{ route('ProductAttributeRemove') }}", {id: id}, function(data) {
            if (data.success == true) {
                swal("Success!", data.message, "success");
                window.location.href = '{{ route('ProductData', ['id' => $id]) }}'
            }else{
                swal("Error!", data.message, "warning");
            }
            }
        );
    }


    function VariationAdd() {
        var formData =  new FormData($('#variation_form')[0]);
        $.ajax({
            url: "{{ route('ProductVariationAdd') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,

            success: (d) => {
                if (d.success == true) {
                    swal("Success!", d.message, "success");
                     setTimeout(()=>{
                    location.reload();
                }, 700);
                }else{
                    swal("Error!", d.message, "warning");
                }
            }
        });

    }

    function VariationDelete(e, id) {
        e.stopPropagation();
        $.get("{{ route('ProductVariationRemove') }}", {id: id}, function(data) {
            if (data.success == true) {
                swal("Success!", data.message, "success");
                window.location.href = '{{ route('ProductData', ['id' => $id])}}'
            }else{
                swal("Error!", data.message, "error");
            }
            }
        );
    }

    function ImageAdd() {
        if (!croppedimage) {
            swal("Error!", "Images is Required", "warning");
        }
        var formData = new FormData($('#image_form')[0]);
        formData.append('product_image',  dataURItoBlob(croppedimage), 'cropped_image.jpg');
        $.ajax({
            url: "{{ route('ProductImageAdd') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: (d) => {
                if (d.success == true) {
                    swal("Success!", d.message, "success");
                    setTimeout(()=>{
                        location.reload();
                    }, 700);
                }else{
                    swal("Error!", d.message, "warning");
                }
                // window.location.href = '{{ route('ProductData', ['id' => $id])}}';
            }
        });
    }

    function ImageDelete(e, id) {
        e.stopPropagation();
        $.get("{{ route('ProductImageRemove') }}", {id: id}, function(data) {
            if (data.success == true) {
                swal("Success!", data.message, "success");
                window.location.href = '{{ route('ProductData', ['id' => $id])}}'
            }else{
                swal("Error!", data.message, "warning");
            }
            }
        );
    }

    </script>
@endsection
