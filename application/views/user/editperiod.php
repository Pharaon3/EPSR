<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('academics'); ?> <small><?php echo $this->lang->line('student_fees1'); ?></small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('eidt') . " " . $this->lang->line('period'); ?></h3>
                        </div>
                        <form id="period_form" name="period_form" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <input type="hidden" id="period_id" name="period_id" class="form-control" value="<?php echo $period['id'] ?>">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('level'); ?></label><small class="req"> *</small>
                                    <select autofocus="" id="level_id" name="level_id" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php
                                        foreach ($levelList as $level) {
                                        ?>
                                            <option <?php if (set_value('level_id',  $period['level_id']) == $level["id"])  echo "selected"; ?> value="<?php echo $level['id'] ?>"><?php echo $level['level'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="class_id_error text-danger"><?php echo form_error('level_id'); ?></span>
                                </div>
                                
                                <br><br>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('period'); ?></label><small class="req"> *</small>
                                    <input type="text" id="label" name="label" class="form-control" value="<?php echo set_value('label',  $period['label']) ?>">
                                    <span class="text-danger"><?php echo form_error('label'); ?></span>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang->line('start'); ?></label><small class="req"> *</small>
                                    <select autofocus="" id="start_month" name="start_month" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php foreach ($monthlist as $m_key => $month) { ?>
                                                <option value="<?php echo $m_key ?>" <?php
                                                if (set_value('start_month',  $period['start_month']) == $m_key) {
                                                    echo "selected =selected";
                                                }
                                                ?>><?php echo $month; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="class_id_error text-danger"><?php echo form_error('start_month'); ?></span>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang->line('end'); ?></label><small class="req"> *</small>
                                    <select autofocus="" id="end_month" name="end_month" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php foreach ($monthlist as $m_key => $month) { ?>
                                                <option value="<?php echo $m_key ?>" <?php
                                                if (set_value('end_month',  $period['end_month']) == $m_key) {
                                                    echo "selected =selected";
                                                }
                                                ?>><?php echo $month; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="class_id_error text-danger"><?php echo form_error('end_month'); ?></span>
                                </div>

                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line("period") . " " . $this->lang->line('list') ?></h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="mailbox-controls">
                            <div class="pull-right">
                            </div>
                        </div>
                        <div class="table-responsive mailbox-messages" id="transfee">
                            <table class="table table-striped table-bordered table-hover topic-list " id="headerTable" data-export-title="<?php echo $this->lang->line('period') . " " . $this->lang->line('list') ?>" id="headerTable">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('level'); ?></th>
                                        <th><?php echo $this->lang->line('period'); ?></th>
                                        <th><?php echo $this->lang->line('start')?></th>
                                        <th><?php echo $this->lang->line('end'); ?></th>
                                        <th class="mailbox-date text-right noExport "><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="mailbox-controls">
                            <div class="pull-right">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            </div>
        </div>
    </section>

</div>
<script>
    function deleteperiod(id) {
        if (confirm('<?PHP echo $this->lang->line('delete_confirm') ?>')) {
            $.ajax({
                url: base_url + 'admin/grading_period/delete/' + id ,
                success: function(res) {
                    successMsg(res.message);
                    window.location.replace("<?php echo base_url("admin/grading_period") ?>");
                }
            })
        }
    }
</script>
<script>

    $("#period_form").on('submit', (function(e) {
        e.preventDefault();

        var $this = $(this).find("button[type=submit]:focus");

        $.ajax({
            url: base_url + "admin/grading_period/update",
            type: "POST",
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $this.button('loading');
            },
            success: function(res) {
                if (res.status == "fail") {
                    var message = "";
                    $.each(res.error, function(index, value) {
                        message += value;
                    });
                    errorMsg(message);
                } else {
                    successMsg(res.message);
                    window.location.replace("<?php echo base_url("admin/grading_period") ?>");
                }
            },
            error: function(xhr) { // if error occured
                alert("Error occured.please try again");
                $this.button('reset');
            },
            complete: function() {
                $this.button('reset');
            }

        });


    }));
</script>
<script>
    (function($) {
        'use strict';
        $(document).ready(function() {
            initDatatable('topic-list', 'admin/grading_period/getlist', [], ['btn-all'], 100);
        });
    }(jQuery))
</script>