<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SubjectScore_model extends CI_Model {

    protected $table = 'subject_score'; // Set your table name

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Load the database, if not autoloaded
    }

    // Retrieve all records
    public function get_all() {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    // Retrieve a single record by primary key (usually 'id')
    public function get_by_id($id) {
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->row();
    }

    // Insert a new record
    public function insert($data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();

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

    // Update an existing record by primary key
    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    // Delete a record by primary key
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

}