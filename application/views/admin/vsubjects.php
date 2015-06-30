<?php
$id = isset($update_data["id"]) ? $update_data["id"] : "";
$subject_id = isset($update_data["subject_id"]) ? $update_data["subject_id"] : "";
$course_id = isset($update_data["course_id"]) ? $update_data["course_id"] : "";
$subject_name = isset($update_data["subject_name"]) ? $update_data["subject_name"] : "";
$slug = isset($update_data["slug"]) ? $update_data["slug"] : "";
$description = isset($update_data["description"]) ? $update_data["description"] : "";
$rank = isset($update_data["rank"]) ? $update_data["rank"] : "";
$video_intro = isset($update_data["video_intro"]) ? $update_data["video_intro"] : "";
$instructors_ids = isset($update_data["instructors_ids"]) ? $update_data["instructors_ids"] : "";

$btn_msg = ($id == 0) ? "ADD" : " Update";
$title_msg = ($id == 0) ? "Create" : " Update";
?>


<script type="text/javascript" >
    $(document).ready(function () {

        $('#Subject').validationEngine('attach', {scroll: false, addFailureCssClassToField: 'inputbox-error'});
    });
</script>


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
                <div class="box-body"> 
                    <?php foreach ($subjects as $row): ?>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                            <h3><?php echo $row->course_type ?></h3>
                            <ul>
                                <li><a href="#"><?php echo $row->cat_name ?></a> >></li>
                                <li><a href="#"><?php echo $row->course_name ?></a> >></li>
                                <li><a href="#"><?php echo $row->subject_name ?></a></li>
                            </ul>
                            <div class="_item">
                                <?php echo character_limiter($row->description, 200) ?>
                            </div>
                            <hr >
                            <div class="moderator">
                                <h4>Moderator</h4>
                                <?php $moderator = getModerator($row->course_id); ?>
                                <ul>
                                    <li>
                                        <label>Name: </label> <?php echo $moderator->salutation . '. ' . $moderator->last_name . ' ' . $moderator->first_name ?>
                                    </li>
                                    <li>
                                        <label>Institution: </label><?php echo $moderator->institution ?>
                                    </li>
                                    <li>
                                        <label>Email: </label><a href="mailto:<?php echo $moderator->email ?>"><?php echo $moderator->email ?></a>
                                    </li>
                                </ul>
                            </div>
                            <hr >
                            <div class="course_action pull-right">
                                <a href="<?php echo site_url('Subject/subject_detail/' . $row->subject_id) ?>" id="view_course_detail" ><i class="glyphicon glyphicon-floppy-open"></i></a>
                                <a href="<?php echo base_url('Subject/edit_subject/' . $row->subject_id) ?>" id="edit_course"><i class="glyphicon glyphicon-edit"></i></a>
                                <a href="<?php echo base_url('Subject/delete_subject/' . $row->subject_id) ?>" id="delete_course"><i class="glyphicon glyphicon-remove"></i></a>
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

                    <?php echo form_open_multipart("Subject/process_form") ?>
                                        <?php echo form_hidden($csrf); ?>

                    <div class="form-group">
                        <label>Subject Name*</label>
                        <div class="field">
                            <input name="subject_name" id="subject_name" type="text"  class="xxwide text input validate[required] form-control" placeholder="Subject name" value="<?php echo $subject_id; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Course</label>
                        <div class="field">
                            <?php echo form_dropdown('course_id', $courses) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Slug*</label>
                        <div class="field">
                            <input name="slug" id="slug" type="text"  class="xxwide text input validate[required] form-control" placeholder="Slug" value="<?php echo $slug; ?>" /> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Rank</label>
                        <div class="field">
                            <input name="rank" id="rank" type="text"  class="xxwide text input validate[required] form-control" placeholder="Rank" value="<?php echo $rank; ?>" /> 
                        </div>
                        <div class="alert alert-info">
                            Ranking determines the order in which subjects under course should follow when taking the course. it means subjects with lower rank should be taken first.<br>
                            Or leave it blank to be taken at any time without following any order.
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Subject summary*</label>
                        <div class="field">
                            <textarea rows="8" name="subject_description" id="subject_description" 
                                      class="xxwide text input validate[required] form-control" 
                                      placeholder="Subject Description..."><?php echo set_value('subject_description'); ?></textarea>
                        </div>
                    </div>

<!--                    <div class="form-group">
                        <label>Video Intro Type</label>
                        <div class="field">
                            <select id="video_type" name="video_type">
                                <option value="">Select Video Type</option>
                                <option value="html5-comp">MP4</option>
                                <option value="youtube">Youtube</option>
                            </select>
                        </div>
                    </div>-->
                     <div class="form-group">
                        <label>Instructors</label>
                        <div> <?php echo form_multiselect('instructors',$instructors); ?></div>
<!--                        <div class="alert-info alert">
                            Moderator is  an instructor or a faculty member who is in charge of the course.
                        </div>-->
                    </div>
                    <div class="form-group">
                        <div>
                            <label>Video Intro of the subject</label>
                            <input type="file" id="video_url" name="video_url" value="<?php echo set_value('video_url') ?>" >
                        </div>
                        <div class="field">
                            <label>Youtube Video Url</label>
                            <div>
                                <textarea cols="3" class="form-control input text" placeholder="Paste or Enter youtube video url here..." name="youtubeVideo" id="youtubeVideo"></textarea>
                            </div>
                        </div>
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


<script>
    function save_data(e) {
        e.stopPropagation();
        e.preventDefault();
        var thisdata = $(e.target);

        var valid = jQuery('#Subject').validationEngine('validate');


        if (valid == false) {
            return false;

        }
        $.ajax({
            type: "post",
            url: base_url + "/Subject/process_form",
            cache: false,
            data: $('#Subject').serialize(),
            success: function (json) {
                var obj = jQuery.parseJSON(json);
                var status = obj['is_error'];
                var is_redirect = obj['is_redirect'];
                var error_count = obj['error_count'];

                if (status == false) {


                    $('form input:text,form textarea').val('');

                    $('#smessage').html(obj['data']);
                    $('#smessage').addClass("secondary").removeClass('danger');
                    $('#smessage').show();
                    if (is_redirect == true) {
                        window.location = base_url + '/Subject';
                    }
                } else {
                    if (is_redirect == true) {
                        window.location = base_url + '/Subject';
                    }
                    if (error_count != 0) {
                        $("#smessage").html("There are " + error_count + "  errors.please fix all");
                    } else {
                        $("#smessage").html("");
                    }
                    $("#smessage").append(obj["data"]);
                    $("#smessage").addClass("danger").removeClass("secondary");
                    $("#smessage").show();
                }
            },
            error: function () {
                alert("Something Went wrong...");
            }
        });


    }


    $(document).ready(function () {
        $("#smessage").hide();
        $('#Subject').submit(save_data);



    });


</script>

