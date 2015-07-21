<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Add Events</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
// Change the css classes to suit your needs    
                            $attributes = array('class' => '', 'id' => 'event_form');
                            echo form_open('/index.php/Events/process_event_form', $attributes);
                            ?>

                            <div class="form-group">
                                <label for="event_title">Event Title <span class="required">*</span></label>
                                <?php echo form_error('event_title'); ?>
                                <input id="event_title" type="text" required="" class="form-control" name="event_title" maxlength="500" value="<?php echo set_value('event_title'); ?>"  />
                            </div>
                            <div class="form-group">
                                <label for="event_start_date">Event Start date <span class="required">*</span></label>
                                <?php echo form_error('event_start_date'); ?>
                                <input id="event_date" type="text" required="" class="form-control" name="event_start_date" maxlength="50" value="<?php echo set_value('event_date'); ?>"  />
                            </div>

                            <div class="form-group">
                                <label for="event_end_date">Event End Date <span class="required">*</span></label>
                                <?php echo form_error('event_end_date'); ?>
                                <input id="event_end_date" class="form-control" required="" type="datetime-local" name="event_end_date" maxlength="50" value="<?php echo set_value('event_end_date'); ?>"  />
                            </div>

                            <div class="form-group">
                                <label for="location">Location: <span class="required">*</span></label>
                                <?php echo form_error('location') ?>
                                <input id="location" class="form-control" required="" type="text" name="location" >
                            </div>

                            <div class="form-group">
                                <label for="event_summary">Summary <span class="required">*</span></label>
                                <?php echo form_error('event_summary'); ?>
                                <?php echo form_textarea(array('name' => 'event_summary', 'class' => 'form-control', 'rows' => '5', 'cols' => '80', 'value' => set_value('event_summary'))) ?>
                            </div>
                            <div class="form-group">
                                <label for="region">Region <span class="required">*</span></label>
                                <?php echo form_error('region'); ?>
                                <?php
                                $options = array(
                                    '' => 'Please Select',
                                    'ashanti' => 'Ashanti',
                                    'accra' => 'Greater Accra',
                                    'brong ahafo' => 'Brong Ahafo',
                                    'western' => 'Western',
                                    'eastern' => 'Eastern',
                                    'centern' => 'Centern',
                                    'volta' => 'Volta',
                                    'upper east' => 'Upper East',
                                    'upper west' => 'Upper West',
                                    'northern' => 'Northern'
                                );
                                ?>

                                <?php echo form_dropdown('region', $options, set_value('region'), array('class' => 'form-control')) ?>
                            </div>   
                            
                            <div class="form-group">
                                <label>Poster (if any)</label>
                                <input type="file" name="userfile" id="userfile" class="form-control"/>
                            </div>
                            
                            <div class="form-group">
                                <?php echo form_submit('submit', 'Submit', 'class="form-control btn btn-primary"'); ?>
                            </div>

                            <?php echo form_close(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">

            <?php if ($events): ?>

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Manage Channels</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table forum table-striped">
                                    <thead>
                                        <tr>
                                            <!--<th class="cell-stat"></th>-->
                                            <th style="width: 45%"><h3>Event Title/Theme</h3></th>
                                    <th class="cell-stat text-center hidden-xs hidden-sm">Start</th>
                                    <th class="cell-stat-2x hidden-xs hidden-sm">End time</th>
                                    <th class="cell-stat text-center hidden-xs hidden-sm">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody> 
                                        <?php foreach ($events as $event): ?>
                                        
                                        <tr>
                                            <!--<td class="text-center"><i class="fa fa-heart fa-2x text-primary"></i></td>-->
                                            <td>
                                                <h4><a href="#"><?php echo $event->event_title ?></a><br><small><?php echo $event->event_summary ?></small></h4>
                                            </td>
                                            <td class="text-center hidden-xs hidden-sm"><small><i class="fa fa-clock-o"></i> </small> <a href="#"><?php echo toDateTime($event->event_start_datetime) ?></a></td>
                                            <td class="text-center hidden-xs hidden-sm"><small><i class="fa fa-clock-o"></i> </small> <a href="#"><?php echo toDateTime($event->event_end_datetime) ?></a> </td>
                                            <td class="hidden-xs hidden-sm">
                                                <a href="#" title="Delete Event"><i class="glyphicon glyphicon-remove-sign fa-2x"></i></a>  
                                                <a href="#" title="Click to view event details"><i class="glyphicon glyphicon-eye-open fa-2x"></i></a> </td>
                                        </tr>
                                        <?php  endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                <?php echo $pagination ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            <?php else: ?>

            <?php endif; ?>
        </div>
    </div>
</div>
