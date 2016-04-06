<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/ref_skpd.php";

class model_ref_skpd extends ref_skpd {

    protected $rules = array(
        array("nama_skpd", "required|min_length[2]|max_length[300]"),
        array("col_order", "numeric"),
    );

    public function __construct() {
        parent::__construct();
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        $this->db->order_by("col_order", "asc");
        return parent::get_all(array(
                    "nama_skpd",
                    "col_order",
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }
}

?>