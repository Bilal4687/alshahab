@extends('Admin.AdminLayout')

@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->


<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{$category}}</h3>
            <p></p>
            <p>Category</p>
          </div>
          <div class="icon">
            {{-- <i class="ion ion-bag"></i> --}}
            <i class="nav-icon fas fa-th"></i>

          </div>
          <a href="{{route('Category')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$slider}}<sup style="font-size: 20px">%</sup></h3>

            <p>Slider</p>
          </div>
          <div class="icon">
            <i class="nav-icon fas fa-image"></i>

          </div>
          <a href="{{route('Slider')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{$attribute}}</h3>

            <p>Attribute</p>
          </div>
          <div class="icon">
            <i class="nav-icon fas fa-tag"></i>

          </div>
          <a href="{{route('Attribute')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{$brands}}</h3>

            <p>Brand</p>
          </div>
          <div class="icon">
            <i class="nav-icon fas fa-laugh"></i>
          </div>
          <a href="{{route('Brand')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>


      <!-- ./col -->
    </div>
    <div class="row">
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$discount}}<sup style="font-size: 20px">%</sup></h3>

            <p>Discount</p>
          </div>
          <div class="icon">
            <i class="nav-icon fas fa-percent"></i>
          </div>
          <a href="{{route('Discount')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{$products}}</h3>

            <p>Product</p>
          </div>
          <div class="icon">
            <i class="nav-icon fas fa-shopping-bag"></i>
          </div>
          <a href="{{route('Product')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{$variationss}}</h3>

            <p>Variation</p>
          </div>
          <div class="icon">
            <i class="nav-icon fas fa-cubes"></i>
          </div>
          <a href="{{route('variation')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
</div><!-- /.container-fluid -->

@endsection
