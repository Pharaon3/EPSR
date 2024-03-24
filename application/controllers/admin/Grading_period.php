<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Grading_period extends Admin_Controller
{

    public $sch_setting_detail = array();

    public function __construct()
    {
        parent::__construct();
        $this->sch_current_session = $this->setting_model->getCurrentSession();
        $this->staff_id            = $this->customlib->getStaffID();
        $this->sch_setting_detail = $this->setting_model->getSetting();
        $this->load->library("datatables");
        $this->load->model('Level_model');
        $this->load->model('Gradingreport_model');
        $this->load->model('Gradingperiod_model');
    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('grading_report_period', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'GradingReport');
        $this->session->set_userdata('sub_menu', 'GradingReport/Period');

        $level_list = $this->Level_model->getLevelList();
        $data['levelList'] = $level_list;
        
        $monthlist = $this->customlib->getMonthDropdown();
        $data['monthlist'] = $monthlist;
        
        $this->load->view('layout/header', $data);
        $this->load->view('admin/gradingreport/gradingperiod', $data);
        $this->load->view('layout/footer', $data);
    }

    public function create()
    {
        $this->form_validation->set_rules('level_id', $this->lang->line('level'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('label', $this->lang->line('period'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('start_month', $this->lang->line('start'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_month', $this->lang->line('end'), 'trim|required|xss_clean');

       
        if ($this->form_validation->run() == false) {
            $msg = array(
                'level_id'       => form_error('level_id'),
                'label'             => form_error('label'),
                'start_month' => form_error('start_month'),
                'end_month'     => form_error('end_month'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $data = array(
                'level_id'       => $this->input->post('level_id'),
                'label'             => $this->input->post('label'),
                'start_month' => $this->input->post('start_month'),
                'end_month'     => $this->input->post('end_month'),
            );
            $this->Gradingperiod_model->addPeriod($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function getlist()
    {   
        $monthlist = $this->customlib->getMonthDropdown();
        $result  = $this->Gradingperiod_model->getPeriodList();
        $m       = json_decode($result);
        $dt_data = array();
        if (!empty($m->data)) {
            foreach ($m->data as $key => $value) {
                $deletebtn = '';
                $editbtn = '';
                if ($this->rbac->hasPrivilege('grading_report_period', 'can_edit')) {
                    $editbtn = "<a href='" . base_url() . "admin/grading_period/edit/" . $value->id . "'   class='btn btn-default btn-xs'  data-toggle='tooltip' data-placement='left' title='" . $this->lang->line('edit') . "'><i class='fa fa-pencil'></i></a>";
                }
                if ($this->rbac->hasPrivilege('grading_report_period', 'can_delete')) {
                    $deletebtn = "<a onclick='deleteperiod(" . '"' . $value->id . '"' . "  )'  class='btn btn-default btn-xs' data-placement='left' title='" . $this->lang->line('delete') . "' data-toggle='tooltip'><i class='fa fa-remove'></i></a>";
                }
                $row       = array();
                $row[]     = $value->level;
                $row[]     = $value->label;
                $row[]     = $monthlist[$value->start_month];
                $row[]     = $monthlist[$value->end_month];
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

    public function edit($id)
    {
        if (!($this->rbac->hasPrivilege('grading_report_period', 'can_edit'))) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'GradingReport');
        $this->session->set_userdata('sub_menu', 'GradingReport/Period');

        $level_list = $this->Level_model->getLevelList();
        $data['levelList'] = $level_list;
        
        $monthlist = $this->customlib->getMonthDropdown();
        $data['monthlist'] = $monthlist;

        $period = $this->Gradingperiod_model->getPeriod($id);
        $data['period'] = $period;
        
        $this->load->view('layout/header', $data);
        $this->load->view('admin/gradingreport/editperiod', $data);
        $this->load->view('layout/footer', $data);
    }

    public function update()
    {
        $this->form_validation->set_rules('level_id', $this->lang->line('level'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('label', $this->lang->line('period'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('start_month', $this->lang->line('start'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_month', $this->lang->line('end'), 'trim|required|xss_clean');

       
        if ($this->form_validation->run() == false) {
            $msg = array(
                'level_id'       => form_error('level_id'),
                'label'             => form_error('label'),
                'start_month' => form_error('start_month'),
                'end_month'     => form_error('end_month'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $data = array(
                'id'       => $this->input->post('period_id'),
                'level_id'       => $this->input->post('level_id'),
                'label'             => $this->input->post('label'),
                'start_month' => $this->input->post('start_month'),
                'end_month'     => $this->input->post('end_month'),
            );
            $this->Gradingperiod_model->addPeriod($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function delete($id)
    {
        if (!($this->rbac->hasPrivilege('grading_report_period', 'can_delete'))) {
            access_denied();
        }
        $this->Gradingperiod_model->deletePeriod($id);
        $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('delete_message'));
        echo json_encode($array);
    }

}
