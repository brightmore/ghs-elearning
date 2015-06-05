 <?php 
                    $cat_id= isset($update_data["cat_id"]) ? $update_data["cat_id"] : "";
                    $cat_name= isset($update_data["cat_name"]) ? $update_data["cat_name"] : "";
                    $summary= isset($update_data["summary"]) ? $update_data["summary"] : "";

$btn_msg = ($id == 0) ? "ADD" : " Update";
$title_msg = ($id == 0) ? "Create" : " Update";
?>


<script type="text/javascript" >
    $(document).ready(function() {

        $('#CI_CourseCategory').validationEngine('attach', {scroll: false, addFailureCssClassToField: 'inputbox-error'});
    });
</script>


<div class="row">
<div class="col-lg-12">


             <h3 class="text-muted"><?php echo $title_msg; ?> CourseCategory</h3> 
                


                                <div id="smessage">
                                    <?php echo validation_errors();
                                           echo $this->session->flashdata('smessage');
                                    ?>

                                </div>



                                <form action="" method="post"  class="form-group"  name="CI_CourseCategory" id="CI_CourseCategory">
                                    <?php
                                    if ($id != 0) {
                                        echo '<input name="id" id="id" type="hidden" value="' . $id . '" />';
                                    }
                                    ?>   <div class="col-lg-4">  
                                    <label>Cat name*</label>
                                    <div class="field">

                                        <input name="cat_name" id="cat_name" type="text"  class="xxwide text input validate[required] form-control" placeholder="Cat name" value="<?php echo $cat_name; ?>" />

 
                                    </div>
                             </div>   <div class="col-lg-4">  
                                    <label>Summary*</label>
                                    <div class="field">

                                        <input name="summary" id="summary" type="text"  class="xxwide text input validate[required] form-control" placeholder="Summary" value="<?php echo $summary; ?>" />

 
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

        var valid = jQuery('#CI_CourseCategory').validationEngine('validate');
        

        if (valid == false) {
            return false;

        }
        $.ajax({
            type: "post",
            url: base_url + "/CI_CourseCategory/process_form",
            cache: false,
            data: $('#CI_CourseCategory').serialize(),
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
                        window.location = base_url + '/CI_CourseCategory';
                    }
                } else {
                    if (is_redirect == true) {
                        window.location = base_url + '/CI_CourseCategory';
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
        $('#CI_CourseCategory').submit(save_data);
      


    });


</script>


