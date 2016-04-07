<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once "cpustaka_data.php";

class Cdaftar_diklat extends Cpustaka_data {

    public $model = 'model_tr_diklat';

    public function __construct() {
        parent::__construct('kelola_diklat', 'Daftar Diklat');
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

        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Pendaftaran ' . $this->_header_title
        ));
//        $this->add_jsfiles(array("avant/plugins/form-jasnyupload/fileinput.min.js"));
    }

}

?>