<!-- NAVBAR CODE END -->
<div class="container">

    <div class="row">
        <div class="signup-wrapper">
            <div class="col-md-6 col-sm-6">
                <?php echo form_open('member/login') ?>
                <strong>Already Registered ? </strong>Please login below to access your account.
                <hr />
                <a href="#" class="btn btn-social btn-facebook">
                    <i class="fa fa-facebook"></i>&nbsp; Facebook Account</a>
                &nbsp;OR&nbsp;
                <a href="#" class="btn btn-social btn-google">
                    <i class="fa fa-google-plus"></i>&nbsp; Google Account</a>
                <hr>
                <h5>Or Login with <strong>Website Account  :</strong></h5>
                <label><?php echo lang('login_identity_label', 'identity'); ?> : </label>
                <input type="text" class="form-control">
                <label> <?php echo lang('login_password_label', 'password'); ?> :  </label>
                <input type="password" class="form-control">
                <label><input type="checkbox" name="remeber" id="remeberme" value="true">Remember Me</label>
                <hr>
                <!--<a href="#" class="btn btn-info"><span class="fa fa-user"></span>&nbsp;Log In </a>--> 
                <input type="submit" name="login" id="login" class="btn btn-info" value="Login" />
                &nbsp;&nbsp; <a href="<?php echo base_url("index.php/member/forgot_password") ?>" >forgotten Password</a>
                <?php echo form_close() ?>
            </div>
            <div class="col-md-6 col-sm-6 alert alert-success">
                <?php echo form_open('index.php/public/Member/process_create_user') ?>
                <strong>Not Registered </strong>with us ? Login with facebook / Google or fill the form below to get full access.
                <hr />
                <div class="form-group">
                <label>Salutation:</label>
                <?php echo form_dropdown('salutation',$salutation)?>
                </div>
                <label>First Name:</label>
                <input type="text" name="first_name" required="" id="first_name" class="form-control" />
                <label>Last Name:</label>
                <input type="text" name="last_name" required="" id="last_name" class="form-control"/>
                <label>Enter Email ID : </label>
                <input type="email" required="" name="email" class="form-control">
                <label>Phone</label>
                <input type="tel" required="" name="phone" class="form-control">
                <label>Institution/Facility</label>
                <input type="text" required="" name="institution" class="form-control" >
                <label>Enter Password :  </label>
                <input type="password" name="password" required="" class="form-control">
                <label>Retype Password :  </label>
                <input type="password" name="password_confirm" required="" class="form-control">
                <hr>
                <input type="submit" class="btn btn-warning" name="register" value="Register Me" />&nbsp;
                <input type="reset"  class="btn btn-success" name="reset" value="Reset Entries" />
                <?php form_close() ?>
            </div>
        </div>
        <!-- END SIGN UP FORM-->
    </div>

</div>