<style type="text/css">
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 22px !important; border-radius: 0 !important; padding-left: 0 !important;}
    .input-group-addon .glyphicon{font-size: 12px;}

    .show{
        display : block;
        z-index: 100;
        background-image : url('../../backend/images/timeloader.gif');
        opacity : 0.6;
        background-repeat : no-repeat;
        background-position : center;
    }
    /* .tab-pane{min-height: 200px;}*/
    .commentForm .input-group {position: relative;display: block;border-collapse: separate;}
    .commentForm .input-group-addon{
        position: absolute;
        right: 26px;
        top: 0px;
        z-index: 3;
    }
    .relative{position: relative;}
    .commentForm .input-group-addon i,
    .commentForm .input-group-addon span{padding-left: 13px;}
    .commentForm .relative label.text-danger{position: absolute; bottom: 5px;}
    .addbtnright{ position: absolute;right: 0;top: -46px;}

    @media(max-width:767px){
        .timeresponsive{overflow-x: auto;     overflow-y: hidden;}
        .timeresponsive .dropdown-menu{z-index: 1060;    bottom: 0 !important; height: 250px; padding: 20px;}
        .tablewidthRS{width: 690px;}
    }

#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  text-align: center;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;text-align: center;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: center;
  background-color: #44AA6D;
  color: white;
}
</style>
<script src="<?php echo base_url(); ?>backend/custom/jquery.validate.min.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('academics'); ?> <small><?php echo $this->lang->line('student_fees1'); ?></small></h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <form action="<?php echo site_url('admin/timetable/create') ?>" method="post" accept-charset="utf-8">
                        <div class="box-body">

                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('class'); ?><small class="req"> *</small></label>
                                        <select autofocus="" id="class_id" name="class_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
foreach ($classlist as $class) {
    ?>
                                                <option value="<?php echo $class['id'] ?>" <?php
if (set_value('class_id') == $class['id']) {
        echo "selected=selected";
    }
    ?>><?php echo $class['class'] ?></option>
                                                        <?php
}
?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('section'); ?><small class="req"> *</small></label>
                                        <select  id="section_id" name="section_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('subject') . " " . $this->lang->line('group'); ?><small class="req"> *</small></label>
                                        <select  id="subject_group_id" name="subject_group_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('subject_group_id'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right btn-sm"><?php echo $this->lang->line('search'); ?></button>
                        </div>
                    </form>

                                        
<?php ###################   start new time table input ############## ?>
    <div class="box-header ptbnull subject-warning" >
        <style>
            .red {color:red}
            .subject-warning{
                padding-left:3rem;
                padding-top: 2px;
            }
            </style>
        <?php 
        if( !empty($class_id) && !empty($section_id) && !empty($subject_group_id))
        {
            if($validate_lessoncount>MAXLIMIT_LESSONCOUNT_PERWEEK)
            {
                //print($validate_lessoncount ." ". MAXLIMIT_LESSONCOUNT_PERWEEK . "<br>");
                $msg = sprintf($this->lang->line("lessoncount_perweek"), $validate_lessoncount-MAXLIMIT_LESSONCOUNT_PERWEEK, MAXLIMIT_LESSONCOUNT_PERWEEK);
                print($msg);
                print('<br>');
            }
            if(count($validate_duplicated)>0)
            foreach($validate_duplicated as $row)
            {
                if(($row->sub_on_weekly - $row->subjects_count)>0)
                {
                    //print("There are less than <span class='red'>".($row->sub_on_weekly - $row->subjects_count)."</span> classes in <span class='red'>$row->name</span> subject.");
                }
                else
                {
                    $msg = sprintf($this->lang->line("lessoncount_over"), ($row->subjects_count - $row->sub_on_weekly), $row->name);
                    print($msg);
                    print('<br>');
                }
            }

            if( count($validate_staffdup)>0 )
            foreach($validate_staffdup as $dup)
            {
                $dup_classes = "<span class='red'>" . str_replace(":", " ", str_replace(",", "</span> ".$this->lang->line("and")." <span class='red'>", $dup->dup_classes)) . "</span>";
                $duplicated_message = sprintf($this->lang->line("staff_duplicate"), $dup->name ." " . $dup->surname. "($dup->employee_id)", $dup_classes, " <span class='red'>$dup->dup_days</span> " . " $dup->dup_time " );
                print($duplicated_message);
                print("<br>");
            }
        }
        ?>
    </div>
