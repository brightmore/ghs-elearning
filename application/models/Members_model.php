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
class Members_model extends CI_Model {

    private $_table = "users";
    const STUDENTS = 2;
    const INSTRUCTORS = 3;
    const MODERATORS= 4;

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
    
    function get_instructor_courses($instructor_id){
        $this->db->select("course_id,course_name");
        $this->db->from('courses');
        $this->db->where(array('instructor_id'=>$instructor_id));
        $query = $this->db->get();
        $data = array();
        if($query->num_rows() > 0){
            $data = $query->result();
        }
        return $data;
    }
    
    function get_students_for_instructor($instructor_id,$course_id){
        //let get first course id for the instructor_id 
        
        $this->db->select('instructor_id');
        $this->db->from('courses');
        $this->db->where('instructor_id',$instructor_id);
        $this->db->where('course_id',$course_id);
        $q = $this->db->get();
        
        if($q->num_rows() == 0){
            return FALSE;
        }
        
         $sql = "SELECT distinct(users.id),username,email,phone,institution FROM users INNER JOIN "
                 . "take_course ON users.id = take_course.user_id WHERE course_id = ?;";
        $query = $this->db->query($sql,array($course_id));

        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
        }

        return $data;
    }
    
    function get_total_instructors_moderators(){
         $sql = "SELECT count(distinct users.id) as total_falcuty FROM users inner join users_groups on users_groups.user_id = users.id
where users_groups.group_id IN(?,?);";
        
        $query = $this->db->query($sql,array(Members_model::INSTRUCTORS,  Members_model::MODERATORS));
       return $total_falcuty = $query->row()->total_falcuty;
    }
    
    function get_total_students(){
         $sql = "SELECT count(distinct users.id) as total_students FROM users inner join users_groups on users_groups.user_id = users.id
where users_groups.group_id = ?;";
        
        $query = $this->db->query($sql,array(Members_model::STUDENTS));
       return $total_student = $query->row()->total_students;
    }
    
    function get_students_limit(){
        $sql = "SELECT distinct(users.id),username,email,phone,institution  FROM users inner join users_groups on users_groups.user_id = users.id
where users_groups.group_id = ? LIMIT 30;";
        
        $query = $this->db->query($sql,array(Members_model::STUDENTS));
        
        $data = array();
        
        if($query->num_rows() > 0){
            $data = $query->result();
            $query->free_result();
        }
        
        return $data;
    }

    function get_moderators_instructors(){
        $sql = "SELECT distinct(users.id),username,email,phone,institution FROM users inner join users_groups on users_groups.user_id = users.id
where users_groups.group_id IN(?,?);";
        $query = $this->db->query($sql,array(Members_model::INSTRUCTORS,  Members_model::MODERATORS));

        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
        }

        return $data;
    }

    function get_instructors_for_View($select = TRUE) {
        $data = array();
        $this->db->select('username,users.id,email,first_name,last_name,salutation');
        $this->db->from('users');
        $this->db->join("users_groups", "users_groups.user_id = users.id");
        $groups = [3, 4]; //instructors and moderators group
        $this->db->where_in('users_groups.group_id', $groups);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            if ($select) {
                $fullname = '';
                foreach ($query->result() as $value) {

                    $fullname = $value->salutation . ' ' . $value->last_name . ' ' + $value->first_name;

                    if ($fullname === FALSE) {
                        $data[$value->id] = $value->email;
                    } else {
                        $data[$value->id] = $fullname;
                    }
                }
            } else {
                $data = $query->result();
            }
        }
        $query->free_result();
        return $data;
    }

}
