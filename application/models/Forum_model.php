<?php
if (!defined("BASEPATH"))
    exit('No direct script access allowed');

/**
 * Description of Forum_model
 *
 * @author bright
 */
class Forum_model extends CI_Model{
   
     private $_table_channel = 'channels';
    private $_table_thread = 'thread';
    private $_table_post = 'post';
    private $_table_user_thread = 'user_thread';
    
    public function __construct() {
        parent::__construct();
    }
    
    function get_channels(){
        $this->db->select('*');
        $this->db->from($this->_table_channel);
        $query = $this->db->get();
        $data = [];
        if($query->num_rows() > 0){
            $data = $query->result();
            $query->free_result();
            return $data;
        }
        
        return $data;
    }
    
    public function get_user_thread($user_id,$limit=10,$offset=0){
//        $sql = "SELECT t.id,t.title,c.color FROM thread AS t "
//                . "INNER JOIN channels AS c ON t.channel_id = c.id "
//                . "INNER JOIN user_thread AS u ON t.id = u.thread_id "
//                . "WHERE u.user_id = ? "
//                . "ORDER BY t.id "
//                . "LIMIT ?,?";
        $this->db->select("thread.id,thread.title,channels.color");
        $this->db->from($this->_table_thread);
        $this->db->where(array('user_thread.user_id'=>$user_id));
        $this->db->join('channels','thread.channel_id = channels.id');
        $this->db->join('user_thread','thread.id = user_thread.thread_id');
        $this->db->order_by('thread.id','DESC');
        $this->db->limit($limit,$offset);
        $query = $this->db->get();
        $data = array();
        
        if($query->num_rows() > 0){
            $data = $query->result();
            $query->free_result();
            
            return $data;
        }
        
        return $data;
    }
    
    public function get_general_thread($slug='general',$offset=0,$limit=50){
        $this->db->select('id,title,slug,channel_id,user_id,post_on');
        $this->db->from($this->_table_thread);
        $this->db->where(array('slug'=>$slug));
        $this->db->order_by('id','DESC');
        $this->db->limit($limit,$offset);
        $query = $this->db->get();
        $data = array();
        if($query->num_rows() > 0){
            $data = $query->result();
            $query->free_result();
        }
        
        return $data;
    }
    
    public function get_thread_post($thread_id,$offset=0,$limit=50){
        $this->db->select('id,text,timestamps,');
        $this->db->from($this->_table_post);
        $this->db->join('users', 'users.id = thread.thread_id');
        $this->db->where(array('thread_id'=>$thread_id));
        $this->db->order_by('id','DESC');
        $this->db->limit($limit,$offset);
        $query = $this->db->get();
        $data = array();
        if($query->num_rows() > 0){
            $data = $query->result();
            $query->free_result();
        }
        
        return $data;
    }
  
}
