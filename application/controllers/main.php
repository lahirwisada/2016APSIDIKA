<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends LWS_Controller {

    public function __construct() {
        parent::__construct();
    }

//    public function access_rules() {
//        return parent::access_rules(array(
//            array(
//                'allow',
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

    public function index() {
        show_404();
    }

    protected function get_user_detail_from_session() {
        return $this->lmanuser->get("user_detail", $this->my_side);
    }
    
    protected function get_user_detail_from_session_and_db(){
        if ($this->lmanuser->is_front_end_authenticated()) {
            $sess_detail = $this->lmanuser->get("user_detail", $this->my_side);
            if ($sess_detail) {
                $this->load->model('model_ref_pegawai');
                return $this->model_ref_pegawai->get_by_nip($sess_detail["nip"]);
            }
        }
        return FALSE;
    }
    
    
}

?>