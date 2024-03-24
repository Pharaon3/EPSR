<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timetable_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('timetables');
    }

    public function add($data) {
        if (($data['id']) != 0) {
            $this->db->where('id', $data['id']);
            $this->db->update('timetables', $data);
        } else {
            $this->db->insert('timetables', $data);
            return $this->db->insert_id();
        }
    }

    public function get($data) {
        $query = $this->db->get_where('timetables', $data);
        return $query->result_array();
    }

    public function addtimetable($data)
    {
        $this->db->insert('lessontimes', $data);
        return $this->db->insert_id();
    }
    
    public function getlesson_time( $class_id , $section_id )
    {
        $sql = "SELECT CASE WHEN NOT ISNULL(class_timezone.timezone) THEN class_timezone.timezone ELSE 0 END as ampm FROM class_sections";
        $sql.= " LEFT JOIN class_timezone ON class_timezone.class_section_id=class_sections.id";
        $sql.= " WHERE class_sections.class_id='$class_id' AND class_sections.section_id='$section_id'";

        //print($sql); die;
        $q = $this->db->query($sql);
        
        if($q->num_rows()<=0)   return 0;
        else return $q->result_array()[0]['ampm'];
    }

    public function gettimetable($id = null,$time_type = 1,$timezone_id = 0)
    {
        $this->db->select('*');
        if($id)
        {
            $this->db->where('id',$id);
        }
        else
        {
            if($time_type == 0)
            {
                $this->db->where('time_type',$time_type);
            }

            //if($timezone_id != 0)
            {
                $this->db->where('timezone_id',$timezone_id);
            }
            $this->db->where('delete_flag', 0);
        }
        //print($ampm); exit;
        $this->db->from('lessontimes');
        $this->db->order_by("CONVERT( SUBSTRING_INDEX(time_from, ':', 1), SIGNED integer) ");
        $this->db->order_by("CONVERT( SUBSTRING_INDEX(time_from, ':', -1), SIGNED integer) ");
        $this->db->order_by("CONVERT( SUBSTRING_INDEX(time_to, ':', 1), SIGNED integer) ");
        $this->db->order_by("CONVERT( SUBSTRING_INDEX(time_to, ':', -1), SIGNED integer) ");
        $query = $this->db->get();
        // print($this->db->last_query()); exit;
        $result = $query->result_array();
        return $result;
    }


    public function getlevel_timetable($timezone_id)
    {
        $this->db->select('*');
        $this->db->where('timezone_id',$timezone_id);
        $this->db->where('delete_flag', 0);
        
        $this->db->from('lessontimes');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function updatetimetable($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('lessontimes', $data);
    }
    function deletelessontime($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('lessontimes');
    }

    function get_level()
    {
        $this->db->select("levels.*, level as name");
        $this->db->where('is_active', 'yes');
        $this->db->from('levels');
        $this->db->order_by('id');
        $query = $this->db->get();
        return $query->result_array();
    }
    function getclsss_lesson_timezone($class_id, $section_id)
    {
        $sql  = "SELECT timezone as timezone_id FROM class_timezone";
        $sql .= " LEFT JOIN class_sections as cs ON cs.id=class_timezone.class_section_id";
        $sql .= " WHERE cs.class_id = $class_id AND cs.section_id = $section_id";
        $query = $this->db->query($sql);
        
        $result = $query->result();
        if( count($result)>0)
            return $result[0]->timezone_id;
        else
        {
                return 0;
        }            
    }
    // function getlevel_id($class_id)
    // {
    //     $sql = "SELECT levels_timetable.id FROM levels_timetable
    //     WHERE levels_timetable.name = (SELECT levels.level FROM levels INNER JOIN level_class ON level_class.level_id = levels.id WHERE level_class.class_id = $class_id)";
    //     $query = $this->db->query($sql);
    //     return $query->result()[0]->id;
    // }
    // function getinitial_level_id($class_id)
    // {
    //     $sql = "SELECT levels_timetable.id FROM levels_timetable
    //     WHERE levels_timetable.name = (SELECT SUBSTRING_INDEX(classes.class, ' ', 1)  FROM classes  WHERE classes.id = $class_id)";
    //     $query = $this->db->query($sql);
    //     return $query->result()[0]->id;
    // }
    // function getlevel_ampm($class_id, $section_id)
    // {
    //     $sql  = "SELECT ct.timezone as ampm, lc.level_id FROM class_sections as cs";
    //     $sql .= " LEFT JOIN class_timezone as ct ON ct.class_section_id=cs.id";
    //     $sql .= " LEFT JOIN level_class as lc ON lc.class_id=cs.class_id";
    //     $sql .= " WHERE cs.class_id='$class_id' AND cs.section_id='$section_id'";

    //     //print($sql); die;
    //     $q = $this->db->query($sql);

    //     if( $q->num_rows()<=0 ) return [0 ,0];
    //     return $q->result_array()[0]['level_id'];
    // }

    function getclassname($class_id,$searchstr)
    {
        $this->db->select('*')->from('classes')->where("id",$class_id)->like("class",$searchstr,'before');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getlevelname($class_id)
    {
        $sql = "SELECT levels.level FROM levels INNER JOIN level_class on level_class.level_id = levels.id WHERE level_class.class_id = $class_id";
        $query = $this->db->query($sql);
        return $query->result()[0]->level;
    }
    function getLevelNameByStaffId($staff_id){
        $sql = "";
        $sql .= " SELECT levels.level ";
        $sql .= " FROM class_teacher ";
        $sql .= " INNER JOIN level_class ON level_class.class_id = class_teacher.class_id ";
        $sql .= " INNER JOIN levels ON levels.id = level_class.level_id ";
        $sql .= " WHERE class_teacher.staff_id = ".$staff_id;
        $sql .= " GROUP BY levels.id ";
        $query = $this->db->query($sql);
        //print($this->db->last_query());
        return $query->result_array(); 
    }

    // function getsub_id($level_id,$searchstr)
    // {
    //     $this->db->select('id')->from('levels_timetable')->where('parent_id',$level_id)->where("name",$searchstr);
    //     $query = $this->db->get();
    //     return $query->result()[0]->id;
    //}

    function getstafflessontimes($staff_id)
    {
        $this->db->select('lesson_id')->from('subject_timetable')->where('staff_id',$staff_id)->where('lesson_id <> ', 0);
        $lessontimes = $this->db->get();
        
        $lessontimes = $lessontimes->result();

        $lessontimes_id_array = [];
        foreach($lessontimes as $row)
        {
            $lessontimes_id_array[] = $row->lesson_id;
        }
        if( count($lessontimes_id_array)==0)    $lessontimes_id_array = [0];    // error excepting;
        $this->db->select('timezone_id')->from('lessontimes')->where_in('id',$lessontimes_id_array);
        $level_ids = $this->db->get();
        $level_ids = $level_ids->result();

        $timezone_id_array = [];
        foreach($level_ids as $row)
        {
            $timezone_id_array[] = $row->timezone_id;
        }

        if(count($timezone_id_array)==0)    $timezone_id_array = [0];
        $this->db->select('*');
        $this->db->where_in('timezone_id', $timezone_id_array);
        $this->db->from('lessontimes');
        $this->db->order_by("(SELECT MIN(CONVERT( SUBSTRING_INDEX(time_from, ':', 1), SIGNED INTEGER)) FROM lessontimes aa WHERE aa.timezone_id=lessontimes.timezone_id)");
        $this->db->order_by("timezone_id");
        $this->db->order_by("CONVERT( SUBSTRING_INDEX(time_from, ':', 1), SIGNED integer) ");
        $this->db->order_by("CONVERT( SUBSTRING_INDEX(time_from, ':', -1), SIGNED integer) ");
        $this->db->order_by("CONVERT( SUBSTRING_INDEX(time_to, ':', 1), SIGNED integer) ");
        $this->db->order_by("CONVERT( SUBSTRING_INDEX(time_to, ':', -1), SIGNED integer) ");
        $query = $this->db->get();
        $result = $query->result_array();
        //print($this->db->last_query())  ;
        return $result;        
    }

    ##      lesson_timezone table       ##
    public function gettimezone($id=null) {
        $data = ['delete_flag'=>0];
        if(!empty($id))         $data = ['id'=>$id];

        $query = $this->db->get_where('lesson_timezone', $data);

        if(!empty($id)) return $query->result_array()[0];
        return $query->result_array();
    }

    public function AddorUpdateTimetableZone($data)
    {
        if( !empty($data['id']) )
        {
            $this->db->where('id', $data['id']);
            $this->db->update('lesson_timezone', $data);            
        }
        else
        {
            $this->db->where('id', $data['id']);
            $this->db->insert('lesson_timezone', $data);            
        }
    }

    public function deletelessontimezone($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('lesson_timezone');
    }
}
