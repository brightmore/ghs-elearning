<div  style="background-color: #ccff66; margin: 1em -15px; padding-right: 15px;">
    <div class="row" style="padding:10px 0; ">
    <div class="col-lg-1 col-md-1">
        <img class="pull-right" src="<?php echo base_url().'uploads/courseBanners/image.png' ?>"  width="50"/>
    </div>
        <div class="col-lg-11 col-md-11">
            Adopting an Agile Approach to Project Management
            <a href="#" class="pull-right btn btn-default" style="background-color:yellow">Start</a>
        </div>
    </div>
    
    <div class="row">
    <div class="col-lg-1 col-md-1">
        <img class="pull-right" src="<?php echo base_url().'uploads/courseBanners/image2.png' ?>"  width="50"/>
    </div>
        <div class="col-lg-11 col-md-11">
            Adopting an Agile Approach to Project Management
            <a href="#" class="pull-right btn btn-default" style="background-color:yellow">Start</a>
        </div>
    </div>
    
    <div class="row" style="padding:10px 0;">
    <div class="col-lg-1 col-md-1">
        <img class="pull-right" src="<?php echo base_url().'uploads/courseBanners/image.png' ?>"  width="50"/>
    </div>
        <div class="col-lg-11 col-md-11">
            Adopting an Agile Approach to Project Management
            <a href="#" class="pull-right btn btn-default" style="background-color:yellow">Continue</a>
        </div>
    </div>
    
    <div class="row" style="padding:10px 0;">
    <div class="col-lg-1 col-md-1">
        <img class="pull-right" src="<?php echo base_url().'uploads/courseBanners/image.png' ?>"  width="50"/>
    </div>
        <div class="col-lg-11 col-md-11">
            Adopting an Agile Approach to Project Management
            <a href="#" class="pull-right btn btn-default" style="background-color:yellow">Continue</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-lg-4 col-sm-12">
        <h3>Catalogue</h3>
        <ul>
            <?php foreach ($catalogue as $row) { ?>
                <li>
                    <a class='' data-popover="true" data-html=true 
                       data-content="<div class='custom-popover'>
                       <h5>Summary</h5>

                       <?php echo character_limiter($row->summary, 200); ?>

                       <a href='#' class='btn'>Click to view Courses</a>
                       </div>
                       "><?php echo $row->cat_name ?></a>  
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="col-md-4 col-lg-4 col-sm-12">
        <h3>My Community</h3>
        <?php if ($users_thread): ?>
            <ul>
                <li>Your Activities In Forum</li>
                <?php foreach ($users_thread as $value): ?>
                    <li><span style="background-color: <?php echo $value->color ?>; width:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <span class="user_thread">
                            <a href="#"><?php echo $value->title ?></a>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <div class="col-md-4 col-lg-4 col-sm-12">

        <?php if ($news):?>
            <h3> News</h3>
            <ul>
                <?php foreach ($news as $value) { ?>

                    <li><?php echo $value->title ?></li>

                <?php } ?>
            </ul>
        <?php endif; ?>
            
        <?php if ($events): ?>
            <h3>Events</h3>
            <ul>
                <?php foreach ($events as $row) { ?>
                    <li><a href="#"><?php echo $row->event_title ?></a></li>
                <?php } ?>
            </ul>
        <?php endif; ?>
    </div>
    
</div>
<div class="row">
            <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
            <h3 style="border:1px solid #31ba00; padding: 5px;">Our most popular e-Learning programmes include:</h3>
            </div>
        </div>
<div class="row border-bottom-style">
    <?php if (isset($course_outlines)): $base_url = base_url() ?>

        <?php foreach ($course_outlines as $value) { ?>
            <div class="col-lg-4 col-md-3 col-sm-12">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h5><?php echo $value->cat_name ?> </h5>
                    <img src="<?php echo $base_url . $value->banner_url ?>" width="155"/>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h5>Course Outline</h5>
                    <?php $subjects = getCourseSubject($value->course_id); ?>
                    <ul>
                        <?php foreach ($subjects as $subject): ?>
                            <li><?php echo $subject->subject_name ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php } ?>

    <?php else: ?>

    <?php endif; ?>
</div>
