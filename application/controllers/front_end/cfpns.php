<?php

/**
 * Description of cfpns
 *
 * @author nurfadillah
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class cfpns extends Front_end {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 04 OKTOBER 2016
     * Kantin BKPP
     * 
     * detail pegawai akan dicari kembali berdasarkan nip.
     * karena tidak mungkin mencari id crypt pegawai pada API bidang data
     * 
     * untuk saat ini (tanggal 04 OKTOBER 2016) pencarian dilakukan dengan dengan
     * cara mencari pada tabel ref_pegawai berdasarkan nip yang tercatat pada session
     * 
     * @author Lahir Wisada <lahirwisada@gmail.com>
     * @todo melakukan pencarian NIP kepada API bidang data
     */
    public function index() {
        $is_authenticated = $this->lmanuser->is_front_end_authenticated();
        $sess_detail = FALSE;
        
        $user_detail = $this->get_user_detail_from_session_and_db();

        $this->set("additional_js", array(
            "front_end/" . $this->_name . "/js/index_js",
        ));

        $this->set("is_authenticated", $is_authenticated);
        $this->set("user_detail", $user_detail);
        $this->set("sess_detail", $sess_detail);
    }

    public function login() {
        parent::login();
    }

}
