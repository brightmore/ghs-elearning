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
                    <h3 class="box-title">Subject Content Management</h3>
                </div>
                <div class="box-body "> 
                    <?php if ($subjects): ?>

                        <?php foreach ($subjects as $key => $value): ?>
                            <div class="col-lg-12 col-md-12 col-sm-12">    
                                <h2><a href="<?php echo site_url("Subject/subject_detail/{$key}") ?>"><?php echo $value ?></a></h2>
                                <?php $subject_content = get_subject_content($key) ?>
                                <?php if ($subject_content): ?>
                                    <?php foreach ($subject_content as $value): ?>
                                        <div>
                                            <h3>  <?php echo $value->title ?></h3>
                                            <div >
                                                <?php echo character_limiter($value->summary, 200); ?>
                                            </div>
                                            <div class="alert-success">
                                                <a href="#"><i class="glyphicon glyphicon-play-circle"></i></a>  
                                                <a href="#">edit</a>
                                                <a href="#">Delete</a>
                                            </div>
                                        </div> 
                                        <hr />
                                    <?php endforeach; ?>
                                <?php else: ?>
                                        <div>
                                            <a href="<?php echo site_url("Subject/subject_detail/{$key}") ?>" class="alert-warning">add content</a>
                                        </div>
                                <?php endif; ?>
                                <div></div>
                            </div>
                        <?php endforeach; ?>

                    <?php else: ?>

                    <?php endif; ?>
                </div>
            </div>
        </section>      
        <section class="col-lg-5 connectedSortable">
            <div class="box">
                <div class="box-header">
<!-- <i class="fa fa-comments-o"></i>-->
                    <h3 class="box-title">
                        Add Subject Content
                    </h3> 
                    <hr >
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
                        <label>Content Type</label>
                        <div>
                            <select name="content">
                                <option value="Video">Video</option>
                                <option value="pdf">PDF</option>
                                <option value="webResource">Web Resource</option>
                                <option value="Audio">Audio</option>
                                <option value="text_html">Text/html</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Summary*</label>
                        <div class="field">
                            <textarea rows="8" name="summary" id="content" 
                                      class="xxwide text input validate[required] form-control" 
                                      placeholder="Summary..."><?php echo set_value('summary'); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div>
                            <label>Video Intro of the subject</label>
                            <input type="file" id="user_file" name="user_file" value="<?php echo set_value('user_file') ?>" >
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

