<div class="row" style="margin-top: 20px;">
    <div class="col-md-4 col-sm-4 col-xs-12 col-lg-3">
         <div style="font-size: 14px; font-weight: bold; margin-bottom: 10px">Categories</div>
         <?php foreach ($catalogue as $value) { ?>
    <div>
        
            <img src="<?php echo base_url().$value->logo ?>" width="45"/>
        <a class="btn" style="background-color: green; color: white; width: 75%" 
           href="<?php echo base_url("index.php/public/Frontier/category_details/{$value->cat_id}/{$value->cat_name}") ?>"><?php echo $value->cat_name ?></a>
    </div>
         <?php } ?>
    </div>
    <div class="col-md-8 col-sm-8 col-xs-12 col-lg-9"> 
        <?php if($subjects): ?>
      
            <?php foreach ($subjects as $value) { ?>
        <div class="collapse-card">
            <div class="title">
                <i class="fa fa-folder-open-o fa-3x fa-fw"></i>

                <span>01:40</span>
                <strong><?php echo $value->subject_name ?></strong>
            </div>
            <div class="body">
               <?php echo $value->summary ?>
            </div>
        </div>

        <?php } ?>
        
        <div class="info-box alert alert-success">
            This course have days to complete(DTC) attached to it, it means you must finish this course before the DTC ends.
            When it ends and you still haven't finished the course, you be will given you a grace period of 5 days to complete the course after which you would be asked to take a quiz.
            After the grace period and you still haven't finished the course then, the system won't allow you to take the course again. You will be force you to take the quiz or you have to re-register
            course again.
        </div>
        
         <div class=" row">
            <div class="col-lg-12" > <a href="<?php echo base_url().'index.php/public/Frontier/start_course/'.$course_id.'/'.$course_name?>" class="btn btn-default btn-warning pull-right">Start Course</a></div>
        </div>
        <?php else: ?>
        <div class="alert alert-info">
            This is course is not active at the moment, Content would be added soon. Email would be sent to you when the content is ready.<br />
            Thank you.
        </div>
        <?php endif; ?>
    </div>
</div>



