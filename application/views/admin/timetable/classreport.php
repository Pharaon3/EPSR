
<style>
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
<div class="content-wrapper" style="min-height: 946px;">
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
                            <!-- <a href="<?php echo site_url('admin/timetable/allreport') ?>" type="button"  class="btn btn-sm btn-primary" autocomplete="off"><i class="fa fa-print"></i> <?php echo $this->lang->line('all')." ".$this->lang->line('report'); ?></a> -->
                            <a href="<?php echo site_url('admin/timetable/create') ?>" type="button"  class="btn btn-sm btn-primary" autocomplete="off"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add'); ?></a>
                        </div>
                        
                    </div>
                    <form action="<?php echo site_url('admin/timetable/classreport') ?>" method="post" accept-charset="utf-8">
                        <div class="box-body">

                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('section'); ?></label><small class="req"> *</small>
                                        <select  id="section_id" name="section_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right btn-sm" name="search"><?php echo $this->lang->line('search'); ?></button>
                        </div>
                    </form>

                    <?php
                    if (isset($timetable)) {
                        ?>
                        <style>
                            .red {color:red}
                            .subject-warning{
                                padding-left:3rem;
                                padding-top: 2px;
                            }
                            </style>
                        <div class="box-header ptbnull subject-warning" >
                            <?php 
                            //print("+++".$timezone_id."####");
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
                            ?>
                        </div>
                        <div class="box-body">
                            <?php
                            if (!empty($timetable)) {
                                ?>
                                <style>
                                    .table>thead>tr>th{
                                        border-bottom: 2px solid grey;
                                    }
                                    .table>tbody>tr>td{
                                        border-top: 1px solid lightgrey;
                                    }
                                </style>
                                <div class="table-responsive">    
                                    <div class="box-tools pull-right">
                                        <div class="btn btn-sm btn-primary" autocomplete="off" onclick = "printview(<?php echo $class_id;?>)"><i class="fa fa-print"></i> <?php echo $this->lang->line('report'); ?></div>
                                        <div style="padding-bottom:10px;"></div>
                                    </div>
                                   
                                    <table class="table table-stripped" id="customers" border = "1">
                                        <thead>
                                            <tr >
                                                <th class="text text-center"><?php echo $this->lang->line("time"); ?></th>
                                                <?php
                                                foreach ($timetable as $tm_key => $tm_value) {
                                                    ?>
                                                    <th class="text text-center"><?php echo $this->lang->line(strtolower($tm_key)); ?>
                                                    </th>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <?php
                                            if($timezone_id==0 || count($lesson_timetables)==0) { 
                                                ?>
                                                <tr><td colspan="20" style="text-align:center;border-top:solid 1px #666;"><?php echo $this->lang->line("has_no_lesson_timezone") ?></td></td></tr>
                                                <?php    
                                            }
                                            else
                                            {                                                
                                                $count = 0;
                                                $rows = 0;
                                                $cols = 0;
                                                foreach ($lesson_timetables as $key => $value) 
                                                {
                                                    ?>
                                                    <tr style=<?php if($value['time_type'] != 0) echo "'background-color: #afafc6;'"?>>
                                                    <td class="text text-center" ><?php echo $value['time_from']." ~ ".$value['time_to'];?></td>
                                                    <?php 
                                                    if($value['time_type'] == 2) 
                                                    { 
                                                        
                                                            echo '<td class="text text-center">Merienda</td>';
                                                            echo '<td class="text text-center">Merienda</td>';
                                                            echo '<td class="text text-center">Merienda</td>';
                                                            echo '<td class="text text-center">Merienda</td>';
                                                            echo '<td class="text text-center">Merienda</td>';
                                                    }  
                                                    else if($value['time_type'] == 1)
                                                    {
                                                        echo '<td class="text text-center">R</td>';
                                                        echo '<td class="text text-center">E</td>';
                                                        echo '<td class="text text-center">CR</td>';
                                                        echo '<td class="text text-center">E</td>';
                                                        echo '<td class="text text-center">O</td>';
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <?php 
                                                        $cols = 0;
                                                        foreach($days as $day_key=>$day_value) 
                                                        {
                                                            if($level_name == "NIVEL SECUNDARIO")
                                                            {
                                                                if($rows == 5 && $cols == 4)
                                                                {
                                                                    ?>
                                                                    <td rowspan="2" class="text text-center" width="16%">
                                                                        <div>
                                                                            <img src=<?php echo base_url('backend/images/grading_report_logo.jpg'); ?> width="80" height="80"/>
                                                                        </div>
                                                                        <div>
                                                                            <label><?php echo $room_no;?></label>
                                                                        </div>
                                                                    </td>
                                                                    <?php
                                                                }
                                                                else if($rows > 5 && $cols >= 4)
                                                                {
                                                                    break;
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <td class="text text-center" width="16%">
                                                                        <?php 
                                                                            if( !empty($timetable[$day_key][$key]) )
                                                                                print($timetable[$day_key][$key]->subject_name);
                                                                        ?>
                                                                    </td>
                                                                    <?php
                                                                }

                                                            }
                                                            else
                                                            {
                                                            ?>
                                                                <td class="text text-center" width="16%">
                                                                    <?php 
                                                                    if( !empty($timetable[$day_key][$key]) )
                                                                        print($timetable[$day_key][$key]->subject_name);
                                                                    ?>
                                                                </td>
                                                            <?php
                                                            }
                                                            $cols++;
                                                        }
                                                        $count++;
                                                        $rows++;
                                                    } ?>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <?php 
                                            } ?> 
                                        </tbody>
                                    </table>
                                </div>  
                                <?php
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

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {


        var target = $(e.target).attr("href"); // activated tab
        var target_id = $(e.target).attr("id"); // activated tab
        var ajax_data = $(e.target).data(); // activated tab
        $(target).html("");
        getGroupdata(target, target_id, ajax_data);
    })

    function getGroupdata(target, target_id, ajax_data) {

        $.ajax({
            type: 'POST',
            url: base_url + "admin/timetable/getBydategroupclasssection",
            data: {'day': ajax_data.day, 'class_id': ajax_data.c, 'section_id': ajax_data.s, 'subject_group_id': ajax_data.group},
            dataType: 'json',
            beforeSend: function () {
                $(target).addClass('show');
            },
            success: function (data) {
                $(target).html(data.html);

                $('.staff', target).select2({
                    dropdownAutoWidth: true,
                    width: '100%'
                });
                $('.subject', target).select2({
                    dropdownAutoWidth: true,
                    width: '100%'
                });
                tot_count = data.total_count + 1;
            },
            error: function (xhr) { // if error occured

            },
            complete: function () {
                $(target).removeClass('show');
            }
        });
    }


    $(document).ready(function () {
        var counter = 0;

        $(document).on("click", ".addrow", function () {

            var newRow = $("<tr>");
            var cols = "";
            cols += '<td><input type="hidden" name="total_row[]" value="' + tot_count + '"><input type="hidden" name="prev_id_' + tot_count + '" value="0"><select class="form-control subject" id="subject_id_' + tot_count + '" name="subject_' + tot_count + '">' + $("#subject_dropdown").text() + '</select></td>';
            cols += '<td><select class="form-control staff" id="staff_id_' + tot_count + '" name="staff_' + tot_count + '">' + $("#staff_dropdown").text() + '</select></td>';

            cols += '<td><div class="input-group"><input type="text" name="time_from_' + tot_count + '" class="form-control time_from time" id="time_from_' + tot_count + '"  aria-invalid="false"><div class="input-group-addon"><span class="glyphicon glyphicon-dashboard"></span></div></div></td>';

            cols += '<td><div class="input-group"><input type="text" name="time_to_' + tot_count + '" class="form-control time_to time" id="time_to_' + tot_count + '"  aria-invalid="false"><div class="input-group-addon"><span class="glyphicon glyphicon-dashboard"></span></div></div></td>';

            cols += '<td><input type="text" class="form-control room_no" name="room_no_' + tot_count + '" id="room_no_' + tot_count + '"/></td>';
            cols += '<td><button type="button" class="ibtnDel btn btn-danger btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>';
            newRow.append(cols);

            $("table.order-list").append(newRow);


            $('.staff', newRow).select2({
                dropdownAutoWidth: true,
                width: '100%'
            });

            $('.subject', newRow).select2({
                dropdownAutoWidth: true,
                width: '100%'
            });
            tot_count++;
        });



        $(document).on("click", ".ibtnDel", function (event) {
            $(this).closest("tr").remove();
            counter -= 1
        });



        $(document).on('click', '.submit_subject_group', function () {
            var form_id = $(this).closest("form").attr('id');
            var target = $('.nav-tabs .active a').attr("href"); // activated tab
            var target_id = $('.nav-tabs .active a').attr("id"); // activated tab
            var ajax_data = $('.nav-tabs .active a').data(); // activated tab

        });

    });
    function printview(id) {
        var base_url = '<?php echo base_url() ?>';
        var class_id = $('#class_id').val();
        var section_id = $('#section_id').val();
        $.ajax({
            type: "POST",
            url: base_url + "admin/timetable/printclasstimetable",
            data: {
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



</script>


<script type="text/template" id="staff_dropdown">
    <option value=""><?php echo $this->lang->line('select') ?></option>
    <?php
    foreach ($staff as $staff_key => $staff_value) {
        ?>
        <option value="<?php echo $staff_value['id']; ?>"><?php echo $staff_value['name'] . " " . $staff_value['surname'] . " (" . $staff_value['employee_id'] . ")"; ?></option>
        <?php
    }
    ?>
</script>

<script type="text/template" id="subject_dropdown">
    <option value=""><?php echo $this->lang->line('select') ?></option>
    <?php
    foreach ($subject as $subject_key => $subject_value) {
        ?>
        <option value="<?php echo $subject_value->id; ?>" ><?php echo $subject_value->name . " (" . $subject_value->code . ")"; ?></option>
        <?php
    }
    ?>
</script>