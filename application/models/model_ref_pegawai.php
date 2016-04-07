<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/ref_pegawai.php";

class model_ref_pegawai extends ref_pegawai {

    protected $rules = array(
        array("id_pegawai_skpd", ""),
        array("id_status_perkawinan", ""),
        array("gelar_depan", "max_length[20]|alpha_dash"),
        array("gelar_belakang", "max_length[100]|alpha_dash"),
        array("nama_depan", "required|max_length[60]|alpha_dash"),
        array("nama_tengah", "max_length[60]|alpha_dash"),
        array("nama_belakang", "max_length[60]|alpha_dash"),
        array("nama_sambung", "required|min_length[2]|max_length[200]|alpha_dash"),
        array("tgl_lahir", ""),
        array("tempat_lahir", "max_length[200]"),
        array("nip", "max_length[60]"),
        array("no_kep", "max_length[200]"),
        array("tmt_peg", ""),
    );

    public function __construct() {
        parent::__construct();
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array(
                    "gelar_depan",
                    "gelar_belakang",
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }
}

?>