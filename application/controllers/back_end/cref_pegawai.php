<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once "cpustaka_data.php";

class Cref_pegawai extends Cpustaka_data {

    public $model = 'model_ref_pegawai';

    public function __construct() {
        parent::__construct('kelola_pustaka_pegawai', 'Pustaka Data Pegawai');
    }

    public function index() {
        parent::index();
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function detail($id = FALSE) {
        parent::detail($id, array(
            "id_status_perkawinan",
            "gelar_depan",
            "gelar_belakang",
            "nama_depan",
            "nama_tengah",
            "nama_belakang",
            "nama_sambung",
            "tgl_lahir",
            "tempat_lahir",
            "nip",
            "no_kep",
            "tmt_peg",
        ));

        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Pendaftaran ' . $this->_header_title
        ));
//        $this->add_jsfiles(array("avant/plugins/form-jasnyupload/fileinput.min.js"));
    }
    
    public function get_like() {
        $keyword = $this->input->post("keyword");
        $id_skpd = $this->input->post("id_skpd");

        $data_found = $this->{$this->model}->get_like($keyword, $id_skpd);
        
        $this->to_json($data_found);
    }

}

?>