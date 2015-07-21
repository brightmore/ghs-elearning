<?php

class Events extends CI_Controller {

    private $upload_location = './uploads/eventsPoster';
    
    function __construct() {
        parent::__construct();

        $this->load->model('Event_model', 'mevents');
    }
    
    function process_event_form() {
        
          if (_valid_csrf_nonce() === FALSE) {
            $this->session->flashdata('error', 'There is something fishy about the form you just submitted, it fails CSRF Test');
            redirect("/index.php/Frontier/");
        }

        
        $this->form_validation->set_rules('event_start_date', 'Event date', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('event_title', 'Event Title', 'required|trim|max_length[500]|xss_clean');
        $this->form_validation->set_rules('event_end_date', 'Event End Date', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('event_summary', 'Summary', 'required|trim|xss_clean');
        $this->form_validation->set_rules('region', 'Region', 'required|trim');
        $this->form_validation->set_rules('location', 'Location', 'required|trim|xss_clean');
       // $this->form_validation->set_rules('userfile', 'Banner', 'required');

        $this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');

        if ($this->form_validation->run() === FALSE) { // validation hasn't been passed
           // $this->load->view('events_form _view');
            echo $this->form_validation->error_string();
        } else { // passed validation proceed to post success logic
            // build array for the model
            //filter_input(INPUT_POST | INPUT_GET, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $event_start_date = $this->input->post('event_start_date');
            $event_end_date = $this->input->post('event_end_date');
            $event_title = $this->input->post('event_title');
            $summary = $this->input->post('event_summary');
            $region = $this->input->post('region');
            $location = $this->input->post('location');
            
            $banner = NULL;
            if (@$_FILES['logo']['userfile'] !== "") {
                $config['upload_path'] = $this->upload_location;
                $config['allowed_types'] = 'jpeg|png|jpg|gif';
                $config['encrypt_name'] = TRUE;
                $config['remove_spaces'] = TRUE;
                $config['max_size'] = '1048';

                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->do_upload();

                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->do_upload();
                $error = $this->upload->display_errors();
                if (empty($error)) {
                    $data = $this->upload->data();
                    $poster = $data['file_name'];
                    $banner = substr($this->upload_location, 2) . '/'.$poster;
                } else {
                    $this->errors['banner'] = $error;
                }
            }

            $data = [
                'event_start_datetime' => $event_start_date,
                'event_end_datetime' => $event_end_date,
                'event_title' => $event_title,
                'event_summary' => $summary,
                'region' => $region,
                'location' => $location,
                'banner'=>$banner
            ];

//            $form_data = array(
//                'event_date' => set_value('event_date'),
//                'event_title' => set_value('event_title'),
//                'event_end_date' => set_value('event_end_date'),
//                'summary' => set_value('summary'),
//                'region' => set_value('region'),
//                'location' => set_value('location')
//            );
//            
            $this->db->insert('events',$data);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('success','The event was added successfully.');
                redirect('/index.php/Events/create_event');
            }  else {
                $this->session->set_flashdata('failure','An error occurred saving your information. Please try again later');
                redirect('/index.php/Events/create_event');
            }
        }
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

    function view_event($id) {
        $content['events'] = $this->mevents->get_event($id);
    }

    function delete_event($id) {
        $this->db->delete('events', array('id' => $id));
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("sucess", "The event was delete successfully.");
            redirect("index.php/Events/create_event");
        } else {
            $this->session->set_flashdata("failure", 'No event was delete successfully.');
            redirect("index.php/Events/create_event");
        }
    }

    function create_event() {

        $this->load->library('pagination');
        //$this->uri->segment(3,0);

        if ($this->uri->segment(3)) {
            $offset = ($this->uri->segment(3));
        } else {
            $offset = 0;
        }

        $config['base_url'] = base_url() . '/index.php/Events/create_event';
        $config['total_rows'] = $this->db->count_all_results('events');
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $this->pagination->initialize($config);
        $content['csrf'] = _get_csrf_nonce();
        $content['events'] = $this->mevents->all_event($config['per_page'], $offset);
        $content['pagination'] = $this->pagination->create_links();
        $content['page'] = 'Create Event';
        $data['title'] = "Event Management";
        $data['content'] = $this->load->view('admin/event_form', $content, TRUE);
        $this->load->view('admin/template', $data);
    }

}

?>