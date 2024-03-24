<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Classroom extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("classroom_model");
        $this->role;
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function index() {
        if (!$this->rbac->hasPrivilege('assign_class_room', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'admin/classroom');
        $data['title'] = 'Add Class Room';
        $data['title_list'] = 'Class List';

        $this->form_validation->set_rules('class', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section', $this->lang->line('section'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('room', $this->lang->line('room'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('staff_id', $this->lang->line('room_coordinator'), 'trim|required|xss_clean');

        if ($this->form_validation->run() != false) {
            if (!$this->rbac->hasPrivilege('assign_class_room', 'can_add')) {
                access_denied();
            }
            $class = $this->input->post("class");
            $section = $this->input->post("section");
            $room = $this->input->post("room");
            $staff_id = $this->input->post("staff_id");

            $data = array(
                'room' => $room,
                'class_id' => $class,
                'section_id' => $section,
                'staff_id' => $staff_id,
                'session_id' => $this->current_session,
            );
            $this->classroom_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/classroom');
        }

        $classlist = $this->class_model->get();
        $data['classlist'] = $classlist;

        $teacherlist = $this->staff_model->getStaffbyrole($role = 2);
        $data['teacherlist'] = $teacherlist;
        
        $roomslist = $this->classroom_model->get();
        $data['roomslist'] = $roomslist;

        $this->load->view('layout/header', $data);
        $this->load->view('admin/classrooms/index', $data);
        $this->load->view('layout/footer', $data);
    }

    public function edit($id) {

        if (!$this->rbac->hasPrivilege('assign_class_room', 'can_edit')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'admin/classroom');
        $data['title'] = 'Edit Class Room';
        $data['title_list'] = 'Room List';

        $result = $this->classroom_model->get($id);
        $data['result'] = $result;

        $this->form_validation->set_rules('class', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section', $this->lang->line('section'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('room', $this->lang->line('room'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('staff_id', $this->lang->line('room_coordinator'), 'trim|required|xss_clean');


        if ($this->form_validation->run() != false) {
            $id = $this->input->post("id");
            $class = $this->input->post("class");
            $section = $this->input->post("section");
            $room = $this->input->post("room");
            $staff_id = $this->input->post("staff_id");

            $data = array(
                'id' => $id,
                'room' => $room,
                'class_id' => $class,
                'section_id' => $section,
                'staff_id' => $staff_id,
                'session_id' => $this->current_session,
            );
            $this->classroom_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('update_message') . '</div>');
            redirect('admin/classroom');
        }

        $classlist = $this->class_model->get();
        $data['classlist'] = $classlist;

        $teacherlist = $this->staff_model->getStaffbyrole($role = 2);
        $data['teacherlist'] = $teacherlist;
        
        $roomslist = $this->classroom_model->get();
        $data['roomslist'] = $roomslist;

        $this->load->view('layout/header', $data);
        $this->load->view('admin/classrooms/edit', $data);
        $this->load->view('layout/footer', $data);
    }

    public function delete($id) {

        if ((!empty($id))) {
            $this->classroom_model->delete($id);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">' . $this->lang->line('delete_message') . '</div>');
            redirect("admin/classroom");
        }
    }

}
