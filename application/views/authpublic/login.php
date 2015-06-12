 <!-- NAVBAR CODE END -->
    <div class="container">
        
        <div class="row">
            <div class="signup-wrapper">


                <div class="col-md-6 col-sm-6">
                    <strong>Already Registered ? </strong>Please login below to access your account.
                    <hr />
                    <a href="#" class="btn btn-social btn-facebook">
                        <i class="fa fa-facebook"></i>&nbsp; Facebook Account</a>
                    &nbsp;OR&nbsp;
                    <a href="#" class="btn btn-social btn-google">
                        <i class="fa fa-google-plus"></i>&nbsp; Google Account</a>
                    <hr>
                    <h5>Or Login with <strong>Website Account  :</strong></h5>
                    <label><?php echo lang('login_identity_label', 'identity');?> : </label>
                    <input type="text" class="form-control">
                    <label> <?php echo lang('login_password_label', 'password');?> :  </label>
                    <input type="password" class="form-control">
                    <hr>
                    <a href="#" class="btn btn-info"><span class="fa fa-user"></span>&nbsp;Log In </a> &nbsp;&nbsp; <a href="<?php echo base_url("index.php/member/forgot_password")?>" >forgotten Password</a>
                </div>
                <div class="col-md-6 col-sm-6 alert alert-info">
                    <strong>Not Registered </strong>with us ? Login with facebook / Google or fill the form below to get full access.
                 <hr />
                   
                    <label>Enter Email ID : </label>
                    <input type="text" class="form-control">
                    <label>Enter Password :  </label>
                    <input type="password" class="form-control">
                    <label>Retype Password :  </label>
                    <input type="password" class="form-control">
                    <hr>
                    <a href="#" class="btn btn-warning"><span class="fa fa-user-plus"></span>&nbsp;Register Me </a>&nbsp;
                     <a href="#" class="btn btn-success"><span class="fa fa-refresh"></span>&nbsp;Reset Entries</a>

                </div>
            </div>
            <!-- END SIGN UP FORM-->
        </div>

    </div>