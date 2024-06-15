<style type="text/css">
    @page {
        size: 11.0in 8.5in;
        margin: 0.05in;
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
    .title-color {
        color: <?php 
            if (strpos($student['class'], '1er') !== false) echo '#f7941d';
            else if (strpos($student['class'], '2do') !== false) echo '#1075bb';
            else if (strpos($student['class'], '3er') !== false) echo '#1f9186';
            else if (strpos($student['class'], '4to') !== false) echo '#f183aa';
            else if (strpos($student['class'], '5to') !== false) echo '#ae9d40';
            else if (strpos($student['class'], '6to') !== false) echo '#7b3500';
            else echo '#f183aa';
            ?> !important;
    }
    .title-bgcolor {
        background-color: <?php 
            if (strpos($student['class'], '1er') !== false) echo '#f7941d';
            else if (strpos($student['class'], '2do') !== false) echo '#1075bb';
            else if (strpos($student['class'], '3er') !== false) echo '#1f9186';
            else if (strpos($student['class'], '4to') !== false) echo '#f183aa';
            else if (strpos($student['class'], '5to') !== false) echo '#ae9d40';
            else if (strpos($student['class'], '6to') !== false) echo '#7b3500';
            else echo '#f183aa';
            ?> !important;
    }
    .table-color {
        background-color: <?php 
            if (strpos($student['class'], '1er') !== false) echo '#fce1cb';
            else if (strpos($student['class'], '2do') !== false) echo '#b9e6fb';
            else if (strpos($student['class'], '3er') !== false) echo '#8ad3d8';
            else if (strpos($student['class'], '4to') !== false) echo '#facad9';
            else if (strpos($student['class'], '5to') !== false) echo '#fef3bc';
            else if (strpos($student['class'], '6to') !== false) echo '#fcc39d';
            else echo '#facad9';
            ?> !important;
        color: black;
    }
    .table-light-color {
        background-color: <?php 
            if (strpos($student['class'], '1er') !== false) echo '#faf0e8';
            else if (strpos($student['class'], '2do') !== false) echo '#dcf2fd';
            else if (strpos($student['class'], '3er') !== false) echo '#c3e7eb';
            else if (strpos($student['class'], '4to') !== false) echo '#fbdfe9';
            else if (strpos($student['class'], '5to') !== false) echo '#fef9dd';
            else if (strpos($student['class'], '6to') !== false) echo '#fce6d3';
            else echo '#fbdfe9';
            ?> !important;
        color: black;
    }
</style>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<style>
    .kanit-thin {
    font-family: "Kanit", sans-serif;
    font-weight: 100;
    font-style: normal;
    }

    .kanit-extralight {
    font-family: "Kanit", sans-serif;
    font-weight: 200;
    font-style: normal;
    }

    .kanit-light {
    font-family: "Kanit", sans-serif;
    font-weight: 300;
    font-style: normal;
    }

    .kanit-regular {
    font-family: "Kanit", sans-serif;
    font-weight: 400;
    font-style: normal;
    }

    .kanit-medium {
    font-family: "Kanit", sans-serif;
    font-weight: 500;
    font-style: normal;
    }

    .kanit-semibold {
    font-family: "Kanit", sans-serif;
    font-weight: 600;
    font-style: normal;
    }

    .kanit-bold {
    font-family: "Kanit", sans-serif;
    font-weight: 700;
    font-style: normal;
    }

    .kanit-extrabold {
    font-family: "Kanit", sans-serif;
    font-weight: 800;
    font-style: normal;
    }

    .kanit-black {
    font-family: "Kanit", sans-serif;
    font-weight: 900;
    font-style: normal;
    }

    .kanit-thin-italic {
    font-family: "Kanit", sans-serif;
    font-weight: 100;
    font-style: italic;
    }

    .kanit-extralight-italic {
    font-family: "Kanit", sans-serif;
    font-weight: 200;
    font-style: italic;
    }

    .kanit-light-italic {
    font-family: "Kanit", sans-serif;
    font-weight: 300;
    font-style: italic;
    }

    .kanit-regular-italic {
    font-family: "Kanit", sans-serif;
    font-weight: 400;
    font-style: italic;
    }

    .kanit-medium-italic {
    font-family: "Kanit", sans-serif;
    font-weight: 500;
    font-style: italic;
    }

    .kanit-semibold-italic {
    font-family: "Kanit", sans-serif;
    font-weight: 600;
    font-style: italic;
    }

    .kanit-bold-italic {
    font-family: "Kanit", sans-serif;
    font-weight: 700;
    font-style: italic;
    }

    .kanit-extrabold-italic {
    font-family: "Kanit", sans-serif;
    font-weight: 800;
    font-style: italic;
    }

    .kanit-black-italic {
    font-family: "Kanit", sans-serif;
    font-weight: 900;
    font-style: italic;
    }

</style>
<style>
    #print-page {
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;
    gap: 20px;
    height: 100%;
    }
    table {
        margin: 0px !important;
        font-size: 12px !important;
    }
    .table>:not(caption)>*>* {
        padding: 0.3rem 0.2rem !important;
    }
    #print-page> div {
    width: 50%;
    height: 100%;
    }
    #left-table {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    height: 100%;
    }
    #left-table> div {
    width: 100%;
    }
    #FIRMA {
    width: 100%;
    }
    #print-page table thead tr th {
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 5px;
    }
    table {
        border-color: black !important;
    }
    #print-page table {
        border-width: 1px;
        border-style: solid;
        border-color: black;
    }
    #Observaciones table thead tr th {
    justify-content: start;
    padding-left: 15px;
    }
    #firma-table {
    width: 100%;
    border-spacing: 0px;
    }
    #Observaciones-table {
    width: 100%;
    border-spacing: 0px;
    }
    #print-page table tbody tr td {
    border-color: black;
    /* border-width: 2px; */
    border-style: solid;
    border-top: none;
    padding: 10px;
    display: flex;
    flex-direction: column;
    }

    #print-page #Observaciones-table tbody tr td {
        gap: 20px;
    }

    .underlined-field {
    min-height: 0px;
    }
    .underlined-field span{
    display: flex;
    border-bottom-color: black;
    border-bottom-width: 1px;
    border-bottom-style: solid;
    }
    #right-side {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    justify-content: space-between;
    height: 100%;
    }
    .right-info {
        padding: 20px;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 4px;
        font-size: 14px;
    }
    #logo-table {
        display: flex;
        /* border: 1px solid black; */
        font-size: 12px;
        padding: 3px;
    }
    .flex {
        display: flex;
    }
    .nowrap {
    text-wrap: nowrap;
    }
    .fullwidth {
        width: 100%;
    }
    .bottom-border {
        border-bottom: solid black 1px
    }
    .text-center {
        text-align: center;
    }
    #print-page #Observaciones-table1 thead tr th {
        display: table-cell;
        border: solid black 1px;
        text-align: center;
    }

    #print-page #Observaciones-table1 tbody tr td {
        display: table-cell;
        width: calc(100% / 3);
        border: solid black 1px;
    }

    #print-page #Observaciones-table1, #print-page #Observaciones-table1 th, #print-page #Observaciones-table1 td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
    }


    #print-page #Observaciones-table1 {
        width: 100%;
        border-collapse: collapse;
    }

    #print-page #Observaciones-table1 thead tr, #print-page #Observaciones-table1 thead th {
        width: 100%;
    }
    .grade-table {
        padding: 0.2rem 0.2rem !important;
        line-height: 1;
    }
