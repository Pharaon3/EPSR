<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
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

        .student-list th,
        .student-list td {
            border: 1px solid #ddd !important;
            text-align: center !important;
            vertical-align: bottom !important;
        }

        .darksalmon {
            background-color: darksalmon !important;
        }

        .lightgreen {
            background-color: lightgreen !important;
        }

        .yellow {
            background-color: yellow !important;
        }

        .lightblue {
            background-color: lightblue !important;
        }

        .pink {
            background-color: #f3a6c0 !important;
        }

        .lightpink {
            background-color: #fad9e0 !important;
        }
        .red_text {
            color: red !important;
        }

        .td-input {
            border: none !important;
            background: transparent !important;
            max-width: 60px !important;
            text-align: center;
            outline: unset !important;
        }

        .disable-addtest {
            visibility: hidden;
        }

        .subjectlabelth {
            font-weight: bold;
            font-size: 16px;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
        .vertical-lr {
            writing-mode: vertical-lr;
        }

        .rotated {
            transform: rotate(180deg);
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
                        <form role="form" action="<?php echo site_url('admin/grading_result/searchvalidation') ?>" method="post" class="class_search_subject_form">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if ($this->session->flashdata('msg')) { ?>
                                        <?php echo $this->session->flashdata('msg') ?>
                                    <?php } ?>
                                    <?php echo $this->customlib->getCSRF(); ?>
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                        <select autofocus="" id="searchclassid" name="class_id" onchange="getSectionByClass(this.value, 0, 'secid')" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($classlist as $class) {
                                            ?>
                                                <option <?php
                                                        if ($class_id == $class["id"]) {
                                                            echo "selected";
                                                        }
                                                        ?> value="<?php echo $class['id'] ?>"><?php echo $class['class'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="class_id_error text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('section'); ?></label><small class="req"> *</small>
                                        <select id="secid" name="section_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="section_id_error text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('subject'); ?></label><small class="req"> *</small>
                                        <select id="subid" name="subject_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="subject_id_error text-danger"><?php echo form_error('subject_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button id="search_filter" type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="subject_group_subjects_id" value="">
                            <!--./row-->
                        </form>
                    </div>

                    <div class="box-body">
                        <div>
                            <?php if ($this->rbac->hasPrivilege('grading_report_results', 'can_edit')) { ?>
                                <button id="save_report_btn" onclick="saveSecondaryEdit()" disabled class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-save"></i> <?php echo $this->lang->line('save'); ?></button>
                                <button id="cancel_report_btn" style="margin-right: 10px" onclick="cancelSecondaryEdit()" disabled class="btn btn-primary btn-sm pull-right checkbox-toggle"> <?php echo $this->lang->line('cancel'); ?></button>
                            <?php } ?>
                            <button id="print_report_btn" style="margin-right: 10px" onclick="printsubjectreport()" disabled class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-print"></i> <?php echo $this->lang->line('view'); ?></button>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive" id="transfee">
                                    
                                    <table class="table table-striped table-bordered table-hover student-list" data-export-title="<?php echo $this->lang->line('student') . " " . $this->lang->line('list'); ?>">
                                        <thead>
                                            <tr>
                                                <th class="subjectlabelth" colspan="3" rowspan="2"></th>
                                                <!-- <th class="pink" colspan="1">COMPETENCIAS FUNDAMENTALES</th> -->
                                                <th class="pink" colspan="4" rowspan="2">Comunicativa</th>
                                                <th class="pink" colspan="4" rowspan="2">• Pensamiento Lógico, <br> Creativo y Crítico <br> • Resolución de Problemas</th>
                                                <th class="pink" colspan="4" rowspan="2">• Científica y Tecnológica <br> • Ambiental y de la Salud</th>
                                                <th class="pink" colspan="4" rowspan="2">• Ética y Ciudadana <br> • Desarrollo Personal <br> y Espiritual</th>
                                                <th class="pink" colspan="4" rowspan="2">PROMEDIO GRUPO <br> DE COMPETENCIAS <br> ESPECÍFICAS</th>
                                                <th class="lightpink vertical-lr rotated" colspan="1" rowspan="3">CALIFICACIÓN <br> FINAL DEL ÁREA</th>
                                                <th class="pink" colspan="4">CALIFICACIÓN <br> COMPLETIVA</th>
                                                <th class="pink" colspan="4">CALIFICACIÓN <br> EXTRAORDINARIA</th>
                                                <th class="pink" colspan="2">EVALUACIÓN <br> ESPECIAL</th>
                                                <th class="pink" colspan="2" rowspan="2">SITUACIÓN <br> FINAL EN LA <br> ASIGNATURA</th>
                                            </tr>
                                            <tr>
                                                <th class="pink vertical-lr rotated" rowspan="2">50% C. F.</th>
                                                <th class="pink vertical-lr rotated" rowspan="2">C.E.C.</th>
                                                <th class="pink vertical-lr rotated" rowspan="2">50% C.E.C.</th>
                                                <th class="lightpink vertical-lr rotated" rowspan="2">C.C.F.</th>
                                                <th class="pink vertical-lr rotated" rowspan="2">30% C.F.</th>
                                                <th class="pink vertical-lr rotated" rowspan="2">C.E. EX</th>
                                                <th class="pink vertical-lr rotated" rowspan="2">70% C.E. EX</th>
                                                <th class="lightpink vertical-lr rotated" rowspan="2">C.EX.F.</th>
                                                <th class="pink vertical-lr rotated" rowspan="2">C.F.</th>
                                                <th class="lightpink vertical-lr rotated" rowspan="2">C.E.</th>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('admission_no'); ?></th>
                                                <th><?php echo $this->lang->line('no'); ?></th>
                                                <th><?php echo $this->lang->line('student_name'); ?></th>
                                                <th class="lightpink">P1</th>
                                                <th class="lightpink">P2</th>
                                                <th class="lightpink">P3</th>
                                                <th class="lightpink">P4</th>
                                                <th class="lightpink">P1</th>
                                                <th class="lightpink">P2</th>
                                                <th class="lightpink">P3</th>
                                                <th class="lightpink">P4</th>
                                                <th class="lightpink">P1</th>
                                                <th class="lightpink">P2</th>
                                                <th class="lightpink">P3</th>
                                                <th class="lightpink">P4</th>
                                                <th class="lightpink">P1</th>
                                                <th class="lightpink">P2</th>
                                                <th class="lightpink">P3</th>
                                                <th class="lightpink">P4</th>
                                                <th class="lightpink">PC1</th>
                                                <th class="lightpink">PC2</th>
                                                <th class="lightpink">PC3</th>
                                                <th class="lightpink">PC4</th>
                                                <th class="pink">A</th>
                                                <th class="pink">R</th>
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
            </div>
        </div>
        <div class="forprintlayout" style="display: none;">
            <strong>Curso y Sección:</strong> <span id="classnameforprint"></span>. Sección <span id="sectionnameforprint"></span><br>
            <strong><?php echo $this->lang->line('subject');?>:</strong> <span id="subjectnameforprint"></span><br>
            <strong><?php echo $this->lang->line('teacher');?>:</strong> <?php echo $this->customlib->getUserData()['name'] . " " . $this->customlib->getUserData()['surname']; ?><br>
            <style type="text/css">
                .print-table{
                    width: 100% !important;
                    border-collapse: collapse;
                }
                .print-table th, .print-table td{
                    border: 1px solid #ddd !important;
                    text-align: center !important;
                    vertical-align: bottom !important;
                    padding: 5px;
                }
            </style>
            <table class="print-table" data-export-title="<?php echo $this->lang->line('student') . " " . $this->lang->line('list'); ?>">
                <thead>
                    <tr>
                        <th class="subjectlabelth" colspan="3" rowspan="2"></th>
                        <th class="darksalmon" colspan="<?php echo count($periodList) + 1 ?>">CALIFICACIONES DEL AÑO ESCOLAR</th>
                        <?php //if ($addstep > 0) { 
                        ?>
                        <th class="lightgreen" colspan="4">CALIFICACIÓN COMPLETIVA</th>
                        <?php //} 
                        ?>
                        <?php //if ($addstep > 1) { 
                        ?>
                        <th class="yellow" colspan="4">CALIFICACIÓN EXTRAORDINARIA</th>
                        <?php //} 
                        ?>
                        <th colspan="2">SITUACIÓN FINAL</th>
                        <th colspan="2">C.A.P.</th>
                    </tr>
                    <tr>
                        <th colspan="<?php echo count($periodList) ?>">Calificaciones Parciales</th>
                        <th class="lightblue" rowspan="2">C.F.</th>
                        <?php //if ($addstep > 0) { 
                        ?>
                        <th rowspan="2">50% P.C.P.</th>
                        <th rowspan="2">C.P.C.</th>
                        <th rowspan="2">50% C.P.C.</th>
                        <th class="lightblue" rowspan="2">C.C.</th>
                        <?php //} 
                        ?>
                        <?php //if ($addstep > 1) { 
                        ?>
                        <th rowspan="2">30% P.C.P.</th>
                        <th rowspan="2">C.P.EX.</th>
                        <th rowspan="2">70% C.P.EX.</th>
                        <th class="lightblue" rowspan="2">C.EX.</th>
                        <?php //} 
                        ?>
                        <th rowspan="2">A</th>
                        <th rowspan="2">R</th>
                        <th colspan="2">OPORTUNIDAD</th>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('admission_no'); ?></th>
                        <th><?php echo $this->lang->line('no'); ?></th>
                        <th><?php echo $this->lang->line('student_name'); ?></th>
                        <?php  foreach($periodList as $key=>$value) { ?>
                            <th><?php echo $value['label']; ?></th>
                        <?php } ?>
                        <th>1</th>
                        <th>2</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </section>
</div>

<script type="text/javascript">
    function printsubjectreport() {
        //console.log($('.forprintlayout').html());
        Popup($('.forprintlayout').html());
        //Popup($('#transfee').html())
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

    function getSectionByClass(class_id, section_id, select_control) {
        if (class_id != "") {
            $('#' + select_control).html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {
                    'class_id': class_id
                },
                dataType: "json",
                beforeSend: function() {
                    $('#' + select_control).addClass('dropdownloading');
                },
                success: function(data) {
                    $.each(data, function(i, obj) {
                        var sel = "";
                        if (section_id == obj.section_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";
                    });
                    $('#' + select_control).append(div_data);
                },
                complete: function() {
                    $('#' + select_control).removeClass('dropdownloading');
                }
            });
        }
    }
    $(document).on('change', '#secid', function() {
        var class_id = $('#searchclassid').val();
        var section_id = $(this).val();
        getSubjectGroup(class_id, section_id, 0, 'subid');
    });

    function getSubjectGroup(class_id, section_id, subjectgroup_id, subject_id_target) {
        if (class_id != "" && section_id != "") {

            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/subjectgroup/getGroupByClassandSection',
                data: {
                    'class_id': class_id,
                    'section_id': section_id
                },
                dataType: 'JSON',
                beforeSend: function() {
                    // setting a timeout
                    $('#' + subject_id_target).html("");
                },
                success: function(data) {
                    if (data.length > 0) {
                        getsubjectBySubjectGroup(class_id, section_id, data[0].subject_group_id, 0, 'subid');
                    } else {
                        errorMsg("No subject attached");
                    }
                },
                error: function(xhr) { // if error occured
                    alert("Error occured.please try again");
                },
            });
        }

    }

    function getsubjectBySubjectGroup(class_id, section_id, subject_group_id, subject_group_subject_id, subject_target) {
        if (class_id != "" && section_id != "" && subject_group_id != "") {

            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/subjectgroup/getGroupsubjects',
                data: {
                    'subject_group_id': subject_group_id
                },
                dataType: 'JSON',
                beforeSend: function() {
                    // setting a timeout
                    $('#' + subject_target).html("").addClass('dropdownloading');
                },
                success: function(data) {
                    $.each(data, function(i, obj) {
                        var sel = "";
                        if (subject_group_subject_id == obj.id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
                    });
                    $('#' + subject_target).append(div_data);
                },
                error: function(xhr) { // if error occured
                    alert("Error occured.please try again");

                },
                complete: function() {
                    $('#' + subject_target).removeClass('dropdownloading');
                }
            });
        }
    }

    function cancelSecondaryEdit() {
        setoriginvalue('a');
        setoriginvalue('r');
        setoriginvalue('50pcp');
        setoriginvalue('50cpc');
        setoriginvalue('cc');
        setoriginvalue('30pcp');
        setoriginvalue('70cpex');
        setoriginvalue('cex');
        setoriginvalue('cf');
        setoriginvalue('pr');
        setoriginvalue('cpc');
        setoriginvalue('cpex');
        $('#save_report_btn').prop('disabled', true);
        $('#cancel_report_btn').prop('disabled', true);
    }

    function setoriginvalue(classname) {
        $('.' + classname).each(function() {
            if (classname == 'pr') {
                $(this).val($(this).attr('data_org'));
            } else if (classname == 'cpc' || classname == 'cpex') {
                $(this).find('input').addClass($(this).attr('data_org'));
                $(this).find('input').val($(this).find('input').attr('data_org'));
            } else {
                $(this).text($(this).attr('data_org'));
                if (classname == 'cf' || classname == 'cc' || classname == 'cex') {
                    var avg = $(this).text() * 1;
                    if (avg >= 70) {
                        $(this).removeClass('red_text');
                    } else {
                        $(this).addClass('red_text');
                    }
                }
            }
        });
    }

    function saveSecondaryEdit() {
        var data = [];
        $('.student-list tbody tr').each(function() {
            var student_session_id = $(this).find('.td-input').attr('data_stdID');
            student_report = {
                student_session_id: student_session_id,
                report: []
            };
            $(this).find('.td-input').each(function() {
                var name = $(this).attr('data_column');
                var value = $(this).hasClass('disable-addtest') ? '' : $(this).val();
                student_report.report.push({
                    name: name,
                    value: value
                })
            })

            data.push(student_report);
        });
        var subject_group_subjects_id = $('#subject_group_subjects_id').val();

       
        var $this = $('#save_report_btn');
        $.ajax({
            type: "POST",
            url: base_url + "admin/grading_result/updatemultistudentsnewreport",
            data: {
                subject_group_subjects_id: subject_group_subjects_id,
                data: data
            }, // serializes the form's elements.
            dataType: "JSON", // serializes the form's elements.
            beforeSend: function() {
                $this.button('loading');
            },
            success: function(response) {
                if (response.success) {
                    if ($.fn.DataTable.isDataTable('.print-table')) { // if exist datatable it will destrory first
                        $('.print-table').DataTable().destroy();
                    }
                    
                    var data =
                    {
                        "class_id":$('#searchclassid').val(), 
                        "section_id":$('#secid').val(),
                        "subject_id":$('#subid').val(),
                    };
                ptable = $('.print-table').DataTable({
                    // "scrollX": true,
                    dom: 'Bfrtip',
                    buttons: [],
                    "language": {
                        processing: '<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span> '
                    },
                    "paging": false,
                    "ordering": false,
                    "searching": false,
                    "info":     false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": baseurl + "admin/grading_result/dteditstudentlistforprint",
                        "dataSrc": 'data',
                        "type": "POST",
                        'data': data,
                    }

                });
                    successMsg(response.msg);
                } else {
                    errorMsg(response.msg);
                }
                $this.button('reset');
            },
            error: function(xhr) { // if error occured
                alert("Error occured.please try again");
            }
        });
        
    }


    $(document).ready(function() {

        emptyDatatable('student-list', 'data');

        $(document).on('submit', '.class_search_subject_form', function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var $this = $(this).find("button[type=submit]:focus");
            var form = $(this);
            var url = form.attr('action');
            var form_data = form.serializeArray();
            form_data.push({
                name: 'search_type',
                value: 'search_edit'
            });
            $.ajax({
                url: url,
                type: "POST",
                dataType: 'JSON',
                data: form_data, // serializes the form's elements.
                beforeSend: function() {
                    $('#print_report_btn').prop('disabled', true);
                    $('[id^=error]').html("");
                    $this.button('loading');
                },
                success: function(response) { // your success handler

                    if (!response.status) {
                        $.each(response.error, function(key, value) {
                            $('.' + key + '_error').html(value);
                        });
                    } else {
                        $('#classnameforprint').html($('#searchclassid option[value="' + $('#searchclassid').val() + '"]').html());
                        $('#sectionnameforprint').html($('#secid option[value="' + $('#secid').val() + '"]').html());
                        $('#subjectnameforprint').html($('#subid option[value="' + $('#subid').val() + '"]').html());


                        $('#print_report_btn').prop('disabled', false);
                        $('#subject_group_subjects_id').val($('#subid').val());

                        $('.subjectlabelth').text($('#subid option[value="' + $('#subid').val() + '"]').html());

                        if ($.fn.DataTable.isDataTable('.student-list')) { // if exist datatable it will destrory first
                            $('.student-list').DataTable().destroy();
                        }
                        table = $('.student-list').DataTable({
                            // "scrollX": true,
                            dom: 'Bfrtip',
                            buttons: [],
                            "language": {
                                processing: '<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span> '
                            },
                            "pageLength": 100,
                            "ordering": false,
                            "searching": false,
                            "processing": true,
                            "serverSide": true,
                            "ajax": {
                                "url": baseurl + "admin/grading_result/dtneweditstudentlist",
                                "dataSrc": 'data',
                                "type": "POST",
                                'data': response.params,
                            },
                            "rowCallback": function(nRow, aData, iDisplayIndex) {
                                /* Append the grade to the default row class name */
                                $('td:eq(1)', nRow).html(iDisplayIndex + 1)
                                var period_count = <?= count($periodList) ?> * 1;
                                $('td:eq(' + (19 + period_count) + ')', nRow).addClass('lightpink');
                                $('td:eq(' + (23 + period_count) + ')', nRow).addClass('lightpink');
                                $('td:eq(' + (27 + period_count) + ')', nRow).addClass('lightpink');
                                $('td:eq(' + (29 + period_count) + ')', nRow).addClass('lightpink');

                                if ($('.cf', nRow).html() * 1 < 70) {
                                    $('.cf', nRow).addClass('red_text');
                                }

                                if ($('.cc', nRow).html() * 1 < 70) {
                                    $('.cc', nRow).addClass('red_text');
                                }

                                if ($('.cex', nRow).html() * 1 < 70) {
                                    $('.cex', nRow).addClass('red_text');
                                }
                            },

                        });

                        
                        if ($.fn.DataTable.isDataTable('.print-table')) { // if exist datatable it will destrory first
                            $('.print-table').DataTable().destroy();
                        }
                        ptable = $('.print-table').DataTable({
                            // "scrollX": true,
                            dom: 'Bfrtip',
                            buttons: [],
                            "language": {
                                processing: '<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span> '
                            },
                            "paging": false,
                            "ordering": false,
                            "searching": false,
                            "info":     false,
                            "processing": true,
                            "serverSide": true,
                            "ajax": {
                                "url": baseurl + "admin/grading_result/dteditstudentlistforprint",
                                "dataSrc": 'data',
                                "type": "POST",
                                'data': response.params,
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


        $(document).on('keydown', '.td-input', function(e) {

            var key = e.which;
            var $this = $(this);

            if (e.which === 38 || e.which === 40) {
                e.preventDefault();
            }

            if (key == 13 || key == 38 || key == 40) // the enter key code
            {
                $this.trigger('blur');
                var column = $(this).attr('data_column');
                var index = $('.td-input[data_column="' + column + '"]').index(this);
                if (key == 38) {
                    index = index - 2;
                }
                var next = $('.td-input[data_column="' + column + '"]').eq(index + 1);
                if (next.length > 0) {
                    var strLength = next.val().length * 2;
                    next.focus();
                    next.attr('type', 'text');
                    next[0].setSelectionRange(strLength, strLength);
                    next.attr('type', 'number');
                }
            }
        });

        $(document).on('change', '.td-input', function(e) {
            $('#save_report_btn').prop('disabled', false);
            $('#cancel_report_btn').prop('disabled', false);

            var std_id = $(this).attr('data_stdID');
            var validate = true;
            var cf = 0;
            var periods = $('.pr[data_stdID="' + std_id + '"]').length;
            $('.pr[data_stdID="' + std_id + '"]').each(function(e) {
                if (!$(this).val()) {
                    validate = false;
                }
                cf += $(this).val() / periods;
            });

            cf = Math.round(cf)

            if (validate) {
                $('.cf[data_stdID="' + std_id + '"]').text(cf);
                if (cf >= 70) {
                    $('.cf[data_stdID="' + std_id + '"]').removeClass('red_text')
                    $('.a[data_stdID="' + std_id + '"]').text('A');
                    $('.r[data_stdID="' + std_id + '"]').text('');
                    $('.cpc[data_stdID="' + std_id + '"] input').addClass('disable-addtest');
                    $('.cpex[data_stdID="' + std_id + '"] input').addClass('disable-addtest');

                    $('.50pcp[data_stdID="' + std_id + '"]').text('');
                    $('.50cpc[data_stdID="' + std_id + '"]').text('');
                    $('.cc[data_stdID="' + std_id + '"]').text('');

                    $('.30pcp[data_stdID="' + std_id + '"]').text('');
                    $('.70cpex[data_stdID="' + std_id + '"]').text('');
                    $('.cex[data_stdID="' + std_id + '"]').text('');
                } else {
                    $('.cf[data_stdID="' + std_id + '"]').addClass('red_text')
                    $('.a[data_stdID="' + std_id + '"]').text('');
                    $('.r[data_stdID="' + std_id + '"]').text('R');
                    if (cf >= 40) {

                        $('.30pcp[data_stdID="' + std_id + '"]').text('');
                        $('.50cpc[data_stdID="' + std_id + '"]').text('');
                        $('.cex[data_stdID="' + std_id + '"]').text('');


                        $('.50pcp[data_stdID="' + std_id + '"]').text(Math.round(cf / 2));
                        $('.cpc[data_stdID="' + std_id + '"] input').removeClass('disable-addtest');
                        $('.cpex[data_stdID="' + std_id + '"] input').addClass('disable-addtest');
                        var cpc = $('.cpc[data_stdID="' + std_id + '"] input').val() * 1;
                        var cc = Math.round(cf / 2) + Math.round(cpc / 2);

                        if (cpc) {
                            $('.50cpc[data_stdID="' + std_id + '"]').text(Math.round(cpc / 2));
                            $('.cc[data_stdID="' + std_id + '"]').text(Math.round(cc));

                            if (cc >= 70) {
                                $('.cc[data_stdID="' + std_id + '"]').removeClass('red_text')
                                $('.a[data_stdID="' + std_id + '"]').text('A');
                                $('.r[data_stdID="' + std_id + '"]').text('');
                            } else {
                                $('.cc[data_stdID="' + std_id + '"]').addClass('red_text')
                                $('.30pcp[data_stdID="' + std_id + '"]').text(Math.round(cf * 0.3));
                                $('.cpc[data_stdID="' + std_id + '"] input').removeClass('disable-addtest');
                                $('.cpex[data_stdID="' + std_id + '"] input').removeClass('disable-addtest');
                                var cpex = $('.cpex[data_stdID="' + std_id + '"] input').val() * 1;
                                var cex = Math.round(cf * 0.3) + Math.round(cpex * 0.7);

                                if (cpex) {
                                    $('.70cpex[data_stdID="' + std_id + '"]').text(Math.round(cpex * 0.7));
                                    $('.cex[data_stdID="' + std_id + '"]').text(Math.round(cex));
                                    $('.cex[data_stdID="' + std_id + '"]').addClass('red_text')
                                    if (cex >= 70) {
                                        $('.cex[data_stdID="' + std_id + '"]').removeClass('red_text')
                                        $('.a[data_stdID="' + std_id + '"]').text('A');
                                        $('.r[data_stdID="' + std_id + '"]').text('');
                                    }
                                } else {
                                    $('.70cpex[data_stdID="' + std_id + '"]').text('');
                                    $('.cex[data_stdID="' + std_id + '"]').text('');
                                }
                            }
                        } else {
                            $('.50cpc[data_stdID="' + std_id + '"]').text('');
                            $('.cc[data_stdID="' + std_id + '"]').text('');
                        }
                    } else {
                        $('.cpc[data_stdID="' + std_id + '"] input').addClass('disable-addtest');
                        $('.cpex[data_stdID="' + std_id + '"] input').removeClass('disable-addtest');
                        $('.50pcp[data_stdID="' + std_id + '"]').text('');
                        $('.50cpc[data_stdID="' + std_id + '"]').text('');
                        $('.cc[data_stdID="' + std_id + '"]').text('');

                        $('.30pcp[data_stdID="' + std_id + '"]').text(Math.round(cf * 0.3));
                        var cpex = $('.cpex[data_stdID="' + std_id + '"] input').val() * 1;
                        var cex = Math.round(cf * 0.3) + Math.round(cpex * 0.7);

                        if (cpex) {
                            $('.70cpex[data_stdID="' + std_id + '"]').text(Math.round(cpex * 0.7));;
                            $('.cex[data_stdID="' + std_id + '"]').text(Math.round(cex));
                            $('.cex[data_stdID="' + std_id + '"]').addClass('red_text')
                            if (cex >= 70) {
                                $('.cex[data_stdID="' + std_id + '"]').removeClass('red_text')
                                $('.a[data_stdID="' + std_id + '"]').text('A');
                                $('.r[data_stdID="' + std_id + '"]').text('');
                            }
                        } else {
                            $('.70cpex[data_stdID="' + std_id + '"]').text('');
                            $('.cex[data_stdID="' + std_id + '"]').text('');
                        }
                    }
                }
            } else {
                $('.a[data_stdID="' + std_id + '"]').text('');
                $('.r[data_stdID="' + std_id + '"]').text('');
                $('.cpc[data_stdID="' + std_id + '"] input').addClass('disable-addtest');
                $('.cpex[data_stdID="' + std_id + '"] input').addClass('disable-addtest');

                $('.50pcp[data_stdID="' + std_id + '"]').text('');
                $('.50cpc[data_stdID="' + std_id + '"]').text('');
                $('.cc[data_stdID="' + std_id + '"]').text('');

                $('.30pcp[data_stdID="' + std_id + '"]').text('');
                $('.70cpex[data_stdID="' + std_id + '"]').text('');
                $('.cex[data_stdID="' + std_id + '"]').text('');
            }
        });


    });
</script>