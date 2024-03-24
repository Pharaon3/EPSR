<style type="text/css">
    body {
        counter-reset: section; 
    }
    @media print {
        @page {
            size: A4;
            margin-top: 0;
            margin-bottom: 0;
        }
    }
    @media print {
        .pagebreak {
            page-break-before: always;

        }
        tfoot { visibility: hidden; }
        /* page-break-after works, as well */
    }
    /*.tableone td {
        padding: 5px 10px
    }*/
    /*.mark-container {
        width: 100%;
        padding-bottom: 20px;
    }*/
    .blank100 {
        width:100%;
        height: 100px;
    }
    .blank50 {
        width:100%;
        height: 50px;
    }
    /*.blank20 {
        width:100%;
        height: 20px;
    }*/
    /*.blank10 {
        width:100%;
        height: 10px;
    }*/
    .header {
        font-size: 30px;
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        text-decoration-line: underline;
    }

    .header_secondary {
        font-size: 27px;
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        text-decoration-line: underline;
    }
    /*.title {
        font-size: 23px;
        text-decoration-line: underline;
    }*/
    /*.title_secondary {
        font-size: 23px;
        width:50%;
    }*/
    .restbackground {
        background-color: #afafc6;
    }
    .rest {
        padding: 5px 5px;
        font-size:22px;
        font-weight: bold;
        text-align: center;
    }
    .subjectclass {
        font-size:18px;
        text-align: center;
        padding:5px 5px 5px 5px;
        word-break: break-word;
        overflow: hidden;
        width:100px;
    }
    /*.bordertale {
        width:100%;
    }*/
    /*.footer {
        font-size:15px;
        font-style: italic;
    }*/
    .tableheader {
        padding: 5px 5px;
        font-size:23px;
        font-weight: bold;
        border-collapse: collapse;
        border-right: 1px solid #999;
        border-bottom: 1px solid #999;
    }

    .tabletime {
        padding: 5px 5px;
        font-size:23px;
        width:90px;
        font-weight: bold;
        border-collapse: collapse;
        border-right: 1px solid #999;
        border-bottom: 1px solid #999;
        text-align: center;
    }
    /*.headertitle {
        font-size: 33px;
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
        text-align: left;
    }*/
    .tcb-1 {
        border-top: none;
        border-bottom: none;
        border-left: none;
    }
    .tcb-2 {
        border-bottom: none;
        border-left: none;
    }
    .tcb-3 {
        border-right: none;
    }
    .tp-0 {
        padding: 5px;
    }
</style>

<?php
if (!empty($timetable)) {
    ?>
    <div class="blank50"></div>
    <div class="">
        <?php
        if($level_name) {
            echo "<div class='header_secondary'>HORARIO DE LOS DOCENTES $level_name<br>
            AÑO ESCOLAR  2021-22</div>";
        }
        ?>
    </div>
    <div style="margin:20px 0px 20px 0px;">
        <table class='headertable' border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td class="tcb-1 tp-0">DOCENTE</td>
                <td class="tcb-1 tp-0"><?php echo $staff_data['name']." ".$staff_data['surname']; ?></td>
                <td class="tcb-1 tcb-3 tp-0">ASIGNATURA</td>
            </tr>
            <tr>
                <td class="tcb-2 tp-0">GRADOS</td>
                <td class="tcb-2 tp-0">
                    <?php 
                        if(isset($min_class) && isset($max_class)){
                            $display_class = substr($min_class['class'],0,1)." Y ";
                            $display_class .= substr($max_class['class'],0,1).", ";
                            echo $display_class;
                        }elseif(isset($min_class)){
                            echo substr($min_class['class'],0,1).", ";
                        }
                        if(isset($min_section) && isset($max_section)){
                            echo $min_section['section']." y ".$max_section['section']." ";
                        }elseif(isset($min_section)){
                            echo $min_section['section']." ";
                        }
                    ?> 
                </td>
                <td class="tcb-2 tcb-3 tp-0"></td>
            </tr>
            <tr>
                <td class="tcb-2 tp-0">TOTAL HORAS</td>
                <td class="tcb-2 tp-0">
                    <?php echo $time_table_count; ?>h
                </td>
                <td class="tcb-1 tcb-3 tp-0">
                    <?php echo !empty($subject_data['name'])?$subject_data['name']:''; ?>
                </td>
            </tr>
        </table>
    </div>
    <table class="table table-stripped bordertable" cellpadding="0" border="1" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="text text-center tableheader"><?php echo $this->lang->line("time"); ?></th>
                <?php
                foreach ($timetable as $tm_key => $tm_value) {
                    ?>
                    <th class="text text-center tableheader"><?php echo $tm_key; ?></th>
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
                if($timezone_id!=0 && ($timezone_id!=$value['timezone_id']) )
                {
                    print("</tbody></table>");
                    print('<div class="pagebreak"></div>');
                    print('<div class="blank100"></div>');
                    echo '<table class="table table-stripped bordertable" cellpadding="0" border="1" cellspacing="0" width="100%">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th class="text text-center tableheader">';
                    echo $this->lang->line("time");
                    echo '</th>';
                    foreach ($timetable as $tm_key => $tm_value) 
                    {
                        echo '<th class="text text-center tableheader">';
                        echo $tm_key;
                        echo '</th>';
                    }
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                }
                $timezone_id = $value['timezone_id'];                
                ?>
                <tr <?php if($value['time_type'] != 0) echo "class = 'restbackground'"?>>
                    <td class="text text-center tabletime"><?php echo $value['time_from']." ".$value['time_to'];?></td>
                    <?php if($value['time_type'] == 1) { ?>
                        <td class="text text-center rest">R</td>
                        <td class="text text-center rest">E</td>
                        <td class="text text-center rest">CR</td>
                        <td class="text text-center rest">E</td>
                        <td class="text text-center rest">O</td>
                    <?php } else { ?>
                        <?php foreach($days as $day_key=>$day_value) {?>
                            <td class="text text-center subjectclass" width="14%">
                                <?php 
                                $dup_flag = false;
                                foreach($duplicated_result as $row) {
                                    if($key==$row->lesson_id)
                                    {
                                        $dup_flag = true;
                                    }
                                }
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