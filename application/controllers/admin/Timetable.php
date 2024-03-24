<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Timetable extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("staff_model");
        $this->load->model("classteacher_model");
    }

    public function index()
    {

        if (!$this->rbac->hasPrivilege('class_time_table', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'Academics/timetable');
        $session            = $this->setting_model->getCurrentSession();
        $data['title']      = 'Exam Marks';
        $data['exam_id']    = "";
        $data['class_id']   = "";
        $data['section_id'] = "";

        $class             = $this->class_model->get();
        $data['classlist'] = $class;

        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('group_id', $this->lang->line('group'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/timetable/timetableList', $data);
            $this->load->view('layout/footer', $data);
        } else {

            $class_id           = $this->input->post('class_id');
            $section_id         = $this->input->post('section_id');
            $section_id         = $this->input->post('group_id');
            $data['class_id']   = $class_id;
            $data['section_id'] = $section_id;
            $result_subjects    = $this->teachersubject_model->getSubjectByClsandSection($class_id, $section_id);

            $getDaysnameList         = $this->customlib->getDaysname();
            
            $data['getDaysnameList'] = $getDaysnameList;
            $final_array             = array();
            if (!empty($result_subjects)) {
                foreach ($result_subjects as $subject_k => $subject_v) {
                    $result_array = array();
                    foreach ($getDaysnameList as $day_key => $day_value) {
                        $where_array = array(
                            'teacher_subject_id' => $subject_v['id'],
                            'day_name'           => $day_value,
                        );
                        $result = $this->timetable_model->get($where_array);
                        if (!empty($result)) {
                            $obj                      = new stdClass();
                            $obj->status              = "Yes";
                            $obj->start_time          = $result[0]['start_time'];
                            $obj->end_time            = $result[0]['end_time'];
                            $obj->room_no             = $result[0]['room_no'];
                            $result_array[$day_value] = $obj;
                        } else {
                            $obj                      = new stdClass();
                            $obj->status              = "No";
                            $obj->start_time          = "N/A";
                            $obj->end_time            = "N/A";
                            $obj->room_no             = "N/A";
                            $result_array[$day_value] = $obj;
                        }
                    }
                    $final_array[$subject_v['name']] = $result_array;
                }
            }

            $data['result_array'] = $final_array;
            $this->load->view('layout/header', $data);
            $this->load->view('admin/timetable/timetableList', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    public function mytimetable()
    {

        if (!$this->rbac->hasPrivilege('teachers_time_table', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'My Timetable';
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'Academics/timetable/mytimetable');
        $my_role  = $this->customlib->getStaffRole();
        $assignteacherlist = $this->class_model->getClassTeacher();
        
        $role     = json_decode($my_role);
        $is_admin = false;

        if ($role->id != "2") {
            $staff_list         = $this->staff_model->getEmployee('2');
            $data['staff_list'] = $staff_list;
            $is_admin           = true;
        }

        $staff_id          = $this->customlib->getStaffID();
        $data['timetable'] = array();
        $days              = $this->customlib->getDaysname();
        $lesson_timetables = $this->timetable_model->getstafflessontimes($staff_id);

        //print_r();
        //exit();
        
        $data['lesson_timetables'] = [];
        foreach($lesson_timetables as $row)
            $data['lesson_timetables'] [ $row['id'] ] = $row;
        
        $data['days'] = $days;
        foreach ($days as $day_key => $day_value) {
            $data['timetable'][$day_value] = [];
            foreach($this->subjecttimetable_model->getByStaffandDay($staff_id, $day_key) as $row)
            {
                $data['timetable'][$day_value][ $row->lesson_id ] = $row;
            }
        }

        $this->load->view('layout/header', $data);
        if ($is_admin) {
            $this->load->view('admin/timetable/admintimetable', $data);
        } else {
            $this->load->view('admin/timetable/mytimetable', $data);
        }
        $this->load->view('layout/footer', $data);
    }

    public function view($id)
    {
        if (!$this->rbac->hasPrivilege('class_timetable', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Mark List';
        $mark          = $this->mark_model->get($id);
        $data['mark']  = $mark;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/timetable/timetableShow', $data);
        $this->load->view('layout/footer', $data);
    }

    public function delete($id)
    {
        $data['title'] = 'Mark List';
        $this->mark_model->remove($id);
        redirect('admin/timetable/index');
    }

    public function create()
    {
        if (!$this->rbac->hasPrivilege('class_timetable', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'Academics/timetable');
        $class_id         = $this->input->post('class_id');
        $section_id       = $this->input->post('section_id');
        $subject_group_id = $this->input->post('subject_group_id');
        $session            = $this->setting_model->getCurrentSession();
        $data['title']      = 'Class Time Table';
        $data['subject_id'] = "";
        $data['class_id']   = "";
        $data['section_id'] = "";
        $class              = $this->class_model->get('', $classteacher = 'yes');
        $data['classlist']  = $class;
       

        if(
            !empty($_REQUEST['timetable_subject']) && 
            !empty($_REQUEST['timetable_staff'])  
            )
            {
                $this->savetimetable2();
            }
        $timezone_id = $this->timetable_model->getclsss_lesson_timezone( $class_id ?? 0, $section_id?? 0 );
        $data['timezone_id']         = $timezone_id;
        if($timezone_id!=0)
        {
            $data['validate_duplicated'] = $this->subjecttimetable_model->validateSubjectCountbyWeek($class_id, $section_id);
            $data['validate_lessoncount'] = $this->subjecttimetable_model->validateLessonCountbyWeek($class_id, $section_id);
        }
        
        $lesson_timetables = $this->timetable_model->gettimetable(null,0, $timezone_id);
        $data['lesson_timetables'] = $lesson_timetables;
        $staff                   = $this->staff_model->getStaffbyrole(2);
        $data['staff']           = $staff;
        $data['subject']         = array();
        $feecategory             = $this->feecategory_model->get();
        $data['feecategorylist'] = $feecategory;
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject_group_id', $this->lang->line('group'), 'trim|required|xss_clean');
        $data['class_id']         = $class_id;
        $data['section_id']       = $section_id;
        $data['subject_group_id'] = $subject_group_id;
      
        $data['validate_staffdup'] = [];
        foreach($staff as $row)
        {
            $validate_staffdup = $this->subjecttimetable_model->validateDuplicatedStaffInAtime($row['id']);    
            if(count($validate_staffdup)>0)
            {
                $data['validate_staffdup'] = $data['validate_staffdup'] + $validate_staffdup;
            }
        }
        if ($this->form_validation->run() != false) {
            $getDaysnameList         = $this->customlib->getDaysname();
            
            $data['getDaysnameList'] = $getDaysnameList;
            $subject                 = $this->subjectgroup_model->getGroupsubjects($subject_group_id);
            $data['subject']         = $subject;

            $data['timetable_subjects'] = [];
            
            $ClassTietable = $this->subjecttimetable_model->getSubjectByClassandSection($class_id, $section_id);
            $data['room_no'] = $ClassTietable[0]->room_no;

            foreach($ClassTietable as $row)
            {
                $data['timetable_subjects'][$row->lesson_id][$row->day] = [
                    'subject_id' => $row->subject_id,
                    'subject_name' => $row->subject_name,
                    'subject_code' => $row->code,
                    'subject_type' => $row->type,
                ];
            }

            $data['timetable_staff'] = [];
            foreach($ClassTietable as $row)
            {
                $data['timetable_staff'][$row->lesson_id][$row->day] = [
                    'staff_id'      => $row->class_teacher,
                    'staff_name'    => $row->name,
                    'staff_code'    => $row->employee_id,
                    'staff_type'    => $row->staff_type,
                ];
            }
        }
        //print_r($data['timetable_subjects']); die;
        
        $this->load->view('layout/header', $data);
        $this->load->view('admin/timetable/timetableCreate', $data);
        $this->load->view('layout/footer', $data);
    }

    public function classreport()
    {
        if (!$this->rbac->hasPrivilege('class_timetable', 'can_view')) {
            access_denied();
        }
        $class_id    = $this->input->post('class_id');
        $section_id  = $this->input->post('section_id');
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'Academics/timetable');
        $data['title']           = 'Exam Schedule';
        $data['subject_id']      = "";
        $data['class_id']        = $class_id ?? 0;
        $data['section_id']      = $section_id ?? 0;
        $exam                    = $this->exam_model->get();
        $class                   = $this->class_model->get('', $classteacher = 'yes');
        $data['examlist']        = $exam;
        $data['classlist']       = $class;
        $userdata                = $this->customlib->getUserData();
        $staff                   = $this->staff_model->getStaffbyrole(2);
        $data['staff']           = $staff;
        $data['subject']         = array();
        $feecategory             = $this->feecategory_model->get();
        $data['feecategorylist'] = $feecategory;

        $timezone_id = 0;

        if(!empty($class_id) && !empty($section_id))
        {
            $level_name = $this->timetable_model->getlevelname($class_id);
            $timezone_id = $this->timetable_model->getclsss_lesson_timezone( $class_id ?? 0, $section_id?? 0 );
            $lesson_timetables = $this->timetable_model->gettimetable(null,1,$timezone_id);
            $data['lesson_timetables'] = [];
            foreach($lesson_timetables as $row)
            {
                $data['lesson_timetables'][ $row['id'] ] = $row;
            }
        }

        $days                   = $this->customlib->getDaysname();
        $data['days']           = $days;
        $data['class_id']       = $class_id;
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        $room_no = "";
        if ($this->form_validation->run() == true) {
            if (isset($_POST['search'])) {
                $days_record = array();
                foreach ($days as $day_key => $day_value) {
                    $days_record[$day_key] = [];
                    $ClassTimetable = $this->subjecttimetable_model->getSubjectByClassandSectionDay($class_id, $section_id, $day_key);
                    if(empty($room_no))
                        $room_no = $ClassTimetable[0]->room_no;
                    foreach($ClassTimetable as $row)
                    {
                        $days_record[$day_key][ $row->lesson_id ] = $row;
                    }
                }
                $data['timetable'] = $days_record;
            }
        }
        //print_r($data['timetable'] ); die;
        $data['timezone_id'] = $timezone_id;
        $data['room_no'] = $room_no;
        $data['level_name'] = $level_name;
        if( !empty($timezone_id) )
        $data['validate_duplicated'] = $this->subjecttimetable_model->validateSubjectCountbyWeek($class_id, $section_id);
        $this->load->view('layout/header', $data);
        $this->load->view('admin/timetable/classreport', $data);
        $this->load->view('layout/footer', $data);
    }

    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('class_timetable', 'can_edit')) {
            access_denied();
        }
        $data['title'] = 'Edit Mark';
        $data['id']    = $id;
        $mark          = $this->mark_model->get($id);
        $data['mark']  = $mark;
        $this->form_validation->set_rules('name', $this->lang->line('mark'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/timetable/timetableEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id'   => $id,
                'name' => $this->input->post('name'),
                'note' => $this->input->post('note'),
            );
            $this->mark_model->add($data);
            $this->session->set_flashdata('msg', '<div mark="alert alert-success text-center">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/timetable/index');
        }
    }

    public function getBydategroupclasssection()
    {
        $data                = array();
        $data['total_count'] = 1;
        $day                 = $this->input->post('day');
        $class_id            = $this->input->post('class_id');
        $section_id          = $this->input->post('section_id');
        $subject_group_id    = $this->input->post('subject_group_id');
        $subject             = $this->subjectgroup_model->getGroupsubjects($subject_group_id);

        //$level_id = $this->timetable_model->getlevel_ampm($class_id, $section_id);
        $timezone_id = $this->timetable_model->getclsss_lesson_timezone( $class_id ?? 0, $section_id?? 0 );
        $lesson_timetables = $this->timetable_model->gettimetable(null,0,$timezone_id);

        $prev_record = $this->subjecttimetable_model->getBySubjectGroupDayClassSection($subject_group_id, $day, $class_id, $section_id);
        $data['lesson_timetables'] = [];
        foreach($lesson_timetables as $row)
        {
            $data['lesson_timetables'][ $row['id'] ] = $row;
        }
        $staff         = $this->staff_model->getStaffbyrole(2);
        $data['staff'] = $staff;
        if (empty($prev_record)) {
            $data['prev_record'] = array();
        } else {
            $data['total_count'] = count($prev_record);
            $data['prev_record'] = $prev_record;
        }
        $data['subject']            = $subject;
        $data['day']                = $day;
        $data['class_id']           = $class_id;
        $data['section_id']         = $section_id;
        $data['subject_group_id']   = $subject_group_id;

        $data['html'] = $this->load->view('admin/timetable/addrow', $data, true);
        echo json_encode($data);
    }

    public function savegroup()
    {
        $json = array();
        $this->form_validation->set_rules('subject_group_id', $this->lang->line('subject_group'), 'trim|required');
        $this->form_validation->set_rules('day', $this->lang->line('day'), 'trim|required');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required');
        $this->form_validation->set_rules('room_no', "Room No", 'trim|required');
        foreach ($this->input->post('total_row') as $key => $value) {
            $this->form_validation->set_rules('subject_' . $value, 'Subject', 'trim|required');
            $this->form_validation->set_rules('staff_' . $value, 'Staff', 'trim|required');
            $this->form_validation->set_rules('lesson_' . $value, 'lesson Time', 'trim|required');
            $this->form_validation->set_rules('room_no_' . $value, 'Room No', 'trim|required');
        }
       
        if (!$this->form_validation->run()) {
            $json = array(
                'subject_group_id' => form_error('subject_group_id', '<li>', '</li>'),
                'day'              => form_error('day', '<li>', '</li>'),
                'class_id'         => form_error('class_id', '<li>', '</li>'),
                'section_id'       => form_error('section_id', '<li>', '</li>'),
                'room_no'             => form_error('room_no', '<li>', '</li>'),
            );

            foreach ($this->input->post('total_row') as $key => $value) {
                $json['subject_' . $value]   = form_error('subject_' . $value, '<li>', '</li>');
                $json['staff_' . $value]     = form_error('staff_' . $value, '<li>', '</li>');
                $json['lesson_' . $value]    = form_error('lesson_' . $value, '<li>', '</li>');
                $json['room_no_' . $value]   = form_error('room_no_' . $value, '<li>', '</li>');
            }

            $json_array = array('status' => '0', 'error' => $json);
        } 
        else 
        {
            $day              = $this->input->post('day');
            $weekDayList      = $this->customlib->getDaysname();
            foreach($weekDayList as $daykey=>$datLabel)
            {
                if($datLabel==$day) $day = $daykey; break;
            }
            
            $class_id         = $this->input->post('class_id');
            $section_id       = $this->input->post('section_id');
            $subject_group_id = $this->input->post('subject_group_id');
            $total_row        = $this->input->post('total_row');
            $session          = $this->setting_model->getCurrentSession();
            $insert_array     = array();
            $update_array     = array();
            $old_input        = array();
            $prev_array       = $this->input->post('prev_array');
           
            if (isset($prev_array)) {
                foreach ($prev_array as $prev_arr_key => $prev_arr_value) {
                    $old_input[] = $prev_arr_value;
                }
            }
           
            $preserve_array = array();
            if (isset($total_row)) {
                foreach ($total_row as $total_key => $total_value) {
                    $prev_id = $this->input->post('prev_id_' . $total_value);

                    if ($prev_id == 0) {
                        $insert_array[] = array(
                            'day'                      => $day,
                            'class_id'                 => $class_id,
                            'section_id'               => $section_id,
                            'subject_group_id'         => $subject_group_id,
                            'subject_group_subject_id' => $this->input->post('subject_' . $total_value),
                            'staff_id'                 => $this->input->post('staff_' . $total_value),
                            'lesson_id'                 => $this->input->post('lesson_' . $total_value),
                            // 'time_from'                => $this->input->post('time_from_' . $total_value),
                            // 'time_to'                  => $this->input->post('time_to_' . $total_value),
                            // 'start_time'               => $this->customlib->timeFormat($this->input->post('time_from_' . $total_value), true),
                            // 'end_time'                 => $this->customlib->timeFormat($this->input->post('time_to_' . $total_value), true),
                            'room_no'                  => $this->input->post('room_no'),
                            'session_id'               => $session,
                        );
                    } else {
                        $preserve_array[] = $prev_id;
                        $update_array[]   = array(
                            'id'                       => $prev_id,
                            'day'                      => $day,
                            'class_id'                 => $class_id,
                            'section_id'               => $section_id,
                            'subject_group_id'         => $subject_group_id,
                            'subject_group_subject_id' => $this->input->post('subject_' . $total_value),
                            'staff_id'                 => $this->input->post('staff_' . $total_value),
                            'lesson_id'                 => $this->input->post('lesson_' . $total_value),
                            // 'time_from'                => $this->input->post('time_from_' . $total_value),
                            // 'time_to'                  => $this->input->post('time_to_' . $total_value),
                            // 'start_time'               => $this->customlib->timeFormat($this->input->post('time_from_' . $total_value), true),
                            // 'end_time'                 => $this->customlib->timeFormat($this->input->post('time_to_' . $total_value), true),
                            'room_no'                  =>$this->input->post('room_no'),
                            'session_id'               => $session,
                        );
                    }
                }
            }
            $delete_array = array_diff($old_input, $preserve_array);

            $result       = $this->subjecttimetable_model->add($delete_array, $insert_array, $update_array);
            if ($result) {
                $json_array = array('status' => '1', 'error' => '', 'message' => $this->lang->line('success_message'));
            } else {
                $json_array = array('status' => '2', 'error' => '', 'message' => $this->lang->line('something_wrong'));
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json_array));
    }

    public function getteachertimetable()
    {
        $json = array();
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('teacher', $this->lang->line('teacher'), 'trim|required');

        if (!$this->form_validation->run()) {
            $json = array(
                'teacher' => form_error('teacher'),
            );

            $json_array = array('status' => '0', 'error' => $json);
        } 
        else 
        {
            $staff_id          = $this->input->post('teacher');
            $data['timetable'] = array();
            $days              = $this->customlib->getDaysname();
            $lesson_timetables = $this->timetable_model->getstafflessontimes($staff_id);

            //print_r();
            //exit();
            
            $data['lesson_timetables'] = [];
            foreach($lesson_timetables as $row)
                $data['lesson_timetables'] [ $row['id'] ] = $row;
            
            $data['days'] = $days;
            foreach ($days as $day_key => $day_value) {
                $data['timetable'][$day_value] = [];
                foreach($this->subjecttimetable_model->getByStaffandDay($staff_id, $day_key) as $row)
                {
                    $data['timetable'][$day_value][ $row->lesson_id ] = $row;
                }
            }
            $data['duplicated_result'] = $this->subjecttimetable_model->validateDuplicatedStaffInAtime($staff_id);
            $timetable_page = $this->load->view('admin/timetable/_partialgetteachertimetable', $data, true);
            $json_array = array('status' => '1', 'error' => '', 'message' => $timetable_page);
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json_array));
    }
    function printTeacherTimeTable(){
        $staff_id          = $this->input->post('staff_id');
        $data['timetable'] = array();
        $days              = $this->customlib->getDaysname();
        $lesson_timetables = $this->timetable_model->getstafflessontimes($staff_id);
        $data['lesson_timetables'] = [];
        foreach($lesson_timetables as $row)
            $data['lesson_timetables'] [ $row['id'] ] = $row;
        $data['days'] = $days;
        $time_table_first_id = 0;
        $time_table_count = 0;
        $min_class_id = 0; $max_class_id = 0;
        $min_section_id = 0; $max_section_id = 0;
        foreach ($days as $day_key => $day_value) {
            $data['timetable'][$day_value] = [];
            foreach($this->subjecttimetable_model->getByStaffandDay($staff_id, $day_key) as $row)
            {
                $data['timetable'][$day_value][ $row->lesson_id ] = $row;
                $time_table_count++;
                if($time_table_first_id == 0){
                    $time_table_first_id = $row->id;
                }
                if($min_class_id == 0 || $min_class_id > $row->class_id){
                    $min_class_id = $row->class_id;
                }
                if($max_class_id == 0 || $max_class_id < $row->class_id){
                    $max_class_id = $row->class_id;
                }
                if($min_section_id == 0 || $min_section_id > $row->section_id){
                    $min_section_id = $row->section_id;
                }
                if($max_section_id == 0 || $max_section_id < $row->section_id){
                    $max_section_id = $row->section_id;
                }
            }
        }
        $data['duplicated_result'] = $this->subjecttimetable_model->validateDuplicatedStaffInAtime($staff_id);
        //$level_data = $this->timetable_model->getLevelNameByStaffId($staff_id);
        //$data['level_name'] = $level_data['level'];
        //print_r($level_data);
        //exit();
        $data['level_name'] = $this->timetable_model->getlevelname($min_class_id);
        $staff_data = $this->staff_model->get($staff_id);
        $data['staff_data'] = $staff_data;
        $subject_data = [];
        if($time_table_first_id != 0) {
            $subject_data = $this->subjecttimetable_model->getSubjectForPrintTeacherTimeTable($time_table_first_id);
        }
        $data['subject_data'] = $subject_data;
        $data['time_table_count'] = $time_table_count;
        if($min_class_id != 0) {
            $data['min_class'] = $this->class_model->getAll($min_class_id);
        }
        if($max_class_id != 0 && $min_class_id != $max_class_id){
            $data['max_class'] = $this->class_model->getAll($max_class_id);
        }
        if($min_section_id != 0) {
            $data['min_section'] = $this->section_model->get($min_section_id);
        }
        if($max_section_id != 0 && $min_section_id != $max_section_id){
            $data['max_section'] = $this->section_model->get($max_section_id);
        }
        
        $timetable_page = $this->load->view('admin/timetable/printteachertimetable', $data, true);
        $json_array = array('status' => '1', 'error' => '', 'page' => $timetable_page);
        echo json_encode($json_array);
    }
    function printAllTeacherTimeTable(){
        $staff_list         = $this->staff_model->getEmployee('2');
        $all_data = [];
        foreach($staff_list as $staff) {
            $data = [];
            $staff_id = $staff['id'];
            $data['staff_id'] = $staff_id;
            $data['timetable'] = array();
            $days              = $this->customlib->getDaysname();
            $lesson_timetables = $this->timetable_model->getstafflessontimes($staff_id);
            $data['lesson_timetables'] = [];
            foreach($lesson_timetables as $row)
                $data['lesson_timetables'] [ $row['id'] ] = $row;
            $data['days'] = $days;
            $time_table_first_id = 0;
            $time_table_count = 0;
            $min_class_id = 0; $max_class_id = 0;
            $min_section_id = 0; $max_section_id = 0;
            foreach ($days as $day_key => $day_value) {
                $data['timetable'][$day_value] = [];
                foreach($this->subjecttimetable_model->getByStaffandDay($staff_id, $day_key) as $row)
                {
                    $data['timetable'][$day_value][ $row->lesson_id ] = $row;
                    $time_table_count++;
                    if($time_table_first_id == 0){
                        $time_table_first_id = $row->id;
                    }
                    if($min_class_id == 0 || $min_class_id > $row->class_id){
                        $min_class_id = $row->class_id;
                    }
                    if($max_class_id == 0 || $max_class_id < $row->class_id){
                        $max_class_id = $row->class_id;
                    }
                    if($min_section_id == 0 || $min_section_id > $row->section_id){
                        $min_section_id = $row->section_id;
                    }
                    if($max_section_id == 0 || $max_section_id < $row->section_id){
                        $max_section_id = $row->section_id;
                    }
                }
            }
            $data['duplicated_result'] = $this->subjecttimetable_model->validateDuplicatedStaffInAtime($staff_id);
            $level_data = $this->timetable_model->getLevelNameByStaffId($staff_id);
            $data['level_name'] = $level_data['level'];
            $staff_data = $this->staff_model->get($staff_id);
            $data['staff_data'] = $staff_data;
            $subject_data = [];
            if($time_table_first_id != 0) {
                $subject_data = $this->subjecttimetable_model->getSubjectForPrintTeacherTimeTable($time_table_first_id);
            }
            $data['subject_data'] = $subject_data;
            $data['time_table_count'] = $time_table_count;
            if($min_class_id != 0) {
                $data['min_class'] = $this->class_model->getAll($min_class_id);
            }
            if($max_class_id != 0 && $min_class_id != $max_class_id){
                $data['max_class'] = $this->class_model->getAll($max_class_id);
            }
            if($min_section_id != 0) {
                $data['min_section'] = $this->section_model->get($min_section_id);
            }
            if($max_section_id != 0 && $min_section_id != $max_section_id){
                $data['max_section'] = $this->section_model->get($max_section_id);
            }
            if(!empty($data['timetable']) && $time_table_first_id > 0){
                $all_data[] = $data;
            }
        }
        $data_ary = [];
        $data_ary['all_data'] = $all_data;
        $timetable_page = $this->load->view('admin/timetable/printallteachertimetable', $data_ary, true);
        $json_array = array('status' => '1', 'error' => '', 'page' => $timetable_page);
        echo json_encode($json_array);
    }

    function allreport()
    {
        // $classlist = $this->class_model->getAll();
        // foreach($classlist as $key=>$class)
        // {
        //     $level_str = "MATUTINO";
        //     $level_id = $this->timetable_model->getlevel_id($class_id);
        //     if(empty($level_id))
        //         $level_id = $this->timetable_model->getinitial_level_id($class_id);
        //     if($this->timetable_model->getclassname($class_id,$level_str) == 0)
        //         $level_str = "VESPERTINO";
        //     $level_name = $this->timetable_model->getlevelname($class_id);
        //     if($level_name != "NIVEL SECUNDARIO")
        //         $level_id = $this->timetable_model->getsub_id($level_id,$level_str);

        //     $lesson_timetables = $this->timetable_model->gettimetable(null,1,$level_id);
        //     $data['lesson_timetables'] = [];
        //     foreach($lesson_timetables as $row)
        //     {
        //         $data['lesson_timetables'][ $row['id'] ] = $row;
        //     }

        // }
    }
    function printclasstimetable()
    {
        $class_id    = $this->input->post('class_id');
        $section_id  = $this->input->post('section_id');
        $data['title']           = 'Exam Schedule';
        $data['subject_id']      = "";
        $data['class_id']        = "";
        $data['section_id']      = "";
        $exam                    = $this->exam_model->get();
        $class                   = $this->class_model->get('', $classteacher = 'yes');
        $data['examlist']        = $exam;
        $data['classlist']       = $class;
        $userdata                = $this->customlib->getUserData();
        $staff                   = $this->staff_model->getStaffbyrole(2);
        $data['staff']           = $staff;
        $data['subject']         = array();
        $feecategory             = $this->feecategory_model->get();
        $data['feecategorylist'] = $feecategory;
        $data['teacher'] = $this->classteacher_model->teacherByClassSection($class_id, $section_id);
        if(isset($class_id))
        {
            $level_name = $this->timetable_model->getlevelname($class_id);
            $name = $this->class_model->get($class_id)['class'];
            $class_name = explode(' ',$name)[0];
            $lesson_type = strtoupper(explode(' ',$name)[1]);
            $section_name = $this->section_model->get($section_id)['section'];
          
            //$level_id = $this->timetable_model->getlevel_ampm($class_id, $section_id);
            $timezone_id = $this->timetable_model->getclsss_lesson_timezone( $class_id ?? 0, $section_id?? 0 );
            $lesson_timetables = $this->timetable_model->gettimetable(null,-100,$timezone_id);
            $data['lesson_timetables'] = [];
            foreach($lesson_timetables as $row)
            {
                $data['lesson_timetables'][ $row['id'] ] = $row;
            }
        }
        $days                   = $this->customlib->getDaysname();
        $data['days']           = $days;
        $data['class_id']       = $class_id;
        $days_record = array();
        $room_no = "";
        foreach ($days as $day_key => $day_value)
        {
            $days_record[$day_key] = [];
            $ClassTimetable = $this->subjecttimetable_model->getSubjectByClassandSectionDay($class_id, $section_id, $day_key);
            if(empty($room_no))
                $room_no = $ClassTimetable[0]->room_no;
            foreach($ClassTimetable as $row)
            {
                $days_record[$day_key][ $row->lesson_id ] = $row;
            }
        }
        $data['timetable'] = $days_record;
        $data['level_name']  = $level_name;
        $data['class_name'] =  $class_name;
        $data['section_name'] =  $section_name;
        $data['lesson_type'] = $lesson_type;
        $data['room_no'] = $room_no;
        // $data['validate_duplicated'] = $this->subjecttimetable_model->validateSubjectCountbyWeek($class_id, $section_id);
        $html = $this->load->view('admin/timetable/printclasstimetable', $data, true);
        $array = array('status' => '1', 'error' => '', 'page' => $html);
        echo json_encode($array);
    }

    public function savetimetable2()
    {
        $class_id           = $this->input->post('class_id');
        $section_id         = $this->input->post('section_id');
        $subject_group_id   = $this->input->post('subject_group_id');
        $timezone_id        = $this->input->post('timezone_id');
        $room_no        = $this->input->post('room_no');
        $timetable_subject  = $_REQUEST['timetable_subject'];
        $timetable_staff    = $_REQUEST['timetable_staff'];

        $result = $this->subjecttimetable_model->getBySubjectGroupClassSection(
            $subject_group_id, $class_id, $section_id
        );
        $oldArray = [];
        foreach($result as $row)
        {
            $oldArray[] = [
                'class_id'          => $class_id,
                'section_id'        => $section_id,
                'subject_group_id'  => $subject_group_id,
                'lesson_id'         => $row->lesson_id,
                'day'               => $row->day,
                'room_no'           => $room_no,
                'staff_id'          => $row->staff_id,
                'subject_group_subject_id'          => $row->subject_group_subject_id,
                'id'                => $row->id,
        ];
        }

        $new_array = [];
        foreach($timetable_subject as $lesson_id=>$row)
            foreach($row as $daykey=>$subject_id)
            {
                if(empty($lesson_id) || empty($subject_id) ) continue;

                $staff_id = $timetable_staff[$lesson_id][$daykey];
                $new_array[] = [
                    'class_id'          => $class_id,
                    'section_id'        => $section_id,
                    'subject_group_id'  => $subject_group_id,
                    'lesson_id'         => $lesson_id,
                    'day'               => $daykey,
                    'room_no'           => $room_no,
                    'staff_id'          => $staff_id,
                    'subject_group_subject_id'          => 
                        $this->subjectgroup_model->get_subjectgroup_subject_id($subject_group_id, $subject_id),
                    'session_id'        => $this->setting_model->getCurrentSession()
                ];
            }

        
        //$insert_array = array_diff($new_array, $oldArray);
        foreach($new_array as $subrow)
        {
            $bIsExist = false;$val = [];
            foreach($oldArray as $row)
            {
                if( $subrow['class_id']==$row['class_id'] &&
                    $subrow['section_id']==$row['section_id'] &&
                    $subrow['section_id']==$row['section_id'] &&
                    $subrow['lesson_id']==$row['lesson_id'] &&
                    $subrow['day']==$row['day'] 
                    )
                    {
                        $bIsExist = true; break;
                    }
            }
            if(!$bIsExist)
            {
                $insert_array[] = $subrow;
            }
        }
       
        $delete_array = [];
        $update_array = [];
        foreach($oldArray as $row)
        {
            $bIsExist = false;
            $val = [];
            foreach($new_array as $subrow)
            {
                if( $subrow['class_id']==$row['class_id'] &&
                    $subrow['section_id']==$row['section_id'] &&
                    $subrow['section_id']==$row['section_id'] &&
                    $subrow['lesson_id']==$row['lesson_id'] &&
                    $subrow['day']==$row['day'] 
                    )
                    {
                        $val['lesson_id']   = $subrow['lesson_id'];
                        $val['day']         = $subrow['day'];
                        $val['staff_id']    = $subrow['staff_id'];
                        $val['subject_group_subject_id']  = $subrow['subject_group_subject_id'];
                        $bIsExist = true; break;
                    }
            }
            //print($bIsExist . "<br>");
            if(!$bIsExist)
            {
                $delete_array[] = $row['id'];
            }
            else
            {
                $row['lesson_id']   = $val['lesson_id'];
                $row['day']         = $val['day'];
                $row['staff_id']    = $val['staff_id'];
                $row['subject_group_subject_id']= $val['subject_group_subject_id'];
                $update_array[]     = $row;
            }
        }
        // print_r($update_array);        
        // print_r($insert_array);        die;

        $result       = $this->subjecttimetable_model->add($delete_array, $insert_array, $update_array);
        // $data['timetable_subjects'] = [];
        // $ClassTietable = $this->subjecttimetable_model->getSubjectByClassandSection($class_id, $section_id);

        //redirect('admin/timetable/create');
    }
}
