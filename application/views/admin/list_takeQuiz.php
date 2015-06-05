 
                 
                 
    <script type="text/javascript">
        //var base_url = "";//mention your base url here
        $(document).ready(function() {

        $("#dataTable").dataTable({
            "aaSorting": [[0, "asc"]],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "/takeQuiz/list_all_data",
            "aoColumns": [ 
                    {"sTitle": "quiz code", "mData": "quiz_code"}, 
                    {"sTitle": "question id", "mData": "question_id"}, 
                    {"sTitle": "answer id", "mData": "answer_id"}, 
                    {"sTitle": "user name", "mData": "user_name"}, 
                    {"sTitle": "quiz type", "mData": "quiz_type"},    
                {"sTitle": "Action", "sClass": "center", "mData": null,
                    "bSortable": false,
                    "mRender": function(data, type, full)
                    {
                        var edit = '<td><a href="' + base_url + '/takeQuiz/edit/' + full.quiz_code+'" class="edit"><i class="icon-edit">edit</i></a>' +
                                '  <a href="' + base_url + '/takeQuiz/remove_form" id="' + full.quiz_code + '" data-id ="' + full.quiz_code + '" class="delete-confirm" ><i class="icon-delete">delete</i></a>'                           
                                                           
                                + '</td>'
                            ;
                        return edit;
                    }},
                ],
         });


$(document).on("click", ".delete-confirm", function(e) {

            e.stopPropagation();
            e.preventDefault();
            var url = $(this).attr("href");
            var data_id = $(this).attr("data-id");
            //html div with id  dialog-confirm placed in footer file
            var conf = confirm("Are you sure to delete this value?");
            if (conf) {
                $.ajax({
                    type: "post",
                    url: url,
                    cache: false,
                    data: {id: data_id},
                    success: function(json) {
                        $("#dataTable").dataTable().fnClearTable();
                    },
                    error: function() {
                        alert("Something Went wrong...");
                    }
                });
            }

            return false;
        });
        
        
        
        });
    </script>

<?php if ($this->session->flashdata('smessage')) { ?>
    <div id="smessage" class="secondary alert"><?php echo $this->session->flashdata('smessage'); ?></div>
<?php } else { ?>
    <div id="smessage"></div>
<?php } ?>            



 <h3 class="text-muted">Take Quiz Listing </h3>
   
            
                 <a href="<?php echo site_url('takeQuiz/create') ?>" class="rt-but">Create Take Quiz</a>
   

<div class="row marketing">
        <div class="col-lg-12">
 <div id="datatable-wrapper">
                <table id="dataTable" cellpadding="0" cellspacing="0" border="0" class="display" >
                </table>
            </div> 
        </div>
    </div>
        