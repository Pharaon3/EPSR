<style>
    .tb-p {
        width: 100%;
        word-break: break-word;
        overflow: hidden;
        /* text-overflow: ellipsis; */
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
    </section>
    <section class="content">
        <div class="row">
            <?php if ($this->rbac->hasPrivilege('nurse_dept_search', 'can_view')) { ?>
                <!-- start left column -->
                <div class="col-md-4">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title" id="nurse_editbox_title"><?php echo $this->lang->line('add') . " " . $this->lang->line('nurse'); ?></h3>
                        </div><!-- /.box-header -->
                        <form id="form1" action="<?php echo site_url('admin/nurse') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                            <div class="box-body">
                                <?php echo $this->session->flashdata('nurse_msg') ?>
                                <input type="hidden" id="nurse_id" name="nurse_id" value="0">
                                <div class="form-group">
                                    <label for="student_id"><?php echo $this->lang->line('admission_no'); ?> : <span class="admission_no"><?php echo set_value('admission_no'); ?></span></label>
                                    <input type="text" class="admission_no" name="admission_no" class="form-control" value="<?php echo set_value('admission_no'); ?>" hidden />
                                    <input type="text" class="student_id" name="student_id" class="form-control" value="<?php echo set_value('student_id'); ?>" hidden />
                                    <span class="text-danger"><?php echo form_error('student_id'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="student_name"><?php echo $this->lang->line('student') . " " . $this->lang->line('name'); ?> : <span class="student_name"><?php echo set_value('student_name'); ?></span></label>
                                    <input type="text" class="student_name" name="student_name" class="form-control" value="<?php echo set_value('student_name'); ?>" hidden />
                                    <span class="text-danger"><?php echo form_error('student_name'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="guardian_name"><?php echo $this->lang->line('guardian_name'); ?> : <span class="guardian_name"><?php echo set_value('guardian_name'); ?></span></label>
                                    <input type="text" class="guardian_name" name="guardian_name" class="form-control" value="<?php echo set_value('guardian_name'); ?>" hidden />
                                    <span class="text-danger"><?php echo form_error('guardian_name'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="guardian_phone1"><?php echo $this->lang->line('guardian_phone'); ?> 1 : <span class="guardian_phone1"><?php echo set_value('guardian_phone1'); ?></span></label>
                                    <input type="text" class="guardian_phone1" name="guardian_phone1" class="form-control" value="<?php echo set_value('guardian_phone1'); ?>" hidden />
                                    <span class="text-danger"><?php echo form_error('guardian_phone1'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="guardian_phone2"><?php echo $this->lang->line('guardian_phone'); ?> 2 : <span class="guardian_phone2"><?php echo set_value('guardian_phone2'); ?></span></label>
                                    <input type="text" class="guardian_phone2" name="guardian_phone2" class="form-control" value="<?php echo set_value('guardian_phone2'); ?>" hidden />
                                    <span class="text-danger"><?php echo form_error('guardian_phone2'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="guardian_email"><?php echo $this->lang->line('guardian_email'); ?> : <span class="guardian_email"><?php echo set_value('guardian_email'); ?></span></label>
                                    <input type="text" class="guardian_email" name="guardian_email" class="form-control" value="<?php echo set_value('guardian_email'); ?>" hidden />
                                    <span class="text-danger"><?php echo form_error('guardian_email'); ?></span>
                                </div>

                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="pwd"><?php echo $this->lang->line('date'); ?></label>
                                        <small class="req"> *</small>
                                        <input type="text" id="date" name="date" class="form-control date" value="<?php echo set_value('date', date($this->customlib->getSchoolDateFormat())); ?>" readonly="">
                                        <span class="text-danger"><?php echo form_error('date'); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description"><?php echo $this->lang->line('content'); ?></label>
                                    <small class="req"> *</small>
                                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo set_value('description'); ?></textarea>
                                    <span class="text-danger"><?php echo form_error('description'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('attach_document'); ?></label>
                                    <div><input class="filestyle form-control" type='file' name='file' />
                                    </div>
                                    <span class="text-danger"><?php echo form_error('file'); ?></span>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" name="submit" id="send_mail" hidden value="sendmail" class="btn btn-info pull-left"><?php echo $this->lang->line('send_mail_to_guardian'); ?></button>
                                <button type="submit" name="submit" value="save" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end left column -->
                <!-- start right column -->
                <div class="col-md-<?php
                                    if ($this->rbac->hasPrivilege('nurse_dept_search', 'can_view')) {
                                        echo "8";
                                    } else {
                                        echo "12";
                                    }
                                    ?>">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('please_select_student'); ?></h3>
                        </div>
                        <form role="form" action="<?php echo site_url('student/searchvalidation') ?>" method="post" class="class_search_form">
                            <?php if ($this->session->flashdata('msg')) { ?>
                                <div class="alert">
                                    <?php echo $this->session->flashdata('msg') ?>
                                </div>
                            <?php } ?>
                            <div class="row" style="margin:10px;">
                                <div class="col-md-6">
                                    <div class="row">
                                        <?php echo $this->customlib->getCSRF(); ?>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('class'); ?></label> <small class="req"> *</small>
                                                <select autofocus="" id="class_id" name="class_id" class="form-control">
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    <?php
                                                    $count = 0;
                                                    foreach ($classlist as $class) {
                                                    ?>
                                                        <option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id']) {
                                                                                                        echo "selected=selected";
                                                                                                    }
                                                                                                    ?>><?php echo $class['class'] ?></option>
                                                    <?php
                                                        $count++;
                                                    }
                                                    ?>
                                                </select>
                                                <span class="text-danger" id="error_class_id"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('section'); ?></label>
                                                <select id="section_id" name="section_id" class="form-control">
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--./col-md-6-->
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('search_by_keyword'); ?></label>
                                                <input type="text" name="search_text" id="search_text" class="form-control" value="<?php echo set_value('search_text'); ?>" placeholder="<?php echo $this->lang->line('search_by_student_name'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button type="submit" name="search" value="search_full" class="btn btn-primary pull-right btn-sm checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <!-- student list begin -->
                            <div class="col-md-12">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                        <i class="fa fa-users"></i>
                                        <?php echo $this->lang->line('student') . " " . $this->lang->line('list'); ?>
                                    </h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <div>
                                        <table class="table table-hover table-striped table-bordered student-list">
                                            <thead>
                                                <tr>
                                                    <th><?php echo $this->lang->line('admission_no'); ?></th>
                                                    <th><?php echo $this->lang->line('student_name'); ?></th>
                                                    <th><?php echo $this->lang->line('class'); ?></th>
                                                    <th><?php echo $this->lang->line('date_of_birth'); ?></th>
                                                    <th><?php echo $this->lang->line('gender'); ?></th>
                                                    <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- student list end -->
                    </div>

                    <!-- mediacl report list begin -->
                    <div class="box box-primary" id="report_list" style="display:none;">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('report') . " " . $this->lang->line('list'); ?></h3>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="box-body table-responsive">
                                    <div class="download_label"> <?php echo $this->lang->line('report') . " " . $this->lang->line('list'); ?> </div>
                                    <div>
                                        <table class="table table-hover table-striped table-bordered nurse-list">
                                            <thead>
                                                <tr>
                                                    <th><?php echo $this->lang->line('id') ?></th>
                                                    <th><?php echo $this->lang->line('content') ?></th>
                                                    <th><?php echo $this->lang->line('attach_document'); ?></th>
                                                    <th><?php echo $this->lang->line('created_by'); ?></th>
                                                    <th><?php echo $this->lang->line('date') ?></th>
                                                    <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- mediacl report list end -->
                </div>
                <!-- end right column -->
            <?php } ?>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script>
    var btn_format = [{
            extend: 'copy',
            text: '<i class="fa fa-files-o"></i>',
            titleAttr: 'Copy',
            className: "btn-copy",
            title: $('.student-list').data("exportTitle"),
            exportOptions: {
                columns: ["thead th:not(.noExport)"]
            }
        },
        {
            extend: 'excel',
            text: '<i class="fa fa-file-excel-o"></i>',
            titleAttr: 'Excel',
            className: "btn-excel",
            title: $('.student-list').data("exportTitle"),
            exportOptions: {
                columns: ["thead th:not(.noExport)"]
            }
        },
        {
            extend: 'csv',
            text: '<i class="fa fa-file-text-o"></i>',
            titleAttr: 'CSV',
            className: "btn-csv",
            title: $('.student-list').data("exportTitle"),
            exportOptions: {
                columns: ["thead th:not(.noExport)"]
            }
        },
        {
            extend: 'pdf',
            text: '<i class="fa fa-file-pdf-o"></i>',
            titleAttr: 'PDF',
            className: "btn-pdf",
            title: $('.student-list').data("exportTitle"),
            exportOptions: {
                columns: ["thead th:not(.noExport)"]
            },

        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i>',
            titleAttr: 'Print',
            className: "btn-print",
            title: $('.student-list').data("exportTitle"),
            customize: function(win) {

                $(win.document.body).find('th').addClass('display').css('text-align', 'center');
                $(win.document.body).find('table').addClass('display').css('font-size', '14px');
                $(win.document.body).find('h1').css('text-align', 'center');
            },
            exportOptions: {
                columns: ["thead th:not(.noExport)"]

            }

        }
    ];
    $(document).ready(function() {
        emptyDatatable('student-list', 'data');
        emptyDatatable('nurse-list', 'data');
        var class_id = $('#class_id').val();
        var section_id = '<?php echo set_value('section_id') ?>';
        getSectionByClass(class_id, section_id);
        $('#send_mail').hide();

        $(document).on('change', '#class_id', function(e) {
            $('#section_id').html("");
            var class_id = $(this).val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {
                    'class_id': class_id
                },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(i, obj) {
                        div_data += "<option value=" + obj.section_id + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        });

        $(document).on('submit', '.class_search_form', function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $("#report_list").css('display', 'none');
            $("input.student_id").val('');
            $("input.admission_no").val('');
            $("input.student_name").val('');
            $("input.guardian_name").val('');
            $("input.guardian_phone1").val('');
            $("input.guardian_phone2").val('');
            $("input.guardian_email").val('');
            $('#send_mail').hide();
            $("#description").val("");
            var $this = $(this).find("button[type=submit]:focus");
            var form = $(this);
            var url = form.attr('action');
            var form_data = form.serializeArray();
            form_data.push({
                name: 'search_type',
                value: $this.attr('value')
            });
            $.ajax({
                url: url,
                type: "POST",
                dataType: 'JSON',
                data: form_data, // serializes the form's elements.
                beforeSend: function() {
                    $('[id^=error]').html("");
                    $this.button('loading');

                    resetFields($this.attr('value'));
                },
                success: function(response) { // your success handler
                    if (!response.status) {
                        $.each(response.error, function(key, value) {
                            $('#error_' + key).html(value);
                        });
                    } else {
                        if ($.fn.DataTable.isDataTable('.student-list')) { // if exist datatable it will destrory first
                            $('.student-list').DataTable().destroy();
                        }
                        table = $('.student-list').DataTable({
                            "order": [[ 1, "asc" ]],
                            dom: 'frtip',
                            "language": {
                                processing: '<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span> '
                            },
                            "pageLength": 10,
                            "processing": false,
                            "serverSide": false,
                            "ajax": {
                                "url": baseurl + "admin/nurse/dtstudentlist",
                                "dataSrc": 'data',
                                "type": "POST",
                                'data': response.params,

                            },
                            "drawCallback": function(settings) {

                            }
                        });
                    }
                },
                error: function() { // your error handler
                    $this.button('reset');
                },
                complete: function() {
                    $this.button('reset');
                }
            });
        });

    });

    function resetFields(search_type) {

        if (search_type == "search_full") {
            $('#class_id').prop('selectedIndex', 0);
            $('#section_id').find('option').not(':first').remove();
        } else if (search_type == "search_filter") {

            $('#search_text').val("");
        }
    }

    function getSectionByClass(class_id, section_id) {
        if (class_id != "" && section_id != "") {
            $('#section_id').html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {
                    'class_id': class_id
                },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(i, obj) {
                        var sel = "";
                        if (section_id == obj.section_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        }
    }

    function selecteNurse(student_id, student_name, nurse_id, admission_no, guardian_name, guardian_phone1, guardian_phone2, guardian_email) {
        var base_url = '<?php echo base_url() ?>';
        $(".admission_no").html(admission_no);
        $("input.admission_no").val(admission_no);
        $("input.student_id").val(student_id);
        $(".student_name").html(student_name);
        $("input.student_name").val(student_name);
        $("#nurse_id").val(nurse_id);
        $(".guardian_name").html(guardian_name);
        $("input.guardian_name").val(guardian_name);
        $(".guardian_phone1").html(guardian_phone1);
        $("input.guardian_phone1").val(guardian_phone1);
        $(".guardian_phone2").html(guardian_phone2);
        $("input.guardian_phone2").val(guardian_phone2);
        $(".guardian_email").html(guardian_email);
        $("input.guardian_email").val(guardian_email);

        if (guardian_email) {
            $('#send_mail').show();
        }
        if (nurse_id == '0') { // add
            $('#nurse_editbox_title').html("<?php echo $this->lang->line('add') .' ' . $this->lang->line('nurse'); ?>");
            $("#report_list").css('display', 'block');
            $("#description").val("");
            if ($.fn.DataTable.isDataTable('.nurse-list')) { // if exist datatable it will destrory first
                $('.nurse-list').DataTable().destroy();
            }

            var params = {
                'student_id': student_id,
                'admission_no': admission_no,
                'student_name': student_name,
                'guardian_name': guardian_name,
                'guardian_phone1': guardian_phone1,
                'guardian_phone2': guardian_phone2,
                'guardian_email': guardian_email
            };

            table = $('.nurse-list').DataTable({
                dom: 'Bfrtip',
                buttons: btn_format,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span> '
                },
                "pageLength": 10,
                "processing": false,
                "serverSide": false,
                "ajax": {
                    "url": baseurl + "admin/nurse/getNurseListByStudentId",
                    "dataSrc": 'data',
                    "type": "POST",
                    'data': params,
                },
                "drawCallback": function(settings) {}
            });
        } else { // edit
            $('#nurse_editbox_title').html("<?php echo $this->lang->line('edit') . ' ' . $this->lang->line('nurse'); ?>" + ": #" + nurse_id);
            var base_url = '<?php echo base_url() ?>';
            $.ajax({
                type: "POST",
                url: base_url + "admin/nurse/getNurse",
                data: {
                    'nurse_id': nurse_id
                },
                dataType: "json",
                success: function(data) {
                    if (data.status == "success") {
                        $("#description").val(data.result.description);
                    }
                }
            });
        }
    }

    function showNurseList(student_id, student_name, admission_no, guardian_name, guardian_phone1, guardian_phone2, guardian_email) {
        var base_url = '<?php echo base_url() ?>';
        $("#report_list").css('display', 'block');
        if ($.fn.DataTable.isDataTable('.nurse-list')) { // if exist datatable it will destrory first
            $('.nurse-list').DataTable().destroy();
        }

        var params = {
            'student_id': student_id,
            'admission_no': admission_no,
            'student_name': student_name,
            'guardian_name': guardian_name,
            'guardian_phone1': guardian_phone1,
            'guardian_phone2': guardian_phone2,
            'guardian_email': guardian_email
        };

        table = $('.nurse-list').DataTable({
            dom: 'Bfrtip',
            buttons: btn_format,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span> '
            },
            "pageLength": 10,
            "processing": false,
            "serverSide": false,
            "ajax": {
                "url": baseurl + "admin/nurse/getNurseListByStudentId",
                "dataSrc": 'data',
                "type": "POST",
                'data': params,
            },
            "drawCallback": function(settings) {

            }
        });
    }

    function deleteNurse(student_id, student_name, nurse_id, admission_no, guardian_name, guardian_phone1, guardian_phone2, guardian_email) {
        var base_url = '<?php echo base_url() ?>';
        var delete_str = "<?php echo $this->lang->line('delete_confirm') ?>";
        if (confirm(delete_str)) {
            $.ajax({
                type: "POST",
                url: base_url + "admin/nurse/deleteNurse",
                data: {
                    'nurse_id': nurse_id
                },
                dataType: "json",
                success: function(data) {
                    if (data.status == "success") {
                        showNurseList(student_id, student_name, admission_no, guardian_name, guardian_phone1, guardian_phone2, guardian_email);
                    }
                }
            });
        }
    }
</script>