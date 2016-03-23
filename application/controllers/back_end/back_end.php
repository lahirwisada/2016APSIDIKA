<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Back_end extends Main {
    
    protected $backend_controller_location = "back_end/";

    public function __construct() {
        $this->is_front_end = FALSE;
        parent::__construct();
         $this->_layout = "backend";
         $this->my_location = "back_end/";
//        $this->init_back_end();
    }
    
    public function can_access(){
        return TRUE;
    }
    
    private function init_back_end(){
        $this->my_location = "back_end/";
        
        $this->load->model('model_ref_modul');
        $menu_item = $this->model_ref_modul->get_backend_menu();
        $this->backend_controller_location = $this->my_location.$this->_name;
        $this->set("menu_item", $menu_item);
        $this->set("controller_location", $this->backend_controller_location);
        
    }
    
}
?>