<?php
$btn_msg = ($id == 0) ? "ADD" : " Update";
$title_msg = ($id == 0) ? "Create" : " Update";
?>


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
                                <?php if ($row->banner_url == TRUE): ?>
                                    <img src="<?php echo base_url($row->banner_url) ?>" /> 
                                <?php endif; ?>
                                <?php echo character_limiter($row->course_description, 200) ?>

                            </div>
                            <div class="course_action pull-right">
                                <a href="<?php echo base_url('Courses/view_course/' . $row->id) ?>" id="view_course_detail" ><i class="glyphicon glyphicon-floppy-open"></i></a>
                                <a href="<?php echo base_url('Courses/delete_course/' . $row->id) ?>" id="edit_course"><i class="glyphicon glyphicon-edit"></i></a>
                                <a href="<?php echo base_url('Courses/edit_course/' . $row->id) ?>" id="delete_course"><i class="glyphicon glyphicon-remove"></i></a>
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
                    <?php echo form_open_multipart('index.php/Courses/process_form') ?>
                   
                    <?php echo form_hidden($csrf); ?>
                    <div class="form-group">
                        <?php echo form_error('course_name', '<div class="error">', '</div>'); ?>
                        <label>Course Name*</label>
                        <div class="field">
                            <input name="course_name" id="course_name" type="text"  class="xxwide text input validate[required] form-control" placeholder="Course name" value="<?php echo set_value('course_name') ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo form_error('category', '<div class="error">', '</div>'); ?>
                        <label>Categories</label>
                        <div class="field">
                            <?php echo form_dropdown('category', $categories);  ?>
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
                        <label>Moderator</label>
                       <select name="instructor" class="form-control" >
                           <option value="">Select Moderator</option>
                                <?php foreach ($instructors as $instructor){?>
                                <option value="<?php echo $instructor->id ?>"><?php echo $instructor->username?></option> 
                                <?php } ?>
                            </select>
                        <div class="alert-info alert">
                            Moderator is  an instructor or a faculty member who is in charge of the course.
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <?php echo form_error('course_description', '<div class="error">', '</div>'); ?>
                        <label>Course description*</label>
                        <div class="field">
                            <textarea cols="6" name="course_description" id="course_description" 
                                      class="xxwide text input validate[required] form-control" 
                                      placeholder="Course description"><?php echo set_value('course_description'); ?></textarea>
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <?php echo form_error('faq', '<div class="error">', '</div>'); ?>
                        <label>Course FAQ'S*</label>
                        <div class="field">
                            <textarea cols="6" name="faq" id="faq" 
                                      class="xxwide text input validate[required] form-control" 
                                      placeholder="Course faq"><?php echo set_value('faq'); ?></textarea>
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <?php echo form_error('suggested_reading', '<div class="error">', '</div>'); ?>
                        <label>Suggested Reading*</label>
                        <div class="field">
                            <textarea cols="6" name="suggested_reading" id="suggested_reading" 
                                      class="xxwide text input validate[required] form-control" 
                                      placeholder="Suggested reading"><?php echo set_value('suggested_reading'); ?></textarea>
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <?php echo form_error('course_format', '<div class="error">', '</div>'); ?>
                        <label>Course Format*</label>
                        <div class="field">
                            <textarea cols="6" name="course_format" id="course_format" 
                                      class="xxwide text input validate[required] form-control" 
                                      placeholder="Course format"><?php echo set_value('course_format'); ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <?php echo form_error('recommended_background', '<div class="error">', '</div>'); ?>
                        <label>Recommended Background*</label>
                        <div class="field">
                            <textarea cols="6" name="recommended_background" id="course_format" 
                                      class="xxwide text input validate[required] form-control" 
                                      placeholder="Recommended Background..."><?php echo set_value('recommended_background'); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Course Banner</label>
                        <input type="file" id="banner_url" name="banner_url" value="<?php echo set_value('banner_url') ?>" >
                    </div>

                    <div class="box-footer clearfix">

                        <button class="pull-right btn btn-default" id="add_insuere_group" >Send <i class="fa fa-arrow-circle-right"></i></button>
                    </div>   
                    <?php echo form_close() ?>
                </div>
            </div>         
        </section>
    </div>
</div>