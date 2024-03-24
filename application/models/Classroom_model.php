<?php

class Classroom_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function get($id = null) {

        if (!empty($id)) {

            $query = $this->db->select('staff.*,class_rooms.id as crid,class_rooms.room,class_rooms.class_id,class_rooms.section_id,classes.class,sections.section')->join("staff", "class_rooms.staff_id = staff.id")->join("classes", "class_rooms.class_id = classes.id")->join("sections", "class_rooms.section_id = sections.id")->where("class_rooms.session_id", $this->current_session)->where("class_rooms.id", $id)->get("class_rooms");
            return $query->row_array();
        } else {
            $query = $this->db->select('staff.*,class_rooms.id as crid,class_rooms.room,classes.class,sections.section')
            ->join("staff", "class_rooms.staff_id = staff.id")->join("classes", "class_rooms.class_id = classes.id")
            ->join("sections", "class_rooms.section_id = sections.id")
            ->where("class_rooms.session_id", $this->current_session)
            ->get("class_rooms");
            return $query->result_array();
        }
    }

    public function add($data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data["id"])) {

            $this->db->where("id", $data["id"])->update("class_rooms", $data);
            $message = UPDATE_RECORD_CONSTANT . " On  class room id " . $data["id"];
            $action = "Update";
            $record_id = $data["id"];
            $this->log($message, $record_id, $action);
        } else {

            $this->db->insert("class_rooms", $data);
            $id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On class room id " . $id;
            $action = "Insert";
            $record_id = $id;
            $this->log($message, $record_id, $action);
        }
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

    function roomByClassSection($class_id, $section_id) {

        $query = $this->db->select('staff.*,class_rooms.id as crid,class_rooms.class_id,class_rooms.room,class_rooms.section_id,classes.class,sections.section')->join("staff", "class_rooms.staff_id = staff.id")->join("classes", "class_rooms.class_id = classes.id")->join("sections", "class_rooms.section_id = sections.id")->where("class_rooms.class_id", $class_id)->where("class_rooms.section_id", $section_id)->where("staff.is_active", 1)->where("class_rooms.session_id", $this->current_session)->get("class_rooms");

        return $query->result_array();
    }

    function updateRoom($previd, $class_id, $section_id) {
        $data = array('class_id' => $class_id, 'section_id' => $section_id);
        $this->db->set('class_id', 'class_id', false);
        $this->db->set('section_id', 'section_id', false);
        $this->db->where_in('id', $previd);
        $this->db->update('class_rooms', $data);
    }

    public function delete($id) {

        $this->db->where('id', $id);
        $this->db->delete('class_rooms');
    }

}

?>