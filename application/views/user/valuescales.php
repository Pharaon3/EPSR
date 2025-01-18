<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('academics'); ?> <small><?php echo $this->lang->line('student_fees1'); ?></small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('grading_report_valuescales', 'can_add')) {
            ?>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('add') . " " . $this->lang->line('value_scale'); ?></h3>
                        </div>
                        <form id="valuescale_form" name="valuescale_form" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('level'); ?></label><small class="req"> *</small>
                                    <select autofocus="" id="level_id" name="class_id" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php
                                        foreach ($levelList as $level) {
                                        ?>
                                            <option <?php if ($level_id == $level["id"])  echo "selected"; ?> value="<?php echo $level['id'] ?>"><?php echo $level['level'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="class_id_error text-danger"><?php echo form_error('class_id'); ?></span>
                                </div>
                                <br><br>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('value_scale'); ?></label><small class="req"> *</small>
                                    <input type="text" id="label" name="label" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang->line('marks'); ?></label><small class="req"> *</small>
                                    <input type="number" id="marks" name="marks" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang->line('symbol'); ?></label>
                                    <input type="text" id="symbol" name="symbol" class="form-control">
                                </div>

                                <div id="competence_result"></div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-<?php
                                if ($this->rbac->hasPrivilege('grading_report_valuescales', 'can_add')) {
                                    echo "8";
                                } else {
                                    echo "12";
                                }
                                ?>">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line("grading_competences") . " " . $this->lang->line('list') ?></h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="mailbox-controls">
                            <div class="pull-right">
                            </div>
                        </div>
                        <div class="table-responsive mailbox-messages" id="transfee">
                            <table class="table table-striped table-bordered table-hover topic-list " id="headerTable" data-export-title="<?php echo $this->lang->line('competence') . " " . $this->lang->line('list') ?>" id="headerTable">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('level'); ?></th>
                                        <th><?php echo $this->lang->line('value_scale') ?></th>
                                        <th><?php echo $this->lang->line('marks'); ?></th>
                                        <th><?php echo $this->lang->line('symbol'); ?></th>
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
    function deletevaluescale(id) {
        if (confirm('<?PHP echo $this->lang->line('delete_confirm') ?>')) {
            $.ajax({
                url: base_url + 'admin/grading_result/deletevaluescale/' + id,
                success: function(res) {
                    successMsg(res.message);
                    window.location.replace("<?php echo base_url("admin/grading_result/valuescales") ?>");
                }
            })
        }
    }
</script>
<script>
    $(document).ready(function(e) {

        $("#valuescale_form").on('submit', (function(e) {
            e.preventDefault();

            var $this = $(this).find("button[type=submit]:focus");

            $.ajax({
                url: base_url + "admin/grading_result/createvaluescales",
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
                        window.location.replace("<?php echo base_url("admin/grading_result/valuescales") ?>");

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

    });
</script>
<script>
    (function($) {
        'use strict';
        $(document).ready(function() {
            initDatatable('topic-list', 'admin/grading_result/getvaluescalelist', [], ['btn-all'], 100);
        });
    }(jQuery))
</script>