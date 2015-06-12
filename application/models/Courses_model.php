<?php

if (!defined("BASEPATH")) exit('No direct script access allowed');

class Courses_model extends CI_Model {

    /**
     * @var string
     * CMS Master table name
     */
    private $_table = 'courses';
    private $_pk_field = 'id';
    private $list_colums = array('id', 'course_id', 'course_description', 'banner_url','course_name', 'course_type', 'category_id',);
    private $sort_colums_order = array('id', 'course_id','course_name', 'course_type',);
    
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
    
    function getCourses($cat_id=NULL){
        $this->db->select('courses.*,course_category.cat_name');
        $this->db->from($this->_table);
        $this->db->join($this->_category_table,"courses.category_id=course_category.cat_id");
        if(isset($cat_id)){
              $this->db->where(array('courses.category_id'=>$cat_id));
        }
        
        $q = $this->db->get();
        
        $data = array();
        if($q->num_rows() > 0){
            $data = $q->result();
            
            $q->free_result();
        }
        
        return $data;
    }
    
    
    function getCoursesForView(){
        $this->db->select("course_id,course_name");
        $this->db->from($this->_table);
        $q = $this->db->get();
        
        $data = array();
        if($q->num_rows() > 0){
            $data = $q->result();
            $q->free_result();
        }
        
        return $data;
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

    
    function getCourseCategories(){
        $this->db->select("*");
        $this->db->from($this->_category_table);
        //$this->db->join($this->_category_table);
        $q = $this->db->get();
        $data = array();
        if($q->num_rows() > 0){
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

}
