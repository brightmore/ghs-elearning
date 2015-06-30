<?php

class Events extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('Events_model');
    }

    function index() {
        $this->form_validation->set_rules('event_date', 'Event date', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('event_title', 'Event Title', 'required|trim|max_length[500]');
        $this->form_validation->set_rules('event_end_date', 'Event End Date', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('summary', 'Summary', 'required|trim');
        $this->form_validation->set_rules('region', 'Region', 'required|trim');

        $this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');

        if ($this->form_validation->run() == FALSE) { // validation hasn't been passed
            $this->load->view('events form _view');
        } else { // passed validation proceed to post success logic
            // build array for the model
            //filter_input(INPUT_POST | INPUT_GET, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $form_data = array(
                'event_date' => set_value('event_date'),
                'event_title' => set_value('event_title'),
                'event_end_date' => set_value('event_end_date'),
                'summary' => set_value('summary'),
                'region' => set_value('region')
            );

            // run insert model to write data to db

            if ($this->Events_model->SaveForm($form_data) == TRUE) { // the information has therefore been successfully saved in the db
                redirect('Events/success');   // or whatever logic needs to occur
            } else {
                echo 'An error occurred saving your information. Please try again later';
                // Or whatever error handling is necessary
            }
        }
    }

    function success() {
        echo 'this form has been successfully submitted with all validation being passed. All messages or logic here. Please note
			sessions have not been used and would need to be added in to suit your app';
    }

    function list_event_for_view() {
        $this->load->library('pagination');

        $offset = ($this->uri->segment(3) != '' ? $this->uri->segment(3) : 0);
        $config['total_rows'] = $this->db->count_all('events');
        $config['per_page'] = 4;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['uri_segment'] = 3;
        $config['base_url'] = base_url('Events/list_event_for_view');
        // $config['suffix'] = '?'.http_build_query($_GET, '', "&"); 
        $this->pagination->initialize($config);
        $this->data['paginglinks'] = $this->pagination->create_links();
        // Showing total rows count 
        if ($this->data['paginglinks'] != '') {
            $this->data['pagermessage'] = 'Showing ' . ((($this->pagination->cur_page - 1) * $this->pagination->per_page) + 1) . ' to ' . ($this->pagination->cur_page * $this->pagination->per_page) . ' of ' . $this->pagination->total_rows;
        }
    }

}

?>