<?php

class Subject extends CI_Controller {

    private $username;
    private $uploadLocation = "./uploads/subjects";
    private $_table = 'subject';

    public function __construct() {
        parent::__construct();

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
     */
    function index() {
        $this->load->model('Members_model', 'mMember');
        $courses_list = $this->mcourses->getCourses();
        $courses = array();

        if ($courses_list) {
            foreach ($courses_list as $value) {
                $courses[$value->course_id] = $value->course_name;
            }
        }

        $content['csrf'] = _get_csrf_nonce();
        $content['id'] = 0;
        $content['subjects'] = $this->msubject->getSubjectDetails();
        $content['instructors'] = $this->mMember->get_moderators_instructors();
        $data['title'] = "Subject Management";

        $content['page'] = "Subjects";
        $content['courses'] = $courses;
        $data['content'] = $this->load->view('admin/vsubjects', $content, TRUE);
        $this->load->view('admin/template', $data);
    }

    function subject_detail($subject_id) {
        $subject = $this->msubject->getSubjectDetail($subject_id);

        $courses_list = $this->mcourses->getCoursesForView();
        $courses = array();
        if ($courses_list) {
            foreach ($courses_list as $value) {
                $courses[$value->course_id] = $value->course_name;
            }
        }
        $data['title'] = $subject->subject_name;
        $content['subject'] = $subject;
        $content['courses'] = $courses;
        $content['subject_content'] = $this->msubject->getSubjectContent($subject_id);

        $content['page'] = "Subject <small class='success'>" . $subject->subject_name . "</small>";
        $data['content'] = $this->load->view('admin/vsubject_detail', $content, TRUE);
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

        $this->load->view('partials/header');
        $this->load->view('admin/create_CourseContent', $data);
        $this->load->view('partials/footer');
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
     */
    public function edit($id = 0) {

        $data['id'] = $id;
        if ($id != 0) {
            $result = $this->Subject_model->findByPk($id);
            if (empty($result)) {
                show_error('Page is not existing', 404);
            } else {
                $data['update_data'] = $result;
            }
        }

        $this->load->view('partials/header');
        $this->load->view('admin/create_CourseContent', $data);
        $this->load->view('partials/footer');
    }

    /**
     * Functon add subject
     * 
     * process form
     * 
     * @auther Bright Nsarko <brightmore1@gmail.com>
     * @createdon   : 2015-06-03 
     * @
     * 
     * @param type 
     * @return void
     * exceptions
     *
     */
    public function add_subject_content($subject_id = NULL) {
         $subjects_list = $this->msubject->get_subjects_for_view();
         $subjects = array();
            foreach ($subjects_list as $value) {
                $subjects[$value->subject_id] = $value->subject_name;
            }

        $content['subjects'] = $subjects;
        
        $content['csrf'] = _get_csrf_nonce();
        $content['page'] = "Add subject Content";
        $data["title"] = $content['page'];
        $data['content'] = $this->load->view('admin/subject_content', $content,TRUE);
        $this->load->view('admin/template', $data);
    }

    /**
     * Functon process add subject
     * 
     * process form
     * 
     * @auther Bright Nsarko <brightmore1@gmail.com>
     * @createdon   : 2015-06-03 
     * @
     * 
     * @param type 
     * @return void
     * exceptions
     *
     */
    function processAddSubject_form() {
        
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
     * @return void
     * exceptions
     *
     */
    public function process_form() {

//        if (!$this->input->is_ajax_request()) {
//            exit('No direct script access allowed');
//        }

        if (_valid_csrf_nonce() === FALSE) {
            $this->session->flashdata('error', 'There is something fishy about the form you just submitted, it fails CSRF Test');
            redirect("Courses/create_CourseCategory");
        }

        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $userid = $this->session->userdata('user_id');
        $message['is_error'] = true;
        $message['error_count'] = 0;
        $data = array();


        $this->form_validation->set_rules("subject_name", "Subject name", " strip_tags|trim|required|max_length[500]");
        $this->form_validation->set_rules("slug", "slug", "trim|required|max_length[100]");
        $this->form_validation->set_rules("rank", "rank", "trim|required|integer|max_length[3]");
        $this->form_validation->set_rules("course_id", 'Course ID', 'trim|requiredmax_length[5]');
        $this->form_validation->set_rules("subject_description", "Subject Description", "trim|required");
        $this->form_validation->set_rules('instructors', 'Instructors', 'required');


//        $video_type = $this->input->post('video_type');
//        if($video_type == 'html5-comp'){
//            $this->form_validation->set_rules('video_url','Intro Video','required');
//        }else{
//            $this->form_validation->set_rules("youtubeVideo", "Youtube Video Url","required");
//        }

        $video_url = NULL;
        if (@!$_FILES['video_url']['name'] !== '') {
            $config['upload_path'] = $this->uploadLocation;
            $config['allowed_types'] = 'mp4|flv';
            $config['encrypt_name'] = TRUE;
            $config['remove_spaces'] = TRUE;
            $config['max_size'] = '10048';

            $this->load->library('upload');
            $this->upload->initialize($config);
            $this->upload->do_upload('video_url');

            $error = $this->upload->display_errors();
            if (empty($error)) {
                $file_data = $this->upload->data();
                $video_url = $this->uploadLocation . '/' . $file_data['file_name'];
            }
        } else {
            $this->form_validation->set_rules('youtubeVideo', 'Youtube Video Url', 'trim|required');
        }

        if ($this->form_validation->run() == FALSE) {

            $message['is_redirect'] = false;
            $err = validation_errors();
            //$err =  $this->form_validation->_error_array();
            $data = $err;
            $count = count($this->form_validation->error_array());
            $message['error_count'] = $count;
        } else {


            $course_id = $this->input->post('course_id');
            $subject_name = $this->input->post('subject_name');
            $slug = $this->input->post('slug');
            $description = $this->input->post('subject_description');
            $instructors_ids = $this->input->post('instructors');
            $rank = $this->input->post('rank');

            $totalCourse = $this->db->count_all($this->_table);
            $subject_id = 'S' . str_pad($totalCourse, 4, '0', STR_PAD_LEFT);

            $data_inser_array = array(
                'subject_id' => $subject_id,
                'course_id' => $course_id,
                'subject_name' => $subject_name,
                'slug' => $slug,
                'description' => $description,
                'rank' => $rank,
                'instructors_ids' => serialize($instructors_ids)
            );

            if ($video_url) {
                $data_inser_array['video_intro_url'] = $video_url;
                $data_inser_array['video_intro_type'] = "mp4";
            } else {
                $data_inser_array['video_intro_url'] = $this->input->post('youtubeVideo');
            }

            if (isset($id) && !empty($id)) {

                $condition = array("id" => $id);
                //$insert = $this->CourseContent_model->update('courseContent',$data_inser_array,$condition);
                $insert = $this->db->update('subject', $data_inser_array, $condition);
                $data = "Data Updated Successfully.";
                $this->session->set_flashdata('smessage', "Data Updated Successfully");
                $message['is_redirect'] = true;
            } else {

                $this->db->select("rank");
                $this->db->from('subject');
                $this->db->where('course_id', $course_id);
                $this->db->where('rank', $rank);
                $query = $this->db->get();

                if ($query->num_rows() === 0) {

                    //$insert = $this->CourseContent_model->create('courseContent',$data_inser_array);
                    $insert = $this->db->insert('subject', $data_inser_array);
                    $message['is_redirect'] = true;

                    $data = "Data Inserted Successfully.";
                    if ($insert) {

                        $message['is_error'] = false;
                        $message['is_redirect'] = true;
                    } else {
                        $message['is_error'] = true;
                        $message['is_redirect'] = false;
                        $data = "Something Went Wrong..";
                    }
                } else {
                    $message['is_error'] = TRUE;
                    $message['is_redirect'] = FALSE;
                    $data = "The rank is taking, Two subjects can't have the same ranking number.";
                }
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
     * @return mixed
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

        $config["total_rows"] = $this->CourseContent_model->count_all_rows($search);


        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();


        $sort_col = $_GET["iSortCol_0"];
        $sort_dir = $_GET["sSortDir_0"];
        $limit = $_GET["iDisplayLength"];
        $start = $_GET["iDisplayStart"];
        $search = $_GET["sSearch"];


        $arr = $this->CourseContent_model->get_data($sort_col, $sort_dir, $limit, $start, $search);

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

            $condition = array("id" => $pid);
            // $params = array("is_active" => 0);

            $insert = $this->db->delete("courseContent", $condition);

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
