 <?php 
                    $id= isset($update_data["id"]) ? $update_data["id"] : "";
                    $subtopic_id= isset($update_data["subtopic_id"]) ? $update_data["subtopic_id"] : "";
                    $topic_id= isset($update_data["topic_id"]) ? $update_data["topic_id"] : "";
                    $subtopic_name= isset($update_data["subtopic_name"]) ? $update_data["subtopic_name"] : "";
                    $slug= isset($update_data["slug"]) ? $update_data["slug"] : "";
                    $description= isset($update_data["description"]) ? $update_data["description"] : "";
                    $content_type= isset($update_data["content_type"]) ? $update_data["content_type"] : "";
                    $image= isset($update_data["image"]) ? $update_data["image"] : "";
                    $content= isset($update_data["content"]) ? $update_data["content"] : "";
                    $rank= isset($update_data["rank"]) ? $update_data["rank"] : "";

$btn_msg = ($id == 0) ? "ADD" : " Update";
$title_msg = ($id == 0) ? "Create" : " Update";
?>


<script type="text/javascript" >
    $(document).ready(function() {

        $('#CourseContent').validationEngine('attach', {scroll: false, addFailureCssClassToField: 'inputbox-error'});
    });
</script>


<div class="row">
<div class="col-lg-12">
             <h3 class="text-muted"><?php echo $title_msg; ?> Course Content</h3> 
               
                                <div id="smessage">
                                    <?php echo validation_errors();
                                           echo $this->session->flashdata('smessage');
                                    ?>

                                </div>

                                <form action="" method="post"  class="form-group"  name="CourseContent" id="CourseContent">
                                    <?php
                                    if ($id != 0) {
                                        echo '<input name="id" id="id" type="hidden" value="' . $id . '" />';
                                    }
                                    ?>   <div class="col-lg-4">  
                                    <label>Subtopic id*</label>
                                    <div class="field">

                                        <input name="subtopic_id" id="subtopic_id" type="text"  class="xxwide text input validate[required] form-control" placeholder="Subtopic id" value="<?php echo $subtopic_id; ?>" />

 
                                    </div>
                             </div>   <div class="col-lg-4">  
                                    <label>Topic id*</label>
                                    <div class="field">

                                        <input name="topic_id" id="topic_id" type="text"  class="xxwide text input validate[required] form-control" placeholder="Topic id" value="<?php echo $topic_id; ?>" />

 
                                    </div>
                             </div>   <div class="col-lg-4">  
                                    <label>Subtopic name*</label>
                                    <div class="field">

                                        <input name="subtopic_name" id="subtopic_name" type="text"  class="xxwide text input validate[required] form-control" placeholder="Subtopic name" value="<?php echo $subtopic_name; ?>" />

 
                                    </div>
                             </div>   <div class="col-lg-4">  
                                    <label>Slug*</label>
                                    <div class="field">

                                        <input name="slug" id="slug" type="text"  class="xxwide text input validate[required] form-control" placeholder="Slug" value="<?php echo $slug; ?>" />

 
                                    </div>
                             </div>   <div class="col-lg-4">  
                                    <label>Description*</label>
                                    <div class="field">

                                        <input name="description" id="description" type="text"  class="xxwide text input validate[required] form-control" placeholder="Description" value="<?php echo $description; ?>" />

 
                                    </div>
                             </div>   <div class="col-lg-4">  
                                    <label>Content type*</label>
                                    <div class="field">

                                        <input name="content_type" id="content_type" type="text"  class="xxwide text input validate[required] form-control" placeholder="Content type" value="<?php echo $content_type; ?>" />

 
                                    </div>
                             </div>   <div class="col-lg-4">  
                                    <label>Image*</label>
                                    <div class="field">

                                        <input name="image" id="image" type="text"  class="xxwide text input validate[required] form-control" placeholder="Image" value="<?php echo $image; ?>" />

 
                                    </div>
                             </div>   <div class="col-lg-4">  
                                    <label>Content*</label>
                                    <div class="field">

                                        <input name="content" id="content" type="text"  class="xxwide text input validate[required] form-control" placeholder="Content" value="<?php echo $content; ?>" />

 
                                    </div>
                             </div>   <div class="col-lg-4">  
                                    <label>Rank*</label>
                                    <div class="field">

                                        <input name="rank" id="rank" type="text"  class="xxwide text input validate[required] form-control" placeholder="Rank" value="<?php echo $rank; ?>" />

 
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

        var valid = jQuery('#CourseContent').validationEngine('validate');
        

        if (valid == false) {
            return false;

        }
        $.ajax({
            type: "post",
            url: base_url + "/CourseContent/process_form",
            cache: false,
            data: $('#CourseContent').serialize(),
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
                        window.location = base_url + '/CourseContent';
                    }
                } else {
                    if (is_redirect == true) {
                        window.location = base_url + '/CourseContent';
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
        $('#CourseContent').submit(save_data);
      


    });


</script>


