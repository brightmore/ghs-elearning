<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Forum
 *
 * @author bright
 */
class Forum extends CI_Controller {

    private $_table_channel = 'channels';
    private $_table_thread = 'thread';
    private $_table_post = 'post';
    private $_table_user_thread = 'user_thread';
    private $upload_location = './uploads/forum';
    private $error = array();

    public function __construct() {
        parent::__construct();
        $this->load->model('Forum_model', 'mforum');
    }

    function create_channel() {
        // insert csrf check
        $content['csrf'] = _get_csrf_nonce();
        $content['channels'] = $this->mforum->getChannels();
        $data['title'] = "Forum Channel Management";
        $data['content'] = $this->load->view('admin/create_forum_channel', $content, TRUE);
        $this->load->view('admin/template', $data);
    }

    function create_thread() {
        $content['csrf'] = _get_csrf_nonce();
        $data['title'] = "Forum Thread Management";
        $data['content'] = $this->load->view('admin/create_forum_thread', $content, TRUE);
        $this->load->view('admin/template', $data);
    }

    public function create_posts() {
        $content['csrf'] = _get_csrf_nonce();
        $data['title'] = "POST Management";
        $data['content'] = $this->load->view('admin/create_forum_post', $content, TRUE);
        $this->load->view('admin/template', $data);
    }

    
    public function process_post_form() {
        if (_valid_csrf_nonce() === FALSE) {
            $this->session->flashdata('error', 'There is something fishy about the form you just submitted, it fails CSRF Test');
            redirect("Forum/create_posts");
        }
        
        $this->form_validation->set_rules('thread_id','thread ID','required|numeric');
        $this->form_validation->set_rules('post','Post','required');
         
        if($this->form_validation->run() === FALSE){
            $this->error['form_error'] = $this->form_validation->error_array();
            echo json_encode(array('result' => $this->error));
        }
        
        
        $post = htmlentities(trim($this->input->post('post')),ENT_COMPAT);
        $user_id = $this->session->userdata('user_id');
        $thread_id = $this->input->post('thread_id');
        $data = ['text'=>$post,'thread_id'=>$thread_id,'user_id'=>$user_id];
      
        $this->db->insert($this->_table_post,$data);
        $result = NULL;
        if($this->db->affected_rows() > 0){
            $result = TRUE;
        }
         
        echo json_encode($result);
    }

    public function process_thread_form() {
        if (_valid_csrf_nonce() === FALSE) {
            $this->session->flashdata('error', 'There is something fishy about the form you just submitted, it fails CSRF Test');
            redirect("Forum/create_channel");
        }

        $this->form_validation->set_rules('title', 'Title', 'required|trim|max_length[500]');
        $this->form_validation->set_rules("slug", 'Slug', 'required|trim|max_length[500]');
        $this->form_validation->set_rules('channel_id', 'Channel', 'required|trim|max_length[8]');

        if ($this->form_validation->run() === FALSE) {
            $this->error['form_error'] = $this->form_validation->error_string();
            echo json_encode(array('result' => $this->error));
            return;
        }

        $title = trim($this->input->post('title'));
        $slug = trim($this->input->post('slug'));
        $channel_id = trim($this->input->post('channel_id'));
        $user_id = trim($this->session->userdata('user_id'));

        $data = ['title' => $title, 'slug' => $slug, 'channel_id' => $channel_id, 'user_id' => $user_id];
        $this->db->insert($this->_table_thread, $data);

        $result = NULL;
        if ($this->db->affected_rows() > 0) {
            $result = TRUE;
        }

        echo json_encode(array('result' => $result));

//        if ($this->input->is_ajax_request()) {
//            
//        } else {
//           
//        }
    }

    public function process_channel_form() {

        if (_valid_csrf_nonce() === FALSE) {
            $this->session->flashdata('error', 'There is something fishy about the form you just submitted, it fails CSRF Test');
            redirect("Forum/create_channel");
        }

        $this->form_validation->set_rules('channel_name', 'Channel name', 'required|trim|callback_channel_name_already_exist|max_length[200]');
        $this->form_validation->set_rules("slug", 'Slug', 'required|trim|max_length[500]|callback_slug_already_exist');
        $this->form_validation->set_rules('color', 'Channel Color', 'required|trim|max_length[8]');

        if (isset($this->input->post('userfile'))) {
            $this->form_validation->set_rules("userfile", 'Icon', '');
        }

        if ($this->form_validation->run() === FALSE) {
            $this->error['form_errors'] = $this->form_validation->error_array();
            echo json_encode(array('result' => $this->error));
            return;
        }

        $icon = NULL;
        if (@$_FILES['userfile']['name'] !== "") {
            $config['upload_path'] = $this->upload_location;
            $config['allowed_types'] = 'jpeg|png|jpg|gif';
            $config['encrypt_name'] = TRUE;
            $config['remove_spaces'] = TRUE;
            $config['max_size'] = '200';

            $this->load->library('upload');
            $this->upload->initialize($config);
            $this->upload->do_upload();

            $error = $this->upload->display_errors();

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

                $icon = substr($this->upload_location, 1) . '/' . $logo;
            } else {
                $this->errors['icon'] = $error;
            }
        }



        if (count($this->error) > 0) {
            echo json_encode(array('result' => ['error' => $this->error]));
            return;
        } else {
            $name = $this->input->post('channel_name');
            $slug = $this->input->post('slug');
            $color = $this->input->post('color');

            $data['name'] = $name;
            $data['slug'] = $slug;
            $data['color'] = $color;
            if (isset($icon)) {
                $data['icon'] = $icon;
            }

            $this->db->insert($this->_table_channel, $data);
            echo json_encode(array('result' => ['success' => TRUE]));
        }
    }

    function channel_name_already_exist($str) {
        $is_exist_name = $this->db->get_where($this->_table_channel, array('name' => $str))->num_rows();
        if ($is_exist_name > 0) {
            $this->form_validation->set_message("The channel name already exist");
            return FALSE;
        }

        return TRUE;
    }

    function slug_already_exist($str) {
        $is_exist_name = $this->db->get_where($this->_table_channel, array('slug' => $str))->num_rows();
        if ($is_exist_name > 0) {
            $this->form_validation->set_message("The slug already exist");
            return FALSE;
        }

        return TRUE;
    }

}
