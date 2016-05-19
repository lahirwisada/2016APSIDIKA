<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once "cpustaka_data.php";

class Cpeserta_diklat extends Cpustaka_data {

    public $model = 'model_tr_peserta_diklat';

    public function __construct() {
        parent::__construct('kelola_peserta_diklat', 'Peserta Diklat');
        $this->load->model('model_tr_diklat');
    }

    public function index($crypted_id_diklat = FALSE) {

        if (!$crypted_id_diklat) {
            redirect('back_end/cdaftar_diklat');
        }

        $detail_diklat = $this->model_tr_diklat->get_detail_by_crypted($crypted_id_diklat);

        $id_diklat = $detail_diklat ? $detail_diklat->id_diklat : FALSE;

        if (!$id_diklat || !$detail_diklat) {
            redirect('back_end/cdaftar_diklat');
        }

        $this->get_attention_message_from_session();
        $this->{$this->model}->change_offset_param("currpage_" . $this->cmodul_name);
        $records = $this->{$this->model}->all($id_diklat);

        $paging_set = $this->get_paging($this->get_current_location(), $records->record_found, $this->default_limit_paging, $this->cmodul_name);
        $this->set('records', $records->record_set);
        $this->set("keyword", $records->keyword);
        $this->set('field_id', $this->{$this->model}->primary_key);
        $this->set("paging_set", $paging_set);
        $this->set("detail_diklat", $detail_diklat);

        $this->set("additional_js", "back_end/" . $this->_name . "/js/index_js");

        $this->set("next_list_number", $this->{$this->model}->get_next_record_number_list());

        $this->set("bread_crumb", array(
            "back_end/cdaftar_diklat" => "Daftar Diklat",
            "#" => $this->_header_title
        ));
    }

    public function detail($crypted_id_diklat = FALSE, $id = FALSE) {
        parent::detail($id, array(
            "nip",
            "no_kep",
            "gelar_depan",
            "gelar_belakang",
            "nama_depan",
            "nama_tengah",
            "nama_belakang",
            "tempat_lahir",
            "tgl_lahir",
            "id_diklat",
            "id_skpd",
            "id_jabatan",
            "id_golongan",
        ));

        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Pendaftaran ' . $this->_header_title
        ));

        $detail_diklat = $this->model_tr_diklat->get_detail_by_crypted($crypted_id_diklat);

        $this->set("additional_js", array(
            "back_end/" . $this->_name . "/js/detail_js",
            "back_end/" . $this->_name . "/js/detail_isian_js",
        ));

        $this->add_cssfiles(array("plugins/select2/select2.min.css"));
        $this->add_jsfiles(array("plugins/select2/select2.full.min.js"));

        $this->set('id_diklat', $crypted_id_diklat);
        $this->set("detail_diklat", $detail_diklat);

//        $this->add_jsfiles(array("avant/plugins/form-jasnyupload/fileinput.min.js"));
    }

    public function get_like() {
        $keyword = $this->input->post("keyword");

        $provinsi_found = $this->model_ref_provinsi->get_like($keyword);

        $this->to_json($provinsi_found);
    }

}

?>