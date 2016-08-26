<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Back_end extends Main {
    
    protected $backend_controller_location = "back_end/";

    public function __construct() {
        $this->is_front_end = FALSE;
        parent::__construct();
         $this->_layout = "atlant";
         $this->my_location = "back_end/";
        $this->init_back_end();
    }

    
//    public function access_rules() {
//        return parent::access_rules(array(
////            array(
////                'allow',
////                'users' => array('*')
////            ),
//            array(
//                'allow',
//                'actions' => array("login", "logout"),
//                'users' => array('*')
//            ),
//            array(
//                'allow',
//                'actions' => array("back_end"),
//                'roles' => array("administrator"),
//                'users' => array('@')
//            )
//        ));
//    }
//    public function can_access(){
//        return TRUE;
//    }
    
    private function init_back_end(){
        $this->my_location = "back_end/";
        
        $this->init_backend_menu();
        
        $this->backend_controller_location = $this->my_location.$this->_name;
        $this->set("controller_location", $this->backend_controller_location);
        
    }
    
}
?>