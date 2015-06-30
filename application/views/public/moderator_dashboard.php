<div class="col-lg-12">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Manage Course</a></li>
            <li><a href="#tab2" data-toggle="tab">Manage Instructors</a></li>
            <li><a href="#tab3" data-toggle="tab">Manage Student</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                <h3>Manage Subject</h3>
                <div class="col-lg-6">
                    <?php echo form_open_multipart("index.php/public/Frontier/process_add_subject_content", array("class" => "form-horizontal")) ?>
                    <?php echo form_hidden($csrf); ?>

                    <div class="form-group">
                        <label>Title*</label>
                        <div class="field">
                            <input name="title" id="title" type="text"  
                                   class="xxwide text input validate[required] form-control" 
                                   placeholder="Title" value="<?php echo set_value('title'); ?>" />
                        </div>
                    </div>
                    <?php if (isset($subjects)): ?>
                        <div class="form-group">
                            <label>Subjects</label>
                            <div class="field">
                                <?php echo form_dropdown('subject_id', $subjects) ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Video Type</label>
                        <div>
                            <select name="video-type">
                                <option value="">Select...</option>
                                <option value="html5-comp">Html5 Video</option>
                                <option value="youtube">Youtube</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Summary*</label>
                        <div class="field">
                            <textarea rows="3" name="summary" id="content" 
                                      class="xxwide text input validate[required] form-control" 
                                      placeholder="Summary..."><?php echo set_value('summary'); ?></textarea>
                        </div>
                    </div>
                    <fieldset><legend>Study Material</legend>
                        <div class="form-group">
                            <div>
                                <label>Video mp4:</label>
                                <input type="file" id="video_mp4" name="video_mp4"  value="<?php echo set_value('video_mp4') ?>" >
                            </div>
                            <div>
                                <label>Video webm:</label>
                                <input type="file" id="video_webm" name="video_webm" value="<?php echo set_value('video_webm') ?>" >
                            </div>
                            <div>
                                <label>Video ogg:</label>
                                <input type="file" id="video_ogg" name="video_ogg" value="<?php echo set_value('video_ogg') ?>" >
                            </div>
                            <div>
                                <label>PDF:</label>
                                <input type="file" id="video_ogg" name="video_ogg" value="<?php echo set_value('video_ogg') ?>" >
                            </div>
                            <div class="field">
                                <label>Youtube Video Url</label>
                                <div>
                                    <textarea cols="3" class="form-control input text" placeholder="Paste or Enter youtube video url here..." name="youtubeVideo" id="youtubeVideo"></textarea>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="box-footer clearfix">

                        <input type="reset" class="pull-right btn btn-default" id="add_insuere_group" value="Clear">
                        <input type="submit" class="pull-right btn btn-default" id="add_content" value="Add Content">&nbsp;&nbsp;
                    </div>   
                    <?php echo form_close() ?>
                </div> <!-- /end of add subject content -->

                <div class="col-lg-6">
                    <div>
                        <?php if ($subject_content): ?>
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($subject_content as $value) { ?>
                                        <tr>
                                            <td><a href="<?php echo base_url() . 'index.php/public/Frontier/subject_content/' . $value->id ?>" ><?php echo $value->title ?></a></td>
                                            <td>
                                                <a href="#"><i class="glyphicon glyphicon-remove-sign"></i></a>
                                                <a href="<?php echo base_url() . 'index.php/public/Frontier/subject_content/' . $value->id ?>"><i class="glyphicon glyphicon-eye-open"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab2">
                <div class="col-lg-12">

                    <h3>Manage Instructors</h3>

                    <div class="col-lg-6">
                        <ul class="nav nav-pills">
                            <li role="presentation" class="active"> <a href="#" id="add_instructor" class="">Add</a> </li>
                            <li role="presentation"> <a href="#" id="remove_instructor">Remove</a></li>
                            <li role="presentation"> <a href="#" id="send_mail" >Send Message</a></li>
                            <li role="presentation">  <a href="#" id="send_email" >Send Email</a></li>

                        </ul>
                    </div>

                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div><!-- /btn-group -->

                            </div>

                            <div class="input-group col-lg-8">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Go!</button>
                                </span>
                            </div><!-- /input-group -->

                        </div>

                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-12">
                        <?php echo form_open('index.php/public/Frontier/process_add_instructor_to_course', array('id' => 'add_instructor', 'class' => '')) ?>

                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 30px"></th>
                                    <th>Name</th>
                                    <th>Institution/Facility</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php foreach ($instructors as $value): ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="instructors[]" value="<?php echo $value->id ?>" />
                                        </td>
                                        <td><?php echo $value->username ?></td>
                                        <td><?php echo $value->institution ?></td>
                                        <td><?php echo $value->phone ?></td>
                                        <td><?php echo $value->email ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <?php echo form_close(); ?>

                        <div id="message_form">
                            <textarea class="form-control" id="message" placeholder="Enter message here..."></textarea>
                            <button class="btn btn-primary" id="send_message">Send <i class="glyphicon glyphicon-send"></i></button>
                        </div>

                        <div id="email_form">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" id="message_title" name="message_title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea class="form-control" name="message_body" id="message_body"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Attachment</label>
                                <input type="file" name="userfile" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="tab3">
               
                    <?php if ($students): ?>
                 <div class="row">
                    <h3>Managing Students</h3>
                        <div class="col-lg-6">
                            <ul class="nav nav-pills">
                                <li role="presentation"> <a href="#" id="remove_instructor">Remove</a></li>
                                <li role="presentation"> <a href="#" id="student_send_mail" >Send Message</a></li>
                                <li role="presentation">  <a href="#" id="student_send_email" >Send Email</a></li>
                                <li role="presentation"><a href="#" id="banned">Banned</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Go!</button>
                                </span>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                    </div>

                    <div class="row">
                        <?php echo form_open('index.php/public/Frontier/process_add_instructor_to_course', array('id' => 'add_instructor', 'class' => '')) ?>
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 30px"></th>
                                    <th>Name</th>
                                    <th>Institution/Facility</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php foreach ($students as $value): ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="instructors[]" value="<?php echo $value->id ?>" />
                                        </td>
                                        <td><?php echo $value->username ?></td>
                                        <td><?php echo $value->institution ?></td>
                                        <td><?php echo $value->phone ?></td>
                                        <td><?php echo $value->email ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                        <div id="student_message_form">
                            <textarea class="form-control" id="message" placeholder="Enter message here..."></textarea>
                            <button class="btn btn-primary" id="send_message">Send <i class="glyphicon glyphicon-send"></i></button>
                        </div>

                        <div id="student_email_form">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" id="message_title" name="message_title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea class="form-control" name="message_body" id="message_body"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Attachment</label>
                                <input type="file" name="userfile" >
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" id="send_message">Send <i class="glyphicon glyphicon-send"></i></button>
                            </div>
                        </div>
                        <?php echo form_close() ?>

                    </div>
                <?php else: ?> 

                <?php endif; ?>
            </div>
        </div>
    </div>   
</div>