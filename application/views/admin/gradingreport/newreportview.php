<style type="text/css" media="print">
    @page
    {
        size:  auto;   /* auto is the initial value */
        margin: 10mm;  /* this affects the margin in the printer settings */
    }

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
            counter-increment: page;
            counter-reset: page 1;
           /* @top-right {
                content: "Page " counter(page) " of " counter(pages);
            }*/
        }
    }
    @media print {
        .pagebreak {
            page-break-before: always;

        }
        tfoot { visibility: hidden; }
        /* page-break-after works, as well */
    }
    @media print {
        @page {
            margin-top: 0;
            margin-bottom: 0;
        }
        * {
            -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
            color-adjust: exact !important;  /*Firefox*/
        }
    }
    * {
        padding: 0;
        margin: 0;
    }

    .tableone td {
        padding: 5px 10px
    }


    .denifittable th {
        padding: 10px 10px;
        font-weight: normal;
        border-collapse: collapse;
        border-right: 1px solid #999;
        border-bottom: 1px solid #999;
    }

    .denifittable td {
        padding: 10px 10px;
        font-weight: bold;
        border-collapse: collapse;
        border-left: 1px solid #999;
    }

    .mark-container {
        width: 1000px;
        position: relative;
        z-index: 2;
        margin: 0 auto;
        padding-top: 20px;
        padding-bottom: 20px;
    }
    .pagebreak {
        page-break-before: always;
        counter-increment: section;
    }

    .tablemain {
        position: relative;
        z-index: 2
    }
    .bordertable,
    .bordertable th,
    .bordertable td {
        border: 1px solid black;
        border-collapse: collapse;
    }


    span:before {
        content: '';
        width: 100%;
        height: 3em;
        display: inline-block;
    }

    span {
        display: inline-block; /* Can remove if span:before width doesn't matter. */
    }
    div.sticky {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        padding: 5px;
        background-color: #cae8ca;
        border: 2px solid #4CAF50;
        bottom: 8px;
    }
    .bottomright {
        position: absolute;
        bottom: 8px;
        right: 16px;
        font-size: 18px;
    }
    div.static {
        position: static;
        border: 3px solid #73AD21;
    }

    div.absolute {
        position: absolute;
        width: 50%;
        bottom: 10px;
        border: 3px solid #8AC007;
    }
    div.fixed {
        position: fixed;
        width: 100%;
        bottom: 10px;
        border: 3px solid #8AC007;
    }
    div.relative {
        position: relative;
        width: 50%;
        bottom: 5px;!important;
        margin-top: 500px;
        border: 3px solid #8AC007;
    }
    body{ min-height:100vh; margin:0; position:relative; }
    header{ min-height:50px; background:lightcyan; }
    footer{ background:PapayaWhip; }

    /* Trick: */
    body {
        position: relative;
        counter-reset: section;
    }

    body::after {
        content: '';
        display: block;
        height: 50px; /* Set same as footer's height */
    }

    footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 50px;
    }

    span::before {
        counter-increment: section;                 /* Increment the value of section counter by 1 */
        content: counter(section) ": ";  /* Display counter value in default style (decimal) */
    }

