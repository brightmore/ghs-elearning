<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Takecourse_model extends CI_Model {

    /**
     * @var string
     * CMS Master table name
     */
    private $_table = 'takeCourse';
    private $_pk_field = 'id';
    private $list_colums = array('id', 'subtopic_id', 'date_start', 'time_start', 'user_name', 'takeCourse_ID', 'start_course', 'completed', 'date_completed', 'certificate_printed', 'take_quiz',);
    private $sort_colums_order = array('id', 'subtopic_id', 'date_start', 'time_start', 'user_name',);

    public function __construct() {

        parent::__construct();
    }

    /**
     * Functon find by primery key
     * 
     * process  
     * 
     * @auther Bright Nsarko <brightmore1@gmail.com>
     * @createdon   : 2015-06-03 
     * @
     * 
     * @param type  id
     * @return type array
     * exceptions
     */
    function findByPk($id) {

        $this->db->select("*");
        $this->db->from($this->_table);

        $this->db->where($this->_pk_field, $id);
        $this->db->limit(1);
        $query = $this->db->get();
        $result = array_shift($query->result_array());

        return $result;
    }

    /**
     * Functon get_data
     * 
     * process for search result
     * 
     * @auther Bright Nsarko <brightmore1@gmail.com>
     * @createdon   : 2015-06-03 
     * @
     * 
     * @param type 
     * @return type
     * 
     */
    public function get_data($sort_num = 0, $sortby = "DESC", $limit, $start, $search = "") {

        $sort_field = $this->sort_colums_order[$sort_num];
        $this->db->select($this->sort_colums_order);
        $this->db->from($this->_table);

        //$where = "is_active = 1";
        if (!empty($search)) {
            $search = mysql_escape_string($search);
        }

        //$this->db->where($where, NULL, FALSE);
        $this->db->order_by($sort_field, $sortby);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo $this->db->last_query();

        $result = $query->result_array();

        return $result;
    }

    function count_all_rows($search = "") {

        $this->db->select("COUNT(*) AS numrows");
        $this->db->from($this->_table);
        //$where = "is_active = 1";
        if (!empty($search)) {
            //search condition      
        }

        //$this->db->where($where, NULL, FALSE);
        return $this->db->get()->row()->numrows;
    }

    function studentTakesubject($course_id,$subject_id){
        date_default_timezone_set("Africa/Accra");
        
       $start_datetime =  mktime();
        
        $data = array(
                    'subject_id'=>$subject_id,
                    'datetime_start'=>$start_datetime,
                    'username'=>  $this->username,
                    'takeCourse_ID'=>$course_id
                );
        
        $insert_id = $this->db->insert($this->_table,$data);
        if($insert_id){
            return TRUE;
        }
        return FALSE;
    }
    
    
    function subjectUnderCourse($course_id){
        $this->db->select("subject_id,subject_name,description,content_type,content,rank,course_name");
        $this->db->from($this->_table);
        $this->db->join("courses", "subjects.course_id = courses.course_id");
        $this->db->where(array('courses.course_id'=>$course_id));
        $this->db->order_by("subjec_name");
        $query = $this->db->get();
        
        $data = array();
        if($query->result()){
            $data = $query->result();
            $query->free_result();
            return $data;
        }
        
        return false;
    }
    
    
    
}
