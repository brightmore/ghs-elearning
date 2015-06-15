<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of News_model
 *
 * @author bright
 */
class News_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_news($slug = FALSE) {
        if ($slug === FALSE) {
            $query = $this->db->get('news');
            return $query->result_array();
        }

        $query = $this->db->get_where('news', array('slug' => $slug));
        return $query->row_array();
    }

    public function delete_news($id) {
        $this->db->delete('news', array('id' => $id));
        if ($this->db->affected_rows() > 0) {
            $data = TRUE;
        } else {
            $data = FALSE;
        }

        return $data;
    }

    public function get_news_slugs() {
        $this->db->select('slug');
        $this->db->from('news');
        $q = $this->db->get();
        $data = [];
        if ($q->num_rows() > 0) {
            $data = $q->result();
            $q->free_result();
        }

        return $data;
    }

    function add_news($data) {

        $this->db->insert('News', $data);
        if ($this->db->affected_rows() > 0) {
            return FALSE;
        }

        return FALSE;
    }

    function get_news_by_ID($id){
        $this->db->select('*');
        $this->db->from('news');
        $this->db->where(array('id'=>$id));
        $q = $this->db->get();
        $data = [];
        if ($q->num_rows() > 0) {
            $data = $q->row();
            $q->free_result();
        }

        return $data;
    }
    
}
