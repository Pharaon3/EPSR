<style type="text/css">
    @page {
        size: 14.0in 8.5in;
        margin: 0.01in;
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
        /* padding: 80px 40px 50px 40px; */
        height: 100vh;
    }

    .report-container {
        /* width: 11in; */
        /* height: 8.5in; */
        margin: 0 auto;
        /* padding: 60px 30px 50px 30px; */
        position: relative;
        padding: 0.2in;
        height: 100vh;
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
        text-align: center;
        height: 24px;
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

    .CALIFICACIONES {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1px;
        width: 100%;
        color: white;
        font-size: 14px;
    }

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

    body {
        margin: 0px;
    }

    #print-page {
        padding: 20px 40px;
        display: flex;
        justify-content: space-between;
        gap: 20px;
        height: 95vh;
    }

    #print-page>div {
        width: 50%;
        height: 95vh;
    }

    #left-table {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        height: 95vh;
    }

    #left-table>div {
        width: 100%;
    }

    #FIRMA {
        width: 100%;
    }

    #print-page table thead tr th {
        /* background-color: #1d70b7; */
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
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
        border-width: 2px;
        border-style: solid;
        border-top: none;
        padding: 10px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .underlined-field {
        min-height: 20px;
    }

    .underlined-field span {
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
        justify-content: space-around;
        height: 100%;
    }

    .right-info {
        padding: 20px;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 8px;
        font-size: 14px;
    }

    #detail-page {
        padding: 10px;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 10px;
        justify-content: space-around;
        height: 100%;
    }

    .vertical-lr {
        writing-mode: vertical-lr;
    }

    .rotated {
        transform: rotate(180deg);
    }

    .pink {
        background-color: <?php echo "#f3a6c0"; ?> !important;
    }

    .lightpink {
        background-color: #fad9e0 !important;
    }

    .title-bgcolor {
        background-color: <?php 
                if ($student['class'] == '1er Grado') echo '#006532';
                else if ($student['class'] == '2do Grado') echo '#1d70b7';
                else if ($student['class'] == '3er Grado') echo '#c84730';
                else if ($student['class'] == '4to. Grado') echo '#00a09a';
                else if ($student['class'] == '5to. Grado') echo '#e83879';
                else if ($student['class'] == '6to. Grado') echo '#1d3d71';
                else echo '#006532';
                 ?> !important;
    }

    .title-color {
        color: <?php 
                if ($student['class'] == '1er Grado') echo '#006532';
                else if ($student['class'] == '2do Grado') echo '#1d70b7';
                else if ($student['class'] == '3er Grado') echo '#c84730';
                else if ($student['class'] == '4to. Grado') echo '#00a09a';
                else if ($student['class'] == '5to. Grado') echo '#e83879';
                else if ($student['class'] == '6to. Grado') echo '#1d3d71';
                else echo '#006532';
                 ?> !important;
    }
    .table-color {
        background-color: <?php 
                if ($student['class'] == '1er Grado') echo '#d4e4ae';
                else if ($student['class'] == '2do Grado') echo '#89d1f5';
                else if ($student['class'] == '3er Grado') echo '#fac9a5';
                else if ($student['class'] == '4to. Grado') echo '#c1dcdb';
                else if ($student['class'] == '5to. Grado') echo '#f3a6c0';
                else if ($student['class'] == '6to. Grado') echo '#d8eefc';
                else echo '#d4e4ae';
                 ?> !important;
        color: black !important;
    }
    .table-light-color {
        background-color: <?php 
                if ($student['class'] == '1er Grado') echo '#eaf1d7';
                else if ($student['class'] == '2do Grado') echo '#d8eefc';
                else if ($student['class'] == '3er Grado') echo '#fdebdb';
                else if ($student['class'] == '4to. Grado') echo '#d0eaee';
                else if ($student['class'] == '5to. Grado') echo '#fad9e0';
                else if ($student['class'] == '6to. Grado') echo '#eaf6fe';
                else echo '#eaf1d7';
                 ?> !important;
    }
    .cyan {
        background-color: <?php echo "#89d1f5"; ?> !important;
        background-color: <?php 
                if ($student['class'] == '1er Grado') echo base_url('uploads/school_content/logo/1grado.png');
                else if ($student['class'] == '2do Grado') echo base_url('uploads/school_content/logo/2grado.png');
                else if ($student['class'] == '3er Grado') echo base_url('uploads/school_content/logo/3grado.png');
                else if ($student['class'] == '3er Grado') echo base_url('uploads/school_content/logo/3grado.png');
                else if ($student['class'] == '4to. Grado') echo base_url('uploads/school_content/logo/4grado.png');
                else if ($student['class'] == '5to. Grado') echo base_url('uploads/school_content/logo/5grado.png');
                else if ($student['class'] == '6to. Grado') echo base_url('uploads/school_content/logo/6grado.png');
                else echo base_url('uploads/school_content/logo/4grado.png');
                 ?> !important;
    }

    .lightcyan {
        background-color: <?php echo "#d8eefc"; ?> !important;
    }

    .blue {
        background-color: #1d70b7 !important;
    }

    #student-detail {
        display: flex;
        align-items: end;
    }

    .nowrap {
        white-space: nowrap;
    }

    .resumen-table thead tr th {
        text-align: center;
        align-content: center;
    }
    .resumen-table tbody tr td {
        text-align: center;
        align-content: center;
    }

    .SITUACION {
        display: flex;
        gap: 10px;
        width: 50%;
        flex-direction: column;
        justify-content: space-between;
    }

    .situacion-title {
        display: flex;
        align-items: center;
        width: 100%;
        justify-content: space-around;
    }
    .subjectlabelth {
        min-width: 200px;
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
    table {
        border-color: black !important;
    }
    .right-border {
        border-right: solid black 2px !important;
    }
    .left-border {
        border-left: solid black 2px !important;
    }
    /* #firma-table tbody tr td {
        border: none;
        border-top: solid black 2px;
    } */
    .grade-table thead tr th {
        text-align: center;
        align-content: center;
        padding: 0.2rem 0.2rem !important;
        /* line-height: 1; */
    }
    .grade-table tbody tr td {
        padding: 0.2rem 0.2rem !important;
    }
    .condicion-table thead tr th {
        padding: 0.2rem 0.2rem !important;
    }
    .condicion-table tbody tr td {
        padding: 0.2rem 0.2rem !important;
    }
</style>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<div class="front-container">
    <div id="print-page">
        <div id="left-table">
            <div id="FIRMA">
                <table id="firma-table" style="font-size: 11px;">
                <thead>
                    <tr>
                    <th class="kanit-medium table-color">FIRMA DEL PADRE, MADRE O TUTOR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td style="border: solid black 1px !important;">
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
            <div id="Observaciones" style="height: 100%;">
                <table id="Observaciones-table" style="height: 100%; font-size: 11px;">
                    <thead>
                        <tr>
                        <th class="kanit-medium table-color">Observaciones: </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td style="padding-top: 20px; height: 100%; border: solid black 1px !important;">
                        <?php if ($observation) echo $observation; 
                        else { ?>
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
                            <div class="underlined-field kanit-light"><span></span></div>
                            <div class="underlined-field kanit-light"><span></span></div>
                            <div class="underlined-field kanit-light"><span></span></div>
                            <div class="underlined-field kanit-light"><span></span></div>
                        <?php } ?>
                        </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="right-side">
            <img src="<?php echo base_url('uploads/school_content/logo/logo.png'); ?>" style="width: 20%;">
            <div class="kanit-light" style="text-align: center; font-size: 12px;">Viceministro de Servicios Técnicos y Pedagógicos <br> Dirección General de Educación Secundaria</div>
            <div class="kanit-medium title-color" style="font-size: 24px;">BOLETÍN DE CALIFICACIONES </div>
            <img src="<?php 
                if ($student['class'] == '1er Grado') echo base_url('uploads/school_content/logo/1grado.png');
                else if ($student['class'] == '2do Grado') echo base_url('uploads/school_content/logo/2grado.png');
                else if ($student['class'] == '3er Grado') echo base_url('uploads/school_content/logo/3grado.png');
                else if ($student['class'] == '3er Grado') echo base_url('uploads/school_content/logo/3grado.png');
                else if ($student['class'] == '4to. Grado') echo base_url('uploads/school_content/logo/4grado.png');
                else if ($student['class'] == '5to. Grado') echo base_url('uploads/school_content/logo/5grado.png');
                else if ($student['class'] == '6to. Grado') echo base_url('uploads/school_content/logo/6grado.png');
                else echo base_url('uploads/school_content/logo/4grado.png');
                ?>" style="width: 30%;">
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
</div>
<div class="pagebreak"></div>
<div class="report-container">
    <div id="detail-page">
        <div id="student-detail" class="kanit-regular">
            <span class="nowrap">Nombre(s) y apellido (s): </span>
            <span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;">
                <?php echo $this->customlib->getFullName($student['firstname'], $student['middlename'], $student['lastname'], $sch_setting->middlename, $sch_setting->lastname); ?>
            </span>
            Grado:<span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;">
                <?php echo $student['class'] ?>
            </span>
            Sección: <span style="font-family: sans-serif; border-bottom: solid 1px black; width: 100%; height: 20px; padding-left: 10px;">
                <?php echo $student['section'] ?>
            </span>
        </div>
        <div class="kanit-medium CALIFICACIONES title-bgcolor">
            CALIFICACIONES DE RENDIMIENTO
        </div>
        <div>
            <table class="table-bordered table-hover grade-table" style="font-size: 11px;">
            <thead>
                <tr>
                    <th class="table-color subjectlabelth right-border" colspan="2" rowspan="2">COMPETENCIAS <br> FUNDAMENTALES</th>
                    <th class="table-color right-border" colspan="4" rowspan="2" style="text-wrap: nowrap">• Comunicativa</th>
                    <th class="table-color right-border" colspan="4" rowspan="2">• Pensamiento Lógico, Creativo y Crítico <br> • Resolución de Problemas</th>
                    <th class="table-color right-border" colspan="4" rowspan="2">• Científica y Tecnológica <br> • Ambiental y de la Salud</th>
                    <th class="table-color right-border" colspan="4" rowspan="2">• Ética y Ciudadana <br> • Desarrollo Personal y Espiritual</th>
                    <th class="table-color right-border" colspan="4" rowspan="2">PROMEDIO GRUPO DE COMPETENCIAS ESPECÍFICAS</th>
                    <th class="table-light-color vertical-lr rotated right-border" colspan="1" rowspan="3">CALIFICACIÓN <br> FINAL DEL ÁREA</th>
                    <th class="table-color right-border" colspan="4">CALIFICACIÓN COMPLETIVA</th>
                    <th class="table-color right-border" colspan="4">CALIFICACIÓN EXTRAORDINARIA</th>
                    <th class="table-color right-border" colspan="2">EVALUACIÓN ESPECIAL</th>
                    <th class="table-color right-border" colspan="2" rowspan="2">SITUACIÓN FINAL EN LA ASIGNATURA</th>
                </tr>
                <tr>
                    <th class="table-color vertical-lr rotated right-border" rowspan="2">50% C. F.</th>
                    <th class="table-color vertical-lr rotated" rowspan="2">C.E.C.</th>
                    <th class="table-color vertical-lr rotated" rowspan="2">50% C.E.C.</th>
                    <th class="table-light-color vertical-lr rotated left-border" rowspan="2">C.C.F.</th>
                    <th class="table-color vertical-lr rotated right-border" rowspan="2">30% C.F.</th>
                    <th class="table-color vertical-lr rotated" rowspan="2">C.E. EX</th>
                    <th class="table-color vertical-lr rotated" rowspan="2">70% C.E. EX</th>
                    <th class="table-light-color vertical-lr rotated left-border" rowspan="2">C.EX.F.</th>
                    <th class="table-color vertical-lr rotated" rowspan="2">C.F.</th>
                    <th class="table-light-color vertical-lr rotated left-border" rowspan="2">C.E.</th>
                </tr>
                <tr>
                    <th class="table-light-color right-border" colspan="2">PERÍODOS</th>
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
                    <th class="table-light-color">P1</th>
                    <th class="table-light-color">P2</th>
                    <th class="table-light-color">P3</th>
                    <th class="table-light-color right-border">P4</th>
                    <th class="table-light-color">PC1</th>
                    <th class="table-light-color">PC2</th>
                    <th class="table-light-color">PC3</th>
                    <th class="table-light-color right-border">PC4</th>
                    <th class="table-color">A</th>
                    <th class="table-color">R</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grading_subject_results as $index => $result) { ?>
                    <tr>
                    <?php if ($index == 0) { ?> <td rowspan="<?php echo count($grading_subject_results); ?>" class="table-color kanit-semibold vertical-lr rotated right-border" style="text-align: center;">ÁREAS CURRICULARES</td> <?php } ?>
                        <td class="kanit-semibold right-border" style="padding-left: 4px; padding-right: 4px; text-align: left;"><?php echo $result['subject'] ?></td>
                        <?php for ($i = 0; $i < count($periodList) * 5; $i++) { ?>
                            <td class="<?php if ($i % 4 == 3) echo 'right-border'; ?>"><?php echo $result['period_results'][$i] ? $result['period_results'][$i] : "" ?></td>
                        <?php } ?>
                            <td class="rboder right-border"><?php echo $result['CF'] ?></td>
                            <td><?php echo $result['50PCP'] ?></td>
                            <td><?php echo $result['CPC'] ?></td>
                            <td><?php echo $result['50CPC'] ?></td>
                            <td class="rboder right-border"><?php echo $result['CC'] ?></td>
                            <td><?php echo $result['30PCP'] ?></td>
                            <td><?php echo $result['CPEX'] ?></td>
                            <td><?php echo $result['70CPEX'] ?></td>
                            <td class="rboder right-border"><?php echo $result['CEX'] ?></td>
                            <td><?php echo $result['O1'] ?></td>
                            <td class="rboder right-border"><?php echo $result['O2'] ?></td>
                            <td><?php echo $result['A'] ?></td>
                            <td><?php echo $result['R'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            </table>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 20px;">
            <div>
                <table class="table table-bordered table-hover resumen-table kanit-semibold" style="text-align: center; height: 100%; font-size: 11px; align-content: center;">
                    <thead>
                    <tr>
                        <th class="table-color" colspan="5">RESUMEN DE ASISTENCIA DEL/LA ESTUDIANTE</th>
                    </tr>
                    <tr>
                        <th class="table-light-color" rowspan="2">Períodos</th>
                        <th rowspan="2">Asistencia</th>
                        <th rowspan="2">Ausencia</th>
                        <th colspan="2">% de Anual</th>
                    </tr>
                    <tr>
                        <th>Asistencia</th>
                        <th>Ausencia</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="table-light-color">P1</td>
                        <td></td>
                        <td></td>
                        <td rowspan="4"></td>
                        <td rowspan="4"></td>
                    </tr>
                    <tr>
                        <td class="table-light-color">P2</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="table-light-color">P3</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="table-light-color">P4</td>
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
                        <th class="table-color" style="text-align: center;">LEYENDA:</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="display: flex; gap: 10px; padding: 10px; height: 100%;">
                            <div class="kanit-semibold">
                                <div>(P1)</div>
                                <div>(P2)</div>
                                <div>(P3)</div>
                                <div>(P4)</div>
                                <div>(PC)</div>
                                <div>(C.F.)</div>
                                <div>(C.E.C.)</div>
                                <div>(C.C.F.)</div>
                                <div>(C.E. EX)</div>
                                <div>(C.EX.F.)</div>
                                <div>(C.E.)</div>
                                <div>(A)</div>
                                <div>(R)</div>
                            </div>
                            <!-- <div>
                            </div>
                            <div>
                            </div> -->
                            <div>
                                <div>Período 1</div>
                                <div>Período 2</div>
                                <div>Período 3</div>
                                <div>Período 4</div>
                                <div>Promedio Grupo de Competencias Específicas</div>
                                <div>Calificación Final</div>
                                <div>Calificación Evaluación Completiva</div>
                                <div>Calificación Completiva Final</div>
                                <div>Calificación Evaluación Extraordinaria</div>
                                <div>Calificación Extraordinaria Final</div>
                                <div>Calificación Especial</div>
                                <div>Aprobado</div>
                                <div>Reprobado</div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="kanit-medium SITUACION">
                <div class="situacion-title">
                    <div class="table-color kanit-semibold" style="padding: 2px 30px; min-width: 300px; text-align: center; font-size: 12px;">SITUACIÓN DEL/DE LA ESTUDIANTE</div>
                    <div style="display: flex; gap: 5px;">
                    <div>Promovido/a</div>
                    <input type="radio">
                    </div>
                    <div style="display: flex; gap: 5px;">
                    <div>Repitente</div>
                    <input type="radio">
                    </div>
                    <div></div>
                </div>
                <table class="table table-bordered table-hover condicion-table" style="height: 100%; font-size: 11px; margin-bottom: 0px;">
                    <thead>
                    <tr>
                        <th class="table-color" style="text-align: center;">CONDICIÓN FINAL DEL/DE LA ESTUDIANTE:</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="height: 100px;"></td>
                    </tr>
                    </tbody>
                </table>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div id="logo-table">
                        <img src="<?php echo base_url('uploads/school_content/logo/rect-logo.png'); ?>" style="width: 70px;">
                        <div style="padding: 2px;">
                            <div style="font-size: 16px;"><b>Escuela Parroquial Santa Rita</b></div>
                            <div style="font-size: 14px;"><b>Orden Agustinos Recoletos</b></div>
                            <div>Lema del año: “¿Aspiras a lo grande? Comienza por lo pequeño” <br> Valor del año: Interioridad </div>
                        </div>
                    </div>
                    <div id="logo-table" style="justify-content: space-between;">
                        <div class="text-center">
                            <div style="width: 95%; height: 30px; border-bottom: 1px solid black;"></div>
                            <div class="kanit-semibold"><?php echo $school_director; ?></div>
                            <div>Director General</div>
                        </div>
                        <div class="text-center">
                            <div style="width: 95%; height: 30px; border-bottom: 1px solid black;"></div>
                            <div class="kanit-semibold"><?php echo $Coordinadora2; ?></div>
                            <div>Coordinadora Nivel Secundario</div>
                        </div>
                        <div class="text-center">
                            <div style="width: 95%; height: 30px; border-bottom: 1px solid black;"></div>
                            <div class="kanit-semibold"><?= $class_teacher ?></div>
                            <div>Maestro Guía</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pagebreak"></div>