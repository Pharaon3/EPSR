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
            if ($this->rbac->hasPrivilege('grading_report_indicators', 'can_add')) {
            ?>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('add') . " " . $this->lang->line('indicators_achievement'); ?></h3>
                        </div>
                        <form id="indicators_form" name="indicators_form" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('level'); ?></label><small class="req"> *</small>
                                    <select autofocus="" id="level_id" name="level_id" onchange="getClsPeriByLevel(this.value, 0, 0)" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php
                                        foreach ($levelList as $level) {
                                        ?>
                                            <option <?php if ($level_id == $level["id"])  echo "selected"; ?> value="<?php echo $level['id'] ?>"><?php echo $level['level'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="class_id_error text-danger"><?php echo form_error('level_id'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                    <select id="class_id" name="class_id" onchange="getCompetences('<?php echo $competence_id; ?>')" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    </select>
                                    <span class="class_id_error text-danger"><?php echo form_error('class_id'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('period'); ?></label><small class="req"> *</small>
                                    <select id="period_id" name="period_id" onchange="getCompetences('<?php echo $competence_id; ?>')" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    </select>
                                    <span class="section_id_error text-danger"><?php echo form_error('period_id'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('competence'); ?></label><small class="req"> *</small>
                                    <select id="competence_id" name="competence_id" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    </select>
                                    <span class="section_id_error text-danger"><?php echo form_error('competence_id'); ?></span>
                                </div>
                                <br><br>
                                <div class="form-group">
                                    <?php ?>
                                    <lebel class="btn btn-xs btn-info pull-right" onclick="add_indicators()"><?php echo $this->lang->line('add') . " " . $this->lang->line('more'); ?></lebel>
                                </div>

                                <div id="indicators_result"></div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-<?php
                                if ($this->rbac->hasPrivilege('grading_report_indicators', 'can_add')) {
                                    echo "8";
                                } else {
                                    echo "12";
                                }
                                ?>">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line("grading_indicators") . " " . $this->lang->line('list') ?></h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="mailbox-controls">
                            <div class="pull-right">
                            </div>
                        </div>
                        <div class="table-responsive mailbox-messages" id="transfee">
                            <table class="table table-striped table-bordered table-hover topic-list " id="headerTable" data-export-title="<?php echo $this->lang->line('indicators') . " " . $this->lang->line('list') ?>" id="headerTable">
                                <thead>
                                    <tr class="hide" id="visible">
                                        <td colspan="6">
                                            <center><b><?php echo $this->lang->line("indicators") . " " . $this->lang->line('list') ?></b></center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('level'); ?></th>
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('period')?></th>
                                        <th><?php echo $this->lang->line('competence')?></th>
                                        <th><?php echo $this->lang->line('indicators'); ?></th>
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
    function deleteIndicatorsBulk(competence_id) {
        if (confirm('<?PHP echo $this->lang->line('delete_confirm') ?>')) {
            $.ajax({
                url: base_url + 'admin/grading_indicators/deleteindicatorsbulk/' + competence_id,
                success: function(res) {
                    successMsg(res.message);
                    window.location.replace("<?php echo base_url("admin/grading_indicators") ?>");
                }
            })
        }
    }
</script>
<script>
    $(document).ready(function(e) {
        getClsPeriByLevel("<?php echo $level_id ?>", "<?php echo $class_id ?>", "<?php echo $period_id ?>");
    });

    function getClsPeriByLevel(level_id, class_id, period_id) {
        if (level_id != "") {
            $('#class_id').html("");
            $('#period_id').html("");
            var base_url = '<?php echo base_url() ?>';
            var cls_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            var peri_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "admin/grading_competence/getByLevel",
                data: {
                    'level_id': level_id
                },
                dataType: "json",
                beforeSend: function() {
                    $('#class_id').addClass('dropdownloading');
                    $('#period_id').addClass('dropdownloading');
                },
                success: function(data) {
                    $.each(data.class, function(i, obj) {
                        var sel = "";
                        if (class_id == obj.id) {
                            sel = "selected";
                        }
                        cls_data += "<option value=" + obj.id + " " + sel + ">" + obj.class + "</option>";
                    });
                    $('#class_id').html(cls_data);

                    $.each(data.period, function(i, obj) {
                        var sel = "";
                        if (period_id == obj.id) {
                            sel = "selected";
                        }
                        peri_data += "<option value=" + obj.id + " " + sel + ">" + obj.label + "</option>";
                    });
                    $('#period_id').html(peri_data);
                },
                complete: function() {
                    $('#class_id').removeClass('dropdownloading');
                    $('#period_id').removeClass('dropdownloading');
                }
            });
        }
    }

    function getCompetences(competence_id) {
        var class_id = $('#class_id').val();
        var period_id = $('#period_id').val();
        var base_url = '<?php echo base_url() ?>';
        var com_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
        $.ajax({
            type: "GET",
            url: base_url + "admin/grading_indicators/getCompetences",
            data: {
                'class_id': class_id,
                'period_id': period_id
            },
            dataType: "json",
            beforeSend: function() {
                $('#competence_id').addClass('dropdownloading');
            },
            success: function(data) {
                $.each(data, function(i, obj) {
                    var sel = "";
                    if (competence_id == obj.id) {
                        sel = "selected";
                    }
                    com_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
                });
                $('#competence_id').html(com_data);
            },
            complete: function() {
                $('#competence_id').removeClass('dropdownloading');
            }
        });
    }

    add_indicators();

    function add_indicators() {
        var id = makeid(8);
        $('#indicators_result').append('<div class="form-group" id="' + id + '"><label><?php echo $this->lang->line("indicators") . ' ' . $this->lang->line('name'); ?></label><small class="req"> *</small><br><input type="text" name="indicators[]" class="lessinput" /> <span  onclick="remove_indicators(' + id + ')" class="section_id_error text-danger">&nbsp;<i class="fa fa-remove"></i></span></div>');
    }

    function remove_indicators(id) {
        $('#' + id).html("");
    }

    function makeid(length) {
        var result = '';
        var characters = '0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    $("#indicators_form").on('submit', (function(e) {
        e.preventDefault();

        var $this = $(this).find("button[type=submit]:focus");

        $.ajax({
            url: base_url + "admin/grading_indicators/createindicators",
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
                    window.location.replace("<?php echo base_url("admin/grading_indicators") ?>");

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
            initDatatable('topic-list', 'admin/grading_indicators/getindicatorslist', [], [], 100);
        });
    }(jQuery))
</script>