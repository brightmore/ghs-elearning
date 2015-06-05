<?php

if (!defined("BASEPATH"))
    exit('No direct script access allowed');

class TakeQuiz_model extends CI_Model {

    /**
     * @var string
     * CMS Master table name
     */
    private $_table = 'takeQuiz';
    private $_pk_field = 'quiz_code';
    private $list_colums = array('quiz_code', 'question_id', 'answer_id', 'user_name', 'quiz_type',);
    private $sort_colums_order = array('quiz_code', 'question_id', 'answer_id', 'user_name', 'quiz_type',);
    var $NOQUIZ = 0;
    var $NOTSTUDENT = 1;

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
    
    
    /**
     * Functon 
     * 
     * process for search result
     * 
     * @auther Bright Nsarko <brightmore1@gmail.com>
     * @createdon   : 2015-06-03 
     * @
     * 
     * @param string 
     * @return mixed
     * exceptions
     *
     */
    
    function getQuestions($quizType = 'pretest',$totalQuestion=20){
        $this->db->select("questionBank.question_id,question,answer_id,objective,answer");
        $this->db->from("questionBank");
        $this->db->join("answerBank","questionBank.question_id = answerBank.question_id");
        $this->db->where(array('type'=>$quizType));
        $this->db->order_by('rand()');
        $this->db->limit($totalQuestion);
        $query = $this->db->get();
        
        $data = $query->result_array();
        if(count($data) === 0){
            return $this->NOQUIZ;
        }
        
        $username = $this->session->userdata('username');
        $user_mode = $this->session->userdata('user_mode');
        
        if($user_mode !== 'student'){
            return $this->NOTSTUDENT;
        }
        
        $totalQuiz = $this->db->count_all($this->_table);
        $qcode = ($totalQuiz === 0) ? str_pad('1', 10, "0", STR_PAD_LEFT) : str_pad(strvar($totalQuestion), 10, '0', STR_PAD_LEFT);
        
        $values= serialize($data);
        
        $insert_id = $this->db->insert($this->_table,
                array(
                    'quiz_code'=>$qcode,
                    'question_answers'=>$values,
                    'username'=>$username,
                    'quiz_type'=>$quizType
                ));
        if($insert_id > 0){
            return TRUE;
        }
        
        return FALSE;
    }
    
    function completeQuiz(){
        $this->input->post();
    }

}
