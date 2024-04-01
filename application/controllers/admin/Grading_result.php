<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Grading_result extends Admin_Controller
{

    public $sch_setting_detail = array();

    public function __construct()
    {
        parent::__construct();
        $this->sch_current_session = $this->setting_model->getCurrentSession();
        $this->staff_id            = $this->customlib->getStaffID();
        $this->sch_setting_detail = $this->setting_model->getSetting();
        $this->load->library("datatables");
        $this->load->model('Teacherpermission_model');
        $this->load->model('Gradingreport_model');
        $this->load->model('Studentsession_model');
        $this->load->model('Level_model');
        $this->load->model('Session_model');
    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('grading_report_results', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'GradingReport');
        $this->session->set_userdata('sub_menu', 'GradingReport/Results');
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata["role_id"];
        // print_r($userdata);
        // exit();
        if($role_id == 51) //primary
        {
            $level_id = 42;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else if($role_id == 52) //secondary
        {
            $level_id = 43;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else if($role_id == 53) //initial
        {
            $level_id = 41;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else
        {
            $class_list = $this->class_model->get();
        }
        $data['sch_setting']     = $this->sch_setting_detail;
        $data['classlist']       = $class_list;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/gradingreport/main', $data);
        $this->load->view('layout/footer', $data);
    }

    public function edit()
    {
        if (!$this->rbac->hasPrivilege('grading_report_results', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'GradingReport');
        $this->session->set_userdata('sub_menu', 'GradingReport/BySubject');
        $userdata   = $this->customlib->getUserData();
        $role_id    = $userdata["role_id"];
        $staff_id   = $userdata["id"];

        if($role_id == 51) //primary
        {
            $level_id = 42;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else if($role_id == 52) //secondary
        {
            $level_id = 43;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else if($role_id == 53) //initial
        {
            $level_id = 41;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else
        {
            if($role_id == 2)
            {
                $level_id           = $this->Gradingreport_model->getLevelByStaffId($staff_id);
                $class_list         = $this->class_model->get();
            }
            else
            {
                $level_id = 43;     // for admin role
                $class_list         = $this->Gradingreport_model->getClassByLevel(0);
            }
        }
        
        // $period_list = $this->Gradingreport_model->getPeriodByLevel($level_id);   
        ## if(admin) only 4number columns
        //print($level_id); die;
        $period_list = $this->Gradingreport_model->getPeriodEnabledByStaffId($staff_id, $level_id);   
        $data['role_id']        = $role_id;
        $data['classlist']       = $class_list;
        $data['sch_setting']     = $this->sch_setting_detail;
        $data['periodList'] = $period_list;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/gradingreport/edit', $data);
        $this->load->view('layout/footer', $data);
    }

    public function newedit()
    {
        if (!$this->rbac->hasPrivilege('grading_report_results', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'GradingReport');
        $this->session->set_userdata('sub_menu', 'GradingReport/ReportBySubject');
        $userdata   = $this->customlib->getUserData();
        $role_id    = $userdata["role_id"];
        $staff_id   = $userdata["id"];

        if($role_id == 51) //primary
        {
            $level_id = 42;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else if($role_id == 52) //secondary
        {
            $level_id = 43;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else if($role_id == 53) //initial
        {
            $level_id = 41;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else
        {
            if($role_id == 2)
            {
                $level_id           = $this->Gradingreport_model->getLevelByStaffId($staff_id);
                $class_list         = $this->class_model->get();
            }
            else
            {
                $level_id = 43;     // for admin role
                $class_list         = $this->Gradingreport_model->getClassByLevel(0);
            }
        }
        
        // $period_list = $this->Gradingreport_model->getPeriodByLevel($level_id);   
        ## if(admin) only 4number columns
        //print($level_id); die;
        $period_list = $this->Gradingreport_model->getPeriodEnabledByStaffId($staff_id, $level_id);   
        $data['role_id']        = $role_id;
        $data['classlist']       = $class_list;
        $data['sch_setting']     = $this->sch_setting_detail;
        $data['periodList'] = $period_list;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/gradingreport/newedit', $data);
        $this->load->view('layout/footer', $data);
    }

    public function searchvalidation()
    {
        $class_id   = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $subject_id = $this->input->post('subject_id');
        $subject_group_id = $this->input->post('subject_group_id');

        $srch_type = $this->input->post('search_type');
        $search_text = $this->input->post('search_text');

        if ($srch_type == 'search_filter') {

            $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
            if ($this->form_validation->run() == true) {

                $params = array('srch_type' => $srch_type, 'class_id' => $class_id, 'section_id' => $section_id);
                $array  = array('status' => 1, 'error' => '', 'params' => $params);
                echo json_encode($array);
            } else {

                $error             = array();
                $error['class_id'] = form_error('class_id');
                $array             = array('status' => 0, 'error' => $error);
                echo json_encode($array);
            }
        } elseif ($srch_type == 'search_edit') {

            $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required|xss_clean');

            if ($this->form_validation->run() == true) {

                $params = array('srch_type' => $srch_type, 'class_id' => $class_id, 'section_id' => $section_id, 'subject_id' => $subject_id);
                $array  = array('status' => 1, 'error' => '', 'params' => $params);
                echo json_encode($array);
            } else {

                $error               = array();
                $error['class_id']   = form_error('class_id');
                $error['section_id'] = form_error('section_id');
                $error['subject_id'] = form_error('subject_id');

                $array             = array('status' => 0, 'error' => $error);
                echo json_encode($array);
            }
        } else {
            $params = array('srch_type' => 'search_full', 'class_id' => $class_id, 'section_id' => $section_id, 'search_text' => $search_text);
            $array  = array('status' => 1, 'error' => '', 'params' => $params);
            echo json_encode($array);
        }
    }
    public function dtstudentlist()
    {

        $class           = $this->input->post('class_id');
        $section         = $this->input->post('section_id');
        $search_text     = $this->input->post('search_text');
        $search_type     = $this->input->post('srch_type');
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata["role_id"];
        if($role_id == 51) //primary
        {
            $level_id = 42;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else if($role_id == 52) //secondary
        {
            $level_id = 43;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else if($role_id == 53) //initial
        {
            $level_id = 41;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else
        {
            $class_list = $this->class_model->get();
        }

        $carray          = array();
        if (!empty($class_list)) {
            foreach ($class_list as $ckey => $cvalue) {
                $carray[] = $cvalue["id"];
            }
        }
        $sch_setting = $this->sch_setting_detail;
        if ($search_type == "search_filter") {
            $resultlist = $this->student_model->searchdtByClassSection($class, $section);
        } elseif ($search_type == "search_full") {
            $resultlist = $this->student_model->searchFullText($search_text, $carray);
        }

        $students = array();
        $students = json_decode($resultlist);
        $dt_data  = array();
        if (!empty($students->data)) {
            $number = 1;
            foreach ($students->data as $student_key => $student) {
                $row   = array();
                $row[] = "<div data_id=" . $student->id . ">" . $student->admission_no . "</div>";
                $row[] = "$number";
                $row[] = $this->customlib->getFullName($student->firstname, $student->middlename, $student->lastname, $sch_setting->middlename, $sch_setting->lastname);
                $row[] = "<i class='fa fa-angle-double-right'></i>";
                $number++;
                $dt_data[] = $row;
            }
        }
        $student_detail_view = $this->load->view('student/_searchDetailView', array('sch_setting' => $sch_setting, 'students' => $students), true);
        $json_data           = array(
            "draw"                => intval($students->draw),
            "recordsTotal"        => intval($students->recordsTotal),
            "recordsFiltered"     => intval($students->recordsFiltered),
            "data"                => $dt_data,
            "student_detail_view" => $student_detail_view,
        );

        echo json_encode($json_data);
    }

    public function dteditstudentlist()
    {

        $class              = $this->input->post('class_id');
        $section            = $this->input->post('section_id');
        $subject_id         = $this->input->post('subject_id');
        $sch_setting        = $this->sch_setting_detail;
        $admin_session      = $this->session->userdata('admin');
        $permission         = $this->staff_model->get_permission($admin_session['id']);
        $resultlist         = $this->Gradingreport_model->searchdtByClassSectionSubject($class, $section, $subject_id);
        $period_list        = [];
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata["role_id"];
        if($role_id == 51) //primary
        {
            $level_id = 42;
            $class_list         = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else if($role_id == 52) //secondary
        {
            $level_id = 43;
            $class_list         = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else if($role_id == 53) //initial
        {
            $level_id = 41;
            $class_list         = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else
        {
            $level_id           = $this->Gradingreport_model->getLevelByClass($class);
            $class_list         = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        $staff_id = $userdata["id"];
        $period_list = $this->Gradingreport_model->getPeriodEnabledByStaffId($staff_id, $level_id);   

        $students = array();
        $students = json_decode($resultlist);
        $dt_data  = array();
        $canedit = $this->rbac->hasPrivilege('grading_report_results', 'can_edit');
        if (!empty($students->data)) {
            foreach ($students->data as $student) {
                $addstep = 0;
                $row   = array();
                $row[] = "<div data_id=" . $student->id . ">" . $student->admission_no . "</div>";
                $row[] = '';
                $row[] = $this->customlib->getFullName($student->firstname, $student->middlename, $student->lastname, $sch_setting->middlename, $sch_setting->lastname);

                $period_results = array();
                $period_results[] = $student->p1;
                $period_results[] = $student->p2;
                $period_results[] = $student->p3;
                $period_results[] = $student->p4;
                $period_results[] = $student->p5;
                $update_date = array();
                $update_date[] = $student->update_date_p1;
                $update_date[] = $student->update_date_p2;
                $update_date[] = $student->update_date_p3;
                $update_date[] = $student->update_date_p4;
                $update_date[] = $student->update_date_p5;
                
                $i = 0;
                foreach ( $period_list as $period) {
                   
                    if( !empty($period['canedit']) )
                    {
                        $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $period_results[$i] . "' data_column = 'p" . ($i + 1) . "' data_stdID='" . $student->student_session_id . "' value='" . $period_results[$i] . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                    } else {
                        $row[] =  "<input readonly min='0' max='100' class='td-input pr' data_org = '" . $period_results[$i] . "' data_column = 'p" . ($i + 1) . "' data_stdID='" . $student->student_session_id . "' value='" . $period_results[$i] . "'>";
                    }
                    $i++;
                }
                for ($ii = $i; $ii < 4; $ii++) {
                    $row[] = "";
                }
                $CF = 0;
                $i = 0; $cnt = 0;
                // $CF = 0;  echo ($period_results[$i] * 1);die;
                for ($i = 0; $i < count($period_list); $i++) {
                    if (empty($period_results[$i]) || empty($period_results[$i] * 1)) {
                        $CF = 0;
                        break;
                    } else {
                        $CF += $period_results[$i] / count($period_list);
                    }
                }

                if (!empty($CF)) {
                    $CF = round($CF);
                }
                $row[] = "<div class='cf' data_org = '" . $CF . "' data_stdID='" . $student->student_session_id . "'>" . $CF . "</div>";

                $_50PCP = '';
                $CPC = '';
                $_50CPC = '';
                $CC = '';
                $_30PCP = '';
                $CPEX = '';
                $_70CPEX = '';
                $CEX = '';
                $A = '';
                $R = '';
                $O1 = '';
                $O2 = '';
                if (empty($CF)) {
                    $CF = 0;
                } else {
                    $CF = round($CF);
                    if ($CF >= 70) {
                        $A = 'A';
                        $R = '';
                    } else {
                        $A = '';
                        $R = 'R';
                        if ($CF > 40) {
                            $addstep = 1;
                            $_50PCP = round($CF / 2);
                            if (!empty($student->CPC * 1)) {
                                $CPC = $student->CPC;
                                $_50CPC = round($student->CPC / 2);
                                $CC = $_50PCP + $_50CPC;
                                if ($CC >= 70) {
                                    $A = 'A';
                                    $R = '';
                                } else {
                                    $addstep = 2;
                                    $_30PCP = round($CF * 0.3);
                                    if (!empty($student->CPEX * 1)) {
                                        $CPEX = $student->CPEX;
                                        $_70CPEX = round($student->CPEX * 0.7);
                                        $CEX = $_30PCP + $_70CPEX;
                                        if ($CEX >= 70) {
                                            $A = 'A';
                                            $R = '';
                                        }
                                    }
                                }
                            }
                        } else {
                            $addstep = 3;
                            $_30PCP = round($CF * 0.3);
                            if (!empty($student->CPEX * 1)) {
                                $CPEX = $student->CPEX;
                                $_70CPEX = round($student->CPEX * 0.7);
                                $CEX = $_30PCP + $_70CPEX;
                                if ($CEX >= 70) {
                                    $A = 'A';
                                    $R = '';
                                }
                            }
                        }
                    }
                }
                $addtest1 = $addstep < 1 || $addstep == 3 ? "disable-addtest" : "";
                $addtest2 = $addstep < 2 ? "disable-addtest" : "";
                $row[] = "<div class='50pcp' data_org = '" . $_50PCP . "' data_stdID='" . $student->student_session_id . "'>" . $_50PCP . "</div>";
                if ($canedit) {
                    $row[] = "<div class='cpc' data_org = '" . $addtest1 . "' data_stdID='" . $student->student_session_id . "'><input type='number' min='0' max='100' class='td-input " . $addtest1 . "' data_org = '" . $CPC . "' data_column = 'CPC' data_stdID='" . $student->student_session_id . "' value='" . $CPC . "'></div>";
                } else {
                    $row[] = $addstep < 1 || $addstep == 3 ? "" : $CPC;
                }
                $row[] = "<div class='50cpc' data_org = '" . $_50CPC . "' data_stdID='" . $student->student_session_id . "'>" . $_50CPC . "</div>";
                $row[] = "<div class='cc' data_org = '" . $CC . "' data_stdID='" . $student->student_session_id . "'>" . $CC . "</div>";
                $row[] = "<div class='30pcp' data_org = '" . $_30PCP . "' data_stdID='" . $student->student_session_id . "'>" . $_30PCP . "</div>";
                if ($canedit) {
                    $row[] = "<div class='cpex' data_org = '" . $addtest2 . "' data_stdID='" . $student->student_session_id . "'><input type='number' min='0' max='100' class='td-input " . $addtest2 . "' data_org = '" . $CPEX . "' data_column = 'CPEX' data_stdID='" . $student->student_session_id . "' value='" . $CPEX . "'></div>";
                } else {
                    $row[] = $addstep < 2 ? "" : $CPEX;
                }
                $row[] = "<div class='70cpex' data_org = '" . $_70CPEX . "' data_stdID='" . $student->student_session_id . "'>" . $_70CPEX . "</div>";
                $row[] = "<div class='cex' data_org = '" . $CEX . "' data_stdID='" . $student->student_session_id . "'>" . $CEX . "</div>";
                $row[] = "<div class='a' data_org = '" . $A . "' data_stdID='" . $student->student_session_id . "'>" . $A . "</div>";
                $row[] = "<div class='r' data_org = '" . $R . "' data_stdID='" . $student->student_session_id . "'>" . $R . "</div>";
                $row[] = $O1;
                $row[] = $O2;

                $dt_data[] = $row;
            }
        }

        $json_data           = array(
            "draw"                => intval($students->draw),
            "recordsTotal"        => intval($students->recordsTotal),
            "recordsFiltered"     => intval($students->recordsFiltered),
            "data"                => $dt_data,
        );

        echo json_encode($json_data);
    }

    public function dtneweditstudentlist()
    {

        $class              = $this->input->post('class_id');
        $section            = $this->input->post('section_id');
        $subject_id         = $this->input->post('subject_id');
        $sch_setting        = $this->sch_setting_detail;
        $admin_session      = $this->session->userdata('admin');
        $permission         = $this->staff_model->get_permission($admin_session['id']);
        $resultlist         = $this->Gradingreport_model->searchReportByClassSectionSubject($class, $section, $subject_id);
        $period_list        = [];
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata["role_id"];
        if($role_id == 51) //primary
        {
            $level_id = 42;
            $class_list         = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else if($role_id == 52) //secondary
        {
            $level_id = 43;
            $class_list         = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else if($role_id == 53) //initial
        {
            $level_id = 41;
            $class_list         = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else
        {
            $level_id           = $this->Gradingreport_model->getLevelByClass($class);
            $class_list         = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        $staff_id = $userdata["id"];
        $period_list = $this->Gradingreport_model->getPeriodEnabledByStaffId($staff_id, $level_id);   

        $students = array();
        $students = json_decode($resultlist);
        $dt_data  = array();
        $canedit = $this->rbac->hasPrivilege('grading_report_results', 'can_edit');
        if (!empty($students->data)) {
            foreach ($students->data as $student) {
                $addstep = 0;
                $row   = array();
                $row[] = "<div data_id=" . $student->id . ">" . $student->admission_no . "</div>";
                $row[] = '';
                $row[] = $this->customlib->getFullName($student->firstname, $student->middlename, $student->lastname, $sch_setting->middlename, $sch_setting->lastname);

                $period_results = array();
                $period_results[] = $student->p11;
                $period_results[] = $student->p12;
                $period_results[] = $student->p13;
                $period_results[] = $student->p14;
                $update_date = array();
                $update_date[] = $student->update_date_p1;
                $update_date[] = $student->update_date_p2;
                $update_date[] = $student->update_date_p3;
                $update_date[] = $student->update_date_p4;
                $update_date[] = $student->update_date_p5;
                
                $i = 0;
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p11 . "' data_column = 'p11' data_stdID='" . $student->student_session_id . "' value='" . $student->p11 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p12 . "' data_column = 'p12' data_stdID='" . $student->student_session_id . "' value='" . $student->p12 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p13 . "' data_column = 'p13' data_stdID='" . $student->student_session_id . "' value='" . $student->p13 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p14 . "' data_column = 'p14' data_stdID='" . $student->student_session_id . "' value='" . $student->p14 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p21 . "' data_column = 'p21' data_stdID='" . $student->student_session_id . "' value='" . $student->p21 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p22 . "' data_column = 'p22' data_stdID='" . $student->student_session_id . "' value='" . $student->p22 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p23 . "' data_column = 'p23' data_stdID='" . $student->student_session_id . "' value='" . $student->p23 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p24 . "' data_column = 'p24' data_stdID='" . $student->student_session_id . "' value='" . $student->p24 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p31 . "' data_column = 'p31' data_stdID='" . $student->student_session_id . "' value='" . $student->p31 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p32 . "' data_column = 'p32' data_stdID='" . $student->student_session_id . "' value='" . $student->p32 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p33 . "' data_column = 'p33' data_stdID='" . $student->student_session_id . "' value='" . $student->p33 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p34 . "' data_column = 'p34' data_stdID='" . $student->student_session_id . "' value='" . $student->p34 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p41 . "' data_column = 'p41' data_stdID='" . $student->student_session_id . "' value='" . $student->p41 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p42 . "' data_column = 'p42' data_stdID='" . $student->student_session_id . "' value='" . $student->p42 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p43 . "' data_column = 'p43' data_stdID='" . $student->student_session_id . "' value='" . $student->p43 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->p44 . "' data_column = 'p44' data_stdID='" . $student->student_session_id . "' value='" . $student->p44 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->pc1 . "' data_column = 'pc1' data_stdID='" . $student->student_session_id . "' value='" . $student->pc1 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->pc2 . "' data_column = 'pc2' data_stdID='" . $student->student_session_id . "' value='" . $student->pc2 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->pc3 . "' data_column = 'pc3' data_stdID='" . $student->student_session_id . "' value='" . $student->pc3 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $student->pc4 . "' data_column = 'pc4' data_stdID='" . $student->student_session_id . "' value='" . $student->pc4 . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                // foreach ( $period_list as $period) {
                   
                //     if( !empty($period['canedit']) )
                //     {
                //         $row[] = "<input type='number' min='0' max='100' class='td-input pr' data_org = '" . $period_results[$i] . "' data_column = 'p" . ($i + 1) . "' data_stdID='" . $student->student_session_id . "' value='" . $period_results[$i] . "' onfocus=\"style.background='LightYellow'; \" onblur=\"this.style.background='';  \">";
                //     } else {
                //         $row[] =  "<input readonly min='0' max='100' class='td-input pr' data_org = '" . $period_results[$i] . "' data_column = 'p" . ($i + 1) . "' data_stdID='" . $student->student_session_id . "' value='" . $period_results[$i] . "'>";
                //     }
                //     $i++;
                // }
                for ($ii = $i; $ii < 4; $ii++) {
                    $row[] = "";
                }
                $CF = 0;
                $i = 0; $cnt = 0;
                // $CF = 0;  echo ($period_results[$i] * 1);die;
                for ($i = 0; $i < count($period_list); $i++) {
                    if (empty($period_results[$i]) || empty($period_results[$i] * 1)) {
                        $CF = 0;
                        break;
                    } else {
                        $CF += $period_results[$i] / count($period_list);
                    }
                }

                if (!empty($CF)) {
                    $CF = round($CF);
                }
                $row[] = "<div class='cf' data_org = '" . $CF . "' data_stdID='" . $student->student_session_id . "'>" . $CF . "</div>";

                $_50PCP = '';
                $CPC = '';
                $_50CPC = '';
                $CC = '';
                $_30PCP = '';
                $CPEX = '';
                $_70CPEX = '';
                $CEX = '';
                $A = '';
                $R = '';
                $O1 = '';
                $O2 = '';
                if (empty($CF)) {
                    $CF = 0;
                } else {
                    $CF = round($CF);
                    if ($CF >= 70) {
                        $A = 'A';
                        $R = '';
                    } else {
                        $A = '';
                        $R = 'R';
                        if ($CF > 40) {
                            $addstep = 1;
                            $_50PCP = round($CF / 2);
                            if (!empty($student->CPC * 1)) {
                                $CPC = $student->CPC;
                                $_50CPC = round($student->CPC / 2);
                                $CC = $_50PCP + $_50CPC;
                                if ($CC >= 70) {
                                    $A = 'A';
                                    $R = '';
                                } else {
                                    $addstep = 2;
                                    $_30PCP = round($CF * 0.3);
                                    if (!empty($student->CPEX * 1)) {
                                        $CPEX = $student->CPEX;
                                        $_70CPEX = round($student->CPEX * 0.7);
                                        $CEX = $_30PCP + $_70CPEX;
                                        if ($CEX >= 70) {
                                            $A = 'A';
                                            $R = '';
                                        }
                                    }
                                }
                            }
                        } else {
                            $addstep = 3;
                            $_30PCP = round($CF * 0.3);
                            if (!empty($student->CPEX * 1)) {
                                $CPEX = $student->CPEX;
                                $_70CPEX = round($student->CPEX * 0.7);
                                $CEX = $_30PCP + $_70CPEX;
                                if ($CEX >= 70) {
                                    $A = 'A';
                                    $R = '';
                                }
                            }
                        }
                    }
                }
                $addtest1 = $addstep < 1 || $addstep == 3 ? "disable-addtest" : "";
                $addtest2 = $addstep < 2 ? "disable-addtest" : "";
                $row[] = "<div class='50pcp' data_org = '" . $_50PCP . "' data_stdID='" . $student->student_session_id . "'>" . $_50PCP . "</div>";
                if ($canedit) {
                    $row[] = "<div class='cpc' data_org = '" . $addtest1 . "' data_stdID='" . $student->student_session_id . "'><input type='number' min='0' max='100' class='td-input " . $addtest1 . "' data_org = '" . $CPC . "' data_column = 'CPC' data_stdID='" . $student->student_session_id . "' value='" . $CPC . "'></div>";
                } else {
                    $row[] = $addstep < 1 || $addstep == 3 ? "" : $CPC;
                }
                $row[] = "<div class='50cpc' data_org = '" . $_50CPC . "' data_stdID='" . $student->student_session_id . "'>" . $_50CPC . "</div>";
                $row[] = "<div class='cc' data_org = '" . $CC . "' data_stdID='" . $student->student_session_id . "'>" . $CC . "</div>";
                $row[] = "<div class='30pcp' data_org = '" . $_30PCP . "' data_stdID='" . $student->student_session_id . "'>" . $_30PCP . "</div>";
                if ($canedit) {
                    $row[] = "<div class='cpex' data_org = '" . $addtest2 . "' data_stdID='" . $student->student_session_id . "'><input type='number' min='0' max='100' class='td-input " . $addtest2 . "' data_org = '" . $CPEX . "' data_column = 'CPEX' data_stdID='" . $student->student_session_id . "' value='" . $CPEX . "'></div>";
                } else {
                    $row[] = $addstep < 2 ? "" : $CPEX;
                }
                $row[] = "<div class='70cpex' data_org = '" . $_70CPEX . "' data_stdID='" . $student->student_session_id . "'>" . $_70CPEX . "</div>";
                $row[] = "<div class='cex' data_org = '" . $CEX . "' data_stdID='" . $student->student_session_id . "'>" . $CEX . "</div>";
                $row[] = "<div class='a' data_org = '" . $A . "' data_stdID='" . $student->student_session_id . "'>" . $A . "</div>";
                $row[] = "<div class='r' data_org = '" . $R . "' data_stdID='" . $student->student_session_id . "'>" . $R . "</div>";
                $row[] = $O1;
                $row[] = $O2;

                $dt_data[] = $row;
            }
        }

        $json_data           = array(
            "draw"                => intval($students->draw),
            "recordsTotal"        => intval($students->recordsTotal),
            "recordsFiltered"     => intval($students->recordsFiltered),
            "data"                => $dt_data,
        );

        echo json_encode($json_data);
    }

    public function dteditstudentlistforprint()
    {

        $class             = $this->input->post('class_id');
        $section           = $this->input->post('section_id');
        $subject_id        = $this->input->post('subject_id');
        $sch_setting       = $this->sch_setting_detail;

        $resultlist = $this->Gradingreport_model->searchdtByClassSectionSubject($class, $section, $subject_id);
        $period_list = [];
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata["role_id"];
        if($role_id == 51) //primary
        {
            $level_id = 42;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else if($role_id == 52) //secondary
        {
            $level_id = 43;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
           
        }
        else if($role_id == 53) //initial
        {
            $level_id = 41;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
        }
        else
        {
            $level_id = 43;
            if($role_id == 2)
            {
                $class_list         = $this->class_model->get();
            }
            else
            {
                $class_list         = $this->Gradingreport_model->getClassByLevel($level_id);
            }
        }
        $period_list        = $this->Gradingreport_model->getPeriodByLevel($level_id);
        $students = array();
        $students = json_decode($resultlist);
        $dt_data  = array();
        $canedit = $this->rbac->hasPrivilege('grading_report_results', 'can_edit');
        if (!empty($students->data)) {
            $index = 1;
            foreach ($students->data as $student) {
                $addstep = 0;
                $row   = array();
                $row[] = "<div data_id=" . $student->id . ">" . $student->admission_no . "</div>";
                $row[] = $index;
                $index++;
                $row[] = $this->customlib->getFullName($student->firstname, $student->middlename, $student->lastname, $sch_setting->middlename, $sch_setting->lastname);

                $period_results = array();

                $period_results[] = $student->p1;
                $period_results[] = $student->p2;
                $period_results[] = $student->p3;
                $period_results[] = $student->p4;
                $period_results[] = $student->p5;

                for ($i = 0; $i < count($period_list); $i++) {
                    $row[] =  $period_results[$i];
                }

                $CF = 0;
                for ($i = 0; $i < count($period_list); $i++) {
                    if (empty($period_results[$i]) || empty($period_results[$i] * 1)) {
                        $CF = 0;
                        break;
                    } else {
                        $CF += $period_results[$i] / count($period_list);
                    }
                }   
                if (!empty($CF)) {
                    $CF = round($CF);
                }

                $row[] = $CF;
                $_50PCP = '';
                $CPC = '';
                $_50CPC = '';
                $CC = '';
                $_30PCP = '';
                $CPEX = '';
                $_70CPEX = '';
                $CEX = '';
                $A = '';
                $R = '';
                $O1 = '';
                $O2 = '';
                if (empty($CF)) {
                    $CF = 0;
                } else {
                    $CF = round($CF);
                    if ($CF >= 70) {
                        $A = 'A';
                        $R = '';
                    } else {
                        $A = '';
                        $R = 'R';
                        if ($CF > 40) {
                            $addstep = 1;
                            $_50PCP = round($CF / 2);
                            if (!empty($student->CPC * 1)) {
                                $CPC = $student->CPC;
                                $_50CPC = round($student->CPC / 2);
                                $CC = $_50PCP + $_50CPC;
                                if ($CC >= 70) {
                                    $A = 'A';
                                    $R = '';
                                } else {
                                    $addstep = 2;
                                    $_30PCP = round($CF * 0.3);
                                    if (!empty($student->CPEX * 1)) {
                                        $CPEX = $student->CPEX;
                                        $_70CPEX = round($student->CPEX * 0.7);
                                        $CEX = $_30PCP + $_70CPEX;
                                        if ($CEX >= 70) {
                                            $A = 'A';
                                            $R = '';
                                        }
                                    }
                                }
                            }
                        } else {
                            $addstep = 3;
                            $_30PCP = round($CF * 0.3);
                            if (!empty($student->CPEX * 1)) {
                                $CPEX = $student->CPEX;
                                $_70CPEX = round($student->CPEX * 0.7);
                                $CEX = $_30PCP + $_70CPEX;
                                if ($CEX >= 70) {
                                    $A = 'A';
                                    $R = '';
                                }
                            }
                        }
                    }
                }
                $row[] = $_50PCP;
                $row[] = $addstep < 1 || $addstep == 3 ? "" : $CPC;
                $row[] = $_50CPC;
                $row[] = $CC;
                $row[] = $_30PCP;
                $row[] = $addstep < 2 ? "" : $CPEX;
                $row[] = $_70CPEX;
                $row[] = $CEX;
                $row[] = $A;
                $row[] = $R;
                $row[] = $O1;
                $row[] = $O2;

                $dt_data[] = $row;
            }
        }
        $json_data           = array(
            "draw"                => intval($students->draw),
            "recordsTotal"        => intval($students->recordsTotal),
            "recordsFiltered"     => intval($students->recordsFiltered),
            "data"                => $dt_data,
        );

        echo json_encode($json_data);
    }

    public function valuescales()
    {
        if (!$this->rbac->hasPrivilege('grading_report_valuescale', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'GradingReport');
        $this->session->set_userdata('sub_menu', 'GradingReport/Valuescale');

        $level_list = $this->Gradingreport_model->getLevelList();
        $data['levelList'] = $level_list;

        $this->load->view('layout/header', $data);
        $this->load->view('admin/gradingreport/valuescales', $data);
        $this->load->view('layout/footer', $data);
    }

    public function createvaluescales()
    {
        $this->form_validation->set_rules('class_id', $this->lang->line('level'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('label', $this->lang->line('value_scale'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('marks', $this->lang->line('marks'), 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {
            $msg = array(
                'class_id' => form_error('class_id'),
                'label'       => form_error('label'),
                'marks'       => form_error('marks'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $data = array(
                'class_id' => $_POST['class_id'],
                'marks'       => $_POST['marks'],
                'label'       => $_POST['label'],
                'symbol'     => $_POST['symbol'],
            );

            $this->Gradingreport_model->add_valuescale($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function getvaluescalelist()
    {
        $result  = $this->Gradingreport_model->getValuescalelist();

        $m       = json_decode($result);
        $dt_data = array();
        if (!empty($m->data)) {
            foreach ($m->data as $key => $value) {
                $deletebtn = '';
                $editbtn = '';
                if ($this->rbac->hasPrivilege('grading_report_valuescale', 'can_edit')) {
                    $editbtn = "<a href='" . base_url() . "admin/grading_result/editvaluescale/" . $value->class_id . "/" .$value->id . "'
                     class='btn btn-default btn-xs'  data-toggle='tooltip' data-placement='left' title='" . $this->lang->line('edit') . "'
                     ><i class='fa fa-pencil'></i></a>";
                }
                if ($this->rbac->hasPrivilege('grading_report_valuescale', 'can_delete')) {
                    $deletebtn = "<a onclick='deletevaluescale(" . '"' . $value->id . '"' . "  )'
                     class='btn btn-default btn-xs' data-placement='left' title='" . $this->lang->line('delete') . "'
                     data-toggle='tooltip'><i class='fa fa-remove'></i></a>";
                }

                // if (in_array($value->classid, $class_array)) {
                $row       = array();
                $row[]     = $value->level;
                $row[]     = $value->label;
                $row[]     = $value->marks;
                $row[]     = $value->symbol;
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

    public function editvaluescale($level_id, $id)
    {
        if (!($this->rbac->hasPrivilege('grading_report_competences', 'can_edit'))) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'GradingReport');
        $this->session->set_userdata('sub_menu', 'GradingReport/Valuescale');

        $level_list = $this->Gradingreport_model->getLevelList();
        $data['levelList'] = $level_list;

        $valuescale = $this->Gradingreport_model->getvaluescale($id);

        $data['level_id']         = $level_id;
        $data['id']       = $valuescale['id'];
        $data['label'] = $valuescale['label'];
        $data['marks'] = $valuescale['marks'];
        $data['symbol'] = $valuescale['symbol'];

        $this->load->view('layout/header');
        $this->load->view('admin/gradingreport/editvaluescales', $data);
        $this->load->view('layout/footer');
    }

    public function updatevaluescales()
    {
        $this->form_validation->set_rules('id', $this->lang->line('eidt') . " " . $this->lang->line('id'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', $this->lang->line('level'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('label', $this->lang->line('value_scale'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('marks', $this->lang->line('value_scale') . " " . $this->lang->line('marks'), 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {
            $msg = array(
                'id'     => form_error('id'),
                'class_id' => form_error('class_id'),
                'label'       => form_error('label'),
                'marks'       => form_error('marks'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $data = array(
                'id'             => $_POST['id'],
                'class_id' => $_POST['class_id'],
                'marks'       => $_POST['marks'],
                'label'       => $_POST['label'],
                'symbol'     => $_POST['symbol'],
            );

            $this->Gradingreport_model->add_valuescale($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function deletevaluescale($id)
    {
        if (!($this->rbac->hasPrivilege('grading_report_competences', 'can_delete'))) {
            access_denied();
        }
        $this->Gradingreport_model->deleteValuescale($id);
        $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('delete_message'));
        echo json_encode($array);
    }

    public function viewreport($id, $period_id = null)
    {

        if (!$this->rbac->hasPrivilege('grading_report_results', 'can_view')) {
            access_denied();
        }
        $student         = $this->student_model->get($id);
        $data['student']  = $student;
        $student_session_id = $student['student_session_id'];

        $alledit = $this->input->get('alledittype');
        $data['alledit'] = !empty($alledit);

        $class_level = $this->Gradingreport_model->getClassByStudent_session_id($student_session_id);
        
        $userdata   = $this->customlib->getUserData();
        $role_id    = $userdata["role_id"];
        $staff_id   = $userdata["id"];
       
        $data['observationeditable'] = true;
        if (isset($role_id) && ($userdata["role_id"] == 2)){
            $data['observationeditable'] = false;
            $classteachers = $this->classteacher_model->teacherByClassSection($student['class_id'], $student['section_id']);
            if(!empty($classteachers) && $classteachers[0]['id'] == $userdata["id"]){
                $data['observationeditable'] = true;
            }
        }
       
        $data['student_session_id'] = $student_session_id;
        $data['class_id']  = $class_level['class_id'];
        $data['class']        = $class_level['class'];
        $data['level_id']  = $class_level['level_id'];
        $data['level']        = $class_level['level'];
        $data['observation'] = $this->Gradingreport_model->getStudentObservations($student_session_id);
        
        $level_id=$class_level['level_id'];

        //$level_id=$this->Gradingreport_model->getLevelByStaffId($staff_id);
        if( empty($level_id) ) $level_id=43;
        $period_list = $this->Gradingreport_model->getPeriodEnabledByStaffId($staff_id, $level_id);
        $data['periodList'] = $period_list;
        $data['isPrekender'] = $class_level['level_id'] != 43 ? true : false;
        
        if (!$data['isPrekender']) {

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
                $result = $this->Gradingreport_model->getReportByStudentAndSubject($student_session_id, $subject->id);
                $row = array();
                $row['subject'] = $subject->name;
                $row['subjectId'] = $subject->id;
                $row['period_results'] = array();
                $edit_flag = [];
                if (!empty($result)) {
                    $row['reportId'] = $result['id'];
					$update_date = [];
					$update_date[] = $result['update_date_p1'];
					$update_date[] = $result['update_date_p2'];
					$update_date[] = $result['update_date_p3'];
					$update_date[] = $result['update_date_p4'];
					$update_date[] = $result['update_date_p5'];
                    $row['period_results'][] = $result['p1'];
                    $row['period_results'][] = $result['p2'];
                    $row['period_results'][] = $result['p3'];
                    $row['period_results'][] = $result['p4'];
                    $row['period_results'][] = $result['p5'];
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
                foreach($period_list as $period) {
                    if (empty($row['period_results'][$i])) {
                        $row['CF'] = '';
                        break;
                    } else {
                        $row['CF'] += $row['period_results'][$i];// / count($period_list);
                    }
                    $i++;
                }
                if(!empty($row['CF']) && $i>0) $row['CF'] = round($row['CF'] / $i);
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
            
        } else {

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
        $this->load->view('admin/gradingreport/grading_report', $data);
    }

    function changeObservation()
    {
        $index = $this->input->post('index');
        $student_session_id = $this->input->post('student_session_id');
        $data = array(
            'id' => $student_session_id,
            'observation_index' => $index
        );
        $this->Gradingreport_model->changeObservation($data);
        $data = $this->Gradingreport_model->getStudentObservations($student_session_id);
        echo $data;
    }
    public function updatereport()
    {
        if (!$this->rbac->hasPrivilege('grading_report_results', 'can_edit')) {
            access_denied();
        }

        if (isset($_POST)) {
            if (isset($_POST['savealledit'])) {
                $data = $_POST['savealledit'];
                foreach ($data as $stdudents) {
                    $student_session_id = $stdudents['stdId'];
                    foreach ($stdudents['report'] as $indicator) {
                        if ($indicator['name'] != "student_session_id") {
                            $pieces = explode("_", $indicator['name']);
                            $indicators_id = $pieces[1];
                            if (!empty($indicators_id)) {
                                $grading_marker = $this->Gradingreport_model->getReportByIndicator($indicators_id, $student_session_id);
                                if (empty($grading_marker)) {
                                    $data = array(
                                        'student_session_id'       => $student_session_id,
                                        'indicators_id'                  => $indicators_id,
                                        'marks' => $indicator['value'],
                                    );
                                    $this->Gradingreport_model->add_marks($data);
                                } else {
                                    $data = array(
                                        'student_session_id'       => $student_session_id,
                                        'indicators_id'                  => $indicators_id,
                                        'marks' => $indicator['value'],
                                        'id'                  => $grading_marker[0]['id'],
                                    );
                                    $this->Gradingreport_model->add_marks($data);
                                }
                            }
                        }
                    }
                }
                echo json_encode(array('success' => true, 'message' => ''));
                return;
            }
            $student_session_id = $_POST['student_session_id'];
            $data = [];
            foreach ($_POST as $key => $value) {
                if ($key != "student_session_id") {
                    $pieces = explode("_", $key);
                    $indicators_id = $pieces[1];
                    if (!empty($indicators_id) && isset($_POST['indicators_' . $indicators_id])) {
                        $grading_marker = $this->Gradingreport_model->getReportByIndicator($indicators_id, $student_session_id);
                        if (empty($grading_marker)) {
                            $data = array(
                                'student_session_id'       => $student_session_id,
                                'indicators_id'                  => $indicators_id,
                                'marks' => $value,
                            );
                            $this->Gradingreport_model->add_marks($data);
                        } else {
                            $data = array(
                                'student_session_id'       => $student_session_id,
                                'indicators_id'                  => $indicators_id,
                                'marks' => $value,
                                'id'                  => $grading_marker[0]['id'],
                            );
                            $this->Gradingreport_model->add_marks($data);
                        }
                    }
                }
            }
            echo json_encode(array('success' => true, 'message' => ''));
        } else {
            echo json_encode(array('success' => false, 'message' => 'faild edit grading report'));
        }
    }

    public function updatemultistudentsreport()
    {
        if (!$this->rbac->hasPrivilege('grading_report_results', 'can_edit')) {
            access_denied();
        }

        if (isset($_POST) && isset($_POST['subject_group_subjects_id']) && !empty($_POST['subject_group_subjects_id'])) {
            $subject_group_subjects_id = $_POST['subject_group_subjects_id'];

            $data = $_POST['data'];
            foreach ($data as $stdreport) {
                $student_session_id = $stdreport['student_session_id'];
                $reports = $stdreport['report'];
                $postData = [];
                $postData['student_session_id'] = $student_session_id;
                $postData['subject_group_subjects_id'] = $subject_group_subjects_id;
                $grading_marker = $this->Gradingreport_model->getReportByStudentAndSubject($student_session_id, $subject_group_subjects_id);
                /*
                //print_r($reports); die;
                Array
                    (
                        [0] => Array
                            (
                                [name] => p1
                                [value] => 82
                            )

                        [1] => Array
                            (
                                [name] => p2
                                [value] => 82
                            )

                 */
                foreach ($reports as $report) {
                    $key = $report['name'];
                    $value = $report['value'];

                    if(in_array($key, ['p1','p2','p3','p4','p5','CPC','CPEX']))
                        $postData[$key] = empty($value) ? null : $value;
                    if(!in_array($key, ['p1','p2','p3','p4','p5'])) continue;
                    
                    if(empty($grading_marker) || $grading_marker[$key] != $postData[$key])
                        $postData["update_date_$key"] = date("Y-m-d");
                    else
                        unset($postData["update_date_$key"]);
                }
                if (empty($grading_marker)) {
                    $this->Gradingreport_model->add_subjectreport($postData);
                } else {

                    $postData['id'] = $grading_marker['id'];
                    $this->Gradingreport_model->add_subjectreport($postData);
                }
               
            }
            echo json_encode(array('success' => true, 'msg' => 'Grading report has been saved successfully.'));
        } else {
            echo json_encode(array('success' => false, 'msg' => 'Faild edit grading report'));
        }
    }

    public function updatemultistudentsnewreport()
    {
        if (!$this->rbac->hasPrivilege('grading_report_results', 'can_edit')) {
            access_denied();
        }

        if (isset($_POST) && isset($_POST['subject_group_subjects_id']) && !empty($_POST['subject_group_subjects_id'])) {
            $subject_group_subjects_id = $_POST['subject_group_subjects_id'];

            $data = $_POST['data'];
            foreach ($data as $stdreport) {
                $student_session_id = $stdreport['student_session_id'];
                $reports = $stdreport['report'];
                $postData = [];
                $postData['student_session_id'] = $student_session_id;
                $postData['subject_group_subjects_id'] = $subject_group_subjects_id;
                $grading_marker = $this->Gradingreport_model->getReportByStudentAndSubject($student_session_id, $subject_group_subjects_id);
                foreach ($reports as $report) {
                    $key = $report['name'];
                    $value = $report['value'];

                    if(in_array($key, [ 'p11','p12','p13','p14',
                                        'p21','p22','p23','p24',
                                        'p31','p32','p33','p34',
                                        'p41','p42','p43','p44',
                                        'pc1','pc2','pc3','pc4']))
                        $postData[$key] = empty($value) ? null : $value;
                    if(!in_array($key, ['p11','p12','p13','p14',
                                        'p21','p22','p23','p24',
                                        'p31','p32','p33','p34',
                                        'p41','p42','p43','p44',
                                        'pc1','pc2','pc3','pc4'])) continue;
                    
                    if(empty($grading_marker) || $grading_marker[$key] != $postData[$key])
                        $postData["update_date_$key"] = date("Y-m-d");
                    else
                        unset($postData["update_date_$key"]);
                }
                if (empty($grading_marker)) {
                    $this->Gradingreport_model->add_subjectnewreport($postData);
                } else {
                    $postData['id'] = $grading_marker['id'];
                    $this->Gradingreport_model->add_subjectnewreport($postData);
                }
            }
            echo json_encode(array('success' => true, 'msg' => 'Grading report has been saved successfully.'));
        } else {
            echo json_encode(array('success' => false, 'msg' => 'Faild edit grading report'));
        }
    }

    public function updatesubjectreport()
    {
        if (!$this->rbac->hasPrivilege('grading_report_results', 'can_edit')) {
            access_denied();
        }

        if (isset($_POST)) {
            $student_session_id = $_POST['student_session_id'];
            $student = $this->Studentsession_model->searchStudentsBySession($student_session_id);

            $postDatas = array();

            if (isset($_POST['subjectreportkey']) && !empty($_POST['subjectreportkey'])) {
                $pieces = explode("_", $_POST['subjectreportkey']);
                if ($pieces[0] == 'secondaryreport' && ($this->rbac->hasPrivilege('grading_report_results', 'can_delete') || !empty($_POST['subjectreportvalue']))) {
                    $subject_group_subjects_id = $pieces[1];
                    $resultkey = $pieces[2];
                    $postDatas[$subject_group_subjects_id][$resultkey] = empty($_POST['subjectreportvalue']) ? null : $_POST['subjectreportvalue'];
                }
            }

            foreach ($_POST as $key => $pvalue) {
                if ($key == "student_session_id") {
                    continue;
                } else {
                    $pieces = explode("_", $key);
                    if ($pieces[0] == 'secondaryreport' && !empty($pvalue)) {
                        $subject_group_subjects_id = $pieces[1];
                        $resultkey = $pieces[2];
                        $postDatas[$subject_group_subjects_id][$resultkey] = empty($pvalue) ? null : $pvalue;
                    }
                }
            }

            foreach ($postDatas as $subjectkey => $postData) {
                $role = $this->customlib->getStaffRole();
                $role_id = json_decode($role)->id;
                if($role_id == 2)   ///Teacher
                {
                    foreach($postData as $key => $value)
                    {
                        $postData['update_date_'.$key] = date("y-m-d");
                    }
                }
                $postData['student_session_id'] = $student_session_id;
                $postData['subject_group_subjects_id'] = $subjectkey;

                $grading_marker = $this->Gradingreport_model->getReportByStudentAndSubject($student_session_id, $subjectkey);
                //$postData['update_date_'.$subjectkey.substr(1,1)] = date("y-m-d");
                if (empty($grading_marker)) {
                    $this->Gradingreport_model->add_subjectreport($postData);
                } else {
                    $postData['id'] = $grading_marker['id'];
                    $this->Gradingreport_model->add_subjectreport($postData);
                }
            }
            echo json_encode(array('success' => true, 'message' => ''));
        } else {
            echo json_encode(array('success' => false, 'message' => 'faild edit grading report'));
        }
    }

    public function updateObservation(){
        $student_session_id = $this->input->post('student_session_id');
        $observation = $this->input->post('observation');
        $index = $this->input->post('index');

        if(!empty($student_session_id)){
            $this->Studentsession_model->updateById(array('id'=>$student_session_id, 'observations_'.$index =>$observation));
            echo json_encode(array('success' => true, 'message' => 'Observation Saved Successfully'));
        }else{
            json_encode(array('success' => false, 'message' => 'Faild edit observation'));
        }
    }


    public function printCard()
    {
        $class           = $this->input->post('class_id');
        $section         = $this->input->post('section_id');
        $id = $this->input->post('id');
        $period_id = $this->input->post('period_id');
        $this->session->userdata['pageNum'] = 0;
        $order_number = 1;
        if (!empty($id))
        {
            $studentList = array();
            if ($id == 'all') {
                $class           = $this->input->post('class_id');
                $section         = $this->input->post('section_id');
                $search_text     = $this->input->post('search_text');
                $search_type     = $this->input->post('srch_type');
                $classlist       = $this->class_model->get();
                $classlist       = $classlist;
                $carray          = array();
                
                if (!empty($classlist)) {
                    foreach ($classlist as $ckey => $cvalue) {
                        $carray[] = $cvalue["id"];
                    }
                }

                if ($search_type == "search_filter") {
                    $resultlist = $this->student_model->searchdtByClassSection($class, $section);
                } elseif ($search_type == "search_full") {
                    $resultlist = $this->student_model->searchFullText($search_text, $carray);
                }
                $students = json_decode($resultlist,true);
                if (!empty($students['data'])) {
                    foreach ($students['data'] as $student) {
                        $studentList[] = $student;
                    }
                }
            } else {

                $resultlist = $this->student_model->searchdtByClassSection($class, $section);
                $students = json_decode($resultlist,true);

                if (!empty($students['data'])) {
                    $order_number = 0;
                    foreach ($students['data'] as $student) {
                        $order_number++;
                        if($student['id'] == $id )
                           break;
                    }
                }
                $student = $this->student_model->get($id);
                $studentList[] = $student;
            }

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
                    if($data['level'] == "NIVEL INICIAL")
                        $class_id = 3;
                    else
                        $class_id = 42;
                    $valuescale = $this->Gradingreport_model->getValuescaleByClass($class_id);
                    $data['valuescaleList'] = $valuescale;
                    $data['order_number'] = $order_number;
                    $student_admit_cards = $this->load->view('admin/gradingreport/reportview', $data, true);
                    $renderprintpage .= " ". $student_admit_cards. " ";
                    $order_number++;
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
                    }
                    $data['pageNum'] = $this->session->userdata['pageNum'];
                    $data['grading_subject_results'] = $grading_subject_results;
                    $seconday_grading_report_cards = $this->load->view('admin/gradingreport/_secondaryreportview', $data, true);
                    $renderprintpage .= " ". $seconday_grading_report_cards. " ";
                }
            }
            $array = array('status' => '1', 'error' => '', 'page' => $renderprintpage);
            echo json_encode($array);
        }
    }
    public function permissionteacher()
    {
        if (!$this->rbac->hasPrivilege('grading_report_valuescale', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'GradingReport');
        $this->session->set_userdata('sub_menu', 'GradingReport/permissionteacher');

        $userdata = $this->customlib->getUserData();
        $role_id = $userdata["role_id"];
        
        if($role_id == 51) //primary
        {
            $level_id = 42;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
            $levelperiod_list = $this->Gradingreport_model->getPeriodByLevel($level_id);
        }
        else if($role_id == 52) //secondary
        {
            $level_id = 43;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
            $levelperiod_list = $this->Gradingreport_model->getPeriodByLevel($level_id);
        }
        else if($role_id == 53) //initial
        {
            $level_id = 41;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
            $levelperiod_list = $this->Gradingreport_model->getPeriodByLevel($level_id);
        }
        else
        {
            
            $role_id = 0;
            $data['selected_level_id'] = $selected_level_id = $this->input->post('level_id');
            $level_id = !empty($selected_level_id) ? $selected_level_id : 43;
            //$level_id = 0;

            $class_list = $this->class_model->get();
            $levelperiod_list = $this->Gradingreport_model->getPeriodByLevel($level_id);
        }
        
        $data['view_role_id'] = $role_id;
        $data['class_list'] = $class_list;
        $data['levelperiod_list'] = $levelperiod_list;
        $data['levellist']  = $this->Level_model->getLevelList();
        
        $all_check_flag = [1,1,1,1,1,1,1,1,1,1,1,1,1];
        $check_flag = [];
        $result = $this->staff_model->get_permission(0, $data['selected_level_id']);
        foreach($result as $key=> $staff)
        {
            foreach($levelperiod_list as $item)
            {
                $check_flag[$staff['staff_id']][] = '0';
            }
            for($i =0; $i < strlen($staff['is_permission']);$i++)
            {
               if(substr($staff['is_permission'],$i,1) == 1)
               {
                   $check_flag[$staff['staff_id']][$i] = 1;
               }
               $all_check_flag[$i] = $all_check_flag[$i] & $check_flag[$staff['staff_id']][$i];
            }
        }
        $data['check_flag'] = $check_flag;
        $data['all_check_flag'] = $all_check_flag;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/gradingreport/permissionteacher', $data);
        $this->load->view('layout/footer', $data);
    }

    public function getteacherslist($level_id=0)
    {

        $userdata = $this->customlib->getUserData();
        $role_id = $userdata["role_id"];
        
        if($role_id == 51) //primary
        {
            $level_id = 42;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
            $levelperiod_list = $this->Gradingreport_model->getPeriodByLevel($level_id);
        }
        else if($role_id == 52) //secondary
        {
            $level_id = 43;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
            $levelperiod_list = $this->Gradingreport_model->getPeriodByLevel($level_id);
        }
        else if($role_id == 53) //initial
        {
            $level_id = 41;
            $class_list = $this->Gradingreport_model->getClassByLevel($level_id);
            $levelperiod_list = $this->Gradingreport_model->getPeriodByLevel($level_id);
        }
        else
        {
            $class_list = $this->class_model->get();
            $levelperiod_list = $this->Gradingreport_model->getPeriodByLevel($level_id);
        }
        // $data['class_list'] = $class_list;
        // $data['levelperiod_list'] = $levelperiod_list;
        
        

        $result = $this->Gradingreport_model->getteacherlist($level_id);
        $m       = json_decode($result);
        $dt_data = array();
        if (!empty($m->data)) {
            foreach ($m->data as $key => $value) {
                // if (in_array($value->classid, $class_array)) {
                $row       = array();
                $row[0] = $value->name;
                for($i = 0; $i < count($levelperiod_list); $i++)
                {
                    if(strlen($value->is_permission)>=count($levelperiod_list) && substr($value->is_permission,$i,1) == 1)
                    {
                        $btn = "<div onclick='changepermission(event, $i, $value->id, $value->staff_id)'
                     class='btn btn-default btn-xs'
                     ><i class='fa fa-check'></i></div>";
                    }
                    else
                    {
                        $btn = "<div onclick='changepermission(event, $i, $value->id, $value->staff_id)'
                     class='btn btn-default btn-xs'
                     ><i class='fa fa-remove '></i></div>";
                    }
                    $row[$i + 1] = $btn;
                }
                $dt_data[] = $row;
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
    public function changepermission()
    {
        $index = $_POST['index'];
        $staff_roles_id = $_POST['staff_roles_id'];
        $staff_id = $_POST['staff_id'];
        $permission = $this->staff_model->get_permission($staff_roles_id);
        
        if(substr($permission,$index,1) == 0)
        {
            $permission = substr_replace($permission,'1',$index,1);
        }
        else{
            $permission = substr_replace($permission,'0',$index,1);
        }

        $data['id'] = $staff_roles_id;

        $data['is_permission'] = $permission;
        $this->staff_model->updatepermission($data);
        echo json_encode(array('success' => true, 'message' => 'Update Successfully'));
    }
    public function changeallpermission()
    {
        $index = $_POST['index'];
        $permission = $_POST['permission']; $permission = 1-$permission ;
        $level_id = $_POST['level_id'];
        $result = $this->staff_model->get_permission(0);    //, $level_id
        //print_r($result); die;
        foreach($result as $key=> $value)
        {
            $is_permission = $value['is_permission'] ."00000000000000000000";  //20 numbers
            $is_permission = substr($is_permission, 0, 12);   
            $is_permission = substr_replace($is_permission, $permission, $index, 1);

            $data['id'] = $value['id'];
            $data['is_permission'] = $is_permission; 
            
            $this->staff_model->updatepermission($data);
        }
        echo json_encode(array('success' => true, 'message' => 'Update Successfully'));
    }

    public function GradingResult()
    { 
        if (!$this->rbac->hasPrivilege('grading_report_results', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'GradingReport');
        $this->session->set_userdata('sub_menu', 'GradingReport/GradingResult');
        $userdata                   = $this->customlib->getUserData();
        $role_id                    = $userdata["role_id"];
        $staff_id                   = $userdata["id"];
        $level_id                   = 43;
        $class_list                 = $this->Gradingreport_model->getClassByLevel($level_id);
        $data['classlist']          = $class_list;
        $data['sectionlist']            = $this->section_model->get();
        $data['period_list']        = $this->Gradingreport_model->getPeriodByLevel($level_id); 
        $data['session_list']        = $this->Session_model->getAllSession(); 
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('session_id', $this->lang->line('session'), 'trim|required|xss_clean');
        
        if ($this->form_validation->run() == false) {
           
        } 
        else {
            
            $class_id                   = $_POST['class_id'];
            $section_id                 = $_POST['section_id'];
            $session_id                 = $_POST['session_id'];
            $data["class_id"]           = $class_id;
            $data["section_id"]         = $section_id;
            $data["session_id"]         = $session_id;
            $data['mark']               = 'CF';
            $data['students']           = $this->student_model->getStudent_nameOrder($class_id,$section_id);
            $data['curse']              = $this->Gradingreport_model->getclassname($class_id);
            $data['subject_list']       = $this->subjectgroup_model->getsubjectByclassidAndPeriod($class_id);
            $studentlist                = $this->student_model->getStudent_gradingresult_with_session($class_id,$section_id, false, 4, $session_id); 
            $data['studentlist']        = $studentlist;    
        }
        $this->load->view('layout/header', $data);
        $this->load->view('admin/gradingreport/grading', $data);
        $this->load->view('layout/footer', $data);
    }
    public function printGradingResult()
    {
        $class_id                       = $_POST['class_id'];
        $data["class_id"]               = $class_id;
        $section_id                     = $_POST['section_id'];
        $data["section_id"]             = $section_id;
        $session_id                     = $_POST['session_id']; 
        $data["session_id"]             = $session_id;
        $data['mark']                   = 'CF';
        $data['students']               = $this->student_model->getStudent_nameOrder($class_id,$section_id);
        $data['curse']                  = $this->Gradingreport_model->getclassname($class_id);
        $data['subject_list']           = $this->subjectgroup_model->getsubjectByclassidAndPeriod($class_id);
        $studentlist                    = $this->student_model->getStudent_gradingresult_with_session($class_id,$section_id, false, 4, $session_id); 
        $data['studentlist']            = $studentlist;
        $renderprintpage                = $this->load->view('admin/gradingreport/printgradingresult', $data, true);
        $array = array('status' => '1', 'error' => '', 'page' => $renderprintpage);
        echo json_encode($array);
    }


    public function GradingResult_CF()
    {
        if (!$this->rbac->hasPrivilege('grading_report_results', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'GradingReport');
        $this->session->set_userdata('sub_menu', 'GradingReport/GradingResult_CF');
        $userdata                   = $this->customlib->getUserData();
        $role_id                    = $userdata["role_id"];
        $staff_id                   = $userdata["id"];
        $level_id                   = 43;
        $class_list                 = $this->Gradingreport_model->getClassByLevelandSession($level_id,$Session_id);
        $data['classlist']          = $class_list;
        $data['sectionlist']        = $this->section_model->get();
        $data['period_list']        = $this->Gradingreport_model->getPeriodByLevelandSession($level_id,$session_id); 
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            
        } 
        else 
        {
            $class_id                   = $_POST['class_id'];
            $section_id                 = $_POST['section_id'];
			$session_id = $_POST['session_id'];
            $data["class_id"]           = $class_id;
            $data["section_id"]         = $section_id;
			$data["session_id"]         = $session_id;
            $data['mark']               = 'CF';
            $data['students']           = $this->student_model->getStudent_nameOrder($class_id,$section_id);
            $data['curse']              = $this->Gradingreport_model->getclassname($class_id);
            $data['subject_list']       = $this->subjectgroup_model->getsubjectByclassidAndPeriod($class_id);
            $studentlist                = $this->student_model->getStudent_gradingresult($class_id,$section_id,true);
            $data['studentlist']        = $studentlist;    
        }
        $this->load->view('layout/header', $data);
        $this->load->view('admin/gradingreport/grading_CF', $data);
        $this->load->view('layout/footer', $data);
    }
    public function printGradingResult_CF()
    {
        $class_id                       = $_POST['class_id'];
        $data["class_id"]               = $class_id;
        $section_id                     = $_POST['section_id'];
        $data["section_id"]             = $section_id;
        $data['mark']                   = 'CF';
        $data['students']               = $this->student_model->getStudent_nameOrder($class_id,$section_id);
        $data['curse']                  = $this->Gradingreport_model->getclassname($class_id);
        $data['subject_list']           = $this->subjectgroup_model->getsubjectByclassidAndPeriod($class_id);
        $studentlist                    = $this->student_model->getStudent_gradingresult($class_id,$section_id,true);
        $data['studentlist']            = $studentlist;
        $renderprintpage                = $this->load->view('admin/gradingreport/printgradingresult_CF', $data, true);
        $array = array('status' => '1', 'error' => '', 'page' => $renderprintpage);
        echo json_encode($array);
    }

}