</style>
<div id="print-page">
    <div id="left-table">
        <div id="FIRMA">
            <table id="firma-table">
            <thead>
                <tr>
                <th class="kanit-medium title-bgcolor">FIRMA DEL PADRE, MADRE O TUTOR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>
                    <div class="kanit-regular" style="font-weight: bold;">Períodos de Reportes de Calificaciones</div>
                    <div class="kanit-light flex"><span class="nowrap">Ago-Sept-Oct</span><span class="flex fullwidth bottom-border"></span></div>
                    <div class="kanit-light flex"><span class="nowrap">Nov-Dic-Ene</span> <span class="flex fullwidth bottom-border"></span></div>
                    <div class="kanit-light flex"><span class="nowrap">Feb-Mar</span> <span class="flex fullwidth bottom-border"></span></div>
                    <div class="kanit-light flex"><span class="nowrap">Abr-May-Jun</span> <span class="flex fullwidth bottom-border"></span></div>
                </td>
                </tr>
            </tbody>
            </table>
        </div>
        <?php if ($class_id < 16) {?> 
        <div id="Observaciones">
            <table id="Observaciones-table">
            <thead>
                <tr>
                <th class="kanit-medium table-color" style="color: black;">Información sobre el nivel de avance de los aprendizajes y los apoyos
                    que necesita para la mejora de sus aprendizajes. </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td style="padding-top: 20px;">
                    <div class="underlined-field kanit-light"><span></span></div>
                    <div class="underlined-field kanit-light"><span></span></div>
                    <div class="underlined-field kanit-light"><span></span></div>
                    <div class="underlined-field kanit-light"><span></span></div>
                    <div class="underlined-field kanit-light"><span></span></div>
                    <div class="underlined-field kanit-light"><span></span></div>
                    <div class="underlined-field kanit-light"><span></span></div>
                    <div class="underlined-field kanit-light"><span></span></div>
                    <div class="underlined-field kanit-light"><span></span></div>
                    <div class="underlined-field kanit-light"><span></span></div>
                    <div class="underlined-field kanit-light"><span></span></div>
                    <div class="underlined-field kanit-light"><span></span></div>
                    <div class="underlined-field kanit-light"><span></span></div>
                    <div class="underlined-field kanit-light"><span></span></div>
                </td>
                </tr>
            </tbody>
            </table>
        </div>
        <?php } else { ?>
        <div>
            <table id="Observaciones-table1">
                <thead>
                    <tr>
                        <th class="kanit-medium table-color" style="color: black;" colspan="3">SITUACIÓN DEL/DE LA ESTUDIANTE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="kanit-light">
                            Promovido/a
                        </td>
                        <td class="kanit-light">
                            Aplazado/a
                        </td>
                        <td class="kanit-light">
                            Repitente
                        </td>
                    </tr>
                    <tr style="height: 50px;">
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="Observaciones">
            <table id="Observaciones-table">
                <thead>
                    <tr>
                    <th class="kanit-medium table-color" style="color: black;">Observaciones: </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td style="padding-top: 20px;">
                        <div class="underlined-field kanit-light"><span></span></div>
                        <div class="underlined-field kanit-light"><span></span></div>
                        <div class="underlined-field kanit-light"><span></span></div>
                        <div class="underlined-field kanit-light"><span></span></div>
                        <div class="underlined-field kanit-light"><span></span></div>
                        <div class="underlined-field kanit-light"><span></span></div>
                        <div class="underlined-field kanit-light"><span></span></div>
                        <div class="underlined-field kanit-light"><span></span></div>
                        <div class="underlined-field kanit-light"><span></span></div>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php } ?>
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <div id="logo-table">
                <img src="<?php echo base_url('uploads/school_content/logo/rect-logo.png'); ?>" style="width: 80px;">
                <div style="padding: 2px;">
                    <div style="font-size: 18px;"><b>Escuela Parroquial Santa Rita</b></div>
                    <div style="font-size: 16px;"><b>Orden Agustinos Recoletos</b></div>
                    <div>Lema del año: “¿Aspiras a lo grande? Comienza por lo pequeño” <br> Valor del año: Interioridad </div>
                </div>
            </div>
            <div id="logo-table" style="justify-content: space-between;">
                <div class="text-center">
                    <div style="width: 95%; height: 30px; border-bottom: 1px solid black;"></div>
                    <div class="kanit-semibold" style="font-size: 11px;"><?php echo $school_director; ?></div>
                    <div>Director General</div>
                </div>
                <div class="text-center">
                    <div style="width: 95%; height: 30px; border-bottom: 1px solid black;"></div>
                    <div class="kanit-semibold" style="font-size: 11px;"><?php echo $Coordinadora; ?></div>
                    <div>Coordinadora Nivel Primario</div>
                </div>
                <div class="text-center">
                    <div style="width: 95%; height: 30px; border-bottom: 1px solid black;"></div>
                    <div class="kanit-semibold" style="font-size: 11px;"><?= $class_teacher ?></div>
                    <div>Maestro Guía</div>
                </div>
            </div>
        </div>
    </div>
    <div id="right-side">
        <img src="<?php echo base_url('uploads/school_content/logo/logo.png'); ?>" style="width: 25%;">
        <div class="kanit-light" style="text-align: center; font-size: 12px;">Viceministro de Servicios Técnicos y Pedagógicos <br> Dirección General de Educación Secundaria</div>
        <!-- <div class="kanit-medium title-color" style="font-size: 24px;">INFORME DE APRENDIZAJE</div> -->
        <? $student['class'] ?>
        <img src="<?php echo base_url('uploads/school_content/logo/primarylogo/' . $student['class']) . '.png';?>" style="width: 55%;">
        <div class="kanit-bold">
            <b>Año Escolar <?php echo $session ?></b>
        </div>
        <div class="kanit-light right-info">
            <div style="display: flex;justify-content: space-between;">
                <span style="width: 50%; display: flex;justify-content: space-between;"><span style="white-space: nowrap; padding-right: 10px;">Sección: </span><span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;"><?= $student['section'] ?></span> </span>
                <span style="width: 50%; display: flex;justify-content: space-between;"><span style="white-space: nowrap; padding-right: 10px;">Número de orden: </span><span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;"><?php echo $order_number ?></span> </span>
            </div>
            <div style="display: flex;justify-content: space-between;">
                <span style="white-space: nowrap; padding-right: 10px;">Nombre (s): </span>
                <span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;">
                    <?php echo $student['firstname']; ?>
                </span>
            </div>
            <div style="display: flex;justify-content: space-between;">
                <span style="white-space: nowrap; padding-right: 10px;">Apellido (s): </span>
                <span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;">
                    <?php echo $student['lastname']; ?>
                </span>
            </div>
            <div style="display: flex;justify-content: space-between;">
                <span style="white-space: nowrap; padding-right: 10px;">ID estudiante (Número de identificación SIGERD): </span>
                <span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;">
                    <?php echo $student['roll_no']; ?>
                </span>
            </div>
            <div style="display: flex;justify-content: space-between;">
                <span style="white-space: nowrap; padding-right: 10px;">Docente: </span>
                <span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;">
                    <?= $class_teacher ?>
                </span>
            </div>
            <div style="display: flex;justify-content: space-between;">
                <span style="white-space: nowrap; padding-right: 10px;">Centro educativo: </span>
                <span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;">
                    Escuela Parroquial Santa Rita
                </span>
            </div>
            <div style="display: flex;justify-content: space-between;">
                <span style="white-space: nowrap; padding-right: 10px;">Código del centro: </span>
                <span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;">
                    21002717
                </span>
            </div>
            <div style="display: flex;justify-content: space-between;">
                <span style="white-space: nowrap; padding-right: 10px;">Tanda: </span>
                <span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;">
                    Matutina
                </span>
            </div>
            <div style="display: flex;justify-content: space-between;">
                <span style="white-space: nowrap; padding-right: 10px;">Teléfono del centro: </span>
                <span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;">
                    809-528-3552
                </span>
            </div>
            <div style="display: flex;justify-content: space-between;">
                <span style="white-space: nowrap; padding-right: 10px;">Distrito educativo: </span>
                <span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;">
                    San Cristóbal 04-02
                </span>
            </div>
            <div style="display: flex;justify-content: space-between;">
                <span style="white-space: nowrap; padding-right: 10px;">Regional de educación: </span>
                <span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;">
                    San Cristóbal, Norte 04
                </span>
            </div>
            <div style="display: flex;justify-content: space-between;">
                <span style="white-space: nowrap; padding-right: 10px;">Provincia: </span>
                <span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;">
                    San Cristóbal
                </span>
            </div>
            <div style="display: flex;justify-content: space-between;">
                <span style="white-space: nowrap; padding-right: 10px;">Municipio: </span>
                <span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;">
                    San Cristóbal
                </span>
            </div>
        </div>
    </div>
