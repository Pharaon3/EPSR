<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('academics'); ?> <small><?php echo $this->lang->line('student_fees1'); ?></small>
        </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('compose_timetable', 'can_add')) {
            ?>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('add') . " " . $this->lang->line('time'); ?></h3>
                        </div>
                        <form action="<?php echo site_url('admin/composetimetable/insert') ?>" id="lessontimeform" 
                        name="lessontimeform" method="post" accept-charset="utf-8" >
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class ="form-group">
                                    <label for="level"><?php echo $this->lang->line('class_timezone'); ?> </label>
                                    <div style="width:100%;display: flex;">
                                        <select autofocus="" id="timezone_id" name="timezone_id" class="form-control" >
                                            <option value=0></option>
                                            <?php
                                            foreach ($lesson_timezone as $value) {
                                                ?>
                                                <option value="<?php echo $value['id'] ?>" <?php
                                                if ($timezone_id == $value['id']) {
                                                    echo "selected=selected";
                                                }
                                                ?>><?php echo $this->lang->line($value['description']); ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="level"><?php echo $this->lang->line('time'); ?> </label><small class="req"> *</small>
                                    <div style="width:100%;display: flex;">
                                        <div style="width:50%">
                                            <div class="input-group"><input type="text" name="time_from" require class="form-control time_from time" id="time_from"  
                                            aria-invalid="false"placeholder="From" value=""/>
                                            <div class="input-group-addon"><i class="fa fa-clock-o"></i></div></div>
                                            <span class="text-danger"><?php echo form_error('time_from'); ?></span>
                                        </div>
                                        <div style="width:50%;float:right;">
                                            <div class="input-group"><input type="text" name="time_to" require class="form-control time_to time" id="time_to"  
                                            aria-invalid="false" placeholder="To" value=""/>
                                            <div class="input-group-addon"><i class="fa fa-clock-o"></i></div></div>
                                            <span class="text-danger"><?php echo form_error('time_to'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label >
                                        <?php echo $this->lang->line('time_type') ?>
                                    </label>
                                    <div style="width:100%;display: flex;">
                                            <select autofocus="" id="time_type" name="time_type" class="form-control" >
                                                <?php foreach(TIME_TYPE as $row){ ?>
                                                <option value='<?php echo $row['id'] ?>'><?php echo $this->lang->line($row['namekey']) ?></option>
                                                <?php } ?>
                                                </select>
                                       
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label >
                                        <?php echo $this->lang->line('description') ?>
                                    </label>
                                    <div style="width:100%;display: flex;">

                                            <input autofocus="" id="description" name="description"
                                                    value=""
                                                    placeholder="description"
                                                 class="form-control" />
                                                
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-<?php
                                if ($this->rbac->hasPrivilege('compose_timetable', 'can_add')) {
                                    echo "8";
                                } else {
                                    echo "12";
                                }
                                ?>" >
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('timetable'); ?></h3>
                    </div>
                    <div class="box-body ">
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label"><?php echo $this->lang->line('time') . " " . $this->lang->line('list'); ?></div>
                            <table class="table table-striped table-bordered table-hover example" id="timetable">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('no'); ?></th>
                                        <th><?php echo $this->lang->line('time'); ?></th>
                                        <th><?php echo $this->lang->line('time_type'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $count = 1;
                                    foreach ($timetables as $value) {
                                    ?>
                                        <tr>
                                            <td><?= $count; ?></td>
                                            <td class="mailbox-name"> <?php echo $value['time_from']." - ".$value['time_to'] ?></td>
                                            <td class="mailbox-name"> 
                                                <?php
                                                    if($value['time_type'] == 0)
                                                        echo $this->lang->line('time_type_lesson');
                                                    else if($value['time_type'] == 1)
                                                        echo $this->lang->line('time_type_rest');
                                                    else
                                                        echo $this->lang->line('time_type_other');
                                                ?>
                                            </td>
                                            <td class="mailbox-date pull-right">
                                                <?php
                                                if ($this->rbac->hasPrivilege('compose_timetable', 'can_edit')) {
                                                ?>
                                                    <a data-placement="left" href="<?php echo base_url(); ?>admin/composetimetable/edit/<?php echo $value['id'] ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                <?php
                                                }
                                                if ($this->rbac->hasPrivilege('compose_timetable', 'can_delete')) {
                                                ?>
                                                    <a data-placement="left" href="<?php echo base_url(); ?>admin/composetimetable/delete/<?php echo $value['id'] ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('are_you_sure_to_delete_this') ?>');">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php
                                    $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).on('submit', '#lessontimeform', function (e) {
        if($('#time_from').val()=="" ) 
        {
            e.preventDefault();
            $('#time_from').focus();
            return;
        }
        if($('#time_to').val()=="" ) 
        {
            e.preventDefault();
            $('#time_to').focus();
            return;
        }
    });
    $(document).on('focus', '.time', function () {
        var $this = $(this);
        $this.datetimepicker({
            format: 'HH:mm'
        });
    });

    $(document).on('change', '#timezone_id', function (e) {
            var timezone_id = $(this).val();
            var base_url = '<?php echo base_url() ?>';
            const form = document.createElement('form');
            form.method = "post";
            form.action = base_url + "admin/composetimetable";
            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = "timezone_id";
            hiddenField.value = timezone_id;
            form.appendChild(hiddenField);
            document.body.appendChild(form);
            form.submit();
        });

        
</script>