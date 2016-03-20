<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Front_end extends Main {

    public function __construct() {
        $this->is_front_end = TRUE;
//        $this->_layout = 'travel';
        parent::__construct();
        $this->init_front_end();
    }
    
    private function init_front_end(){
        $this->my_location = "front_end/";
    }
}
?>