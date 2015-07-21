<div class="row">
    <div class="col-md-3 col-sm-12 col-lg-3">
        <h3 style="background-color: #31ba00; padding: 5px;">
            <?php echo $course->cat_name ?>
        </h3>
        <div>
            <img src="<?php echo base_url($course->banner_url) ?>" width="200"/>
        </div>
        <h3>Course Syllabus</h3>
    <div>
        <?php $course_outline = getCourseSubject($course->course_id) ?>
       <?php if($course_outline): ?> 
        <div>
            At the end of this course will learn following:
        </div>
        <ul>
            <?php foreach ($course_outline as $row) { ?>
                <li>
                    <a class='' data-popover="true" data-html=true 
                       data-content="<div class='custom-popover'>
                       <h5>Summary</h5>

                       <?php echo character_limiter($row->description, 200); ?>

                       <a href='#' class='btn'>View</a>
                       </div>
                       "><?php echo $row->subject_name ?></a>  
                </li>
            <?php } ?>
        </ul> 
        <?php endif;?>
    </div>
         <div class="suggest_reading">
            <h3>Suggested Reading</h3>
            <div>
                <?php if(isset($course->suggested_readings)):?>
                    <?php echo $course->suggested_readings?>
                <?php else: ?>
                    There is no required reading.
                <?php endif; ?>
            </div>
        </div>
        <div class="Instructors">
            <?php $moderator = getModerator($course->course_id); 

            ?>
        </div>
    </div>
    <div class="col-md-9 col-sm-12 col-lg-9">
        <div style="border-bottom:2px solid #31ba00 ">
            <h3>About The Course</h3>
        </div>
        <div>
            <?php echo $course->course_description ?>
        </div>
        
        <div class="recommended_background">
            <h3>Recommended Background</h3>
            <?php if($course->recommended_background): echo $course->recommended_background?>
                
            <?php else: ?>
                You can take this course without any background or you can start right way.
            <?php endif; ?>
        </div>
        
        <div class="course_format">
            <h3>Course Format</h3>
            <?php if($course->course_format)  echo $course->course_format ?>
        </div>
        
        <div >
            <h3>FAQs</h3>
            <?php echo $course->FAQ ?>
        </div>
        
        <div class=" row">
            <div class="col-lg-12" > <a href="<?php echo base_url().'index.php/public/Frontier/take_course/'.$course->course_id.'/'.$course_name?>" class="btn btn-default btn-primary pull-right">Take Course</a></div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
            <h3 style="border:1px solid #31ba00; padding: 5px;">Our most popular e-Learning programmes include:</h3>
            </div>
        </div>
    </div>  
</div>
