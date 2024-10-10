<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User extends Student_Controller
{

    public $school_name;
    public $school_setting;
    public $setting;
    public $payment_method;

    public function __construct()
    {
        parent::__construct();
        $this->payment_method     = $this->paymentsetting_model->getActiveMethod();
        $this->sch_current_session = $this->setting_model->getCurrentSession();
        $this->sch_setting_detail = $this->setting_model->getSetting();
        $this->load->model("student_edit_field_model");
        $this->config->load('mailsms');
        $this->load->model('Gradingreport_model');
        $this->load->model('Studentsession_model');
        $this->load->model('subjectgroup_model');
        $this->load->model('staff_model');
        $this->load->model('Studentsession_model');
        $this->load->model('Level_model');
    }

    public function unauthorized()
    {
        $data = array();
        $this->load->view('layout/student/header');
        $this->load->view('unauthorized', $data);
        $this->load->view('layout/student/footer');
    }

    public function choose()
    {
        if ($this->session->has_userdata('current_class')) {

            redirect('user/user/dashboard');
        }
        $data['sch_setting']      = $this->sch_setting_detail;
        $role                     = $this->customlib->getUserRole();
        $data['role']             = $role;
        $student_current_class    = array();
        $default_login_student_id = "";
        if ($role == "student") {
            $student_id            = $this->customlib->getStudentSessionUserID();
            $data['student_lists'] = $this->studentsession_model->searchMultiClsSectionByStudent($student_id);
            if ($data['student_lists'][0]->default_login) {
                $default_login_student_id = $data['student_lists'][0]->student_id;
                $student_current_class    = array('class_id' => $data['student_lists'][0]->class_id, 'section_id' => $data['student_lists'][0]->section_id, 'student_session_id' => $data['student_lists'][0]->student_session_id);
            }
        } elseif ($role == "parent") {
            $parent_id             = $this->customlib->getUsersID();
            $data['student_lists'] = $this->student_model->getParentChilds($parent_id);
            if ($data['student_lists'][0]->default_login) {
                $default_login_student_id = $data['student_lists'][0]->id;
                $student_current_class    = array('class_id' => $data['student_lists'][0]->class_id, 'section_id' => $data['student_lists'][0]->section_id, 'student_session_id' => $data['student_lists'][0]->student_session_id);
            }
        }
        if (!empty($student_current_class)) {
           
            $logged_In_User               = $this->customlib->getLoggedInUserData();
            $logged_In_User['student_id'] = $default_login_student_id;
            $this->session->set_userdata('student', $logged_In_User);
            $this->session->set_userdata('current_class', $student_current_class);
             redirect('user/user/dashboard');
        }

        $this->form_validation->set_rules('clschg', $this->lang->line('select') . " " . $this->lang->line('class'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == true) {
            $student_session_id           = $this->input->post('clschg');
            $student                      = $this->student_model->getByStudentSession($student_session_id);
            $logged_In_User               = $this->customlib->getLoggedInUserData();
            $logged_In_User['student_id'] = $student['id'];
            $this->session->set_userdata('student', $logged_In_User);
            $this->studentsession_model->updateById(array('id'=>$student_session_id,'default_login'=>1));
            $student_current_class = array('class_id' => $student['class_id'], 'section_id' => $student['section_id'], 'student_session_id' => $student['student_session_id']);
            $this->session->set_userdata('current_class', $student_current_class);   
            redirect('user/user/dashboard');
        }

        $this->load->view('user/choose', $data);

    }

    public function dashboard()
    {
        $this->session->set_userdata('top_menu', 'Dashboard');
        $student_id            = $this->customlib->getStudentSessionUserID();
        $student_current_class = $this->customlib->getStudentCurrentClsSection();
        $student = $this->student_model->getStudentByClassSectionID($student_current_class->class_id, $student_current_class->section_id, $student_id);
        $data = array();
        $period_id = $this->input->post('period_id');
        if (!empty($student)) {

            $student_session_id           = $student_current_class->student_session_id;
            $gradeList                    = $this->grade_model->get();
            $student_due_fee              = $this->studentfeemaster_model->getStudentFees($student_session_id);
            $student_discount_fee         = $this->feediscount_model->getStudentFeesDiscount($student_session_id);
            $data['student_discount_fee'] = $student_discount_fee;
            $data['student_due_fee']      = $student_due_fee;
            $timeline                     = $this->timeline_model->getStudentTimeline($student["id"], $status = 'yes');
            $data["timeline_list"]        = $timeline;
            $data['sch_setting']          = $this->sch_setting_detail;
            $data['adm_auto_insert']      = $this->sch_setting_detail->adm_auto_insert;
            $data['examSchedule']         = array();
            $data['exam_result']          = $this->examgroupstudent_model->searchStudentExams($student['student_session_id'], true, true);
            $ss                           = $this->grade_model->getGradeDetails();
            $data['exam_grade']           = $this->grade_model->getGradeDetails();
            $student_doc                  = $this->student_model->getstudentdoc($student_id);
            $data['student_doc']          = $student_doc;
            $data['student_doc_id']       = $student_id;
            $category_list                = $this->category_model->get();
            $data['category_list']        = $category_list;
            $data['gradeList']            = $gradeList;
            $data['student']              = $student;

            $student_session_id = $student['student_session_id'];

            $class_level = $this->Gradingreport_model->getClassByStudent_session_id($student_session_id);
            $data['observationeditable'] = true;
            $data['student_session_id'] = $student_session_id;
            $data['class_id']  = $class_level['class_id'];
            $data['class']        = $class_level['class'];
            $data['level_id']  = $class_level['level_id'];
            $data['level']        = $class_level['level'];
            $data['observation'] = $this->Gradingreport_model->getStudentObservations($student_session_id);
            $period_list = $this->Gradingreport_model->getPeriodByLevel($data['level_id']);
            $data['periodList'] = $period_list;
            $data['isPrekender'] = $class_level['level_id'] != 43 ? true : false;
            $data['is_primary'] = $class_level['level_id'] == 42 ? true : false;
            
            if (!$data['isPrekender'] && !$data['is_primary']) {

                $subjects = array();

                $subject_groups = $this->subjectgroup_model->getGroupByClassandSection($student['class_id'], $student['section_id']);

                foreach ($subject_groups as $subject_group) {

                    $groupsubjects = $this->subjectgroup_model->getGroupsubjects($subject_group['subject_group_id']);

                    array_splice($subjects, count($subjects), 0, $groupsubjects);
                }

                $grading_subject_results = array();
                $admin_session   = $this->session->userdata('admin');
                $permission = $this->staff_model->get_permission($admin_session['id']);
                $role = $this->customlib->getStaffRole();

                $role_id = json_decode($role)->id;
                //$permission_staff_ids = $this->staff_model->getpermission('Permission of Teachers');
                $data['role_id'] = $role_id;
                $addstep = 0;
                $teacherCnt = 0;
                foreach ($subjects as $subject) {
                    $result = $this->Gradingreport_model->getNewReportByStudentAndSubject($student_session_id, $subject->id);
                    $row = array();
                    $row['subject'] = $subject->name;
                    $row['subjectId'] = $subject->id;
                    $row['period_results'] = array();
                    $row['period_resultsRP'] = array();
                    $edit_flag = [];
                    if (!empty($result)) {
                        $row['reportId'] = $result['id'];
                        $update_date = [];
                        $update_date[] = $result['update_date_p11'];
                        $update_date[] = $result['update_date_p12'];
                        $update_date[] = $result['update_date_p13'];
                        $update_date[] = $result['update_date_p14'];
                        $row['period_results'][] = $result['p11'];
                        $row['period_results'][] = $result['p12'];
                        $row['period_results'][] = $result['p13'];
                        $row['period_results'][] = $result['p14'];
                        $row['period_results'][] = $result['p21'];
                        $row['period_results'][] = $result['p22'];
                        $row['period_results'][] = $result['p23'];
                        $row['period_results'][] = $result['p24'];
                        $row['period_results'][] = $result['p31'];
                        $row['period_results'][] = $result['p32'];
                        $row['period_results'][] = $result['p33'];
                        $row['period_results'][] = $result['p34'];
                        $row['period_results'][] = $result['p41'];
                        $row['period_results'][] = $result['p42'];
                        $row['period_results'][] = $result['p43'];
                        $row['period_results'][] = $result['p44'];

                        $row['period_resultsRP'][] = $result['rp11'];
                        $row['period_resultsRP'][] = $result['rp12'];
                        $row['period_resultsRP'][] = $result['rp13'];
                        $row['period_resultsRP'][] = $result['rp14'];
                        $row['period_resultsRP'][] = $result['rp21'];
                        $row['period_resultsRP'][] = $result['rp22'];
                        $row['period_resultsRP'][] = $result['rp23'];
                        $row['period_resultsRP'][] = $result['rp24'];
                        $row['period_resultsRP'][] = $result['rp31'];
                        $row['period_resultsRP'][] = $result['rp32'];
                        $row['period_resultsRP'][] = $result['rp33'];
                        $row['period_resultsRP'][] = $result['rp34'];
                        $row['period_resultsRP'][] = $result['rp41'];
                        $row['period_resultsRP'][] = $result['rp42'];
                        $row['period_resultsRP'][] = $result['rp43'];
                        $row['period_resultsRP'][] = $result['rp44'];

                        $pc1 = 0;
                        $pc2 = 0;
                        $pc3 = 0;
                        $pc4 = 0;
                        $flag1 = 0;
                        $flag2 = 0;
                        $flag3 = 0;
                        $flag4 = 0;
                        for ($i = 0; $i < 4; $i++) {
                            if ($row['period_results'][$i] < 70) $pc1 = $pc1 + $row['period_resultsRP'][$i] / 4;
                            else $pc1 = $pc1 + $row['period_results'][$i] / 4;
                            if ($row['period_results'][$i + 4] < 70) $pc2 = $pc2 + $row['period_resultsRP'][$i + 4] / 4;
                            else $pc2 = $pc2 + $row['period_results'][$i + 4] / 4;
                            if ($row['period_results'][$i + 8] < 70) $pc3 = $pc3 + $row['period_resultsRP'][$i + 8] / 4;
                            else $pc3 = $pc3 + $row['period_results'][$i + 8] / 4;
                            if ($row['period_results'][$i + 12] < 70) $pc4 = $pc4 + $row['period_resultsRP'][$i + 12] / 4;
                            else $pc4 = $pc4 + $row['period_results'][$i + 12] / 4;
                            if (!$row['period_resultsRP'][$i] && $row['period_results'][$i] < 70) $flag1 = 1;
                            if (!$row['period_resultsRP'][$i + 4] && $row['period_results'][$i + 4] < 70) $flag2 = 1;
                            if (!$row['period_resultsRP'][$i + 8] && $row['period_results'][$i + 8] < 70) $flag3 = 1;
                            if (!$row['period_resultsRP'][$i + 12] && $row['period_results'][$i + 12] < 70) $flag4 = 1;
                        }

                        if ($flag1 == 1) $pc_show1 = "";
                        else $pc_show1 = round($pc1, 1);
                        if ($flag2 == 1) $pc_show2 = "";
                        else $pc_show2 = round($pc2, 1);
                        if ($flag3 == 1) $pc_show3 = "";
                        else $pc_show3 = round($pc3, 1);
                        if ($flag4 == 1) $pc_show4 = "";
                        else $pc_show4 = round($pc4, 1);

                        $row['period_results'][] = $pc_show1;
                        $row['period_results'][] = $pc_show2;
                        $row['period_results'][] = $pc_show3;
                        $row['period_results'][] = $pc_show4;
                        $date = date("Y-m-d");
                        if($role_id == 2)   // if Teacher is,
                        {
                            for($i = 0; $i < count($update_date);$i++)
                            {
                                $edit_flag[$i] = 0;
                                if(substr($permission,$i,1) == 1)
                                {
                                    $edit_flag[$i] = 1;
                                    continue;
                                }
                                if(substr($student['class'],0,1) == ($i + 1))
                                {
                                    if($update_date[$i] == $date or $update_date[$i] == null)
                                        $edit_flag[$i] = 1;
                                }
                            }
                        }
                        else
                        {
                            for($i = 0; $i < count($update_date);$i++)
                                $edit_flag[$i] = 1;
                        }
                    } else {
                        $row['reportId'] = null;
                        $row['period_results'] = [null, null, null, null, null];
                        for($i = 0; $i < 5;$i++)
                            $edit_flag[$i] = 1;
                    }
                    $row['edit_flag'] = $edit_flag;
                    $row['CF'] = 0;
                    $i = 0;
                    if ($pc1 && $pc2 && $pc3 && $pc4 && $pc_show1 && $pc_show2 && $pc_show3 && $pc_show4) $row['CF'] = round(($pc1 + $pc2 + $pc3 + $pc4) / 4);
                    $row['AA'] = '';
                    $row['50PCP'] = '';
                    $row['CPC'] = '';
                    $row['50CPC'] = '';
                    $row['CC'] = '';
                    $row['30PCP'] = '';
                    $row['CPEX'] = '';
                    $row['70CPEX'] = '';
                    $row['CEX'] = '';
                    $row['O1'] = '';
                    $row['O2'] = '';
                    $row['A'] = '';
                    $row['R'] = '';
                    $row['add'] = '';
                    if (empty($row['CF'])) {
                        $row['CF'] = '';
                    } else {
                        $row['CF'] = round($row['CF']);
                        if ($row['CF'] >= 70) {
                            $row['A'] = 'A';
                            $row['R'] = '';
                        } else {
                            $row['A'] = '';
                            $row['R'] = 'R';
                            if (empty($addstep)) {
                                $addstep = 1;
                            }
                            $row['add'] = 'cpc';
                            if (!empty($result) && !empty($result['CPC'])) {
                                $row['50PCP'] = round($row['CF'] / 2);
                                $row['CPC'] = $result['CPC'];
                                $row['50CPC'] = round($result['CPC'] / 2);
                                $row['CC'] = $row['50PCP'] + $row['50CPC'];
                                if ($row['CC'] >= 70) {
                                    $row['A'] = 'A';
                                    $row['R'] = '';
                                } else {
                                    $row['add'] = 'cpex';
                                    $addstep = 2;
                                    if (!empty($result) && !empty($result['CPEX'])) {
                                        $row['30PCP'] = round($row['CF'] * 0.3);
                                        $row['CPEX'] = $result['CPEX'];
                                        $row['70CPEX'] = round($result['CPEX'] * 0.7);
                                        $row['CEX'] = $row['30PCP'] + $row['70CPEX'];
                                        if ($row['CEX'] >= 70) {
                                            $row['A'] = 'A';
                                            $row['R'] = '';
                                        } else {
                                            $row['O1'] = '';
                                            $row['O2'] = '';
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $grading_subject_results[] = $row;
                    $teacherCnt++;
                }
                $data['addstep'] = $addstep;
                $data['grading_subject_results'] = $grading_subject_results;

            }
            else if($data['is_primary']){

                $subjects = array();

                $subject_groups = $this->subjectgroup_model->getGroupByClassandSection($student['class_id'], $student['section_id']);

                foreach ($subject_groups as $subject_group) {

                    $groupsubjects = $this->subjectgroup_model->getGroupsubjects($subject_group['subject_group_id']);

                    array_splice($subjects, count($subjects), 0, $groupsubjects);
                }

                $grading_subject_results = array();
                $admin_session   = $this->session->userdata('admin');
                $permission = $this->staff_model->get_permission($admin_session['id']);
                $role = $this->customlib->getStaffRole();

                $role_id = json_decode($role)->id;
                //$permission_staff_ids = $this->staff_model->getpermission('Permission of Teachers');
                $data['role_id'] = $role_id;
                $addstep = 0;
                $teacherCnt = 0;
                $pc1 = 0;
                $pc2 = 0;
                $pc3 = 0;
                foreach ($subjects as $subject) {
                    $result = $this->Gradingreport_model->getNewReportByStudentAndSubject($student_session_id, $subject->id);
                    $row = array();
                    $row['subject'] = $subject->name;
                    $row['subjectId'] = $subject->id;
                    $row['period_results'] = array();
                    $row['period_resultsRP'] = array();
                    $edit_flag = [];
                    $pc1 = 0;
                    $pc2 = 0;
                    $pc3 = 0;
                    $row['CF1'] = 0;
                    $row['CF2'] = 0;
                    if (!empty($result)) {
                        $row['reportId'] = $result['id'];
                        $update_date = [];
                        $update_date[] = $result['update_date_p11'];
                        $update_date[] = $result['update_date_p12'];
                        $update_date[] = $result['update_date_p13'];
                        $update_date[] = $result['update_date_p14'];
                        $row['period_results'][] = $result['p11'];
                        $row['period_results'][] = $result['p12'];
                        $row['period_results'][] = $result['p13'];
                        $row['period_results'][] = $result['p14'];
                        $row['period_results'][] = $result['p21'];
                        $row['period_results'][] = $result['p22'];
                        $row['period_results'][] = $result['p23'];
                        $row['period_results'][] = $result['p24'];
                        $row['period_results'][] = $result['p31'];
                        $row['period_results'][] = $result['p32'];
                        $row['period_results'][] = $result['p33'];
                        $row['period_results'][] = $result['p34'];

                        $row['period_resultsRP'][] = $result['rp11'];
                        $row['period_resultsRP'][] = $result['rp12'];
                        $row['period_resultsRP'][] = $result['rp13'];
                        $row['period_resultsRP'][] = $result['rp14'];
                        $row['period_resultsRP'][] = $result['rp21'];
                        $row['period_resultsRP'][] = $result['rp22'];
                        $row['period_resultsRP'][] = $result['rp23'];
                        $row['period_resultsRP'][] = $result['rp24'];
                        $row['period_resultsRP'][] = $result['rp31'];
                        $row['period_resultsRP'][] = $result['rp32'];
                        $row['period_resultsRP'][] = $result['rp33'];
                        $row['period_resultsRP'][] = $result['rp34'];

                        $row['CF1'] = $result['cf1'];
                        $row['CF2'] = $result['cf2'];
                        $flag1 = 0;
                        $flag2 = 0;
                        $flag3 = 0;
                        for ($i = 0; $i < 4; $i++) {
                            if ($row['period_results'][$i] < 65 && $row['period_resultsRP'][$i]) $pc1 = $pc1 + $row['period_resultsRP'][$i] / 4;
                            else $pc1 = $pc1 + $row['period_results'][$i] / 4;
                            if ($row['period_results'][$i + 4] < 65 && $row['period_resultsRP'][$i + 4]) $pc2 = $pc2 + $row['period_resultsRP'][$i + 4] / 4;
                            else $pc2 = $pc2 + $row['period_results'][$i + 4] / 4;
                            if ($row['period_results'][$i + 8] < 65 && $row['period_resultsRP'][$i + 8]) $pc3 = $pc3 + $row['period_resultsRP'][$i + 8] / 4;
                            else $pc3 = $pc3 + $row['period_results'][$i + 8] / 4;
                            if (!$row['period_results'][$i]) $flag1 = 1;
                            if (!$row['period_results'][$i + 4]) $flag2 = 1;
                            if (!$row['period_results'][$i + 8]) $flag3 = 1;
                        }
                        // show pdf reports result for primary
                        if ($flag1 == 1) $pc_show1 = "";
                        else $pc_show1 = round($pc1);
                        if ($flag2 == 1) $pc_show2 = "";
                        else $pc_show2 = round($pc2);
                        if ($flag3 == 1) $pc_show3 = "";
                        else $pc_show3 = round($pc3);

                        $row['period_results'][] = $pc_show1;
                        $row['period_results'][] = $pc_show2;
                        $row['period_results'][] = $pc_show3;
                        $date = date("Y-m-d");
                        if($role_id == 2)   // if Teacher is,
                        {
                            for($i = 0; $i < count($update_date);$i++)
                            {
                                $edit_flag[$i] = 0;
                                if(substr($permission,$i,1) == 1)
                                {
                                    $edit_flag[$i] = 1;
                                    continue;
                                }
                                if(substr($student['class'],0,1) == ($i + 1))
                                {
                                    if($update_date[$i] == $date or $update_date[$i] == null)
                                        $edit_flag[$i] = 1;
                                }
                            }
                        }
                        else
                        {
                            for($i = 0; $i < count($update_date);$i++)
                                $edit_flag[$i] = 1;
                        }
                    } else {
                        $row['reportId'] = null;
                        $row['period_results'] = [null, null, null, null, null];
                        for($i = 0; $i < 5;$i++)
                            $edit_flag[$i] = 1;
                    }
                    $row['edit_flag'] = $edit_flag;
                    $row['CF'] = 0;
                    $i = 0;
                    if ($pc1 && $pc2 && $pc3 && $pc_show1 && $pc_show2 && $pc_show3) $row['CF'] = round(($pc1 + $pc2 + $pc3) / 3);
                    $grading_subject_results[] = $row;
                    $teacherCnt++;
                }
                $data['addstep'] = $addstep;
                $data['grading_subject_results'] = $grading_subject_results;
            }
            else {
                if (!empty($data['class_id'])) {

                    $data['period_id'] = '';
                    if (!empty($period_id)) {
                        $data['period_id'] = $period_id;
                    }

                    $competences = $this->Gradingreport_model->getCompetences($this->sch_current_session, $data['class_id'], $period_id);
                    $data['competenceList'] = array();
                    foreach ($competences as $competence) {
                        $reportdata = $this->Gradingreport_model->getCompetenceReport($competence['id'], $student_session_id);
                        $competence['data'] = $reportdata;
                        $data['competenceList'][] = $competence;
                    }
                    $valuescale = $this->Gradingreport_model->getValuescaleByClass($data['level_id']);
                    $data['valuescaleList'] = $valuescale;
                }
            }

        }

        $unread_notifications = $this->notification_model->getUnreadStudentNotification();

        $notification_bydate = array();

        foreach ($unread_notifications as $unread_notifications_key => $unread_notifications_value) {
            if (date($this->customlib->getSchoolDateFormat()) >= date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($unread_notifications_value->publish_date))) {
                $notification_bydate[] = $unread_notifications_value;
            }
        }
        $data['unread_notifications'] = $notification_bydate;
        $this->load->view('layout/student/header', $data);
        $this->load->view('user/dashboard', $data);
        $this->load->view('layout/student/footer', $data);
    }

    public function printCard()
    {
        $id = $this->input->post('id');
        $period_id = $this->input->post('period_id');
        $this->session->userdata['pageNum'] = 1;
        if (!empty($id))
        {
            $studentList = array();
            $student = $this->student_model->get($id);
            $studentList[] = $student;
            $renderprintpage = '';
            $Cnt = 0;

            foreach ($studentList as $student) {
                $Cnt++;
                $data = array();
                $data['student']  = $student;
                $student_session_id = $student['student_session_id'];
                $class_level = $this->Gradingreport_model->getClassByStudent_session_id($student_session_id);
                $data['order_number'] = $this->Gradingreport_model->getStudentOrderNumber($student['class_id'], $student['section_id'], $student_session_id);
                $data['student_session_id'] = $student_session_id;
                $data['class_id']  = $class_level['class_id'];
                $data['class']        = $class_level['class'];
                $data['level_id']  =  $class_level['level_id'];
                $data['observation'] = $this->Gradingreport_model->getStudentObservations($student_session_id);
                $data['period_id'] = $period_id;
                $data['level_coordinator'] = '';
                $level = $this->Level_model->getLevelList($data['level_id']);
                if (!empty($level['coordinator_id'])) {
                    $level_coordinator = $this->staff_model->get_StaffNameById($level['coordinator_id']);
                    $data['level_coordinator'] = $level_coordinator['name'];
                }
                $data['school_director'] = '';
                $school_director = $this->staff_model->getStaffbyrole(9);
                if (!empty($school_director)) {
                    $data['school_director'] = $school_director[0]['name'] . " " . $school_director[0]['surname'];
                }

                $data['class_teacher'] = '';
                $classteachers = $this->classteacher_model->teacherByClassSection($data['class_id'], $student['section_id']);
                if (!empty($classteachers)) {
                    $data['class_teacher'] = $classteachers[0]['name'] . " " . $classteachers[0]['surname'];
                }
                $data['level']        = $class_level['level'];
                $data['session']  = $this->setting_model->getCurrentSessionName();
                $period_list = $this->Gradingreport_model->getPeriodByLevel($data['level_id']);

                $data['periodList'] = $period_list;
                $monthlist = $this->customlib->getMonthDropdown();
                if($this->session->userdata['admin']['language']['language'] == 'English')
                {
                    $month['January'] = "enero";
                    $month['February'] = "febrero";
                    $month['March'] = "marzo";
                    $month['April'] = "abril";
                    $month['May'] = "Mayo";
                    $month['June'] = "junio";
                    $month['July'] = "julio";
                    $month['August'] = "agosto";
                    $month['September'] = "septiembre";
                    $month['October'] = "octubre";
                    $month['November'] = "noviembre";
                    $month['December'] = "diciembre";
                    $data['monthlist'] = $month;
                }
                else
                {
                    $data['monthlist'] = $monthlist;
                }

                $data['sch_setting'] = $this->sch_setting_detail;
                $data['isPrekender'] = $class_level['level_id'] != 43 ? true : false;

                if ($data['isPrekender']) {
                    $data['competenceList'] = array();
                    $data['indicatorsList'] = array();

                    foreach ($period_list as $period) {
                        $competences = $this->Gradingreport_model->getCompetences($this->sch_current_session, $data['class_id'], $period['id']);
                        foreach ($competences as $competence) {
                            $indicators = $this->Gradingreport_model->getCompetenceReport($competence['id'], $student_session_id);
                            $data['indicatorsList'][$competence['id']] = $indicators;
                        }
                        $data['competenceList'][$period['id']] = $competences;
                    }
                    if($student['level'] == "NIVEL PRIMARIO")
                        $class_id = $data['level_id'];
                    else
                        $class_id = 3;

                    $valuescale = $this->Gradingreport_model->getValuescaleByClass($class_id);
                    $data['valuescaleList'] = $valuescale;
                    $student_admit_cards = $this->load->view('user/reportview', $data, true);
                    $renderprintpage .= " ". $student_admit_cards. " ";
                }
                else
                {
                    $subjects = array();
                    $subject_groups = $this->subjectgroup_model->getGroupByClassandSection($student['class_id'], $student['section_id']);
                    foreach ($subject_groups as $subject_group) {
                        $groupsubjects = $this->subjectgroup_model->getGroupsubjects($subject_group['subject_group_id']);
                        array_splice($subjects, count($subjects), 0, $groupsubjects);
                    }
                    $grading_subject_results = array();
                    foreach ($subjects as $subject) {
                        $result = $this->Gradingreport_model->getReportByStudentAndSubject($student_session_id, $subject->id);
                        $row = array();
                        $row['subject'] = $subject->name;
                        $row['period_results'] = array();
                        if (!empty($result)) {
                            $row['reportId'] = $result['id'];
                            $row['period_results'][] = $result['p1'];
                            $row['period_results'][] = $result['p2'];
                            $row['period_results'][] = $result['p3'];
                            $row['period_results'][] = $result['p4'];
                            $row['period_results'][] = $result['p5'];
                        } else {
                            $row['reportId'] = null;
                            $row['period_results'] = [null, null, null, null, null];
                        }

                        $row['CF'] = "";
                        for ($i = 0; $i < count($period_list); $i++) {
                            if (empty($row['period_results'][$i])) {
                                $row['CF'] = '';
                                break;
                            } else {
                                $row['CF'] += $row['period_results'][$i] / count($period_list);
                            }
                        }

                        $row['AA'] = '';
                        $row['50PCP'] = '';
                        $row['CPC'] = '';
                        $row['50CPC'] = '';
                        $row['CC'] = '';
                        $row['30PCP'] = '';
                        $row['CPEX'] = '';
                        $row['70CPEX'] = '';
                        $row['CEX'] = '';
                        $row['O1'] = '';
                        $row['O2'] = '';
                        $row['A'] = '';
                        $row['R'] = '';
                        $row['add'] = '';
                        if (empty($row['CF'])) {
                            $row['CF'] = '';
                        } else {
                            $row['CF'] = round($row['CF']);
                            if ($row['CF'] > 70) {
                                $row['A'] = 'A';
                                $row['R'] = '';
                            } else {
                                $row['A'] = '';
                                $row['R'] = 'R';
                                if (empty($addstep)) {
                                    $addstep = 1;
                                }
                                $row['add'] = 'cpc';
                                if (!empty($result) && !empty($result['CPC'])) {
                                    $row['50PCP'] = round($row['CF'] / 2);
                                    $row['CPC'] = $result['CPC'];
                                    $row['50CPC'] = round($result['CPC'] / 2);
                                    $row['CC'] = $row['50PCP'] + $row['50CPC'];
                                    if ($row['CC'] > 70) {
                                        $row['A'] = 'A';
                                        $row['R'] = '';
                                    } else {
                                        $row['add'] = 'cpex';
                                        $addstep = 2;
                                        if (!empty($result) && !empty($result['CPEX'])) {
                                            $row['30PCP'] = round($row['CF'] * 0.3);
                                            $row['CPEX'] = $result['CPEX'];
                                            $row['70CPEX'] = round($result['CPEX'] * 0.7);
                                            $row['CEX'] = $row['30PCP'] + $row['70CPEX'];
                                            if ($row['CEX'] > 70) {
                                                $row['A'] = 'A';
                                                $row['R'] = '';
                                            } else {
                                                $row['O1'] = '';
                                                $row['O2'] = '';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $grading_subject_results[] = $row;
                    }
                    $data['pageNum'] = $this->session->userdata['pageNum'];
                    $data['grading_subject_results'] = $grading_subject_results;
                    $seconday_grading_report_cards = $this->load->view('user/_secondaryreportview', $data, true);
                    $renderprintpage .= " ". $seconday_grading_report_cards. " ";
                }
            }
            $array = array('status' => '1', 'error' => '', 'page' => $renderprintpage);
            echo json_encode($array);
        }
    }

    public function changepass()
    {
        $data['title'] = 'Change Password';
        $this->form_validation->set_rules('current_pass', 'Current password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('new_pass', 'New password', 'trim|required|xss_clean|matches[confirm_pass]');
        $this->form_validation->set_rules('confirm_pass', 'Confirm password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $sessionData            = $this->session->userdata('loggedIn');
            $this->data['id']       = $sessionData['id'];
            $this->data['username'] = $sessionData['username'];
            $this->load->view('layout/student/header', $data);
            $this->load->view('user/change_password', $data);
            $this->load->view('layout/student/footer', $data);
        } else {
            $sessionData = $this->session->userdata('student');
            $data_array  = array(
                'current_pass' => ($this->input->post('current_pass')),
                'new_pass'     => ($this->input->post('new_pass')),
                'user_id'      => $sessionData['id'],
                'user_name'    => $sessionData['username'],
            );
            $newdata = array(
                'id'       => $sessionData['id'],
                'password' => $this->input->post('new_pass'),
            );
            $query1 = $this->user_model->checkOldPass($data_array);
            if ($query1) {
                $query2 = $this->user_model->saveNewPass($newdata);
                if ($query2) {

                    $this->session->set_flashdata('success_msg', 'Password changed successfully');
                    $this->load->view('layout/student/header', $data);
                    $this->load->view('user/change_password', $data);
                    $this->load->view('layout/student/footer', $data);
                }
            } else {

                $this->session->set_flashdata('error_msg', 'Invalid current password');
                $this->load->view('layout/student/header', $data);
                $this->load->view('user/change_password', $data);
                $this->load->view('layout/student/footer', $data);
            }
        }
    }

    public function changeusername()
    {
        $sessionData = $this->customlib->getLoggedInUserData();

        $data['title'] = 'Change Username';
        $this->form_validation->set_rules('current_username', 'Current username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('new_username', 'New username', 'trim|required|xss_clean|matches[confirm_username]');
        $this->form_validation->set_rules('confirm_username', 'Confirm username', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {

        } else {

            $data_array = array(
                'username'     => $this->input->post('current_username'),
                'new_username' => $this->input->post('new_username'),
                'role'         => $sessionData['role'],
                'user_id'      => $sessionData['id'],
            );
            $newdata = array(
                'id'       => $sessionData['id'],
                'username' => $this->input->post('new_username'),
            );
            $is_valid = $this->user_model->checkOldUsername($data_array);

            if ($is_valid) {
                $is_exists = $this->user_model->checkUserNameExist($data_array);
                if (!$is_exists) {
                    $is_updated = $this->user_model->saveNewUsername($newdata);
                    if ($is_updated) {
                        $this->session->set_flashdata('success_msg', 'Username changed successfully');
                        redirect('user/user/changeusername');
                    }
                } else {
                    $this->session->set_flashdata('error_msg', 'Username Already Exists, Please choose other');
                }
            } else {
                $this->session->set_flashdata('error_msg', 'Invalid current username');
            }
        }
        $this->data['id']       = $sessionData['id'];
        $this->data['username'] = $sessionData['username'];
        $this->load->view('layout/student/header', $data);
        $this->load->view('user/change_username', $data);
        $this->load->view('layout/student/footer', $data);
    }

    public function download($student_id, $doc)
    {
        $this->load->helper('download');
        $filepath = "./uploads/student_documents/$student_id/" . $this->uri->segment(5);
        $data     = file_get_contents($filepath);
        $name     = $this->uri->segment(6);
        force_download($name, $data);
    }

    public function user_language($lang_id)
    {
        $language_name = $this->db->select('languages.language')->from('languages')->where('id', $lang_id)->get()->row_array();
        $student       = $this->session->userdata('student');
        if (!empty($student)) {
            $this->session->unset_userdata('student');
        }
        $language_array      = array('lang_id' => $lang_id, 'language' => $language_name['language']);
        $student['language'] = $language_array;
        $this->session->set_userdata('student', $student);

        $session         = $this->session->userdata('student');
        $id              = $session['student_id'];
        $data['lang_id'] = $lang_id;
        $language_result = $this->language_model->set_studentlang($id, $data);
    }

    public function timeline_download($timeline_id, $doc)
    {
        $this->load->helper('download');
        $filepath = "./uploads/student_timeline/" . $doc;
        $data     = file_get_contents($filepath);
        $name     = $doc;
        force_download($name, $data);
    }

    public function view($id)
    {
        $data['title']           = 'Student Details';
        $student                 = $this->student_model->get($id);
        $student_due_fee         = $this->studentfee_model->getDueFeeBystudent($student['class_id'], $student['section_id'], $id);
        $data['student_due_fee'] = $student_due_fee;
        $transport_fee           = $this->studenttransportfee_model->getTransportFeeByStudent($student['student_session_id']);
        $data['transport_fee']   = $transport_fee;
        $examList                = $this->examschedule_model->getExamByClassandSection($student['class_id'], $student['section_id']);
        $data['examSchedule']    = array();
        if (!empty($examList)) {
            $new_array = array();
            foreach ($examList as $ex_key => $ex_value) {
                $array         = array();
                $x             = array();
                $exam_id       = $ex_value['exam_id'];
                $exam_subjects = $this->examschedule_model->getresultByStudentandExam($exam_id, $student['id']);
                foreach ($exam_subjects as $key => $value) {
                    $exam_array                     = array();
                    $exam_array['exam_schedule_id'] = $value['exam_schedule_id'];
                    $exam_array['exam_id']          = $value['exam_id'];
                    $exam_array['full_marks']       = $value['full_marks'];
                    $exam_array['passing_marks']    = $value['passing_marks'];
                    $exam_array['exam_name']        = $value['name'];
                    $exam_array['exam_type']        = $value['type'];
                    $exam_array['attendence']       = $value['attendence'];
                    $exam_array['get_marks']        = $value['get_marks'];
                    $x[]                            = $exam_array;
                }
                $array['exam_name']   = $ex_value['exam_name'];
                $array['exam_result'] = $x;
                $new_array[]          = $array;
            }
            $data['examSchedule'] = $new_array;
        }
        return $data['student'] = $student;
    }

    public function getfees()
    {

        $id                    = $this->customlib->getStudentSessionUserID();
        $student_current_class = $this->customlib->getStudentCurrentClsSection();

        $this->session->set_userdata('top_menu', 'fees');
        $this->session->set_userdata('sub_menu', 'student/getFees');
        $category                = $this->category_model->get();
        $data['categorylist']    = $category;
        $data['sch_setting']     = $this->sch_setting_detail;
        $data['adm_auto_insert'] = $this->sch_setting_detail->adm_auto_insert;
        $paymentoption           = $this->customlib->checkPaypalDisplay();
        $data['paymentoption']   = $paymentoption;
        $data['payment_method']  = false;
        if (!empty($this->payment_method)) {
            $data['payment_method'] = true;
        }
        $student_id                   = $id;
        $student                      = $this->student_model->getStudentByClassSectionID($student_current_class->class_id, $student_current_class->section_id, $student_id);
        $class_id                     = $student_current_class->class_id;
        $section_id                   = $student_current_class->section_id;
        $data['title']                = 'Student Details';
        $student_due_fee              = $this->studentfeemaster_model->getStudentFees($student_current_class->student_session_id);
        $student_discount_fee         = $this->feediscount_model->getStudentFeesDiscount($student_current_class->student_session_id);
        $data['student_discount_fee'] = $student_discount_fee;
        $data['student_due_fee']      = $student_due_fee;
        $data['student']              = $student;

        $this->load->view('layout/student/header', $data);
        $this->load->view('student/getfees', $data);
        $this->load->view('layout/student/footer', $data);
    }

    public function printFeesByGroupArray()
    {

        $data['sch_setting'] = $this->sch_setting_detail;
        $record              = $this->input->post('data');
        $record_array        = json_decode($record);
        $fees_array          = array();
        foreach ($record_array as $key => $value) {
            $fee_groups_feetype_id = $value->fee_groups_feetype_id;
            $fee_master_id         = $value->fee_master_id;
            $fee_session_group_id  = $value->fee_session_group_id;
            $feeList               = $this->studentfeemaster_model->getDueFeeByFeeSessionGroupFeetype($fee_session_group_id, $fee_master_id, $fee_groups_feetype_id);
            $fees_array[]          = $feeList;
        }
        $data['feearray'] = $fees_array;
        $this->load->view('student/printFeesByGroupArray', $data);
    }

    public function getcollectfee()
    {
        $setting_result      = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $record              = $this->input->post('data');
        $record_array        = json_decode($record);
        $fees_array = array();
        foreach ($record_array as $key => $value) {
            $fee_groups_feetype_id = $value->fee_groups_feetype_id;
            $fee_master_id         = $value->fee_master_id;
            $fee_session_group_id  = $value->fee_session_group_id;
            $feeList               = $this->studentfeemaster_model->getDueFeeByFeeSessionGroupFeetype($fee_session_group_id, $fee_master_id, $fee_groups_feetype_id);
            $fees_array[]          = $feeList;
        }
        $data['feearray'] = $fees_array;
        $result           = array(
            'view' => $this->load->view('student/getcollectfee', $data, true),
        );
        $this->output->set_output(json_encode($result));
    }

    public function create_doc()
    {

        $this->form_validation->set_rules('first_title', $this->lang->line('title'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('first_doc', $this->lang->line('document'), 'callback_handle_upload');

        if ($this->form_validation->run() == false) {
            $msg = array(
                'first_title' => form_error('first_title'),
                'first_doc'   => form_error('first_doc'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $student_id = $this->input->post('student_id');
            if (isset($_FILES["first_doc"]) && !empty($_FILES['first_doc']['name'])) {
                $uploaddir = './uploads/student_documents/' . $student_id . '/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder $uploaddir");
                }

                $fileInfo    = pathinfo($_FILES["first_doc"]["name"]);
                $first_title = $this->input->post('first_title');
                $file_name   = $_FILES['first_doc']['name'];
                $exp         = explode(' ', $file_name);
                $imp         = implode('_', $exp);
                $img_name    = $uploaddir . basename($imp);
                move_uploaded_file($_FILES["first_doc"]["tmp_name"], $img_name);
                $data_img = array('student_id' => $student_id, 'title' => $first_title, 'doc' => $imp);
                $this->student_model->adddoc($data_img);

            }

            $msg   = $this->lang->line('success_message');
            $array = array('status' => 'success', 'error' => '', 'message' => $msg);

        }
        echo json_encode($array);

    }
	
    public function handle_upload()
    {

        $image_validate = $this->config->item('file_validate');
        $result         = $this->filetype_model->get();
        if (isset($_FILES["first_doc"]) && !empty($_FILES['first_doc']['name'])) {

            $file_type = $_FILES["first_doc"]['type'];
            $file_size = $_FILES["first_doc"]["size"];
            $file_name = $_FILES["first_doc"]["name"];

            $allowed_extension = array_map('trim', array_map('strtolower', explode(',', $result->file_extension)));
            $allowed_mime_type = array_map('trim', array_map('strtolower', explode(',', $result->file_mime)));
            $ext               = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mtype = finfo_file($finfo, $_FILES['first_doc']['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mtype, $allowed_mime_type)) {
                $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                $this->form_validation->set_message('handle_upload', $this->lang->line('extension_not_allowed'));
                return false;
            }
            if ($file_size > $result->file_size) {
                $this->form_validation->set_message('handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                return false;
            }

            return true;
        } else {
            $this->form_validation->set_message('handle_upload', $this->lang->line('the_file_field_is_required'));
            return false;
        }
        return true;
    }
	
    public function edit()
    {
        $data['title']              = 'Edit Student';
        $id                         = $this->customlib->getStudentSessionUserID();
        $data['id']                 = $id;
        $student                    = $this->student_model->get($id);
        $genderList                 = $this->customlib->getGender();
        $data['student']            = $student;
        $data['genderList']         = $genderList;
        $session                    = $this->setting_model->getCurrentSession();
        $vehroute_result            = $this->vehroute_model->get();
        $data['vehroutelist']       = $vehroute_result;
        $category                   = $this->category_model->get();
        $data['categorylist']       = $category;
        $data["bloodgroup"]         = $this->config->item('bloodgroup');
        $data['inserted_fields']    = $this->student_edit_field_model->get();
        $data['sch_setting_detail'] = $this->sch_setting_detail;

        if ($this->findSelected($data['inserted_fields'], 'firstname')) {
            $this->form_validation->set_rules('firstname', $this->lang->line('first_name'), 'trim|required|xss_clean');
        }
        if ($this->findSelected($data['inserted_fields'], 'guardian_is')) {

            $this->form_validation->set_rules('guardian_is', $this->lang->line('guardian'), 'trim|required|xss_clean');
        }
        if ($this->findSelected($data['inserted_fields'], 'dob')) {

            $this->form_validation->set_rules('dob', $this->lang->line('date_of_birth'), 'trim|required|xss_clean');
        }
        if ($this->findSelected($data['inserted_fields'], 'gender')) {

            $this->form_validation->set_rules('gender', $this->lang->line('gender'), 'trim|required|xss_clean');
        }
        if ($this->findSelected($data['inserted_fields'], 'guardian_name')) {
            $this->form_validation->set_rules('guardian_name', $this->lang->line('guardian_name'), 'trim|required|xss_clean');

        }

        if ($this->findSelected($data['inserted_fields'], 'guardian_phone')) {

            $this->form_validation->set_rules('guardian_phone', $this->lang->line('guardian_phone'), 'trim|required|xss_clean');
        }

        $this->form_validation->set_rules('file', $this->lang->line('image'), 'callback_edit_handle_upload[file]');
        $this->form_validation->set_rules('father_pic', $this->lang->line('image'), 'callback_edit_handle_upload[father_pic]');
        $this->form_validation->set_rules('mother_pic', $this->lang->line('image'), 'callback_edit_handle_upload[mother_pic]');
        $this->form_validation->set_rules('guardian_pic', $this->lang->line('image'), 'callback_edit_handle_upload[guardian_pic]');

        if ($this->form_validation->run() == false) {
            $this->load->view('layout/student/header', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('layout/student/footer', $data);
        } else {

            $student_id = $id;
            $data       = array(
                'id' => $id,
            );

            $firstname = $this->input->post('firstname');
            if (isset($firstname)) {
                $data['firstname'] = $this->input->post('firstname');
            }
            $rte = $this->input->post('rte');
            if (isset($rte)) {
                $data['rte'] = $this->input->post('rte');
            }
            $pincode = $this->input->post('pincode');
            if (isset($pincode)) {
                $data['pincode'] = $this->input->post('pincode');
            }
            $cast = $this->input->post('cast');
            if (isset($cast)) {
                $data['cast'] = $this->input->post('cast');
            }
            $guardian_is = $this->input->post('guardian_is');
            if (isset($guardian_is)) {
                $data['guardian_is'] = $this->input->post('guardian_is');
            }
            $previous_school = $this->input->post('previous_school');
            if (isset($previous_school)) {
                $data['previous_school'] = $this->input->post('previous_school');
            }
            $dob = $this->input->post('dob');
            if (isset($dob)) {
                $data['dob'] = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('dob')));
            }
            $current_address = $this->input->post('current_address');
            if (isset($current_address)) {
                $data['current_address'] = $this->input->post('current_address');
            }
            $permanent_address = $this->input->post('permanent_address');
            if (isset($permanent_address)) {
                $data['permanent_address'] = $this->input->post('permanent_address');
            }
            $bank_account_no = $this->input->post('bank_account_no');
            if (isset($bank_account_no)) {
                $data['bank_account_no'] = $this->input->post('bank_account_no');
            }
            $bank_name = $this->input->post('bank_name');
            if (isset($bank_name)) {
                $data['bank_name'] = $this->input->post('bank_name');
            }
            $ifsc_code = $this->input->post('ifsc_code');
            if (isset($ifsc_code)) {
                $data['ifsc_code'] = $this->input->post('ifsc_code');
            }
            $guardian_occupation = $this->input->post('guardian_occupation');
            if (isset($guardian_occupation)) {
                $data['guardian_occupation'] = $this->input->post('guardian_occupation');
            }
            $guardian_email = $this->input->post('guardian_email');
            if (isset($guardian_email)) {
                $data['guardian_email'] = $this->input->post('guardian_email');
            }
            $gender = $this->input->post('gender');
            if (isset($gender)) {
                $data['gender'] = $this->input->post('gender');
            }
            $guardian_name = $this->input->post('guardian_name');
            if (isset($guardian_name)) {
                $data['guardian_name'] = $this->input->post('guardian_name');
            }
            $guardian_relation = $this->input->post('guardian_relation');
            if (isset($guardian_relation)) {
                $data['guardian_relation'] = $this->input->post('guardian_relation');
            }
            $guardian_phone = $this->input->post('guardian_phone');
            if (isset($guardian_phone)) {
                $data['guardian_phone'] = $this->input->post('guardian_phone');
            }
            $guardian_address = $this->input->post('guardian_address');
            if (isset($guardian_address)) {
                $data['guardian_address'] = $this->input->post('guardian_address');
            }
            $adhar_no = $this->input->post('adhar_no');
            if (isset($adhar_no)) {
                $data['adhar_no'] = $this->input->post('adhar_no');
            }
            $samagra_id = $this->input->post('samagra_id');
            if (isset($samagra_id)) {
                $data['samagra_id'] = $this->input->post('samagra_id');
            }

            $house             = $this->input->post('house');
            $blood_group       = $this->input->post('blood_group');
            $measurement_date  = $this->input->post('measure_date');
            $roll_no           = $this->input->post('roll_no');
            $lastname          = $this->input->post('lastname');
            $category_id       = $this->input->post('category_id');
            $religion          = $this->input->post('religion');
            $mobileno          = $this->input->post('mobileno');
            $email             = $this->input->post('email');
            $admission_date    = $this->input->post('admission_date');
            $height            = $this->input->post('height');
            $weight            = $this->input->post('weight');
            $father_name       = $this->input->post('father_name');
            $father_phone      = $this->input->post('father_phone');
            $father_occupation = $this->input->post('father_occupation');
            $mother_name       = $this->input->post('mother_name');
            $mother_phone      = $this->input->post('mother_phone');
            $mother_occupation = $this->input->post('mother_occupation');

            if (isset($measurement_date)) {
                $data['measurement_date'] = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('measure_date')));
            }

            if (isset($house)) {
                $data['school_house_id'] = $this->input->post('house');
            }
            if (isset($blood_group)) {

                $data['blood_group'] = $this->input->post('blood_group');
            }

            if (isset($lastname)) {

                $data['lastname'] = $this->input->post('lastname');
            }

            if (isset($category_id)) {

                $data['category_id'] = $this->input->post('category_id');
            }

            if (isset($religion)) {

                $data['religion'] = $this->input->post('religion');
            }

            if (isset($mobileno)) {

                $data['mobileno'] = $this->input->post('mobileno');
            }

            if (isset($email)) {

                $data['email'] = $this->input->post('email');
            }

            if (isset($admission_date)) {

                $data['admission_date'] = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('admission_date')));
            }

            if (isset($height)) {

                $data['height'] = $this->input->post('height');
            }

            if (isset($weight)) {

                $data['weight'] = $this->input->post('weight');
            }

            if (isset($father_name)) {

                $data['father_name'] = $this->input->post('father_name');
            }

            if (isset($father_phone)) {

                $data['father_phone'] = $this->input->post('father_phone');
            }

            if (isset($father_occupation)) {

                $data['father_occupation'] = $this->input->post('father_occupation');
            }

            if (isset($mother_name)) {

                $data['mother_name'] = $this->input->post('mother_name');
            }

            if (isset($mother_phone)) {

                $data['mother_phone'] = $this->input->post('mother_phone');
            }

            if (isset($mother_occupation)) {

                $data['mother_occupation'] = $this->input->post('mother_occupation');
            }

            $this->student_model->add($data);

            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/student_images/" . $img_name);
                $data_img = array('id' => $id, 'image' => 'uploads/student_images/' . $img_name);
                $this->student_model->add($data_img);
            }

            if (isset($_FILES["father_pic"]) && !empty($_FILES['father_pic']['name'])) {
                $fileInfo = pathinfo($_FILES["father_pic"]["name"]);
                $img_name = $id . "father" . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["father_pic"]["tmp_name"], "./uploads/student_images/" . $img_name);
                $data_img = array('id' => $id, 'father_pic' => 'uploads/student_images/' . $img_name);
                $this->student_model->add($data_img);
            }

            if (isset($_FILES["mother_pic"]) && !empty($_FILES['mother_pic']['name'])) {
                $fileInfo = pathinfo($_FILES["mother_pic"]["name"]);
                $img_name = $id . "mother" . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["mother_pic"]["tmp_name"], "./uploads/student_images/" . $img_name);
                $data_img = array('id' => $id, 'mother_pic' => 'uploads/student_images/' . $img_name);
                $this->student_model->add($data_img);
            }

            if (isset($_FILES["guardian_pic"]) && !empty($_FILES['guardian_pic']['name'])) {
                $fileInfo = pathinfo($_FILES["guardian_pic"]["name"]);
                $img_name = $id . "guardian" . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["guardian_pic"]["tmp_name"], "./uploads/student_images/" . $img_name);
                $data_img = array('id' => $id, 'guardian_pic' => 'uploads/student_images/' . $img_name);
                $this->student_model->add($data_img);
            }

            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('user/user/edit');
        }
    }

    public function findSelected($inserted_fields, $find)
    {
        foreach ($inserted_fields as $inserted_key => $inserted_value) {
            if ($find == $inserted_value->name && $inserted_value->status) {
                return true;
            }

        }
        return false;

    }

    public function edit_handle_upload($value, $field_name)
    {

        $image_validate = $this->config->item('image_validate');

        if (isset($_FILES[$field_name]) && !empty($_FILES[$field_name]['name'])) {

            $file_type         = $_FILES[$field_name]['type'];
            $file_size         = $_FILES[$field_name]["size"];
            $file_name         = $_FILES[$field_name]["name"];
            $allowed_extension = $image_validate['allowed_extension'];
            $ext               = pathinfo($file_name, PATHINFO_EXTENSION);
            $allowed_mime_type = $image_validate['allowed_mime_type'];
            if ($files = @getimagesize($_FILES[$field_name]['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('edit_handle_upload', 'File Type Not Allowed');
                    return false;
                }

                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('edit_handle_upload', 'Extension Not Allowed');
                    return false;
                }
                if ($file_size > $image_validate['upload_size']) {
                    $this->form_validation->set_message('edit_handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('edit_handle_upload', "File Type / Extension Error Uploading  Image");
                return false;
            }

            return true;
        }
        return true;
    }

    public function printFeesByName()
    {
        $data                   = array('payment' => "0");
        $record                 = $this->input->post('data');
        $invoice_id             = $this->input->post('main_invoice');
        $sub_invoice_id         = $this->input->post('sub_invoice');
        $student_session_id     = $this->input->post('student_session_id');
        $setting_result         = $this->setting_model->get();
        $data['settinglist']    = $setting_result;
        $student                = $this->studentsession_model->searchStudentsBySession($student_session_id);
        $fee_record             = $this->studentfeemaster_model->getFeeByInvoice($invoice_id, $sub_invoice_id);
        $data['student']        = $student;
        $data['sub_invoice_id'] = $sub_invoice_id;
        $data['feeList']        = $fee_record;
        $data['sch_setting']    = $this->sch_setting_detail;
        $this->load->view('print/printFeesByName', $data);
    }
    

}
