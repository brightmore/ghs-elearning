<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Manage Channels</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Add Thread to channel</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php echo form_open('index.php/Forum/process_thread_form') ?>
                            <?php echo form_hidden($csrf); ?>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <textarea class="form-control" id="title" name="title"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="slug">slug/Tag</label>
                                <input type="text" id="slug" class="form-control" name="slug">
                            </div>

                            <div class="form-group">
                                <label for="channel_name">Channel Name</label>
                                <select name="channel_id" class="form-control">
                                    <option value="">Select Channel...</option>
                                    <?php foreach ($channels as $value): ?>
                                    <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                             <div class="form-group">
                                   <input name="send"
                                          id="send_channel" 
                                          class="btn btn-default" 
                                          value="send_channel" 
                                          type="submit" 
                                          />
                             </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>