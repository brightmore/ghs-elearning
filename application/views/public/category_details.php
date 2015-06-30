<?php if($categories): ?>

<h3><?php echo $category_name?></h3>

    <?php foreach ($categories as $value) { ?>
<div class="col-lg-12 " style="margin-bottom: 1em; border-bottom: green solid 2px; padding: 1em;">
    <div class="col-lg-4">
        <div><?php echo $value->course_name?></div>
        <div> <img src="<?php echo base_url().$value->banner_url ?>" width="80%" /></div>
        <div>
            <a href="#" class="btn btn-danger" >Take Course</a> <a href="#" class="btn alert-info" >Take Test</a>
        </div>
    </div>
    <div class="col-lg-8">
        <h4>Summary</h4>
        <?php echo character_limiter($value->course_description,800) ?>
        <div class="pull-right btn btn-google "><a href="#">More</a></div>
    </div>
</div>
    <?php } ?>
<?php else: ?>

<?php endif; ?>
