<?php

if (!defined("BASEPATH"))
    exit('No direct script access allowed');

class Courses_model extends CI_Model {

    /**
     * @var string
     * CMS Master table name
     */
    private $_table = 'courses';
    private $_pk_field = 'id';
    private $list_colums = array('id', 'course_id', 'course_description', 'banner_url', 'course_name', 'course_type', 'category_id',);
    private $sort_colums_order = array('id', 'course_id', 'course_name', 'course_type',);
    private $_category_pk_field = 'id';
    private $_category_table = 'course_category';

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
     * Function  courses under category
     * 
     */
    function getCourses($cat_id = NULL,$with_category=TRUE) {
        
        if($with_category){
             $this->db->select('courses.*,course_category.cat_name');
              $this->db->join($this->_category_table, "courses.category_id=course_category.cat_id");
        }  else {
            $this->db->select('*');
        }
       
        
        $this->db->from($this->_table);
       
        if (isset($cat_id)) {
            $this->db->where(array('courses.category_id' => $cat_id));
        }

        $q = $this->db->get();

        $data = array();
        if ($q->num_rows() > 0) {
            $data = $q->result();
            $q->free_result();
        }

        return $data;
    }
    
    function getSubjectForCourses($course_id,$details = false){
//      $course_id =  filter_var($id, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
      
      if(! $details){
          $this->db->select("id,subject_id,subject_name,summary");
          
      }  else {
          $this->db->select('*');
      }
      
      $this->db->from("subject");
      $this->db->where('course_id',$course_id);
      $query = $this->db->get();
      $data = [];
      
      if($query->num_rows() > 0){
          $data = $query->result();
          $query->free_result();
      }
      return $data;
    }
    
    function getSubjectForCouserDetail($course_id){
        
    }

    function getCourseDescription($course_id){
        $this->db->select('course_description');
        $this->db->from('courses');
        $this->db->where('course_id',$course_id);
        $query = $this->db->get();
        $row = $query->row()->course_description;
        return $row;
    }
    
    function get_total_courses(){
       return $this->db->count_all_results($this->_table);
    }
    
    function get_total_course_takers(){
        
        $query = $this->db->query("SELECT count(distinct user_id) as total FROM take_course");
        return $query->row()->total;
    }
    
    
    function get_course($course_id) {
        $this->db->select('courses.*,course_category.cat_name');
        $this->db->from($this->_table);
        $this->db->join($this->_category_table, "courses.category_id=course_category.cat_id");
        $this->db->where(array('course_id' => $course_id));
        $q = $this->db->get();
        $data = array();
        if ($q->num_rows() > 0) {
            $data = $q->row();
        }

        return $data;
    }

    function currentCourse($limit) {
        $sql = "SELECT c.course_id,c.banner_url,c.course_name,c.course_type,first_name,last_name,institution,salutation,cat_name,cat_id 
            FROM elearning.courses as c
            INNER JOIN users ON users.id = c.instructor_id 
            INNER JOIN course_category ON c.category_id = course_category.cat_id
            ORDER BY c.id LIMIT {$limit}";
        $query = $this->db->query($sql);

        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
        }

        return $data;
    }

    function getCoursesForView() {
        $this->db->select("course_id,course_name");
        $this->db->from($this->_table);
        $q = $this->db->get();

        $data = array();
        if ($q->num_rows() > 0) {
            $data = $q->result();
            $q->free_result();
        }

        return $data;
    }
    
    function get_all_courses(){
       $this->db->select('courses.*,course_category.cat_name');
        $this->db->join($this->_category_table, "courses.category_id=course_category.cat_id");
        $this->db->from($this->_table);
        $query = $this->db->get();
        
        $data =array();
        if($query->num_rows()){
            $data = $query->result();
            $query->free_result();
        }
        
        return $data;
    }
    
//    function get_courses(){
//        $this->db->select('*');
//        $this->db->from($this->_table);
//        $query = $this->db->get();
//        
//        $data =array();
//        if($query->num_rows()){
//            $data = $query->result();
//            $query->free_result();
//        }
//        
//        return $data;
//    }
    
    function getCoursesByCategories($data){
        
    }

    function findCategoryByPk($id) {

        $this->db->select("*");
        $this->db->from($this->_category_table);

        $this->db->where($this->_cateory_pk_field, $id);
        $this->db->limit(1);
        $query = $this->db->get();
        $result = array_shift($query->result_array());

        return $result;
    }

    function getCourseCategories() {
        $this->db->select("*");
        $this->db->from($this->_category_table);
        //$this->db->join($this->_category_table);
        $q = $this->db->get();
        $data = array();
        if ($q->num_rows() > 0) {
            $data = $q->result();
            $q->free_result();
        }

        return $data;
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
     *   
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

    function is_taking_the_course($course_id, $user_id) {
        $this->db->select('course_id');
        $this->db->from('take_course');
        $this->db->where(array('course_id' => $course_id, 'user_id' => $user_id));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        }

        return false;
    }

    function take_course($data) {
        //check if the student already taking this course
        $user_id = $data['user_id'];
        $course_id = $data['course_id'];

        //the total in course 
        $totalCourse = $this->db->count_all("take_course");
        $takeCourse_ID = 'TC'.str_pad($totalCourse, 10, '0', STR_PAD_LEFT);
        
        $data_insert = [
            'user_id'=>$user_id,
            'course_id'=>$course_id,
            'takeCourse_ID'=>$takeCourse_ID,
            'datetime_start'=>time(),
        ];
        
        if($this->db->insert('take_course',$data_insert)){
            return TRUE;
        }
        
        return FALSE;
    }
    
    function get_courses_categories($cat_id){
        $this->db->select('*');
        $this->db->from('courses');
        $this->db->where(array('category_id'=>$cat_id));
        $q = $this->db->get();
        
        $data = array();
        if($q->num_rows() > 0){
            $data = $q->result();
        }
        
        return $data;
    }

}