</div>
<style>
    #detail-page {
    padding: 10px;
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 10px;
    height: 100%;
    justify-content: space-between;
    }
    .vertical-lr {
    writing-mode: vertical-lr;
    }

    .rotated {
    transform: rotate(180deg);
    }
    .pink {
    background-color: #f3a6c0 !important;
    }

    .lightpink {
    background-color: #fad9e0 !important;
    }
    #student-detail {
    display: flex;
    align-items: end;
    }
    .nowrap {
    white-space: nowrap;
    }
    .CALIFICACIONES {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 5px;
    width: 100%;
    background-color: #00a09a;
    color: white;
    font-size: 14px;
    }
    .resumen-table thead tr th {
    text-align: center;
    }
    .SITUACION {
    display: flex; 
    gap: 10px; 
    width: 70%;
    flex-direction: column;
    justify-content: space-between;
    }
    .SITUACION *{
    line-height: 1.5;
    }
    .situacion-title {
    display: flex;
    align-items: center;
    width: 100%;
    justify-content: space-between;
    margin-top: 20px;
    }
    .table-hover thead tr th {
        text-align: center;
        align-content: center;
    }
    .table-hover tbody tr td {
        text-align: center;
        align-content: center;
    }
    .right-border {
        border-right: solid black 2px !important;
    }
    .left-border {
        border-left: solid black 2px !important;
    }
    .grade-table thead tr th {
        font-size: 10px !important;
    }
