<?php

class Messager extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('messager_model');
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
        $this->load->view('header');
        $this->load->view('list_messager');
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
        $data['id'] = 0;

        $this->load->view('header');
        $this->load->view('create_messager', $data);
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
            $result = $this->messager_model->findByPk($id);
            if (empty($result))
                show_error('Page is not existing', 404);
            else
                $data['update_data'] = $result;
        }


        $this->load->view('header');
        $this->load->view('create_messager', $data);
        $this->load->view('footer');
    }

    function process_form() {
        $this->form_validation->set_rules("mgs", "mgs", "required");
        $this->form_validation->set_rules("title", "Title", "required");
        $this->form_validation->set_rules("receiver", 'Receiver', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['error'] = $this->form_validation->error_string("<div class='error'>", "</div>");
            echo json_encode($data);
            exit;
        } else {
            $mgs = $this->input->post("mgs");
            $title = $this->input->post('title');
            $sender = $this->session->userdata('username');
            $receiver = $this->input->post('receiver');

            if ($this->db->insert('messager', array(
                        'mgs' => $mgs,
                        'title' => $title,
                        'sender' => $sender,
                        'receiver' => $receiver,
                        'dateCreateOn' => mktime()))
            ) {
                $data['success'] = "Message was sent successfully.";
            } else {
                $data['failure'] = "Message fail to be send.";
            }

            echo json_encode($data);
            exit;
        }
    }

    function viewed_mgs($mgs_id) {
        $this->db->where('id', $mgs_id);
        $this->db->update('messagers', array('viewed' => TRUE));
        if ($this->db->affected_rows() > 0) {
            $data['success'] = TRUE;
        } else {
            $data['failure'] = FALSE;
        }

        echo json_encode($data);
    }

    function delete_mgs($mgs_id) {
        $this->db->delete('messages', array('id' => $mgs_id));
        if ($this->db->affected_rows() > 0) {
            $data['success'] = TRUE;
        } else {
            $data['failure'] = FALSE;
        }

        echo json_encode($data);
    }

    function getMessages() {
        $this->db->select("*");
        $this->db->where('receiver', $this->session->userdata('username'));
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            $data['result'] = $query->result();
        } else {
            $data['result'] = FALSE;
        }

        echo json_encode($data);
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
    public function process_bulk_form() {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $userid = $this->session->userdata('userid');
        $message['is_error'] = true;
        $message['error_count'] = 0;
        $data = array();

        $this->form_validation->set_rules("mgs", "mgs", "required");
        $this->form_validation->set_rules("title", "Title", "required");
        $this->form_validation->set_rules("groups", 'Groups', 'required');

        if ($this->form_validation->run() == FALSE) {

            $message['is_redirect'] = false;
            $err = validation_errors();
            //$err =  $this->form_validation->_error_array();
            $data = $err;
            $count = count($this->form_validation->error_array());
            $message['error_count'] = $count;
        } else {

            $group = $this->input->post('groups');
            $users = array();
            if ($group === 'all') {
                $users = $this->members->get_users_list();
            } else {
                $users = $this->members->get_users_list($group);
            }

            $mgs = $this->input->post('mgs');
            $dateCreateOn = mktime();
            $sender = $this->input->post('sender');

            //$viewed= $this->input->post('viewed');

            $users_messager_arr = array();
            foreach ($users as $value) {
                $users_messager_arr[] = [
                    'msg' => $mgs,
                    'dateCreateOn' => $dateCreateOn,
                    'sender' => $sender,
                    'receiver' => $value->username
                ];
            }

            $this->db->insert_batch('messager', $users_messager_arr);

            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('smessage', "Message was sent Successfully");
                redirect("Messager/");
            } else {
                $this->session->set_flashdata('serror', "Message failed to be send.");
                redirect("Messager/");
            }


//            $data_inser_array = array(
//                'mgs' => $mgs,
//                'dateCreateOn' => $dateCreateOn,
//                'sender' => $sender,
//                'reciever' => $reciever,
//                'viewed' => $viewed,
//            );
//            if (isset($id) && !empty($id)) {
//
//                $condition = array("id" => $id);
//                // $insert = $this->messager_model->update('messager',$data_inser_array,$condition);
//                $insert = $this->db->update('messager', $data_inser_array, $condition);
//                $data = "Data Updated Successfully.";
//                $this->session->set_flashdata('smessage', "Data Updated Successfully");
//                $message['is_redirect'] = true;
//            } else {
//                //$insert = $this->messager_model->create('messager',$data_inser_array);
//                $insert = $this->db->insert('messager', $data_inser_array);
//                $message['is_redirect'] = true;
//
//                $data = "Data Inserted Successfully.";
//            }
//            if ($insert) {
//
//                $message['is_error'] = false;
//                $message['is_redirect'] = true;
//            } else {
//                $message['is_error'] = true;
//                $message['is_redirect'] = false;
//                $data = "Something Went Wrong..";
//            }
        }
//        $message['data'] = $data;
//        echo json_encode($message);
//        exit;
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

        $config["total_rows"] = $this->messager_model->count_all_rows($search);


        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();


        $sort_col = $_GET["iSortCol_0"];
        $sort_dir = $_GET["sSortDir_0"];
        $limit = $_GET["iDisplayLength"];
        $start = $_GET["iDisplayStart"];
        $search = $_GET["sSearch"];


        $arr = $this->messager_model->get_data($sort_col, $sort_dir, $limit, $start, $search);

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



            $insert = $this->db->delete("messager", $condition);

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
