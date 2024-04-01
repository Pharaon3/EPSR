<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gradingreport_model extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month = $this->setting_model->getStartMonth();
    }

    public function getPeriodlist( $level_id ){
        return $this->db->select('*')->from('periods')->where('level_id', $level_id)->get()->result_array();
    }

    public function getLevelList( $id = null ){
        $this->db->select('*')->from('levels');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            $levellist = $query->row_array();
        } else {
            $levellist = $query->result_array();
        }
        return $levellist;
    }

    public function addLevel($data) {

        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id']) && $data['id'] != '') {

            $this->db->where('id', $data['id']);
            $query = $this->db->update('levels', $data);
            $insert_id = $data['id'];
            $message = UPDATE_RECORD_CONSTANT . " On levels id " . $insert_id;
            $action = "Update";
            $record_id = $insert_id;
        } else {
            $this->db->insert('levels', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On levels id " . $insert_id;
            $action = "Insert";
            $record_id = $insert_id;
        }

        $this->log($message, $record_id, $action);

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            return $insert_id;
        }
    }

    public function deleteLevel($id) {
        $this->db->where("id", $id)->delete('levels');
    }
    

    public function getCompetencelist($session, $competence = true) 
    {
        $this->datatables
            ->select('grading_competences.id, grading_competences.name, grading_competences.class_id, grading_competences.period_id, grading_competences.subject_id, levels.level as level,levels.id as level_id, periods.label as period, periods.start_month as start_month,periods.end_month as end_month,classes.class as class')
            ->searchable('levels.level,classes.class,periods.label,grading_competences.name')
            ->orderable('levels.level,classes.class,periods.label,grading_competences.name')
        ->join("classes", "classes.id = grading_competences.class_id")
        ->join("periods", "periods.id = grading_competences.period_id")
        ->join("level_class", "classes.id = level_class.class_id")
        ->join("levels", "level_class.level_id = levels.id")
        ->join("levels as period_levels", "periods.level_id = period_levels.id AND period_levels.id = levels.id")
        ->from('grading_competences')
        ->where('session_id', $session);
        if($competence){
            $this->datatables->group_by("grading_competences.class_id, grading_competences.period_id");
        }
         return $this->datatables->generate('json');
    }

    public function getCompetences($session_id, $class_id = null, $period_id = null) {

        $userdata = $this->customlib->getUserData();
        $role_id = $userdata["role_id"];

        $this->db->select('grading_competences.*, subjects.name as subject, subjects.code as subject_code')->from('grading_competences')->join("subject_group_subjects", "subject_group_subjects.id = grading_competences.subject_id","left")->join("subjects", "subjects.id = subject_group_subjects.subject_id","left")->where('grading_competences.session_id', $session_id);
        if(!empty($class_id)){
            $this->db->where('grading_competences.class_id', $class_id);
        }
        if(!empty($period_id)){
            $this->db->where('grading_competences.period_id', $period_id);
        }

        if (isset($role_id) && ($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {
            $my_subjects = $this->teacher_model->get_subjectby_staffid($userdata['id']);
            $this->db->where_in('grading_competences.subject_id', explode(",", $my_subjects['subject']));
        }
        $this->db->order_by('subjects.order','desc');
        return $this->db->get()->result_array();
    }

    public function getCompetence($id) {
        $this->db->select('*')->from('grading_competences');
        $this->db->where('id', $id);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function add_competence($data) {

        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id']) && $data['id'] != '') {

            $this->db->where('id', $data['id']);
            $query = $this->db->update('grading_competences', $data);
            $insert_id = $data['id'];
            $message = UPDATE_RECORD_CONSTANT . " On grading_competence id " . $insert_id;
            $action = "Update";
            $record_id = $insert_id;
        } else {
            $this->db->insert('grading_competences', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On grading_competences id " . $insert_id;
            $action = "Insert";
            $record_id = $insert_id;
        }

        $this->log($message, $record_id, $action);

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            return $insert_id;
        }
    }

    public function getClassByLevel($level_id) {
        $this->db->select('classes.id,classes.class');
        $this->db->from('level_class');
        $this->db->join('classes', 'classes.id = level_class.class_id');
        if(!empty($level_id))
            $this->db->where('level_class.level_id', $level_id);
        $this->db->order_by('classes.id');
        $query = $this->db->get();
        $classes = $query->result_array();
        return $classes;
    }
    
    public function getPeriodEnabledByStaffId($staff_id, $level_id=0) {
        $this->db->select('is_permission, role_id');
        $this->db->from('staff_roles');
        $this->db->where('staff_id', $staff_id);
        $premission = $this->db->get()->result_array();
        if(count($premission)==0)   return [];
        $is_permission = $premission[0]['is_permission'];

        if( $premission[0]['role_id']==7 ||
            $premission[0]['role_id']==1 ||
            $premission[0]['role_id']==51 ||
            $premission[0]['role_id']==52 ||
            $premission[0]['role_id']==53
            )
            {
                $is_permission='111111111111';
            } 
            
        $permmit = [];
        for($i=0; $i<strlen($is_permission); $i++)
        {
            $permmit[] = substr($is_permission, $i,1);
        }
        $this->db->select('periods.*,levels.level');
        $this->db->from('periods');
        $this->db->join('levels', 'levels.id = periods.level_id');
        if(!empty($level_id))
            $this->db->where('periods.level_id', $level_id);
        $this->db->where('levels.is_active', 'yes');
        $this->db->order_by('periods.label');
        $query = $this->db->get();
        $section = $query->result_array();
        $i=0; $result = [];
        foreach($section as $period_item)
        {
            //if( !empty($permmit[$i]) )
            {
                $period_item['start'] = date('m', strtotime($period_item['start_month']));
                $period_item['end'] = date('m', strtotime($period_item['end_month']));
                $period_item['canedit'] = $permmit[$i];
                $iMonth = $period_item['start'];
                //$result[$period_item['level_id'] . $iMonth] = $period_item;
                $result[$period_item['level_id'] . "" . $iMonth] = $period_item;
                //print($period_item['level_id'] . "-" . $iMonth."<br>");
            }
            $i++;
        }
        ksort($result);
        return $result;
    }

    public function getPeriodByLevel($level_id) {
        $this->db->select('periods.*,levels.level');
        $this->db->from('periods');
        $this->db->join('levels', 'levels.id = periods.level_id');
        if(!empty($level_id))
            $this->db->where('periods.level_id', $level_id);
        $this->db->where('levels.is_active', 'yes');
        $this->db->order_by('periods.level_id');
        $this->db->order_by('periods.label');
        $query = $this->db->get();
        $section = $query->result_array();
        return $section;
    }

    public function getPeriod($id) {
        $this->db->select('periods.*');
        $this->db->from('periods');
        $this->db->where('periods.id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function deleteCompetence($id) {
        $this->db->where("id", $id)->delete('grading_competences');
    }

    public function deleteCompetenceBulk($session, $class_id, $period_id) {
        $this->db->where("class_id", $class_id)->where("period_id", $period_id)->where("session_id", $session)->delete('grading_competences');
    }

    public function add_indicators($data) {

        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id']) && $data['id'] != '') {

            $this->db->where('id', $data['id']);
            $query = $this->db->update('grading_indicators', $data);
            $insert_id = $data['id'];
            $message = UPDATE_RECORD_CONSTANT . " On grading_indicators id " . $insert_id;
            $action = "Update";
            $record_id = $insert_id;
        } else {
            $this->db->insert('grading_indicators', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On grading_indicators id " . $insert_id;
            $action = "Insert";
            $record_id = $insert_id;
        }

        $this->log($message, $record_id, $action);

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            return $insert_id;
        }
    }

    public function getIndicatorsByCompetence($competence_id) {
        $this->db->select('*')->from('grading_indicators')->where('competence_id', $competence_id);
        return $this->db->get()->result_array();
    }

    

    public function getIndicators($id = null) {
        $this->db->select('*')->from('grading_indicators');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            $result = $query->row_array();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    public function deleteIndicators($id) {
        $this->db->where("id", $id)->delete('grading_indicators');
    }

    public function deleteIndicatorsBulk($competence_id) {
        $this->db->where("competence_id", $competence_id)->delete('grading_indicators');
    }

    public  function getValuescalelist()
    {
        return $this->datatables
            ->select('value_scale.*, levels.level as level')
            ->searchable('levels.level,value_scale.label,value_scale.marks,value_scale.symbol')
            ->orderable('levels.level,value_scale.label,value_scale.marks,value_scale.symbol')
        // ->join("classes", "classes.id = value_scale.class_id")
        // ->join("level_class", "classes.id = level_class.class_id")
        ->join("levels", "value_scale.class_id = levels.id")
        ->sort("value_scale.class_id")
        ->sort("value_scale.marks", "desc")
        ->from('value_scale')
        ->generate('json');
    }

    public function add_valuescale($data){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id']) && $data['id'] != '') {

            $this->db->where('id', $data['id']);
            $query = $this->db->update('value_scale', $data);
            $insert_id = $data['id'];
            $message = UPDATE_RECORD_CONSTANT . " On value_scale id " . $insert_id;
            $action = "Update";
            $record_id = $insert_id;
        } else {
            $this->db->insert('value_scale', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On value_scale id " . $insert_id;
            $action = "Insert";
            $record_id = $insert_id;
        }

        $this->log($message, $record_id, $action);

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            return $insert_id;
        }
    }

    public function getValuescale($id = null) {
        $this->db->select('*')->from('value_scale');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            $result = $query->row_array();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    public function getValuescaleByClass($class){
        return $this->db->select('*')
        ->from('value_scale')
        ->where('class_id', $class)
        ->get()
        ->result_array();
    }

    public function deleteValuescale($id) {
        $this->db->where("id", $id)->delete('value_scale');
    }

    public function getClassByStudent_session_id($student_session_id) {
        return $this->db->select('student_session.class_id,student_session.section_id, classes.class,level_class.level_id, levels.level')
        ->from('student_session')
        ->join("classes", "classes.id = student_session.class_id")
        ->join("level_class", "classes.id = level_class.class_id")
        ->join("levels", "level_class.level_id = levels.id")
        ->where('student_session.id', $student_session_id)
        ->get()
        ->row_array();
    }


    public function getReportListByCompetence($competence_id, $student_session_id) {
        return $this->datatables
        ->select('grading_indicators.name, grading_markers.marks')
        ->searchable('grading_indicators.name')
        ->orderable('grading_indicators.name')
        ->join("grading_markers", "grading_markers.student_session_id = $student_session_id AND grading_markers.indicators_id = grading_indicators.id")
        ->from('grading_indicators')
        ->where('grading_indicators.competence_id', $competence_id)
        ->generate('json');
    }

    public function getCompetenceReport($competence_id, $student_session_id) {
        $this->db->select('grading_indicators.id, grading_indicators.name, grading_markers.marks, grading_markers.id as grading_marker_id')
        ->from('grading_indicators')
        ->join("grading_markers", "grading_markers.student_session_id = $student_session_id AND grading_markers.indicators_id = grading_indicators.id", "left")
        ->where('grading_indicators.competence_id', $competence_id);
        return $this->db->get()->result_array();
    }

    public function add_marks($data){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id']) && $data['id'] != '') {

            $this->db->where('id', $data['id']);
            $query = $this->db->update('grading_markers', $data);
            $insert_id = $data['id'];
            $message = UPDATE_RECORD_CONSTANT . " On grading_markers id " . $insert_id;
            $action = "Update";
            $record_id = $insert_id;
        } else {
            $this->db->insert('grading_markers', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On grading_markers id " . $insert_id;
            $action = "Insert";
            $record_id = $insert_id;
        }

        $this->log($message, $record_id, $action);

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            return $insert_id;
        }
    }

    public function getReportByIndicator($indicators_id, $student_session_id)
    {
        $this->db->select('*')
        ->from('grading_markers')
        ->where('indicators_id', $indicators_id)
        ->where('student_session_id', $student_session_id);
        return $this->db->get()->result_array();
    }

    public function getReportByStudentAndSubject($student_session_id, $subject_group_subjects_id)
    {
        $this->db->select('*')
            ->from('grading_subject_results')
            ->where('student_session_id', $student_session_id)
            ->where('subject_group_subjects_id', $subject_group_subjects_id);
        $query = $this->db->get(); #print($this->db->last_query()); print("<br>");die;
        return $query->row_array();
    }

    public function add_subjectnewreport($data){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well

        //=======================Code Start===========================
        if (isset($data['id']) && $data['id'] != '') {

            $this->db->where('id', $data['id']);
            $query = $this->db->update('grading_subject_reports', $data);
            $insert_id = $data['id'];
            $message = UPDATE_RECORD_CONSTANT . " On grading_subject_reports id " . $insert_id;
            $action = "Update";
            $record_id = $insert_id;
        } else {
            $this->db->insert('grading_subject_reports', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On grading_subject_reports id " . $insert_id;
            $action = "Insert";
            $record_id = $insert_id;
        }

        $this->log($message, $record_id, $action);

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            return $insert_id;
        }
    }

    public function add_subjectreport($data){
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id']) && $data['id'] != '') {

            $this->db->where('id', $data['id']);
            $query = $this->db->update('grading_subject_results', $data);
            $insert_id = $data['id'];
            $message = UPDATE_RECORD_CONSTANT . " On grading_subject_results id " . $insert_id;
            $action = "Update";
            $record_id = $insert_id;
        } else {
            $this->db->insert('grading_subject_results', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On grading_subject_results id " . $insert_id;
            $action = "Insert";
            $record_id = $insert_id;
        }

        $this->log($message, $record_id, $action);

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            return $insert_id;
        }
    }

    public function searchdtByClassSectionSubject($class_id = null, $section_id = null, $subject_id)
    {

        $i = 1;
        $custom_fields   = $this->customfield_model->get_custom_fields('students', 1);
        $field_var_array = array();
        $field_var_array_name= array();
        if (!empty($custom_fields)) {
            foreach ($custom_fields as $custom_fields_key => $custom_fields_value) {
                $tb_counter = "table_custom_" . $i;
                array_push($field_var_array, 'table_custom_' . $i . '.field_value as ' . $custom_fields_value->name);
                $this->datatables->join('custom_field_values as ' . $tb_counter, 'students.id = ' . $tb_counter . '.belong_table_id AND ' . $tb_counter . '.custom_field_id = ' . $custom_fields_value->id, 'left');
                array_push($field_var_array_name,'table_custom_' . $i . '.field_value');
                $i++;

            }
        }
        
        $field_variable = (empty($field_var_array))? "": ",".implode(',', $field_var_array);
        $field_name = (empty($field_var_array_name))? "": ",".implode(',', $field_var_array_name);

        if ($class_id != null) {
            $this->datatables->where('student_session.class_id', $class_id);
        }
        if ($section_id != null) {
            $this->datatables->where('student_session.section_id', $section_id);
        }

         $this->datatables
            ->select('classes.id AS `class_id`,levels.id AS `level_id`,levels.level AS `level`,student_session.id as student_session_id,students.id,classes.class,sections.id AS `section_id`,sections.section,grading_subject_results.update_date_p1,grading_subject_results.update_date_p2,grading_subject_results.update_date_p3,grading_subject_results.update_date_p4,grading_subject_results.update_date_p5,grading_subject_results.p1,grading_subject_results.p2,grading_subject_results.p3,grading_subject_results.p4,grading_subject_results.p5,grading_subject_results.CPC,grading_subject_results.CPEX,students.id,students.admission_no , students.roll_no,students.admission_date,students.firstname,students.middlename,  students.lastname,students.image,    students.mobileno, students.email ,students.state ,   students.city , students.pincode ,     students.religion,     students.dob ,students.current_address,    students.permanent_address,IFNULL(students.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,students.adhar_no,students.samagra_id,students.bank_account_no,students.bank_name, students.ifsc_code , students.guardian_is , students.father_phone , students.mother_phone , students.guardian_name , students.guardian_relation,students.guardian_phone,students.guardian_address,students.guardian_email,students.is_active ,students.created_at ,students.updated_at,students.father_name,students.app_key,students.parent_app_key,students.rte,students.gender'. $field_variable)
            ->join('student_session', 'student_session.student_id = students.id')
            ->join('classes', 'student_session.class_id = classes.id')
            ->join('level_class', 'level_class.class_id = classes.id')
            ->join('levels', 'levels.id = level_class.level_id')
            ->join('sections', 'sections.id = student_session.section_id')
            ->join('categories', 'students.category_id = categories.id', 'left')
            ->join('grading_subject_results', 'grading_subject_results.student_session_id = student_session.id AND grading_subject_results.subject_group_subjects_id =  '.$subject_id , 'left')
            ->where('student_session.session_id', $this->current_session)
            ->where('students.is_active', "yes")
            ->from('students');

        
        $this->datatables->sort('students.firstname', 'asc');
        $this->datatables->sort('students.lastname', 'asc');
        return $this->datatables->generate('json');

    }

    public function searchReportByClassSectionSubject($class_id = null, $section_id = null, $subject_id)
    {

        $i = 1;
        $custom_fields   = $this->customfield_model->get_custom_fields('students', 1);
        $field_var_array = array();
        $field_var_array_name= array();
        if (!empty($custom_fields)) {
            foreach ($custom_fields as $custom_fields_key => $custom_fields_value) {
                $tb_counter = "table_custom_" . $i;
                array_push($field_var_array, 'table_custom_' . $i . '.field_value as ' . $custom_fields_value->name);
                $this->datatables->join('custom_field_values as ' . $tb_counter, 'students.id = ' . $tb_counter . '.belong_table_id AND ' . $tb_counter . '.custom_field_id = ' . $custom_fields_value->id, 'left');
                array_push($field_var_array_name,'table_custom_' . $i . '.field_value');
                $i++;

            }
        }
        
        $field_variable = (empty($field_var_array))? "": ",".implode(',', $field_var_array);
        $field_name = (empty($field_var_array_name))? "": ",".implode(',', $field_var_array_name);

        if ($class_id != null) {
            $this->datatables->where('student_session.class_id', $class_id);
        }
        if ($section_id != null) {
            $this->datatables->where('student_session.section_id', $section_id);
        }

        $this->datatables
            ->select(`classes.id AS 'class_id',
                        levels.id AS 'level_id',
                        levels.level AS 'level',
                        student_session.id as student_session_id,
                        students.id,
                        classes.class,
                        sections.id AS 'section_id',
                        sections.section,
                        grading_subject_reports.update_date_p1,
                        grading_subject_reports.update_date_p2,
                        grading_subject_reports.update_date_p3,
                        grading_subject_reports.update_date_p4,
                        grading_subject_reports.update_date_p5,
                        grading_subject_reports.p11,
                        grading_subject_reports.p12,
                        grading_subject_reports.p13,
                        grading_subject_reports.p14,
                        grading_subject_reports.p21,
                        grading_subject_reports.p22,
                        grading_subject_reports.p23,
                        grading_subject_reports.p24,
                        grading_subject_reports.p31,
                        grading_subject_reports.p32,
                        grading_subject_reports.p33,
                        grading_subject_reports.p34,
                        grading_subject_reports.p41,
                        grading_subject_reports.p42,
                        grading_subject_reports.p43,
                        grading_subject_reports.p44,
                        grading_subject_reports.pc1,
                        grading_subject_reports.pc2,
                        grading_subject_reports.pc3,
                        grading_subject_reports.pc4,
                        grading_subject_reports.fdac,
                        grading_subject_reports.cf50,
                        grading_subject_reports.cec,
                        grading_subject_reports.cec50,
                        grading_subject_reports.ccf,
                        grading_subject_reports.cf30,
                        grading_subject_reports.ceex,
                        grading_subject_reports.ceex70,
                        grading_subject_reports.cexf,
                        grading_subject_reports.cf,
                        grading_subject_reports.ce,
                        grading_subject_reports.sfeaa,
                        grading_subject_reports.sfear,
                        students.id,
                        students.admission_no , 
                        students.roll_no,
                        students.admission_date,
                        students.firstname,
                        students.middlename,
                        students.lastname,students.image,
                        students.mobileno,
                        students.email,
                        students.state,
                        students.city ,
                        students.pincode,
                        students.religion,
                        students.dob ,
                        students.current_address,
                        students.permanent_address,
                        IFNULL(students.category_id, 0) as 'category_id',
                        IFNULL(categories.category, "") as 'category',
                        students.adhar_no,students.samagra_id,
                        students.bank_account_no,
                        students.bank_name,
                        students.ifsc_code ,
                        students.guardian_is ,
                        students.father_phone ,
                        students.mother_phone ,
                        students.guardian_name ,
                        students.guardian_relation,
                        students.guardian_phone,
                        students.guardian_address,
                        students.guardian_email,
                        students.is_active ,
                        students.created_at ,
                        students.updated_at,
                        students.father_name,
                        students.app_key,
                        students.parent_app_key,
                        students.rte,
                        students.gender`. $field_variable)
            ->join('student_session', 'student_session.student_id = students.id')
            ->join('classes', 'student_session.class_id = classes.id')
            ->join('level_class', 'level_class.class_id = classes.id')
            ->join('levels', 'levels.id = level_class.level_id')
            ->join('sections', 'sections.id = student_session.section_id')
            ->join('categories', 'students.category_id = categories.id', 'left')
            ->join('grading_subject_reports', 'grading_subject_reports.student_session_id = student_session.id AND grading_subject_reports.subject_group_subjects_id =  '.$subject_id , 'left')
            ->where('student_session.session_id', $this->current_session)
            ->where('students.is_active', "yes")
            ->from('students');

        
        $this->datatables->sort('students.firstname', 'asc');
        $this->datatables->sort('students.lastname', 'asc');
        return $this->datatables->generate('json');

    }

    public function getStudentOrderNumber($class_id, $section_id, $student_session_id) {
        $this->db->select('student_session.id')->from('student_session');
        $this->db->join('students', 'student_session.student_id = students.id');
        $this->db->where('student_session.class_id', $class_id)->where('student_session.section_id', $section_id)->where('student_session.session_id', $this->current_session);
        $this->db->order_by('students.firstname');
        $this->db->order_by('students.lastname');
        $studentlist = $this->db->get()->result_array();

        foreach ($studentlist as $key => $student) {
            if($student['id'] == $student_session_id){
                return $key+1;
            }
        }
        return 0;
    }

    public function getStudentObservations($student_session_id) {

        $this->db->select('student_session.observation_index')->from('student_session');
        $this->db->where('student_session.id', $student_session_id);
        $observation = $this->db->get()->row_array();
        $index = $observation['observation_index'];
        $this->db->select('student_session.observations_'.$index)->from('student_session');
        $this->db->where('student_session.id', $student_session_id);
        $observation = $this->db->get()->row_array();
        if(!empty($observation)){
            return $observation['observations_'.$index];
        }else{
            return null;
        }
    }

    public  function getteacherlist($level_id = 0)
    {
        $query = $this->datatables
            ->select('CONCAT_WS(" ",staff.name,staff.surname) as name,staff_roles.id, staff_roles.staff_id, staff_roles.is_permission')
            ->searchable('staff.name,staff.surname')
            ->orderable('staff.name')
            ->from('staff')
            ->join("staff_roles", "staff_roles.staff_id = staff.id");

        ################################# -->
        $query = $query->join("subject_timetable","subject_timetable.staff_id = staff.id", "left");
        $query = $query->join("classes","classes.id = subject_timetable.class_id", "left");
        $query = $query->join("level_class","level_class.class_id = classes.id", "left");
        ################################# <--

        $query = $query->where("staff_roles.role_id",2);
        //$query = $query->where("staff.is_active",1);
        if( !empty($level_id))		    
            $query = $query->where("level_class.level_id", $level_id);
        $query = $query->group_by("staff.id");    
        return $query->generate('json');
    }

    public function getLevelByClass($class_id) {
        $this->db->select('level_id');
        $this->db->from('level_class');
        $this->db->where('class_id', $class_id);
        $query = $this->db->get();
        $classes = $query->result_array();
        if(count($classes)>0) return $classes[0]['level_id'];
        return -1;
    }

    public function getLevelByStaffId($staff_id) {
        $this->db->select('level_class.level_id');
        $this->db->from('staff');
        ################################# -->
        $this->db->join("subject_timetable","subject_timetable.staff_id = staff.id", "left");
        $this->db->join("classes","classes.id = subject_timetable.class_id", "left");
        $this->db->join("level_class","level_class.class_id = classes.id", "left");
        ################################# <--        
        $this->db->where('staff.id', $staff_id);
        $this->db->group_by('level_id');
        $query = $this->db->get();//print($this->db->last_query()); die;
        $levels = $query->result_array(); //print_r($levels[0]['level_id']); die;
        if(count($levels)>0) return $levels[0]['level_id'];
        return -1;
    }

    public function changeObservation($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('student_session',$data);
    }

    public function getclassname($class_id)
    {
        $this->db->select('class');
        $this->db->from('classes');
        $this->db->where('id', $class_id);
        $query = $this->db->get();
        $class = $query->result_array(); 
        if(count($class)>0) 
            return $class[0]['class'];
        return "Error";
    }
}
