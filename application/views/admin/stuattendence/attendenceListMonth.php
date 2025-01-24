<style type="text/css">
    .radio {
        padding-left: 20px;}
    .radio label {
        display: inline-block;
        vertical-align: middle;
        position: relative;
        padding-left: 5px; }
    .radio label::before {
        content: "";
        display: inline-block;
        position: absolute;
        width: 17px;
        height: 17px;
        left: 0;
        margin-left: -20px;
        border: 1px solid #cccccc;
        border-radius: 50%;
        background-color: #fff;
        -webkit-transition: border 0.15s ease-in-out;
        -o-transition: border 0.15s ease-in-out;
        transition: border 0.15s ease-in-out; }
    .radio label::after {
        display: inline-block;
        position: absolute;
        content: " ";
        width: 11px;
        height: 11px;
        left: 3px;
        top: 3px;
        margin-left: -20px;
        border-radius: 50%;
        background-color: #555555;
        -webkit-transform: scale(0, 0);
        -ms-transform: scale(0, 0);
        -o-transform: scale(0, 0);
        transform: scale(0, 0);
        -webkit-transition: -webkit-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
        -moz-transition: -moz-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
        -o-transition: -o-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
        transition: transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33); }
    .radio input[type="radio"] {
        opacity: 0;
        z-index: 1; }
    .radio input[type="radio"]:focus + label::before {
        outline: thin dotted;
        outline: 5px auto -webkit-focus-ring-color;
        outline-offset: -2px; }
    .radio input[type="radio"]:checked + label::after {
        -webkit-transform: scale(1, 1);
        -ms-transform: scale(1, 1);
        -o-transform: scale(1, 1);
        transform: scale(1, 1); }
    .radio input[type="radio"]:disabled + label {
        opacity: 0.65; }
    .radio input[type="radio"]:disabled + label::before {
        cursor: not-allowed; }
    .radio.radio-inline {
        margin-top: 0; }
    .radio-primary input[type="radio"] + label::after {
        background-color: #337ab7; }
    .radio-primary input[type="radio"]:checked + label::before {
        border-color: #337ab7; }
    .radio-primary input[type="radio"]:checked + label::after {
        background-color: #337ab7; }
    .radio-danger input[type="radio"] + label::after {
        background-color: #d9534f; }
    .radio-danger input[type="radio"]:checked + label::before {
        border-color: #d9534f; }
    .radio-danger input[type="radio"]:checked + label::after {
        background-color: #d9534f; }
    .radio-info input[type="radio"] + label::after {
        background-color: #5bc0de; }
    .radio-info input[type="radio"]:checked + label::before {
        border-color: #5bc0de; }
    .radio-info input[type="radio"]:checked + label::after {
        background-color: #5bc0de; }
    @media (max-width:767px){
        .radio.radio-inline {display: inherit;}
    }      
</style>

<div class="content-wrapper" style="min-height: 946px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-calendar-check-o"></i> <?php echo $this->lang->line('attendance'); ?> <small><?php echo $this->lang->line('by_date1'); ?></small></h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <form id='form1' action="<?php echo site_url('admin/stuattendence/attendencebyMonth') ?>"  method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php
                            if ($this->session->flashdata('msg')) {
                                echo $this->session->flashdata('msg');
                            }
                            ?>

                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>

                                        <select autofocus="" id="class_id" name="class_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($classlist as $class) {
                                                ?>
                                                <option value="<?php echo $class['id'] ?>" <?php
                                                if ($class_id == $class['id']) {
                                                    echo "selected =selected";
                                                }
                                                ?>><?php echo $class['class'] ?></option>
                                                        <?php
                                                        $count++;
                                                    }
                                                    ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('section'); ?></label><small class="req"> *</small>
                                        <select  id="section_id" name="section_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            <?php echo $this->lang->line('attendance'); ?>
                                            <?php echo $this->lang->line('month'); ?>
                                        </label>
                                        <input id="month" name="month" placeholder="" type="text" class="form-control month"  value="<?php echo set_value('month', date($this->customlib->getSchoolMonthFormat())); ?>" readonly="readonly"/>
                                        <span class="text-danger"><?php echo form_error('date'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-12">    
                                    <div class="form-group">
                                        <button type="submit" name="search" value="search" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                    </div> 
                                </div>   
                            </div>
                        </div>
                    </form>
                    <?php
                    if (isset($resultlist)) {
                        ?>
                        <div class="">
                            <div class="box-header ptbnull"></div> 
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-users"></i> <?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('list'); ?></h3>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <div class="box-body">
                                <?php
                                if (!empty($resultlist)) {
                                    $can_edit = 1;
                                    $checked = "";
                                    if (!isset($msg)) {
                                        if ($resultlist[0]['attendence_type_id'] != "") {
                                            if ($resultlist[0]['attendence_type_id'] != 5) {
                                                if ($this->rbac->hasPrivilege('student_attendance', 'can_edit')) {

                                                    $can_edit = 1;
                                                } else {
                                                    $can_edit = 0;
                                                }
                                                ?>
                                                <div class="alert alert-success"><?php echo $this->lang->line('attendance_already_submitted_you_can_edit_record'); ?></div>
                                                <?php
                                            } else {
                                                $checked = "checked='checked'";
                                                ?>
                                                <div class="alert alert-warning"><?php echo $this->lang->line('attendance_already_submitted_as_holiday'); ?>. <?php echo $this->lang->line('you_can_edit_record'); ?></div>
                                                <?php
                                            }
                                        }
                                    } else {
                                        ?>
                                        <div class="alert alert-success"><?php echo $this->lang->line('attendance_saved_successfully'); ?></div>
                                        <?php
                                    }
                                    ?>
                                    <form action="<?php echo site_url('admin/stuattendence/attendencebyMonth') ?>" method="post" class="form_attendence">
                                        <?php echo $this->customlib->getCSRF(); ?>
                                        <div class="mailbox-controls" style="display: flex; justify-content: space-between;">                                        
                                            <select id="attendencetype" name="attendencetype" class="form-control" style="width: 100px;">
                                                <option value="" selected="selected">-</option>
                                                <option value="1">P</option>
                                                <option value="3">L</option>
                                                <option value="4">A</option>
                                                <option value="6">H</option>
                                            </select>
                                            <div class="pull-right">
                                                <?php
                                                if ($can_edit == 1) {
                                                    if ($this->rbac->hasPrivilege('student_attendance', 'can_add')) {
                                                        ?>
                                                        <button type="submit" name="search" value="saveattendence" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-save"></i> <?php echo $this->lang->line('save_attendance'); ?> </button>
                                                    <?php }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                                        <input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
                                        <input type="hidden" name="month" value="<?php echo $month; ?>">
                                        <div class="table-responsive ptt10">
                                            <table class="table table-hover table-striped example"> 
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th><?php echo $this->lang->line('admission_no'); ?></th>
                                                        <?php
                                                        if ($sch_setting->biometric) {
                                                            ?>
                                                            <th><?php echo $this->lang->line('date'); ?></th>
                                                            <?php
                                                        } 
                                                        ?>
                                                        <th><?php echo $this->lang->line('roll_no'); ?></th>
                                                        <th><?php echo $this->lang->line('name'); ?></th>
                                                        <th class=""><?php echo $this->lang->line('attendance'); ?></th>
                                                        <?php foreach ($dates as $eachDate) {
                                                            ?><th class=""><?php echo($eachDate); ?></th>
                                                        <?php
                                                        } ?>
                                                        <th class="noteinput"><?php echo $this->lang->line('note'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $row_count = 1;
                                                    foreach ($stuattendanceList as $key => $value) {

                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" name="student_session[]" value="<?php echo $value['student_session_id']; ?>">
                                                                <input  type="hidden" value="<?php echo $value['attendence_id']; ?>"  name="attendendence_id<?php echo $value['student_session_id']; ?>">
                                                                <?php echo $row_count; ?>
                                                            </td>
                                                            <td>
                                                            <?php echo $value['admission_no']; ?>
                                                            </td>
                                                            <?php
                                                            if ($sch_setting->biometric) {
                                                                ?>
                                                                <td>
                                                                    <?php
                                                                    if ($value['biometric_attendence']) {

                                                                        echo $value['attendence_dt'];
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <?php
                                                            }
                                                             ?>
                                                            <td>
                                                                <?php echo $value['roll_no']; ?>
                                                            </td>

                                                            <td style="white-space: nowrap">
                                                                <?php 
                                                                echo $this->customlib->getFullName($value['firstname'],$value['middlename'],$value['lastname'],$sch_setting->middlename,$sch_setting->lastname);  ?>
                                                            </td>
                                                            <td>
                                                                <select id="attendencetype<?php echo $value['student_session_id']; ?>" name="attendencetype<?php echo $value['student_session_id']; ?>" class="form-control">
                                                                    <option value="" selected="selected">-</option>
                                                                    <option value="1">P</option>
                                                                    <option value="3">L</option>
                                                                    <option value="4">A</option>
                                                                    <option value="6">H</option>
                                                                </select>
                                                            </td>
                                                            <?php foreach ($dates as $eachDate) {
                                                                list($dateString1, $dateString) = explode('/', $eachDate);
                                                                ?><td class="">
                                                                    <?php 
                                                                        if ($value['attendence_type_id_' . $dateString]) { ?>
                                                                            <input  type="hidden" value="<?php echo $value['attendence_id_' . $dateString]; ?>"  name="attendendence_id<?php echo $value['student_session_id'] . '_' . $dateString; ?>">
                                                                        <?php }  else { ?>
                                                                        <?php }
                                                                    ?>
                                                                    <select style="width: 59px;" id="<?php echo('studentattendanceselection_' . $value['student_session_id'] . '_' . $dateString); ?>" name="<?php echo('studentattendanceselection_' . $value['student_session_id'] . '_' . $dateString); ?>" class="form-control">
                                                                        <?php 
                                                                            if ($value['attendence_type_id_' . $dateString] == 1) {
                                                                                echo '<option value="1" selected="selected">P</option>
                                                                                        <option value="3">L</option>
                                                                                        <option value="4">A</option>
                                                                                        <option value="6">H</option>';
                                                                            } elseif ($value['attendence_type_id_' . $dateString] == 3) {
                                                                                echo '<option value="1">P</option>
                                                                                        <option value="3" selected="selected">L</option>
                                                                                        <option value="4">A</option>
                                                                                        <option value="6">H</option>';
                                                                            } elseif ($value['attendence_type_id_' . $dateString] == 4) {
                                                                                echo '<option value="1">P</option>
                                                                                        <option value="3">L</option>
                                                                                        <option value="4" selected="selected">A</option>
                                                                                        <option value="6">H</option>';
                                                                            } elseif ($value['attendence_type_id_' . $dateString] == 6) {
                                                                                echo '<option value="1">P</option>
                                                                                        <option value="3">L</option>
                                                                                        <option value="4">A</option>
                                                                                        <option value="6" selected="selected">H</option>';
                                                                            } else {
                                                                                echo '<option value="1">P</option>
                                                                                        <option value="3">L</option>
                                                                                        <option value="4">A</option>
                                                                                        <option value="6">H</option>';
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            <?php
                                                            } ?>
                                                            </td>
                                                            <?php if ($month == 'xxx') { ?> 
                                                                <td class="text-right"><input type="text" class="noteinput" name="remark<?php echo $value["student_session_id"] ?>" ></td>
                                                                    <?php } else { ?>
                                                                <td class="text-right"><input type="text" class="noteinput" name="remark<?php echo $value["student_session_id"] ?>" value="<?php echo $value["remark"]; ?>" ></td>
                                                        <?php } ?>
                                                        </tr>
                                                        <?php
                                                        $row_count++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                    <?php
                                } else {
                                    ?>
                                    <div class="alert alert-info"><?php echo $this->lang->line('admited_alert'); ?></div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div> 
    </section>
</div>
<script type="text/javascript">

    $(document).ready(function () {
        $.extend($.fn.dataTable.defaults, {
            searching: false,
            ordering: true,
            paging: false,
            retrieve: true,
            destroy: true,
            info: false
        });
        var table = $('.example').DataTable();
        table.buttons('.export').remove();
        var section_id_post = '<?php echo $section_id; ?>';
        var class_id_post = '<?php echo $class_id; ?>';
        populateSection(section_id_post, class_id_post);
        function populateSection(section_id_post, class_id_post) {
            $('#section_id').html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {'class_id': class_id_post, 'day_wise': 'yes'},
                dataType: "json",
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        var select = "";
                        if (section_id_post == obj.section_id) {
                            var select = "selected=selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + select + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        }

        $(document).on('change', '#class_id', function (e) {
            $('#section_id').html("");
            var class_id = $(this).val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            var url = "<?php
                        $userdata = $this->customlib->getUserData();
                        if (($userdata["role_id"] == 2)) {
                            echo "getClassTeacherSection";
                        } else {
                            echo "getByClass";
                        }
                        ?>";
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {'class_id': class_id, 'day_wise': 'yes'},
                dataType: "json",
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        div_data += "<option value=" + obj.section_id + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        });

    });
</script>
<script type="text/javascript">
    $(function () {
        $('.button-checkbox').each(function () {
            var $widget = $(this),
                    $button = $widget.find('button'),
                    $checkbox = $widget.find('input:checkbox'),
                    color = $button.data('color'),
                    settings = {
                        on: {
                            icon: 'glyphicon glyphicon-check'
                        },
                        off: {
                            icon: 'glyphicon glyphicon-unchecked'
                        }
                    };
            $button.on('click', function () {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
                $checkbox.triggerHandler('change');
                updateDisplay();
            });
            $checkbox.on('change', function () {
                updateDisplay();
            });

            function updateDisplay() {
                var isChecked = $checkbox.is(':checked');
                $button.data('state', (isChecked) ? "on" : "off");
                $button.find('.state-icon')
                        .removeClass()
                        .addClass('state-icon ' + settings[$button.data('state')].icon);
                if (isChecked) {
                    $button
                            .removeClass('btn-success')
                            .addClass('btn-' + color + ' active');
                } else {
                    $button
                            .removeClass('btn-' + color + ' active')
                            .addClass('btn-primary');
                }
            }

            function init() {
                updateDisplay();
                if ($button.find('.state-icon').length == 0) {
                    $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
                }
            }
            init();
        });
    });

    $('#checkbox1').change(function () {

        if (this.checked) {
            var returnVal = confirm("<?php echo $this->lang->line('are_you_sure'); ?>");
            $(this).prop("checked", returnVal);

            $("input[type=radio]").attr('disabled', true);


        } else {
            $("input[type=radio]").attr('disabled', false);
            $("input[type=radio][value='1']").attr("checked", "checked");

        }

    });


    $('form.form_attendence').on('submit', function (e) {

        $(this).submit(function () {
            return false;
        });
        return true;

    });

</script>