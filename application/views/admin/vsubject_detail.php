<div class="container">
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">  
            <div class="box">
                <div class="box-header">
<!--                                    <i class="fa fa-comments-o"></i>-->
                    <h3 class="box-title"><?php echo $subject->subject_name ?></h3>
                </div>
                <div class="box-body " style="overflow:auto"> 
                    <div class="_item">
                        <?php if ($subject->video_intro_url !== NULL): ?>
                            <div class="video">
                                <?php if ($subject->youtube == 'youtube') : ?>
                                    <video id="vid1" src="" class="video-js vjs-default-skin" controls preload="false" width="640" height="360" data-setup='{ "techOrder": ["youtube"], "src": "<?php echo $subject->video_intro_url ?>" }'>
                                    </video>
                                <?php else: ?>
                                    <video id="vid1" class="video-js vjs-default-skin" controls preload="false" width="100%" height="360" >
                                        <source src="<?php $subject->video_intro_url ?>" type="<?php echo $subject->video_mime_type ?>">
                                        <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                                    </video>
                                <?php endif; ?>
                            </div> 
                        <?php endif; ?>

                        <div class="alert alert-success">
                            <?php echo $subject->description ?>
                        </div>
                    </div>

                    <?php if ($subject_content): ?>
                        <div class="box-group" id="accordion">
                            <?php foreach ($subject_content as $value) { ?>
                                <div class="panel box box-primary">
                                    <div class="box-header">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo "collapse".$value->id ?>">
                                                <?php echo $value->title ?>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="<?php echo "collapse".$value->id ?>" class="panel-collapse collapse">
                                        <div class="box-body">
                                            <?php echo $value->description ?>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>
                        </div>
                    <?php endif; ?>     
                </div>
            </div>
   
</section>

<section class="col-lg-5 connectedSortable">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Add Subject Content</h3>
        </div>
        <div class="box-body">
            <form action="#" method="post">
                <input type="hidden" name="subject_id" value="<?php echo $subject->subject_id ?>"
                       <div class="form-group">
                    <label>Title</label>
                    <div class="field">
                        <input name="title" id="title" type="text"  
                               class="xxwide text input validate[required] form-control" 
                               placeholder="title" value="<?php echo set_value("title") ?>" />
                    </div>

                    <div class="form-group">
                        <label>Content*</label>
                        <div class="field">
                            <textarea cols="6" name="description" id="course_description" 
                                      class="xxwide text input validate[required] form-control" 
                                      placeholder="Summary"><?php echo set_value('description'); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <label>Video</label>
                            <input type="file" id="banner_url" name="banner_url" value="<?php echo set_value('banner_url') ?>" >
                        </div>
                        <div class="field">
                            <label>Youtube Video Url</label>
                            <div>
                                <textarea cols="3" class="form-control input text" placeholder="Paste or Enter youtube video url here..." name="youtubeVideo" id="youtubeVideo"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Resource Type Video mode:</label>
                        <div class="field">
                            <select name="content_type">
                                <option value="error">Select content type</option>
                                <option value="html5">mp4</option>
                                <option value="html5">webm</option>
                                <option value="flash">Flash</option>
                                <option value="youtube">Youtube url</option>
                            </select> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Rank</label>
                        <div class="field">
                            <input name="rank" id="rank" type="text"  class="xxwide text input validate[required] form-control" placeholder="Rank" value="<?php echo set_value('rank'); ?>" /> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Video Intro Type</label>
                        <div class="field">
                            <select id="video_type" name="video_type">
                                <option value="html5-comp">MP4</option>
                                <option value="youtube">Youtube</option>
                            </select>
                        </div>
                    </div>


                    <div class="box-footer clearfix">

                        <button class="pull-right btn btn-default" id="add_insuere_group" >Send <i class="fa fa-arrow-circle-right"></i></button>
                    </div>   
            </form>
        </div>
    </div>
</section>
</div>