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
        $this->load->library(array('ion_auth'));
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

        $content['forum'] = '';
        $data['content'] = $this->load->view('public/forum_index', '', TRUE);
        $this->load->view('public/public_template', $data);
    }

    function forum_post() {
        $this->load->library('pagination');

        $thread_id = $this->uri->segment(3);
        $offset = $this->uri->segment(4);

        $num_rows = $this->mforum->get_total_thread_post($thread_id);

        $config['base_url'] = base_url() . '/index.php/public/Frontier/forum_post';
        $config['total_rows'] = $num_rows;
        $config['per_page'] = 20;
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $this->pagination->initialize($config);

        $data['page'] = '';
        $content['records'] = $this->mforum->get_thread_post($thread_id, $config['per_page'], $offset);
        $data['content'] = $this->load->view('public/forum_post', $content, TRUE);
        $this->load->view('public/public_template', $data);
    }

    function all_events($offset = 0) {
        $this->load->library('pagination');
        //$this->uri->segment(3,0);

        if ($this->uri->segment(3)) {
            $offset = ($this->uri->segment(3));
        } else {
            $offset = 1;
        }

        $config['base_url'] = base_url() . '/index.php/public/Frontier/all_events';
        $config['total_rows'] = $this->db->count_all_results('events');
        $config['per_page'] = 6;
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $this->pagination->initialize($config);

        $content['events'] = $this->mevents->all_event($config['per_page'], $offset);
        $content['pagination'] = $this->pagination->create_links();
        $data['page'] = "Events";
        $data['title'] = "Events Management";
        $data['content'] = $this->load->view('public/events', $content, TRUE);
        $this->load->view('public/public_template', $data);
    }

    function forum_post_process() {

        if (_valid_csrf_nonce() === FALSE) {
            $this->session->flashdata('error', 'There is something fishy about the form you just submitted, it fails CSRF Test');
            redirect("/index.php/Frontier/");
        }

        $this->form_validation->set_rules('thread_id', 'Thread ID', 'required');
        $this->form_validation->set_rules('post', 'Post', 'required|trim|xss_clean');

        if ($this->form_validation->run() === FALSE) {
            //@TODO
            echo $this->error = $this->form_validation->error_string();
        }

        $thread_id = trim($this->input->post('thread_id'));
        $post = trim($this->input->post('post'));

        $user_id = $this->session->userdata('user_id');

        $data['thread_id'] = $thread_id;
        $data['user_id'] = $user_id;
        $data['post'] = $post;

        $this->db->insert('post', $data);

        if ($this->db->affected_rows()) {
            echo json_encode(array('result' => TRUE));
        }

        echo json_encode(array('result' => FALSE));
    }

    function course_list() {
        $content['catalogue'] = $this->mcourses->getCourseCategories();
        $data['content'] = $this->load->view('public/course_modules', $content, TRUE);
        $this->load->view('public/public_template', $data);
    }

    function course_list_grid() {
        $content['catalogue'] = $this->mcourses->getCourseCategories();
        $content['courses'] = $this->mcourses->getCourses(NULL, FALSE);
        $data['content'] = $this->load->view('public/course_list_grid', $content, TRUE);
        $this->load->view('public/public_template', $data);
    }

    function subjectsForCourses($course_id,$course_name) {
        $content['course_id'] = $course_id;
        $content['course_name'] = $course_name;
        $content['catalogue'] = $this->mcourses->getCourseCategories();
        $content['description'] = $this->mcourses->getCourseDescription($course_id);
        $content['subjects'] = $this->mcourses->getSubjectForCourses($course_id);
        $content['title'] = "";
        $data['content'] = $this->load->view('public/course_subjects', $content, TRUE);
        $this->load->view('public/public_template', $data);
    }

    function start_course($course_id,$course_name) {

        if (!$this->ion_auth->logged_in()) {
            redirect('/index.php/public/Member/login', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');

        //check if the user already started the course
        $this->db->select('user_id');
        $this->db->from('take_course');
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $this->db->where('start_course', 'NO');

        $query = $this->db->get();
        if ($query->num_rows() > 0) { // the user hasn't started the course
            $data = ['start_course' => 'YES', 'course_start_datetime' => now()];
            $this->db->where(array('user_id' => $user_id, 'course_id' => $course_id));
            $this->db->update('take_course', $data);
            
            redirect('/index.php/public/Frontier/subjectsForCoursesDetail/'.$course_id.'/'.$course_name);
            
        } else {
             redirect('/index.php/public/Frontier/subjectsForCoursesDetail/'.$course_id.'/'.$course_name);
        }
    }

    function news() {
        
    }

    function subjectsForCoursesDetail($course_id,$course_name) {
        if (!$this->ion_auth->logged_in()) {
            redirect('/index.php/public/Member/login', 'refresh');
        }
         $content['description'] = $this->mcourses->getCourseDescription($course_id);
        $content['course_name'] = $course_name;
        $content['course_id'] = $course_id;
        $content['catalogue'] = $this->mcourses->getCourseCategories();
        $content['subjects'] = $this->mcourses->getSubjectForCourses($course_id,TRUE);
        $content['title'] = "";
        $data['content'] = $this->load->view('public/course_subject_details', $content, TRUE);
        $this->load->view('public/public_template', $data);
        
    }

    function moderator_dashboard() {
        
        if (!$this->ion_auth->logged_in()) {
            redirect('/index.php/public/Member/login', 'refresh');
        }
        
        $content['csrf'] = _get_csrf_nonce();

        $this->load->model('Members_model', 'mMembers');

        $user_id = $this->session->userdata('user_id');

        if(! is_member_type($user_id, 'moderators')){
            echo "You should be moderator  before you can add instructor to a course";
            exit;
        }
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
        
        $instructor_courses = $this->mMembers->get_instructor_courses($user_id);
        if ($instructor_courses) {
            $course_id = $instructor_courses[0]->course_id;
            $content['students'] = $this->mMembers->get_students_for_instructor($user_id, $course_id);
        } else {
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

    function instructor_dashboard() {
        
    }

    function add_subject_content() {

        //check if login
        if (!$this->ion_auth->logged_in()) {
            //redirect them to the login page
            redirect('index.php/public/Frontier/login', 'location');
        }

        $user_id = $this->session->userdata('user_id');
        if (!is_member_type($user_id, 'moderators') || !is_member_type($user_id, 'instructors')) {
            echo "You have no right to add subject content, "
            . "if you are part admin group, login into the CMS and add content from there."
            . "Thank you";
        }

        //@TODO check if the person has the right to add content to the subject

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
        if (!is_member_type($user_id, 'moderators') || !is_member_type($user_id, 'instructors')) {
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
            $pdf_url = substr($this->uploadLocation . '/' . $file_pdf['file_name'], 2);

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

            $insert_id = $this->db->insert('subject_content', $data);
            if ($this->db->affected_rows()) {
                echo json_encode(array('result' => TRUE));
            }

            echo json_encode(array('result' => FALSE));
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

        $this->load->model('Members_model', 'mMembers');

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
        $data['content'] = $this->load->view('public/add_instructor_to_course', $content, TRUE);
        $this->load->view("public/public_template", $data);
    }

    function process_add_instructor_to_course() {
        
    }

    function events() {
        
    }

    function take_course($course_id,$course_name) {
        //@TODO validate incoming input $course_id
        
         if (!$this->ion_auth->logged_in()) {
            //redirect them to the login page
            redirect('index.php/public/Member/login', 'refresh');
        }

        
        $user_id = $this->session->userdata('user_id');

        if (is_null($user_id) || !isset($user_id)) {
            $this->session->flashdata("message", "Before you can take this course, you have login first.");
            redirect("/index.php/public/Member/login");
            exit;
        }

        //check if the user is student
        $error = array();
        if (!is_member_type($user_id)) {
            //only student can take is course
            $error['notStudent'] = 'You must be part of the student group before you can take this course';
            redirect("/index.php/public/Member/login");
            exit;
//            echo json_encode($error);
        }

        if ($this->mcourses->is_taking_the_course($course_id, $user_id)) {
            //already taking the course

            $error['already'] = 'Already taking this course';
            $this->session->set_flashdata("failure", "Already taking this course");
            echo json_encode($error);
            exit;
        }

        $data = [
            'user_id' => $user_id,
            'course_id' => $course_id
        ];

//        if ($this->input->is_ajax_request()) {
//            
//                if ($this->mcourses->take_course($data)) {
//                    echo json_encode(array('result' => TRUE));
//                    exit;
//                } else {
//                    echo json_encode(array('result' => FALSE));
//                    exit;
//                }
//           
//        } else {
//           
//                if ($this->mcourses->take_course($data)) {
//                    echo json_encode(array('result' => TRUE));
//                    exit;
//                } else {
//                    echo json_encode(array('result' => FALSE));
//                    exit;
//                }
//        }

        if ($this->mcourses->take_course($data)) {
            //echo json_encode(array('result' => TRUE));
            //exit;
            redirect('/index.php/public/Frontier/subjectsForCourses/'.$course_id.'/'.$course_name);
        } else {
            redirect('/index.php/public/Frontier/subjectsForCourses/'.$course_id.'/'.$course_name);
//            echo json_encode(array('result' => FALSE));
//            exit;
        }
    }

    function subject_content($content_id) {
        $content['subject_content'] = $this->db->get_where('subject_content', array('id' => $content_id))->row();
        $data['content'] = $this->load->view('public/subject_content', $content, TRUE);
        $data['title'] = 'Subject Content';
        $this->load->view('public/public_template', $data);
    }

    function take_quiz($course_id, $quiz_type) {

         if (!$this->ion_auth->logged_in()) {
            //redirect them to the login page
            redirect('index.php/public/Member/login', 'refresh');
        }

        $this->load->model('Quiz_model', 'mQuiz');
//validation
//        $course_length = strlen($course_id);
//        $character = substr($course_id, 0, 1);
//
//        if (($course_length != 5) && ($character !== 'C')) {
//            
//        }

        $result = $this->mQuiz->takeQuizQuestions($course_id);
        
        if($result === 3) { //there was db error
            show_error("something bad happened ):", 500);
        }
        
        

        $data = array();
        $content = array();
        $content['quiz_result'] = $result;
        $content['quizes'] = $this->mQuiz->loadQuiz($result);
        $data['title'] = "Taking Quiz ";
        $data['content'] = $this->load->view('public/take_quiz', $content, TRUE);
        $this->load->view('public/public_template', $data);
    }
    
    function load_quiz($quiz_code){
         if (!$this->ion_auth->logged_in()) {
            //redirect them to the login page
            redirect('index.php/public/Member/login', 'refresh');
        }

        
          $data['title'] = "Taking Quiz";
          $content['quizes'] = $this->mQuiz->loadQuiz($quiz_code);
          $data['content'] = $this->load->view('public/take_quiz',$content,TRUE);
          $this->load->view('public/public_template',$data);
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
        
        echo $subject_id;
        $content['subject'] = $this->msubject->getSubjectDetail($subject_id);
        var_dump($content);
        $data['content'] = $this->load->view('public/subject_detail', $content, TRUE);
        $this->load->view('public/public_template', $data);
    }

    function course_details($course_id) {
        $content['course'] = $this->mcourses->get_course($course_id);
        $data['title'] = $content['course']->course_name;
        $content['course_name'] = $data['title'];
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

    function register() {
        $data['csrf'] = _get_csrf_nonce();
        $this->load->view('public/partials/header');
        $this->load->view('public/register', $data);
        $this->load->view('public/partials/footer');
    }

    function process_register() {
        if (_valid_csrf_nonce() === FALSE) {
            $this->login(); // say nonething because it was illegal operation the user was performing
            exit;
        }

        $this->form_validation->set_error_delimiters("<div class='form_error'>", "</div>");
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|max_length[100]|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone No', 'trim|required|is_natural');
        $this->form_validation->set_rules("confirm_password", 'confirm Password', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirm_password]');

        if ($this->form_validation->run() === false) {
            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            echo validation_errors();
            $this->login();
        }

        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $password = $this->input->post('password');

        $data['first_name'] = $first_name;
        $data['last_name'] = $last_name;
        $data['email'] = $email;
        $data['phone'] = $phone;
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

            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            echo validation_errors();
            $this->login();
        } else {

            if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember)) {
                //if the login is successful
                //redirect them back to the home page

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('/index.php/public/Frontier/', 'refresh');
            } else {
                //if the login was un-successful
                //redirect them back to the login page
                echo $this->ion_auth->errors();
                $this->session->set_flashdata('failure', $this->ion_auth->errors());
                redirect('/index.php/public/Frontier/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        }
    }

}
