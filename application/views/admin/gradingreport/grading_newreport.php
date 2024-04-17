<style type="text/css">
    #gradingResultTB th {
        text-align: center;
        vertical-align: middle;
    }

    #gradingResultTB th,
    #gradingResultTB td {
        border: 1px solid black;
        border-collapse: collapse;
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

    .competencerow {
        position: relative;
        text-align: center;
        background-color: #d4d4d4;
        padding: 9px !important;
    }

    .pull_right {
        position: absolute;
        right: 5px;
        top: 6px;
        padding: 3px 10px;
    }

    .observaciones_container {
        padding-top: 20px;
    }

    .observaciones_container textarea {
        padding: 4px 4px;
        resize: none;
        border: none
    }

    .observaciones_container :focus {
        outline: none;
        border: solid 1px #ccc;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .right-red {
        border-right-color: red !important;
    }

    .td-input {
        border: none !important;
        background: transparent !important;
        max-width: 30px !important;
        text-align: center;
        outline: unset !important;
    }
    
</style>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">View Report</h3>
                    <button type="button" style="margin-left:10px; font-size:20px; padding:1px 6px;" class="btn btn-primary " onclick="printview(<?= $student['id'] ?>)"><i class='fa fa-print'></i></button>
                    <?php if ($isPrekender) { ?>
                        <button type="button" style="<?php if (!$alledit) { ?>display:none;<?php } ?> margin-left:10px; font-size:20px; padding:1px 6px;" class="btn btn-primary pull-right savealleditbtn" onclick="savealledit()"><?php echo $this->lang->line('all'); ?> <?php echo $this->lang->line('save'); ?></button>
                        <button type="button" style="<?php if (!$alledit) { ?>display:none;<?php } ?>margin-left:10px; font-size:20px; padding:1px 6px;" class="btn btn-primary pull-right cancelalleditbtn" onclick="cancelalledit()"><?php echo $this->lang->line('all'); ?> <?php echo $this->lang->line('cancel'); ?></button>
                        <button type="button" style="<?php if ($alledit) { ?>display:none;<?php } ?>margin-left:10px; font-size:20px; padding:1px 6px;" class="btn btn-primary pull-right alleditbtn" onclick="alledit()"><?php echo $this->lang->line('all'); ?> <?php echo $this->lang->line('edit'); ?></button>
                        <input type="hidden" id="alledittype" value="<?= $alledit ?>">
                    <?php } ?>
                    <input type="hidden" id="student_id" value="<?= $student['id'] ?>">
                </div>
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="sfborder">
                                <div class="col-md-2">
                                    <img width="115" height="115" class="round5" src="<?php
                                                                                        if (!empty($student['image'])) {
                                                                                            echo base_url() . $student['image'];
                                                                                        } else {
                                                                                            echo base_url() . "uploads/student_images/no_image.png";
                                                                                        }
                                                                                        ?>" alt="No Image">
                                </div>

                                <div class="col-md-10">
                                    <div class="row">
                                        <table class="table table-striped mb0 font13">
                                            <tbody>
                                                <tr>
                                                    <th class="bozero"><?php echo $this->lang->line('name'); ?></th>
                                                    <td class="bozero"><?php echo $this->customlib->getFullName($student['firstname'], $student['middlename'], $student['lastname'], $sch_setting->middlename, $sch_setting->lastname); ?></td>

                                                    <th class="bozero"><?php echo $this->lang->line('class_section'); ?></th>
                                                    <td class="bozero"><?php echo $student['class'] . " (" . $student['section'] . ")" ?> </td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo $this->lang->line('father_name'); ?></th>
                                                    <td><?php echo $student['father_name']; ?></td>
                                                    <th><?php echo $this->lang->line('admission_no'); ?></th>
                                                    <td><?php echo $student['admission_no']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo $this->lang->line('mobile_no'); ?></th>
                                                    <td><?php echo $student['mobileno']; ?></td>
                                                    <th><?php echo $this->lang->line('roll_no'); ?></th>
                                                    <td> <?php echo $student['roll_no']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo $this->lang->line('category'); ?></th>
                                                    <td>
                                                        <?php
                                                        foreach ($categorylist as $value) {
                                                            if ($student['category_id'] == $value['id']) {
                                                                echo $value['category'];
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php if ($sch_setting->rte) { ?>
                                                        <th><?php echo $this->lang->line('rte'); ?></th>
                                                        <td><b class="text-danger"> <?php echo $student['rte']; ?> </b>
                                                        </td>
                                                    <?php } ?>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div style="background: #dadada; height: 1px; width: 100%; clear: both; margin-bottom: 10px;"></div>
                        </div>
                    </div>
                    <?php if ($isPrekender) { ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label><?php echo $this->lang->line('period'); ?></label> <small class="req"> *</small>
                                            </div>
                                            <div class="col-sm-8">
                                            <select autofocus="" id="period_id" name="period_id" class="form-control">
                                                <option value=""><?php echo $this->lang->line('all'); ?></option>
                                                <?php
                                                foreach ($periodList as $period) {
                                                    if( empty($period['canedit'])) continue;
                                                ?>
                                                    <option value="<?php echo $period['id'] ?>" <?php if ($period_id == $period['id']) {
                                                                                                    echo "selected=selected";
                                                                                                } ?>>
                                                        <?php echo $period['label'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <button id="search_by_period" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php if($observationeditable) { ?>
                    <div class="observaciones_container">
                    <div class="col-md-12">
                            <input type="radio" name="editList" id="1er" <?php if($student['observation_index'] == 1) echo "checked"; ?> value="1"/>
                            <label for="1er">1er.</label>
                            <input type="radio" name="editList" style="margin-left:15px;" id="2do" <?php if($student['observation_index'] == 2) echo "checked"; ?> value="2"/>
                            <label for="2do">2do.</label>
                            <input type="radio" name="editList" style="margin-left:15px;" id="3er" <?php if($student['observation_index'] == 3) echo "checked"; ?> value="3"/>
                            <label for="3er">3er.</label>
                            <input type="radio" name="editList" style="margin-left:15px;" id="4to" <?php if($student['observation_index'] == 4) echo "checked"; ?> value="4"/>
                            <label for="4to">4to.</label>
                         </div>
                         <div>
                        <strong>Observaciones:</strong>
                        <textarea id="std_observation" style="width:100%;" rows="3" placeholder="Observaciones"><?php echo $observation ?></textarea>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($isPrekender) { ?>


                    <div class="table-responsive">
                        <form id="update_competence_report">
                            <input type="hidden" name="student_session_id" value="<?php echo $student_session_id ?>">
                            <table class="table table-striped table-bordered table-hover">
                                <tbody>
                                    <?php foreach ($competenceList as $competence) { ?>
                                        <tr>
                                            <td colspan="<?= count($valuescaleList) + 1 ?>" class="competencerow">
                                                <strong><?php echo $competence['name']; ?></strong>
                                                <?php if ($this->rbac->hasPrivilege('grading_report_results', 'can_edit')) { ?>
                                                    <button style="<?php if ($alledit) { ?>display:none;<?php } ?>" type="button" id="edit_btn_<?= $competence['id'] ?>" data_type="edit" onclick="editReportByCompetence(<?= $competence['id'] ?>)" class="btn btn-primary btn-sm pull_right edit-competence-report-btn"><?php echo $this->lang->line('edit'); ?></button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('indicators_achievement'); ?></th>
                                            <?php foreach ($valuescaleList as $valuescale) { ?>
                                                <th class="text-center"><?php echo $valuescale['label']; ?></th>
                                            <?php } ?>
                                        </tr>
                                        <?php foreach ($competence['data'] as $indicator) { ?>
                                            <tr>
                                                <td><?php echo $indicator['name']; ?></td>
                                                <?php foreach ($valuescaleList as $key => $valuescale) { ?>
                                                    <td class="text-center td_competence_<?= $competence['id'] ?>">
                                                        <div style="<?php if ($alledit) { ?>display:none;<?php } ?>" class="marklabel">
                                                            <?php echo $indicator['marks'] == $valuescale['marks'] ? $valuescale['symbol'] : ""; ?>
                                                        </div>
                                                        <div class="markedit" data_innerhtml='<input type="radio" name="indicators_<?php echo $indicator['id'] ?>" <?php echo (empty($indicator['marks']) && $key == 1) || $indicator['marks'] == $valuescale['marks'] ? "checked" : ""; ?> value="<?php echo $valuescale['marks'] ?>">'>
                                                            <?php if ($alledit) { ?><input type="radio" name="indicators_<?php echo $indicator['id'] ?>" <?php echo (empty($indicator['marks']) && $key == 1) || $indicator['marks'] == $valuescale['marks'] ? "checked" : ""; ?> value="<?php echo $valuescale['marks'] ?>"><?php } ?>
                                                        </div>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </form>

                        <div class="form-group save_competence_edit_btn_container" style="padding: 2px 25%; display:none;">
                            <button id="save_competence_edit" class="btn btn-primary btn-block btn-sm checkbox-toggle"><?php echo $this->lang->line('save'); ?> <?php echo $this->lang->line('all'); ?></button>
                        </div>
                    </div>
                    <!-- </div> -->
<!--                    --><?php //if($observationeditable) { ?>
<!--                        <div class="observaciones_container">-->
<!--                            <strong>Observaciones:</strong>-->
<!--                            <textarea id="std_observation" style="width:100%;" rows="3" placeholder="Observaciones">--><?php //echo $observation ?><!--</textarea>-->
<!--                        </div>-->
<!--                    --><?php //} ?>
                    <br><br>
                <?php } else { ?>
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            CALIFICACIONES DE RENDIMIENTO DE <?php echo $student['class'] ?> <?php echo $student['section'] ?>
                        </h3>
                        <button type="button" id="second_save_btn" style="margin-left: 10px; display:none;" onclick="saveReportBySubject()" class="btn btn-primary btn-sm pull-right"><?php echo $this->lang->line('save'); ?></button>
						<?php if($role_id != 2) {?>
                        <button type="button" id="second_edit_btn" data_type="edit" onclick="editReportBySubject()" class="btn btn-primary btn-sm pull-right"><?php echo $this->lang->line('edit'); ?></button>
						<?php } ?>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive" id="gradingResultTB">
                            <form id="update_subject_report">
                                <input type="hidden" name="student_session_id" value="<?php echo $student_session_id ?>">
                                <table class="table table-striped table-bordered table-hover competence-<?php echo $competence['id'] ?>" data-export-title="<?php echo $this->lang->line('student') . " " . $this->lang->line('list'); ?>">
                                    <thead>
                                        <tr>
                                            <th class="subjectlabelth right-red" colspan="1" rowspan="3">ASIGNATURAS</th>
                                            <!-- <th class="pink" colspan="1">COMPETENCIAS FUNDAMENTALES</th> -->
                                            <th class="pink right-red" colspan="8" rowspan="2">Comunicativa</th>
                                            <th class="pink right-red" colspan="8" rowspan="2">• Pensamiento Lógico, <br> Creativo y Crítico <br> • Resolución de Problemas</th>
                                            <th class="pink right-red" colspan="8" rowspan="2">• Científica y Tecnológica <br> • Ambiental y de la Salud</th>
                                            <th class="pink right-red" colspan="8" rowspan="2">• Ética y Ciudadana <br> • Desarrollo Personal <br> y Espiritual</th>
                                            <th class="pink right-red" colspan="4" rowspan="2">PROMEDIO GRUPO <br> DE COMPETENCIAS <br> ESPECÍFICAS</th>
                                            <th class="lightpink vertical-lr rotated right-red" colspan="1" rowspan="3">CALIFICACIÓN <br> FINAL DEL ÁREA</th>
                                            <th class="pink" colspan="4">CALIFICACIÓN <br> COMPLETIVA</th>
                                            <th class="pink" colspan="4">CALIFICACIÓN <br> EXTRAORDINARIA</th>
                                            <th class="pink" colspan="2">EVALUACIÓN <br> ESPECIAL</th>
                                            <th class="pink" colspan="2" rowspan="2">SITUACIÓN <br> FINAL EN LA <br> ASIGNATURA</th>
                                        </tr>
                                        <tr>
                                            <th class="pink vertical-lr rotated" rowspan="2">50% C. F.</th>
                                            <th class="pink vertical-lr rotated" rowspan="2">C.E.C.</th>
                                            <th class="pink vertical-lr rotated" rowspan="2">50% C.E.C.</th>
                                            <th class="lightpink vertical-lr rotated" rowspan="2">C.C.F.</th>
                                            <th class="pink vertical-lr rotated" rowspan="2">30% C.F.</th>
                                            <th class="pink vertical-lr rotated" rowspan="2">C.E. EX</th>
                                            <th class="pink vertical-lr rotated" rowspan="2">70% C.E. EX</th>
                                            <th class="lightpink vertical-lr rotated" rowspan="2">C.EX.F.</th>
                                            <th class="pink vertical-lr rotated" rowspan="2">C.F.</th>
                                            <th class="lightpink vertical-lr rotated" rowspan="2">C.E.</th>
                                        </tr>
                                        <tr>
                                            <th class="lightpink">P1</th>
                                            <th class="lightpink">RP1</th>
                                            <th class="lightpink">P2</th>
                                            <th class="lightpink">RP2</th>
                                            <th class="lightpink">P3</th>
                                            <th class="lightpink">RP3</th>
                                            <th class="lightpink">P4</th>
                                            <th class="lightpink right-red">RP4</th>
                                            <th class="lightpink">P1</th>
                                            <th class="lightpink">RP1</th>
                                            <th class="lightpink">P2</th>
                                            <th class="lightpink">RP2</th>
                                            <th class="lightpink">P3</th>
                                            <th class="lightpink">RP3</th>
                                            <th class="lightpink">P4</th>
                                            <th class="lightpink right-red">RP4</th>
                                            <th class="lightpink">P1</th>
                                            <th class="lightpink">RP1</th>
                                            <th class="lightpink">P2</th>
                                            <th class="lightpink">RP2</th>
                                            <th class="lightpink">P3</th>
                                            <th class="lightpink">RP3</th>
                                            <th class="lightpink">P4</th>
                                            <th class="lightpink right-red">RP4</th>
                                            <th class="lightpink">P1</th>
                                            <th class="lightpink">RP1</th>
                                            <th class="lightpink">P2</th>
                                            <th class="lightpink">RP2</th>
                                            <th class="lightpink">P3</th>
                                            <th class="lightpink">RP3</th>
                                            <th class="lightpink">P4</th>
                                            <th class="lightpink right-red">RP4</th>
                                            <th class="lightpink">PC1</th>
                                            <th class="lightpink">PC2</th>
                                            <th class="lightpink">PC3</th>
                                            <th class="lightpink right-red">PC4</th>
                                            <th class="pink">A</th>
                                            <th class="pink">R</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($grading_subject_results as $result) { ?>
                                            <tr>
                                                <td class="right-red"><?php echo $result['subject'] ?></td>
                                                <?php $i = 0;
                                                foreach( $periodList as $per) {  ?>
                                                    <td class="td_subject">
                                                        <input type="number" min="0" max="100" class="td-input pr" style="width:60px;" name="secondaryreport_<?= $result['subjectId'] ?>_p1<?= $i + 1 ?>" value="<?= $result['period_results'][$i] == 0 ? "" : $result['period_results'][$i] ?>" onfocus="style.background='LightYellow';" onblur="this.style.background='';">
                                                    </td>
                                                    <td class="td_subject <?php if ($i % 4 == 3) echo 'right-red' ?> ">
                                                        <input type="number" min="0" max="100" class="td-input pr" style="width:60px;" name="secondaryreport_<?= $result['subjectId'] ?>_rp1<?= $i + 1 ?>" value="<?= $result['period_resultsRP'][$i] == 0 ? "" : $result['period_resultsRP'][$i] ?>">
                                                    </td>
                                                <?php $i++;
                                                } ?>
                                                <?php
                                                foreach( $periodList as $per) {  ?>
                                                    <td class="td_subject">
                                                        <input type="number" min="0" max="100" class="td-input pr" style="width:60px;" name="secondaryreport_<?= $result['subjectId'] ?>_p2<?= $i - 3 ?>" value="<?= $result['period_results'][$i] == 0 ? "" : $result['period_results'][$i] ?>" onfocus="style.background='LightYellow';" onblur="this.style.background='';">
                                                    </td>
                                                    <td class="td_subject <?php if ($i % 4 == 3) echo 'right-red' ?> ">
                                                        <input type="number" min="0" max="100" class="td-input pr" style="width:60px;" name="secondaryreport_<?= $result['subjectId'] ?>_rp2<?= $i - 3 ?>" value="<?= $result['period_resultsRP'][$i] == 0 ? "" : $result['period_resultsRP'][$i] ?>">
                                                    </td>
                                                <?php $i++;
                                                } ?>
                                                <?php
                                                foreach( $periodList as $per) {  ?>
                                                    <td class="td_subject">
                                                        <input type="number" min="0" max="100" class="td-input pr" style="width:60px;" name="secondaryreport_<?= $result['subjectId'] ?>_p3<?= $i - 7 ?>" value="<?= $result['period_results'][$i] == 0 ? "" : $result['period_results'][$i] ?>" onfocus="style.background='LightYellow';" onblur="this.style.background='';">
                                                    </td>
                                                    <td class="td_subject <?php if ($i % 4 == 3) echo 'right-red' ?> ">
                                                        <input type="number" min="0" max="100" class="td-input pr" style="width:60px;" name="secondaryreport_<?= $result['subjectId'] ?>_rp3<?= $i - 7 ?>" value="<?= $result['period_resultsRP'][$i] == 0 ? "" : $result['period_resultsRP'][$i] ?>">
                                                    </td>
                                                <?php $i++;
                                                } ?>
                                                <?php
                                                foreach( $periodList as $per) {  ?>
                                                    <td class="td_subject"><input type="number" min="0" max="100" class="td-input pr" style="width:60px;" name="secondaryreport_<?= $result['subjectId'] ?>_p4<?= $i - 11 ?>" value="<?= $result['period_results'][$i] == 0 ? "" : $result['period_results'][$i] ?>" onfocus="style.background='LightYellow';" onblur="this.style.background='';">
                                                    </td>
                                                    <td class="td_subject <?php if ($i % 4 == 3) echo 'right-red' ?> ">
                                                        <input type="number" min="0" max="100" class="td-input pr" style="width:60px;" name="secondaryreport_<?= $result['subjectId'] ?>_rp4<?= $i - 11 ?>" value="<?= $result['period_resultsRP'][$i] == 0 ? "" : $result['period_resultsRP'][$i] ?>">
                                                    </td>
                                                <?php $i++;
                                                } ?>
                                                <?php
                                                foreach( $periodList as $per) {  ?>
                                                    <td class="td_subject <?php if ($i % 4 == 3) echo 'right-red' ?> ">
                                                        <div class="marklabel" canedit="<?php echo $period['canedit']; ?>">
                                                        <?php echo $result['period_results'][$i] ? $result['period_results'][$i] : "" ?>
                                                        </div>
														
                                                        </div>
                                                    </td>
                                                <?php $i++;
                                                } ?>
                                                <?php for ($ii = $i; $ii < 20; $ii++) { ?>
                                                <td>&nbsp;</td>
                                                <?php } ?>
                                                <td class="right-red"><?php echo $result['CF'] ? $result['CF'] : "" ?></td>
                                                <td><?php echo $result['50PCP'] ? $result['50PCP'] : "" ?></td>
                                                <td><?php echo $result['CPC'] ? $result['CPC'] : "" ?></td>
                                                <td><?php echo $result['50CPC'] ? $result['50CPC'] : "" ?></td>
                                                <td><?php echo $result['CC'] ? $result['CC'] : "" ?></td>
                                                <td><?php echo $result['30PCP'] ? $result['30PCP'] : "" ?></td>
                                                <td><?php echo $result['CPEX'] ? $result['CPEX'] : "" ?></td>
                                                <td><?php echo $result['70CPEX'] ? $result['70CPEX'] : "" ?></td>
                                                <td><?php echo $result['CEX'] ? $result['CEX'] : "" ?></td>
                                                <td><?php echo $result['O1'] ?></td>
                                                <td><?php echo $result['O2'] ?></td>
                                                <td><?php echo $result['A'] ?></td>
                                                <td><?php echo $result['R'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <div style="padding-bottom:10px">
                            <table class="explain_field">
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
                            <div style="font-weight: bolder; color:black;">
                                <span style="padding:1px 20px 1px 10px; background:#CCC; border:solid 1px black">CONDICIÓN FINAL:</span> &nbsp;&nbsp; Promovido <span style="padding:1px 20px; border:solid 1px black">X</span> &nbsp;&nbsp; Reprobado <span style="padding:1px 20px; border:solid 1px black">X</span> &nbsp;&nbsp; Promovido con asignaturas pendientes <span style="padding:1px 20px; border:solid 1px black">X</span>
                            </div>
                           
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        $("input[name='editList']").change(
        function(e)
        {
            var index = this.value;
            var student_session_id = $('input[name="student_session_id"]').val();
            $.ajax({
                type: "POST",
                url: base_url + "admin/grading_result/changeObservation",
                data: {
                    student_session_id: student_session_id,
                    index: index,
                }, // serializes the form's elements.
                success: function(data) {
                    $('#std_observation').val(data);
                },
            });
        });
    });
</script>