<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teacherpermission_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function get($id = null) {
        $this->db->select()->from('teacher_permissions');
        if ($id != null) {
            $this->db->where('teacher_permissions.id', $id);
        } else {
            $this->db->order_by('teacher_permissions.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row();
        } else {
            return $query->result_array();
        }
    }

    
    public function remove($id) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->where('id', $id);
        $this->db->delete('teacher_permissions');
        $message = DELETE_RECORD_CONSTANT . " On teacher_permissions id " . $id;
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

    public function addOrUpdate($data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well


        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('teacher_permissions', $data);
            $message = UPDATE_RECORD_CONSTANT . " On  teacher permission id " . $data['id'];
            $action = "Update";
            $record_id = $insert_id = $data['id'];
            $this->log($message, $record_id, $action);
        } else {
            $this->db->insert('teacher_permissions', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On teacher permission id " . $insert_id;
            $action = "Insert";
            $record_id = $insert_id;
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
            return $insert_id;
        }
        
    }
    public function getPeriodEnabledByStaffId($staff_id, $level_id=0) {
        $this->db->select('periods.id, periods.label, periods.start_month, periods.end_month, periods.level_id,levels.level');
        $this->db->from('periods');
        $this->db->join('teacher_permissions', 'teacher_permissions.period_id = periods.id', "LEFT");
        $this->db->join('levels', 'levels.id = periods.level_id', "LEFT");
		$this->db->join('staff', 'teacher_permissions.staff_id = staff.id', "LEFT"); // Join the staff table
        $this->db->group_start(); //this will start grouping
        //$this->db->where('levels.is_active', 'yes');
		$this->db->where('staff.is_active', 1); // Check for staff.is_active = 1
       // $this->db->or_where("staff.is_active");
        $this->db->group_end(); //this will end grouping
        
        if(!empty($staff_id))
        {
            $this->db->where('teacher_permissions.is_permit <>', '0');
            $this->db->where('teacher_permissions.staff_id', $staff_id);
        }
            
        if(!empty($level_id))
            $this->db->where('periods.level_id', $level_id);
        $this->db->group_by('periods.id');
        $this->db->order_by('periods.level_id');
        $this->db->order_by('periods.label');
        $query = $this->db->get(); # print($this->db->last_query()); die;
        $section = $query->result_array();

        $i=0; $result = [];
        foreach($section as $period_item)
        {
            $period_item['start'] = date('m', strtotime($period_item['start_month']));
            $period_item['end'] = date('m', strtotime($period_item['end_month']));
            $iMonth = $period_item['start'];
            $result[$period_item['level_id'] . "" . $iMonth] = $period_item;
            $i++;
        }
        ksort($result);
        return $result;
    }
    public function getPeriodPermissionArray($staff_id = 0, $level_id = 0) {
    $this->db->select('staff.id as staff_id, period_id, periods.label, periods.level_id, levels.level,periods.start_month, periods.end_month, teacher_permissions.id, teacher_permissions.is_permit');
    $this->db->from('staff');
    $this->db->join('teacher_permissions', 'teacher_permissions.staff_id = staff.id', "left");
    $this->db->join('periods', 'periods.id=teacher_permissions.period_id', "left");
    $this->db->join('levels', 'levels.id = periods.level_id', "left");
    if(!empty($staff_id))
        $this->db->where('staff.id', $staff_id);
    if(!empty($level_id))
        $this->db->where('periods.level_id', $level_id);
    $this->db->group_start(); //this will start grouping
    $this->db->where('levels.is_active', 'yes');
    $this->db->or_where("levels.is_active", 1); // Check for is_active = 1
    $this->db->group_end(); //this will end grouping
    $this->db->where('staff.is_active', 1); // Check for staff.is_active = 1
    $this->db->order_by('periods.level_id');
    $this->db->order_by('periods.label');
    $this->db->group_by('staff.id');
    $this->db->group_by('periods.id');
    $query = $this->db->get();
    #print($this->db->last_query()); die;
    $section = $query->result_array();

    $i = 0; $result = [];
    foreach($section as $period_item)
    {
        $period_item['start'] = date('m', strtotime($period_item['start_month']));
        $period_item['end'] = date('m', strtotime($period_item['end_month']));
        $iMonth = $period_item['start'];
        $result[$period_item['staff_id']][$period_item['level_id'] . "" . $iMonth] = $period_item;
        $i++;
    }
    $staff_period_array = [];
    foreach($result as $staff_id=>$staff_permit)
    {
        foreach($staff_permit as $key=>$staff_permit_period)
        {
            $staff_period_array[$staff_id][$staff_permit_period['period_id']] = $staff_permit_period;
        }
    }
    return $staff_period_array;
}


    public function getStaffPeriodPermission($staff_id, $period_id) {
        $this->db->select('*');
        $this->db->from('teacher_permissions');
        $this->db->where('staff_id', $staff_id);
        $this->db->where('period_id', $period_id);
        $result = $this->db->get()->result_array();
        return $result;
    }

    // public function updateAllPermissionsByPeriodId($period_id, $permit)
    // {
    //     $sql = "UPDATE teacher_permissions SET is_permit='$permit' WHERE period_id='$period_id'";
    //     print($sql); die;
    //     $this->db->query( $sql  );
    // }
}
