<?php

if (!defined("BASEPATH"))
    exit('No direct script access allowed');

class Quiz_model extends CI_Model {

    /**
     * @var string
     * CMS Master table name
     */
    private $_table = 'quiz';
    private $_pk_field = 'id';
    private $list_colums = array('id', 'quiz_code', 'user_name', 'subtopic_id', 'quiz_completed', 'time_span_left',);
    private $sort_colums_order = array('id', 'quiz_code', 'user_name', 'subtopic_id', 'quiz_completed',);
    private $user_id;
    private $NOQUIZ = 0;
    private $NOTSTUDENT = 1;
    private $DATABASE_ERROR = 3;
    private $SUCCESS = 4;
    private $FAILURE = 5;
    private $QUIZ_COMPLETED = 6;
    private $MARK_ERROR = 7;
    private $LOADING_QUIZ = 8;
    


    public function __construct() {

        parent::__construct();
        $this->user_id = $this->session->userdata('user_id'); 
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

    
     function take_quiz($course_id) {
        $user_id = $this->session->userdata('user_id');
        $quiz_code = 'q'. str_pad($this->db->count_all('quiz'), 4, '0', STR_PAD_LEFT);
        $start_date = time();
        
        
    }
    
    function quiz(){}
    
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
    function completeQuiz($quiz_code,$course_id) {
      
         //check if the user is a student
        if(! is_member_type($this->user_id)){
            return $this->NOTSTUDENT;
        }
       
        
        //check if the user already completed the course
        $this->db->select('user_id');
        $this->db->from('quiz');
        $this->db->where(
            array(
            'user_id'=>$this->user_id,
            'quiz_code'=>$quiz_code,
            'quiz_completed'=>'YES'
            ));
        $query = $this->db->get();
        
        if($query->num_rows() > 0){
            return $this->QUIZ_COMPLETED; //user already completed this course quiz
        }
        
        //update take course table
        $data = array(
            'completed'=>'YES',
            'date_completed' => time()
           );
        
        $where = array('user_id'=>$this->user_id,'quiz_code'=>$quiz_code);
        
        if($this->markQuiz($quiz_code)){
            $this->db->update('take_course',$where,$data);
            if($this->db->affected_rows() > 0){
                return $this->SUCCESS;
            }else{
                return $this->FAILURE;
            }
              
        }else{
            return $this->MARK_ERROR; 
        }
    }
    
     function loadQuiz($quiz_code){
        //get question list for this quiz
        $this->db->select("*");
        $this->db->from("take_quiz");
        $this->db->where(array('quiz_code'=>$quiz_code,'user_id'=>$this->user_id));
        $query = $this->db->get();
        
        if( $query->num_rows() === 0){
             return $this->LOADING_QUIZ;
        }
        
         $row = $query->row();
         $questions = unserialize($row->question_answer);
        
         return $questions;
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
    function takeCourseQuizQuestions($course_id, $quizType = 'pretest', $totalQuestion = 20) {
        
         //@todo
        if (! is_member_type($this->user_id)) {
            return $this->NOTSTUDENT;
        }
        
        //check if the person assign posttest to course
        $this->db->select('*');
        $this->db->from('quiz');
        $this->db->where('user_id',  $this->user_id);
        $this->db->where('course_id',$course_id);
        $this->db->where('quizType','posttest');
        
        $q = $this->db->get();
        
        if($q->num_rows() > 0){
            
        }
        
        
        $this->db->select("*");
        $this->db->from("question_bank");
        //$this->db->join("answerBank", "question_bank.question_id = answer_bank.question_id");
        $this->db->where(array('type' => $quizType));
        $this->db->order_by('RANDOM');
        
        $this->db->limit($totalQuestion);
        $query = $this->db->get();

        if ($query->num_rows() === 0) {
            return $this->NOQUIZ;
        }
        
        $dataSerialize = $query->result();
        
        $query->free_result();

        $totalQuiz = $this->db->count_all($this->_table);
//        $qcode = ($totalQuiz === 0) ? str_pad('1', 10, "0", STR_PAD_LEFT) : str_pad(strvar($totalQuestion), 10, '0', STR_PAD_LEFT);
        $qcode = 'q'.str_pad($totalQuiz, '0',STR_PAD_LEFT);
        
        $values = serialize($dataSerialize);

        $this->db->trans_begin();
        
            $this->db->insert($this->_table, array(
                'quiz_code' => $qcode,
                'question_answers' => $values,
                'username' => $this->user_id,
                'quiz_type' => $quizType
            ));
            
            //register quiz for user
            $data_take_quiz = ['quiz_code' => $qcode, 
                'user_id' => $this->user_id, 
                'course_id' => $course_id,'start_date'=>time()];
            
            $this->db->insert('quiz', $data_take_quiz);
            
            
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $error = mysql_error(); 

            //@todo log error
             log_message('error','[DB: query @'.$_SERVER['REQUEST_URI']." : error: $error");
             $this->db->trans_rollback();
             echo $error;
             return $this->DATABASE_ERROR;
            //  show_error($message, $status_code, $heading = 'An Error Was Encountered');
        }else{
            $this->db->trans_commit();
            return $qcode; 
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
               'user_id'=>$this->user_id,
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
