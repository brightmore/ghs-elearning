<?php

class Questions extends CI_Controller {

    private $username;

    public function __construct() {
        parent::__construct();

        $this->load->model('question_model', 'mquestions');
        $this->load->model('Subject_model', 'msubject');
        $this->load->model('courses_model', 'mcourses');
        $this->username = $this->session->userdata('username');
    }

    /**
     * Functon index
     * 
     * list all the values in grid
     * 
     * @auther Bright Nsarko <brightmore1@gmail.com>
     * @createdon   : 2015-06-03 
     * 
     * 
     * @param type 
     * @return type
     * exceptions
     * 
     * 
     */
    function index() {
        $subjects_list = $this->msubject->getSubjects();
        $subjects = array();

        if ($subjects_list) {
            foreach ($subjects_list as $value) {
                $subjects[$value->subject_id] = $value->subject_name;
            }
        }

        $content['page'] = "Question Bank";
        $content['csrf'] = _get_csrf_nonce();
        $content['subjects'] = $subjects;
        $content['courses'] = $this->mcourses->getCoursesForView();
        $data['title'] = "Question Bank Management";
        $data['content'] = $this->load->view('admin/create_question', $content, TRUE);
        $this->load->view('admin/template', $data);
    }

    function setQuestion($subject_id) {
        
    }

    function view($id, $question) {
        $question_id = $id;
        $questionAnswers = $this->mquestions->getQuestionAnswers($question_id);
        $question = urldecode($question);

        $subjects_list = $this->msubject->getSubjects();
        $subjects = array();

        if ($subjects_list) {
            foreach ($subjects_list as $value) {
                $subjects[$value->subject_id] = $value->subject_name;
            }
        }

        $data['title'] = $question;
        $content['page'] = "Question Bank";
        $content['id'] = $id;
        $content['question'] = $question;
        $content['courses'] = $this->mcourses->getCoursesForView();
        $content['questionAnswers'] = $questionAnswers;
        $data['content'] = $this->load->view('admin/viewQuestion', $content, TRUE);
        $this->load->view('admin/template', $data);
    }

