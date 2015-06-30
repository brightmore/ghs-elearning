<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of frontier
 *
 * @author bright
 */
class Frontier extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();

        $this->load->model('courses_model', 'mcourses');
        $this->load->model('Subject_model', 'msubject');
        $this->load->model('Event_model', 'mevents');
        $this->load->model('News_model', 'mnews');
        $this->load->model('Forum_model', 'mforum');
        $this->load->model('TakeQuiz_model', 'mtakeQuiz');
    }

    function index() {

        $content['course_outlines'] = $this->mcourses->currentCourse(3);
        $content['catalogue'] = $this->mcourses->getCourseCategories();
        $content['users_thread'] = $this->mforum->get_user_thread(1, 8);

//       $date = new DateTime();
//echo $date->getTimestamp();
// $nextWeek = time() + (7 * 24 * 60 * 60);
        $content['events'] = $this->mevents->get_current_events(4);
        $content['news'] = $this->mnews->get_all_news(4);
        $data['content'] = $this->load->view('public/index', $content, TRUE);
        $this->load->view('public/public_template', $data);
    }

    function forum_thread() {
        
    }

    function forum_post($thread_id) {
        
    }

    function course_list() {
        $content['catalogue'] = $this->mcourses->getCourseCategories();
        $data['content'] = $this->load->view('public/course_modules', $content, TRUE);
        $this->load->view('public/public_template', $data);
    }

    function course_list_grid() {
        $content['catalogue'] = $this->mcourses->getCourseCategories();
        $data['content'] = $this->load->view('public/course_list_grid', $content, TRUE);
        $this->load->view('public/public_template', $data);
    }

    function news() {
        
    }
    
    function moderator_dashboard(){
        $content['csrf'] = _get_csrf_nonce();
        
         $this->load->model('Members_model','mMembers');
        
        $user_id = $this->session->userdata('user_id');
        
//        if(! is_member_type($user_id, 'moderators')){
//            echo "You should be moderator  before you can add instructor to a course";
//            exit;
//        }
//        
//        $this->db->select('instructor_id');
//        $this->db->from('courses');
//        $this->db->where('instructor_id',$user_id);
//        $this->db->where('course_id',$course_id);
//        $query = $this->db->get();
//        if($query->num_rows() === 0){
//           echo "You should be moderator of this course before you can add instructor to this course";
//           exit;
//        }
        $user_id = 1;
       $instructor_courses = $this->mMembers->get_instructor_courses($user_id);
       if($instructor_courses){
           $course_id = $instructor_courses[0]->course_id;
           $content['students'] = $this->mMembers->get_students_for_instructor($user_id,$course_id);
       }else{
           $content['students'] = NULL;
       }
       
        $content['instructors'] = $this->mMembers->get_moderators_instructors();  
        $subjects_list = $this->msubject->get_subjects_for_view();
        $subjects = array();
        foreach ($subjects_list as $value) {
            $subjects[$value->subject_id] = $value->subject_name;
        }

        $content['subjects'] = $subjects;
        $content['subject_content'] = $this->msubject->get_subject_content_for_instructor($user_id); //all subject content he/she has in his/her name
        $data['title'] = "Add Subject content";
        $data['content'] = $this->load->view('public/moderator_dashboard', $content, TRUE);
        $this->load->view('public/public_template', $data);
        
    }
    
    function instructor_dashboard(){
        
    }

    function add_subject_content() {
        
          //check if login
          if (!$this->ion_auth->logged_in()) {
          //redirect them to the login page
          redirect('index.php/public/Frontier/login', 'location');
          }

          $user_id = $this->session->userdata('user_id');
          if (! is_member_type($user_id, 'moderators') || ! is_member_type($user_id, 'instructors')) {
                echo "You have no right to add subject content, "
            . "if you are part admin group, login into the CMS and add content from there."
                    . "Thank you";
          }
         
        
        $content['csrf'] = _get_csrf_nonce();
        $subjects_list = $this->msubject->get_subjects_for_view();
        $subjects = array();
        foreach ($subjects_list as $value) {
            $subjects[$value->subject_id] = $value->subject_name;
        }

        $content['subjects'] = $subjects;
        $content['subject_content'] = $this->msubject->get_subject_content_for_instructor($user_id); //all subject content he/she has in his/her name
        $data['title'] = "Add Subject content";
        $data['content'] = $this->load->view('public/add_subject_content', $content, TRUE);
        $this->load->view('public/public_template', $data);
    }

    function process_add_subject_content() {

        $this->uploadLocation = "./uploads/subjects/subject_content";

        if (!$this->ion_auth->logged_in()) {
            //redirect them to the login page
            redirect('index.php/public/Member/login', 'location');
        }

        $user_id = $this->session->userdata('user_id');
        //check if the user is an instructor or moderator
        if (! is_member_type($user_id, 'moderators') || ! is_member_type($user_id, 'instructors')) {
            echo "You have no right to add subject content, "
            . "if you are part admin group, login into the CMS and add content from there."
                    . "Thank you";
        }

        try {

            $data = array();
            //validation
            $this->form_validation->set_rules('summary', 'Summary', 'required|xss_clean');
            $this->form_validation->set_rules('video-type', 'Video Type', 'required|in_list[html5-comp,youtube]');
            $this->form_validation->set_rules('title', 'Title', 'required|trim|xss_clean');
            $this->form_validation->set_rules('pdf', 'PDF', 'required');

            $video_type = $this->input->post('video_type');

            if ($video_type === 'html5-comp') {
                $this->form_validation->required("video_mp4", 'mp4 video Format', 'required');
                $this->form_validation->required("video_webm", 'webm video Format', 'required');
                $this->form_validation->required("video_ogv", 'ogv video Format', 'required');
            } else {
                $this->form_validation->set_rules("youtubeVideo", 'Youtube Video', 'required|trim|xss_clean');
            }

            if ($this->form_validation->run() === FALSE) {
                $this->add_subject_content();
            }

            $config['upload_path'] = $this->uploadLocation;
            $config['allowed_types'] = 'mp4|webm|ogv|ogg|pdf';
            $config['encrypt_name'] = TRUE;
            $config['remove_spaces'] = TRUE;
            $config['max_size'] = '0';

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($video_type === 'html5-comp') {

                $this->upload->do_upload('video_mp4');
                $file_mp4 = $this->upload->data();

                //
                $mp4_url = substr($this->uploadLocation . '/' . $file_mp4['file_name'], 2);

                $this->upload->do_upload("video_webm");
                $file_webm = $this->upload->data();
                $webm_url = substr($this->uploadLocation . '/' . $file_webm['file_name'], 2);

                $this->upload->do_upload("video_ogv");
                $file_ogv = $this->upload->data();
                $ogv_url = substr($this->uploadLocation . '/' . $file_ogv['file_name'], 2);

                $data['video_webm'] = $webm_url;
                $data['video_mp4'] = $mp4_url;
                $data['video_ogv'] = $ogv_url;
            } else {
                $data['content'] = $this->input->post('youtubeVideo');
            }

            $this->upload->do_upload('pdf');
            $file_pdf = $this->upload->data();
            $pdf_url = substr($this->uploadLocation.'/'.$file_pdf['file_name'],2);
            
            $summery = trim($this->input->post('summary'));
            $subject_id = trim($this->input->post('subject_id'));
            $title = trim($this->input->post('title'));

            $data['pdf'] = $pdf_url;
            $data['instructor_id'] = $user_id;
            $data['summary'] = $summery;
            $data['subject_id'] = $subject_id;
            $data['type_mode'] = $video_type;
            $data['title'] = $title;
            $data['date_created'] = time();
            
            $insert_id = $this->db->insert('subject_content',$data);
            if($this->db->affected_rows()){
                echo json_encode(array('result'=>TRUE));
            }
            
            echo json_encode(array('result'=>FALSE));
            
        } catch (Exception $err) {
            log_message("error", $err->getMessage());
            return show_error($err->getMessage());
        }
    }

    function remove_dir($dir, $DeleteMe) {
        if (!$dh = @opendir($dir))
            return;
        while (false !== ($obj = readdir($dh))) {
            if ($obj == '.' || $obj == '..')
                continue;
            if (!@unlink($dir . '/' . $obj))
                $this->remove_dir($dir . '/' . $obj, true);
        }

        closedir($dh);
        if ($DeleteMe) {
            @rmdir($dir);
        }
    }

    function add_instructor_to_course($course_id) {
        
        $this->load->model('Members_model','mMembers');
        
        $user_id = $this->session->userdata('user_id');
        
//        if(! is_member_type($user_id, 'moderators')){
//            echo "You should be moderator  before you can add instructor to a course";
//            exit;
//        }
//        
//        $this->db->select('instructor_id');
//        $this->db->from('courses');
//        $this->db->where('instructor_id',$user_id);
//        $this->db->where('course_id',$course_id);
//        $query = $this->db->get();
//        if($query->num_rows() === 0){
//           echo "You should be moderator of this course before you can add instructor to this course";
//           exit;
//        }
        
       
        
        $content['instructors'] = $this->mMembers->get_moderators_instructors();  
        $data['content'] = $this->load->view('public/add_instructor_to_course',$content,TRUE);
        $this->load->view("public/public_template",$data);
                
    }
    
    function process_add_instructor_to_course(){
        
    }

    
    function events() {
        
    }

    function take_course($course_id) {
        //@TODO validate incoming input $course_id
        $user_id = $this->session->userdata('user_id');
        //check if the user is student
        $error = array();
        if (!is_member_type($user_id)) {
            //only student can take is course
            $error['notStudent'] = 'You must be part of the student group before you can take this course';
        }

        if ($this->mcourses->is_taking_the_course($course_id, $user_id)) {
            //already taking the course

            $error['already'] = 'Already taking this course';
            $this->session->set_flashdata("failure", "Already taking this course");
        }

        $data = [
            'user_id' => $user_id,
            'course_id' => $course_id
        ];

        if ($this->input->is_ajax_request()) {
            if (!isset($error)) {
                if ($this->mcourses->take_course($data)) {
                    echo json_encode(array('result' => TRUE));
                    exit;
                } else {
                    echo json_encode(array('result' => FALSE));
                    exit;
                }
            } else {
                echo json_encode(array('error' => $data));
                exit;
            }
        } else {
            if (!isset($error)) {
                if ($this->mcourses->take_course($data)) {
                    echo json_encode(array('result' => TRUE));
                    exit;
                } else {
                    echo json_encode(array('result' => FALSE));
                    exit;
                }
            } else {
                echo json_encode(array('error' => $data));
                exit;
            }
        }
    }

    function subject_content($content_id) {
        $content['subject_content'] = $this->db->get_where('subject_content', array('id' => $content_id))->row();
        $data['content'] = $this->load->view('public/subject_content', $content, TRUE);
        $data['title'] = 'Subject Content';
        $this->load->view('public/public_template', $data);
    }

    function take_quiz($course_id, $quiz_type) {

        $this->load->model('Quiz_model', 'mQuiz');

        $course_length = strlen($course_id);
        $character = substr($course_id, 0, 1);

        if (($course_length != 5) && ($character !== 'C')) {
            
        }

        $result = $this->mQuiz->takeQuizQuestions($course_id);

        $data = array();
        $content = array();
        $content['quiz_result'] = $result;
        $content['quizes'] = $this->mQuiz->loadQuiz($result, $course_id, $quiz_type);
        $data['title'] = "Taking Quiz ";
        $data['content'] = $this->load->view('public/take_quiz', $content, TRUE);
        $this->load->view('public/public_template', $data);
    }

    function take_quiz_case_handler($case) {
        
    }

    function download_subject_content_pdf($id) {

        $id = intval($id);
        if (!is_int($id)) {
            exit;
        }

        $this->load->helper('download');
        $this->db->select("title,pdf");
        $this->db->from('subject_content');
        $this->db->where(array('id' => $id));
        $q = $this->db->get()->row();

        $data = file_get_contents($q->pdf);
        $name = $q->title . '.pdf';
        force_download($name, $data);
    }

    function download_subject_content_video($id) {
        $this->load->helper('download');
        $id = intval($id);

        if (!is_int($id)) {
            show_404();
            exit;
        }

        $this->load->helper('download');
        $this->db->select("title,video_mp4");
        $this->db->from('subject_content');
        $this->db->where(array('id' => $id));
        $q = $this->db->get()->row();

        $data = file_get_contents($q->video_mp4);
        $name = $q->title . '.mp4';
        force_download($name, $data);
    }

    function subject_details($subject_id) {
        $content['subject'] = $this->msubject->getSubjectDetail($subject_id);
        $data['content'] = $this->load->view('public/subject_detail', $content, TRUE);
        $this->load->view('public/public_template', $data);
    }

    function course_details($course_id) {
        $content['course'] = $this->mcourses->get_course($course_id);
        $data['title'] = $content['course']->course_name;
        $data['content'] = $this->load->view('public/course_details', $content, TRUE);
        $this->load->view('public/public_template', $data);
    }

    function category_details($cat_id, $category_name) {
        $content['categories'] = $this->mcourses->get_courses_categories($cat_id);
        $content['category_name'] = urldecode($category_name);
        $data['content'] = $this->load->view('public/category_details', $content, TRUE);
        $data['title'] = "" . $category_name;
        $this->load->view('public/public_template', $data);
    }

    function login() {
        $data['csrf'] = _get_csrf_nonce();
        $this->load->view('public/partials/header');
        $this->load->view('public/login', $data);
        $this->load->view('public/partials/footer');
    }

    function process_login() {
        if (_valid_csrf_nonce() === FALSE) {
            $this->login(); // say nonething because it was illegal operation the user was performing
            exit;
        }

        $this->form_validation->set_error_delimiters('<div class="form_error">', '</div>');
        //validate form
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $remember = (bool) $this->input->post('remember');

        if ($this->form_validation->run() === FALSE) {
            // $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->login();
        } else {
            if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember)) {
                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('index.php/public/Frontier/', 'refresh');
            } else {
                //if the login was un-successful
                //redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('index.php/public/Frontier/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        }
    }

}
