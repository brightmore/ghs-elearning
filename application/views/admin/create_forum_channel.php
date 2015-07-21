<!-- Main content -->
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <div class="box-header">
<!--                                    <i class="fa fa-comments-o"></i>-->
                    <h3 class="box-title">Manage Channels</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php if($channels): ?>
                            <table class="table-hover table-striped ">
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>Name</th>
                                        <th>Created On</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($channels as $value){ ?>
                                        <tr>
                                            <td><input type="checkbox" name="channels[]" value="<?php echo $value->id ?>" /> </td>
                                            <td><?php echo $value->name ?></td>
                                            <td><?php echo $value->created_on ?></td>
                                            <td><a href="<?php echo base_url() ?>"><i class="glyphicon glyphicon-remove-sign"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                            <div class="alert alert-warning">
                                There is forum channel created for the forum;
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Add New Channel</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php  echo form_open_multipart('/index.php/Forum/process_channel_form') ?>
                            <?php echo form_hidden($csrf); ?>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="channel_name" class="form-control" name="channel_name" />
                            </div>
                            
                            <div class="form-group">
                                <label>slug/Tag</label>
                                <input type="text" id="slug" class="form-control" name="slug" />
                            </div>
                            
                            <div class="form-group">
                                <label>Icon</label>
                                <input type="file" name="userfile" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                   <input name="send"
                                          id="send_channel" 
                                          class="btn btn-default" 
                                          value="send_channel" 
                                          type="submit" 
                                          />
                             </div>
                            <?php form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>