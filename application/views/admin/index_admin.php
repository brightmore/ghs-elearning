<!-- Main content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
<!--                                    <i class="fa fa-comments-o"></i>-->
                    <h3 class="box-title">Quick Statistics</h3>
                </div>
                <div class="box-body"> 
                    <div class="row">
                        
                        <div class="col-lg-3">
                            <div style="background-color: #00ca6d; color: #FFF; height: 80px; padding: 10px;text-align: center">
                                <span style="font-size: 2em"> <?php echo $total_courses ?></span>
                                <span style="font-size: 2em;position:absolute; left:40px;">Courses</span> 
                                
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div style="background-color: #7adddd; height: 80px;padding: 10px;color: #FFF; text-align: center">
                              <span style="font-size: 2em;"> <?php echo $total_course_takers ?></span>  <span style="font-size: 2em">Course takers</span>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div style="background-color: #F4A460; height: 80px; padding: 10px; color: #FFF">
                                <span style="font-size: 2em;"><?php echo $total_students ?></span> <span style="font-size: 2em">Participants</span>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div style="background-color: salmon; height: 80px;padding: 10px; color: #FFF">
                          <span style="font-size: 2em;"> <?php echo $faculty_total ?></span>  <span style="font-size: 2em;">faculty</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">  
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Category Structure</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php if ($catalogue): ?>
                            <?php foreach ($catalogue as $value) { ?>
                                <div class="tree col-lg-6 col-md-6 col-sm-6">
                                    <ul>
                                        <li>
                                            <a href="#"><?php echo $value->cat_name ?> :: Category</a>
                                            <?php $courses = get_courses_category($value->cat_id) ?>
                                            <?php if ($courses): ?>
                                                <ul>
                                                    <?php foreach ($courses as $course): ?>
                                                        <li><a href="<?php echo base_url('index.php/public/Frontier/course_details/' . $course->course_id); ?>"><?php echo $course->course_name ?> :: Course</a>
                                                            <?php $course_outline = getCourseSubject($course->course_id); ?>
                                                            <?php if ($course_outline): ?>
                                                                <ul>
                                                                    <?php foreach ($course_outline as $row) { ?>
                                                                        <li><a href="<?php echo base_url('index.php/public/Frontier/subject_details/' . $row->subject_id); ?>"><?php echo $row->subject_name ?></a></li>
                                                                    <?php } ?>
                                                                </ul>
                                                            <?php endif; ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?> 
                                            </div>
                                        <?php } ?>

                                    <?php else: ?>

                                    <?php endif; ?>
                                    </div>
                                    </div>
                                    </div>
                                    </section>
                                    <section class="col-lg-6 connectedSortable">
                                        <div class="box">
                                            <div class="box-header">
                                                <div class="box-title">
                                                    <h3>Add Category</h3>
                                                </div>
                                            </div>
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div id="smessage">
                                                            <?php
                                                            echo validation_errors();
                                                            echo $this->session->flashdata('smessage');
                                                            ?>
                                                        </div>
                                                        <?php echo form_open_multipart('/Courses/process_category_form') ?> 
                                                        <?php echo form_hidden($csrf); ?>
                                                        <div class="form-group">
                                                            <label>Course Name*</label>
                                                            <div class="field">
                                                                <input name="category_name" id="category_name" type="text"  
                                                                       class="xxwide text input validate[required] 
                                                                       form-control" placeholder="Course id" value="" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Course description*</label>
                                                            <div class="field">
                                                                <input name="description" id="description" type="text"  
                                                                       class="xxwide text input validate[required] 
                                                                       form-control" placeholder="Course description" value="" />
                                                            </div>
                                                        </div>
                                                      
                                                        <div class="form-group">
                                                            <input type="file" id="logo" name="userfile" value="" >
                                                        </div>

                                                        <div class="box-footer clearfix">
                                                            <button class="pull-right btn btn-default" id="add_insuere_group" value="">Send <i class="fa fa-arrow-circle-right"></i></button>
                                                        </div>   
                                                        <?php echo form_close() ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </section>
                                    </div>
                                    </div>