<?php if( !empty($class_id) && !empty($section_id) && !empty($subject_group_id)) { ?>

<form method="POST" action="<?php echo site_url('admin/timetable/create'); ?>" 
    id="form_timetable" 
    class="commentForm autoscroll">
        <div class="row" style="padding-left:1rem;padding-right:1rem;padding-top:1rem;">
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="room_no" class="col-md-3 text-right" style="margin-top:3px;"><?php echo $this->lang->line('room')." ". $this->lang->line('no') ; ?><small class="req"> *</small></label>
                    <div class="col-md-4">
                        <input autofocus="" id="room_no" name="room_no" placeholder="" type="text" class="form-control" value="<?php echo $room_no; ?>" />
                        <span class="text-danger"><?php echo form_error('room_no'); ?></span>
                    </div>
                </div>
            </div>
        </div>
<div class="table-responsive" style="padding-bottom:1rem;padding-left:1rem;padding-right:1rem;">    
<input type="hidden" name="class_id" value="<?php echo $class_id; ?>" />
<input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
<input type="hidden" name="subject_group_id" value="<?php echo $subject_group_id; ?>" />
<input type="hidden" name="timezone_id" value="<?php echo $timezone_id; ?>" />

    <table class="table table-stripped" border = "1" id="customers">
        <thead>
            <tr style="border: solid 1px;">
                <th class="text text-center" style="min-width:100px;"><?php echo $this->lang->line("time"); ?></th>
                <?php $cnt = 0;
                foreach ($getDaysnameList as $days_key => $days_value) { $cnt++; ?>
                    <th class="text text-center" ><?php echo $days_value; ?></th>
                <?php } ?>
                <?php for($idx=$cnt ; $idx<5; $idx++ ) {  ?>
                    <th class="text text-center">&nbsp;</th>
                <?php } # this is empty cell when weekdays array is invalid ?>
            </tr>
        </thead>
        <tbody>

            <?php 
            if($timezone_id==0) { 
                ?>
                <tr><td colspan="20" style="text-align:center;border-top:solid 1px #666;"><?php echo $this->lang->line("has_no_lesson_timezone") ?></td></td></tr>
                <?php    
            }
            else
            {
                $row_idx = 0;
                foreach ($lesson_timetables as $lesson_key => $lesson_value) { $row_idx++; ?>
                <tr style="border: solid 0px;">
                    <td class="text text-center">
                        <?php echo $lesson_value['time_from'] . " - " . $lesson_value['time_to']; ?>
                        <input type="hidden" id="h_level_time_id_<?php echo $row_idx; ?>" name="leveltime_id[<?php echo $lesson_key; ?>]" value="<?php echo $lesson_key ?>" />
                        </td>
                    <?php foreach ($getDaysnameList as $days_key => $days_value) {  ?>
                        <td class="text text-center">   
                            <div style="">
                            <?php //print_r($timetable_subjects[$lesson_value['id']]) ; ?>
                            <select class="form-control subject" 
                                    id="subject_id_<?php echo $row_idx ?>_<?php echo $days_key ?>" 
                                    style="width:100%;padding-left:0.1rem;margin-bottom:0.5rem;"
                                    name="timetable_subject[<?php echo $lesson_value['id'] ?>][<?php echo $days_key ?>]">
                                <option value="0"></option>
                                <?php foreach($subject as $key=>$subject_info){ ?>
                                    <?php 
                                        $selected = $timetable_subjects[$lesson_value['id']][$days_key]['subject_id'] == $subject_info->subject_id ? "selected" : "";
                                        //$selected = $timetable_subjects[$lesson_value['id']][$days_key]['subject_id'];
                                    ?>
                                <option <?php echo $selected; ?> value="<?php echo $subject_info->subject_id; ?>"><?php echo $subject_info->name; ?></option>
                                <!-- (<?php echo $subject_info->code; ?>) -->
                                <?php } ?>
                            </select>
                            <select class="form-control subject" 
                                    id="staff_id_<?php echo $row_idx ?>_<?php echo $days_key ?>" 
                                    style="width:100%;padding-left:0.1rem;"
                                    name="timetable_staff[<?php echo $lesson_value['id'] ?>][<?php echo $days_key ?>]">
                                <option value="0"></option>
                                <?php foreach($staff as $key=>$staff_info){ ?>
                                    <?php 
                                        $selected = ( !empty($staff_info['id']) && 
                                                    $timetable_staff[$lesson_value['id']][$days_key]['staff_id'] == $staff_info['id']) ? "selected" : "";
                                        //$selected = $timetable_subjects[$lesson_value['id']][$days_key]['subject_id'];
                                    ?>
                                <option <?php echo $selected; ?> value="<?php echo $staff_info['id']; ?>"><?php echo $staff_info['name']; ?> <?php echo $staff_info['surname']; ?></option>
                                <?php } ?>
                            </select>
                            </div>
                        </td>
                    <?php }  ?>
                    <?php for($idx=$cnt ; $idx<5; $idx++ ) {  ?>
                        <th class="text text-center">&nbsp;</th>
                    <?php } # this is empty cell when weekdays array is invalid ?>
                </tr>
                <?php } ?>
           <?php } ?>
        </tbody>
    </table>
    <button class="btn btn-primary btn-sm pull-right" type="submit" autocomplete="off"><i class="fa fa-save"></i> Save</button>
</div>
</form>
<?php } ?>    

