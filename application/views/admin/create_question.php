
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
                <div class="box-body"> 
                    
                    <?php if(isset($subjects)): ?>
                    
                    <?php echo form_open_multipart('index.php/Questions/process_new_question') ?>
                     <?php echo form_hidden($csrf); ?>
                        <div class="form-group">
                            <label>Subjects</label>
                            <select name="subject_id" id="subject_id">
                                <option value="">Select Subject...</option>
                                <?php foreach($subjects as $key=> $value): ?>
                                <option value="<?php echo $key?>"><?php echo $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="question">
                            <div class="form-group">
                                <label>Quiz Type</label>
                                <select name="question_type" id="question_type">
                                    <option value="">Select quiz type...</option>
                                    <option value="pretest">Pretest</option>
                                    <option value="posttest">Post Test</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Question Mode</label>
                                <select name="question_mode" id="question_mode">
                                    <option value="" >Select...</option>
                                    <option value="text">Text</option>
                                    <option value="image">Image</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Time Span</label>
                                <input type="text"  name="time_span" id="hint" value="<?php echo set_value("time_span") ?>">
                                <span class="alert-danger">Total number seconds you should answer to the question</span>
                            </div>
                            
                            <div id="question_text" class="form-group">
                                <textarea class="text input form-control" cols="3" name="question_text" placeholder="Enter question here..."><?php echo set_value("question_text")?></textarea>
                            </div>
                            <div id="question_image" class="form-group">
                               
                                    <label>Figure</label>
                                    <input type="file" name="question_image" id="question_image_id" >
                        
                                <div>
                                    <label>Extra</label>
                                    <textarea class="text input form-control" 
                                              cols="3" name="extra" 
                                              placeholder="Enter question here..."><?php echo set_value('extra') ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Hint</label>
                                <div class="field">
                                    <input type="text" 
                                           name="hint" id="hint" 
                                           class="input text form-control"  
                                           value="<?php echo set_value('hint')?>">
                                </div>
                            </div>
                        </div>

                        <div class="answers">
                            <fieldset>
                                <legend>Answers to the Question</legend>
                                <div class="field">
                                    <label>A. </label>
                                    <textarea class="text input form-control" 
                                              cols="2" name="answerA" 
                                              id="answerA" placeholder="Enter answer here..."><?php echo set_value('answerA') ?></textarea>
                                </div>
                                <div class="field">
                                    <label>B. </label>
                                    <textarea name="answerB" id="answerB" 
                                              class="text input form-control" 
                                              placeholder="Enter answer here..."><?php echo set_value('answerB') ?></textarea>
                                </div>
                                <div class="field">
                                    <label>C. </label>
                                    <textarea name="answerC" id="answerC" 
                                              class="text input form-control"
                                              placeholder="Enter answer here..."><?php echo set_value('answerC') ?></textarea>
                                </div>
                                <div class="field">
                                    <label>D. </label>
                                    <textarea name="answerD" id="answerD" 
                                              class="text input form-control" 
                                              placeholder="Enter answer here..."><?php echo set_value('answerD') ?></textarea>
                      
                                </div>
                                <div class="field">
                                    <div> <label><input type="radio" name="answers" value="a" >Answer A</label></div>
                                    <div><label><input type="radio" name="answers" value="b" >Answer B</label></div>
                                    <div><label><input type="radio" name="answers" value="c" >Answer C</label></div>
                                    <div><label><input type="radio" name="answers" value="d" >Answer D</label></div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="box-footer clearfix">

                        <button class="pull-right btn btn-github" id="add_insuere_group" >Send <i class="fa fa-arrow-circle-right"></i></button>
                    </div> 
                    </form>
                    <?php else: ?>
                    <div class="alert alert-danger">
                        There is no subject added on this platform, Please add subject first. 
                        <a href="<?php echo site_url('subject'); ?>">Add subject</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>      
        <section class="col-lg-5 connectedSortable">
            <div class="box">
                <div class="box-header">
<!--                                    <i class="fa fa-comments-o"></i>-->
                    <h3 class="box-title"> Courses</h3> <hr >
                </div>
                <div class="box-body">
                    <div id="smessage">
                        <?php
                        echo validation_errors();
                        echo $this->session->flashdata('smessage');
                        ?>
                    </div>

                    <?php if (isset($courses)): ?>
                        <ul>
                            <?php foreach ($courses as $value): ?>
                                <li><?php echo $value->course_name ?>

                                    <?php $subjects = getCourseSubject($value->course_id) ?>
                                    <?php if (isset($subjects)): ?>
                                        <ul>
                                            <?php foreach ($subjects as $row): ?>
                                                <li>
                                                    <a href="<?php echo site_url("Questions/showSubjectQuestion/{$row->subject_id}/{$row->subject_name}") ?>">
                                                        <?php echo $row->subject_name ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif;
                                    ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                    <div class="alert alert-info">
                        There is no course added in this platform, please add course. <a href="<?php echo site_url("Coures/") ?>">Click Here to add a course</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>         
        </section>
    </div>
</div> 