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

    /**
     * Functon 
     * 
     * process for generating random question for a test taker 
     * 
     * @auther Bright Nsarko <brightmore1@gmail.com>
     * @createdon   : 2015-06-03 
     * @
     * 
     * @param string $subject_id
     * @param String $quizType type of test the test taker selected to take (pretest,posttest)
     * @param int $totalQuestion Total random question that should be generate
     * @return mixed
     * exceptions
     *
     */
    function takeQuizQuestions($subject_id, $quizType = 'pretest', $totalQuestion = 20) {
        $this->db->select("question_bank.question_id,question,answer_id,objective,answer");
        $this->db->from("question_bank");
        $this->db->join("answerBank", "question_bank.question_id = answer_bank.question_id");
        $this->db->where(array('type' => $quizType));
        $this->db->order_by('RANDOM');
        
        $this->db->limit($totalQuestion);
        $query = $this->db->get();

        
        if ($query->num_rows() === 0) {
            return $this->NOQUIZ;
        }
        
        $dataSerialize = $query->result_array();
        
        $query->free_result();

      //@todo
        $user_mode = $this->session->userdata('user_mode');

        if ($user_mode !== 'student') {
            return $this->NOTSTUDENT;
        }

        $totalQuiz = $this->db->count_all($this->_table);
        $qcode = ($totalQuiz === 0) ? str_pad('1', 10, "0", STR_PAD_LEFT) : str_pad(strvar($totalQuestion), 10, '0', STR_PAD_LEFT);

        $values = serialize($dataSerialize);

        $this->db->trans_begin();
        
            $this->db->insert($this->_table, array(
                'quiz_code' => $qcode,
                'question_answers' => $values,
                'username' => $this->username,
                'quiz_type' => $quizType
            ));
            
            
            //register quiz for user
            $data_take_quiz = array('quiz_code' => $qcode, 'username' => $this->username, 'subject_id' => $subject_id);
            $this->db->insert('quiz', $data_take_quiz);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
         //   $error = mysql_error();

            //@todo log error
           //  log_message('error','[DB: query @'.$_SERVER['REQUEST_URI']."][$sql]: $error", $php_error = FALSE);
             $this->db->trans_rollback();
             return $this->DATABASE_ERROR;
            //  show_error($message, $status_code, $heading = 'An Error Was Encountered');
        }else{
            $this->db->trans_commit();
             return TRUE;
        }
        
    }

 
    function loadQuiz($quiz_code){
        //get question list for this quiz
        $this->db->select("*");
        $this->db->from($this->_table);
        $this->db->where(array('quiz_code'=>$quiz_code,'username'=>$this->username));
        $query = $this->db->get();
        
        if(! $query->num_rows()){
             return FALSE;
        }
        
         $row = $query->row();
         $questions = unserialize($row->question_answer);
        
         return $questions;
    }
    
    /**
     * Functon 
     * 
     * process for completing quiz
     * 
     * @auther Bright Nsarko <brightmore1@gmail.com>
     * @createdon   : 2015-06-03 
     * @
     * 
     * @param string $quiz_code
     * @param String $subject_id 
     * @return mixed
     * exceptions
     *
     */
    function completeQuiz($quiz_code,$subject_id) {
      
        $user_mode = $this->session->userdata('user_mode');
        
         //@TODO
        if($user_mode !== 'student'){
            return FALSE;
        }
        
        //check if the user already completed the course
        $this->db->select('username');
        $this->db->from('quiz');
        $this->db->where(array('username'=>$this->username,'quiz_code'=>$quiz_code));
        $query = $this->db->get();
        
        if($query->num_rows() > 0){
            return 1; //user already completed this subject
        }
        
        //update take course table
        $data = array(
//            'username'=>$this->username,
//            'quiz_code'=>$quiz_code,
//            'subject_id'=>$subject_id,
            'completed'=>'YES',
            'date_completed' => mktime()
           );
        
        $where = array('username'=>$this->username,'quiz_code'=>$quiz_code);
        
        if($this->markQuiz($quiz_code)){
            $this->db->update('take_course',$where,$data);
        }
    }
    
    
    function markQuiz($quiz_code){
        
        $questions = $this->loadQuiz($quiz_code);
        
         if (!is_array($questions)) {
            // something went wrong,
             return FALSE;
         }
       
         $master_list = array();
         
        //preparing question and answer for this quiz
        foreach($questions as $row){
            if($row->answer === 'YES'){
                $master_list[$row->question_id] = $row->answer_id;
            }
        }
        
        $totalQuestion = count($master_list); 
        
         //load all question answered
         $this->db->select("*");
         $this->db->from('questions_answered');
         $this->db->where(array('quiz_code'=>$quiz_code));
         $queryAnswers = $this->db->get();
         
         if(! $queryAnswers->num_rows()){
            
             return FALSE;
         }
         
         $answers_list = array();
          foreach($queryAnswers->result() as $row){
                 $answers_list[$row->question_id] = $row->ans_provided;
           }
         

          /*
           * find the intersection for the two array
           */
           $result_intersect = array_intersect($master_list, $answers_list);
           $totalScore = count($result_intersect);
           $totalScoreInPercentage = ($totalScore/$totalQuestion) * 100;
           
           //add to the score table
           $scoreQuiz = array(
               'username'=>$this->username,
               'quiz_code'=>$quiz_code,
               'percentage'=>$totalScoreInPercentage,
               'score'=>$totalScore
               );
           
           $insert_value = $this->db->insert('quiz_score',$scoreQuiz);
           
           if($insert_value){
               return TRUE;
           }
           
           return FALSE;
    }
}
