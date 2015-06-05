<?php
$quiz_code = isset($update_data["quiz_code"]) ? $update_data["quiz_code"] : "";
$question_id = isset($update_data["question_id"]) ? $update_data["question_id"] : "";
$answer_id = isset($update_data["answer_id"]) ? $update_data["answer_id"] : "";
$user_name = isset($update_data["user_name"]) ? $update_data["user_name"] : "";
$quiz_type = isset($update_data["quiz_type"]) ? $update_data["quiz_type"] : "";

$btn_msg = ($id == 0) ? "ADD" : " Update";
$title_msg = ($id == 0) ? "Create" : " Update";
?>


<script type="text/javascript" >
    $(document).ready(function () {

        $('#takeQuiz').validationEngine('attach', {scroll: false, addFailureCssClassToField: 'inputbox-error'});
    });
</script>


<div class="row">
    <div class="col-lg-12">
        <h3 class="text-muted"><?php echo $title_msg; ?> Take Quiz</h3> 

        <div id="smessage">
            <?php
            echo validation_errors();
            echo $this->session->flashdata('smessage');
            ?>
        </div>

        <form action="" method="post"  class="form-group"  name="takeQuiz" id="takeQuiz">
            <?php
            if ($id != 0) {
                echo '<input name="id" id="id" type="hidden" value="' . $id . '" />';
            }
            ?>  
            <div class="col-lg-4">  
                <label>Question id*</label>
                <div class="field">
                    <input name="question_id" id="question_id" type="text"  class="xxwide text input validate[required] form-control" placeholder="Question id" value="<?php echo $question_id; ?>" />
                </div>
            </div>   
            <div class="col-lg-4">  
                <label>Answer id*</label>
                <div class="field">
                    <input name="answer_id" id="answer_id" type="text"  class="xxwide text input validate[required] form-control" placeholder="Answer id" value="<?php echo $answer_id; ?>" />
                </div>
            </div>  
            <div class="col-lg-4">  
                <label>User name*</label>
                <div class="field">
                    <input name="user_name" id="user_name" type="text"  class="xxwide text input validate[required] form-control" placeholder="User name" value="<?php echo $user_name; ?>" />
                </div>
            </div>   
            <div class="col-lg-4">  
                <label>Quiz type*</label>
                <div class="field">
                    <input name="quiz_type" id="quiz_type" type="text"  class="xxwide text input validate[required] form-control" placeholder="Quiz type" value="<?php echo $quiz_type; ?>" />
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

        var valid = jQuery('#takeQuiz').validationEngine('validate');


        if (valid == false) {
            return false;

        }
        $.ajax({
            type: "post",
            url: base_url + "/takeQuiz/process_form",
            cache: false,
            data: $('#takeQuiz').serialize(),
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
                        window.location = base_url + '/takeQuiz';
                    }
                } else {
                    if (is_redirect == true) {
                        window.location = base_url + '/takeQuiz';
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
        $('#takeQuiz').submit(save_data);



    });


</script>


