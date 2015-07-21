<div class="row">
    <div class="col-md-4 col-lg-3">
        <div style="font-size: 14px; font-weight: bold; margin-bottom: 10px">Categories</div>
         <?php foreach ($catalogue as $value) { ?>
    <div>
        
            <img src="<?php echo base_url().$value->logo ?>" width="45"/>
        <a class="btn" style="background-color: green; color: white; width: 150px" 
           href="<?php echo base_url("index.php/public/Frontier/category_details/{$value->cat_id}/{$value->cat_name}") ?>"><?php echo $value->cat_name ?></a>
    </div>
    <?php } ?>
    </div>
    <div class="col-md-8 col-lg-9 col-sm-8 col-xs-12">
        
        <div>
            <?php echo $description ?>
        </div>
        
        <?php if($subjects): ?>
        <!--<div class="panel-group" id="accordion" style="width:100% !important; padding: 0; margin: 0">-->
            <?php foreach ($subjects as $value) { ?>
                        
            
             <div class="collapse-card">
            <div class="title">
                <i class="fa fa-folder-open-o fa-3x fa-fw"></i>

                <span>01:40</span>
                <strong><?php echo $value->subject_name ?></strong>
            </div>
            <div class="body">
                <?php $subject_content = get_subject_content($value->subject_id); ?>
               <?php echo $value->summary ?>
                
                <?php if($subject_content): ?>
                                
                               <ul>
                                   <?php foreach ($subject_content as $subject) {?>
                                   <li><a href=""><?php echo $subject->title ?></a></li>
                                    <?php } ?> 
                                </ul>
                 <div class=" row">
            <div class="col-lg-12" > 
                <a href="<?php echo base_url().'index.php/public/Frontier/subject_details/'.$subject->subject_id?>" 
                                        class="btn btn-default btn-warning pull-right">Start</a>
            </div>
        </div>
                
                <?php else: ?>
                <div class="alert alert-success">
                    This is course is not active at moment. You can try later. 
                    <a href="<?php echo base_url().'index.php/public/Frontier/course_list_grid/'?>" 
                                        class="pull-right"><i class="fa fa-chevron-circle-left"></i>
 Back to Courses</a>
                </div>
                <?php endif; ?>
              
            </div>
        </div>
            
<!--                 <div class="panel panel-success" >
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion"
                                   href="#<?php echo $value->subject_id ?>"><?php echo $value->subject_name?></a>
                            </h4>
                        </div>
                        <div id="<?php echo $value->subject_id ?>" class="panel-collapse collapse">
                              <?php $subject_content = get_subject_content($value->subject_id); ?>
                            <div class="panel-body">
                                <p class="subject_summary">
                                    <?php echo $value->summary ?>
                                </p>
                                
                                <?php if($subject_content): ?>
                                
                               <ul>
                                   <?php foreach ($subject_content as $subject) {?>
                                    <li><?php echo $subject->title ?></li>
                                    <?php } ?> 
                                </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>-->
        <?php } ?>
         <!--</div>-->
       <?php else: ?>
        
        <?php endif;?>
        
        
    </div>
</div>