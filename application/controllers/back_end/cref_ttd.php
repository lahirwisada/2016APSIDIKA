<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cref_ttd extends Back_end {

    public $model = 'model_ref_ttd';

    public function __construct() {
        parent::__construct('kelola_pustaka_ttd', 'Pustaka Tanda Tangan');
    }

    public function index() {
        parent::index();
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function detail($id = FALSE) {
        parent::detail($id, array(
            "id_pegawai",
            "jabatan_ttd",
            "uraian_atas_ttd",
            "uraian_bawah_ttd",
            "id_skpd",
        ));

        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Pendaftaran ' . $this->_header_title
        ));

        $this->set("additional_js", "back_end/" . $this->_name . "/js/detail_js");

        $this->add_cssfiles(array("plugins/select2/select2.min.css"));
        $this->add_jsfiles(array("plugins/select2/select2.full.min.js"));
    }
    
    public function get_like() {
        $keyword = $this->input->post("keyword");

        $kabupaten_found = $this->{$this->model}->get_like($keyword);
        
        $this->to_json($kabupaten_found);
    }

}

?>