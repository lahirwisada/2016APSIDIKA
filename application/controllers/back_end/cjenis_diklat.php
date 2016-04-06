<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cjenis_diklat extends Back_end {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_ref_jenis_diklat');
    }

    public function index() {
        $this->get_attention_message_from_session();
        $this->model_ref_jenis_diklat->change_offset_param("currpage_kelola_jenis_diklat");
        $records = $this->model_ref_jenis_diklat->all();
        
        $paging_set = $this->get_paging($this->get_current_location(), $records->record_found, $this->default_limit_paging, "kelola_jenis_diklat");
        $this->set('records', $records->record_set);
        $this->set("keyword", $records->keyword);
        $this->set('field_id', $this->model_ref_jenis_diklat->primary_key);
        $this->set("paging_set", $paging_set);
        $this->set("header_title", "Pustaka Data Jenis Diklat");
        
        $this->set("additional_js", "back_end/cjenis_diklat/js/index_js");
        
        $this->set("bread_crumb", array(
            "#" => 'Jenis Diklat'
        ));
        
        $this->set("next_list_number", $this->model_ref_jenis_diklat->get_next_record_number_list());
    }

    public function detail($id = FALSE) {
        if ($this->model_ref_jenis_diklat->get_data_post(FALSE, array("jenis_diklat", "keterangan"))) {
            if ($this->model_ref_jenis_diklat->is_valid()) {

                $saved_id = $this->model_ref_jenis_diklat->save($id);

                if (!$id) {
                    $id = $saved_id;
                }

                $this->attention_messages = "Jenis Diklat baru telah disimpan.";
                if ($id) {
                    $this->attention_messages = "Perubahan telah disimpan.";
                }
                redirect('back_end/cjenis_diklat');
            } else {
                $this->attention_messages = $this->model_ref_jenis_diklat->errors->get_html_errors("<br />", "line-wrap");
            }
        }

        $detail = $this->model_ref_jenis_diklat->show_detail($id);

        $this->set("detail", $detail);
        
        $this->set("bread_crumb", array(
            "back_end/cjenis_diklat" => 'Jenis Diklat',
            "#" => 'Pendaftaran Jenis Diklat'
        ));
//        $this->add_jsfiles(array("avant/plugins/form-jasnyupload/fileinput.min.js"));
    }

    public function delete($id = FALSE) {
        if ($id) {
            $this->model_ref_jenis_diklat->set_non_active($id);
            $this->store_attention_message_to_session("Data berhasil dihapus.");
        } else {
            $this->store_attention_message_to_session("Data tidak ditemukan.");
        }
        redirect($this->my_location . "cjenis_diklat/index/");
    }

}

?>