<style type="text/css">
    @page {
        size: 11.0in 8.5in;
        margin: 0;
    }

    @media print {
        .pagebreak {
            page-break-before: always;
        }

        /* page-break-after works, as well */
    }

    @media print {
        #gradingResultTB th,
        .final_condition {
            !background-color: #e6e6ed !important;
            -webkit-print-color-adjust: exact;
        }

    }



    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .front-container {
        z-index: 2;
        margin: 0 auto;
        padding: 80px 40px 50px 40px;
    }

    .report-container {
        width: 11in;
        height: 8.5in;
        margin: 0 auto;
        padding: 60px 30px 50px 30px;
        position: relative;
    }

    #gradingResultTB th {
        text-align: center;
        vertical-align: middle;
        font-weight: 300;
        font-size: 13px;
    }

    #gradingResultTB th,
    #gradingResultTB td {
        border: 1px solid black !important;
        border-collapse: collapse !important;
    }

    #gradingResultTB td {
        padding-left: 3px;
        font-size: 16px;
        vertical-align: bottom;
        text-align:center;
        height:24px;
    }

    #gradingResultTB .rboder {
        border-right: 2px solid black !important;
    }

    .explain_field {
        width: 100%;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    .explain_field td {
        width: 33%;
        padding-left: 4px;
        padding-right: 4px;
    }

    .border-right-2 {
        border-right: 1px solid;
        text-align: right;
    }

    .border-left-2 {
        border-left: 1px solid;
    }

    .pb-2 {
        padding-bottom: 8px;
    }
</style>

<div class="front-container">

    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="50%" valign="top" style="padding-top: 30px; padding-right:80px; font-style: oblique;">
                <div style="text-align:center; font-size:22px; font-weight:800; font-family: 'Arial Black',arial-black;">VISIÓN</div>
                <div style="text-align: justify; text-justify: inter-word; font-size: 17px; margin-bottom:40px;">
                    Educamos decididos a participar con capacidad, libertad y responsabilidad en la configuración de una nueva sociedad compuesta por personas más felices, fraternas y solidarias.
                </div>
                <div style="text-align:center; font-size:22px; font-weight:0; font-family: 'Arial black',arial-black;">MISIÓN</div>
                <div style="text-align: justify; text-justify: inter-word; font-size: 17px; margin-bottom:60px;">
                    Somos un centro educativo católico y agustiniano que forma personas de manera integral para impactar positivamente en la sociedad
                </div>
                <div style="text-align:center; font-size:22px; font-weight:0; font-family: 'Arial black',arial-black;">VALORES</div>
                <div style="text-align: justify; text-justify: inter-word; font-size: 17px; margin-bottom:5px;">
                    • Interioridad  </div>
                <div style="text-align: justify; text-justify: inter-word; font-size: 17px; margin-bottom:5px;">
                    • Solidaridad  </div>
                <div style="text-align: justify; text-justify: inter-word; font-size: 17px; margin-bottom:5px;">
                    • Libertad  </div>
                <div style="text-align: justify; text-justify: inter-word; font-size: 17px; margin-bottom:5px;">
                    • Verdad  </div>
                <div style="text-align: justify; text-justify: inter-word; font-size: 17px; margin-bottom:5px;">
                    • Responsabilidad  </div>
                <div style="text-align: justify; text-justify: inter-word; font-size: 17px; margin-bottom:40px;">
                    • Amistad  </div>


</div>
<div style="font-size: 17px; margin-bottom:40px;">
    <strong>Salida Optativa del centro:</strong> Humanidades y Ciencias Sociales
</div>
<div style="font-size: 16px;">
    <strong>"Considero que soy uno de esos que escriben mientras aprenden y aprenden mientras escriben".</strong> <span style="font-style:normal">San Agustín.</span>
</div>
</td>
<td width="50%" valign="top" style="padding-left:50px">
    <!-- <div style="text-align:center; font-size:16px; margin-bottom:20px;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
          <strong style="font-size: 22px;">ESCUELA PARROQUIAL SANTA RITA</strong>
          <p>AGUSTINOS RECOLETOS</p>
      </div>-->
    <div style="text-align:center; margin-bottom:70px">
        <img src="<?php echo base_url('uploads/school_content/logo/' . $sch_setting->image); ?>" width="260" height="260">
    </div>

    <div style="text-align:center; font-size:22px; margin-bottom:50px;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
        <strong>REPORTE DE CALIFICACIONES<br>
            <?php if (trim($student['class'])[0] * 1 > 3) {
                echo 'SEGUNDO';
            } else {
                echo 'PRIMER';
            } ?> CICLO NIVEL SECUNDARIO<br>
            <?= $student['class'] ?>. Sección <?= $student['section'] ?><br>
            <br>
            Año Escolar <?php echo $session ?>
        </strong>
    </div>
    <div style="font-size: 17px;">
        <strong>Nombres y Apellidos: </strong><?php echo $this->customlib->getFullName($student['firstname'], $student['middlename'], $student['lastname'], $sch_setting->middlename, $sch_setting->lastname); ?><br>
        <strong>No. de Orden:</strong> <?php echo $order_number ?><br>
        <strong>Matrícula:</strong> <?php echo $student['admission_no'] ?><br>
        <strong>Curso y Sección:</strong> <?= $student['class'] ?>. Sección <?= $student['section'] ?><br>
        <strong>Dirección del centro:</strong> Av. Libertad No. 31, San Cristóbal.<br>
        <strong>Distrito Educativo:</strong> 02 de San Cristóbal Norte<br>
        <strong>Dirección Regional de Educación:</strong> 04 de San Cristóbal<br>
    </div>
</td>
</tr>
</table>
</div>
<div class="pagebreak"></div>
<div class="report-container">
    <div class="table-responsive" id="gradingResultTB">
        <div style="text-transform: uppercase; text-align:center; font-size:24px; margin-bottom:10px; font-weight:bold;font-family: 'Arial Narrow', arial-narrow;">CALIFICACIONES DE RENDIMIENTO DE <?= $student['class'] ?>. Sección <?= $student['section'] ?></div>
        <strong>No.&nbsp;&nbsp;&nbsp;&nbsp;</strong> <?php echo $order_number ?><br>
        <strong>Alumno:</strong><?php echo $this->customlib->getFullName($student['firstname'], $student['middlename'], $student['lastname'], $sch_setting->middlename, $sch_setting->lastname); ?>
        <div style="width:100%; border:1px solid; padding:2px; margin-top:6px;">
            <table style="width:100%; border-collapse: collapse;font-family: 'Arial Narrow', arial-narrow;">
                <thead>
                <tr>
                    <th rowspan="3" style="min-width:200px; font-size:20px">ASIGNATURAS</th>
                    <th colspan="<?php echo count($periodList) + 1 ?>" class="rboder">CALIFICACIONES DEL AÑO ESCOLAR</th>
                    <th rowspan="3">% A.A</th>
                    <th colspan="4" class="rboder">CALIFICACIÓN COMPLETIVA</th>
                    <th colspan="4" class="rboder">CALIFICACIÓN EXTRAORDINARIA</th>
                    <th colspan="2">SITUACIÓN FINAL</th>
                    <th colspan="2">C.A.P.</th>
                </tr>
                <tr>
                    <th colspan="<?php echo count($periodList) ?>">Calificaciones Parciales</th>
                    <th rowspan="2" class="rboder">C.F.</th>
                    <th rowspan="2">50% P.C.P.</th>
                    <th rowspan="2">C.P.C.</th>
                    <th rowspan="2">50% C.P.C.</th>
                    <th rowspan="2" class="rboder">C.C.</th>
                    <th rowspan="2">30% P.C.P.</th>
                    <th rowspan="2">C.P.EX.</th>
                    <th rowspan="2">70% C.P.EX.</th>
                    <th rowspan="2" class="rboder">C.EX.</th>
                    <th rowspan="2">A</th>
                    <th rowspan="2">R</th>
                    <th colspan="2">OPORTUNIDAD</th>
                </tr>
                <tr>
                    <?php for ($i = 0; $i < count($periodList); $i++) { ?>
                        <th><?= "P".substr($periodList[$i]['label'],0,1); ?></th>
                    <?php } ?>
                    <th>1</th>
                    <th>2</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($grading_subject_results as $result) { ?>
                    <tr>
                        <td style="padding-left: 4px; padding-right: 4px;font-weight: 300; text-align: left;"><?php echo $result['subject'] ?></td>
                        <?php for ($i = 0; $i < count($periodList); $i++) { ?>
                            <td><?php echo $result['period_results'][$i] ?></td>
                        <?php } ?>
                        <td class="rboder"><?php echo $result['CF'] ?></td>
                        <td><?php echo $result['AA'] ?></td>
                        <td><?php echo $result['50PCP'] ?></td>
                        <td><?php echo $result['CPC'] ?></td>
                        <td><?php echo $result['50CPC'] ?></td>
                        <td class="rboder"><?php echo $result['CC'] ?></td>
                        <td><?php echo $result['30PCP'] ?></td>
                        <td><?php echo $result['CPEX'] ?></td>
                        <td><?php echo $result['70CPEX'] ?></td>
                        <td class="rboder"><?php echo $result['CEX'] ?></td>
                        <td><?php echo $result['A'] ?></td>
                        <td><?php echo $result['R'] ?></td>
                        <td><?php echo $result['O1'] ?></td>
                        <td><?php echo $result['O2'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div style="padding-bottom:10px">
        <table class="explain_field" style="border-collapse: collapse; font-size:14px;">
            <tr>
                <td class="border-right-2"><strong>C.F.</strong> = Calificación Fina</td>
                <td><strong>%A.A.</strong> = Porciento Asistencia Anual</td>
                <td class="border-left-2"><strong>P.C.P.</strong>= Promedio de Calificaciones Parciales</td>
            </tr>
            <tr>
                <td class="border-right-2"><strong>C.P.C.</strong>= Calificación Prueba Completiva</td>
                <td colspan="2"><strong>C.C.</strong>= Calificación Completiva igual al 50% Promedio Calificación Parcial + 50% Prueba Completiva</td>
            </tr>
            <tr>
                <td class="border-right-2"><strong>C.P.EX.</strong>= Calificación Prueba Extraordinaria</td>
                <td colspan="2"><strong>C.EX.</strong>= Calificación Extraordinaria igual al 30% Promedio Calificación Parcial + 70% Prueba Extraordinaria</td>
            </tr>
            <tr>
                <td class="border-right-2 pb-2"><strong>A</strong>= Aprobado con 70 o más</td>
                <td class="pb-2"><strong>R</strong>= Reprobado con menos de 70 puntos</td>
                <td class="border-left-2 pb-2"><strong>C.A.P.</strong>= Calificación Asignaturas Pendientes</td>
            </tr>
        </table>
        <!-- <div style="font-weight: bolder; color:black; margin-bottom:15px;">
            <span class="final_condition" style="font-family: 'arial';padding:1px 20px 1px 10px; border:solid 1px black">CONDICIÓN FINAL:</span> &nbsp;&nbsp;&nbsp;&nbsp; Promovido &nbsp;<span style="padding:1px 15px; border:solid 1px black"></span> &nbsp;&nbsp;&nbsp;&nbsp; Reprobado &nbsp;<span style="padding:1px 15px; border:solid 1px black"></span> &nbsp;&nbsp;&nbsp;&nbsp; Promovido con asignaturas pendientes &nbsp;<span style="padding:1px 15px; border:solid 1px black"></span>
        </div> -->

        <div style="line-height:1.5; margin-bottom:20px; width:100%; position: relative">
            <strong>Observaciones:</strong> <br>
            <div style="width:100%; word-break: break-word;" class="observacioines_content"><?php echo $observation; ?></div>
            <div style="width:100%; height: 25px; position: absolute; top:45px; border :solid 1px black;border-left:0px; border-right:0px;"></div>
        </div>

        <table width="100%" style="text-align:center; font-weight:bold; position: absolute; bottom: 30px; left: 0px">
            <tr>
                <td width="33%">
                    <strong>_______________________________</strong><br>
                    <span style="font-family:'Palatino Linotype';font-style: oblique; font-size:14px"><?= $school_director ?></span><br>
                    Director General
                </td>
                <td width="33%">
                    <strong>_______________________________</strong><br>
                    <span style="font-family:'Palatino Linotype';font-style: oblique; font-size:14px"><?= $level_coordinator ?></span><br>
                    Coordinadora de Secundaria
                </td>
                <td width="33%">
                    <strong>_______________________________</strong><br>
                    <span style="font-family:'Palatino Linotype';font-style: oblique; font-size:14px"><?= $class_teacher ?></span><br>
                    Maestro Guía
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="pagebreak"> </div>