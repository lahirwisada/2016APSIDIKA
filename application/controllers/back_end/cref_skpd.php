<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once "cpustaka_data.php";

class Cref_skpd extends Cpustaka_data {
    
    public $model = 'model_ref_skpd';

    public function __construct() {
        parent::__construct('kelola_pustaka_skpd', 'Pustaka Data SKPD');
    }

    public function index() {
        parent::index();
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function detail($id = FALSE) {
        parent::detail($id, array("nama_skpd", "col_order"));
        
        $this->set("bread_crumb", array(
            "back_end/".$this->_name => $this->_header_title,
            "#" => 'Pendaftaran '.$this->_header_title
        ));
//        $this->add_jsfiles(array("avant/plugins/form-jasnyupload/fileinput.min.js"));
    }

}

?>