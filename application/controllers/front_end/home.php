<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends Front_end {

    public function __construct() {
        
        parent::__construct();
//        $this->load->model(array("model_ref_petak","model_ref_gambar_petak"));
//        $this->_layout = "backend";
    }

    public function index() {
echo "Sorry, login first";exit;
//        $this->model_ref_petak->change_offset_param("currpage_display_petak");
//        $records = $this->model_ref_petak->all_with_thumbanil();
//        $paging_set = $this->get_paging($this->get_current_location(), $records->record_found, $this->default_limit_paging, "display_petak");
//        $this->set("records", $records->record_set);
//        $this->set("keyword", $records->keyword);
//        $this->set("field_id", $this->model_ref_petak->primary_key);
//        $this->set("paging_set", $paging_set);
//        $this->set("next_list_number", $this->model_ref_petak->get_next_record_number_list());
//
//        /** set javascript */
//        $this->set("additional_css", "front_end/home/css/index_css");
//        $this->set("additional_js", "front_end/home/js/index_js");
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>