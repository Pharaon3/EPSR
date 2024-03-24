<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Class_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    public function getAll($id = null) {

        $this->db->select()->from('classes');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            $classlist = $query->row_array();
        } else {
            $classlist = $query->result_array();
        }

        return $classlist;
    }



    public function get($id = null, $classteacher = null) {

        $userdata = $this->customlib->getUserData();
        $role_id = $userdata["role_id"];
        $carray = array();
        if (isset($role_id) && ($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {
            if ($userdata["class_teacher"] == 'yes') {

                $classlist = $this->teacher_model->get_teacherrestricted_mode($userdata["id"]);
            }
        } else {

            $this->db->select()->from('classes');
            if ($id != null) {
                $this->db->where('id', $id);
            } else {
                $this->db->order_by('id');
            }
            $query = $this->db->get();
            if ($id != null) {
                $classlist = $query->row_array();
            } else {
                $classlist = $query->result_array();
            }
        }

        return $classlist;
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->where('id', $id);
        $this->db->delete('classes'); //class record delete.

        $this->db->where('class_id', $id);
        $this->db->delete('class_sections'); //class_sections record delete.

        $message = DELETE_RECORD_CONSTANT . " On classes id " . $id;
        $action = "Delete";
        $record_id = $id;
        $this->log($message, $record_id, $action);
        //======================Code End==============================
        $this->db->trans_complete(); # Completing transaction
        /* Optional */
        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            //return $return_value;
        }
    }

    /**
     * This function will take the post data passed from the controller
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function add($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('classes', $data);
        } else {
            $this->db->insert('classes', $data);
        }
    }

    public function check_data_exists($data) {
        $this->db->where('class', $data);

        $query = $this->db->get('classes');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function class_exists($str) {

        $class = $this->security->xss_clean($str);
        $res = $this->check_data_exists($class);

        if ($res) {
            $pre_class_id = $this->input->post('pre_class_id');
            if (isset($pre_class_id)) {
                if ($res->id == $pre_class_id) {
                    return true;
                }
            }
            $this->form_validation->set_message('class_exists', 'Record already exists');
            return false;
        } else {
            return true;
        }
    }

    public function check_classteacher_exists($class, $section, $teacher) {

        $this->db->where(array('class_id' => $class, 'section_id' => $section, 'session_id' => $this->current_session));
        // $this->db->where_in('staff_id', $teacher);

        $query = $this->db->get('class_teacher');
        if ($query->num_rows() > 0) {

            return $query->row();
        } else {

            return false;
        }
    }

    public function class_teacher_exists($str) {

        $class = $this->input->post('class');
        $section = $this->input->post('section');
        $teachers = $this->input->post('teachers');

        $res = $this->check_classteacher_exists($class, $section, $teachers);

        if ($res) {
            $prev_class_id = $this->input->post('prev_class_id');
            $prev_section_id = $this->input->post('prev_section_id');
            if (isset($prev_class_id) && isset($prev_section_id)) {
                if ($prev_class_id == $class && $prev_section_id == $section) {
                    return true;
                }
            }
            $this->form_validation->set_message('class_exists', 'Record already exists');
            return false;
        } else {
            return true;
        }
    }

    public function getClassTeacher() {
        $query = $this->db->query('SELECT class_teacher.*,classes.class,sections.section FROM `class_teacher` INNER JOIN classes on classes.id=class_teacher.class_id INNER JOIN sections on sections.id=class_teacher.section_id where class_teacher.session_id="' . $this->current_session . '" GROUP BY class_teacher.class_id , class_teacher.section_id ORDER by length(classes.class), classes.class');

        //     $query = $this->db->query('SELECT distinct class_id AS class_id ,section_id,
        //  (SELECT C.class FROM classes C WHERE C.ID = CT.CLASS_ID) class,
        // (SELECT S.SECTION FROM sections S  WHERE S.ID = CT.SECTION_ID) section
        // FROM class_teacher CT where 1=1');

        $result = $query->result_array();

        return $result;
    }

    public function get_section($id) {

        return $this->db->select('sections.id,sections.section')->from('class_sections')->join('sections', 'class_sections.section_id=sections.id')->where('class_id', $id)->get()->result_array();
    }

    public function getTeacher_classid($staff_id) {

        $this->db->select("class_id")->from("class_teacher")->where('staff_id',$staff_id);
        $query = $this->db->get()->result_array()[0];
        //     $query = $this->db->query('SELECT distinct class_id AS class_id ,section_id,
        //  (SELECT C.class FROM classes C WHERE C.ID = CT.CLASS_ID) class,
        // (SELECT S.SECTION FROM sections S  WHERE S.ID = CT.SECTION_ID) section
        // FROM class_teacher CT where 1=1');
        return $query['class_id'];
    }

    public function get_timezone_list()
    {
        $sql  = "SELECT cs.id as class_section_id, classes.class, sections.Section, levels.level, ct.timezone as timezone_id, lt.ampm_flag, lc.level_id, levels.is_ampm";
        $sql .= " FROM class_sections as cs";
        $sql .= " LEFT JOIN classes ON classes.id=cs.class_id";
        $sql .= " LEFT JOIN sections ON sections.id=cs.section_id";
        $sql .= " LEFT JOIN class_timezone as ct ON ct.class_section_id=cs.id";
        $sql .= " LEFT JOIN lesson_timezone as lt ON lt.id=ct.timezone";
        $sql .= " LEFT JOIN level_class as lc ON lc.class_id=classes.id";
        $sql .= " LEFT JOIN levels ON levels.id=lc.level_id";

        //print($sql); die;
        $query= $this->db->query($sql);
        return $query->result_array();
        
    }

    public function UpdateTimezone($cs_id, $ampm_flag)
    {
        $sql  = "SELECT lt.id FROM class_sections as cs ";
        $sql .= " LEFT JOIN level_class as lc ON lc.class_id=cs.class_id";
        $sql .= " LEFT JOIN lesson_timezone as lt ON lt.level_id=lc.level_id";
        $sql .= " WHERE cs.id='$cs_id'";
        $sql .= " AND lt.ampm_flag='$ampm_flag'";
        
        //print($sql); die;
        $query= $this->db->query($sql);
        $result = $query->result_array();
        if( count($result)==0 )     $timezone_id = 0;
        else    $timezone_id = $result[0]['id'];
        
        $lesson_timezone = [
            'class_section_id'=> $cs_id, 
            'timezone'=>$timezone_id
        ];

        $this->db->where('class_section_id',$cs_id);
        $q = $this->db->get('class_timezone');
        
        if($timezone_id!=0)
        {
            if ( $q->num_rows() > 0 ) 
            {
               $this->db->where('class_section_id',$cs_id);
               $this->db->update('class_timezone',$lesson_timezone);
            } else {
               //$this->db->set('class_section_id', $cs_id);
               $this->db->insert('class_timezone',$lesson_timezone);
               print($this->db->last_query() . "<br>");
            }
        }
    }

    public function GetLevelId($classid)
    {
        $this->db->select("level_id");
        $this->db->from("level_class");
        $this->db->where("class_id",$classid);
        $result = $this->db->get()->result_array();
        return $result[0]['level_id'];
    }
}
