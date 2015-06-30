<ul class="breadcrumb">
    <li><a href="#"><?php echo $subject->cat_name ?></a></li>
    <li><a href="#"><?php echo $subject->course_name ?></a></li>
    <li><?php echo $subject->subject_name ?></li>
</ul>
<div class="subject_detail_top border-bottom-style row">
    <div class="video col-lg-7 col-md-7 col-sm-12" >
        <?php if (isset($subject->youtube)) : ?>
            <video id="vid1" src="" class="video-js vjs-default-skin" controls preload="false" width="640" height="360" data-setup='{ "techOrder": ["youtube"], "src": "<?php echo base_url() . $subject->video_intro_url ?>" }'>
            </video>
        <?php else: ?>

            <video id="vid1" class="video-js vjs-default-skin" controls preload="false" width="100%" height="360" >
                <source src="<?php echo base_url('uploads/subjects/subject_content/small.mp4') ?>" type="video/mp4">
                <source src="<?php echo base_url('uploads/subjects/subject_content/small.ogv') ?>" type="video/ogg">
                <source src="<?php echo base_url('uploads/subjects/subject_content/small.webm') ?>" type="video/webm" >
                <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
            </video>
        <?php endif; ?>
    </div> 
    <div class="col-lg-5 col-md-5 col-sm-12">
        <h3><?php echo $subject->subject_name ?></h3>
        <div>
            <?php echo $subject->description ?>
        </div>
    </div>
</div>


<?php $subject_content = get_subject_content($subject->subject_id) ?>

<?php if (!empty($subject_content)): ?>
<h3>Subject Modules</h3>
    <div class="row" style="margin-top:1em">
        <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="panel-group" id="accordion">
                <?php foreach ($subject_content as $content) : ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion"
                                   href="#<?php echo $content->id ?>"><?php echo $content->title?></a>
                            </h4>
                        </div>
                        <div id="<?php echo $content->id ?>" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>
                                    <?php echo $content->summary ?>
                                </p>
                                <div class="pull-right">
                                    <?php if($content->hasVideo ==='YES'): ?>
                                    <a href="#" class="" style="width:25px; background-color: green; padding: 5px;"><i class="glyphicon glyphicon-facetime-video"></i></a>
                                    <?php endif; ?>
                                    <a href="<?php echo base_url($content->pdf)?>" target="_blank"><img src="<?php echo base_url('assets/img/pdf.jpg')?>" width="25"></a>
                                    <a href="<?php echo base_url(); ?>"><i class="glyphicon glyphicon-eye-open" style="width: 25px; background-color: green; padding: 5px"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>