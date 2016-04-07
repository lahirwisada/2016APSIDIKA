<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class Ref_pegawai extends LWS_model {

    public function __construct() {
        parent::__construct("ref_pegawai");
        $this->primary_key = "id_pegawai";
    }

    protected $attribute_labels = array(
        "id_pegawai" => array("id_pegawai", ""),
        "id_status_perkawinan" => array("id_status_perkawinan", ""),
        "gelar_depan" => array("gelar_depan", ""),
        "gelar_belakang" => array("gelar_belakang", ""),
        "nama_depan" => array("nama_depan", ""),
        "nama_tengah" => array("nama_tengah", ""),
        "nama_belakang" => array("nama_belakang", ""),
        "nama_sambung" => array("nama_sambung", ""),
        "tgl_lahir" => array("tgl_lahir", ""),
        "tempat_lahir" => array("tempat_lahir", ""),
        "nip" => array("nip", ""),
        "no_kep" => array("no_kep", ""),
        "tmt_peg" => array("tmt_peg", ""),
        "created_date" => array("created_date", ""),
        "created_by" => array("created_by", ""),
        "modified_date" => array("modified_date", ""),
        "modified_by" => array("modified_by", ""),
        "record_active" => array("record_active", ""),
    );
    protected $rules = array(
        array("id_pegawai_skpd", ""),
        array("id_status_perkawinan", ""),
        array("gelar_depan", ""),
        array("gelar_belakang", ""),
        array("nama_depan", ""),
        array("nama_tengah", ""),
        array("nama_belakang", ""),
        array("nama_sambung", ""),
        array("tgl_lahir", ""),
        array("tempat_lahir", ""),
        array("nip", ""),
        array("no_kep", ""),
        array("tmt_peg", ""),
        array("created_date", ""), array("created_by", ""), array("modified_date", ""), array("modified_by", ""), array("record_active", ""),);
    protected $related_tables = array();
    protected $attribute_types = array();

}

?>