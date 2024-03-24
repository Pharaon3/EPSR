<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Composetimezone extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('timetable_model');
        $this->load->model('level_model');
        
    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('compose_timetable', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'composetimezone/index');
        
        $data['lesson_timezone'] = $this->timetable_model->gettimezone();
        $data['ampms'] = TIME_AMPM;

        $this->load->view('layout/header');
        $this->load->view('admin/composetimetable/timezone', $data);
        $this->load->view('layout/footer');
    }

    public function insert()
    {
        if (!$this->rbac->hasPrivilege('compose_timetable', 'can_view')) {
            access_denied();
        }
        $lesson_timezone_id = $this->input->post('lesson_timezone_id');
        $timezone_name      = $this->input->post('timezone_name');
        $ampm_flag          = $this->input->post('lesson_time');
        $description        = $this->input->post('note');
      
        $this->form_validation->set_rules('timezone_name', $this->lang->line('time_from'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == true) {
            $timezone_data = [];
            if($lesson_timezone_id != 0)
            {
                $timezone_data = ['id' => $lesson_timezone_id];
            }
            $timezone_data['timezone_name'] = $timezone_name;
            $timezone_data['ampm_flag']     = $ampm_flag;
            $timezone_data['description']   = $description;

            $this->timetable_model->AddorUpdateTimetableZone($timezone_data);
            //print("<script>console.log(parent); parent.formClear();</script>");
        }
        redirect('admin/composetimezone');
    }
    
    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('compose_timetable', 'can_delete')) {
            access_denied();
        }
        $this->timetable_model->deletelessontimezone($id);
        redirect('admin/composetimezone');
    }

    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('compose_timetable', 'can_edit')) {
            access_denied();
        }

        $lesson_timezone_detail = $this->timetable_model->gettimezone($id);
        
        if( count($lesson_timezone_detail)==0)
        {
            return redirect('admin/composetimetable/index');
        }
        
        $data['ampms'] = TIME_AMPM;
        $data['lesson_timezone'] = $this->timetable_model->gettimezone();
        $data['lesson_timezone_detail'] = $lesson_timezone_detail;

        $this->load->view('layout/header');
        $this->load->view('admin/composetimetable/timezone', $data);
        $this->load->view('layout/footer');
    }
}
