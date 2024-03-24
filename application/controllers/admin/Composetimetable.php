<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Composetimetable extends Admin_Controller
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
        $this->session->set_userdata('sub_menu', 'composetimetable/index');
        $combo_info = $this->session->userData('combo_info');

        
        $timezone_id                = $this->input->post('timezone_id');

        if( empty($timezone_id) && !empty($combo_info))
        {
            $timezone_id            = $combo_info['timezone_id'];
        }
        $data['lesson_timezone']    = $this->timetable_model->gettimezone();
        $data['timezone_id']        = $timezone_id;
        $data["timetables"]         = $this->timetable_model->getlevel_timetable($timezone_id);


        $this->load->view('layout/header');
        $this->load->view('admin/composetimetable/timelist', $data);
        $this->load->view('layout/footer');
    }

    public function insert()
    {
        if (!$this->rbac->hasPrivilege('compose_timetable', 'can_view')) {
            access_denied();
        }
        $timezone_id            = $this->input->post('timezone_id');
        $time_type              = $this->input->post('time_type');
        $description            = $this->input->post('description');
        $time_from              = $this->input->post('time_from');
        $time_to                = $this->input->post('time_to');
        $data['timezone_id']    = $timezone_id;
        
        $data["timetables"] = $this->timetable_model->getlevel_timetable($timezone_id);

        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'composetimetable/index');
        $this->form_validation->set_rules('time_from', $this->lang->line('time_from'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('time_to', $this->lang->line('time_to'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == true) {
            $time_from = $this->input->post('time_from');
            $time_from = str_replace("PM","",$time_from);
            $time_from = str_replace("AM","",$time_from);
            $time_to = $this->input->post('time_to');
            $time_to = str_replace("PM","",$time_to);
            $time_to = str_replace("AM","",$time_to);
            $update_id = $this->input->post('update_id');
            if($update_id == 0)
            {
                $insert_data = array(
                    'time_from'     => $time_from,
                    'time_to'       => $time_to,
                    'timezone_id'   => $timezone_id,
                    'delete_flag'   => 0,
                    'description'   => $description,
                    'time_type'     => $time_type,
                );
                $this->timetable_model->addtimetable($insert_data);
            }
            else
            {
                $update_data = array(
                    'id'            => $update_id,
                    'time_from'     => $time_from,
                    'time_to'       => $time_to,
                    'delete_flag'   => 0,
                    'description'   => $description,
                    'time_type'     => $time_type,
                );
                $this->timetable_model->updatetimetable($update_data);
            }
            
            $combo_info = array(
                'timezone_id'      => $timezone_id,
            );
            $this->session->set_userdata('combo_info',$combo_info);
        }
        redirect("admin/composetimetable/index");
    }
    
    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('compose_timetable', 'can_delete')) {
            access_denied();
        }
        
        $lesson_time = $this->timetable_model->gettimetable($id);
       
        $this->timetable_model->deletelessontime($id);
        redirect('admin/composetimetable/index');
    }

    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('compose_timetable', 'can_edit')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'composetimetable/index');
        $lesson_time = $this->timetable_model->gettimetable($id);
        
        if( count($lesson_time)==0)
        {
            return redirect('admin/composetimetable/index');
        }
   
        $timezone_id       = $lesson_time[0]['timezone_id'];

        $data['lesson_timezone']    = $this->timetable_model->gettimezone();
        $data['timezone_id']        = $timezone_id;
        $data["timetables"]         = $this->timetable_model->getlevel_timetable($timezone_id);
        $data['id'] = $id;

        $data['timezone_id']        = $timezone_id;
        $data["lesson_time"]        = $lesson_time[0];
        
        $this->form_validation->set_rules('time_from', $this->lang->line('time_from'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('time_to', $this->lang->line('time_to'), 'trim|required|xss_clean');

        # intial edit form view
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header');
            $this->load->view('admin/composetimetable/timeEdit', $data);
            $this->load->view('layout/footer');
        } else {
            # edit form submited
            $data = array(
                'id' => $id,
                'time_from'     => $this->input->post('time_from'),
                'time_to'       => $this->input->post('time_to'),
                'time_type'     => $this->input->post('time_type'),
                'description'   => $this->input->post('description'),

            );
            $this->timetable_model->updatetimetable($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            
            // selected filter holding
            $combo_info = array(
                'timezone_id' => $timezone_id,
            );
            $this->session->set_userdata('combo_info',$combo_info);
            redirect('admin/composetimetable/index');
        }
    }
}
