<?= $header1;?>
<div id="processing"></div>
  <main class="main login-page">
           
            <!-- End of Breadcrumb -->
            <div class="page-content">
                <div class="container">
                    <div class="login-popup">
                        <div class="tab tab-nav-boxed tab-nav-center tab-nav-underline">
                            <ul class="nav nav-tabs text-uppercase" role="tablist">
                                <li class="nav-item">
                                    <a href="#sign-in" class="nav-link active">OTP Verification</a>
                                </li>
                               
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="sign-in">
                                    <div class="alert alert-success">An OTP has been sent to your registered email ID . Please enter OTP to Verify. Thanks</div>
                                    <br />
                                	<form id="otp" method="post" enctype="multipart/form-data">
                                		<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
	                                    <div class="form-group" style="margin-bottom: 0px">
	                                        <label>Enter OTP</label>
	                                        <input type="number" class="form-control" name="otpval" id="otpval" placeholder="Enter OTP">
	                                        <span id="otp_error" class="text-danger"></span>
	                                    </div>
                                        <span style="color:red;margin-top: 5px;float: right;cursor: pointer;" onclick="return resendOtp()">Resend OTP</span>
                                        <br />
	                                    <button type="submit" class="btn btn-dark">Verify OTP</button>
                                	</form>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </main>
<?= $footer;?>
<?= $js;?>