<?php //(!defined("BASEPATH")) or exit('No direct script access allowed');

function getCourses($cat_id){
    $CI = & get_instance();
    
    $CI->db->select("*");
    $CI->db->from('courses');
    $CI->db->where(array('category_id' =>$cat_id));
    $q = $CI->db->get();
    $data = array();
    if($q->num_rows() > 0){
         $data = $q->result();
         return $data;
    }
    
    return $data;
}

function getModerator($course_id){
    
     $CI = & get_instance();
     
     $CI->db->select('instructor_id');
     $CI->db->from('courses');
     $CI->db->where(array('course_id'=>$course_id));
     $CI->db->limit(1);
     
     $instructor_id = $CI->db->get()->row()->instructor_id;
     
     $CI->db->select('first_name,last_name,salutation,institution,phone,email');
     $CI->db->from('users');
     $CI->db->where(array('id'=>$instructor_id));
     return $CI->db->get()->row();
}

function getCourseSubject($course_id){
    $CI =& get_instance();
    $CI->db->select("subject_name,subject_id,description");
    $CI->db->from("subject");
    $CI->db->where(array('course_id'=>$course_id));
    $query = $CI->db->get();
    return $query->result(); 
}
