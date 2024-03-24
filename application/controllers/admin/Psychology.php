<?php

class Psychology extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model("Psychology_model");
        $this->load->library(array('mailer', 'form_builder', 'mailsmsconf'));
    }

    function index()
    {
        if (!$this->rbac->hasPrivilege('psychology_search', 'can_view')) {
            access_denied();
        }
        $data = [];
        $class                   = $this->class_model->get();
        $data['classlist']       = $class;
        $this->session->set_userdata('top_menu', 'Psychology');
        $this->session->set_userdata('sub_menu', 'Psychology/index');
        $this->form_validation->set_rules('student_id', $this->lang->line('student_id'), 'required');
        $this->form_validation->set_rules('description', $this->lang->line('description'), 'required');
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'required');
        $this->form_validation->set_rules('file', $this->lang->line('file'), 'callback_handle_upload[file]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view("layout/header");
            $this->load->view("admin/psychology/index", $data);
            $this->load->view("layout/footer");
        } else {
            $created_by = 0;
            $encryp_key = '';
            $user_info = $this->customlib->getUserData();

            if (!empty($user_info)) {
                $created_by = $user_info["id"];
                $encryp_key = $user_info["id"] . "_" . $user_info['email'];
            }
            $psychology_id = 0;

            if ($this->input->post('submit') == "sendmail") {
                $email_subject = $this->lang->line('psychology_mail_subject');
                $this->mailer->send_mail($this->input->post('guardian_email'), $email_subject, $this->input->post('description'));
                $this->session->set_flashdata('psychology_msg', '<div class="alert alert-success">' . $this->lang->line('send_mail_success') . '</div>');
                redirect('admin/psychology');
            }else{

                if (empty($this->input->post('psychology_id'))) {
                    // add psychology
                    if (!$this->rbac->hasPrivilege('psychology_search', 'can_add')) {
                        access_denied();
                    }
                    $created_at = date("Y-m-d H:i:s");
                    $psychology = array(
                        'student_id' => $this->input->post('student_id'),
                        'description' => $this->aes->encode($this->input->post('description'), $encryp_key),
                        'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                        'created_by' => $created_by,
                        'created_at' => $created_at
                    );
                    $psychology_id = $this->Psychology_model->add($psychology);
                } else {
                    // edit psychology
                    if (!$this->rbac->hasPrivilege('psychology_search', 'can_edit')) {
                        access_denied();
                    }
                    $psychology_id = $this->input->post('psychology_id');
                    $psychology = array(
                        'student_id' => $this->input->post('student_id'),
                        'description' => $this->aes->encode($this->input->post('description'), $encryp_key),
                        'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                        'created_by' => $created_by,
                    );
                    $this->Psychology_model->update($psychology_id, $psychology);
                }

                // file upload and update table
                if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                    $fileInfo = pathinfo($_FILES["file"]["name"]);
                    $temp_filename = 'id' . $psychology_id . '.' . $fileInfo['extension'];
                    $file_name = $this->aes->encode($temp_filename, $encryp_key);
                    move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/psychology/" . $temp_filename);
                    $this->Psychology_model->attach_file_add($psychology_id, $file_name);
                }
                redirect('admin/psychology');
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

    public function getPsychologyListByStudentId()
    {
        $student_id = $this->input->post('student_id');
        $admission_no = $this->input->post('admission_no');
        $student_name = $this->input->post('student_name');
        $guardian_name = $this->input->post('guardian_name');
        $guardian_phone1 = $this->input->post('guardian_phone1');
        $guardian_phone2 = $this->input->post('guardian_phone2');
        $guardian_email = $this->input->post('guardian_email');
        $dt_data  = array();

        $resultlist = $this->Psychology_model->getPsychologyListByStudentId($student_id);
        $psychologys = json_decode($resultlist);
        if (!empty($psychologys->data)) {
            foreach ($psychologys->data as $key => $psychology) {
                $encryp_key = $psychology->created_by . "_" . $psychology->staff_email;
                $row   = array();
                $row[] = $psychology->id;

                $description = "<p class='tb-p'>" . $this->aes->decode($psychology->description, $encryp_key) . "</p>";
                $row[] = $description;

                $attach_tag = "";
                if (!empty($psychology->attach_file)) {
                    $attach_tag = "<a href='" . base_url() . "admin/psychology/download/" . $this->aes->decode($psychology->attach_file, $encryp_key) . "'>" . $this->aes->decode($psychology->attach_file, $encryp_key) . "&nbsp;<i class='fa fa-download'></i></a>";
                }
                $row[] = $attach_tag;
                $staff = $psychology->staff_name . "(" . $psychology->role_name . ")";
                $row[] = $staff;
                $row[] = $this->customlib->dateformat($psychology->date);

                $editbtn = "";
                if ($this->rbac->hasPrivilege('psychology_search', 'can_edit')) {
                    $editbtn = "<a onclick='selectePsychology(\"" . $student_id . "\",\"" . $student_name . "\",\"" . $psychology->id . "\",\"" . $admission_no . "\",\"" . $guardian_name . "\",\"" . $guardian_phone1 . "\",\"" . $guardian_phone2 . "\",\"" . $guardian_email . "\")'   class='btn btn-default btn-xs'  data-toggle='tooltip' data-placement='left' title='" . $this->lang->line('edit') . "'><i class='fa fa-pencil'list></i></a>";
                }

                $deletebtn = "";
                if ($this->rbac->hasPrivilege('psychology_search', 'can_delete')) {
                    $deletebtn = "<a onclick='deletePsychology(\"" . $student_id . "\",\"" . $student_name . "\",\"" . $psychology->id . "\",\"" . $admission_no . "\",\"" . $guardian_name . "\",\"" . $guardian_phone1 . "\",\"" . $guardian_phone2 . "\",\"" . $guardian_email . "\")'   class='btn btn-default btn-xs'  data-toggle='tooltip' data-placement='left' title='" . $this->lang->line('delete') . "'><i class='fa fa-remove'list></i></a>";
                }

                $row[] = $editbtn . " " . $deletebtn;
                $dt_data[] = $row;
            }
        }

        $json_data           = array(
            "draw"                => intval($psychologys->draw),
            "recordsTotal"        => intval($psychologys->recordsTotal),
            "recordsFiltered"     => intval($psychologys->recordsFiltered),
            "data"                => $dt_data,
        );
        echo json_encode($json_data);
    }

    public function getPsychology()
    {
        $psychology_id = $this->input->post('psychology_id');
        $result = $this->Psychology_model->getpsychology($psychology_id);

        if (!empty($result)) {
            $encryp_key = $result['created_by'] . "_" . $result['staff_email'];
            $result['description'] =  $this->aes->decode($result['description'], $encryp_key);
            $ret = array('status' => 'success', 'result' => $result);
        } else {
            $ret = array('status' => 'failed', 'result' => array());
        }
        echo json_encode($ret);
    }

    public function deletePsychology()
    {
        if (!$this->rbac->hasPrivilege('psychology_dept_search', 'can_delete')) {
            access_denied();
        }
        $psychology_id = $this->input->post('psychology_id');
        if (!empty($psychology_id)) {
            $this->Psychology_model->delete($psychology_id);
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
        $filepath = "./uploads/psychology/" . $file_name;
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

                if ($this->rbac->hasPrivilege('psychology_search', 'can_add')) {
                    $addbtn = "<a onclick='selectePsychology(\"" . $student->id . "\",\"" . $student_full_name . "\",\"0\",\"" . $admission_no . "\",\"" . $guardian_name . "\",\"" . $guardian_phone1 . "\",\"" . $guardian_phone2 . "\",\"" . $guardian_email . "\")'   class='btn btn-default btn-xs'  data-toggle='tooltip' data-placement='left' title='" . $this->lang->line('add') . "'><i class='fa fa-plus-circle'list></i></a>";
                }
                $viewbtn = "<a onclick='showPsychologyList(\"" . $student->id . "\",\"" . $student_full_name . "\",\"" . $admission_no . "\",\"" . $guardian_name . "\",\"" . $guardian_phone1 . "\",\"" . $guardian_phone2 . "\",\"" . $guardian_email . "\")' class='btn btn-default btn-xs'  data-toggle='tooltip' data-placement='left' title='" . $this->lang->line('view') . "'><i class='fa fa-eye'></i></a>";
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
