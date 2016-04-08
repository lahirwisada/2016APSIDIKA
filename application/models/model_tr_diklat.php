<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/tr_diklat.php";

class model_tr_diklat extends tr_diklat {

    protected $rules = array(
        array("id_diklat", ""),
        array("id_kabupaten_kota", ""),
        array("id_jenis_diklat", ""),
        array("nama_diklat", ""),
        array("angkatan", ""),
        array("alamat_lokasi", ""),
        array("penyelenggara", ""),
        array("tgl_pelaksanaan", ""),
        array("tgl_selesai", ""),
        array("total_jam", ""),
        array("postfix_no_sttpp", ""),
    );

    public function __construct() {
        parent::__construct();
    }

    protected function before__get_all() {
        $this->db->order_by("id_diklat", "desc");
        $this->db->order_by("tgl_pelaksanaan", "desc");
    }
    
    protected function after_get_data_post() {
        if($this->tgl_pelaksanaan == ''){
            $this->tgl_pelaksanaan = NULL;
        }
        if($this->tgl_selesai == ''){
            $this->tgl_selesai = NULL;
        }
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array(
                    "nama_diklat",
                    "angkatan",
                    "alamat_lokasi",
                    "penyelenggara",
                    "tgl_pelaksanaan",
                    "tgl_selesai",
                    "total_jam",
                    "postfix_no_sttpp",
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

}

?>