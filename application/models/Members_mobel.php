<?php

if (!defined("BASEPATH"))
    exit('No direct script access allowed');

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
class Members_mobel extends CI_Model {

    private $_table = "users";

    public function __construct() {
        parent::__construct();
    }

    function updateProfile($username, $data) {
        $where = array('username' => $data);
        $this->db->update($this->_table, $data, $where);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }

    function get_users_list($group = 'all') {

        $data = array();
        $this->db->select('username,id');
        $this->db->from('users');
        if ($group !== 'all') {
            $this->db->where('group_id', '2');
        } else {
            $groups = [];
            $this->db->where_not_in('username', $names);
        }

        $this->db->join("user_group", "user_group.user_id = users.id");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        }

        return $data;
    }

    function get_instructors_for_View($select = TRUE) {
        $data = array();
        $this->db->select('username,users.id,email,first_name,last_name,salutation');
        $this->db->from('users');
        $this->db->join("users_groups", "users_groups.user_id = users.id");
        $groups = [3, 4]; //instructors and moderators group
        $this->db->where_in('group_id', $groups);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            if ($select) {
                $fullname = '';
                foreach ($query->result() as $value) {
                   
                        $fullname = $value->salutation . ' ' . $value->last_name . ' ' + $value->first_name;
                    
                    if ($fullname === FALSE) {
                        $data[$value->id] = $value->email;
                    } else {
                        $data[$value->id] = $value->last_name .' '.$value->first_name;
                    }
                  
                }
            } else {
                $data = $query->result();
            }
        }

        return $data;
    }

}
