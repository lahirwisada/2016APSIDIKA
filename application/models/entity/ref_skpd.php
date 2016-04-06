<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class Ref_skpd extends LWS_model {

    public function __construct() {
        parent::__construct("ref_skpd");
        $this->primary_key = "id_skpd";
    }

    protected $attribute_labels = array(
        "id_skpd"        => array("id_skpd", "Id SKPD"),
        "nama_skpd"      => array("nama_skpd", "Nama SKPD"),
        "col_order"      => array("col_order", "No. urut"),
        "created_date"    => array("created_date", "created_date"),
        "created_by"      => array("created_by", "created_by"),
        "modified_date"   => array("modified_date", "modified_date"),
        "modified_by"     => array("modified_by", "modified_by"),
        "record_active"   => array("record_active", "record_active"),
    );
    protected $rules = array(array("id_skpd", ""), array("nama_skpd", ""), array("created_date", ""), array("created_by", ""), array("modified_date", ""), array("modified_by", ""), array("record_active", ""),);
    protected $related_tables = array();
    protected $attribute_types = array();

}

?>