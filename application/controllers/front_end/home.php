<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends Front_end {

    public function __construct() {
        parent::__construct('lobi_sidika_front_end', 'Lobi Si Dika');
//        $this->load->model(array("model_ref_petak","model_ref_gambar_petak"));
//        $this->_layout = "backend";
    }

    public function index() {
        $this->add_jsfiles(array("atlant/plugins/datatables/jquery.dataTables.min.js"));
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */