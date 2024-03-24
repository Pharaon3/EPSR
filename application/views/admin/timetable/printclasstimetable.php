<style type="text/css" media="print">
    
</style>

<style type="text/css">
    body {
        counter-reset: section;                     /* Устанавливает значение
                                                 счётчика, равным 0 */
    }
    @media print
    {
        @page {
            size: A4;
            margin-top: 0;
            margin-bottom: 0;
        }
    }
    .tableone td {
        padding: 5px 10px
    }
    
    .mark-container {
        width: 100%;
        padding-bottom: 20px;
    }
  
    .blank100
    {
        width:100%;
        height: 100px;
    }
    .blank50
    {
        width:100%;
        height: 50px;
    }
    .blank20
    {
        width:100%;
        height: 20px;
    }
    .blank10
    {
        width:100%;
        height: 10px;
    }
    .header
    {
        font-size: 35px;
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        text-decoration-line: underline;
    }

    .header_secondary
    {
        font-size: 24px;
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        text-decoration-line: underline;
    }
    .title
    {
        font-size: 23px;
        text-decoration-line: underline;
    }
    .title_secondary
    {
        font-size: 23px;
        width:50%;
    }
    .restbackground
    {
        background-color: #afafc6;
    }
    .rest
    {
        padding: 5px 5px;
        font-size:22px;
        font-weight: bold;
        text-align: center;
    }
    .subjectclass
    {
        font-size:18px;
        text-align: center;
        padding:5px 5px 5px 5px;
        word-break: break-word;
        overflow: hidden;
        width:100px;
    }
    .bordertale
    {
        width:100%;
    }
    .footer
    {
        font-size:15px;
        font-style: italic;
    }
    .tableheader
    {
        padding: 5px 5px;
        font-size:23px;
        font-weight: bold;
        border-collapse: collapse;
        border-right: 1px solid #999;
        border-bottom: 1px solid #999;
    }

    .tabletime
    {
        padding: 5px 5px;
        font-size:23px;
        width:90px;
        font-weight: bold;
        border-collapse: collapse;
        border-right: 1px solid #999;
        border-bottom: 1px solid #999;
        text-align: center;
    }
    .headertitle
    {
        font-size: 33px;
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
        text-align: left;
    }
