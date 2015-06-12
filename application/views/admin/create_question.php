
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
                    
                    <form id="question-maker">
                        <div class="form-group">
                            <label>Subjects</label>
                            <select name="subjects" id="subjects">
                                <?php foreach ($subjects as $key=> $value): ?>
                                <option value="<?php echo $key?>"><?php echo $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="question">
                            <div class="form-group">
                                <label>Quiz Type</label>
                                <select name="question_as" id="question_type">
                                    <option value="0">Select...</option>
                                    <option value="1">Pretest</option>
                                    <option value="2">Post Test</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Question Mode</label>
                                <select name="question_type" id="question_type">
                                    <option value="0" >Select...</option>
                                    <option value="1">Text</option>
                                    <option value="2">Image</option>
                                </select>
                            </div>
                            <div id="question_text" class="form-group">
                                <textarea class="text input form-control" cols="3" name="quetion_text" placeholder="Enter question here..."></textarea>
                            </div>
                            <div id="question_image" class="form-group">
                               
                                    <label>Figure</label>
                                    <input type="file" name="question_image" id="question_image_id" >
                        
                                <div>
                                    <label>Extra</label>
                                    <textarea class="text input form-control" cols="3" name="quetion_text" placeholder="Enter question here..."></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Hint</label>
                                <div class="field">
                                    <input type="text" name="hint" id="hint" class="input text form-control" >
                                </div>
                            </div>
                        </div>

                        <div class="answers">
                            <fieldset>
                                <legend>Answers to the Question</legend>
                                <div class="field">
                                    <label>A. </label>
                                    <textarea class="text input form-control" cols="2" name="answerA" id="answerA" placeholder="Enter question here..."></textarea>
                                </div>
                                <div class="field">
                                    <label>B. </label><input type="text" name="answerB" id="answerB" class="text input form-control" >
                                </div>
                                <div class="field">
                                    <label>C. </label><input type="text" name="answerC" id="answerC" class="text input form-control" >
                                </div>
                                <div class="field">
                                    <label>D. </label><input type="text" name="answerD" id="answerD" class="text input form-control" >
                                </div>
                                <div class="field">

                                </div>
                            </fieldset>
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