</style>
<div class="pagebreak"></div>
<div id="detail-page">
    <div class="kanit-medium CALIFICACIONES title-bgcolor"> DESEMPEÑO INDIVIDUAL DEL/LA ESTUDIANTE </div>
    <div>
        <table class="table table-bordered table-hover grade-table" style="font-size: 10px;">
            <thead>
                <?php if ($class_id > 15) {?>
                <tr>
                    <th class="subjectlabelth table-color right-border" colspan="2" rowspan="1">COMPETENCIAS FUNDAMENTALES</th>
                    <th class="table-color right-border" colspan="8" rowspan="1">Comunicativa</th>
                    <th class="table-color right-border" colspan="8" rowspan="1">• Pensamiento Lógico, Creativo y Crítico • Resolución de Problemas • Científica y Tecnológica</th>
                    <th class="table-color right-border" colspan="8" rowspan="1">• Ética y Ciudadana • Desarrollo Personal y Espiritual • Ambiental y de la Salud</th>
                    <th class="table-color right-border" colspan="3" rowspan="1"> Calificación final por competencia</th>
                    <th class="table-color vertical-lr rotated right-border left-border" colspan="1" rowspan="2"> final del área <br> Calificación </th>
                    <th class="table-color vertical-lr rotated left-border" colspan="1" rowspan="2">final recuperación <br>Calificación </th>
                    <th class="table-color vertical-lr rotated left-border" colspan="1" rowspan="2">especial recuperación <br>Calificación </th>
                </tr>
                <tr>
                    <th class="table-light-color subjectlabelth right-border" colspan="2" rowspan="1">PERÍODOS</th>
                    <th class="table-light-color">P1</th>
                    <th class="table-light-color">RP1</th>
                    <th class="table-light-color">P2</th>
                    <th class="table-light-color">RP2</th>
                    <th class="table-light-color">P3</th>
                    <th class="table-light-color">RP3</th>
                    <th class="table-light-color">P4</th>
                    <th class="table-light-color right-border">RP4</th>
                    <th class="table-light-color">P1</th>
                    <th class="table-light-color">RP1</th>
                    <th class="table-light-color">P2</th>
                    <th class="table-light-color">RP2</th>
                    <th class="table-light-color">P3</th>
                    <th class="table-light-color">RP3</th>
                    <th class="table-light-color">P4</th>
                    <th class="table-light-color right-border">RP4</th>
                    <th class="table-light-color">P1</th>
                    <th class="table-light-color">RP1</th>
                    <th class="table-light-color">P2</th>
                    <th class="table-light-color">RP2</th>
                    <th class="table-light-color">P3</th>
                    <th class="table-light-color">RP3</th>
                    <th class="table-light-color">P4</th>
                    <th class="table-light-color right-border">RP4</th>
                    <th class="table-light-color">C1</th>
                    <th class="table-light-color">C2</th>
                    <th class="table-light-color right-border">C3</th>
                </tr>
                <?php } else {?>
                <tr>
                    <th class="subjectlabelth table-color right-border" colspan="2" rowspan="1">COMPETENCIAS FUNDAMENTALES</th>
                    <th class="table-color right-border" colspan="4" rowspan="1">Comunicativa</th>
                    <th class="table-color right-border" colspan="4" rowspan="1">• Pensamiento Lógico, Creativo y Crítico • Resolución de Problemas • Científica y Tecnológica</th>
                    <th class="table-color right-border" colspan="4" rowspan="1">• Ética y Ciudadana • Desarrollo Personal y Espiritual • Ambiental y de la Salud</th>
                    <th class="table-color right-border" colspan="3" rowspan="1"> Calificación final por competencia</th>
                    <th class="table-color vertical-lr rotated right-border" colspan="1" rowspan="2"> final del área <br> Calificación </th>
                    <th class="table-color vertical-lr rotated" colspan="1" rowspan="2">final <br> recuperación <br>Calificación </th>
                </tr>
                <tr>
                    <th class="table-light-color subjectlabelth right-border" colspan="2" rowspan="1">PERÍODOS</th>
                    <th class="table-light-color">P1</th>
                    <th class="table-light-color">P2</th>
                    <th class="table-light-color">P3</th>
                    <th class="table-light-color right-border">P4</th>
                    <th class="table-light-color">P1</th>
                    <th class="table-light-color">P2</th>
                    <th class="table-light-color">P3</th>
                    <th class="table-light-color right-border">P4</th>
                    <th class="table-light-color">P1</th>
                    <th class="table-light-color">P2</th>
                    <th class="table-light-color">P3</th>
                    <th class="table-light-color right-border">P4</th>
                    <th class="table-light-color">C1</th>
                    <th class="table-light-color">C2</th>
                    <th class="table-light-color right-border">C3</th>
                </tr>
                <?php } ?>
            </thead>
            <tbody>
                <?php foreach ($grading_subject_results as $index => $result) { ?>
                    <tr>
                    <?php if ($index == 0) { ?> <td rowspan="<?php echo count($grading_subject_results); ?>" class="kanit-semibold vertical-lr rotated table-color" style="text-align: center;">ÁREAS CURRICULARES</td> <?php } ?>
                        <td class="kanit-semibold" style="padding-left: 4px; padding-right: 4px; text-align: left; line-height: 1;"><?php echo $result['subject'] ?></td>
                        <?php for ($i = 0; $i < count($periodList) * 3 + 3; $i++) { ?>
                            <td class="<?php if ($i % count($periodList) == 0) echo 'left-border'; ?>"><?php echo $result['period_results'][$i] ? $result['period_results'][$i] : "" ?></td>
                            <?php if ($class_id > 15 && $i < count($periodList) * 3) { ?>
                                <td><?php echo $result['period_resultsRP'][$i] ? $result['period_resultsRP'][$i] : "" ?></td>
                            <?php } ?>
                        <?php } ?>
                            <td class="rboder left-border"><?php echo $result['CF'] ? $result['CF'] : ""; ?></td>
                            <td class="rboder left-border"> </td>
                            <?php if ($class_id > 15) { ?> <td class="rboder left-border"> </td><?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <table class="table table-bordered table-hover resumen-table" style="text-align: center; height: 100%; font-size: 11px;">
        <thead>
        </thead>
        <tbody>
            <tr>
            <td class="kanit-semibold table-color vertical-lr rotated" rowspan="5">OBSERVACIONES</td>
            </tr>
            <tr>
            <td class="kanit-semibold table-light-color">P1</td>
            <td style="width: 90%;"></td>
            </tr>
            <tr>
            <td class="kanit-semibold table-light-color">P2</td>
            <td></td>
            </tr>
            <tr>
            <td class="kanit-semibold table-light-color">P3</td>
            <td></td>
            </tr>
            <tr>
            <td class="kanit-semibold table-light-color">P4</td>
            <td></td>
            </tr>
        </tbody>
    </table>
    <div style="display: flex; justify-content: space-between; gap: 10px;">
        <div>
            <table class="table table-bordered table-hover resumen-table" style="text-align: center; height: 100%; font-size: 11px;">
                <thead>
                    <tr>
                    <th class="table-color" colspan="5">RESUMEN DE ASISTENCIA DEL/LA ESTUDIANTE</th>
                    </tr>
                    <tr>
                    <th class="table-light-color " rowspan="2">Períodos</th>
                    <th class=" " rowspan="2">Asistencia</th>
                    <th class=""  rowspan="2">Ausencia</th>
                    <th colspan="2">% de Anual</th>
                    </tr>
                    <tr>
                    <th>Asistencia</th>
                    <th>Ausencia</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td class="kanit-semibold table-light-color">P1</td>
                    <td></td>
                    <td></td>
                    <td rowspan="4"></td>
                    <td rowspan="4"></td>
                    </tr>
                    <tr>
                    <td class="kanit-semibold table-light-color">P2</td>
                    <td></td>
                    <td></td>
                    </tr>
                    <tr>
                    <td class="kanit-semibold table-light-color">P3</td>
                    <td></td>
                    <td></td>
                    </tr>
                    <tr>
                    <td class="kanit-semibold table-light-color">P4</td>
                    <td></td>
                    <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <table class="table table-bordered table-hover" style="height: 100%; font-size: 11px;">
                <thead>
                    <tr>
                    <th class="table-color">LEYENDA:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td style="display: flex; gap: 10px; padding: 10px; height: 100%;">
                        <div>
                        <div>(P1)</div>
                        <div>(P2)</div>
                        <div>(P3)</div>
                        <div>(P4)</div>
                        <div style="height: 10px;"></div>
                        <div>(C1)</div>
                        <div>(C2)</div>
                        <div>(C3)</div>
                        </div>
                        <div>
                        <div>Período 1</div>
                        <div>Período 2</div>
                        <div>Período 3</div>
                        <div>Período 4</div>
                        <div style="height: 10px;"></div>
                        <div style="white-space: nowrap;">Competencia 1</div>
                        <div style="white-space: nowrap;">Competencia 2</div>
                        <div style="white-space: nowrap;">Competencia 3</div>
                        </div>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="kanit-regular SITUACION">
            <table class="table table-bordered table-hover resumen-table" style="text-align: left; height: 100%; font-size: 11px;">
                <thead>
                    <tr>
                    <th class="table-color">Escala numérica</th>
                    <th class="table-color">Descripción</th>
                    </tr>
                </thead>
                <tbody style="font-size: 10px;">
                    <tr>
                    <td style="text-align: center; height: 100%;">89-100</td>
                    <td style="text-align: left;">Evidencia que el estudiante ha alcanzado un desempeño <b>destacado</b> con relación a los aspectos
                        evaluados de las competencias de cada área, durante los períodos y al finalizar el año escolar.</td>
                    </tr>
                    <tr>
                    <td style="text-align: center; height: 100%;">77-88</td>
                    <td style="text-align: left;">Evidencia que el estudiante ha <b>logrado</b>, en general, los aprendizajes esperados con relación a los
                        aspectos evaluados de las competencias de cada área, durante los períodos y al finalizar el año escolar.</td>
                    </tr>
                    <tr>
                    <td style="text-align: center; height: 100%;">65-76 </td>
                    <td style="text-align: left;">Evidencia que el estudiante aún se encuentra <b>en proceso</b> con relación a los aspectos evaluados de las
                        competencias de cada área, durante los períodos y al finalizar el año escolar, mostrando un logro muy
                        básico.</td>
                    </tr>
                    <tr>
                    <td style="text-align: center; height: 100%;">Menos de 65</td>
                    <td style="text-align: left;">Evidencia que el estudiante ha alcanzado un desempeño <b>insuficiente</b> con relación a los aspectos
                        evaluados de las competencias de cada área, durante los períodos y al finalizar el año escolar.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="pagebreak"></div>