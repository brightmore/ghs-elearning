<?php
        class CourseContent extends CI_Controller {

        public function __construct() {
                parent::__construct();
               
                $this->load->library("form_validation" ); 
                     $this->load->library("session" ); 
                     $this->load->helper("url" ); 
                     $this->load->model('CourseContent_model');
            
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
     
    function index(){


        $this->load->view('header');
        $this->load->view('list_CourseContent');
        $this->load->view('footer');
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
            $data['id']= 0;
           
           $this->load->view('header');
           $this->load->view('create_CourseContent',$data);
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
         public function edit($id=0) {
		
		
                 $data['id']= $id;
		if($id!=0){
			$result =  $this->CourseContent_model->findByPk($id);
			if(empty($result))
				show_error('Page is not existing', 404);
			else
				
                                  $data['update_data']= $result;
		}
                

           $this->load->view('header');
           $this->load->view('create_CourseContent',$data);
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
     * @return void
     * exceptions
     *
     *   
     * 
     */
      public function process_form(){
			
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
                
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$userid = $this->session->userdata('user_id');
		$message['is_error'] =true;
		$message['error_count'] =0;
		$data = array();
                
                    
                        $this->form_validation->set_rules("subtopic_id", "subtopic id", "required|xss_clean"); 
                        $this->form_validation->set_rules("topic_id", "topic id", "required|xss_clean"); 
                        $this->form_validation->set_rules("subtopic_name", "subtopic name", "required|xss_clean"); 
                        $this->form_validation->set_rules("slug", "slug", "required|xss_clean"); 
                        $this->form_validation->set_rules("description", "description", "required|xss_clean"); 
                        $this->form_validation->set_rules("content_type", "content type", "required|xss_clean"); 
                        $this->form_validation->set_rules("image", "image", "required|xss_clean"); 
                        $this->form_validation->set_rules("content", "content", "required|xss_clean"); 
                        $this->form_validation->set_rules("rank", "rank", "required|xss_clean");
            
            if ($this->form_validation->run() == FALSE){  
            
               $message['is_redirect'] =false;
                $err =  validation_errors();
                //$err =  $this->form_validation->_error_array();
                $data = $err;
                $count = count($this->form_validation->error_array());
                $message['error_count'] =$count;
          }else{   $id = $this->input->post('id');$subtopic_id= $this->input->post('subtopic_id');
                    $topic_id= $this->input->post('topic_id');
                    $subtopic_name= $this->input->post('subtopic_name');
                    $slug= $this->input->post('slug');
                    $description= $this->input->post('description');
                    $content_type= $this->input->post('content_type');
                    $image= $this->input->post('image');
                    $content= $this->input->post('content');
                    $rank= $this->input->post('rank');
                     $data_inser_array = array(  'subtopic_id'=>$subtopic_id,
                         'topic_id'=>$topic_id,
                         'subtopic_name'=>$subtopic_name,
                         'slug'=>$slug,
                         'description'=>$description,
                         'content_type'=>$content_type,
                         'image'=>$image,
                         'content'=>$content,
                         'rank'=>$rank,
                         );  
            
        if(isset($id) && !empty($id)){

            $condition = array("id"=>$id);
           // $insert = $this->CourseContent_model->update('courseContent',$data_inser_array,$condition);
            $insert = $this->db->update('courseContent',$data_inser_array,$condition);
            $data = "Data Updated Successfully.";
            $this->session->set_flashdata('smessage',"Data Updated Successfully");
            $message['is_redirect'] =true;
          }else{
            //$insert = $this->CourseContent_model->create('courseContent',$data_inser_array);
            $insert = $this->db->insert('courseContent',$data_inser_array);
            $message['is_redirect'] =true;

            $data = "Data Inserted Successfully.";
          }
          if($insert){
          
            $message['is_error'] =false;
            $message['is_redirect'] =true;

          }else{
            $message['is_error'] =true;
            $message['is_redirect'] =false;
            $data = "Something Went Wrong..";
          }

          }
          $message['data'] =$data;
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
		$start =  $_GET["iDisplayStart"];
		$search =   $_GET["sSearch"];
			
		$config["total_rows"] = $this->CourseContent_model->count_all_rows($search);
		

		$this->pagination->initialize($config);

		$data["links"] = $this->pagination->create_links();

			
		$sort_col = $_GET["iSortCol_0"];
		$sort_dir = $_GET["sSortDir_0"];
		$limit = $_GET["iDisplayLength"];
		$start =  $_GET["iDisplayStart"];
		$search =   $_GET["sSearch"];
			
			
		$arr = $this->CourseContent_model->get_data($sort_col,$sort_dir,$limit,$start,$search);

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
        $pid = $this->input->post("id" );
       
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
    
	}  }