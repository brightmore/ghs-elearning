<?php if ($catalogue): ?>
    <?php foreach ($catalogue as $value) { ?>
        <div class="tree col-lg-4 col-md-4 col-sm-6">
            <ul>
                <li>
                    <a href="#"><?php echo $value->cat_name ?> :: Category</a>
                    <?php $courses = get_courses_category($value->cat_id) ?>
                    <?php if ($courses): ?>
                        <ul>
                            <?php foreach ($courses as $course): ?>
                            <li><a href="<?php echo base_url('index.php/public/Frontier/course_details/'.$course->course_id); ?>"><?php echo $course->course_name ?> :: Course</a>
                                    <?php $course_outline = getCourseSubject($course->course_id); ?>
                                    <?php if ($course_outline): ?>
                                        <ul>
                                            <?php foreach ($course_outline as $row) { ?>
                                                <li><a href="<?php echo base_url('index.php/public/Frontier/subject_details/'.$row->subject_id); ?>"><?php echo $row->subject_name ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?> 
                  </div>
                <?php } ?>

            <?php else: ?>

            <?php endif; ?>

 <div class="row">
            <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
            <h3 style="border:1px solid #31ba00; padding: 5px;">Our most popular e-Learning programmes include:</h3>
            </div>
 </div>