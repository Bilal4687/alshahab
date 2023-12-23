@extends('website.layout')
@section('content')

	<div class="main-content main-content-login">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breadcrumb-trail breadcrumbs">
						<ul class="trail-items breadcrumb">
							<li class="trail-item trail-begin">
								<a href="index.html">Home</a>
							</li>
							<li class="trail-item trail-end active">
								Sign In
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="content-area col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="site-main">
                        <h3 class="header-message" style="text-align: center">
                            Discover Your Fragrance Journey Today!
                        </h3>
						<div class="customer_login">
							<div class="row">
                                <div class="col-md-3">

                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">

									<div class="login-item">
										<h5 class="title-login">Login Please enter your e-mail and password                                        </h5>
										<form class="login" id="CustomerLogin">
                                              @csrf
											<p class="form-row form-row-wide">
												<label class="text">Username</label>
												<input title="username" type="text" id="customer_email"
                                                name="customer_email" class="input-text">
											</p>
											<p class="form-row form-row-wide">
												<label class="text">Password</label>
												<input title="password" type="password" class="input-text"
                                                id="customer_password" name="customer_password">
											</p>
											<p class="lost_password">
												<span class="inline">
													<input type="checkbox" id="cb1">
													<label for="cb1" class="label-text">Remember me</label>
												</span>
												<a href="#" class="forgot-pw">Forgot password?</a>
											</p>
											<p class="form-row">
												<button type="button" id="LoginBtn" name="LoginBtn" onclick="CustomerLogin()" class="button-submit">Login</button>
                                                <div id="error" style="display: none"></div>
                                            </p>
											<p class="form-row">
                                               <a href="{{ url('Signup') }}">New to Guessmyscent? Create an account</a>
                                            </p>
										</form>
									</div>
								</div>
                                <div class="col-md-3">

                                </div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<a href="#" class="backtotop">
		<i class="fa fa-angle-double-up"></i>
	</a>

    <script>


            function alertmsg(msg, type) {
    $("#error").removeClass().html('').show();
    $("#error").addClass(`alert alert-${type} text-center`).html(msg);
    $("#error").fadeOut(3000);
}




        function CustomerLogin() {
            $('#LoginBtn').prop("disabled", true);

            $.post("{{ route('CustomerLogin') }}", $('#CustomerLogin').serialize())
                .done((res) => {
                    if (res.success) {
                        alertmsg(res.message, "success");
                            window.location.href = "{{ url('/OrderConfirm') }}";
                    } else if (res.validate) {
                        alertmsg(res.message, "warning")
                    } else {
                        alertmsg(res.message, "danger")
                    }
                })
                .fail((err) => {
                    alertmsg("Opps Something Went Wrong", "danger")
                });
            $('#LoginBtn').prop("disabled", false);

        }
    </script>

@endsection

