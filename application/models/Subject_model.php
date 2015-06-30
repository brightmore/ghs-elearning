<?php

if (!defined("BASEPATH"))
    exit('No direct script access allowed');

class Subject_model extends CI_Model {

    /**
     * @var string
     * CMS Master table name
     */
    private $_table = 'subject';
    private $_pk_field = 'id';
    private $list_colums = array('id', 'subtopic_id', 'topic_id', 'subtopic_name', 'slug', 'description', 'content_type', 'image', 'content', 'rank',);
    private $sort_colums_order = array('id', 'subtopic_id', 'topic_id', 'subtopic_name', 'slug',);

    public function __construct() {

        parent::__construct();
        $this->load->database();
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
     *
     *   
     * 
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
     * exceptions
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

    function addSubject($data) {

        if(!is_array($data)){
            return FALSE;
        }

         $this->db->insert($this->_table,$data);
        
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        
        return FALSE;
    }
    
    function get_subject_content_for_instructor($user_id){
        $this->db->select("id,title,date_created,summary");
        $this->db->from('subject_content');
        $this->db->where(array('instructor_id'=>$user_id));
        $query = $this->db->get();
        
        $data = array();
        if($query->num_rows()){
            $data = $query->result();
            $query->free_result();
        }
        
        return $data;
    }
    
    function getSubjectDetails($subject_id = NULL){
        $this->db->select('subject.*,courses.*,course_category.cat_name');
        $this->db->from($this->_table);
        $this->db->join("courses","subject.course_id = courses.course_id");
        $this->db->join("course_category","course_category.cat_id = courses.category_id");
        
        if(isset($subject_id)){
            $this->db->where(array('subject_id'=>$subject_id));
           $this->db->limit(1);
        }
       
        $q = $this->db->get();
        $data = array();
        if($q->num_rows() > 0){
            $data = $q->result();
            $q->free_result();
        }
        
        return $data;
    }
    
    
    function getSubjectDetail($subject_id){
        $this->db->select('subject.*,courses.*,course_category.cat_name');
        $this->db->from($this->_table);
        $this->db->join("courses","subject.course_id = courses.course_id");
        $this->db->join("course_category","course_category.cat_id = courses.category_id");
         $this->db->where(array('subject_id'=>$subject_id));
           $this->db->limit(1);
           return $this->db->get()->row();
    }
    
    function subjectsUnderCourse($course_id){
        $this->db->select("*");
        $this->db->from($this->_table);
        $this->db->where('course_id',$course_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $data = $query->result();
            $query->free_result();
            return $data;
        }
        
        return FALSE;
    }
    
    
    
    function getSubjects(){
        $this->db->select('*');
        $this->db->from($this->_table);
        $query = $this->db->get();
        
        $data = array();
        if($query->num_rows() > 0){
            $data = $query->result();
            $query->free_result();
        }
        
        return $data;
    }
    
    function get_subjects_for_view(){
        $this->db->select('subject_id,subject_name');
        $this->db->from($this->_table);
        $query = $this->db->get();
        
        $data = array();
        if($query->num_rows() > 0){
            $data = $query->result();
            $query->free_result();
        }
        
        return $data;
    }
    
    
    function removeSubject($subject_id){
        
    }
    
    function addSubjectContent($data){
        if(! is_array($data)){
            return FALSE;
        }
        
         $this->db->insert('subject_content',$data);
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        
        return FALSE;
    }
    
    function getSubjectContent($subject_id){
        $this->db->select("*");
        $this->db->from('subject_content');
        $this->db->where('subject_id',$subject_id);
        
        $q = $this->db->get();
        $data = array();
        if($q->num_rows() > 0){
            $data = $q->result();
            $q->free_result();
            return $data;
        }
        
        return $data;
    }

    function removeSubjectContent($id){
        
    }
}
