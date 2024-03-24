<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nurse_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month = $this->setting_model->getStartMonth();
    }

    function add($data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->insert('nurses', $data);
        $query = $this->db->insert_id();
        $message = INSERT_RECORD_CONSTANT . " On  nurses  id " . $query;
        $action = "Insert";
        $record_id = $query;
        $this->log($message, $record_id, $action);
        
        //======================Code End==============================

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            $this->session->set_flashdata('nurse_msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
            return $record_id;
        }
    }

    public function delete($id) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->where('id', $id);
        $this->db->delete('nurses');
        $message = DELETE_RECORD_CONSTANT . " On  nurses  id " . $id;
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
        $this->session->set_flashdata('nurse_msg', '<div class="alert alert-success">' . $this->lang->line('delete_message') . '</div>');
        // redirect('admin/nurse');
    }

    public function update($id, $data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->where('id', $id);
        $this->db->update('nurses', $data);

        $message = UPDATE_RECORD_CONSTANT . " On  nurses id " . $id;
        $action = "Update";
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
        $this->session->set_flashdata('nurse_msg', '<div class="alert alert-success">' . $this->lang->line('update_message') . '</div>');
        // redirect('admin/nurse');
    }

    public function getNurse($id = null) {
        
        $this->db->select(" nurses.*, staff.email AS staff_email ")
        ->from('nurses')
        ->join("staff", "nurses.created_by = staff.id", "left");
        if ($id != null) {
            $this->db->where('nurses.id', $id);
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }


    public function attach_file_add($nurse_id, $attach_file) {
        $array = array('id' => $nurse_id);
        $this->db->set('attach_file', $attach_file);
        $this->db->where($array);
        $this->db->update('nurses');
        $this->session->set_flashdata('nurse_msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
    }

    public function getNurseListByStudentId($student_id) {
        return $this->datatables
        ->select("nurses.*,staff.name AS staff_name,staff.email AS staff_email,roles.name AS role_name")
            // ->searchable("nurses.id")
            ->from('nurses')
            ->join("staff", "nurses.created_by = staff.id", "left")
            ->join("staff_roles", "nurses.created_by = staff_roles.staff_id", "left")
            ->join("roles", "staff_roles.role_id = roles.id", "left")
            ->where('nurses.student_id', $student_id)            
            // ->sort('nurses.updated_at', 'DESC')
            ->generate('json');
    }
}
