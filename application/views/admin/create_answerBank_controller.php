<?php
$answer_id = isset($update_data["answer_id"]) ? $update_data["answer_id"] : "";
$question_id = isset($update_data["question_id"]) ? $update_data["question_id"] : "";
$objective = isset($update_data["objective"]) ? $update_data["objective"] : "";
$answer = isset($update_data["answer"]) ? $update_data["answer"] : "";
$type = isset($update_data["type"]) ? $update_data["type"] : "";

$btn_msg = ($id == 0) ? "ADD" : " Update";
$title_msg = ($id == 0) ? "Create" : " Update";
?>


<script type="text/javascript" >
    $(document).ready(function () {

        $('#answerBank_controller').validationEngine('attach', {scroll: false, addFailureCssClassToField: 'inputbox-error'});
    });
</script>


<div class="row">
    <div class="col-lg-12">

        <h3 class="text-muted"><?php echo $title_msg; ?> Answerbank</h3> 

        <div id="smessage">
            <?php
            echo validation_errors();
            echo $this->session->flashdata('smessage');
            ?>

        </div>

        <form action="" method="post"  class="form-group"  name="answerBank_controller" id="answerBank_controller">
            <?php
            if ($id != 0) {
                echo '<input name="id" id="id" type="hidden" value="' . $id . '" />';
            }
            ?>   <div class="col-lg-4">  
                <label>Question id*</label>
                <div class="field">

                    <input name="question_id" id="question_id" type="text"  class="xxwide text input validate[required] form-control" placeholder="Question id" value="<?php echo $question_id; ?>" />
                </div>
            </div>   <div class="col-lg-4">  
                <label>Objective*</label>
                <div class="field">

                    <input name="objective" id="objective" type="text"  class="xxwide text input validate[required] form-control" placeholder="Objective" value="<?php echo $objective; ?>" />

                </div>
            </div>   <div class="col-lg-4">  
                <label>Answer*</label>
                <div class="field">

                    <input name="answer" id="answer" type="text"  class="xxwide text input validate[required] form-control" placeholder="Answer" value="<?php echo $answer; ?>" />

                </div>
            </div>   <div class="col-lg-4">  
                <label>Type*</label>
                <div class="field">

                    <input name="type" id="type" type="text"  class="xxwide text input validate[required] form-control" placeholder="Type" value="<?php echo $type; ?>" />


                </div>
            </div>   


            <div class="col-lg-2" style="padding-top: 2.2%">
                <input name="insured_group"
                       id="add_insuere_group" class="btn  btn-default" value="<?php echo $btn_msg ?>" type="submit" />
            </div>

        </form>
    </div>
</div>  
<script>

    function save_data(e) {
        e.stopPropagation();
        e.preventDefault();
        var thisdata = $(e.target);

        var valid = jQuery('#answerBank_controller').validationEngine('validate');

        if (valid == false) {
            return false;

        }
        $.ajax({
            type: "post",
            url: base_url + "/answerBank_controller/process_form",
            cache: false,
            data: $('#answerBank_controller').serialize(),
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
                        window.location = base_url + '/answerBank_controller';
                    }
                } else {
                    if (is_redirect == true) {
                        window.location = base_url + '/answerBank_controller';
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
        $('#answerBank_controller').submit(save_data);
    });


</script>