</style>
<div class="blank50"></div>
<div class="table-responsive">   
    <div class="">
        <?php

        if($level_name == "NIVEL INICIAL")
        {
            echo "<div class='header'>HORARIOS DEL $level_name<br>
            TANDA $lesson_type 2021-2022</div>";
        }
        else if($level_name == "NIVEL PRIMARIO"){
            echo "<table class='headertable'>";
            echo "<tr>";
            echo '<td rowspan = "3" valign="top" align="center" width="70" id="logo">
                    <img src='.base_url('backend/images/grading_report_logo.jpg').' width="70" height="70">
                </td>';
            echo "<td class='headertitle'>ESCUELA PARROQUIAL SANTA RITA</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><div style='display:flex;border-bottom: 1px solid black;font-style:italic'>
                    <div style='width:50%'><b>Agustinos  Recoletos</b></div>";
            echo "<div style='width:50%;text-align:right'><b>Ciencia y Amor</b></div></div></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><div style='display:flex;font-style:italic'>
                    <div style='width:60%'><b>Lema: “Construimos juntos la casa de Dios”</b></div>";
            echo "<div style='width:40%;text-align:right'><b>Valor:</b> Comunidad</div></div></td>";
            echo "</tr>";
            echo "</table>";
        }
        else
        {
            echo "<div class='header_secondary'>HORARIO DE SECUNDARIA DEL AÑO ESCOLAR 2021-22</div>";
        }
        ?>
        
    </div>
    <div class="blank20"></div>
    <div>
        <?php
        if($level_name == "NIVEL INICIAL")
        {
            if($class_name == strtoupper("Pre-Kinder") && $section_name == "A")
            $str = "Lourden Linares";
            else if($class_name == strtoupper("Pre-Kinder") && $section_name == "B")
                $str = "Mariel Mateo";
            else if($class_name == strtoupper("Kinder") && $section_name == "A")
                $str = "Dominicana Brito";
            else if($class_name == strtoupper("Kinder") && $section_name == "B")
                $str = "Katya Uribe";
            else if($class_name == strtoupper("Pre-Primario") && $section_name == "A")
                $str = "Altagracia Mateo";
            else if($class_name == strtoupper("Pre-Primario") && $section_name == "B")
                $str = "Oniris Cuevas";
            else if($class_name == strtoupper("Pre-Kinder") && $section_name == "C")
                $str = "Katya Uribe";
            else if($class_name == strtoupper("Kinder") && $section_name == "C")
                $str = "Dominicana Brito";
            else if($class_name == strtoupper("Pre-Primario") && $section_name == "C")
                $str = "ONIRIS CUEVAS";

            echo "<div class='title'>".$class_name. " ".$section_name." ".$str."</div>";
        }
        else if($level_name == "NIVEL PRIMARIO")
        {
            echo "<div class='title'>".$class_name. " ".$section_name." (".$str.")</div>" ;
        }
        else if($level_name == "NIVEL SECUNDARIO")
        {
            echo"<div style='display:flex;'><div class='title_secondary'>". $class_name. " ".$section_name." 
            de Secundaria</div><div class='title_secondary' style='text-align:right;'>Prof. ".  $teacher[0]['surname'] ."</div></div>" ;
        }
       ?>
    </div>
    <?php
    if($level_name != "NIVEL SECUNDARIO")
    {
    ?>
        <div class="blank10"></div>
    <?php
    }
    ?>
    <div class="mark-container">
    <table class="bordertable" cellpadding="0" border="1" cellspacing="0" width="100%">
        <thead>
            <tr >
                <th class = "tableheader"><?php echo $this->lang->line("time"); ?></th>
                <?php
                foreach ($timetable as $tm_key => $tm_value) {
                    ?>
                    <th class="tableheader"><?php echo $this->lang->line(strtolower($tm_key)); ?>
                    </th>
                    <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
                <?php
                $count = 0;
                $rows = 0;
                $cols = 0;
                foreach ($lesson_timetables as $key => $value) 
                {
                    ?>
                    <tr <?php if($value['time_type'] != 0) echo "class = 'restbackground'"?>>
                    <td class="tabletime" ><?php echo $value['time_from']." ".$value['time_to'];?></td>
                    <?php 
                    if($value['time_type'] == 2) 
                    {
                        echo '<td class="subjectclass">Merienda</td>';
                        echo '<td class="subjectclass">Merienda</td>';
                        echo '<td class="subjectclass">Merienda</td>';
                        echo '<td class="subjectclass">Merienda</td>';
                        echo '<td class="subjectclass">Merienda</td>';
                    }
                    else if($value['time_type'] == 1)
                    {
                        echo '<td class="rest">R</td>';
                        echo '<td class="rest">E</td>';
                        echo '<td class="rest">CR</td>';
                        echo '<td class="rest">E</td>';
                        echo '<td class="rest">O</td>';
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
                                    <td rowspan="2" class="subjectclass">
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
                                    <td class="subjectclass">
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
                                <td class="subjectclass">
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
            
        </tbody>
    </table>
    </div>
    <?php if($level_name == "NIVEL INICIAL") 
    { ?>
        <div class="footer"><b>San Agustín</b> “Gran poder tiene para hacernos propicios a Dios la concordia fraterna”</div>
    <?php 
    } 
    else if($level_name == "NIVEL PRIMARIO")
    {
    ?>
        <div class="footer"><b>San Agustín</b> “El amor jamás envejece porque siempre es un sentimiento nuevo”</div>
    <?php
    }
    ?>
</div>  