<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cref_golongan extends Back_end {

    public $model = 'model_ref_golongan';

    public function __construct() {
        parent::__construct('kelola_pustaka_golongan', 'Pustaka Data Golongan');
    }

    public function index() {
        parent::index();
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function detail($id = FALSE) {
        parent::detail($id, array("kode_golongan", "golongan", "keterangan"));

        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Pendaftaran ' . $this->_header_title
        ));
//        $this->add_jsfiles(array("avant/plugins/form-jasnyupload/fileinput.min.js"));
    }

    public function get_like() {
        $keyword = $this->input->post("keyword");

        $data_found = $this->model_ref_golongan->get_like($keyword);

        $this->to_json($data_found);
    }

}

?>