<?php 
    $btn_msg = ($id == 0) ? "ADD" : " Update";
$title_msg = ($id == 0) ? "Create" : " Update";
?>
<aside class="right-side">
    <!-- Content Header (Page header) -->
<!--    <section class="content-header">
        <h1>
            Course Dashboard <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#">
                    <i class="fa fa-dashboard"></i> Home</a>
            </li>
            <li class="active">Courses </li>
        </ol>
    </section>-->

    <!-- Main content -->
        <div class="container">
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">  
                    <div class="box">
                        <div class="box-header">
    <!--                                    <i class="fa fa-comments-o"></i>-->
                            <h3 class="box-title">Course Management</h3>
                        </div>
                        <div class="box-body " style="overflow:auto"> 
                                <?php foreach ($courses as $row): ?>
                                    <div class="col-lg-6 col-md-6 col-sm-12  <?php echo $row->course_type ?>">
                                        <h4><?php echo $row->cat_name ?> >> <small><?php echo $row->course_name ?></small></h4>
                                        <div class="course_item">
                                            <?php if($row->banner_url == TRUE):?>
                                                <img src="<?php echo base_url($row->banner_url) ?>" /> 
                                            <?php endif; ?>
                                               <?php echo character_limiter($row->course_description, 200)?>
                                                
                                        </div>
                                        <div class="course_action pull-right">
                                                    <a href="<?php echo base_url('Courses/view_course/'.$row->id) ?>" id="view_course_detail" ><i class="glyphicon glyphicon-floppy-open"></i></a>
                                                    <a href="<?php echo base_url('Courses/delete_course/'.$row->id) ?>" id="edit_course"><i class="glyphicon glyphicon-edit"></i></a>
                                                    <a href="<?php echo base_url('Courses/edit_course/'.$row->id) ?>" id="delete_course"><i class="glyphicon glyphicon-remove"></i></a>
                                                </div>
                                    </div>  
                                <?php endforeach; ?>
                        </div>
                     </div>
                </section>      
                <section class="col-lg-5 connectedSortable">
                    <div class="box">
                        <div class="box-header">
<!--                                    <i class="fa fa-comments-o"></i>-->
                            <h3 class="box-title"><?php echo $title_msg; ?> Courses</h3> <hr >
                        </div>
                        <div class="box-body">
                           <div id="smessage">
                            <?php
                            echo validation_errors();
                            echo $this->session->flashdata('smessage');
                            ?>
                        </div>
                            
                            <form action="#" method="post">
                                <div class="form-group">
                                    <label>Course Name*</label>
                                    <div class="field">
                                        <input name="course_id" id="course_id" type="text"  class="xxwide text input validate[required] form-control" placeholder="Course name" value="<?php echo set_value('course_name') ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Categories</label>
                                    <div class="field">
                                        <?php  echo form_dropdown('category', $categories) ?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Course Type</label>
                                    <div>
                                        <label><input type="radio" name="course_type" value="general" id="general">General</label>
                                    
                                        <label><input type="radio" name="course_type" value="Specialize" id="specialize">Specialize</label>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        
                                        <div><label><input type="checkbox" class="specialize" name="specialize[]" value="all" >All/General</label></div>
                                        <div><label><input type="checkbox" class="specialize" name="specialize[]" value="midwifery" />Midwifery</label></div>
                                         <div><label><input type="checkbox" class="specialize" name="specialize[]" value="general nurse" />General Nurses</label></div>
                                          
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div><label><input type="checkbox" class="specialize" name="specialize[]" value="doctor" />Doctors</label></div>
                                           <div><label><input type="checkbox" class="specialize" name="specialize[]" value="community nurse" />Community Nurses</label></div>
                                            <div><label><input type="checkbox" class="specialize" name="specialize[]" value="health administrators" />Health Administrators</label></div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Course description*</label>
                                    <div class="field">
                                        <textarea cols="6" name="course_description" id="course_description" 
                                                  class="xxwide text input validate[required] form-control" 
                                                  placeholder="Course description"><?php echo set_value('course_description'); ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <input type="file" id="banner_url" name="banner_url" value="<?php echo set_value('banner_url')?>" >
                                </div>

                                <div class="box-footer clearfix">
                                    
                                    <button class="pull-right btn btn-default" id="add_insuere_group" >Send <i class="fa fa-arrow-circle-right"></i></button>
                                </div>   
                            </form>
                        </div>
                    </div>         
                </section>
            </div>
        </div>
    </aside><!-- /.right-side -->   