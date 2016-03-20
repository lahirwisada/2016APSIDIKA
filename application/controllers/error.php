<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Error extends GS_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function access_rules() {

        return array(
            array(
                'allow',
                'actions' => array("index"),
                'users' => array('*')
            ),
            array(
                'allow',
                'users' => array('@')
            )
        );
    }
    
    public function index(){
        $status_code = $this->input->get('s');
        $message = $this->input->get('m');
        $heading = $this->input->get('h');
        
        $this->set('status_code', $status_code);
        $this->set('message', $message);
        $this->set('heading', $heading);
    }
    
    public function system(){
        $severity = $this->input->get('s');
        $message = $this->input->get('m');
        $filename = $this->input->get('f');
        $line_number = $this->input->get('l');
        
        $this->set("severity", $severity);
        $this->set("message", $message);
        $this->set("filename", $filename);
        $this->set("line_number", $line_number);
    }
}
?>