<style type="text/css" media="print">
    @page
    {
        size:  auto;   /* auto is the initial value */
        margin: 10mm;  /* this affects the margin in the printer settings */
    }

</style>

<style type="text/css">
    @media print
    {
        @page {
            size: A4;
            counter-increment: page;
            counter-reset: page 1;
            @top-right {
                content: "Page " counter(page) " of " counter(pages);
            }
        }
        @page :blank {
            @top-center { content: "This page is intentionally left blank" }
        }

    }
    @media print {
        .pagebreak {
            page-break-before: always;
        }
        tfoot { visibility: hidden; }
        /* page-break-after works, as well */
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
        padding: 20px 30px;
    }
    .pagebreak {
        page-break-before: always;
    }

    .mark-container {
        width: 1000px;
        position: relative;
        z-index: 2;
        margin: 0 auto;
        padding: 20px 30px;
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
</style>
<?php
if (!empty($periodList)) {
    foreach ($periodList as $period) {
        if (empty($period_id) || $period['id'] == $period_id) {
?>
            <div class="mark-container">

                <table cellpadding="0" cellspacing="0" width="100%" class="tablemain" border="0">

                    <tr>
                        <td valign="top">
                            <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                <tr>
                                    <td valign="top" align="center" width="150" id="logo">
                                        <img src="<?php echo base_url('backend/images/grading_report_logo.jpg'); ?>" width="150" height="150">
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
                                                <td valign="top" style="font-size: 20px; font-weight: bold;">Av. Libertad No. 31, San Cristóbal, R. D Tel.: 809-528-3552 Email: info@epsr.edu.do
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
                                    <td style="width : 31%;font-size: 21px;padding:5px;"  colspan="2"><b>&nbsp;No. Matrícula:</b> <?php echo $student['admission_no'] ?></td>
                                    <td style="width : 38%;font-size: 21px;padding:5px;" colspan="1"><b>&nbsp;Curso: </b><?php echo $class ?> </td>
                                    <td style="padding:5px;width : <?php if($student['level'] == "NIVEL INICIAL") echo "30";else echo "13"; ?>%;font-size: 21px;" colspan="
                                    <?php if($student['level'] == "NIVEL INICIAL") echo "2";else echo "1"; ?>
                                    "><b>&nbsp;Sección: </b> <?php echo $student['section'] ?></td>
                                    <?php if($student['level'] == "NIVEL PRIMARIO"){ ?>
                                        <td style="font-size: 21px;padding:5px;"><b>Tanda: </b> Matutina</td>
                                    <?php }?>
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

                        <td valign="top" colspan="5" style="height: 830px ;font-weight: bold; font-size: 60px; text-align:center">
                        <?php if($student['level'] == "NIVEL INICIAL") { ?>
                            Informes de Evaluación<br>
                            <div style="font-size:67px;"><?php
                                    $className = str_replace(" VESPERTINO","",$class);
                                    $className = str_replace(" VESPERTINO","",$class);
                                    echo $className;?></div>
                        <?php }else{ ?>
                            INFORME DE APRENDIZAJE<br>
                            <div style="font-size:67px;"><?php
                                    $className = str_replace(" MATUTINO","",$class);
                                    $className = str_replace(" MATUTINO","",$class);
                                    echo $className;?></div>
                        <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                <tr>
                                    <td valign="top" style="width: 33%;font-weight: bold; font-size: 22px; text-align:center;  line-height:1.5;">
                                        <div style="text-decoration-line:overline;"><?= $class_teacher ?></div>
                                        <font size="4pt" >Maestra Guía</font>
                                    </td>
                                    <td valign="top" style="width: 34%;  font-weight: bold; font-size: 22px; text-align:center; line-height:1.5;">
                                        <div style="text-decoration-line:overline;"> P. Arturo Yax Pacheco, OAR</div>
                                        <font size="4pt">Director General</font>
                                    </td>
                                    <td valign="top" style="width: 33%; font-weight: bold; font-size: 22px; text-align:center; line-height:1.5;">
                                        <div style="text-decoration-line:overline;"><?= $level_coordinator ?></div>
                                       <font size="4pt">Coordinadora Nivel <?php if($student['level'] == "NIVEL PRIMARIO") echo "Primario"; else echo "Inicial"; ?></font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="pagebreak"></div>
            <div class="mark-container">
                <table cellpadding="0" cellspacing="0" width="100%" class="tablemain">
                    <tr>
                        <td valign="top">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="width:80%;padding-top: 60px;font-weight: bold; font-size: 25px; text-align:left">
                                        <?php
                                            if($period['label'] == 1)
                                            {
                                                echo "PRIMERO";
                                            }
                                            else if($period['label'] == 2)
                                            {
                                                echo "SEGUNDO";
                                            }
                                            else if($period['label'] == 3)
                                            {
                                                echo "TERCERO";
                                            }
                                            else if($period['label'] == 2)
                                            {
                                                echo "CUARTO";
                                            }
                                            else
                                            {
                                                echo "QUINTO";
                                            }
                                            ?>
                                        PERÍODO (<?php echo $monthlist[$period["start_month"]]; ?> - <?php echo $monthlist[$period["end_month"]]; ?>)
                                    </td>
                                    <td valign="top" style="font-weight: bold; font-size: 22px; text-align:center">
                                        <table class="bordertable" width="100%">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" style="font-size: 20px;background-color: #e6e6ed">Escala de valores</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($valuescaleList as $valuescale) { ?>
                                                    <tr>
                                                        <td valign="top" style="font-size: 18px; text-align:center;"><?php echo $valuescale['symbol'] ?></td>
                                                        <td valign="top" style="font-size: 20px; text-align:left; padding-left: 15px;"><?php echo $valuescale['label'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td valign="top" height="7"></td>
                    </tr>

                    <?php foreach ($competenceList[$period['id']] as $competence) { ?>
                        <?php if($student['level'] == "NIVEL PRIMARIO") {?>
                        <tr>
                            <td style="width:70%;font-weight: bold; font-size: 25px; text-align:left">AREA: <?php echo $competence['name']; ?></td>
                        </tr>
                        <?php }?>
                        <tr>
                            <td valign="top" style="font-size: 24px; text-align:center">
                                <table class="bordertable" width="100%">
                                    <thead>
                                        <tr>
                                            <th valign="bottom" style="background-color: #e6e6ed; height: 40px;font-size: 24px; text-align:left; padding-left:10px">
                                                <?php if($student['level'] == "NIVEL PRIMARIO")  echo "INDICADORES DE LOGRO"; else echo $competence['name'];?>
                                            </th>
                                            <?php foreach ($valuescaleList as $valuescale) { ?>
                                                <th valign="bottom" style="background-color: #e6e6ed;width:40px; font-size: 18px; text-align:center"><?php echo $valuescale['symbol'] ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($indicatorsList[$competence['id']] as $indicator) { ?>
                                            <tr>
                                                <td valign="top" style="padding: 5px 10px; font-size: 22px; text-align:left"><?php echo $indicator['name'] ?></td>
                                                <?php foreach ($valuescaleList as $valuescale) { ?>
                                                    <td valign="top" style="padding: 5px 10px; font-size: 18px; text-align:center">
                                                        <?php if ($indicator['marks'] == $valuescale['marks']) { ?>
                                                            <?php echo $valuescale['symbol'] ?>
                                                        <?php } ?>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" height="30"></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td valign="top">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td valign="top" height="30"></td>
                                </tr>

                                <tr>
                                    <td valign="top" style=" font-weight: bold; font-size: 24px; text-align:left">
                                        CONTROL DE ASISTENCIA
                                    </td>
                                </tr>

                                <tr>
                                    <td valign="top" height="30"></td>
                                </tr>

                                <tr>
                                    <td valign="top">
                                        <table class="bordertable" width="46%">
                                            <?php  if($student['level'] == "NIVEL INICIAL") { ?>
                                            <thead>
                                                <tr style="background-color: #e6e6ed">
                                                    <th style="font-size: 22px; padding: 5px 5px; text-align:center">AUSENCIAS-TARDANZAS</th>
                                                    <th style="font-size: 22px; padding: 5px 5px; text-align:center"><?php echo $monthlist[$period["start_month"]]; ?>/<?php echo $monthlist[$period["end_month"]]; ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="font-size: 22px; text-align:left; padding: 5px 5px;">Presencias </td>
                                                    <td valign="top" style="font-size: 22px; text-align:left; padding-left: 15px;"></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="font-size: 22px; text-align:left; padding: 5px 5px;">Ausencias</td>
                                                    <td valign="top" style="font-size: 22px; text-align:left; padding-left: 15px;"></td>
                                                </tr>
                                            </tbody>
                                            <?php } else {?>
                                                <thead>
                                                <tr style="background-color: #e6e6ed">
                                                    <th style="font-size: 22px; padding: 5px 5px; text-align:center">AUSENCIAS-TARDANZAS</th>
                                                    <th style="font-size: 22px; padding: 5px 5px; text-align:center"><?php echo $monthlist[$period["start_month"]]; ?>/<?php echo $monthlist[$period["end_month"]]; ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td valign="top" style="font-size: 22px; text-align:left; padding: 5px 5px;">Ausencias Justificadas </td>
                                                    <td valign="top" style="font-size: 22px; text-align:left; padding-left: 15px;"></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="font-size: 22px; text-align:left; padding: 5px 5px;">Ausencias No Justificadas</td>
                                                    <td valign="top" style="font-size: 22px; text-align:left; padding-left: 15px;"></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="font-size: 22px; text-align:left; padding: 5px 5px;">Tardanzas</td>
                                                    <td valign="top" style="font-size: 22px; text-align:left; padding-left: 15px;"></td>
                                                </tr>
                                                </tbody>
                                            <?php }?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td valign="top" height="30"></td>
                    </tr>

                    <tr>
                        <td valign="top" style="font-weight: bold; font-size: 24px; text-align:left">
                            Observaciones: <br />
                        </td>

                    </tr>
                    <tr>
                        <td valign="top" width="100%">
                            <span style="width:100%; border-bottom: 1px solid black;"></span>
                        </td>
                    <tr>
                    <tr>
                        <td valign="top" width="100%">
                            <span style="width:100%; border-bottom: 1px solid black;"></span>
                        </td>
                    <tr>
                    <tr>
                        <td valign="top" width="100%">
                            <span style="width:100%; border-bottom: 1px solid black;"></span>
                        </td>
                    <tr>
                </table>
            </div>
            <div class="pagebreak"></div>
<?php
        }
    }
}
?>
