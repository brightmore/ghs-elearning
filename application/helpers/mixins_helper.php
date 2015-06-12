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
