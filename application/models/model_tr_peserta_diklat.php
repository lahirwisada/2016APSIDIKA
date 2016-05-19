<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/tr_peserta_diklat.php";

class model_tr_peserta_diklat extends Tr_peserta_diklat {

    protected $rules = array(
        array("id_peserta_diklat", ""),
        array("id_diklat", "numeric"),
        array("id_pegawai", "numeric"),
        array("id_skpd", "required|numeric"),
        array("id_jabatan", "required|numeric"),
        array("id_golongan", "required|numeric"),
        array("nomor_peserta", "numeric"),
        array("surat_konfirmasi_ok", "numeric"),
        array("path_scan_surat_konfirmasi", ""),
    );

    public function __construct() {
        parent::__construct();
    }

    private function __check_blank_post() {
        $post_null_check = array(
            "tgl_lahir",
        );

        foreach ($post_null_check as $null_post) {
            if ($this->{$null_post} == "") {
                $this->{$null_post} = "NULL";
            } else {
                $this->{$null_post} = "'" . $this->{$null_post} . "'";
            }
        }
    }

    protected function after_get_data_post() {
        $this->__check_blank_post();
//        var_dump($this->attributes);exit;
    }

    private function __remove_non_column_data($data = FALSE) {
        if ($data) {
            $array_key_to_unset = array(
                "nip",
                "no_kep",
                "gelar_depan",
                "nama_depan",
                "nama_tengah",
                "nama_sambung",
                "nama_belakang",
                "gelar_belakang",
                "tempat_lahir",
                "tgl_lahir",
            );

            foreach ($array_key_to_unset as $key_to_unset) {
                if (array_key_exists($key_to_unset, $data)) {
                    unset($data[$key_to_unset]);
                }
            }
        }
        return $data;
    }

    protected function before_data_update($update_data = FALSE) {
        return $this->__remove_non_column_data($update_data);
    }

    private function __produce_nama_sambung($nama_depan = "", $nama_tengah = "", $nama_belakang = "") {
        $arr_nama_sambung = array($nama_depan, $nama_tengah, $nama_belakang);
        foreach ($arr_nama_sambung as $key => $nama) {
            if (trim($nama) == '') {
                unset($arr_nama_sambung[$key]);
            }
        }
        $nama_sambung = implode(" ", $arr_nama_sambung);
        unset($arr_nama_sambung);
        return $nama_sambung;
    }

    protected function before_data_insert($insert_data = FALSE) {
//        echo "masuk sini";exit;
        $this->load->model('model_ref_pegawai');
//        var_dump($insert_data);exit;
        $insert_data['nama_sambung'] = $this->__produce_nama_sambung($insert_data["nama_depan"], $insert_data["nama_tengah"], $insert_data["nama_belakang"]);
        
        $id_pegawai = $this->model_ref_pegawai->check_and_insert_pegawai_when_not_found($insert_data);
        $insert_data['id_pegawai'] = $id_pegawai;

        return $this->__remove_non_column_data($insert_data);
    }

    protected function before_get_data_post() {
        
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