@extends('Website.Layout')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-lg-6">
            <div style="margin-top: 10%; margin-bottom: 10%">
                <center>

                    <p>
                        <i style="color : #28a745; border: 1px solid green; border-radius: 50%; padding: 30px" class="fa fa-check fa-3x"></i>
                    </p>
                    <h3>Thank you for your order</h3>
                    <p>The order confirmation email with details of your order and a link to track its progress has been sent to your email address</p>
                    <button class="btn btn-default btn-ellipse btn-md alert alert-success" style="border: none">
                        Please Wait Your Invoice is Generating...<i class="fa fa-spinner fa-spin fa-lg"></i>
                    </button>

                    <div class="d-flex justify-content-center" style="margin-top: 10px">
                        <button type="button"  class="btn btn-success btn-sm" ><i class="fa fa-download"></i></button>
                        <button type="button"  class="btn btn-primary btn-sm" ><i class="fa fa-print"></i></button>
                        <button class="btn btn-info btn-sm" ><i class="fa fa-envelope"></i></button>
                    </div>
                </div>
            </center>
        </div>
                <div class="col-md-3"></div>
    </div>
</div>
<script>
    $(document).ready(function () {
        setTimeout(() => {
            window.location.href = "{{ url('/Invoice') }}";
        }, 5000);
    });
</script>
@endsection
