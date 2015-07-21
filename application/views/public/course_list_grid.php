<div id="courses_summary">
    
    <div style="font-size: 22px; padding: 10px; font-weight: bolder">
        Dedicated e-Learning solutions for the healthcare sector
    </div>
    <div style="font-size: 16px; background-color: #fff9ae; padding: 10px 20px; margin-bottom: 20px;">
        e-Learning has changed the approach of staff training and development, within the NHS, the healthcare sector and industry in general. It enables any NHS Trust to create, deploy and
distribute organisational learning to staff, quickly and easily.
    </div>
    
<?php if($catalogue): ?>
<div class="row">
    
    <div class="col-md-3">
        <div style="font-size: 14px; font-weight: bold; margin-bottom: 10px">Categories</div>
         <?php foreach ($catalogue as $value) { ?>
    <div>
        
            <img src="<?php echo base_url().$value->logo ?>" width="45"/>
        <a class="btn" style="background-color: green; color: white; width: 150px" 
           href="<?php echo base_url("index.php/public/Frontier/category_details/{$value->cat_id}/{$value->cat_name}") ?>"><?php echo $value->cat_name ?></a>
    </div>
    <?php } ?>
    </div>
    <div class="col-md-9">
        <div style="font-size: 17px; font-weight: bold; margin-bottom: 10px; margin-top: 10px">Courses and Learning Programs</div>
        <ul class="course_list">
        <?php foreach($courses as $value) { ?>
            <li>
                <a class="block_archor row" href="<?php echo base_url('index.php/public/Frontier/course_details/'.$value->course_id) ?>">
                    <div class="col-md-3">
                        <img src="<?php echo base_url().$value->banner_url?>" width="160" />
                    </div>
                     <div class="col-md-9">
                         <div class="course_name">
                             <span class="course_name>"><?php echo $value->course_name ?></span>
                             
                         </div>
                         <div class="description">
                             <?php echo character_limiter($value->course_description,100) ?>
                         </div>
                         <div class="">
                             <span class="label label-success"><?php echo get_total_student_count_per_course($value->course_id) ?> Students</span>
                             <?php $moderator = getModerator($value->course_id); ?>
                            
                             <span class="label label-primary">Moderator: <?php echo $moderator->salutation.' '.$moderator->last_name.' '.$moderator->first_name  ?></span>
                         <span class="daysToComplete label label-danger pull-right"><i title="days to complete">DTC </i><?php echo $value->daysToComplete ?></span>
                         </div>
                    </div>
                </a>
            </li>
        <?php } ?>
        </ul>
    </div>
    </div>

<?php endif; ?>
</div>
