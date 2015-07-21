<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Messaging</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tabbable">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab1" data-toggle="tab">Courses</a></li>
                                    <li><a href="#tab2" data-toggle="tab">Instructors</a></li>
                                    <li><a href="#tab3" data-toggle="tab">Student</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <!--<h3>Manage Subject</h3>-->
                                        <div class="row">
                                        <div class="col-lg-12">
                                           
                                            <?php if ($courses): ?>

                                                <?php echo form_open_multipart("index.php/Messager/process_sending_courses", array("class" => "form-horizontal")) ?>
                                                <?php echo form_hidden($csrf); ?>
                                                <div class="form-group">
                                                    <?php foreach ($courses as $value) { ?>
                                                    <div class="form-group">
                                                        <label><input type="checkbox" name="courses[]"  value="<?php echo $value->course_id ?>" ><?php echo $value->course_name ?></label>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" name="title" id="title" class="form-control" >
                                            </div>
                                                <div id="message_form" class="form-group">
                                                    <label>Message</label>
                                                    <textarea class="form-control" id="message" name="message" placeholder="Enter message here..."></textarea>
                                                </div>
                                                <hr />
                                                <div class="form-group">
                                                    <button class="btn btn-primary" name="send" id="send_message">Send <i class="glyphicon glyphicon-send"></i></button>
                                                </div>
                                                  <?php echo form_close() ?>
                                            <?php else: ?>
                                                <div class="alert alert-info">
                                                    Please add course to the system. 
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        </div> <!-- /end of add subject content -->
                                    </div> <!--- end of tab -->
                                    <div class="tab-pane" id="tab2">
                                        <div class="col-lg-12">
                                            <!--<h3> Instructors</h3>-->
                                            <div class="col-lg-6">
<!--                                                <ul class="nav nav-pills">
                                                    <li role="presentation" class="active"> <a href="#" id="add_instructor" class="">Add</a> </li>
                                                    <li role="presentation"> <a href="#" id="remove_instructor">Remove</a></li>
                                                    <li role="presentation"> <a href="#" id="send_mail" >Send Message</a></li>
                                                    <li role="presentation">  <a href="#" id="send_email" >Send Email</a></li>

                                                </ul>-->
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="Search for...">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">Go!</button>
                                                        </span>
                                                    </div><!-- /input-group -->
                                                </div>
                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-lg-12">
                                                <?php if ($instructors): ?>
                                                    <?php echo form_open('index.php/Messager/process_sending_instructor', array('id' => 'add_instructor', 'class' => '')) ?>
                                                    <?php echo form_hidden($csrf); ?>
                                                    <table class="table table-striped table-hover table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 30px"><input type="checkbox" id="check_instructors" name="check_instructors" /></th>
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
                                                <hr />
                                                 <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title" id="title" class="form-control">
                                                </div>
                                                    <div id="message_form" class="form-group">
                                                        <textarea class="form-control" id="message" placeholder="Enter message here..."></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <button class="btn btn-primary" name="send_message" id="send_message">Send <i class="glyphicon glyphicon-send"></i></button>
                                                    </div>
                                                    <?php echo form_close(); ?>
                                                <?php else: ?>
                                                    <div class="alert alert-info">
                                                        Please add moderator and instructor or faculty member
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab3">

                                        <?php if ($students): ?>
                                            <div class="row">
                                                <div class="col-lg-6">
<!--                                                    <ul class="nav nav-pills">
                                                        <li role="presentation"> <a href="#" id="remove_instructor">Remove</a></li>
                                                        <li role="presentation"> <a href="#" id="student_send_mail" >Send Message</a></li>
                                                        <li role="presentation">  <a href="#" id="student_send_email" >Send Email</a></li>
                                                        <li role="presentation"><a href="#" id="banned">Banned</a></li>
                                                    </ul>-->
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
                                                <?php echo form_open('index.php/Messager/process_student_message', array('id' => 'student_messaging', 'class' => '')) ?>
                                                <?php echo form_hidden($csrf); ?>
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
                                                                    <input type="checkbox" name="students[]" value="<?php echo $value->id ?>" />
                                                                </td>
                                                                <td><?php echo $value->username ?></td>
                                                                <td><?php echo $value->institution ?></td>
                                                                <td><?php echo $value->phone ?></td>
                                                                <td><?php echo $value->email ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                                <hr />
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title" id="title" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" name="message" id="message" placeholder="Enter message here..."></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-primary" id="send_message">Send <i class="glyphicon glyphicon-send"></i></button>
                                                </div>
                                                <?php echo form_close() ?>

                                            </div>
                                        <?php else: ?> 
                                            <div class="alert alert-info">
                                                There is no participant registered in the system 
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>