<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/tr_diklat_hal_perhatian.php";

class model_tr_diklat_hal_perhatian extends tr_diklat_hal_perhatian {

    protected $rules = array(
        array("level", "numeric"),
        array("uraian", ""),
        array("id_diklat", "numeric"),
    );

    public function __construct() {
        parent::__construct();
    }

    public function remove_by_id_diklat($id_diklat = FALSE) {
        if ($id_diklat) {
            return $this->remove_by_foreign_key($id_diklat, $this->table_name . ".id_diklat");
        }
        return FALSE;
    }

    public function save_collection($set_data = FALSE, $id_diklat = FALSE) {
        if ($set_data && $id_diklat) {
            $this->remove_by_id_diklat($id_diklat);
            foreach ($set_data as $key => $row_data) {
                if ($this->set_attribute_data($row_data, $id_diklat)) {
                    $this->save();
                }
            }
        }
        return FALSE;
    }

    public function set_attribute_data($row_data = FALSE, $id_diklat = FALSE) {
        if ($row_data && $id_diklat) {

            if (is_object($row_data)) {
                $row_data = (array) $row_data;
            }

            $this->level = $row_data["level"];
            $this->uraian = $row_data["uraian"];
            $this->id_diklat = $id_diklat;
            return TRUE;
        }
        return FALSE;
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        $this->db->order_by("col_order", "asc");
        return parent::get_all(array(
                    "level",
                    "uraian",
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

}

?>