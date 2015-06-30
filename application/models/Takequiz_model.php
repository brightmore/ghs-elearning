<?php

if (!defined("BASEPATH"))
    exit('No direct script access allowed');

class TakeQuiz_model extends CI_Model {

    /**
     * @var string
     * CMS Master table name
     */
    private $_table = 'take_quiz';
    private $_pk_field = 'quiz_code';
    private $list_colums = array('quiz_code', 'question_id', 'answer_id', 'user_name', 'quiz_type',);
    private $sort_colums_order = array('quiz_code', 'question_id', 'answer_id', 'user_name', 'quiz_type',);
    var $NOQUIZ = 0;
    var $NOTSTUDENT = 1;
    var $DATABASE_ERROR = 3;
    private $username;

    public function __construct() {

        parent::__construct();
       
        $this->username = $this->session->userdata('username');
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

    
   
    
    
}
