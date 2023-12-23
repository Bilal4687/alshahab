<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('public/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ url('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('public/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo"> <b>Alshahab</b> </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Login to start your session</p>
                <form id="loginForm">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control required"
                            placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text"> <span class="fas fa-envelope"></span> </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control required"
                            placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text"> <span class="fas fa-lock"></span> </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-4 m-auto">
                        <button type="button" class="btn btn-block btn-primary text-white" id="LoginBtn">Login</button>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-md-12 m-auto ">
                        <div id="show_error" class="" style="display:none;"></div>
                    </div>
                </div>


            </div>
        </div>
    </div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ url('public/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ url('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ url('public/dist/js/adminlte.min.js')}}"></script>
<script>
    function alertmsg(msg, type) {
       $("#show_error").removeClass().html('').show();
       $("#show_error").addClass(`alert alert-${type} text-center`).html(msg);
       $("#show_error").fadeOut(2000);
   }
   $("#LoginBtn").click(function() {

   $("#LoginBtn").prop("disabled", true);

   $.post("{{route('AdminLoginStore')}}", $('#loginForm').serialize())
   .done((res)=>{
       if(res.success){
           alertmsg(res.message, "success");
           window.location.href = "{{url('Admin/Dashboard')}}";
       }else if(res.validation){
           alertmsg(res.message[0], "warning")
       }else{
           alertmsg(res.message, "danger")
       }
       })
   .fail((err)=>{
       alertmsg("Opps Something went wrong", "danger")
   });
   $("#LoginBtn").prop("disabled", false);
   });
</script>
</body>
</html>