</style>
<?php
    $totalpageNum = $this->session->userdata['pageNum'];
    $pageNum = 1;

    if($level == 'NIVEL INICIAL')
    {
        $level_t = 'Nivel Inicial';
    }
    else
    {
        $level_t = 'Nivel Primario';
    }

    //////////////////////--------------------------------------->
    //Sorry.
    //plz edit class name.
    $class_t = '';
    if($class == "1er Grado. Primer Ciclo Matutino")
    {
        $class_t =  "1er Grado. Primer Ciclo";
    }
    else if($class == "1er Grado. Primer Ciclo Vespertino")
    {
        $class_t =  "1er Grado. Primer Ciclo";
    }
    else if($class == "2do Grado. Primer Ciclo Matutino")
    {
        $class_t =  "2do Grado. Primer Ciclo";
    }
    else if($class == "2do Grado. Primer Ciclo Vespertino")
    {
        $class_t =  "2do Grado. Primer Ciclo";
    }
    else if($class == "3er Grado. Primer Ciclo Matutino")
    {
        $class_t =  "3er Grado. Primer Ciclo";
    }
    else if($class == "3er Grado. Primer Ciclo Vespertino")
    {
        $class_t =  "3er Grado. Primer Ciclo";
    }
    else if($class == "4to Grado. Segundo Ciclo Matutino")
    {
        $class_t =  "4to Grado. Segundo Ciclo";
    }
    else if($class == "4to Grado. Segundo Ciclo Vespertino")
    {
        $class_t =  "4to Grado. Segundo Ciclo";
    }
    else if($class == "5to Grado. Segundo Ciclo Matutino")
    {
        $class_t =  "5to Grado. Segundo Ciclo";
    }
    else if($class == "5to Grado. Segundo Ciclo Vespertino")
    {
        $class_t =  "5to Grado. Segundo Ciclo";
    }

    else if($class == "6to Grado. Segundo Ciclo Matutino")
    {
        $class_t =  "6to Grado. Segundo Ciclo";
    }
    else if($class == "6to Grado. Segundo Ciclo Vespertino")
    {
        $class_t =  "6to Grado. Segundo Ciclo";
    }

  else if($class == "PRE-KINDER MATUTINO")
    {
        $class_t =  "PRE-KINDER";
    }
  else if($class == "PRE-KINDER VESPERTINO")
    {
        $class_t =  "PRE-KINDER";

    }
  else if($class == "PRE-PRIMARIO VESPERTINO")
    {
        $class_t =  "PRE-PRIMARIO";
    }

  else if($class == "PRE-PRIMARIO MATUTINO")
    {
        $class_t =  "PRE-PRIMARIO";
    }

  else if($class == "KINDER MATUTINO")
    {
        $class_t =  "KINDER";
    }
  else if($class == "KINDER VESPERTINO")
    {
        $class_t =  "KINDER";
    }


   //////////////////////<---------------------------------------
    $pnce = True;
    if (!empty($periodList)) {
    foreach ($periodList as $period) {
    if (empty($period_id) || $period['id'] == $period_id) {
    $period_label = '';
    if($period['label'] == 1)
    {
        $period_label =  "1er Período";
    }
    else if($period['label'] == 2)
    {
        $period_label = "2do Período";
    }
    else if($period['label'] == 3)
    {
        $period_label = "3er Período";
    }
    else if($period['label'] == 4)
    {
        $period_label = "4to Período";
    }
    else
    {
        $period_label = "5to Período";
    }
    $footer = $period_label." de Evaluación.".$class_t.".".$level_t;
//////////"Sección" $section_t
    if($totalpageNum != 0 and $totalpageNum % 2 == 0 and $pnce == True)
    {
        $pnce = False;
        echo '<div class="mark-container" style="position:relative; border:solid 0px;height: 1500px;margin-top: 10px;">';
        echo "</div>";
        echo '<div class="pagebreak"></div>';
    }
?>

<div class="mark-container" style="position:relative;  border:solid 0px;height: 1500px;margin-top: 10px;">

    <div style = "width:1000px;position:absolute;z-index: 1000;border:solid 0px;text-align: center;">
        <table cellpadding="0" cellspacing="0" width="100%" class="tablemain" border="0 ">
        <tr><td><div style="height: 50px;"></div></td></tr>
        <tr>
            <td valign="top">
                <table cellpadding="0" cellspacing="0" width="100%" border="0">
                    <tr>
                        <td valign="top" align="center" width="150" id="logo">
                            <img src="<?php echo base_url('backend/images/LOGO_EPSR_2022.png'); ?>" width="150" height="150">
                        </td>
                        <td valign="top" style="padding-left: 5px">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td valign="top" height="10" colspan="2"></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="font-size: 40px; font-weight: bold;">Escuela Parroquial Santa Rita</td>
                                </tr>
                                <tr>
                                    <td valign="top" style="font-size: 30px; font-weight: bold;">Agustinos Recoletos</td>
                                </tr>
                                <tr>
                                    <td valign="top" style="font-size: 20px; font-weight: bold;">Av. Libertad No. 31, San Cristóbal, R.D Tel.: 809-528-3552 Email: info@epsr.edu.do
                                        <br>RNC: 4-1401247-2
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td valign="top" height="15"></td>
        </tr>

        <tr>
            <td valign="top" >
                <table cellpadding="0" border="1" cellspacing="0" width="100%">
                    <tr>
                        <td valign="top" style="width : 31%;font-size: 21px;padding:5px;" colspan="2">
                            <b> &nbsp;Código del centro: </b> 21002717
                            <br>
                            <b> &nbsp;Año Escolar: </b>  <?php echo $session ?>
                        </td>
                        <td valign="top" style="width : 69%;font-size: 21px;padding:5px;" colspan="3">
                            <b> &nbsp;Regional Educativa: </b> San Cristóbal, Norte 04
                            <br>
                            <b> &nbsp;Distrito Educativo: </b>  San Cristóbal 04-02
                        </td>
                    </tr>
                    <tr>
                        <td style="width : 31%;font-size: 21px;padding:5px;"  colspan="2"><b>&nbsp;SIGERD:</b> <?php echo $student['roll_no'] ?></td>
                        <td style="width : 38%;font-size: 21px;padding:5px;" colspan="2"><b>&nbsp;Curso: </b><?php echo $class ?> </td>
                        <td style="padding:5px;width : <?php if($student['level'] == "NIVEL INICIAL") echo "30";else echo "13"; ?>%;font-size: 21px;" colspan="1"><b>&nbsp;Sección: </b> <?php echo $student['section'] ?></td>
                    </tr>
                    <tr>
                        <td  style="width : 25%;font-size: 28px;padding:5px;" colspan="1">
                            <b>&nbsp;No. Orden: </b> <?=$order_number; ?>
                        </td>
                        <td style="width : 75%;font-size: 28px;padding:5px;" colspan="4">
                            <b>&nbsp;Nombre y Apellidos: </b><?php echo $this->customlib->getFullName($student['firstname'],
                                $student['middlename'], $student['lastname'],
                                $sch_setting->middlename, $sch_setting->lastname); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td valign="top" height="190"></td>
        </tr>
        <tr>


            <?php if($level == "NIVEL INICIAL") { ?>
            <td valign="top" colspan="5" style="height: 810px ;font-weight: bold;font-family: 'Arial Black'; font-size: 67px; text-align:center">
                Informe de Evaluación<br>
                de los Aprendizajes de<br>
                los Niños y Niñas del<br>
                Nivel Inicial<br>
                <?php }else{ ?>
            <td valign="top" colspan="5" style="height: 810px ;font-weight: bold;font-family: 'Arial Black'; font-size: 55px; text-align:center">
                INFORME DE APRENDIZAJE<br>
                <br>
                <div style="font-weight: bold;font-size:67px;font-family: 'Arial Black'">
                    <?php if($class == "1er Grado. Primer Ciclo Matutino")
                    {
                        echo "Primer Grado<br>";
                    }
                    else if($class == "1er Grado. Primer Ciclo Vespertino")
                    {
                        echo "Primer Grado<br>";
                    }
                    else if($class == "2do Grado. Primer Ciclo Matutino")
                    {
                        echo "Segundo Grado<br>";
                    }

                    else if($class == "2do Grado. Primer Ciclo Vespertino")
                    {
                        echo "Segundo Grado<br>";
                    }

                    else if($class == "3er Grado. Primer Ciclo Matutino")
                    {
                        echo "Tercer Grado<br>";
                    }

                    else if($class == "3er Grado. Primer Ciclo Vespertino")
                    {
                        echo "Tercer Grado<br>";
                    }
                    else if($class == "4to Grado. Segundo Ciclo Matutino")
                    {
                        echo "Cuarto Grado<br>";
                    }
                    else if($class == "4to Grado. Segundo Ciclo Vespertino")
                    {
                        echo "Cuarto Grado<br>";
                    }
                    else if($class == "5to Grado. Segundo Ciclo Matutino")
                    {
                        echo "Quinto Grado<br>";
                    }
                    else if($class == "5to Grado. Segundo Ciclo Vespertino")
                    {
                        echo "Quinto Grado<br>";
                    }

                    else if($class == "6to Grado. Segundo Ciclo Matutino")
                    {
                        echo "Sexto Grado<br>";
                    }
                    else if($class == "6to Grado. Segundo Ciclo Vespertino")
                    {
                        echo "Sexto Grado<br>";
                    }
                    ?>
                    del Nivel Primario
                </div>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <table cellpadding="0" cellspacing="0" width="100%" border="0">
                    <tr>
                        <td valign="top" style="width: 33%;font-weight: bold; font-size: 18px; text-align:center;  line-height:1.5;">
                            <div style="text-decoration-line:overline;"> P. Arturo Yax Pacheco, OAR </div>
                            <font size="4pt" >Director General</font>
                        </td>
                        <td valign="top" style="width: 34%;  font-weight: bold; font-size: 18px; text-align:center; line-height:1.5;">
                            <div style="text-decoration-line:overline;"><?= $level_coordinator ?></div>
                            <font size="4pt"> Coordinadora Nivel <?php if($level == "NIVEL PRIMARIO") echo "Primario"; else echo "Inicial"; ?></font>
                        </td>
                        <td valign="top" style="width: 33%; font-weight: bold; font-size: 18px; text-align:center; line-height:1.5;">
                            <div style="text-decoration-line:overline;"><?= $class_teacher ?></div>
                            <font size="4pt">Maestro/a Guía</font>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </div>
    <div style="width:100%;position:absolute;margin-top: 1470px;widht:100%;height: 30px;z-index: 1;border: solid 0px; border-top:solid 1px; ">
        <div style="width:80%;float:left;font-size:20px;">
            <?=$footer;?>
        </div>
        <div style="width:20%;float:right;font-size:20px;text-align: right">
            Pag.<?=$pageNum++;?>
        </div>
    </div>
</div>
<div class="pagebreak"></div>
<div class="mark-container" style="position:relative; border:solid 0px;height: 1500px;margin-top: 10px;">
    <div style = "width:1000px;position:absolute;z-index: 1000;border:solid 0px;text-align: center;">
    <?php
        $pagesize = 1500;
        $currentpagesize = 0;
        echo
        '<table cellpadding="0" cellspacing="0" width="100%" class="tablemain" border="0">
        <tr><td colspan="2"  style="height: 50px;"></td><tr>
                    <tr>
                        <td valign="top">

                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="width:80%;padding-top: 60px;font-weight: bold; font-size: 25px; text-align:left">';
                                        if($period['label'] == 1)
                                        {
                                            echo "PRIMER PERÍODO";
                                        }
                                        else if($period['label'] == 2)
                                        {
                                            echo "SEGUNDO PERÍODO";
                                        }
                                        else if($period['label'] == 3)
                                        {
                                            echo "TERCER PERÍODO";
                                        }
                                        else if($period['label'] == 4)
                                        {
                                            echo "CUARTO PERÍODO";
                                        }
                                        else
                                        {
                                            echo "QUINTO PERÍODO";
                                        }
                                        echo "(".$monthlist[$period["start_month"]]."-". $monthlist[$period["end_month"]].")";
										echo '
                                    </td>
                                    <td valign="top" style="font-weight: bold; font-size: 20px; text-align:center">
                                        <table class="bordertable" width="100%"> 
                                            <thead>
                                               
                                                </thead>
                                                <tbody>';
   
        error_log("report view 542");
        echo'

                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>';
        echo '
                    <tr>
                        <td valign="top" height="10"></td>
                    </tr>';
                                        
        $currentpagesize = 100;
        $n = 0;
        foreach ($competenceList[$period['id']] as $competence)
        {
            error_log("report view 560: " . count($indicatorsList[$competence['id']]));
            if(count($indicatorsList[$competence['id']]) == 0) continue;
            $flag = false;
            $td_count = 33;
            error_log("td_count " . gettype($td_count));
            error_log("indicatorslist competence id " . gettype(count($indicatorsList[$competence['id']])));
            if(count($indicatorsList[$competence['id']]) < $td_count)
            {
                error_log("report view 567");
                foreach ($indicatorsList[$competence['id']] as $indicator)
                {
                    if(strlen($indicator["name"]) > 100)
                    {
                        $td_height = 75;
                    }
                    else
                    {
                        $td_height = 43;
                    }
                    $currentpagesize += $td_height;
                }
            }
            else
            {
                error_log("report view 584");
                $flag = true;
            }
            if($currentpagesize > $pagesize and $flag == false)
            {
                error_log("report view 589");
                $currentpagesize = 50;
                echo "</table>";
                echo '</div>';
                echo '<div style="width:100%;position:absolute;margin-top: 1470px;widht:100%;height: 20px;z-index: 1;border: solid 0px;border-top:solid 1px; ">
                            <div style="width:80%;float:left;font-size:20px;">
                                '.$footer.'
                            </div>
                            <div style="width:20%;float:right;font-size:20px;text-align: right">
                                Pag.'.$pageNum++.'
                            </div>
                        </div>';
                echo "</div>";
                echo '<div class="pagebreak"></div>';
                echo '<div class="mark-container" style="position:relative; border:solid 0px;height: 1500px;margin-top: 10px;">';
                echo '<div style = "width:1000px;position:absolute;z-index: 1000;border:solid 0px;text-align: center;">';
                echo '<table cellpadding="0" cellspacing="0" width="100%" class="tablemain" border="0">';
                echo '<tr><td> <div style="height: 70px;"></td><tr>';
                if(count($indicatorsList[$competence['id']]) < $td_count)
                {
                    error_log("report view 607");
                    foreach ($indicatorsList[$competence['id']] as $indicator)
                    {
                        if(strlen($indicator["name"]) > 100)
                        {
                            $td_height = 75;
                        }
                        else
                        {
                            $td_height = 43;
                        }
                        $currentpagesize += $td_height;
                    }
                }
                else
                {
                    error_log("report view 623");
                    //$currentpagesize = (count($indicatorsList[$competence['id']]) - 33) * 46 + 50;
                }
            }
            if($level != "NIVEL INICIAL")
            {
                error_log("report view 629");
                $currentpagesize += 110;

                 echo '
                    <tr>
                        <td style="width:70%;font-weight: bold; font-size: 25px; text-align:left">AREA: '.$competence["name"].'</td>
                    </tr>';
                echo '
                    <tr>
                        <td valign="top" style="font-size: 24px; text-align:center">
                            <table class="bordertable" width="100%">
                                <thead>
                                <tr>
                                    <th valign="bottom" style="background-color: #afafc6; height: 40px;font-size: 24px; text-align:left; padding-left:10px">';
                echo "INDICADORES DE LOGRO";
                echo '
                                    </th>';
            }
            else
            {
                $currentpagesize += 70;
                echo '
                    <tr>
                        <td valign="top" style="font-size: 24px; text-align:center">
                            <table class="bordertable" width="100%">
                                <thead>
                                <tr>
                                    <th valign="bottom" style="background-color: #afafc6; height: 40px;font-size: 24px; text-align:left; padding-left:10px">';
                echo $competence["name"];
                echo '
                                    </th>';
            }

            foreach ($valuescaleList as $valuescale)
            {
                error_log("report view 665");
                echo '<th valign="bottom" style="background-color: #afafc6;width:40px; font-size: 18px; text-align:center;padding: 5px">'.$valuescale["label"].'</th>';
            }
            echo  '
                                </tr>
                                </thead>
                                <tbody>';
            $n = 0;
           foreach ($indicatorsList[$competence['id']] as $indicator)
            {
                error_log("report view 679");
                
                $n++;
                if($n >= $td_count and $flag = true)
                {
                    $n = 0;
                    $currentpagesize = (count($indicatorsList[$competence['id']]) - 33) * 46 + 50;
                    echo "</tbody>";
                    echo "</table>";
                    echo "</table>";
                    echo '</div>';
                    echo '<div style="width:100%;position:absolute;margin-top: 1470px;widht:100%;height: 20px;z-index: 1;border: solid 0px;border-top:solid 1px; ">
                            <div style="width:80%;float:left;font-size:20px;">
                                '.$footer.'
                            </div>
                            <div style="width:20%;float:right;font-size:20px;text-align: right">
                                Pag.'.$pageNum++.'
                            </div>
                        </div>';
                    echo "</div>";
                    echo '<div class="pagebreak"></div>';
                    echo '<div class="mark-container" style="position:relative; border:solid 0px;height: 1500px;margin-top: 10px;">';
                    echo '<div style = "width:1000px;position:absolute;z-index: 1000;border:solid 0px;text-align: center;">';
                    echo '<table cellpadding="0" cellspacing="0" width="100%" class="tablemain" border="0">';
                    echo '<tr><td> <div style="height: 70px;"></td><tr>';
                    $currentpagesize += 80;
                   echo '
                    <tr>
                        <td valign="top" style="font-size: 24px; text-align:center">
                            <table class="bordertable" width="100%">
                                <thead>
                                <tr>
                                    <th valign="bottom" style="background-color: #afafc6; height: 40px;font-size: 24px; text-align:left; padding-left:10px">';
                echo $competence["name"];
                echo '
                                    </th>';
                    foreach ($valuescaleList as $valuescale)
                    {
                        echo '<th valign="bottom" style="background-color: #afafc6;width:40px; font-size: 18px; text-align:center">'.$valuescale["label"].'</th>';
                    }
                    echo  '
                                </tr>
                                </thead>
                                <tbody>';
                }
                echo '
                    <tr>
                        <td valign="top" style="padding: 5px 10px; font-size: 22px; text-align:left">'.$indicator["name"].'</td>';
                foreach ($valuescaleList as $valuescale)
                {
                    echo '<td valign="top" style="padding: 5px 10px; font-size: 18px; text-align:center">';
                    if ($indicator['marks'] == $valuescale['marks'])
                    {
                        echo $valuescale['symbol'];
                    }
                    echo '
                                        </td>';
                }
                echo ' </tr>';

            }
            echo '
                                </tbody>';
            echo '
                            </table>';
            echo '
                        </td>';
            echo '
                    </tr>';
            echo '
                    <tr>
                        <td valign="top" height="30"></td>
                    </tr>';


        }
        $height = 1000;
        if($level == "NIVEL INICIAL")
            $height = 1100;
        if($currentpagesize >= $height || ((mb_strlen($observation) > 190 && $currentpagesize > 900) || (mb_strlen($observation) > 400 && $currentpagesize > 700)))
        {
            echo "</tr></table>";
            echo  "</div>";
            echo '<div style="width:100%;position:absolute;margin-top: 1470px;widht:100%;height: 20px;z-index: 1;border: solid 0px;border-top:solid 1px; ">
                            <div style="width:80%;float:left;font-size:20px;">
                                '.$footer.'
                            </div>
                            <div style="width:20%;float:right;font-size:20px;text-align: right">
                                Pag.'.$pageNum++.'
                            </div>
                        </div>';
            echo '</div>';
            echo '<div class="pagebreak"></div>';
            echo '<div class="mark-container" style="position:relative; border:solid 0px;height: 1500px;margin-top: 10px;">';
            echo '<div style = "width:1000px;position:absolute;z-index: 1000;border:solid 0px;text-align: center;">';
            echo "<table width='100%'>";
            echo '<tr><td><div style="height: 50px;"></td></tr>';
        }
        echo '
                <tr>';
        echo '
                    <td valign="top">';
        echo '
                        <table cellpadding="0" cellspacing="0" width="100%">';
        echo '
                            <tr>
                                <td valign="top" height="30"></td>
                            </tr>';
    
        echo '
                            <tr>
                                <td valign="top" height="30"></td>
                            </tr>';
        echo '
                            <tr>';
        echo '
                                <td valign="top">
                                    <table class="bordertable" width="46%">';
        if($level == "NIVEL INICIAL")
        {
            error_log("report view 794");
            echo '
                                            <thead>';
            echo '
                                                <tr style="background-color: #afafc6">
                                                    <th style="font-size: 22px; padding: 5px 5px; text-align:center">Control de Asistencia</th>
                                                    <th style="font-size: 22px; padding: 5px 5px; text-align:center">'.$monthlist[$period["start_month"]]." / ".$monthlist[$period["end_month"]].'</th>
                                                </tr>';
            echo '
                                            </thead>';
            echo '
                                            <tbody>';
											
			 echo '
                                            <tr>
                                                <td valign="top" style="font-size: 22px; text-align:left; padding: 5px 5px;">Presencias </td>
                                                <td valign="top" style="font-size: 22px; text-align:left; padding-left: 15px;"></td>
                                            </tr>';
 
            echo '
                                            <tr>
											    <td valign="top" style="font-size: 22px; text-align:left; padding: 5px 5px;">Ausencias</td>
                                                <td valign="top" style="font-size: 22px; text-align:left; padding-left: 15px;"></td>
                                            </tr>';
            echo '
                                            </tbody>';
        }
        else
        {
            error_log("report view 821");
            echo '<thead>';
            echo '
                                            <tr style="background-color: #afafc6">
                                                <th style="font-size: 22px; padding: 5px 5px; text-align:center">AUSENCIAS-TARDANZAS</th>
                                                <th style="font-size: 22px; padding: 5px 5px; text-align:center">'. strtoupper($monthlist[$period["start_month"]])."/".strtoupper($monthlist[$period["end_month"]]).'</th>
                                            </tr>';
            echo '
                                            </thead>
                                            <tbody>';
            echo '
                                            <tr>
                                                <td valign="top" style="font-size: 22px; text-align:left; padding: 5px 5px;">Ausencias Justificadas </td>
                                                <td valign="top" style="font-size: 22px; text-align:left; padding-left: 15px;"></td>
                                            </tr>';
            echo '
                                            <tr>
                                                <td valign="top" style="font-size: 22px; text-align:left; padding: 5px 5px;">Ausencias No Justificadas</td>
                                                <td valign="top" style="font-size: 22px; text-align:left; padding-left: 15px;"></td>
                                            </tr>';
            echo '
                                            <tr>
                                                <td valign="top" style="font-size: 22px; text-align:left; padding: 5px 5px;">Tardanzas</td>
                                                <td valign="top" style="font-size: 22px; text-align:left; padding-left: 15px;"></td>
                                            </tr>';
            echo '
                                            </tbody>';
        }
        echo '
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>';
        echo '</table>';

        echo '<div style="line-height:1.5; width:100%;text-align: left;">
            <div style="padding-top:10px;font-weight: bold; font-size: 30px;">Observaciones: </div>';
            $i = 0;
            if ($observations_1) {
                if ($period['label'] == "1") $observation = $observations_1;
                if ($period['label'] == "2") $observation = $observations_2;
                if ($period['label'] == "3") $observation = $observations_3;
            }
            if(strlen($observation) >= 99)
            {
                $str = substr($observation,$i,99);
                $str = substr($str,0,strripos($str," "));
                $i = strlen($str);
            } 
            else
            {
                $str = $observation;
                $i = strlen($observation);
            }
            
            if(strlen($str) == 0)
            {
                echo '<div style="width:100%; height: 40px; top:45px; border-bottom: 1px solid black;"></div>';
                echo '<div style="width:100%; height: 40px; top:45px; border-bottom: 1px solid black;"></div>';
                echo '<div style="width:100%; height: 40px; top:45px; border-bottom: 1px solid black;"></div>';
            }
            else
            {
                while(strlen($str) != 0)
                {
                    echo '<div style="width:100%;font-size:25px; margin-top:10px; border-bottom: 1px solid black;">'.$str.'</div>';
                    $str = substr($observation,$i,99);
                    if(strlen($str) >= 99)
                        $str = substr($str,0,strripos($str," "));
                    $i += strlen($str);
                }
            }
        echo '<div style="width:100%;margin-top:100px;">'; 
            echo '<div style="float:left;width:20%; font-size:30px; height: 30px; top:15px;font-weight: bold;">Promovido/a a:</div>'; 
            echo '<div style="float:left;width:80%; height: 30px; padding-top:10px; border-bottom: 1px solid black;"></div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<div style="width:100%;position:absolute;margin-top: 1470px;widht:100%;height: 20px;z-index: 1;border: solid 0px;border-top:solid 1px; ">
                            <div style="width:80%;float:left;font-size:20px;">
                                '.$footer.'
                            </div>
                            <div style="width:20%;float:right;font-size:20px;text-align: right">
                                Pag.'.$pageNum++.'
                            </div>
                        </div>';
        echo '</div>';
        echo '
            <div class="pagebreak"></div>';
        }
        }
        }
        $totalpageNum=$pageNum;
        error_log("report view 916");
        $this->session->userdata['pageNum'] = $totalpageNum;
        error_log("report view 918");
    ?>
