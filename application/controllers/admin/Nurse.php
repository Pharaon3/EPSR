<?php
class Nurse extends Admin_Controller
{
    public $sch_setting_detail = array();

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model("Nurse_model");
        $this->sch_setting_detail = $this->setting_model->getSetting();
    }

    function index()
    {
        if (!$this->rbac->hasPrivilege('nurse_dept_search', 'can_view')) {
            access_denied();
        }
        $data = [];
        $class                   = $this->class_model->get();
        $data['classlist']       = $class;
        $this->session->set_userdata('top_menu', 'Nurse_Dept');
        $this->session->set_userdata('sub_menu', 'Nurse_Dept/index');
        $this->form_validation->set_rules('student_id', $this->lang->line('student_id'), 'required');
        $this->form_validation->set_rules('description', $this->lang->line('description'), 'required');
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'required');
        $this->form_validation->set_rules('file', $this->lang->line('file'), 'callback_handle_upload[file]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view("layout/header");
            $this->load->view("admin/nurse/index", $data);
            $this->load->view("layout/footer");
        } else {
            $created_by = 0;
            $encryp_key = '';
            $user_info = $this->customlib->getUserData();

            if (!empty($user_info)) {
                $created_by = $user_info["id"];
                $encryp_key = $user_info["id"] . "_" . $user_info['email'];
            }
            $nurse_id = 0;

            if ($this->input->post('submit') == "sendmail") {
                $email_subject = $this->lang->line('nurse_mail_subject');
                $this->mailer->send_mail($this->input->post('guardian_email'), $email_subject, $this->input->post('description'));
                $this->session->set_flashdata('nurse_msg', '<div class="alert alert-success">' . $this->lang->line('send_mail_success') . '</div>');
                redirect('admin/nurse');
            }else{
                if (empty($this->input->post('nurse_id'))) {
                    // add nurse
                    if (!$this->rbac->hasPrivilege('nurse_dept_search', 'can_add')) {
                        access_denied();
                    }
                    $created_at = date("Y-m-d H:i:s");
                    $nurse = array(
                        'student_id' => $this->input->post('student_id'),
                        'description' => $this->aes->encode($this->input->post('description'), $encryp_key),
                        'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                        'created_by' => $created_by,
                        'created_at' => $created_at
                    );
                    $nurse_id = $this->Nurse_model->add($nurse);
                } else {
                    // edit nurse
                    if (!$this->rbac->hasPrivilege('nurse_dept_search', 'can_edit')) {
                        access_denied();
                    }

                    $nurse_id = $this->input->post('nurse_id');
                    $nurse = array(
                        'student_id' => $this->input->post('student_id'),
                        'description' => $this->aes->encode($this->input->post('description'), $encryp_key),
                        'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                        'created_by' => $created_by,
                    );
                    $this->Nurse_model->update($nurse_id, $nurse);
                }

                // file upload and update table
                if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                    $fileInfo = pathinfo($_FILES["file"]["name"]);
                    $temp_filename = 'id' . $nurse_id . '.' . $fileInfo['extension'];
                    $file_name = $this->aes->encode($temp_filename, $encryp_key);
                    move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/nurse/" . $temp_filename);
                    $this->Nurse_model->attach_file_add($nurse_id, $file_name);
                }
                redirect('admin/nurse');
            }
        }
    }

    public function handle_upload($str, $var)
    {

        $image_validate = $this->config->item('file_validate');
        $result = $this->filetype_model->get();
        if (isset($_FILES[$var]) && !empty($_FILES[$var]['name'])) {

            $file_type         = $_FILES[$var]['type'];
            $file_size         = $_FILES[$var]["size"];
            $file_name         = $_FILES[$var]["name"];

            $allowed_extension = array_map('trim', array_map('strtolower', explode(',', $result->file_extension)));
            $allowed_mime_type = array_map('trim', array_map('strtolower', explode(',', $result->file_mime)));
            $ext               = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if ($files = filesize($_FILES[$var]['tmp_name'])) {

                if (!in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', 'File Type Not Allowed');
                    return false;
                }

                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', 'Extension Not Allowed');
                    return false;
                }
                if ($file_size > $result->file_size) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload', "File Type / Extension Error Uploading  Image");
                return false;
            }

            return true;
        }
        return true;
    }

    public function getNurseListByStudentId()
    {
        $student_id = $this->input->post('student_id');
        $admission_no = $this->input->post('admission_no');
        $student_name = $this->input->post('student_name');
        $guardian_name = $this->input->post('guardian_name');
        $guardian_phone1 = $this->input->post('guardian_phone1');
        $guardian_phone2 = $this->input->post('guardian_phone2');
        $guardian_email = $this->input->post('guardian_email');
        $dt_data  = array();

        $resultlist = $this->Nurse_model->getNurseListByStudentId($student_id);
        $nurses = json_decode($resultlist);
        if (!empty($nurses->data)) {
            foreach ($nurses->data as $key => $nurse) {
                $encryp_key = $nurse->created_by . "_" . $nurse->staff_email;
                $row   = array();
                $row[] = $nurse->id;

                $description = "<p class='tb-p'>" . $this->aes->decode($nurse->description, $encryp_key) . "</p>";
                $row[] = $description;

                $attach_tag = "";
                if (!empty($nurse->attach_file)) {
                    $attach_tag = "<a href='" . base_url() . "admin/nurse/download/". $this->aes->decode($nurse->attach_file, $encryp_key) ."'>" . $this->aes->decode($nurse->attach_file, $encryp_key) . "&nbsp;<i class='fa fa-download'></i></a>";
                }
                $row[] = $attach_tag;
                $staff = $nurse->staff_name . "(" . $nurse->role_name . ")";
                $row[] = $staff;
                $row[] = $this->customlib->dateformat($nurse->date);

                $editbtn = "";
                if ($this->rbac->hasPrivilege('nurse_dept_search', 'can_edit')) {
                    $editbtn = "<a onclick='selecteNurse(\"" . $student_id . "\",\"" . $student_name . "\",\"" . $nurse->id . "\",\"" . $admission_no . "\",\"" . $guardian_name . "\",\"" . $guardian_phone1 . "\",\"" . $guardian_phone2 . "\",\"" . $guardian_email . "\")'   class='btn btn-default btn-xs'  data-toggle='tooltip' data-placement='left' title='" . $this->lang->line('edit') . "'><i class='fa fa-pencil'list></i></a>";
                }

                $deletebtn = "";
                if ($this->rbac->hasPrivilege('nurse_dept_search', 'can_delete')) {
                    $deletebtn = "<a onclick='deleteNurse(\"" . $student_id . "\",\"" . $student_name . "\",\"" . $nurse->id . "\",\"" . $admission_no . "\",\"" . $guardian_name . "\",\"" . $guardian_phone1 . "\",\"" . $guardian_phone2 . "\",\"" . $guardian_email . "\")'   class='btn btn-default btn-xs'  data-toggle='tooltip' data-placement='left' title='" . $this->lang->line('delete') . "'><i class='fa fa-remove'list></i></a>";
                }

                $row[] = $editbtn . " " . $deletebtn;
                $dt_data[] = $row;
            }
        }

        $json_data           = array(
            "draw"                => intval($nurses->draw),
            "recordsTotal"        => intval($nurses->recordsTotal),
            "recordsFiltered"     => intval($nurses->recordsFiltered),
            "data"                => $dt_data,
        );
        echo json_encode($json_data);
    }

    public function getNurse()
    {
        $nurse_id = $this->input->post('nurse_id');
        $result = $this->Nurse_model->getNurse($nurse_id);

        if (!empty($result)) {
            $encryp_key = $result['created_by'] . "_" . $result['staff_email'];
            $result['description'] =  $this->aes->decode($result['description'], $encryp_key);
            $ret = array('status' => 'success', 'result' => $result);
        } else {
            $ret = array('status' => 'failed', 'result' => array());
        }
        echo json_encode($ret);
    }

    public function deleteNurse()
    {
        if (!$this->rbac->hasPrivilege('nurse_dept_search', 'can_delete')) {
            access_denied();
        }
        $nurse_id = $this->input->post('nurse_id');
        if (!empty($nurse_id)) {
            $this->Nurse_model->delete($nurse_id);
            $ret = array('status' => 'success');
        } else {
            $ret = array('status' => 'failed');
        }
        echo json_encode($ret);
    }

    public function download($file_name)
    {
        $this->load->helper('download');
        $name     = $this->uri->segment(4);
        $ext      = explode(".", $name);
        $filepath = "./uploads/nurse/" . $file_name;
        $data     = file_get_contents($filepath);
        force_download($name, $data);
    }

    public function dtstudentlist()
    {
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
            foreach ($students->data as $student_key => $student) {
                $addbtn   = '';
                $viewbtn   = '';
                $admission_no = $student->admission_no;
                $student_full_name = $this->customlib->getFullName($student->firstname, $student->middlename, $student->lastname, $sch_setting->middlename, $sch_setting->lastname);
                $guardian_name = $student->guardian_name;
                $guardian_phone1 = $student->guardian_phone;
                $guardian_phone2 = "";
                if ($student->guardian_is == "father") {
                    $guardian_phone2 = $student->mother_phone;
                } elseif ($student->guardian_is == "mother") {
                    $guardian_phone2 = $student->father_phone;
                } else {
                    $guardian_phone2 = !empty($student->father_phone) ? $student->father_phone : $student->mother_phone;
                }
                $guardian_email = $student->guardian_email;
                if ($this->rbac->hasPrivilege('nurse_dept_search', 'can_add')) {
                    $addbtn = "<a onclick='selecteNurse(\"" . $student->id . "\",\"" . $student_full_name . "\",\"0\",\"" . $admission_no . "\",\"" . $guardian_name . "\",\"" . $guardian_phone1 . "\",\"" . $guardian_phone2 . "\",\"" . $guardian_email . "\")'   class='btn btn-default btn-xs'  data-toggle='tooltip' data-placement='left' title='" . $this->lang->line('add') . "'><i class='fa fa-plus-circle'list></i></a>";
                }
                $viewbtn = "<a onclick='showNurseList(\"" . $student->id . "\",\"" . $student_full_name . "\",\"" . $admission_no . "\",\"" . $guardian_name . "\",\"" . $guardian_phone1 . "\",\"" . $guardian_phone2 . "\",\"" . $guardian_email . "\")' class='btn btn-default btn-xs'  data-toggle='tooltip' data-placement='left' title='" . $this->lang->line('view') . "'><i class='fa fa-eye'></i></a>";
                $row   = array();
                $row[] = $student->admission_no;
                $row[] = $student_full_name;
                $row[] = $student->class . "(" . $student->section . ")";
                $row[] = $this->customlib->dateformat($student->dob);

                $row[] = $student->gender;
                $row[] =  $addbtn . '' . $viewbtn;
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
}