<div class="container">       
<div id="signupbox" style=" margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Sign Up</div>
                <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide();
                                    $('#loginbox').show()">Sign In</a></div>
            </div>  
            <div class="panel-body" >
                
                 <?php if($this->session->flashdata('failure')): ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('failure') ?>
                </div>
                <?php endif; ?>
                
                <form id="signupform" class="form-horizontal" role="form" method="post" action="<?php echo base_url('/index.php/public/Frontier/process_register') ?> ">
                    <div id="signupalert" style="display:none" class="alert alert-danger">
                        <p>Error:</p>
                        <span></span>
                    </div>
                    
                     <?php echo form_hidden($csrf) ?>
                    
                    <?php echo form_error('first_name') ?>
                    <div class="form-group">
                        <label for="firstname" class="col-md-3 control-label">First Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" required="" value="<?php echo set_value('first_name') ?>" name="first_name" placeholder="First Name">
                        </div>
                    </div>
                    <?php echo form_error('last_name') ?>
                    <div class="form-group">
                        <label for="lastname" class="col-md-3 control-label">Last Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" required="" name="last_name" value="<?php echo set_value('last_name') ?>" placeholder="Last Name">
                        </div>
                    </div>
                    
                    <?php echo form_error('email') ?>
                    <div class="form-group">
                        <label for="email" class="col-md-3 control-label">Email</label>
                        <div class="col-md-9">
                            <input type="email" value="<?php echo set_value('email')?>" class="form-control" required="" name="email" placeholder="Email Address">
                        </div>
                    </div>
                    
                       <?php echo form_error('phone') ?>
                     <div class="form-group">
                        <label for="phone" class="col-md-3 control-label">Phone/Contact No</label>
                        <div class="col-md-9">
                            <input type="tel" class="form-control" value="<?php echo set_value('phone') ?>" required="" name="phone" placeholder="Phone no">
                        </div>
                    </div>
                    
                    <?php echo form_error('institution') ?>
                    <div class="form-group">
                        <label for="institution" class="col-md-3 control-label">Institution</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" required="" value="<?php echo set_value('institution') ?>" name="institution" placeholder="">
                        </div>
                    </div>
                    
                    <?php echo form_error('password') ?>
                    <div class="form-group">
                        <label for="password" class="col-md-3 control-label">Password</label>
                        <div class="col-md-9">
                            <input type="password" class="form-control" required="" name="password" placeholder="Password">
                        </div>
                    </div>
                    
                        <?php echo form_error('email') ?>
                     <div class="form-group">
                        <label for="confirm_password" class="col-md-3 control-label">Confirm Password</label>
                        <div class="col-md-9">
                            <input type="password" class="form-control" required="" name="confirm_password" placeholder="Confirm Password">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <!-- Button -->                                        
                        <div class="col-md-offset-3 col-md-9">
                            <button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Sign Up</button>
                            <span style="margin-left:8px;">or</span>  
                        </div>
                    </div>

                    <div style="border-top: 1px solid #999; padding-top:20px"  class="form-group">

                        <div class="col-md-offset-3 col-md-9">
                            <button id="btn-fbsignup" type="submit" class="btn btn-primary"><i class="icon-facebook"></i>   Sign Up with Facebook</button>
                        </div>                                           

                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 