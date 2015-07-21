<?php

class Courses extends CI_Controller {

    private $table = "courses";
    private $banner_url;
    private $upload_location = './uploads/courseBanners';
    private $course_banner;

    public function __construct() {
        parent::__construct();

        $this->load->model('courses_model', 'mcourses');
        $this->form_validation->set_error_delimiters("<div class='error'>", "</div>");
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
//        $content['id'] = 0;
//        $content['categories'] = $this->mcourses->getCourseCategories();
//        $data['title'] = "Course Category Management";
//        $this->load->view('admin/partials/header',$data);
//        $data['content']= $this->load->view('admin/create_CourseCategory', $content,TRUE);
//        $this->load->view('admin/template',$data);
        $this->create_course();
    }

    /**
     * Functon Course Category
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
     */
    public function create_CourseCategory() {
        $content['id'] = 0;
        $data['page'] = "Course Category Management";
        $content['categories'] = $this->mcourses->getCourseCategories();
        $content['csrf'] = _get_csrf_nonce();
        $data['title'] = "Course Category Management";
        // $this->load->view('admin/partials/header',$data);
        $data['content'] = $this->load->view('admin/create_CourseCategory', $content, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function create_course() {

        $this->load->model('Members_model', 'mMember');

        $categories_list = $this->mcourses->getCourseCategories();
        $categories = array();
        if ($categories_list === FALSE) {
            $categories['error'] = "Select Category";
        } else {
            foreach ($categories_list as $value) {
                $categories[$value->cat_id] = $value->cat_name;
            }
            array_unshift($categories, "select Category");
        }
        $data['page'] = "Courses";
        $content['id'] = 0;
        // insert csrf check
        $content['csrf'] = _get_csrf_nonce();
        $content['categories'] = $categories;
        $content['instructors'] = $this->mMember->get_moderators_instructors();
        $content['courses'] = $this->mcourses->get_all_courses();
        $data['title'] = "Course Management";
        $data['content'] = $this->load->view('admin/create_courses', $content, TRUE);
        $this->load->view('admin/template', $data);
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
            $result = $this->courses_model->findByPk($id);
            if (empty($result)) {
                //@todo
                show_error('Page is not existing', 404);
            } else {
                $data['update_data'] = $result;
            }
        }

        $this->load->view('header');
        $this->load->view('create_courses', $data);
        $this->load->view('footer');
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
     * 
     */
    public function process_category_form() {

        if (_valid_csrf_nonce() === FALSE) {
            $this->session->flashdata('error', 'There is something fishy about the form you just submitted, it fails CSRF Test');
            redirect("Courses/create_CourseCategory");
        }

        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $userid = $this->session->userdata('user_id');
        $message['is_error'] = true;
        $message['error_count'] = 0;
        $data = array();

        $this->form_validation->set_rules("category_name", "Category Name", "required");
        $this->form_validation->set_rules("description", "summary", "required");
//        $this->form_validation->set_rules('logo', 'Logo', 'required');

        if (@$_FILES['logo']['name'] !== "") {
            $config['upload_path'] = $this->upload_location;
            $config['allowed_types'] = 'jpeg|png|jpg|gif';
            $config['encrypt_name'] = TRUE;
            $config['remove_spaces'] = TRUE;
            $config['max_size'] = '10048';

            $this->load->library('upload');
            $this->upload->initialize($config);
            $this->upload->do_upload();

            $this->load->library('upload');
            $this->upload->initialize($config);
            $this->upload->do_upload($fieldname);
            $error = $this->upload->display_errors();
            if (empty($error)) {
                $data = $this->upload->data();
                $this->course_banner = $data['file_name'];
                $this->banner_url = $this->upload_location . '/' . $this->course_banner;
            } else {
                $this->errors['banner_url'] = $error;
            }

            if (empty($error)) {
                $file_data = $this->upload->data();
                $logo = $file_data['file_name'];

                //image manipulate
                $config['image_library'] = 'ImageMagick';
                $config['source_image'] = $this->upload_location . '/' . $logo;
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = FALSE;
                $config['new_image'] = FALSE;
                $config['width'] = 120;
                $config['height'] = 80;

                $this->load->library('image_lib', $config);
                $this->image_lib->clear();
                if (!$this->image_lib->resize()) {
                    
                } else {
                    echo $error = $this->image_lib->display_errors();
                }

                $this->logo_url = $this->upload_location . '/' . $logo;
            } else {
                $this->errors['banner_url'] = $error;
            }

//            $this->upload_file($config, 'course_banner');
        }


        if ($this->form_validation->run() == FALSE) {

            $message['is_redirect'] = false;
            $err = validation_errors();
            //$err =  $this->form_validation->_error_array();
            $data = $err;
            $count = count($this->form_validation->error_array());
            $message['error_count'] = $count;
        } else {
            $id = $this->input->post('id');
            $cat_name = $this->input->post('category_name');
            $summary = $this->input->post('description');
            $data_inser_array = [
                'cat_name' => $cat_name,
                'summary' => $summary,
                'logo' => $this->logo_url
            ];

            if (isset($id) && !empty($id)) {

                $condition = array("cat_id" => $id);
                // $insert = $this->CI_CourseCategory_model->update('courseCategory',$data_inser_array,$condition);
                $insert = $this->db->update('course_category', $data_inser_array, $condition);
                $data = "Data Updated Successfully.";
                $this->session->set_flashdata('smessage', "Data Updated Successfully");
                $message['is_redirect'] = true;
            } else {
                //$insert = $this->CI_CourseCategory_model->create('courseCategory',$data_inser_array);
                $insert = $this->db->insert('course_category', $data_inser_array);
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
     *   
     * 
     */
    public function process_form() {

        if (_valid_csrf_nonce() === FALSE) {
            $this->session->flashdata('error', 'There is something fishy about the form you just submitted, it fails CSRF Test');
            redirect("index.php/Courses/");
        }

        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $userid = $this->session->userdata('user_id');
        $message['is_error'] = true;
        $message['error_count'] = 0;
        $data = array();

        //validation rules
        $this->form_validation->set_rules("course_description", "Course Description", "trim|required|xss_clean");
        $this->form_validation->set_rules("course_type", "Course Type", "trim|required");
        $this->form_validation->set_rules('course_name', 'Course name', 'trim|required|xss_clean');
        $this->form_validation->set_rules("category", "Course Category", "required|callback_category_check");
        $this->form_validation->set_rules('suggested_reading','Suggested Reading','required|xss_clean');
        $this->form_validation->set_rules('faq','Course FAQ','required|xss_clean');
        $this->form_validation->set_rules('course_format','Course Format','required|xss_clean');
        

        //check if the course been updated or new record

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == FALSE) {

            $message['is_redirect'] = false;
            $err = validation_errors();
            //$err =  $this->form_validation->_error_array();
            $data = $err;
            $count = count($this->form_validation->error_array());
            $message['error_count'] = $count;
            echo $err;
        } else {

         $this->banner_url = "";
        if (@$_FILES['banner_url']['name'] !== "") {
            $config['upload_path'] = $this->upload_location;
            $config['allowed_types'] = 'jpeg|png|jpg|gif';
            $config['encrypt_name'] = TRUE;
            $config['remove_spaces'] = TRUE;
            $config['max_size'] = '1048';

            $this->load->library('upload');
            $this->upload->initialize($config);
            $this->upload->do_upload("banner_url");
            $error = $this->upload->display_errors();

            if (empty($error)) {
                $file_data = $this->upload->data();
                $this->course_banner = $file_data['file_name'];
                $this->banner_url = $this->upload_location . '/' . $this->course_banner;
            } else {
                $this->bannerUrl_errors['banner_url'] = $error;
                echo $error;
            }

            $this->upload_file($config, 'course_banner');
        }

        
            //if there is update, the id would be set 
            $id = $this->input->post('id');
            $course_description = $this->input->post('course_description');
            $banner_url = $this->banner_url;
            $course_name = $this->input->post('course_name');
            $course_type = $this->input->post('course_type');
            $category_id = $this->input->post('category');
            $instructor_id = $this->input->post('instructor');
            $course_format = $this->input->post('course_format');
            $faq = $this->input->post('faq');
            $suggested_reading = $this->input->post('suggested_reading');
         
            $data_inser_array = array(
                'course_description' => $course_description,
                'banner_url' => $this->banner_url,
                'course_type' => $course_type,
                'category_id' => $category_id,
                'course_name' => $course_name,
                'instructor_id' => $instructor_id,
                'course_format'=>$course_format,
                'suggested_readings'=>$suggested_reading,
                'faq'=>$faq
            );

            if (isset($id) && !empty($id)) {

                $condition = array("id" => $id);
                // $insert = $this->courses_model->update('courses',$data_inser_array,$condition);
                $data_inser_array['course_id'] = $this->input->post("course_id");
                $insert = $this->db->update('courses', $data_inser_array, $condition);
                $data = "Data Updated Successfully.";
                $this->session->set_flashdata('smessage', "Data Updated Successfully");
                $message['is_redirect'] = true;
            } else {

                //the total in course 
                $totalCourse = $this->db->count_all($this->table);
                $course_id = 'C' . str_pad($totalCourse, 4, '0', STR_PAD_LEFT);
                $data_inser_array['course_id'] = $course_id;
                //$insert = $this->courses_model->create('courses',$data_inser_array);
                $insert = $this->db->insert('courses', $data_inser_array);
                $message['is_redirect'] = true;

                $data = "Data Inserted Successfully.";
            }
            if ($insert) {

                $this->session->set_flashdata('success',$data);
                redirect('index.php/Dashboard/Courses','refresh');
//                $message['is_error'] = false;
//                $message['is_redirect'] = true;
            } else {
//                $message['is_error'] = true;
//                $message['is_redirect'] = false;
                $data = "Something Went Wrong..";
                  $this->session->set_flashdata('success',$data);
                redirect('index.php/Dashboard/Courses','refresh');
            }
        }
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

        $config["total_rows"] = $this->courses_model->count_all_rows($search);


        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();

        $sort_col = $_GET["iSortCol_0"];
        $sort_dir = $_GET["sSortDir_0"];
        $limit = $_GET["iDisplayLength"];
        $start = $_GET["iDisplayStart"];
        $search = $_GET["sSearch"];


        $arr = $this->courses_model->get_data($sort_col, $sort_dir, $limit, $start, $search);

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

            $insert = $this->db->delete("courses", $condition);

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

    public function delete_course($id) {
        $condition = array("id" => $id);
        $this->db->delete("courses", $condition);
        if ($this->db->affected_rows() > 0) {
            $this->session->flashdata("success", "The course removed/deleted successfully");
        } else {
            $this->session->flashdata("error", "Internal operational has occurred, Please try again later. "
                    . "<br /> If the problem persist contact your system administrator.");
        }
        redirect('index.php/Courses/');
    }

    public function check_file($field, $field_value) {
        if (isset($this->custom_errors[$field_value])) {
            $this->form_validation->set_message('check_file', $this->bannerUrl_errors[$field_value]);
            unset($this->custom_errors[$field_value]);
            return FALSE;
        }
        return TRUE;
    }

    public function category_check($str) {
        if ($str == '0') {
            $this->form_validation->set_message('category_check', 'The {field} was not selected');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function upload_file($config, $fieldname) {
        $this->load->library('upload');
        $this->upload->initialize($config);
        $this->upload->do_upload($fieldname);
        $error = $this->upload->display_errors();
        if (empty($error)) {
            $data = $this->upload->data();
            $this->course_banner = $data['file_name'];
            $this->banner_url = $this->upload_location . '/' . $this->course_banner;
        } else {
            $this->bannerUrl_errors[$fieldname] = $error;
        }
    }

}
