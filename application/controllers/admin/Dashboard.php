<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author bright
 */
class Dashboard extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('courses_model', 'mcourses');
        $this->load->model('Subject_model', 'msubject');
        $this->load->model('Event_model', 'mevents');
        $this->load->model('News_model', 'mnews');
        $this->load->model('Forum_model', 'mforum');
        $this->load->model('TakeQuiz_model', 'mtakeQuiz');
        $this->load->model('Members_model', 'mMembers');
    }

    public function index() {
        $content['csrf'] = _get_csrf_nonce();
        $data['page'] = "Dashboard";
        $data['title'] = 'Dashboard';
        $content['total_courses'] = $this->mcourses->get_total_courses();
        $content['total_course_takers'] = $this->mMembers->get_total_students();
        $content['total_students'] = $this->mMembers->get_total_students();
        $content['faculty_total'] = $this->mMembers->get_total_instructors_moderators();
        $content['catalogue'] = $this->mcourses->getCourseCategories();
        $content['courses'] = $this->mcourses->get_all_courses();
        $data['content'] = $this->load->view('admin/index_admin', $content, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function categories() {
        redirect('index.php/Courses/create_CourseCategory');
    }

    public function courses() {
        redirect('index.php/Courses/create_course');
    }

    public function subjects() {
        redirect('index.php/Subject/');
    }

    public function forum() {
        
    }

    public function messages() {
        redirect('index.php/Messager/');
    }

    public function member() {
        
    }

    public function mailer() {
        
    }

}
