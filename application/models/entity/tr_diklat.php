<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class Tr_diklat extends LWS_model {

    public function __construct() {
        parent::__construct("tr_diklat");
        $this->primary_key = "id_diklat";
    }

    protected $attribute_labels = array(
        "id_diklat" => array("id_diklat", "Id Diklat"),
        "id_kabupaten_kota" => array("id_kabupaten_kota", "Kota Pelaksanaan"),
        "id_jenis_diklat" => array("id_jenis_diklat", "Jenis Diklat"),
        "nama_diklat" => array("nama_diklat", "Nama Diklat"),
        "angkatan" => array("angkatan", "Angkatan"),
        "alamat_lokasi" => array("alamat_lokasi", "Alamat Lokasi"),
        "penyelenggara" => array("penyelenggara", "Penyelenggara"),
        "tgl_pelaksanaan" => array("tgl_pelaksanaan", "Tgl. Pelaksanaan"),
        "tgl_selesai" => array("tgl_selesai", "Tgl. Selesai"),
        "total_jam" => array("total_jam", "Total Jam"),
        "postfix_no_sttpp" => array("postfix_no_sttpp", "Akiran No. STTPP"),
        "created_date" => array("created_date", "created_date"),
        "created_by" => array("created_by", "created_by"),
        "modified_date" => array("modified_date", "modified_date"),
        "modified_by" => array("modified_by", "modified_by"),
        "record_active" => array("record_active", "record_active"),
    );
    
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
        array("created_date", ""),
        array("created_by", ""),
        array("modified_date", ""),
        array("modified_by", ""),
        array("record_active", ""),
    );
    
    protected $related_tables = array(
        "ref_kabupaten_kota" => array(
            "fkey" => "id_kabupaten_kota",
            "columns" => array(
                "nama_kabupaten",
                "kode_kabupaten",
                "is_ibukota",
            ),
            "referenced" => "LEFT"
        ),
        "ref_jenis_diklat" => array(
            "fkey" => "id_jenis_diklat",
            "columns" => array(
                "jenis_diklat",
            ),
            "referenced" => "inner"
        ),
        "ref_provinsi" => array(
            "fkey" => "id_provinsi",
            "reference_to" => "ref_kabupaten_kota",
            "columns" => array(
                "nama_provinsi",
                "kode_provinsi",
            ),
            "referenced" => "LEFT"
        ),
    );
    
    protected $attribute_types = array(
        "tgl_pelaksanaan" => "DATE",
        "tgl_selesai" => "DATE",
        "total_jam" => "NUMERIC",
    );

}

?>