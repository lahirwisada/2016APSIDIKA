<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/tr_diklat_tahapan.php";

class model_tr_diklat_tahapan extends tr_diklat_tahapan {

    protected $rules = array(
        array("tahapan", "min_length[2]|max_length[300]"),
        array("tgl_mulai_tahapan", ""),
        array("tgl_selesai_tahapan", ""),
        array("keterangan", ""),
        array("id_diklat", "numeric"),
    );

    public function __construct() {
        parent::__construct();
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        $this->db->order_by("col_order", "asc");
        return parent::get_all(array(
                    "tahapan",
                    "tgl_mulai_tahapan",
                    "tgl_selesai_tahapan",
                    "keterangan",
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }
}

?>