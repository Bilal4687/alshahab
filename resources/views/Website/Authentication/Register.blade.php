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
								Authentication
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="content-area col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="site-main">
						<h3 class="custom_blog_title">
							Authentication
						</h3>
						<div class="customer_login">
							<div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
									<div class="login-item">
										<h5 class="title-login">Register now</h5>
										<form class="register" id="AddNewCustomer">
                                            @csrf
                                            <p class="form-row form-row-wide">
                                                <label class="text">Your Name</label>
                                                <input type="text" id="customer_name" name="customer_name" class="input-text">
                                            </p>
											<p class="form-row form-row-wide">
												<label class="text">Your email</label>
												<input title="email" id="customer_email" name="customer_email" type="email" class="input-text">
											</p>
                                            <p class="form-row form-row-wide">
                                                <label class="text">Your Contact No</label>
                                                <input type="text" id="customer_mobile" name="customer_mobile" class="input-text">
                                            </p>
											<p class="form-row form-row-wide">
												<label class="text">Password</label>
												<input title="pass" type="password" id="customer_password" name="customer_password" class="input-text">
											</p>
											<p class="form-row">
												<span class="inline">
													<input type="checkbox" id="cb2">
													<label for="cb2" class="label-text">I agree to <span>Terms & Conditions</span></label>
												</span>
											</p>
											<p class="form-row">
												<button type="button" id="SignUpBtn" name="SignUpBtn" onclick="AddNewCustomer()" class="button-submit">Login</button>
                                                <div id="show_error" class="" style="display:none;"></div>
                                            </p>
										</form>
									</div>
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
            $("#show_error").removeClass().html('').show();
            $("#show_error").addClass(`alert alert-${type} text-center`).html(msg);
            $("#show_error").fadeOut(2000);
        }

        function AddNewCustomer() {
            $('#SignUpBtn').prop("disabled", true);

            $.post("{{ route('AddNewCustomer') }}", $('#AddNewCustomer').serialize())
                .done((res) => {
                    if (res.success) {
                        alertmsg(res.message, "success");
                        window.location.href = "{{ url('Login') }}";
                    } else if (res.validation) {
                        alertmsg(res.message[0], "warning")
                    } else {
                        alertmsg(res.message, "danger")
                    }
                })
                .fail((err) => {
                    alertmsg("Opps Something went wrong", "danger")
                });
                $('#SignUpBtn').prop("disabled", false);
        }
    </script>

@endsection

