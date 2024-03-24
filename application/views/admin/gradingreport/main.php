
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php
//$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-user-plus"></i> <?php echo $this->lang->line('student_information'); ?> <small><?php echo $this->lang->line('student1'); ?></small>
        </h1>
    </section>
    <style type="text/css">
        @media (min-width: 1024px) {
            .row-eq-height {
                display: flex;
            }
            tfoot { visibility: hidden; }
            .right_bd {
                border-right: double 4px #d4d4d4;
            }
        }

        .grading_report_panel_title {
            padding-left: 4px;
            font-size: 17px;
            padding-top: 7px;
            padding-bottom: 4px;
            border-bottom: solid 1px #d4d4d4;
        }

        .grading_report_panel_body {
            padding-left: 4px;
        }

        .student-list tbody tr {
            cursor: pointer;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <div class="box-body">
                        <form role="form" action="<?php echo site_url('admin/grading_result/searchvalidation') ?>" method="post" class="class_search_form">
                            <?php if ($this->session->flashdata('msg')) { ?> <div class="alert alert-success"> <?php echo $this->session->flashdata('msg') ?> </div> <?php } ?>
                            <div class="row">
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
                                                        <option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id', $class_id) == $class['id']) {
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
                                                <button id="search_filter" type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
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
                                                <input type="text" name="search_text" id="search_text" class="form-control" value="<?php echo set_value('search_text', $search_text); ?>" placeholder="<?php echo $this->lang->line('search_by_student_name'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button id="search_full" type="submit" name="search" value="search_full" class="btn btn-primary pull-right btn-sm checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!--./col-md-6-->
                            </div>
                            <!--./row-->
                        </form>
                    </div>

                    <div class="box-body">
                        <div class="row row-eq-height">
                            <div class="col-md-3 right_bd">
                                <div class="allreportbtn_container">
                                    <button id="viewallreportbtn" class="btn btn-primary btn-sm checkbox-toggle"  disabled   onclick="printallview()"> <?php echo $this->lang->line('all'); ?> <?php echo $this->lang->line('report'); ?></button>
                                </div>
                                <div class="table-responsive" id="transfee">
                                    <table class="table table-striped table-bordered table-hover student-list" data-export-title="<?php echo $this->lang->line('student') . " " . $this->lang->line('list'); ?>">
                                        <thead>
                                            <tr>
                                                <th><?php echo $this->lang->line('admission_no'); ?></th>
                                                <th><?php echo $this->lang->line('no'); ?></th>
                                                <th><?php echo $this->lang->line('student_name'); ?></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <!-- <div class="grading_report_panel_title">View Grading Report</div> -->
                                <div class="grading_report_panel_body"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    function printview(id) {
        var base_url = '<?php echo base_url() ?>';
        var period_id = $('#period_id').val();
        var class_id = $('#class_id').val();
        var section_id = $('#section_id').val();
        $.ajax({
            type: "POST",
            url: base_url + "admin/grading_result/printCard",
            data: {
                id: id,
                period_id: period_id,
                class_id: class_id,
                section_id: section_id,
            }, // serializes the form's elements.
            dataType: "JSON", // serializes the form's elements.
            success: function(response) {
                //console.log(response);
                Popup(response.page);
            },
            error: function(xhr) { // if error occured
                alert("Error occured.please try again");
            }
        });
    }

    function printallview() {
        var base_url = '<?php echo base_url() ?>';
        var period_id = $('#period_id').val();
        var formdata = $('#viewallreportbtn').attr('data_form');
        var $this = $('#viewallreportbtn');
        formdata = JSON.parse(formdata);
        formdata['id'] = 'all';
        formdata['period_id'] = period_id;
        $.ajax({
            type: "POST",
            url: base_url + "admin/grading_result/printCard",
            data: formdata, // serializes the form's elements.
            dataType: "JSON", // serializes the form's elements.
            beforeSend: function() {
                $this.button('loading');
            },
            success: function(response) {
                $this.button('reset');
                Popup(response.page);
            },
            error: function(xhr) { // if error occured
                $this.button('reset');
                console.log(xhr)
                alert("Error occured.please try again");
            }
        });

    }

    function Popup(data) {
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";

        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        // frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/idcard.css">');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function() {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
        return true;
    }

    var allstudentsreport = [];

    function viewreport(id, period = '') {
        var base_url = '<?php echo base_url() ?>';
        period = $('#period_id').val();
        if (period == undefined) period = '';

        alledittype = $('#alledittype').val();
        if (alledittype) {
            var serializearray = $(':input[type="radio"]').serializeArray();
            var stds_id = $('input[name="student_session_id"]').val();
            allstudentsreport["std" + stds_id] = serializearray;
        }

        $.ajax({
            type: "GET",
            url: base_url + "admin/grading_result/viewreport/" + id + "/" + period,
            data: {
                alledittype: alledittype
            },
            success: function(response) {
                $('.grading_report_panel_body').html(response);
            },
            error: function(xhr) { // if error occured
                console.log(xhr);
                alert("Error occured.please try again");
            }
        });
    }

    function resetFields(search_type) {
        if (search_type == "search_full") {
            $('#class_id').prop('selectedIndex', 0);
            $('#section_id').find('option').not(':first').remove();
        } else if (search_type == "search_filter") {
            $('#search_text').val("");
        }
    }

    function editReportByCompetence(competenceId) {
        var edit_txt = "<?php echo $this->lang->line('edit'); ?>";
        var cancel_txt = "<?php echo $this->lang->line('cancel'); ?>";
        var type = $('#edit_btn_' + competenceId).attr('data_type');
        if (type == "edit") {
            $('#edit_btn_' + competenceId).attr('data_type', "cancel");
            $('#edit_btn_' + competenceId).html(cancel_txt);
            $('.td_competence_' + competenceId + ' .marklabel').hide();
            $('.td_competence_' + competenceId + ' .markedit').each(function() {
                $(this).html($(this).attr('data_innerhtml'));
            });
        } else {
            $('#edit_btn_' + competenceId).attr('data_type', "edit");
            $('#edit_btn_' + competenceId).html(edit_txt);
            $('.td_competence_' + competenceId + ' .marklabel').show();
            $('.td_competence_' + competenceId + ' .markedit').each(function() {
                $(this).html("");
            });
        }
        if ($('.edit-competence-report-btn[data_type="cancel"]').length > 0) {
            $('.save_competence_edit_btn_container').css('display', 'block');
        } else {
            $('.save_competence_edit_btn_container').css('display', 'none');
        }
    }


    function editReportBySubject() {
        var edit_txt = "<?php echo $this->lang->line('edit'); ?>";
        var cancel_txt = "<?php echo $this->lang->line('cancel'); ?>";
        var type = $('#second_edit_btn').attr('data_type');
        if (type == "edit") {
            $('#second_edit_btn').attr('data_type', "cancel");
            $('#second_save_btn').css('display', "block");
            $('#second_edit_btn').html(cancel_txt);
            $('.td_subject .marklabel').hide();
            $('.td_subject .markedit').each(function() {
                $(this).html($(this).attr('data_innerhtml'));
            });
        } else {
            $('#second_edit_btn').attr('data_type', "edit");
            $('#second_save_btn').css('display', "none");
            $('#second_edit_btn').html(edit_txt);
            $('.td_subject .marklabel').show();
            $('.td_subject .markedit').each(function() {
                $(this).html("");
            });
            total_competence_edit_count--
        }
    }

    function saveReportBySubject() {
        var $this = $('#second_save_btn');
        $.ajax({
            type: "POST",
            url: base_url + "admin/grading_result/updatesubjectreport",
            data: $("#update_subject_report").serialize(), // serializes the form's elements.
            dataType: "JSON", // serializes the form's elements.
            beforeSend: function() {
                $this.button('loading');
            },
            success: function(response) {
                if (response.success) {
                    var id = $('#student_id').val();
                    var period_id = $('#period_id').val();
                    viewreport(id, period_id);
                } else {
                    alert(response.message);
                }
                $this.button('reset');
            },
            error: function(xhr) { // if error occured
                alert("Error occured.please try again");
            }
        });
    }


    function alledit() {
        allstudentsreport = [];
        console.log('alledit');

        $('.marklabel').hide();
        $('.edit-competence-report-btn').hide();
        $('.alleditbtn').hide();
        $('.cancelalleditbtn').show();
        $('.savealleditbtn').show();
        $('.markedit').each(function() {
            $(this).html($(this).attr('data_innerhtml'));
        });
        $('#alledittype').val('1');
    }

    function cancelalledit() {
        allstudentsreport = [];
        console.log("cancelalledit");
        $('.alleditbtn').show();
        $('.edit-competence-report-btn').show();
        $('.cancelalleditbtn').hide();
        $('.savealleditbtn').hide();
        $('.marklabel').show();
        $('.markedit').each(function() {
            $(this).html('');
        });
        $('#alledittype').val('');
    }

    function savealledit() {

        var serializearray = $(':input[type="radio"]').serializeArray();

        var stds_id = $('input[name="student_session_id"]').val();
        var std_index = allstudentsreport.findIndex(std => std.stdId === stds_id);
        if (std_index >= 0) {
            allstudentsreport[std_index].report = serializearray;
        } else {
            allstudentsreport.push({
                stdId: stds_id,
                report: serializearray
            });
        }

        allstudentsreport['std' + stds_id] = serializearray;

        console.log(allstudentsreport);

        $('#alledittype').val('');
        $this = $('.savealleditbtn');

        $.ajax({
            type: "POST",
            url: base_url + "admin/grading_result/updatereport",
            data: {
                savealledit: allstudentsreport
            }, // serializes the form's elements.
            dataType: "JSON", // serializes the form's elements.
            beforeSend: function() {
                $this.button('loading');
            },
            success: function(response) {
                if (response.success) {
                    var id = $('#student_id').val();
                    var period_id = $('#period_id').val();
                    viewreport(id, period_id);
                } else {
                    alert(response.message);
                }
                $this.button('reset');
            },
            error: function(xhr) { // if error occured
                alert("Error occured.please try again");
            }
        });
    }
</script>



<script type="text/javascript">
    $(document).ready(function() {

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

        emptyDatatable('student-list', 'data');

        $(document).on('submit', '.class_search_form', function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
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

                        $('#viewallreportbtn').prop('disabled', true);
                    } else {

                        $('#viewallreportbtn').prop('disabled', false);
                        form_data_str = JSON.stringify(response.params);
                        $('#viewallreportbtn').attr('data_form', form_data_str);

                        if ($.fn.DataTable.isDataTable('.student-list')) { // if exist datatable it will destrory first
                            $('.student-list').DataTable().destroy();
                        }
                        table = $('.student-list').DataTable({
                            // "scrollX": true,
                            "order": [
                                [2, "asc"]
                            ],

                            dom: 'Bfrtip',
                            buttons: [],
                            "language": {
                                processing: '<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span> '
                            },
                            "pageLength": 100,
                            "processing": true,
                            "serverSide": true,
                            "bSort":false,
                        "ajax": {
                                "url": baseurl + "admin/grading_result/dtstudentlist",
                                "dataSrc": 'data',
                                "type": "POST",
                                'data': response.params,

                            },
                            "drawCallback": function(settings) {

                                $('.detail_view_tab').html("").html(settings.json.student_detail_view);
                            }

                        });
                    }
                },
                error: function() { // your error handler
                    $this.button('reset');
                    $('#viewallreportbtn').prop('disabled', true);
                },
                complete: function() {
                    $this.button('reset');
                }
            });
        });

        $('.student-list').on('click', 'tbody tr', function() {
            var std_id = $($(this).children("td").first().html()).attr('data_id');
            viewreport(std_id);
        })

        $(document).on('click', '#search_by_period', function(e) {
            var id = $('#student_id').val();
            var period_id = $('#period_id').val();
            viewreport(id, period_id);
        });

        $(document).on('change', '#period_id', function(e) {
            var id = $('#student_id').val();
            var period_id = $('#period_id').val();
            viewreport(id, period_id);
        });

        $(document).on('click', '.td_subject', function(e) {
            if (!$(this).find('.markedit').html().trim()) {
                $(this).find('.marklabel').hide();
                $(this).find('.markedit').html($(this).find('.markedit').attr('data_innerhtml'));
                $(this).find('input').focus();
            }
        });

        $(document).on('blur', '.td_subject input', function(e) {

            var name = $(this).attr('name');
            var val = $(this).val();
            var student_session_id = $('input[name="student_session_id"]').val();

            var $this = $(this).parents('.td_subject');
            $this.find('.marklabel').show();
            $this.find('.markedit').html('');
            $.ajax({
                type: "POST",
                url: base_url + "admin/grading_result/updatesubjectreport",
                data: {
                    student_session_id: student_session_id,
                    subjectreportkey: name,
                    subjectreportvalue: val,
                }, // serializes the form's elements.
                dataType: "JSON", // serializes the form's elements.
                beforeSend: function() {
                    $this.button('loading');
                },
                success: function(response) {
                    if (response.success) {
                        var id = $('#student_id').val();
                        var period_id = $('#period_id').val();
                        viewreport(id, period_id);
                    } else {
                        alert(response.message);
                    }
                    $this.button('reset');
                },
                error: function(xhr) { // if error occured
                    alert("Error occured.please try again");
                }
            });
        });

        $(document).on('blur', '#std_observation', function(e) {
            $this = $(this);
            var val = $(this).val();
            var student_session_id = $('input[name="student_session_id"]').val();
            var index = $('input[name="editList"]:checked').val();
            $.ajax({
                type: "POST",
                url: base_url + "admin/grading_result/updateObservation",
                data: {
                    student_session_id: student_session_id,
                    index:index,
                    observation: val,
                }, // serializes the form's elements.
                dataType: "JSON", // serializes the form's elements.
                success: function(response) {
                    if (response.success) {
                        successMsg(response.message);
                    } else {
                        errorMsg(response.message);
                    }
                },
                error: function(xhr) { // if error occured
                    alert("Error occured.please try again");
                }
            });
        });

        $(document).on('keypress', '.td_subject input', function(e) {
            var key = e.which;
            if (key == 13) // the enter key code
            {
                $(this).trigger('blur');
            }
        });

        $(document).on('submit', '#update_subject_report', function(e) {
            e.preventDefault();
        });

        $(document).on('click', '#save_competence_edit', function(e) {
            var $this = $(this);
            $.ajax({
                type: "POST",
                url: base_url + "admin/grading_result/updatereport",
                data: $("#update_competence_report").serialize(), // serializes the form's elements.
                dataType: "JSON", // serializes the form's elements.
                beforeSend: function() {
                    $this.button('loading');
                },
                success: function(response) {
                    if (response.success) {
                        var id = $('#student_id').val();
                        var period_id = $('#period_id').val();
                        viewreport(id, period_id);
                    } else {
                        alert(response.message);
                    }
                    $this.button('reset');
                },
                error: function(xhr) { // if error occured
                    alert("Error occured.please try again");
                }
            });
        });

    });
</script>