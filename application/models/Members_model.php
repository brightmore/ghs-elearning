<?php if (!defined("BASEPATH")) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Members
 *
 * @author bright
 */
class Members_mobel extends CI_Model{
        
    private $_table = "users";
    public function __construct() {
        parent::__construct();
    
    }
    
    function updateProfile($username,$data){
        $where = array('username'=>$data);
        $this->db->update($this->_table,$data,$where);
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        
        return FALSE;
    }
    
    
}
