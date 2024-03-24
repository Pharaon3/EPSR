
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
            <i class="fa fa-mortar-board"></i><?php echo $this->lang->line('timetable'); ?> </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('teacher_time_table'); ?></h3>
                        <div class="box-tools pull-right"></div>
                    </div>

                    <div class="box-body">
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



                    </div>


                </div>
            </div>
        </div>
    </section>
</div>

