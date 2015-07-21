<!-- NAVBAR CODE END -->
<div class="container">
    <?php if($this->session->flashdata('message')){ ?>
    <div class="row">
        <div class="col-md-12 alert alert-success">
            <?php echo $this->session->flashdata('message') ?>
        </div>
    </div>
    <?php } ?>
    <div class="row">
        <div class="signup-wrapper">
            <div class="col-md-6 col-sm-6">
                <?php echo form_open('/index.php/public/Member/login') ?>
                <strong>Already Registered ? </strong>Please login below to access your account.
                <hr />
                <a href="#" class="btn btn-social btn-facebook">
                    <i class="fa fa-facebook"></i>&nbsp; Facebook Account</a>
                &nbsp;OR&nbsp;
                <a href="#" class="btn btn-social btn-google">
                    <i class="fa fa-google-plus"></i>&nbsp; Google Account</a>
                <hr>
                <h5>Or Login with <strong>Website Account  :</strong></h5>
                <label><?php echo lang('login_identity_label', 'identity'); ?>  </label>
                <input type="text" name="email" class="form-control">
                <label> <?php echo lang('login_password_label', 'password'); ?>   </label>
                <input type="password" name="password"  class="form-control">
                <label><input type="checkbox" name="remeber" id="remeberme" value="true">Remember Me</label>
                <hr>
                <!--<a href="#" class="btn btn-info"><span class="fa fa-user"></span>&nbsp;Log In </a>--> 
                <input type="submit" name="login" id="login" class="btn btn-info" value="Login" />
                &nbsp;&nbsp; <a href="<?php echo base_url("/index.php/public/Member/forgot_password") ?>" >forgotten Password</a>
                <?php echo form_close() ?>
            </div>
            <div class="col-md-6 col-sm-6 alert alert-success">
                <?php echo form_open('/index.php/public/Member/process_create_user') ?>
                <strong>Not Registered </strong>with us ? Login with facebook / Google or fill the form below to get full access.
                <hr />
                <?php echo form_hidden($csrf) ?>
                <div class="row">
                    <div class="col-md-3"><label>Salutation:</label></div>
                    <div class="col-md-9">
                        <select name="salutation" class="form-control" id="salutation">
                            <option value="">Select... </option>
                            <option value="miss">Miss</option>
                            <option value="mr.">Mr.</option>
                            <option value="mrs.">Mrs.</option>
                            <option value="dr.">Dr</option>
                            <option value="sir">Sir</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3"><label>First Name:</label></div>
                    <div class="col-md-9">
                        <input type="text" name="first_name" required="" id="first_name" class="form-control" value="<?php echo set_value('first_name') ?> " />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3"> <label>Last Name:</label></div>
                    <div class="col-md-9">
                        <input type="text" name="last_name" required="" id="last_name" class="form-control" value="<?php echo set_value('last_name') ?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"> <label>Email: </label></div>
                    <div class="col-md-9">
                        <input type="email" required="" name="email" class="form-control" value="<?php echo set_value('email') ?>" />
                    </div>
                </div>

                <div class="row">      
                    <div class="col-md-3">
                        <label>Phone:</label> 
                    </div>
                                                       
                    <div class="col-md-9">
                        <input type="tel" name="phone" required="" id="phone" class="form-control" value="<?php echo set_value('phone') ?>"/>
                    </div>
                </div>
                <div class="row">   
                    <div class="col-md-3">
                         <label>Institution/Facility:</label>  
                    </div>
                                                   
                    <div class="col-md-9">
                        <input type="text" required="" name="institution" id="institution" class="form-control" value="<?php echo set_value('institution') ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Enter Password :  </label>
                    </div>
                    
                    <div class="col-md-9">
                        <input type="password" name="password" required="" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"><label>Retype Password</label></div>
                    <div class="col-md-9">
                        <input type="password" name="password_confirm" required="" class="form-control">
                    </div>
                </div>

                <hr>
                <div class="row right">
                    <input type="submit" class="btn btn-warning" name="register" value="Register Me" />&nbsp;
                    <input type="reset"  class="btn btn-success" name="reset" value="Reset Entries" />
                </div>
                <?php form_close() ?>
            </div>
        </div>
    </div>
    <!-- END SIGN UP FORM-->
</div>

</div>