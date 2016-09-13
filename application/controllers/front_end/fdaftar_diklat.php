<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fdaftar_diklat extends Front_end {

    public function __construct() {

        parent::__construct();

        $this->load->model(array(
            'model_ref_kabupaten_kota',
            'model_ref_jenis_diklat',
            'model_tr_diklat_hal_perhatian',
            'model_tr_diklat_tahapan',
        ));
//        $this->_layout = "backend";
    }

    public function index() {
        
    }

    public function cek_spt($md5_text = FALSE) {

        $detail = FALSE;
        if ($md5_text) {

            $id = substr($md5_text, 32);

            if (is_numeric($id)) {

                $this->load->model('model_tr_diklat');

                $detail = $this->model_tr_diklat->show_detail($id);
            }
        }
        $this->set("detail", $detail);
    }

    public function cek_peserta($md5_text = FALSE) {

        $detail = FALSE;
        if ($md5_text) {
            $ids = substr($md5_text, 32);
            $arr_id_diklat_id_peserta = explode("dk", strtolower($ids));

            if (count($arr_id_diklat_id_peserta) == 2) {

                $this->load->model('model_tr_peserta_diklat');
                $detail = $this->model_tr_peserta_diklat->get_peserta_diklat_by_id_pegawai_id_diklat($arr_id_diklat_id_peserta[1], $arr_id_diklat_id_peserta[0]);
            }
        }
        $this->set("detail", $detail);
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>