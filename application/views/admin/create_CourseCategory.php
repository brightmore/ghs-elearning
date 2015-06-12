<?php
$id = isset($update_data["id"]) ? $update_data["id"] : "";
$course_id = isset($update_data["course_id"]) ? $update_data["course_id"] : "";
$course_description = isset($update_data["course_description"]) ? $update_data["course_description"] : "";
$banner_url = isset($update_data["banner_url"]) ? $update_data["banner_url"] : "";
$course_type = isset($update_data["course_type"]) ? $update_data["course_type"] : "";
$category_id = isset($update_data["category_id"]) ? $update_data["category_id"] : "";

$btn_msg = ($id == 0) ? "ADD" : " Update";
$title_msg = ($id == 0) ? "Create" : " Update";

?>


<script type="text/javascript" >
    $(document).ready(function () {

        $('#courses').validationEngine('attach', {scroll: false, addFailureCssClassToField: 'inputbox-error'});
    });
</script>

<!-- Right side column. Contains the navbar and content of the page -->
    <!-- Main content -->
        <div class="container">
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">  
                    <div class="box">
                        <div class="box-header">
    <!--                                    <i class="fa fa-comments-o"></i>-->
                            <h3 class="box-title">Course Category Management</h3>
                        </div>
                        <div class="box-body table-responsive" style="height:800px; overflow:auto"> 
                                <table id="courseTable" class="table table-bordered table-hover">
                                     <thead>
                                            <tr>
                                                <th style="width:20%">Cat Name</th>
                                                <th style="width:20%">Courses Under it</th>
                                                <th style="width:20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            <?php foreach ($categories as $row): ?>
                                            <tr>
                                                <td><?php echo $row->cat_name ?></td>
                                                <td>
                                                    <ul>
                                                    <?php foreach (getCourses($row->cat_id) as $value): ?> 
                                                        <li><?php echo $value->course_name ?></li>
                                                      <?php endforeach; ?>  
                                                    </ul>
                                                </td>
                                            </tr> 
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
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
                                        <input name="course_id" id="course_id" type="text"  class="xxwide text input validate[required] form-control" placeholder="Course id" value="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Course description*</label>
                                    <div class="field">
                                        <input name="course_description" id="course_description" type="text"  class="xxwide text input validate[required] form-control" placeholder="Course description" value="<?php echo $course_description; ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Course type*</label>
                                    <div class="control-group">
                                        <label><input type="radio" name="course_type" id="general" value="general">General</label> 
                                         <label><input type="radio" name="course_type" id="general" value="specialize">Specialize</label> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="file" id="banner_url" name="banner_url" value="<?php echo $banner_url?>" >
                                </div>

                                <div class="box-footer clearfix">
                                    
                                    <button class="pull-right btn btn-default" id="add_insuere_group" value="<?php echo $btn_msg ?>">Send <i class="fa fa-arrow-circle-right"></i></button>
                                </div>   
                            </form>
                        </div>
                    </div>         
                </section><!-- /.content -->
              
        <script>
                    function save_data(e) {
                        e.stopPropagation();
                        e.preventDefault();
                        var thisdata = $(e.target);

                        var valid = jQuery('#courses').validationEngine('validate');


                        if (valid == false) {
                            return false;
                        }
                        $.ajax({
                            type: "post",
                            url: base_url + "/courses/process_form",
                            cache: false,
                            data: $('#courses').serialize(),
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
                                        window.location = base_url + '/courses';
                                    }
                                } else {
                                    if (is_redirect == true) {
                                        window.location = base_url + '/courses';
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
                        $('#courses').submit(save_data);
                    });
                </script>


