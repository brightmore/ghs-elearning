<fieldset><legend>answerBank</legend>
 <?php     
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo form_open('answerBank_controller', $attributes); ?>
<div class="control-group">
    <label for="objective" class="control-label">Objective <span class="required">*</span></label>
	<div class='controls'>
       <input id="objective" type="text" name="objective" maxlength="255" value="<?php echo set_value('objective'); ?>"  />
		 <?php echo form_error('objective'); ?>
	</div>
</div><div class="control-group">
    <label for="answer" class="control-label">answer <span class="required">*</span>
</label>
<div class="controls"><?php $options = array(''  => 'Please Select','example_value1'    => 'example option 1'); ?>
 
<?php echo form_dropdown('answer', $options, $this->input->post('answer'))?>
		<?php echo form_error('answer'); ?>
	</div>
</div><div class="control-group">
    <label for="type" class="control-label">Type <span class="required">*</span>
</label>
<div class="controls"><?php $options = array(''  => 'Please Select','example_value1'    => 'example option 1'); ?>
 
<?php echo form_dropdown('type', $options, $this->input->post('type'))?>
		<?php echo form_error('type'); ?>
	</div>
</div>
<div class="control-group">
	<label></label>
	<div class='controls'>
        <?php echo form_submit( 'submit', 'Submit'); ?>
	</div>
</div>
<?php echo form_close(); ?></fieldset>