<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/tr_peserta_diklat.php";

class model_tr_peserta_diklat extends Tr_peserta_diklat {

    protected $rules = array(
        array("id_peserta_diklat", ""),
        array("id_diklat", "required|numeric"),
        array("id_pegawai", "required|numeric"),
        array("nomor_peserta", "numeric"),
        array("surat_konfirmasi_ok", "numeric"),
        array("path_scan_surat_konfirmasi", ""),
    );

    public function __construct() {
        parent::__construct();
    }

    public function all($id_diklat = FALSE, $force_limit = FALSE, $force_offset = FALSE) {

        $this->db->where($this->table_name . ".id_diklat = '" . $id_diklat . "'");

        return parent::get_all(array(
                    "nama_diklat",
                    "angkatan",
                    "alamat_lokasi",
                    "penyelenggara",
                    "tgl_pelaksanaan",
                    "tgl_selesai",
                    "total_jam",
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
                    "status_perkawinan",
                    "kode_status_perkawinan",
                    "tgl_ditetapkan",
                    "tgl_berakhir",
                    "kode_golongan",
                    "golongan",
                    "keterangan",
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

}

?>