<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gradingperiod_model extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month = $this->setting_model->getStartMonth();
    }

    public function getByLevel( $level_id ){
        return $this->db->select('*')->from('periods')->where('level_id', $level_id)->get()->result_array();
    }

    public function addPeriod($data) {

        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id']) && $data['id'] != '') {
            $this->db->where('id', $data['id']);
            $query = $this->db->update('periods', $data);
            $insert_id = $data['id'];
            $message = UPDATE_RECORD_CONSTANT . " On periods id " . $insert_id;
            $action = "Update";
            $record_id = $insert_id;
        } else {
            $this->db->insert('periods', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On periods id " . $insert_id;
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

    public function deletePeriod($id) {
        $this->db->where("id", $id)->delete('periods');
    }
    
    public  function getPeriodList()
    {
        return $this->datatables
            ->select('periods.*, levels.level')
            ->searchable('periods.label,levels.level')
            ->orderable('levels.level,periods.label,periods.start_month, periods.end_month')
        ->join("levels", "periods.level_id = levels.id")
        ->from('periods')
        ->sort('periods.level_id', 'asc')
        ->sort('periods.id', 'asc')
        ->generate('json');
    }


    public function getPeriod($id = null) {
        $this->db->select('*')->from('periods');
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


}
