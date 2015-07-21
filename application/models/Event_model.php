<?php
if (!defined("BASEPATH"))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Event_model
 *
 * @author bright
 */
class Event_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function save_form($form_data) {
        $this->db->insert('events', $form_data);

        if ($this->db->affected_rows() == '1') {
            return TRUE;
        }

        return FALSE;
    }

    function get_current_events($limit=10,$offset=0){
        $now = time();
        $query = $this->db->select('*')
                ->from('events')
                ->where('event_end_datetime >=',$now)
                ->order_by('id', 'DESC')
                ->limit($limit)
                ->get();
        
        $data = array();
        if($query->num_rows() > 0){
            $data = $query->result();
            $query->free_result();
        }
        
        return $data;
    }
    
    function all_event($limit,$offset){
        
      $query =  $this->db->get('events',$limit,$offset);
        $data = array();
        if($query->num_rows()){
            $data = $query->result();
            return $data;
        }
        
        return $data;
    }
    
    function get_event($event_id)
    {
        $query = $this->db->select('*')
                ->form('event')
                ->where(array('id'=>$event_id))
                ->get();
        if($query->num_rows() == 1){
            return $query->row();
        }
        return FALSE;
    }
    
    function update_event($data,$event_id){
        $this->db->update($data,array('id'=>$event_id));
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        
        return FALSE;
    }
    
//    function get_current_events($limit=10,$offset=0){
//        $this->db->select("*");
//        $this->db->from('events');
//        $this->db->order_by('id','DESC');
//        $this->db->limit($limit,$offset);
//        $query = $this->db->get();
//        
//        $data = array();
//        if($query->num_rows() > 0){
//            $data = $query->result();
//            $query->free_result();
//        }
//        
//        return $data;
//    }
    
    function delete_events($event_id){
        $this->db->delete('events',array('eventid'=>$event_id));
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        
        return FALSE;
    }
    
    function current_event($limit = 10){
        
    }
    
    
}
