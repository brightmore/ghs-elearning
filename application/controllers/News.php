<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of News
 *
 * @author bright
 */
class News extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('news_model');
    }

    public function index() {

        $data['news'] = $this->news_model->get_news();
        $data['title'] = 'News archive';

        $this->load->view('templates/header', $data);
        $this->load->view('news/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($slug = NULL) {
       $data['news_item'] = $this->news_model->get_news($slug);

        if (empty($data['news_item']))
        {
                show_404();
        }

        $data['title'] = $data['news_item']['title'];
        $data['slugs'] = $this->new_model->get_news_slugs();
        $this->load->view('templates/header', $data);
        $this->load->view('news/view', $data);
        $this->load->view('templates/footer');
    }

    function add_news(){
        
        $this->form_validation->set_rules('slug','Slug','required');
        $this->form_validation->set_rules('title','Title','required');
        $this->form_validation->set_rules('news_item','News Item','required');
        
        if($this->form_validation->run()){
            $data['error'] = $this->form_validation->error_string("<div class='error'>", "</div>");
            echo json_encode($data); exit;
        }
        
        $slug = $this->input->post('slug');
        $title = $this->input->post('title');
        $news_item = $this->input->post('news_item');
        $date_added = mktime();
        
        $data_insert['slug'] = $slug;
        $data_insert['title'] = $title;
        $data_insert['news_item'] = $news_item;
        $data_insert['date_added'] = $date_added;
        
        if($this->db->insert('news',$data_insert)){
            $data['result'] = TRUE;
        }else{
            $data['result'] = FALSE;
        }
        
        echo json_encode($data);
    }
    
   
}
