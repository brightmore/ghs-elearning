<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
         <video id="vid1" class="video-js vjs-default-skin" controls preload="false" width="100%" height="460" >
                <source src="<?php echo base_url($subject_content->video_mp4) ?>" type="video/mp4">
                <source src="<?php echo base_url($subject_content->video_ogg) ?>" type="video/ogg">
                <source src="<?php echo base_url($subject_content->video_webm) ?>" type="video/webm" >
                <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
         </video>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
       
        <div>
            <a href="<?php echo base_url('index.php/public/Frontier/download_subject_content_video/'.$subject_content->id) ?>" class="btn btn-primary btn-small">Download Video</a>
        </div>
        <div>  <a href="<?php echo base_url('index.php/public/Frontier/download_subject_content_pdf/'.$subject_content->id) ?>" class="btn btn-primary btn-small ">Download PDF</a></div>
             <a href="<?php echo base_url($subject_content->pdf)?>" class="btn btn-default btn-small"> View PDF</a>
        
       
    </div>
</div>
<div class="">
    <?php echo $subject_content->summary ?>
</div>