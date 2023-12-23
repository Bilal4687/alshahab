<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guessmyscent - Invoice</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{url('public/assets/images/favicon.png/')}}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('public/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('public/dist/css/adminlte.min.css')}}">
</head>

<body>

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">


                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="" style="text-align: center">
                                    <img width="150px" src="{{url('public/assets/images/Guessmyscent.png')}}" alt="logo">

                                </div>
                             </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col px-3">
                                From
                                <address>
                                    <strong>Guessmyscent.</strong><br>
                                    Near Haji Ali Function hall<br>
                                    Roshan Gate Road<br>
                                    Phone: 9767894385<br>
                                    Email: info@alshahab.com
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col  px-5">
                                To
                                <address>
                                    <strong>Rehan Ali</strong><br>
                                    101 Royal plaza, sector 49<br>
                                    Chikalthana Midcs Area,<br>
                                    Phone: (+91) 9822824545<br>
                                    Email: rehan.ali@gmail.com
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col px-5">
                                <b>Invoice </b><br>
                                <br>
                                <b>Date:</b> 23-Dec-2023 <br>
                                <b>Order ID:</b> 4F3S8J<br>
                                <b>nvoice ID:</b> #007612<br>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Jannatul Firdous 3ml</td>
                                            <td>300</td>
                                            <td>2</td>
                                            <td>600</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Jannatul Firdous 3ml</td>
                                            <td>300</td>
                                            <td>2</td>
                                            <td>600</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Jannatul Firdous 3ml</td>
                                            <td>300</td>
                                            <td>2</td>
                                            <td>600</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Jannatul Firdous 3ml</td>
                                            <td>300</td>
                                            <td>2</td>
                                            <td>600</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">
                                <p class="lead">Thank you For Chossing our Fragrance</p>

                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    At <strong>Guessmyscent</strong>, we believe that every scent tells a story.
                                     Your story just became a bit more captivating.
                                      We appreciate your trust in us and look forward to being a
                                      delightful part of your
                                      fragrant adventures.
                                </p>
                            </div>
                            <!-- /.col -->
                            <div class="col-6">

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>₹ 600</td>
                                        </tr>
                                        {{-- <tr>
                                            <th>Tax (9.3%)</th>
                                            <td>₹10.34</td>
                                        </tr> --}}
                                        <tr>
                                            <th>Shipping:</th>
                                            <td>₹ 5</td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td>₹ 600</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="invoice-print.html" rel="noopener" target="_blank"
                                    class="btn btn-default"><i class="fas fa-print"></i> Print</a>

                                <button type="button" class="btn btn-primary float-right"
                                    style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Generate PDF
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>


    <script src="{{ url('public/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('public/dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ url('public/dist/js/demo.js')}}"></script>
</body>
