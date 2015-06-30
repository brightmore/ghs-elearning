<?php if($catalogue): ?>
<h3>TRAINING & LEARNING PROGRAMS</h3>

    <?php foreach ($catalogue as $value) { ?>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
        <div>
            <img src="<?php echo base_url().$value->logo ?>" width="180"/>
        </div>
        <a class="btn btn-instagram" style="width: 100%; background-color: green; color: white" 
           href="<?php echo base_url("index.php/public/Frontier/category_details/{$value->cat_id}/{$value->cat_name}") ?>"><?php echo $value->cat_name ?></a>
    </div>
    <?php } ?>
<?php endif; ?>
