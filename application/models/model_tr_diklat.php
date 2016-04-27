<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/tr_diklat.php";

class model_tr_diklat extends tr_diklat {

    protected $rules = array(
        array("id_diklat", ""),
        array("id_kabupaten_kota", "numeric"),
        array("id_jenis_diklat", "numeric|required"),
        array("nama_diklat", "required|max_length[200]"),
        array("angkatan", "required|max_length[20]"),
        array("alamat_lokasi", "required|max_length[500]"),
        array("penyelenggara", "required|max_length[500]"),
        array("tgl_pelaksanaan", ""),
        array("tgl_selesai", ""),
        array("total_jam", "required|numeric"),
        array("postfix_no_sttpp", "required|max_length[60]"),
        array("no_spt_a", "numeric|max_length[60]"),
        array("no_spt_b", "numeric|max_length[60]"),
        array("no_spt_c", "max_length[60]"),
        array("no_spt_d", "max_length[60]"),
        array("tgl_spt", ""),
        array("spt_tembusan", ""),
        array("spt_dasar", ""),
        array("spt_kepada", ""),
        array("id_ref_ttd", ""),
    );

    public function __construct() {
        parent::__construct();
    }

    protected function before__get_all() {
        $this->db->order_by("id_diklat", "desc");
        $this->db->order_by("tgl_pelaksanaan", "desc");
    }

    private function __convert_to_pg_array() {
        $post_check = array(
            "spt_dasar",
            "spt_tembusan",
        );

        foreach ($post_check as $post_key) {
            $posted_data = $this->input->post($post_key);
            if (!$posted_data) {
                $_POST[$post_key] = NULL;
            } else {
                $_POST[$post_key] = to_pg_array($_POST[$post_key]);
            }
        }
    }

    protected function before_get_data_post() {
        $post_check = array(
            "id_kabupaten_kota",
            "id_ref_ttd",
        );

        foreach ($post_check as $post_key) {
            $posted_data = $this->input->post($post_key);
            if (!$posted_data) {
                $_POST[$post_key] = NULL;
            }
        }
        $this->__convert_to_pg_array();
    }

    private function __check_blank_post() {
        $post_null_check = array(
            "tgl_pelaksanaan",
            "tgl_selesai",
            "tgl_spt",
        );

        foreach ($post_null_check as $null_post) {
            if ($this->{$null_post} == "") {
                $this->{$null_post} = "NULL";
            } else {
                $this->{$null_post} = "'" . $this->{$null_post} . "'";
            }
        }
    }

    private function __check_array_post() {
        $post_null_check = array(
            "spt_tembusan",
            "spt_dasar",
        );

        foreach ($post_null_check as $null_post) {
            if ($this->{$null_post} == "") {
                $this->{$null_post} = NULL;
            }
        }
    }

    private function __check_numeric_post() {
        $post_numeric_check = array(
            "id_kabupaten_kota",
            "id_ref_ttd",
        );

        foreach ($post_numeric_check as $numeric_post) {
            if ($this->{$numeric_post} == NULL) {
                $this->{$numeric_post} = 0;
            }
        }
    }

    protected function after_get_data_post() {
        $this->__check_numeric_post();
        $this->__check_blank_post();
        $this->__check_array_post();
    }

    public function get_tahapan_diklat_by_id_diklat($id_diklat = FALSE) {
        if ($id_diklat) {
            
        }
        return FALSE;
    }

    public function after_show_detail($record_found = FALSE) {
        $array_check = array(
            "spt_tembusan",
            "spt_dasar",
        );

        foreach ($array_check as $array_data) {
            if ($record_found && $record_found->{$array_data} != NULL) {
                pg_array_parse($record_found->{$array_data}, $record_found->{$array_data});
            }
        }

        if ($record_found) {
            $record_found->tahapan_diklat = $this->get_tahapan_diklat_by_id_diklat($record_found->id_diklat);
        }

        return $record_found;
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