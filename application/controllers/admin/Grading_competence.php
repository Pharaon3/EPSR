<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Grading_competence extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('Customlib');
        $this->sch_current_session = $this->setting_model->getCurrentSession();
        $this->staff_id            = $this->customlib->getStaffID();
        $this->load->library("datatables");
        $this->load->model('Gradingreport_model');
        $this->load->library('encoding_lib');
    }

    public function competences()
    {
        if (!($this->rbac->hasPrivilege('grading_report_competences', 'can_view'))) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'GradingReport');
        $this->session->set_userdata('sub_menu', 'GradingReport/Competences');

        $level_list = $this->Gradingreport_model->getLevelList();
        $data['levelList'] = $level_list;
        foreach ($level_list as $level_key => $level_value) {
            $data['level_array'][] = $level_value['id'];
        }
        $data['level_id']         = "";
        $data['class_id']         = "";
        $data['period_id']       = "";

        $userdata                 = $this->customlib->getUserData();
        $role_id                  = $userdata["role_id"];
        $staff_id                 = $userdata["id"];

        $this->load->view('layout/header');
        $this->load->view('admin/gradingreport/competences', $data);
        $this->load->view('layout/footer');
    }

    public function createcompetence()
    {

        $data['title'] = 'Add Competence';
        $this->form_validation->set_rules('level_id', $this->lang->line('level'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('period_id', $this->lang->line('period'), 'trim|required|xss_clean');

        $validate = 1;
        if (!empty($_POST['competences'])) {
            foreach ($_POST['competences'] as $ckey => $cvalue) {
                if ($cvalue == '') {
                    $validate = 0;
                }
            }
        } else {
            $validate = 0;
        }

        if ($this->form_validation->run() == false) {
            $msg = array(
                'level_id'   => form_error('level_id'),
                'class_id'   => form_error('class_id'),
                'period_id' => form_error('period_id'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } elseif ($validate == 0) {
            $msg   = array('competences' => $this->lang->line('competence') . " " . $this->lang->line('name') . " field is required");
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            foreach ($_POST['competences'] as $key => $value) {
                $data = array(
                    'class_id'        => $_POST['class_id'],
                    'period_id'        => $_POST['period_id'],
                    'subject_id'        => empty($_POST['subject_id'][$key]) ? null : $_POST['subject_id'][$key],
                    'name'                            => $value,
                    'session_id'                      => $this->sch_current_session,
                );

                $this->Gradingreport_model->add_competence($data);
            }
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function getCompetencelist()
    {
        // $class = $this->class_model->get();

        // foreach ($class as $class_key => $class_value) {
        //     $class_array[] = $class_value['id'];
        // }

        $result  = $this->Gradingreport_model->getCompetencelist($this->sch_current_session);
        $m       = json_decode($result);
        $dt_data = array();

        if (!empty($m->data)) {
            foreach ($m->data as $key => $value) {
                $competence_name = "";
                $competences      = $this->Gradingreport_model->getCompetences($this->sch_current_session, $value->class_id, $value->period_id);
                if ($this->rbac->hasPrivilege('grading_report_competences', 'can_edit')) {
                    $editbtn = "<a href='" . base_url() . "admin/grading_competence/editcompetence/" . $value->level_id . "/" . $value->class_id . "/" . $value->period_id . "'   class='btn btn-default btn-xs'  data-toggle='tooltip' data-placement='left' title='" . $this->lang->line('edit') . "'><i class='fa fa-pencil'></i></a>";
                }
                if ($this->rbac->hasPrivilege('grading_report_competences', 'can_delete')) {
                    $deletebtn = '';
                    $deletebtn = "<a onclick='deletecompetencebulk(" . '"' . $value->class_id . '"' . ',' . '"' . $value->period_id . '"' . "  )'  class='btn btn-default btn-xs' data-placement='left' title='" . $this->lang->line('delete') . "' data-toggle='tooltip'><i class='fa fa-remove'></i></a>";
                }

                // if (in_array($value->classid, $class_array)) {
                $subject_code = "";
                foreach ($competences as $rl_value) {
                    $competence_name .= '<div class="d-flex"> <div>' . $rl_value['name'] . '</div> <div>' . $rl_value['subject_code'] . '</div></div>';
                };
                $row       = array();
                $row[]     = $value->level;
                $row[]     = $value->class;
                $row[]     = $value->period;
                $row[]     = $competence_name;
                $row[]     = $editbtn . ' ' . $deletebtn;
                $dt_data[] = $row;
                // }
            }
        }

        $json_data = array(
            "draw"            => intval($m->draw),
            "recordsTotal"    => intval($m->recordsTotal),
            "recordsFiltered" => intval($m->recordsFiltered),
            "data"            => $dt_data,
        );
        echo json_encode($json_data);
    }

    public function getByLevel()
    {
        $level_id = $this->input->get('level_id');
        $class = $this->Gradingreport_model->getClassByLevel($level_id);
        $period = $this->Gradingreport_model->getPeriodByLevel($level_id);
        $json_data = array(
            "class" => $class,
            "period" => $period
        );
        echo json_encode($json_data);
    }

    public function getSubjectsbyClass()
    {
        $class_id = $this->input->get('class_id');
        $sections     = $this->section_model->getClassBySection($class_id);
        $data = array();
        foreach ($sections as $section) {
            $section_id = $section['section_id'];
            $subjectgroups = $this->subjectgroup_model->getGroupByClassandSection($class_id, $section_id);
            foreach ($subjectgroups as $subjectgroup) {
                $subject_group_id = $subjectgroup['subject_group_id'];
                $subjects = $this->subjectgroup_model->getGroupsubjects($subject_group_id);
                foreach ($subjects as $subject) {
                    $data[$subject->id] = $subject->name;
                }
            }
        }

        $json_data = array(
            "subjects" => $data
        );
        echo json_encode($json_data);
    }

    public function editcompetence($level_id, $class_id, $period_id)
    {
        if (!($this->rbac->hasPrivilege('grading_report_competences', 'can_edit'))) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'GradingReport');
        $this->session->set_userdata('sub_menu', 'GradingReport/Competences');

        $level_list = $this->Gradingreport_model->getLevelList();
        $data['levelList'] = $level_list;

        $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
        $data['classList'] = $class_list;

        $period_list = $this->Gradingreport_model->getPeriodByLevel($level_id);
        $data['periodList'] = $period_list;

        $sections     = $this->section_model->getClassBySection($class_id);
        $subjectList = array();
        foreach ($sections as $section) {
            $section_id = $section['section_id'];
            $subjectgroups = $this->subjectgroup_model->getGroupByClassandSection($class_id, $section_id);
            foreach ($subjectgroups as $subjectgroup) {
                $subject_group_id = $subjectgroup['subject_group_id'];
                $subjects = $this->subjectgroup_model->getGroupsubjects($subject_group_id);
                foreach ($subjects as $subject) {
                    $subjectList[$subject->id] = $subject->name;
                }
            }
        }
        $data['subjectList'] = $subjectList;

        $competences = $this->Gradingreport_model->getCompetences($this->sch_current_session, $class_id, $period_id);

        $data['competences']                 = $competences;
        $data['level_id']                     = $level_id;
        $data['class_id']                       = $class_id;
        $data['period_id']                     = $period_id;

        $this->load->view('layout/header');
        $this->load->view('admin/gradingreport/editcompetence', $data);
        $this->load->view('layout/footer');
    }

    public function updatecompetence()
    {
        $can_edit      = 1;
        $this->form_validation->set_rules('level_id', $this->lang->line('level'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('period_id', $this->lang->line('period'), 'trim|required|xss_clean');

        $all_competences = $this->Gradingreport_model->getCompetences($this->sch_current_session, $_POST['competences_class_id'], $_POST['competences_period_id']);
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata["role_id"];
        // if (isset($role_id) && ($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {
        //     $class_section = $this->lessonplan_model->ifclassteacher($_POST['class_id'], $_POST['section_id'], $userdata['id'], $_POST['subject_group_id'], $_POST['subject_id']);

        //     $can_edit = $class_section;
        // }
        $validate = 1;
        foreach ($all_competences as $cey => $cvalue) {
            if (isset($_POST['competences_' . $cvalue['id']]) && $_POST['competences_' . $cvalue['id']] == '') {
                $validate = 0;
            }
        }
        if (isset($_POST['competences'])) {
            foreach ($_POST['competences'] as $ckey => $cvalue) {
                if ($cvalue == '') {
                    $validate = 0;
                }
            }
        }

        $delete_validate = 1;
        if (isset($_POST['competence_delete'])) {
            foreach ($_POST['competence_delete'] as $delete_key => $delete_value) {
                $in_competences = 0;
                foreach ($all_competences as $cey => $cvalue) {
                    if ($delete_value == $cvalue['id']) {
                        $in_competences = 1;
                    }
                }
                if (!$in_competences) {
                    $delete_validate = 0;
                }
            }
        }

        if ($this->form_validation->run() == false) {
            $msg = array(
                'level_id'   => form_error('level_id'),
                'class_id'   => form_error('class_id'),
                'period_id' => form_error('period_id'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } elseif ($validate == 0) {
            $msg   = array('competence' => $this->lang->line('competence') . " " . $this->lang->line('name') . " field is required");
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } elseif ($can_edit == 0) {
            $msg   = array('competence' => $this->lang->line('you_are_not_authorised_to_update_competences'));
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } elseif ($delete_validate == 0) {
            $msg   = array('competence' => $this->lang->line('deleted_competences_invalid'));
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            if (isset($_POST['competence_delete'])) {
                foreach ($_POST['competence_delete'] as $delete_key => $delete_value) {
                    $this->Gradingreport_model->deleteCompetence($delete_value);
                }
            }

            foreach ($all_competences as $ckey => $cvalue) {
                if (isset($_POST['competences_' . $cvalue['id']])) {
                    $data = array(
                        'class_id'                 => $_POST['class_id'],
                        'name' => $_POST['competences_' . $cvalue['id']],
                        'period_id'               => $_POST['period_id'],
                        'session_id'       => $this->sch_current_session,
                        'subject_id' => empty($_POST['subject_' . $cvalue['id']]) ? null : $_POST['subject_' . $cvalue['id']],
                        'id'                        => $cvalue['id'],
                    );

                    $this->Gradingreport_model->add_competence($data);
                }
            }

            if (isset($_POST['competences'])) {
                foreach ($_POST['competences'] as $key => $value) {
                    $data = array(
                        'class_id'           => $_POST['class_id'],
                        'period_id'         => $_POST['period_id'],
                        'name'                           => $value,
                        'session_id' => $this->sch_current_session,
                        'subject_id'        => empty($_POST['subject_id'][$key]) ? null : $_POST['subject_id'][$key]
                    );
                    $this->Gradingreport_model->add_competence($data);
                }
            }
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function deletecompetencebulk($class_id, $period_id)
    {
        if (!($this->rbac->hasPrivilege('grading_report_competences', 'can_delete'))) {
            access_denied();
        }
        $this->Gradingreport_model->deleteCompetenceBulk($this->sch_current_session, $class_id, $period_id);
        $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('delete_message'));
        echo json_encode($array);
    }

    public function exportformat()
    {
        $this->load->helper('download');
        $filepath = "./backend/import/import_grading_competences_sample_file.csv";
        $data     = file_get_contents($filepath);
        $name     = 'import_grading_competences_sample_file.csv';

        force_download($name, $data);
    }

    public function import()
    {
        if (!$this->rbac->hasPrivilege('grading_report_competences', 'can_view')) {
            access_denied();
        }
        $data['title']      = 'Import Competence';
        $data['title_list'] = 'Recently Added Competence';
        $session            = $this->sch_current_session;
        $level_list = $this->Gradingreport_model->getLevelList();
        $data['levelList'] = $level_list;

        $fields = array('control', 'cDescripcion', 'idIdentificador', 'Idboletin', 'nOrdenGrupo', 'nOrdenAsig');

        $data["fields"]       = $fields;
        $this->form_validation->set_rules('level_id', $this->lang->line('level'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('file', $this->lang->line('image'), 'callback_handle_csv_upload');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/gradingreport/import', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $level_id   = $this->input->post('level_id');
            $class_id   = $this->input->post('class_id');
            $period_list = $this->Gradingreport_model->getPeriodByLevel($level_id);

            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                if ($ext == 'csv') {
                    $file = $_FILES['file']['tmp_name'];
                    $this->load->library('CSVReader');
                    $result = $this->csvreader->parse_file($file);

                    if (!empty($result)) {
                        $competence_data = array();
                        $indicators_data = array();
                        for ($i = 1; $i <= count($result); $i++) {
                            if (isset($result[$i]['nOrdenGrupo']) && $result[$i]['nOrdenGrupo'] == 0) {
                                $competence_data[$result[$i]['nOrdenAsig']] = array();
                                $competence_data[$result[$i]['nOrdenAsig']]['name'] = $result[$i]['cDescripcion'];
                                $competence_data[$result[$i]['nOrdenAsig']]['session_id'] = $session;
                                $competence_data[$result[$i]['nOrdenAsig']]['class_id'] = $class_id;
                                $period_key = $result[$i]['Idboletin'] - 1;
                                $period_id = $period_list[$period_key]['id'];
                                $competence_data[$result[$i]['nOrdenAsig']]['period_id'] = $period_id;
                            } else {
                                $indicators = array();
                                $indicators['name'] = $result[$i]['cDescripcion'];
                                $indicators['competence_id'] = null;
                                $indicators_data[$result[$i]['nOrdenAsig']][] = $indicators;
                            }
                        }

                        foreach ($competence_data as $key => $competence) {
                            $competence_id = $this->Gradingreport_model->add_competence($competence);
                            if ($competence_id) {
                                foreach ($indicators_data[$key] as $indicators) {
                                    $i_data = $indicators;
                                    $i_data['competence_id'] = $competence_id;
                                    $this->Gradingreport_model->add_indicators($i_data);
                                }
                            }
                        }

                        $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">' . $this->lang->line('grading_competences') . " " . $this->lang->line('records_imported_successfully') . '</div>');
                    } else {

                        $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">' . $this->lang->line('no_record_found') . '</div>');
                    }
                } else {

                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">' . $this->lang->line('please_upload_CSV_file_only') . '</div>');
                }
            }

            redirect('admin/grading_competence/import');
        }
    }

    public function handle_csv_upload()
    {
        $error = "";
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
            $allowedExts = array('csv');
            $mimes       = array(
                'text/csv',
                'text/plain',
                'application/csv',
                'text/comma-separated-values',
                'application/excel',
                'application/vnd.ms-excel',
                'application/vnd.msexcel',
                'text/anytext',
                'application/octet-stream',
                'application/txt'
            );
            $temp      = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);
            if ($_FILES["file"]["error"] > 0) {
                $error .= "Error opening the file<br />";
            }
            if (!in_array($_FILES['file']['type'], $mimes)) {
                $error .= "Error opening the file<br />";
                $this->form_validation->set_message('handle_csv_upload', $this->lang->line('file_type_not_allowed'));
                return false;
            }
            if (!in_array($extension, $allowedExts)) {
                $error .= "Error opening the file<br />";
                $this->form_validation->set_message('handle_csv_upload', $this->lang->line('extension_not_allowed'));
                return false;
            }
            if ($error == "") {
                return true;
            }
        } else {
            $this->form_validation->set_message('handle_csv_upload', $this->lang->line('please_select_file'));
            return false;
        }
    }
}
