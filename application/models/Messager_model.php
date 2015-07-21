<?php

if (!defined("BASEPATH"))
    exit('No direct script access allowed');

class Messager_model extends CI_Model {

    /**
     * @var string
     * CMS Master table name
     */
    private $_table = 'messager';
    private $_pk_field = 'id';
    private $list_colums = array('id', 'mgs', 'dateCreateOn', 'sender', 'reciever', 'viewed',);
    private $sort_colums_order = array('id', 'mgs', 'dateCreateOn', 'sender', 'reciever',);

    public function __construct() {

        parent::__construct();
        $this->load->library('email');
    }

    /**
     * Functon find by primery key
     * 
     * process  
     * 
     * @auther Bright Nsarko <brightmore1@gmail.com>
     * @createdon   : 2015-06-03 
     * @
     * 
     * @param type  id
     * @return type array
     * exceptions
     *
     *   
     * 
     */
    function findByPk($id) {

        $this->db->select("*");
        $this->db->from($this->_table);

        $this->db->where($this->_pk_field, $id);
        $this->db->limit(1);
        $query = $this->db->get();
        $result = array_shift($query->result_array());

        return $result;
    }

    /**
     * Functon get_data
     * 
     * process for search result
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
    public function get_data($sort_num = 0, $sortby = "DESC", $limit, $start, $search = "") {

        $sort_field = $this->sort_colums_order[$sort_num];
        $this->db->select($this->sort_colums_order);
        $this->db->from($this->_table);

        //$where = "is_active = 1";
        if (!empty($search)) {
            $search = mysql_escape_string($search);
        }

        //$this->db->where($where, NULL, FALSE);
        $this->db->order_by($sort_field, $sortby);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo $this->db->last_query();

        $result = $query->result_array();

        return $result;
    }

    function count_all_rows($search = "") {

        $this->db->select("COUNT(*) AS numrows");
        $this->db->from($this->_table);
        //$where = "is_active = 1";
        if (!empty($search)) {
            //search condition      
        }

        //$this->db->where($where, NULL, FALSE);
        return $this->db->get()->row()->numrows;
    }

    function sent_bulk_email($list, $title, $message, $attachment) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['bcc_batch_mode'] = TRUE;
        $config['bcc_batch_size'] = 500;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        $ids = implode(',', $list);

        $sql = "SELECT email FROM users WHERE id IN[?]";
        $query = $this->db->query($sql, array($ids));

        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
        }

        if (empty($data)) {
            return FALSE;
        }

        $mailing_list = array();
        try {
            foreach ($data as $value) {
                $mailing_list[] = $value->email;
            }

            $recepients = implode(",", $mailing_list);

            $this->email->initialize($config);
            $this->email->clear(TRUE);
            $this->email->from($this->load->config('admin_email', TRUE), 'Ghana Health Services');//
            $this->email->to('support@**.com');
            $this->email->bcc($recepients);
            $this->email->subject($title);
            // $data['message'] = $message;
            // $message = $this->load->view('email_template',$data,TRUE);
            $this->email->message($message);

            if (isset($attachment)) {
                if (file_exists($attachment)) {
                    $this->email->attach($attachment);
                }
            }

            if ($this->email->send()) {
               return TRUE;
            }
            
            return false;
        } catch (Exception $exc) {
            log_message('error', "[location]:Messager_model,[method]:send_bulk_mail, [error]:" . $exc->getMessage());
            echo $exc->getTraceAsString();
        }
    }

    function send_bulk_msg($list, $sender_id, $message) {
        if (empty($list) || $sender_id == FALSE || empty($message)) {
            return false;
        }

      $sender_username =  $this->db->select('username')->from('users')->where('id',$sender_id)->get()->row()->username;
        $now = time();
        $data = array();
        foreach ($list as $value) {
            $data[] = array(
                'mgs' => $message,
                'dateCreateOn' => $now,
                'sender' => $sender_id,
                'receiver' => $value,
                'sender_username'=>$sender_username
            );
        }

        try {
            $this->db->insert_batch('messagers', $data);
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }

            return FALSE;
        } catch (Exception $exc) {
            log_message('error', "[location]:Messager_model, [error]:" . $exc->getMessage());
            echo $exc->getTraceAsString();
        }
    }
    
    function delete_event($ids){
        if(is_array($ids)){
            foreach ($ids as $id){
                $this->db->where('id',$id);
                $this->db->delete('messager');
            }
        }else{
            $this->db->where('id',$id);
            $this->db->delete('messager');
        }
    }
    
    function get_messages($user_id){
        
        if(!is_integer($user_id)){
            show_error("Invalid user id, trying to access the system from outside.");
        }
        
        $this->db->select("id,mgs,dateCreateOn,title,sender_username");
        $this->db->from($this->_table);
        $this->db->where(array('receiver' => $user_id));
        $query = $this->db->get();
       
       $data = array();
       if($query->num_rows() > 0){
           $data = $query->result();
           $query->free_result();
       }
       return $data;
        
    }
    
    function get_message($id){
        if(! is_integer($id)){
            //@TODO
            show_404("Invalid message id, trying to access the system from outside.");
        }
        
        $where = ['id'=>$id];
        $this->db->update('messager',["viewed"=>'YES'],$where);
//        if($this->db->affected_rows() > 0){
//            
//        }
        $this->db->select("*");
        $this->db->from('messager');
        $this->db->where(array('id'=>$id));
        $query = $this->db->get();
        
        $result = $query->row();
        
        $data[] = $result;
        
        $query->free_result();
        
        $sql = "SELECT * FROM messager WHERE id != ? ORDER BY id desc LIMIT 20";
        $q = $this->db->query($sql,array($id));
        if($q->num_rows()){
            array_push($data, $q->result());
            $q->free_result();
        }
        
        return $data;
       
    }

    function get_messages_count($user_id) {
        $this->db->select("COUNT(*) AS numrows");
        $this->db->from($this->_table);
        $this->db->where(array('receiver' => $user_id,'viewed'=>'NO'));
        
        return $this->db->get()->row()->numrows;
    }

}
