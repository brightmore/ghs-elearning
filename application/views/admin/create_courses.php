 <?php 
                    $id= isset($update_data["id"]) ? $update_data["id"] : "";
                    $course_id= isset($update_data["course_id"]) ? $update_data["course_id"] : "";
                    $course_description= isset($update_data["course_description"]) ? $update_data["course_description"] : "";
                    $banner_url= isset($update_data["banner_url"]) ? $update_data["banner_url"] : "";
                    $course_type= isset($update_data["course_type"]) ? $update_data["course_type"] : "";
                    $category_id= isset($update_data["category_id"]) ? $update_data["category_id"] : "";

$btn_msg = ($id == 0) ? "ADD" : " Update";
$title_msg = ($id == 0) ? "Create" : " Update";
?>


<script type="text/javascript" >
    $(document).ready(function() {

        $('#courses').validationEngine('attach', {scroll: false, addFailureCssClassToField: 'inputbox-error'});
    });
</script>


<div class="row">
<div class="col-lg-12">


             <h3 class="text-muted"><?php echo $title_msg; ?> Courses</h3> 
                


                                <div id="smessage">
                                    <?php echo validation_errors();
                                           echo $this->session->flashdata('smessage');
                                    ?>

                                </div>



                                <form action="" method="post"  class="form-group"  name="courses" id="courses">
                                    <?php
                                    if ($id != 0) {
                                        echo '<input name="id" id="id" type="hidden" value="' . $id . '" />';
                                    }
                                    ?>   <div class="col-lg-4">  
                                    <label>Course id*</label>
                                    <div class="field">

                                        <input name="course_id" id="course_id" type="text"  class="xxwide text input validate[required] form-control" placeholder="Course id" value="<?php echo $course_id; ?>" />

 
                                    </div>
                             </div>   <div class="col-lg-4">  
                                    <label>Course description*</label>
                                    <div class="field">

                                        <input name="course_description" id="course_description" type="text"  class="xxwide text input validate[required] form-control" placeholder="Course description" value="<?php echo $course_description; ?>" />

 
                                    </div>
                             </div>   <div class="col-lg-4">  
                                    <label>Banner url*</label>
                                    <div class="field">

                                        <input name="banner_url" id="banner_url" type="text"  class="xxwide text input validate[required] form-control" placeholder="Banner url" value="<?php echo $banner_url; ?>" />

 
                                    </div>
                             </div>   <div class="col-lg-4">  
                                    <label>Course type*</label>
                                    <div class="field">

                                        <input name="course_type" id="course_type" type="text"  class="xxwide text input validate[required] form-control" placeholder="Course type" value="<?php echo $course_type; ?>" />

 
                                    </div>
                             </div>   <div class="col-lg-4">  
                                    <label>Category id*</label>
                                    <div class="field">

                                        <input name="category_id" id="category_id" type="text"  class="xxwide text input validate[required] form-control" placeholder="Category id" value="<?php echo $category_id; ?>" />

 
                                    </div>
                             </div>   
                                          
                                            
                                            
                                            
                                                   
                                    <div class="col-lg-2" style="padding-top: 2.2%">
                                        <input name="insured_group"
                                               id="add_insuere_group" class="btn  btn-default" value="<?php echo $btn_msg ?>" type="submit" />
                                    </div>
                                   
                                            
                                    

                                   
                                </form>




    </div>
</div>  <script>


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
            success: function(json) {
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
            error: function() {
                alert("Something Went wrong...");
            }
        });


    }


    $(document).ready(function() {
        $("#smessage").hide();
        $('#courses').submit(save_data);
      


    });


</script>


