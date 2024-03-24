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

.report-padding
{
    padding-right: 5px;
}
</style>

<?php if(count($duplicated_result)>0)
    { ?>
    <style> .red{ color:red;}</style>
    <div class="box-tools pull-right">
        <?php 
        foreach($duplicated_result as $row)
        {
            $dup_classes = "<span class='red'>" . str_replace(":", " ", str_replace(",", "</span> ".$this->lang->line("and")." <span class='red'>", $row->dup_classes)) . "</span>";
            $duplicated_message = sprintf($this->lang->line("staff_duplicate"), $row->name ." " . $row->surname. "($row->employee_id)", $dup_classes, " <span class='red'>$row->dup_days</span> " . " $row->dup_time " );
            print($duplicated_message);
            print("<br>");
        }
        ?> 
    </div>
        <?php 
    } ?>
    <!-- <div class="box-tools pull-right report-padding">
        <div class="btn btn-sm btn-primary" autocomplete="off" onclick = "printview_all()"><i class="fa fa-print"></i> <?php echo $this->lang->line('all')." ".$this->lang->line('report'); ?></div>
        <div style="padding-bottom:10px;"></div>
    </div> -->
    <div class="box-tools pull-right report-padding">
        <div class="btn btn-sm btn-primary" autocomplete="off" onclick = "printview()"><i class="fa fa-print"></i> <?php echo $this->lang->line('report'); ?></div>
        <div style="padding-bottom:10px;"></div>
    </div>
<?php
if (!empty($timetable)) {
    ?>
    <table class="table table-stripped" id="customers">
        <thead>
            <tr>
            <th class="text text-center"><?php echo $this->lang->line("time"); ?></th>
                <?php
                foreach ($timetable as $tm_key => $tm_value) {
                    ?>

                    <th class="text text-center"><?php echo $tm_key; ?></th>
                    <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
                $count = 0;
                $timezone_id = 0; ;
                foreach ($lesson_timetables as $key => $value) 
                {
                    ######################## adding split row ##################
                    if($timezone_id!=0 && ($timezone_id!=$value['timezone_id']) )
                    {
                        print("<tr><td colspan=30>&nbsp;</td></tr>");
                    }
                    $timezone_id = $value['timezone_id'];
                    //$ampm_flag = $value['ampm_flag'];
                    #############
                    
                    ?>
                    <tr style=<?php if($value['time_type'] != 0) echo "'background-color: #afafc6;'"?>>
                    <td class="text text-center"><?php echo $value['time_from']." ~ ".$value['time_to'];?></td>
                    <?php 
                    if($value['time_type'] == 1) 
                    { 
                        ?>
                        <td class="text text-center">R</td>
                        <td class="text text-center">E</td>
                        <td class="text text-center">CR</td>
                        <td class="text text-center">E</td>
                        <td class="text text-center">O</td>
                        <?php
                        
                    }
                    else if($value['time_type'] == 2)
                    {
                        echo '<td class="text text-center">Merienda</td>';
                        echo '<td class="text text-center">Merienda</td>';
                        echo '<td class="text text-center">Merienda</td>';
                        echo '<td class="text text-center">Merienda</td>';
                        echo '<td class="text text-center">Merienda</td>';
                    }
                    else
                    {
                        ?>
                        <?php foreach($days as $day_key=>$day_value) {?>

                        <td class="text text-center" width="16%">
                            <?php 
                            $dup_flag = false;
                            foreach($duplicated_result as $row)
                            {
                                if($key==$row->lesson_id)
                                {
                                    $dup_flag = true;
                                }
                            }
                            //print_r([$day_value, $key]);
                            if($dup_flag) print("<span class='red'>");
                            if( !empty($timetable[$day_value][$key]) )
                                echo substr($timetable[$day_value][$key]->class,0,1).$timetable[$day_value][$key]->section;
                            if($dup_flag) print("</span>");
                            ?>
                        </td>
                        <?php
                    }
                    $count++;
                    } ?>
                    </tr>
                    <?php
                }
                ?>
        </tbody>
    </table>
    <?php
} else {
    ?>
    <div class="alert alert-info">
    <?php echo $this->lang->line('no_record_found'); ?>
    </div>
    <?php
}
?>

<script>

function printview() {
        var staff_id = $("#teacher").val();
        var base_url = '<?php echo base_url() ?>';
        if(staff_id != ''){
            $.ajax({
                type: "POST",
                url: base_url + "admin/timetable/printTeacherTimeTable",
                data: {
                    staff_id: staff_id,
                }, // serializes the form's elements.
                dataType: "JSON", // serializes the form's elements.
                success: function(response) {
                    // console.log(response);
                    Popup(response.page);
                },
                error: function(xhr) { // if error occured
                    alert("Error occured.please try again");
                }
            });
        }
    }
    function printview_all() {
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            type: "POST",
            url: base_url + "admin/timetable/printAllTeacherTimeTable",
            data: {
            }, // serializes the form's elements.
            dataType: "JSON", // serializes the form's elements.
            success: function(response) {
                // console.log(response);
                Popup(response.page);
            },
            error: function(xhr) { // if error occured
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