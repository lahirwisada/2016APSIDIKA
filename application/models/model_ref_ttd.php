<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/ref_ttd.php";

class model_ref_ttd extends ref_ttd {

    protected $rules = array(
        array("id_pegawai", "required|numeric"),
        array("id_skpd", "required|numeric"),
        array("jabatan_ttd", "min_length[1]|max_length[100]"),
        array("uraian_atas_ttd", "min_length[1]|max_length[100]"),
        array("uraian_bawah_ttd", "min_length[1]|max_length[100]"),
    );

    public function __construct() {
        parent::__construct();
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array(
                    "nama_depan",
                    "nama_tengah",
                    "nama_belakang",
                    "nama_sambung",
                    "nip",
                    "nama_skpd",
                    "abbr_skpd",
                    "alamat_skpd",
                    "kodepos",
                    "no_telp",
                    "email",
                    "website",
                    "jabatan_ttd",
                    "uraian_atas_ttd",
                    "uraian_bawah_ttd",
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_like($keyword = FALSE) {

        $result = FALSE;
        if ($keyword) {
            $this->db->order_by("nip", "asc");
            $where_keyword = " lower(" . $this->table_name . ".nama_depan) LIKE lower('%" . $keyword . "%') OR " .
                    "lower(" . $this->table_name . ".nama_tengah) LIKE lower('%" . $keyword . "%') OR ".
                    "lower(" . $this->table_name . ".nama_belakang) LIKE lower('%" . $keyword . "%') OR ".
                    "lower(" . $this->table_name . ".nama_sambung) LIKE lower('%" . $keyword . "%') OR ".
                    "lower(" . $this->table_name . ".nip) LIKE lower('%" . $keyword . "%') OR ".
                    "lower(" . $this->table_name . ".nama_skpd) LIKE lower('%" . $keyword . "%') OR ".
                    "lower(" . $this->table_name . ".abbr_skpd) LIKE lower('%" . $keyword . "%') OR ".
                    "lower(" . $this->table_name . ".jabatan_ttd) LIKE lower('%" . $keyword . "%')";
            $this->db->where($where_keyword, NULL, FALSE);
            $result = $this->get_where();
        }
        return $result;
    }

}

?>