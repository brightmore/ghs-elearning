<?php
        class Instructors extends CI_Controller {

        public function __construct() {
                parent::__construct();
               
                $this->load->library("form_validation" ); 
                     $this->load->library("session" ); 
                     $this->load->helper("url" ); 
                     $this->load->model('instructors_model');
            
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
     
    function index(){


        $this->load->view('header');
        $this->load->view('list_instructors');
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
           $this->load->view('create_instructors',$data);
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
			$result =  $this->instructors_model->findByPk($id);
			if(empty($result))
				show_error('Page is not existing', 404);
			else
				
                                  $data['update_data']= $result;
		}
                

           $this->load->view('header');
           $this->load->view('create_instructors',$data);
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
                
                    
                        $this->form_validation->set_rules("username", "username", "required|xss_clean"); 
                        $this->form_validation->set_rules("first_name", "first name", "required|xss_clean"); 
                        $this->form_validation->set_rules("last_name", "last name", "required|xss_clean"); 
                        $this->form_validation->set_rules("gender", "gender", "required|xss_clean"); 
                        $this->form_validation->set_rules("title", "title", "required|xss_clean"); 
                        $this->form_validation->set_rules("email", "email", "required|xss_clean"); 
                        $this->form_validation->set_rules("phone", "phone", "required|xss_clean"); 
                        $this->form_validation->set_rules("instructor_id", "instructor id", "required|xss_clean");
            
            if ($this->form_validation->run() == FALSE){  
            
               $message['is_redirect'] =false;
                $err =  validation_errors();
                //$err =  $this->form_validation->_error_array();
                $data = $err;
                $count = count($this->form_validation->error_array());
                $message['error_count'] =$count;
          }else{   $id = $this->input->post('id');$username= $this->input->post('username');
                    $first_name= $this->input->post('first_name');
                    $last_name= $this->input->post('last_name');
                    $gender= $this->input->post('gender');
                    $title= $this->input->post('title');
                    $email= $this->input->post('email');
                    $phone= $this->input->post('phone');
                    $instructor_id= $this->input->post('instructor_id');
                     $data_inser_array = array(  'username'=>$username,
                         'first_name'=>$first_name,
                         'last_name'=>$last_name,
                         'gender'=>$gender,
                         'title'=>$title,
                         'email'=>$email,
                         'phone'=>$phone,
                         'instructor_id'=>$instructor_id,
                         );  
            
        if(isset($id) && !empty($id)){

            $condition = array("id"=>$id);
           // $insert = $this->instructors_model->update('instructors',$data_inser_array,$condition);
            $insert = $this->db->update('instructors',$data_inser_array,$condition);
            $data = "Data Updated Successfully.";
            $this->session->set_flashdata('smessage',"Data Updated Successfully");
            $message['is_redirect'] =true;
          }else{
            //$insert = $this->instructors_model->create('instructors',$data_inser_array);
            $insert = $this->db->insert('instructors',$data_inser_array);
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
		$start =  $_GET["iDisplayStart"];
		$search =   $_GET["sSearch"];
			
		$config["total_rows"] = $this->instructors_model->count_all_rows($search);
		

		$this->pagination->initialize($config);

		$data["links"] = $this->pagination->create_links();

			
		$sort_col = $_GET["iSortCol_0"];
		$sort_dir = $_GET["sSortDir_0"];
		$limit = $_GET["iDisplayLength"];
		$start =  $_GET["iDisplayStart"];
		$search =   $_GET["sSearch"];
			
			
		$arr = $this->instructors_model->get_data($sort_col,$sort_dir,$limit,$start,$search);

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



            $insert = $this->db->delete("instructors", $condition);

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