<?php
        class TakeCourse extends CI_Controller {

        public function __construct() {
                parent::__construct();
               
                $this->load->library("form_validation" ); 
                     $this->load->library("session" ); 
                     $this->load->helper("url" ); 
                     $this->load->model('takeCourse_model');
            
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
        $this->load->view('list_takeCourse');
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
           $this->load->view('create_takeCourse',$data);
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
			$result =  $this->takeCourse_model->findByPk($id);
			if(empty($result))
				show_error('Page is not existing', 404);
			else
				
                                  $data['update_data']= $result;
		}
                

           $this->load->view('header');
           $this->load->view('create_takeCourse',$data);
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
                
                    
                        $this->form_validation->set_rules("subtopic_id", "subtopic id", "required|xss_clean"); 
                        $this->form_validation->set_rules("date_start", "date start", "required|xss_clean"); 
                        $this->form_validation->set_rules("time_start", "time start", "required|xss_clean"); 
                        $this->form_validation->set_rules("user_name", "user name", "required|xss_clean"); 
                        $this->form_validation->set_rules("takeCourse_ID", "takeCourse ID", "required|xss_clean"); 
                        $this->form_validation->set_rules("start_course", "start course", "required|xss_clean"); 
                        $this->form_validation->set_rules("completed", "completed", "required|xss_clean"); 
                        $this->form_validation->set_rules("date_completed", "date completed", "required|xss_clean"); 
                        $this->form_validation->set_rules("certificate_printed", "certificate printed", "required|xss_clean"); 
                        $this->form_validation->set_rules("take_quiz", "take quiz", "required|xss_clean");
            
            if ($this->form_validation->run() == FALSE){  
            
               $message['is_redirect'] =false;
                $err =  validation_errors();
                //$err =  $this->form_validation->_error_array();
                $data = $err;
                $count = count($this->form_validation->error_array());
                $message['error_count'] =$count;
          }else{   $id = $this->input->post('id');$subtopic_id= $this->input->post('subtopic_id');
                    $date_start= $this->input->post('date_start');
                    $time_start= $this->input->post('time_start');
                    $user_name= $this->input->post('user_name');
                    $takeCourse_ID= $this->input->post('takeCourse_ID');
                    $start_course= $this->input->post('start_course');
                    $completed= $this->input->post('completed');
                    $date_completed= $this->input->post('date_completed');
                    $certificate_printed= $this->input->post('certificate_printed');
                    $take_quiz= $this->input->post('take_quiz');
                     $data_inser_array = array(  'subtopic_id'=>$subtopic_id,
                         'date_start'=>$date_start,
                         'time_start'=>$time_start,
                         'user_name'=>$user_name,
                         'takeCourse_ID'=>$takeCourse_ID,
                         'start_course'=>$start_course,
                         'completed'=>$completed,
                         'date_completed'=>$date_completed,
                         'certificate_printed'=>$certificate_printed,
                         'take_quiz'=>$take_quiz,
                         );  
            
        if(isset($id) && !empty($id)){

            $condition = array("id"=>$id);
           // $insert = $this->takeCourse_model->update('takeCourse',$data_inser_array,$condition);
            $insert = $this->db->update('takeCourse',$data_inser_array,$condition);
            $data = "Data Updated Successfully.";
            $this->session->set_flashdata('smessage',"Data Updated Successfully");
            $message['is_redirect'] =true;
          }else{
            //$insert = $this->takeCourse_model->create('takeCourse',$data_inser_array);
            $insert = $this->db->insert('takeCourse',$data_inser_array);
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
			
		$config["total_rows"] = $this->takeCourse_model->count_all_rows($search);
		

		$this->pagination->initialize($config);

		$data["links"] = $this->pagination->create_links();

			
		$sort_col = $_GET["iSortCol_0"];
		$sort_dir = $_GET["sSortDir_0"];
		$limit = $_GET["iDisplayLength"];
		$start =  $_GET["iDisplayStart"];
		$search =   $_GET["sSearch"];
			
			
		$arr = $this->takeCourse_model->get_data($sort_col,$sort_dir,$limit,$start,$search);

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



            $insert = $this->db->delete("takeCourse", $condition);

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