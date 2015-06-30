<?php
// Change the css classes to suit your needs    

$attributes = array('class' => '', 'id' => 'event_form');
echo form_open('Events', $attributes);
?>

<p>
    <label for="event_title">Event Title <span class="required">*</span></label>
<?php echo form_error('event_title'); ?>
    <br /><input id="event_title" type="text" name="event_title" maxlength="500" value="<?php echo set_value('event_title'); ?>"  />
</p>
<p>
    <label for="event_date">Event date <span class="required">*</span></label>
<?php echo form_error('event_date'); ?>
    <br /><input id="event_date" type="text" name="event_date" maxlength="50" value="<?php echo set_value('event_date'); ?>"  />
</p>

<p>
    <label for="event_end_date">Event End Date <span class="required">*</span></label>
<?php echo form_error('event_end_date'); ?>
    <br /><input id="event_end_date" type="datetime-local" name="event_end_date" maxlength="50" value="<?php echo set_value('event_end_date'); ?>"  />
</p>

<p>
    <label for="summary">Summary <span class="required">*</span></label>
    <?php echo form_error('summary'); ?>
    <br />

<?php echo form_textarea(array('name' => 'summary', 'rows' => '5', 'cols' => '80', 'value' => set_value('summary'))) ?>
</p>
<p>
    <label for="region">Region <span class="required">*</span></label>
    <?php echo form_error('region'); ?>

    <?php // Change the values in this array to populate your dropdown as required ?>
    <?php
    $options = array(
        '' => 'Please Select',
        'ashanti' => 'Ashanti',
        'accra' =>'Greater Accra',
        'brong ahafo'=>'Brong Ahafo',
        'western'=>'Western',
        'eastern'=>'Eastern',
        'centern'=>'Centern',
        'volta'=>'Volta',
        'upper east'=>'Upper East',
        'upper west'=>'Upper West',
        'northern' =>'Northern'
    );
    ?>

    <br /><?php echo form_dropdown('region', sort($options), set_value('region')) ?>
</p>                                             


<p>
<?php echo form_submit('submit', 'Submit'); ?>
</p>

<?php echo form_close(); ?>