<?php ###################   end ################  ?>


<?php
unset($getDaysnameList);
if (isset($getDaysnameList)) {
    ?>
                        <div class="box-header ptbnull"></div>
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs" id="myTabs">
                                <?php
$count = 1;

    foreach ($getDaysnameList as $days_key => $days_value) {
        $cls = "";
        if ($count == 1) {
        }
        ?>
                                    <li <?php echo $cls; ?>><a href="#tab_<?php echo $count; ?>" data-c="<?php echo set_value('class_id'); ?>" data-days="<?php echo $days_value; ?>" data-s="<?php echo set_value('section_id'); ?>" data-group="<?php echo set_value('subject_group_id'); ?>" data-day="<?php echo $days_key; ?>" data-toggle="tab" aria-expanded="true"><?php echo $days_value; ?></a></li>

                                    <?php
$count++;
    }
    ?>
                            </ul>
                            <div class="tab-content">
                                <?php
$count = 1;
    foreach ($getDaysnameList as $days_key => $days_value) {
        $cls = "class='tab-pane'";
        if ($count == 1) {

        }
        ?>
                                    <div <?php echo $cls; ?> id="tab_<?php echo $count; ?>">
                                    </div>

                                    <?php
$count++;
    }
    ?>

                            </div>
                        </div>
                    </div>
                    <?php
}
?>
                </section>
            </div>
<script type="text/javascript">
    $(document).on('focus', '.time', function () {
        var $this = $(this);
        $this.datetimepicker({
            format: 'LT'
        });
    });
    var tot_count = 0;
    var class_id = $('#class_id').val();
    var section_id = '<?php echo set_value('section_id') ?>';
    var subject_group_id = '<?php echo set_value('subject_group_id') ?>';
    $(document).ready(function () {

        $('#myTabs a:first').tab('show') // Select first tab
        getSectionByClass(class_id, section_id);
        getGroupByClassandSection(class_id, section_id, subject_group_id);

        $(document).on('change', '#class_id', function (e) {
            $('#section_id').html("");
            var class_id = $(this).val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';

            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {'class_id': class_id},
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

        $(document).on('change', '#section_id', function (e) {
            $('#subject_group_id').html("");
            var section_id = $(this).val();
            var class_id = $('#class_id').val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "POST",
                url: base_url + "admin/subjectgroup/getGroupByClassandSection",
                data: {'class_id': class_id, 'section_id': section_id},
                dataType: "json",
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        div_data += "<option value=" + obj.subject_group_id + ">" + obj.name + "</option>";
                    });

                    $('#subject_group_id').append(div_data);
                }
            });
        });
    });

    function getSectionByClass(class_id, section_id) {
        if (class_id != "" && section_id != "") {
            $('#section_id').html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';

            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {'class_id': class_id},
                dataType: "json",
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
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


    function getGroupByClassandSection(class_id, section_id, subject_group_id) {
        if (class_id != "" && section_id != "" && subject_group_id != "") {
            $('#subject_group_id').html("");

            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "POST",
                url: base_url + "admin/subjectgroup/getGroupByClassandSection",
                data: {'class_id': class_id, 'section_id': section_id},
                dataType: "json",
                success: function (data) {
                    console.log(subject_group_id);
                    $.each(data, function (i, obj)
                    {
                        var sel = "";
                        if (subject_group_id == obj.subject_group_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.subject_group_id + " " + sel + ">" + obj.name + "</option>";
                    });

                    $('#subject_group_id').append(div_data);
                }
            });
        }
    }

    $(document).ready(function () {
        var counter = 0;

        $(document).on('click', '.submit_subject_group', function () {
            var form_id = $(this).closest("form").attr('id');
            var target = $('.nav-tabs .active a').attr("href"); // activated tab
            var target_id = $('.nav-tabs .active a').attr("id"); // activated tab
            var ajax_data = $('.nav-tabs .active a').data(); // activated tab

        });
    });
</script>
