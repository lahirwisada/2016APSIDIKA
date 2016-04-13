<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/ref_pegawai.php";

class model_ref_pegawai extends ref_pegawai {

    protected $rules = array(
        array("id_pegawai_skpd", ""),
        array("id_status_perkawinan", ""),
        array("gelar_depan", "max_length[20]|alpha_dash"),
        array("gelar_belakang", "max_length[100]|alpha_dash"),
        array("nama_depan", "required|max_length[60]|alpha_dash"),
        array("nama_tengah", "max_length[60]|alpha_dash"),
        array("nama_belakang", "max_length[60]|alpha_dash"),
        array("nama_sambung", "required|min_length[2]|max_length[200]|alpha_dash"),
        array("tgl_lahir", ""),
        array("tempat_lahir", "max_length[200]"),
        array("nip", "max_length[60]"),
        array("no_kep", "max_length[200]"),
        array("tmt_peg", ""),
    );

    public function __construct() {
        parent::__construct();
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array(
                    "gelar_depan",
                    "gelar_belakang",
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    private function __where_id_skpd($id_skpd = FALSE) {
        if ($id_skpd) {
            $table_pegawai_skpd = $this->get_schema_name("tr_pegawai_skpd");
            $this->db->where($table_pegawai_skpd . ".id_skpd = '" . $id_skpd . "'  ");
        }
    }

    private function __select_tr_pegawai_active_skpd() {
        $this->__join_tr_pegawai_active_skpd();
    }

    /**
     * don't use this, you should use __join_tr_pegawai_active_skpd
     * 
     * @author Lahir Wisada <lahirwisada@gmail.com>
     * @see __join_tr_pegawai_active_skpd()
     */
    private function __join_tr_pegawai_skpd_ref_skpd($table_pegawai_skpd) {
        $table_skpd = $this->get_schema_name("ref_skpd");
        $this->db->join($table_skpd, $table_skpd . ".id_skpd = " . $table_pegawai_skpd . ".id_skpd");

        $this->db->select(
                $table_skpd . ".id_skpd, " .
                $table_skpd . ".nama_skpd, " .
                $table_skpd . ".abbr_skpd, " .
                $table_skpd . ".alamat_skpd, " .
                $table_skpd . ".kodepos, " .
                $table_skpd . ".no_telp, " .
                $table_skpd . ".email as email_skpd, " .
                $table_skpd . ".website as website_skpd ", FALSE
        );
    }

    private function __join_tr_pegawai_active_skpd() {
        $table_pegawai_skpd = $this->get_schema_name("tr_pegawai_skpd");
        $this->db->join($table_pegawai_skpd, $table_pegawai_skpd . ".id_pegawai = " . $this->table_name . ".id_pegawai AND " . $table_pegawai_skpd . ".is_active = '1'", "LEFT");
        $this->__join_tr_pegawai_skpd_ref_skpd($table_pegawai_skpd);
    }

    public function get_like($keyword = FALSE, $id_skpd = FALSE) {
        $result = FALSE;
        if ($keyword) {

            $id_skpd = $id_skpd == 'false' ? FALSE : $id_skpd;
            $this->__where_id_skpd($id_skpd);
            $this->__select_tr_pegawai_active_skpd();
            $this->select_field();

            $this->db->order_by("nip", "asc");
            $where_keyword = " ( lower(" . $this->table_name . ".nama_depan) LIKE lower('%" . $keyword . "%') OR " .
                    "lower(" . $this->table_name . ".nama_tengah) LIKE lower('%" . $keyword . "%') OR " .
                    "lower(" . $this->table_name . ".nama_belakang) LIKE lower('%" . $keyword . "%') OR " .
                    "lower(" . $this->table_name . ".nama_sambung) LIKE lower('%" . $keyword . "%') OR " .
                    "lower(" . $this->table_name . ".nip) LIKE lower('%" . $keyword . "%') ) ";
            $this->db->where($where_keyword, NULL, FALSE);
            $result = $this->get_where();
        }
        return $result;
    }

}

?>