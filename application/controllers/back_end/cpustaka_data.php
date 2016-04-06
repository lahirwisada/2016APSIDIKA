<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cpustaka_data extends Back_end {

    protected $_header_title = '';
    
    protected $cmodul_name = '';
    public $model = '';
    
    public function __construct($cmodul_name=FALSE, $header_title=FALSE) {
        
        if($this->model == '' || !$cmodul_name || !$header_title){
            show_404();
        }
        
        $this->cmodul_name = $cmodul_name;
        $this->_header_title = $header_title;
        
        $this->set("header_title", $this->_header_title);
        
        parent::__construct();
        
        $this->load->model($this->model);
    }

    public function index() {
        $this->get_attention_message_from_session();
        $this->{$this->model}->change_offset_param("currpage_".$this->cmodul_name);
        $records = $this->{$this->model}->all();
        
        $paging_set = $this->get_paging($this->get_current_location(), $records->record_found, $this->default_limit_paging, $this->cmodul_name);
        $this->set('records', $records->record_set);
        $this->set("keyword", $records->keyword);
        $this->set('field_id', $this->{$this->model}->primary_key);
        $this->set("paging_set", $paging_set);
        
        
        $this->set("additional_js", "back_end/".$this->_name."/js/index_js");
        
//        $this->set("bread_crumb", array(
//            "#" => 'Jenis Diklat'
//        ));
        
        $this->set("next_list_number", $this->{$this->model}->get_next_record_number_list());
    }

    protected function detail($id = FALSE, $posted_data = array()) {
        if ($this->{$this->model}->get_data_post(FALSE, $posted_data)) {
            if ($this->{$this->model}->is_valid()) {

                $saved_id = $this->{$this->model}->save($id);

                if (!$id) {
                    $id = $saved_id;
                }

                $this->attention_messages = "Data baru telah disimpan.";
                if ($id) {
                    $this->attention_messages = "Perubahan telah disimpan.";
                }
                redirect('back_end/'.$this->_name);
            } else {
                $this->attention_messages = $this->{$this->model}->errors->get_html_errors("<br />", "line-wrap");
            }
        }

        $detail = $this->{$this->model}->show_detail($id);

        $this->set("detail", $detail);
        
//        $this->set("bread_crumb", array(
//            "back_end/cjenis_diklat" => 'Jenis Diklat',
//            "#" => 'Pendaftaran Jenis Diklat'
//        ));
        
        
//        $this->add_jsfiles(array("avant/plugins/form-jasnyupload/fileinput.min.js"));
    }

    public function delete($id = FALSE) {
        if ($id) {
            $this->{$this->model}->set_non_active($id);
            $this->store_attention_message_to_session("Data berhasil dihapus.");
        } else {
            $this->store_attention_message_to_session("Data tidak ditemukan.");
        }
        redirect($this->my_location . $this->_name."/index/");
    }

}

?>