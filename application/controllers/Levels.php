<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Levels extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Level_model');
    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('level', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'level/index');
        $data['title'] = 'level List';

        $level_result      = $this->Level_model->getLevelList();
        $data['levellist'] = $level_result;
        $level_coordinators = $this->staff_model->getStaffbyrole(8);
        $coordinator_array = array();
        foreach($level_coordinators as $value){
            $coordinator_array[$value['id']] = $value['name']." ".$value['surname'];
        }
        $data['coordinatorsList'] = $level_coordinators;
        $data['coordinatorsArray'] = $coordinator_array;

        $this->form_validation->set_rules('level', $this->lang->line('level'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('level/levelList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'level' => $this->input->post('level'),
                'coordinator_id' => $this->input->post('coordinator_id'),
            );
            $this->Level_model->addLevel($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('levels/index');
        }
    }


    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('level', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'level List';
        $this->Level_model->deleteLevel($id);
        redirect('levels/index');
    }

    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('level', 'can_edit')) {
            access_denied();
        }
        $data['title']       = 'Level List';
        $level_result      = $this->Level_model->getLevelList();
        $data['levellist'] = $level_result;
        $data['title']       = 'Edit level';
        $data['id']          = $id;
        $level             = $this->Level_model->getLevelList($id);
        $data['level']     = $level;

        $level_coordinators = $this->staff_model->getStaffbyrole(8);
        $coordinator_array = array();
        foreach($level_coordinators as $value){
            $coordinator_array[$value['id']] = $value['name']." ".$value['surname'];
        }
        $data['coordinatorsList'] = $level_coordinators;
        $data['coordinatorsArray'] = $coordinator_array;

        $this->form_validation->set_rules('level', $this->lang->line('level'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('level/levelEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id'      => $id,
                'level' => $this->input->post('level'),
                'coordinator_id' => $this->input->post('coordinator_id'),
            );
            $this->Level_model->addLevel($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('levels/index');
        }
    }

}
