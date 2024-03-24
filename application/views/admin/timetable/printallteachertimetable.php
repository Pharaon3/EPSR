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
        font-size: 24px;
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        text-decoration-line: underline;
    }
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
if (!empty($all_data)) {
    ?>
    <div class="blank50"></div>
    <div class="">
        <?php
        if($all_data[0]['level_name']) {
            echo "<div class='header'>HORARIO DE LOS DOCENTES ".$all_data[0]['level_name']."<br>
            AÑO ESCOLAR 2021-2022</div>";
        } else {
            echo "<div class='header_secondary'>HORARIO DE LOS DOCENTES</div>";
        }

        ?>
    </div>
    <?php 
    foreach($all_data as $data) { ?>
        <div>
            <div style="margin:20px 0px 20px 0px;">
                <table class='headertable' border="1" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="tcb-1 tp-0">DOCENTE</td>
                        <td class="tcb-1 tp-0"><?php echo $data['staff_data']['name']." ".$data['staff_data']['surname']; ?></td>
                        <td class="tcb-1 tcb-3 tp-0">ASIGNATURA</td>
                    </tr>
                    <tr>
                        <td class="tcb-2 tp-0">GRADOS</td>
                        <td class="tcb-2 tp-0">
                            <?php 
                                if(isset($data['min_class']) && isset($data['max_class'])){
                                    $display_class = substr($data['min_class']['class'],0,1)." Y ";
                                    $display_class .= substr($data['max_class']['class'],0,1).", ";
                                    echo $display_class;
                                }elseif(isset($data['min_class'])){
                                    echo substr($data['min_class']['class'],0,1).", ";
                                }
                                if(isset($data['min_section']) && isset($data['max_section'])){
                                    echo $data['min_section']['section']." y ".$data['max_section']['section']." ";
                                }elseif(isset($data['min_section'])){
                                    echo $data['min_section']['section']." ";
                                }
                            ?> 
                        </td>
                        <td class="tcb-2 tcb-3 tp-0"></td>
                    </tr>
                    <tr>
                        <td class="tcb-2 tp-0">TOTAL HORAS</td>
                        <td class="tcb-2 tp-0">
                            <?php echo $data['time_table_count']; ?>h
                        </td>
                        <td class="tcb-1 tcb-3 tp-0">
                            <?php echo !empty($data['subject_data']['name'])?$data['subject_data']['name']:''; ?>
                        </td>
                    </tr>
                </table>
            </div>
            <table class="table table-stripped bordertable" cellpadding="0" border="1" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="text text-center tableheader"><?php echo $this->lang->line("time"); ?></th>
                        <?php
                        foreach ($data['timetable'] as $tm_key => $tm_value) {
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
                    foreach ($data['lesson_timetables'] as $key => $value) 
                    {
                        if($timezone_id!=0 && ($timezone_id!=$value['timezone_id']) )
                        {
                            print("<tr><td colspan=30>&nbsp;</td></tr>");
                        }
                        $timezone_id = $value['timezone_id'];                
                        ?>
                        <tr class="restbackground">
                            <td class="text text-center tabletime"><?php echo $value['time_from']." ~ ".$value['time_to'];?></td>
                            <?php if($value['time_type'] == 1) { ?>
                                <td class="text text-center rest">R</td>
                                <td class="text text-center rest">E</td>
                                <td class="text text-center rest">CR</td>
                                <td class="text text-center rest">E</td>
                                <td class="text text-center rest">O</td>
                            <?php } else { ?>
                                <?php foreach($data['days'] as $day_key=>$day_value) {?>
                                    <td class="text text-center subjectclass" width="14%">
                                        <?php 
                                        $dup_flag = false;
                                        foreach($data['duplicated_result'] as $row) {
                                            if($key==$row->lesson_id)
                                            {
                                                $dup_flag = true;
                                            }
                                        }
                                        if($dup_flag) print("<span class='red'>");
                                        if( !empty($data['timetable'][$day_value][$key]) )
                                            echo substr($data['timetable'][$day_value][$key]->class,0,1).$data['timetable'][$day_value][$key]->section;
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
        </div>
        <?php
    }
}
?>