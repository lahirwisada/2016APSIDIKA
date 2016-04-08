<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once "cpustaka_data.php";

class Cdaftar_diklat extends Cpustaka_data {

    public $model = 'model_tr_diklat';

    public function __construct() {
        parent::__construct('kelola_diklat', 'Daftar Diklat');
        $this->load->model(array(
            'model_ref_kabupaten_kota',
            'model_ref_jenis_diklat',
            ));
    }

    public function index() {
        parent::index();
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function detail($id = FALSE) {
        parent::detail($id, array(
            "id_kabupaten_kota",
            "id_jenis_diklat",
            "nama_diklat",
            "angkatan",
            "alamat_lokasi",
            "penyelenggara",
            "tgl_pelaksanaan",
            "tgl_selesai",
            "total_jam",
            "postfix_no_sttpp",
        ));

        $jenis_diklat = $this->model_ref_jenis_diklat->combobox(array("key"=>"id_jenis_diklat", "value"=>"jenis_diklat"));
//        $kabupaten_kota = $this->model_ref_kabupaten_kota->combobox(array("key"=>"id_kabupaten_kota", "value"=>"nama_kabupaten"));
//        var_dump($jenis_diklat);exit;
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Pendaftaran ' . $this->_header_title
        ));
        
        $this->set("cb_jenis_diklat", $jenis_diklat);
//        $this->set("cb_kabupaten_kota", $kabupaten_kota);
        
        $this->set("additional_js", "back_end/".$this->_name."/js/detail_js");
        
        $this->add_cssfiles(array("plugins/select2/select2.min.css"));
        $this->add_jsfiles(array("plugins/select2/select2.full.min.js"));
    }

}

?>