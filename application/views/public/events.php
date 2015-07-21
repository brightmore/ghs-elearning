<?php if ($events): ?>
    <h2>Events</h2>
    <div class="row">
        <?php foreach ($events as $event): ?>
            <div class="col-sm-4">
                <?php if($event->banner): ?>
                <div class="thumbnail">
                    <div class="overlay"></div>
                    <img class="img-responsive" alt="alternative text" src="<?php echo base_url().$event->banner ?>">
                </div>
                <div class="alert">
                    <?php echo character_limiter($event->event_summary,200) ?>
                    <a href="#" class="label label-info">Read...</a>
                </div>
                <?php else: ?>
                <div >
                    <?php echo $event->event_summary ?>
                </div>
                <?php endif; ?>
                <span class="label label-info date">
                    <?php echo toDateTime($event->event_start_datetime) ?></span> 
                <span class="label label-primary"><?php echo toDateTime($event->event_end_datetime) ?></span>
                <p>
                    <strong><a href="#"><?php echo $event->event_title ?></a></strong><br>
                    <span class="label label-success">Location</span> <em><?php echo $event->location ?></em><br>
                </p>
            </div>
        <?php endforeach; ?>
        <div class="col-lg-12">
            <?php echo $pagination ?>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        There is no event posted
    </div>
<?php endif; ?>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Modal header</h3>
	</div>
	<div class="modal-body">
		<p>My modal content here…</p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal">Close</button>
	</div>
	</div>
</div>
</div> 