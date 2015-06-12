<?php

if (!defined("BASEPATH"))
    exit('No direct script access allowed');

class Question_model extends CI_Model {

    /**
     * @var string
     * CMS Master table name
     */
    private $_table = 'question_bank';
    private $_pk_field = 'question_id';
    private $list_colums = array('question_id', 'question', 'hint', 'type', 'subtopic_id', 'time_span',);
    private $sort_colums_order = array('question_id', 'question', 'hint', 'type', 'subtopic_id',);

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

    
    function getQuestions($subject_id){
        $this->db->select("question_id,question");
        $this->db->from($this->_table);
        $this->db->where(array('subject_id'=>$subject_id));
        $query = $this->db->get();
        $data = array();
        if($query->num_rows() > 0){
            $data = $query->result();
            $query->free_result();
        }
        
        return $data;
    }
    
    function getQuestionAnswers($question_id){
        $this->db->select('*');
        $this->db->from("answer_bank");
        $this->db->where(array('question_id'=>$question_id));
        $query = $this->db->get();
        $data = array();
        if($query->num_rows() > 0){
            $data = $query->result();
            $query->free_result();
        }
        
        return $data;
    }
    
}
