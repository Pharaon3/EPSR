<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Grading_indicators extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('Customlib');
        $this->sch_current_session = $this->setting_model->getCurrentSession();
        $this->staff_id            = $this->customlib->getStaffID();
        $this->load->library("datatables");
        $this->load->model('Gradingreport_model');
    }

    public function index()
    {
        if (!($this->rbac->hasPrivilege('grading_report_indicators', 'can_view'))) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'GradingReport');
        $this->session->set_userdata('sub_menu', 'GradingReport/Indicators');

        $level_list = $this->Gradingreport_model->getLevelList();
        $data['levelList'] = $level_list;
        foreach ($level_list as $level_key => $level_value) {
            $data['level_array'][] = $level_value['id'];
        }

        $data['level_id']         = "";
        $data['class_id']         = "";
        $data['period_id']       = "";
        $data['competence_id']       = "";

        $userdata                 = $this->customlib->getUserData();
        $role_id                  = $userdata["role_id"];
        $staff_id                 = $userdata["id"];

        $this->load->view('layout/header');
        $this->load->view('admin/gradingreport/indicators', $data);
        $this->load->view('layout/footer');
    }

    public function createindicators()
    {
        $this->form_validation->set_rules('level_id', $this->lang->line('level'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('period_id', $this->lang->line('period'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('competence_id', $this->lang->line('competence'), 'trim|required|xss_clean');

        $validate = 1;
        if (!empty($_POST['indicators'])) {
            foreach ($_POST['indicators'] as $ckey => $cvalue) {
                if ($cvalue == '') {
                    $validate = 0;
                }
            }
        } else {
            $validate = 0;
        }

        if ($this->form_validation->run() == false) {
            $msg = array(
                'level_id'           => form_error('level_id'),
                'class_id'           => form_error('class_id'),
                'period_id'         => form_error('period_id'),
                'competence_id' => form_error('competence_id'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } elseif ($validate == 0) {
            $msg   = array('indicators' => $this->lang->line('indicators') . " " . $this->lang->line('name') . " field is required");
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            foreach ($_POST['indicators'] as $key => $value) {
                $data = array(
                    'name'             => $value,
                    'competence_id' => $_POST['competence_id'],
                );
                $this->Gradingreport_model->add_indicators($data);
            }
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function getindicatorslist()
    {
        // $class = $this->class_model->get();

        // foreach ($class as $class_key => $class_value) {
        //     $class_array[] = $class_value['id'];
        // }

        $result  = $this->Gradingreport_model->getCompetencelist($this->sch_current_session, false);
        $m       = json_decode($result);
        $dt_data = array();


        if (!empty($m->data)) {
            foreach ($m->data as $key => $value) {
                $indicators_name = '';
                $indicators      = $this->Gradingreport_model->getIndicatorsByCompetence($value->id);
                if ($this->rbac->hasPrivilege('grading_report_indicators', 'can_edit')) {
                    $editbtn = "<a href='" . base_url() . "admin/grading_indicators/editindicators/" . $value->level_id . "/" . $value->class_id . "/" . $value->period_id . "/" . $value->id . "'   class='btn btn-default btn-xs'  data-toggle='tooltip' data-placement='left' title='" . $this->lang->line('edit') . "'><i class='fa fa-pencil'></i></a>";
                }
                if ($this->rbac->hasPrivilege('grading_report_indicators', 'can_delete')) {
                    $deletebtn = '';
                    $deletebtn = "<a onclick='deleteIndicatorsBulk(" . '"' . $value->id . '"' . "  )'  class='btn btn-default btn-xs' data-placement='left' title='" . $this->lang->line('delete') . "' data-toggle='tooltip'><i class='fa fa-remove'></i></a>";
                }

                // if (in_array($value->classid, $class_array)) {

                foreach ($indicators as $rl_value) {
                    $indicators_name .= $rl_value['name'] . '<br>';
                };
                $row       = array();
                $row[]     = $value->level;
                $row[]     = $value->class;
                $row[]     = $value->period;
                $row[]     = $value->name;
                $row[]     = $indicators_name;
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

    public function getCompetences()
    {
        $class_id = $this->input->get('class_id');
        $period_id = $this->input->get('period_id');
        $competences = $this->Gradingreport_model->getCompetences($this->sch_current_session, $class_id, $period_id);
        echo json_encode($competences);
    }

    public function editindicators($level_id, $class_id, $period_id, $competence_id)
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

        $competence_list = $this->Gradingreport_model->getCompetences($this->sch_current_session, $class_id, $period_id);
        $data['competenceList'] = $competence_list;

        $indicators = $this->Gradingreport_model->getIndicatorsByCompetence($competence_id);
        $data['indicators']       = $indicators;
        $data['level_id']           = $level_id;
        $data['class_id']           = $class_id;
        $data['period_id']         = $period_id;
        $data['competence_id'] = $competence_id;

        $this->load->view('layout/header');
        $this->load->view('admin/gradingreport/editindicator', $data);
        $this->load->view('layout/footer');
    }

    public function updateindicators()
    {
        $can_edit      = 1;
        $this->form_validation->set_rules('level_id', $this->lang->line('level'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('period_id', $this->lang->line('period'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('competence_id', $this->lang->line('competence'), 'trim|required|xss_clean');

        $all_indicators = $this->Gradingreport_model->getIndicatorsByCompetence($_POST['indicators_competence_id']);
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata["role_id"];
        // if (isset($role_id) && ($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {
        //     $class_section = $this->lessonplan_model->ifclassteacher($_POST['class_id'], $_POST['section_id'], $userdata['id'], $_POST['subject_group_id'], $_POST['subject_id']);

        //     $can_edit = $class_section;
        // }
        $validate = 1;
        foreach ($all_indicators as $cey => $cvalue) {
            if (isset($_POST['indicators_' . $cvalue['id']]) && $_POST['indicators_' . $cvalue['id']] == '') {
                $validate = 0;
            }
        }
        if (isset($_POST['indicators'])) {
            foreach ($_POST['indicators'] as $ckey => $cvalue) {
                if ($cvalue == '') {
                    $validate = 0;
                }
            }
        }

        $delete_validate = 1;
        if (isset($_POST['competence_delete'])) {
            foreach ($_POST['competence_delete'] as $delete_key => $delete_value) {
                $in_indicators = 0;
                foreach ($all_indicators as $cey => $cvalue) {
                    if ($delete_value == $cvalue['id']) {
                        $in_indicators = 1;
                    }
                }
                if (!$in_indicators) {
                    $delete_validate = 0;
                }
            }
        }

        if ($this->form_validation->run() == false) {
            $msg = array(
                'level_id'   => form_error('level_id'),
                'class_id'   => form_error('class_id'),
                'period_id' => form_error('period_id'),
                'competence_id' => form_error('competence_id')
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } elseif ($validate == 0) {
            $msg   = array('indicators' => $this->lang->line('indicators') . " " . $this->lang->line('name') . " field is required");
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } elseif ($can_edit == 0) {
            $msg   = array('indicators' => $this->lang->line('you_are_not_authorised_to_update_indicators'));
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } elseif ($delete_validate == 0) {
            $msg   = array('indicators' => $this->lang->line('deleted_indicators_invalid'));
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            if (isset($_POST['indicators_delete'])) {
                foreach ($_POST['indicators_delete'] as $delete_key => $delete_value) {
                    $this->Gradingreport_model->deleteIndicators($delete_value);
                }
            }

            foreach ($all_indicators as $ckey => $cvalue) {
                if (isset($_POST['indicators_' . $cvalue['id']])) {
                    $data = array(
                        'name' => $_POST['indicators_' . $cvalue['id']],
                        'competence_id'      => $_POST['competence_id'],
                        'id'                           => $cvalue['id'],
                    );

                    $this->Gradingreport_model->add_indicators($data);
                }
            }

            if (isset($_POST['indicators'])) {
                foreach ($_POST['indicators'] as $key => $value) {
                    $data = array(
                        'competence_id' => $_POST['competence_id'],
                        'name'                           => $value,
                    );
                    $this->Gradingreport_model->add_indicators($data);
                }
            }
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function deleteindicatorsbulk($competence_id)
    {
        if (!($this->rbac->hasPrivilege('grading_report_indicators', 'can_delete'))) {
            access_denied();
        }
        $this->Gradingreport_model->deleteIndicatorsBulk($competence_id);
        $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('delete_message'));
        echo json_encode($array);
    }
}
