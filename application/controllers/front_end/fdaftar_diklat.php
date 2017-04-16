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
            'model_tr_diklat_persyaratan',
            'model_tr_diklat',
        ));
//        $this->_layout = "backend";
    }

    public function index() {
        
    }

    public function detail($crypted_id_diklat = FALSE) {
        $detail = FALSE;
        $persyaratan_diklat = FALSE;
        if ($crypted_id_diklat) {
            $detail = $this->model_tr_diklat->get_detail_by_crypted($crypted_id_diklat);
            if ($detail) {
                $persyaratan_diklat = $this->model_tr_diklat_persyaratan->all_by_id_diklat($detail->id_diklat);
            }
        }
        $this->set("detail", $detail);
        $this->set("persyaratan_diklat", $persyaratan_diklat);
    }

    public function daftar($crypted_id_diklat = FALSE) {
        $detail = FALSE;

        $user_detail = $this->get_user_detail_from_session_and_db();
        if ($crypted_id_diklat) {
            $detail = $this->model_tr_diklat->get_detail_by_crypted($crypted_id_diklat);
            if ($detail) {
                /**
                 * @todo get detail pns
                 */
            }
        }

        $additional_js = array();
        if ($this->is_authenticated()) {
            $additional_js = array_merge($additional_js, array(
                "front_end/" . $this->_name . "/js/daftar_mandiri_js",
                "front_end/" . $this->_name . "/js/daftar_js",
            ));
        }

        $this->add_jsfiles(array(
            "atlant/helper.js",
        ));
        
        $this->set("additional_js", $additional_js);

        $this->set("user_detail", $user_detail);
        $this->set("detail", $detail);
    }
    
    public function  mendaftar($id_diklat_crypted = FALSE){
        if($id_diklat_crypted){
            var_dump($_FILES);exit;
            echo '1';
        }
        echo '0';
    }

    public function cek_spt($md5_text = FALSE) {

        $detail = FALSE;
        if ($md5_text) {

            $id = substr($md5_text, 32);

            if (is_numeric($id)) {
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