 
                 
                 
    <script type="text/javascript">
        //var base_url = "";//mention your base url here
        $(document).ready(function() {

        $("#dataTable").dataTable({
            "aaSorting": [[0, "asc"]],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "/CourseContent/list_all_data",
            "aoColumns": [ 
                    {"sTitle": "id", "mData": "id"}, 
                    {"sTitle": "subtopic id", "mData": "subtopic_id"}, 
                    {"sTitle": "topic id", "mData": "topic_id"}, 
                    {"sTitle": "subtopic name", "mData": "subtopic_name"}, 
                    {"sTitle": "slug", "mData": "slug"},    
                {"sTitle": "Action", "sClass": "center", "mData": null,
                    "bSortable": false,
                    "mRender": function(data, type, full)
                    {
                        var edit = '<td><a href="' + base_url + '/CourseContent/edit/' + full.id+'" class="edit"><i class="icon-edit">edit</i></a>' +
                                '  <a href="' + base_url + '/CourseContent/remove_form" id="' + full.id + '" data-id ="' + full.id + '" class="delete-confirm" ><i class="icon-delete">delete</i></a>'                           
                                                           
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



 <h3 class="text-muted">Course Content Listing </h3>
   
            
                 <a href="<?php echo site_url('CourseContent/create') ?>" class="rt-but">Create Course Content</a>
   

<div class="row marketing">
        <div class="col-lg-12">
 <div id="datatable-wrapper">
                <table id="dataTable" cellpadding="0" cellspacing="0" border="0" class="display" >
                </table>
            </div> 
        </div>
    </div>
        