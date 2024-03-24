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
                            <h3 class="box-title"><?php echo $this->lang->line('timetablezone_manage'); ?></h3>
                        </div>
                        <form action="<?php echo site_url('admin/composetimezone/insert') ?>" 
                            id="lessontimezone_form" 
                            name="lessontimezone_form" 
                            method="post" 
                            accept-charset="utf-8" >
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <input type="hidden" id="lesson_timezone_id" name="lesson_timezone_id" value="<?php echo $lesson_timezone_detail['id'] ?? 0 ?>"/>
                                <div class ="form-group">
                                    <label for="timezone_name"><?php echo $this->lang->line('timezone_name'); ?> </label>
                                    <div style="width:100%; display: flex;">
                                        <input type="text" class="form-control" style="width:100%;"
                                                id="timezone_name" name="timezone_name"
                                                value="<?php echo $lesson_timezone_detail['timezone_name'] ?? '' ?>"
                                                 />   
                                    </div>
                                </div>
                                <div class ="form-group">
                                    <label for="lesson_time"><?php echo $this->lang->line('time_type_lesson'); ?> </label>
                                    <div style="width:100%;display: flex;">
                                        <select autofocus="" id="lesson_time" name="lesson_time" class="form-control" >
                                            <option value="0"></option>
                                            <?php
                                            foreach ($ampms as $value) {
                                                 $ampm_flag = $lesson_timezone_detail['ampm_flag'] ?? 0;
                                                 $selected = ($ampm_flag== $value['id']) ? "selected" : "";
                                                
                                                ?>
                                                <option value="<?php echo $value['id'] ?>" <?php echo $selected; ?> >
                                                               <?php echo $value['name'] ?></option><?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class ="form-group">
                                    <label for="txtnote"><?php echo $this->lang->line('note'); ?> </label>
                                    <div style="width:100%;display: flex;">
                                        <textarea id="txtnote" class="form-control" name="note" style="width:100%;"><?php echo $lesson_timezone_detail['description'] ?? '' ?></textarea>
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
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('timetablezone'); ?></h3>
                    </div>
                    <div class="box-body ">
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label"><?php echo $this->lang->line('time') . " " . $this->lang->line('list'); ?></div>
                            <table class="table table-striped table-bordered table-hover example" id="timetable">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('no'); ?></th>
                                        <th><?php echo $this->lang->line('timezone_name'); ?></th>
                                        <th><?php echo $this->lang->line('time_type_lesson'); ?></th>
                                        <th><?php echo $this->lang->line('description'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $count = 1;
                                    foreach ($lesson_timezone as $value) {
                                    ?>
                                        <tr>
                                            <td><?= $count; ?></td>
                                            <td class="mailbox-name"> <?php echo $value['timezone_name'] ?></td>
                                            <td class="mailbox-name"> 
                                                <?php
                                                    if($value['ampm_flag'] == 0)
                                                        echo "&nbsp;";
                                                    else if($value['ampm_flag'] == 1)
                                                        echo $this->lang->line('ampms_morning');
                                                    else
                                                        echo $this->lang->line('ampms_afternoon');
                                                ?>
                                            </td>
                                            <td class="mailbox-name"> <?php echo $value['description'] ?></td>
                                            <td class="mailbox-date pull-right">
                                                <?php
                                                if ($this->rbac->hasPrivilege('compose_timetable', 'can_edit')) {
                                                ?>
                                                    <a data-placement="left" 
                                                        href="<?php echo base_url(); ?>admin/composetimezone/edit/<?php echo $value['id'] ?>" 
                                                        class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                <?php
                                                }
                                                if ($this->rbac->hasPrivilege('compose_timetable', 'can_delete')) {
                                                ?>
                                                    <a data-placement="left" 
                                                        href="<?php echo base_url(); ?>admin/composetimezone/delete/<?php echo $value['id'] ?>" 
                                                            class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('are_you_sure_to_delete_this') ?>');">
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
    <div style="display:none;"><iframe id="frmSubmitTarget" name="frmSubmitTarget" src="none"></iframe></div>
</div>

<script>
    $(document).on('ready', function() {
        $("#timezone_name").focus();
    });

    $(document).on('click', 'input[type="submit"]', function(e) {
        e.preventDefault();
        $("#lessontimezone_form").submit();
    });

    function formClear()
    {
        $("#lesson_timezone_id").val(0);
        $("#timezone_name").val('');
        $("#lesson_time").val('');$("#lesson_time option:selected").removeAttr('selected');
        $("#txtnote").val('');$("#txtnote").html('');
        
    }
</script>