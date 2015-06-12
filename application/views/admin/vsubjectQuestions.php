<!-- Main content -->
<div class="container">
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">  
            <div class="box">
                <div class="box-header">
<!--                                    <i class="fa fa-comments-o"></i>-->
                    <h3 class="box-title">Question Bank Section A</h3>
                </div>
                <div class="box-body">
                     <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="facility-keyword" id="facility-keyword" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn-facility' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="box-body"> 
                    <?php if(isset($sectionA)): ?>
                   
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Question</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sectionA as $value) : ?>
                            <tr>
                                <td>
                                    
                                </td>
                                <td> <a href="<?php echo site_url("Questions/view/".$value->question_id."/".$value->question)?>" title="View question with it answers"><?php echo $value->question?></a> </td>
                                <td>
                                    <a href="<?php echo site_url("Questions/view/".$value->question_id."/".$value->question)?>" title="View question with it answers">View</a> 
                                    <a href="<?php echo site_url("Questions/edit/".$value->question_id) ?>" title="edit question">Edit</a>
                                    <a href="<?php echo site_url('Questions/deleteQuestion/'.$value->question_id) ?>">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <div class="alert alert-info">
                        There is no question set for this subject. You can start adding/setting question for this subject
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </section>
        
     <section class="col-lg-6 connectedSortable">  
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Question Bank Section B</h3>
                </div>
                <div class="box-body">
                    <?php if(isset($sectionB)): ?>
                        <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Question</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sectionB as $value) : ?>
                            <tr>
                                <td>
                                    
                                </td>
                                <td> <a href="<?php echo site_url("Questions/view/".$value->question_id."/".$value->question)?>" title="View question with it answers"><?php echo $value->question?></a> </td>
                                <td>
                                    <a href="<?php echo site_url("Questions/view/".$value->question_id)?>" title="View question with it answers">View</a> 
                                    <a href="<?php echo site_url("Questions/edit/".$value->question_id) ?>" title="edit question">Edit</a>
                                    <a href="<?php echo site_url("Questions/deleteQuestion/".$value->question_id) ?>">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif;?>
                </div>
            </div>
        </section>
    </div>
</div>