    function deleteQuestion($question_id) {
        $this->db->trans_begin();

        $this->db->delete('question_bank', array('question_id' => $question_id));
        $this->db->delete('answer_bank', array('question_id' => $question_id));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(['result' => FALSE]);
        } else {
            $this->db->trans_commit();
            echo json_encode(['result' => TRUE]);
        }
    }

    function showSubjectQuestion($subject_id, $subject_name) {
        $questions = $this->mquestions->getQuestions($subject_id);

        $sectionA = array();
        $sectionB = array();
        if ($questions) {
            list( $sectionA, $sectionB ) = array_chunk($questions, ceil(count($questions) / 2));
        }
        $content['sectionA'] = $sectionA;
        $content['sectionB'] = $sectionB;
        $content['page'] = "Question Bank For " . urldecode($subject_name);
        $data['title'] = $content['page'];
        $data['content'] = $this->load->view('admin/vsubjectQuestions', $content, TRUE);
        $this->load->view('admin/template', $data);
    }

    /**
     * Functon create
     * 
     * create form
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
    public function create() {
        $data['id'] = 0;

        $this->load->view('header');
        $this->load->view('create_questionBank', $data);
        $this->load->view('footer');
    }

    /**
     * Functon edit
     * edit form
     * 
     * @auther Bright Nsarko <brightmore1@gmail.com>
     * @createdon   : 2015-06-03 
     *
     * @param type 
     * @return type
     * exceptions
     *
     *   
     * 
     */
    public function edit($id = 0) {


        $data['id'] = $id;
        if ($id != 0) {
            $result = $this->questionBank_model->findByPk($id);
            if (empty($result))
                show_error('Page is not existing', 404);
            else
                $data['update_data'] = $result;
        }


        $this->load->view('header');
        $this->load->view('create_questionBank', $data);
        $this->load->view('footer');
    }

    function process_new_question() {
        if (_valid_csrf_nonce() === FALSE) {
            $this->session->flashdata('error', 'There is something fishy about the form you just submitted, it fails CSRF Test');
            redirect("Question/");
        }
        
        $this->form_validation->set_rules('answerA', 'Answer A', 'required|xss_clean');
        $this->form_validation->set_rules('answerB', 'Answer B', 'required|xss_clean');
        $this->form_validation->set_rules('answerC', 'Answer C', 'required|xss_clean');
        $this->form_validation->set_rules('answerD', 'Answer D', 'required|xss_clean');
        $this->form_validation->set_rules('question_type', 'Question Type', 'required|in_list[pretest,posttest]');
        $this->form_validation->set_rules('question_mode','Question mode','required|in_list[text,image]');
        $this->form_validation->set_rules('quetion_text','Question','required|xss_clean');
        $this->form_validation->set_rules('subject_id','Subject','required|xss_clean');
        $this->form_validation->set_rules('answers','Answers','required|in_list[a,b,c,d]');
        $this->form_validation->set_rules('time_span','Time Span','required|greater_than_equal_to[10]|less_than_equal_to[120]');

        $location = './uploads/questions_images';

        
        
        if (($this->input->post('question_mode') === 'image')) {
   
            $this->form_validation->set_rules('extra','Entra Information about Image/picture uploaded','required|xss_clean');
        }
        
        $data_question = [];
        
        if($this->form_validation->run() === TRUE){

            $this->db->select('question');
            $this->db->from('question_bank');
            $this->db->where('question',trim($this->input->post('question')));
            $query = $this->db->get();
            
            if($query->num_rows() > 0){
                
            }
            
            if ($_FILES['question_image']['name'] !== ""){
                $config['upload_path'] = $location;
                $config['allowed_types'] = 'jpeg|png|jpg|gif';
                $config['encrypt_name'] = TRUE;
                $config['remove_spaces'] = TRUE;
                $config['max_size'] = '1048';

                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->do_upload("question_image");
                $error = $this->upload->display_errors();

                if (empty($error)){
                    $file_data = $this->upload->data();
                    $image = $file_data['file_name'];
                    $image_location = substr($this->upload_location,2).'/'.$image;
                    $extra = $this->input->post('extra');
                    
                    $data_question['extra'] = $extra;
                    $data_question['question_image'] = $image_location;
                    
                } else {
                    
                    echo $error;
                }
            }
            
            $subject_id = $this->input->post('subject_id');
            
            $this->db->select('course_id');
            $this->db->from('subject');
            $this->db->where('subject_id',$subject_id);
            $course_id = $this->db->get()->row()->course_id;
            
            $data_question['time_span'] = $this->input->post('time_span');
            $data_question['question'] = $this->input->post("question_text");
            $data_question['type'] = $this->input->post('question_type');
            $data_question['question_type']= $this->input->post('question_mode');
            $data_question['subject_id'] = $subject_id;
            $data_question['course_id'] = $course_id;
            
            $data_question['answer_a'] = $this->input->post('answerA');
            $data_question['answer_b'] = $this->input->post('answerB');
            $data_question['answer_c'] = $this->input->post('answerC');
            $data_question['answer_d'] = $this->input->post('answerD');
            $data_question['answer'] = $this->input->post('answers');
            
            $this->db->insert('question_bank',$data_question);
            if($this->db->affected_rows() > 0){
                echo "inserted";
            }  else {
                echo "not inserted";
            }
            
        }else{
            echo $this->form_validation->error_string();
        }
        
    }

    /**
     * Functon process
     * 
     * process form
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
    public function process_form() {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $userid = $this->session->userdata('user_id');
        $message['is_error'] = true;
        $message['error_count'] = 0;
        $data = array();


        $this->form_validation->set_rules("question", "question", "required|xss_clean");
        $this->form_validation->set_rules("hint", "hint", "required|xss_clean");
        $this->form_validation->set_rules("type", "type", "required|xss_clean");
        $this->form_validation->set_rules("subtopic_id", "subtopic id", "required|xss_clean");
        $this->form_validation->set_rules("time_span", "time span", "required|xss_clean");

        if ($this->form_validation->run() == FALSE) {

            $message['is_redirect'] = false;
            $err = validation_errors();
            //$err =  $this->form_validation->_error_array();
            $data = $err;
            $count = count($this->form_validation->error_array());
            $message['error_count'] = $count;
        } else {
            $id = $this->input->post('id');
            $question = $this->input->post('question');
            $hint = $this->input->post('hint');
            $type = $this->input->post('type');
            $subtopic_id = $this->input->post('subtopic_id');
            $time_span = $this->input->post('time_span');
            $data_inser_array = array('question' => $question,
                'hint' => $hint,
                'type' => $type,
                'subtopic_id' => $subtopic_id,
                'time_span' => $time_span,
            );

            if (isset($id) && !empty($id)) {

                $condition = array("question_id" => $id);
                // $insert = $this->questionBank_model->update('questionBank',$data_inser_array,$condition);
                $insert = $this->db->update('questionBank', $data_inser_array, $condition);
                $data = "Data Updated Successfully.";
                $this->session->set_flashdata('smessage', "Data Updated Successfully");
                $message['is_redirect'] = true;
            } else {
                //$insert = $this->questionBank_model->create('questionBank',$data_inser_array);
                $insert = $this->db->insert('questionBank', $data_inser_array);
                $message['is_redirect'] = true;

                $data = "Data Inserted Successfully.";
            }
            if ($insert) {

                $message['is_error'] = false;
                $message['is_redirect'] = true;
            } else {
                $message['is_error'] = true;
                $message['is_redirect'] = false;
                $data = "Something Went Wrong..";
            }
        }
        $message['data'] = $data;
        echo json_encode($message);
        exit;
    }

    /**
     * Functon list_all_data
     * 
     * process grid data 
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
    public function list_all_data() {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $this->load->library('pagination');

        $sort_col = $_GET["iSortCol_0"];
        $sort_dir = $_GET["sSortDir_0"];
        $limit = $_GET["iDisplayLength"];
        $start = $_GET["iDisplayStart"];
        $search = $_GET["sSearch"];

        $config["total_rows"] = $this->questionBank_model->count_all_rows($search);

        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();

        $sort_col = $_GET["iSortCol_0"];
        $sort_dir = $_GET["sSortDir_0"];
        $limit = $_GET["iDisplayLength"];
        $start = $_GET["iDisplayStart"];
        $search = $_GET["sSearch"];


        $arr = $this->questionBank_model->get_data($sort_col, $sort_dir, $limit, $start, $search);

        $output = array(
            "aaData" => $arr,
            "sEcho" => intval($_GET["sEcho"]),
            "iTotalRecords" => $config["total_rows"],
            "iTotalDisplayRecords" => $config["total_rows"],
        );
        echo json_encode($output);

        exit;
    }

    /**
     * Functon remove_form
     * 
     * process grid data 
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
     */
    public function remove_form() {

        $message["is_error"] = true;
        $pid = $this->input->post("id");

        if (!empty($pid)) {
            $data = $this->employee_model->findByPk($pid);

            $condition = array("question_id" => $pid);
            // $params = array("is_active" => 0);

            $insert = $this->db->delete("questionBank", $condition);

            $message["is_error"] = false;
            $data[] = "Entry Removed Successfully";
            $this->session->set_flashdata("Entry Removed Successfully", "sucess");
        } else {
            $data[] = "Entry Not Existing";
            $this->session->set_flashdata("Entry Not Existing", "error");
        }

        $message["data"] = $data;
        echo json_encode($message);
        exit;
    }

}
