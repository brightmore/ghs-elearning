<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of members
 *
 * @author bright
 */
class members extends CI_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
        
        $this->load->library('ion_auth');
    }
}
