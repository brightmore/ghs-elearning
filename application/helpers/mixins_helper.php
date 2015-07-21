<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function check_file($field, $field_value) {

    $CI = & get_instance();
    if (isset($this->custom_errors[$field_value])) {
        $CI->form_validation->set_message($field, "");

        return FALSE;
    }
    return TRUE;
}

function toDateTime($unixTimestamp){
    return date("d-m-Y H:i", $unixTimestamp);
}

function _get_csrf_nonce() {
    $CI = & get_instance();
    $CI->load->helper('string');
    $key = random_string('alnum', 8);
    $value = random_string('alnum', 20);
    $CI->session->set_flashdata('csrfkey', $key);
    $CI->session->set_flashdata('csrfvalue', $value);

    return array($key => $value);
}

function _valid_csrf_nonce() {
    $CI = & get_instance();
    if ($CI->input->post($CI->session->flashdata('csrfkey')) !== FALSE &&
            $CI->input->post($CI->session->flashdata('csrfkey')) == $CI->session->flashdata('csrfvalue')) {
        return TRUE;
    } else {
        return FALSE;
    }
}

 function time_ago($date) {

            if(empty($date)) {
                return "No date provided";
            }

            $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
            $lengths = array("60","60","24","7","4.35","12","10");
            $now = time();
            $unix_date = strtotime($date);

            // check validity of date

            if(empty($unix_date)) {
                return "Bad date";
            }

            // is it future date or past date
            if($now > $unix_date) {
                $difference = $now - $unix_date;
                $tense = "ago";
            } else {
                $difference = $unix_date - $now;
                $tense = "from now";
            }
            for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
                $difference /= $lengths[$j];
            }
            $difference = round($difference);
            if($difference != 1) {
                $periods[$j].= "s";
            }

            return "$difference $periods[$j] {$tense}";
        }