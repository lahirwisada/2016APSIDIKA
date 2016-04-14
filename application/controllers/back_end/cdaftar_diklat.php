<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once "cpustaka_data.php";

class Cdaftar_diklat extends Cpustaka_data {

    public $model = 'model_tr_diklat';

    public function __construct() {
        parent::__construct('kelola_diklat', 'Daftar Diklat');
        $this->load->model(array(
            'model_ref_kabupaten_kota',
            'model_ref_jenis_diklat',
        ));
    }

    public function index() {
        parent::index();

        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function detail($id = FALSE) {

        parent::detail($id, array(
            "id_kabupaten_kota",
            "id_jenis_diklat",
            "nama_diklat",
            "angkatan",
            "alamat_lokasi",
            "penyelenggara",
            "tgl_pelaksanaan",
            "tgl_selesai",
            "total_jam",
            "postfix_no_sttpp",
            "no_spt_a",
            "no_spt_b",
            "no_spt_c",
            "no_spt_d",
            "tgl_spt",
            "spt_tembusan",
            "spt_dasar",
            "spt_kepada",
            "id_ref_ttd",
        ));

        $jenis_diklat = $this->model_ref_jenis_diklat->combobox(array("key" => "id_jenis_diklat", "value" => "jenis_diklat"));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Pendaftaran ' . $this->_header_title
        ));

        $this->set("cb_jenis_diklat", $jenis_diklat);

        $this->set("additional_js", array(
            "back_end/" . $this->_name . "/js/detail_js",
            "back_end/" . $this->_name . "/js/detail_tembusan_spt_js",
            "back_end/" . $this->_name . "/js/detail_dasar_spt_js",
            "back_end/" . $this->_name . "/js/detail_isian_diklat_js"
        ));

        $this->add_cssfiles(array("plugins/select2/select2.min.css"));
        $this->add_jsfiles(array("plugins/select2/select2.full.min.js"));
    }

    public function cetak_spt($id_diklat = FALSE) {

        if (!$id_diklat) {
            $this->attention_messages = "Data diklat tidak ditemukan.";
            redirect('back_end/' . $this->_name);
        }

        $detail = $this->{$this->model}->show_detail($id_diklat);

        $save_document_success = FALSE;
        $output_filename = "spt-diklat-";

        if ($detail) {

            $this->load->library('lwphpword', array(
                "base_path" => APPPATH . "../_assets/spt/",
                "base_url" => base_url() . "_assets/spt/",
                "base_root" => base_url(),
            ));

            $this->lwphpword->save_path = APPPATH . "../_assets/bukti_pembayaran/";

            $load_template_success = $this->lwphpword->load_template(APPPATH . "../_assets/template/TemplateSPT.docx");
            if ($load_template_success) {
                $this->lwphpword->set_value('nama_skpd', strtoupper(beautify_str($detail->nama_skpd, TRUE, " ")));
                $this->lwphpword->set_value('alamat_skpd', beautify_str($detail->alamat_skpd, TRUE, " "));
                $this->lwphpword->set_value('no_telp', $detail->no_telp == "" ? " " : $detail->no_telp);
                $this->lwphpword->set_value('jabatan_ttd', beautify_str($detail->jabatan_ttd, TRUE, " "));
                $this->lwphpword->set_value('spt_kepada', beautify_str($detail->spt_kepada, TRUE, " "));
                $this->lwphpword->set_value('nama_diklat', beautify_str($detail->nama_diklat, TRUE, " "));
                $this->lwphpword->set_value('penyelenggara', beautify_str($detail->penyelenggara, TRUE, " "));
                $this->lwphpword->set_value('alamat_lokasi', beautify_str($detail->alamat_lokasi, TRUE, " "));
                $this->lwphpword->set_value('tgl_pelaksanaan', pg_date_to_text($detail->tgl_pelaksanaan));
                $this->lwphpword->set_value('tgl_selesai', pg_date_to_text($detail->tgl_selesai));
                $this->lwphpword->set_value('tgl_spt', $detail->tgl_spt == NULL ? " " : pg_date_to_text($detail->tgl_spt));
                $this->lwphpword->set_value('uraian_atas_ttd', beautify_str($detail->uraian_atas_ttd, TRUE, " "));
                $this->lwphpword->set_value('gelar_depan', beautify_str($detail->gelar_depan, TRUE, " "));
                $this->lwphpword->set_value('nama_sambung', beautify_str($detail->nama_sambung, TRUE, " "));
                $this->lwphpword->set_value('gelar_belakang', beautify_str($detail->gelar_belakang, TRUE, " "));
                $this->lwphpword->set_value('nip', beautify_str($detail->nip, TRUE, " "));
                $this->lwphpword->set_value('keterangan', beautify_str($detail->keterangan, TRUE, " "));                

                if ($detail->spt_tembusan != NULL && is_array($detail->spt_tembusan)) {
                    $this->lwphpword->clone_row('spt_tembusan_item', count($detail->spt_tembusan));
                    foreach ($detail->spt_tembusan as $key => $tembusan) {
                        $i = $key + 1;
                        $template_string = 'spt_tembusan_item#'.$i;
                        $this->lwphpword->set_value($template_string, $i.". ".beautify_str($tembusan));
                    }
                }else{
                    $this->lwphpword->set_value("spt_tembusan_item", " ");
                }

                if ($detail->spt_dasar != NULL && is_array($detail->spt_dasar)) {
                    $this->lwphpword->clone_row('spt_dasar_item', count($detail->spt_dasar));
                    foreach ($detail->spt_dasar as $key => $dasar) {
                        $i = $key + 1;
                        $template_string = 'spt_dasar_item#'.$i;
                        $this->lwphpword->set_value($template_string, $i.". ".beautify_str($dasar));
                    }
                }else{
                    $this->lwphpword->set_value("spt_dasar_item", " ");
                }
                
                $no_spt_lengkap = array();
                
                if($detail->no_spt_a != ""){
                    $no_spt_lengkap[] = $detail->no_spt_a;
                }else{
                    $no_spt_lengkap[] = "....";
                }
                
                if($detail->no_spt_b != ""){
                    $no_spt_lengkap[] = "/".$detail->no_spt_b;
                }else{
                    $no_spt_lengkap[] = "/....";
                }
                
                if($detail->no_spt_c != ""){
                    $no_spt_lengkap[] = " - ".$detail->no_spt_c;
                }else{
                    $no_spt_lengkap[] = " - ....";
                }
                
                if($detail->no_spt_d != ""){
                    $no_spt_lengkap[] = "/".$detail->no_spt_d;
                }else{
                    $no_spt_lengkap[] = "/....";
                }
                
                $this->lwphpword->set_value("nomor_spt_lengkap", implode("", $no_spt_lengkap));

                $save_document_success = $this->lwphpword->save_document();
                //$save_document_success = $this->lwphpword->save_to_pdf();
            }

            $attention_message = "Cetak SPT tidak dapat dilakukan.";
            if ($save_document_success) {
                $attention_message = "Cetak SPT sukses.";
                $output_filename = "SPT-Diklat" . date('d-F-Y') . ".docx";
                //$this->lwphpword->download($save_document_success, $output_filename, 'pdf');
                $this->lwphpword->download($save_document_success, $output_filename);
            }
        }

        if (!$save_document_success) {
            $this->store_attention_message_to_session($attention_message);
            redirect('back_end/' . $this->_name);
        }
    }

}

?>