<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Level_model extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month = $this->setting_model->getStartMonth();
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
        $this->db->where("level_id", $id)->delete('level_class');
    }

    public function deleteLevelClass($classid) {
        $this->db->where("class_id", $classid)->delete('level_class');
    }
    
}
