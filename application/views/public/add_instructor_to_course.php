<div class="col-lg-12">
<?php echo form_open('index.php/public/Frontier/process_add_instructor_to_course',array('id'=>'add_instructor','class'=>'')) ?>
    <a href="#" id="add_instructor" class="">Add</a>
    <table class="table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th style="width: 30px"></th>
            <th>Name</th>
            <th>Institution/Facility</th>
            <th>Phone</th>
            <th>Email</th>
        </tr>
        
    </thead>
    <tbody>
        <?php foreach($instructors as $value): ?>
        <tr>
            <td>
                <input type="checkbox" name="instructors[]" value="<?php echo $value->id?>" />
            </td>
            <td><?php echo $value->username?></td>
            <td><?php echo $value->institution ?></td>
            <td><?php echo $value->phone?></td>
            <td><?php echo $value->email ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
   
<?php echo form_close(); ?>
</div>