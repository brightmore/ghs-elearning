<!-- Main content -->
<div class="container">
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">  
            <div class="box">
                <div class="box-header">
<!--                                    <i class="fa fa-comments-o"></i>-->
                    <h3 class="box-title"><?php echo $question ?></h3>
                </div>
                <div class="box-body">

                    <?php
                    if ($questionAnswers):
                        $objective = [1 => 'A.', 2 => 'B.', 3 => 'C.', 4 => 'D.'];
                        $count = 1;
                        ?>
                        <form>

                            <?php foreach ($questionAnswers as $row): ?>
                                <div class="form-group">
                                    <label><?php echo $objective[$count] ?></label>
                                    <textarea class="text form-control input" name="answer<?php echo $objective[$count] ?>" id="answer<?php echo $objective[$count] ?>"><?php echo $row->objective ?></textarea>
                                </div>
                                <?php
                                if ($count == 4) {
                                    break;
                                }
                                $count++;
                            endforeach;
                            ?>

                            <div class="box-footer clearfix">  
                                <a href="<?php echo site_url("Questions/deleteQuestion/".$id) ?>" class="btn btn-danger deleteQuestion">Delete</a>
                                <button class="pull-right btn btn-default" id="add_insuere_group" >Update <i class="fa fa-arrow-circle-right"></i></button>
                            </div>     
                        </form>
                    <?php else: ?>
                        <div class="alert alert-info">

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <section class="col-lg-6 connectedSortable">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Question Bank</h3>
                </div>
                <div class="box-body">
                    <?php if (isset($courses)): ?>
                        <ul>
                            <?php foreach ($courses as $value): ?>
                                <li><?php echo $value->course_name ?>

                                    <?php $subjects = getCourseSubject($value->course_id) ?>
                                    <?php if (isset($subjects)): ?>
                                        <ul>
                                            <?php foreach ($subjects as $row): ?>
                                                <li>
                                                    <a href="<?php echo site_url("Questions/showSubjectQuestion/{$row->subject_id}/{$row->subject_name}") ?>">
                                                        <?php echo $row->subject_name ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif;
                                    ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="alert alert-info">
                            There is no course added in this platform, please add course. <a href="<?php echo site_url("Coures/") ?>">Click Here to add a course</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>
</div>