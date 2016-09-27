<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cdaftar_diklat extends Back_end {

    public $model = 'model_tr_diklat';

    public function __construct() {
        parent::__construct('kelola_diklat', 'Daftar Diklat');
        $this->load->model(array(
            'model_ref_kabupaten_kota',
            'model_ref_jenis_diklat',
            'model_tr_diklat_hal_perhatian',
            'model_tr_diklat_persyaratan',
            'model_tr_diklat_tahapan',
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
            "id_ref_ttd_sttpp",
            "tgl_sttpp",
            "spt_hal_perhatian",
            "spt_tahapan",
            "persyaratan_diklat",
            "kuota_diklat",
            "jumlah_waiting_list",
        ));

        $jenis_diklat = $this->model_ref_jenis_diklat->combobox(array("key" => "id_jenis_diklat", "value" => "jenis_diklat"));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Pendaftaran ' . $this->_header_title
        ));

        $this->set("cb_jenis_diklat", $jenis_diklat);
        $this->set("id_diklat", $id);

        $this->set("additional_js", array(
            "back_end/" . $this->_name . "/js/detail_js",
            "back_end/" . $this->_name . "/js/detail_tembusan_spt_js",
            "back_end/" . $this->_name . "/js/detail_tahapan_js",
            "back_end/" . $this->_name . "/js/detail_dasar_spt_js",
            "back_end/" . $this->_name . "/js/detail_isian_diklat_js",
            "back_end/" . $this->_name . "/js/detail_hal_perhatian_spt_js",
            "back_end/" . $this->_name . "/js/detail_persyaratan_diklat_js",
        ));

        $this->add_cssfiles(array("plugins/select2/select2.min.css"));
        $this->add_jsfiles(array(
            "plugins/select2/select2.full.min.js",
            "atlant/plugins/summernote/summernote.js",
        ));
    }

    public function cek_spt($md5_text = FALSE) {
        var_dump(strlen($md5_text), substr($md5_text, 32));
        exit;
    }
    
    public function cek_peserta($md5_text = FALSE) {
        var_dump(strlen($md5_text), substr($md5_text, 32));
        exit;
    }

    /**
     * using clone block bro PHPWord
     * @param type $id_diklat
     */
    public function cetak_sttpp_peserta($id_diklat = FALSE) {
        if (!$id_diklat) {
            $this->attention_messages = "Data diklat tidak ditemukan.";
            redirect('back_end/' . $this->_name);
        }

        $detail = $this->{$this->model}->show_detail($id_diklat);

        $save_document_success = FALSE;
        $output_filename = "sttpp-diklat-";

        $this->load->model("model_tr_peserta_diklat");

        $records = FALSE;
        if ($detail) {
            $id_pegawai = $this->input->get('pid');
            $records = $this->model_tr_peserta_diklat->all_without_paging($id_diklat, $id_pegawai);
        }

        if ($detail && $records) {

            $this->load->library('lwphpword', array(
                "base_path" => APPPATH . "../_assets/sttpp/",
                "base_url" => base_url() . "_assets/sttpp/",
                "base_root" => base_url(),
            ));

            $template_file = "../_assets/template/TemplateSTTPPPesertaWithQR.docx";
//            $template_file = "../_assets/template/basic.docx";


            if ($detail->id_jenis_diklat == "2") {
//                $template_file = "../_assets/template/TemplateSPT_Penjenjangan.docx";
            }

            $this->lwphpword->save_path = APPPATH . "../_assets/sttpp_save_path/";

            $r_peserta = current($records);
            /**
             * QR embed
             */
            $qr_content = base_url('front_end') . "/fdaftar_diklat/cek_peserta/" . md5(rand(2, 15)) . $detail->id_diklat . "dk" . $r_peserta->id_peserta_diklat;
            $this->load->library('lws_qr');
            $qr_png = $this->lws_qr->create($qr_content, "imgspt" . $detail->id_diklat . ".png", 2, 2, 95);
//            $this->lwphpword->set_image_value('image2.png', $qr_png);
            /**
             * END QR embed
             */
            $load_template_success = $this->lwphpword->load_template(APPPATH . $template_file, array('image1.png' => $qr_png));
            $load_template_success = 1;

            if ($load_template_success) {
                $peserta_diklat_found = count($records);

                $this->lwphpword->clone_row('no_sttpp', $peserta_diklat_found);

                foreach ($records as $key => $peserta_diklat) {
                    $template_string_nosttpp = 'no_sttpp#' . ($key + 1);
                    $template_string_postfix_no_sttpp = 'postfix_no_sttpp#' . ($key + 1);
                    $template_string_gelar_depan = 'gelar_depan#' . ($key + 1);
                    $template_string_nama_sambung = 'nama_sambung#' . ($key + 1);
                    $template_string_gelar_belakang = 'gelar_belakang#' . ($key + 1);
                    $template_string_nip = 'nip#' . ($key + 1);
                    $template_tempat_lahir = 'tempat_lahir#' . ($key + 1);
                    $template_tgl_lahir = 'tanggal_lahir#' . ($key + 1);
                    $template_pangkat = 'pangkat#' . ($key + 1);
                    $template_golongan = 'golongan#' . ($key + 1);
                    $template_jabatan = 'jabatan#' . ($key + 1);
                    $template_nama_skpd = 'nama_skpd#' . ($key + 1);
                    $template_keterangan_lulus = 'keterangan_lulus#' . ($key + 1);
                    $template_label_kualifikasi = 'label_kualifikasi#' . ($key + 1);
                    $template_tanda_baca_titik_dua = 'tanda_baca_titik_dua#' . ($key + 1);
                    $template_kualifikasi_kelulusan = 'kualifikasi_kelulusan#' . ($key + 1);
                    $template_nama_diklat = 'nama_diklat#' . ($key + 1);
                    $template_angkatan = 'angkatan#' . ($key + 1);
                    $template_tahun = 'tahun#' . ($key + 1);
                    $template_penyelenggara = 'penyelenggara#' . ($key + 1);
                    $template_tgl_pelaksanaan = 'tanggal_pelaksanaan#' . ($key + 1);
                    $template_tgl_selesai = 'tanggal_selesai#' . ($key + 1);
                    $template_alamat_lokasi = 'alamat_lokasi#' . ($key + 1);
                    $template_total_jam = 'total_jam#' . ($key + 1);
                    $template_tgl_sttpp = 'tgl_sttpp#' . ($key + 1);
                    $template_jabatan_ttd = 'jabatan_ttd#' . ($key + 1);
                    $template_uraian_atas_ttd = 'uraian_atas_ttd#' . ($key + 1);
                    $template_gelar_depan_ttd = 'gelar_depan_ttd#' . ($key + 1);
                    $template_nama_sambung_ttd = 'nama_sambung_ttd#' . ($key + 1);
                    $template_gelar_belakang_ttd = 'gelar_belakang_ttd#' . ($key + 1);
                    $template_nip_ttd = 'nip_ttd#' . ($key + 1);

                    $tgl_pelaksaan = $detail->tgl_pelaksanaan == NULL ? "-" : pg_date_to_text($detail->tgl_pelaksanaan, "d-m-Y", " ");
                    $tgl_selesai = $detail->tgl_selesai == NULL ? "-" : pg_date_to_text($detail->tgl_selesai, "d-m-Y", " ");
                    $tgl_sttpp = $detail->tgl_sttpp == NULL ? "-" : pg_date_to_text($detail->tgl_sttpp, "d-m-Y", " ");
                    $tgl_lahir = $peserta_diklat->tgl_lahir == NULL ? "-" : pg_date_to_text($peserta_diklat->tgl_lahir, "d-m-Y", " ");
                    $tahun_pelaksaan = $detail->tgl_pelaksanaan == NULL ? "-" : date('Y', strtotime($detail->tgl_pelaksanaan));
//                    $tgl_selesai_tahapan = $tahapan_diklat->tgl_selesai_tahapan == NULL ? "-" : pg_date_to_text($tahapan_diklat->tgl_selesai_tahapan, "d-m-Y", " ");
//                    $tgl_tahapan = $tgl_mulai_tahapan . " s.d.\n " . $tgl_selesai_tahapan;

                    $this->lwphpword->set_value($template_string_nosttpp, beautify_str($peserta_diklat->nomor_peserta, FALSE, "......"));
                    $this->lwphpword->set_value($template_string_postfix_no_sttpp, $detail->postfix_no_sttpp);
                    $this->lwphpword->set_value($template_string_gelar_depan, beautify_str($peserta_diklat->gelar_depan, TRUE, " "));
                    $this->lwphpword->set_value($template_string_gelar_belakang, beautify_str($peserta_diklat->gelar_belakang, TRUE, " "));
                    $this->lwphpword->set_value($template_string_nama_sambung, $peserta_diklat->nama_sambung);
                    $this->lwphpword->set_value($template_string_nip, $peserta_diklat->nip);
                    $this->lwphpword->set_value($template_tempat_lahir, beautify_str($peserta_diklat->tempat_lahir, FALSE, "-"));
                    $this->lwphpword->set_value($template_tgl_lahir, $tgl_lahir);
                    $this->lwphpword->set_value($template_pangkat, $peserta_diklat->keterangan_golongan);
                    $this->lwphpword->set_value($template_golongan, $peserta_diklat->golongan);
                    $this->lwphpword->set_value($template_jabatan, beautify_str($peserta_diklat->jabatan, FALSE, "-"));
                    $this->lwphpword->set_value($template_nama_skpd, $peserta_diklat->nama_skpd);

                    if ($detail->id_jenis_diklat == "2") {
                        $this->lwphpword->set_value($template_keterangan_lulus, "LULUS");
                        $this->lwphpword->set_value($template_label_kualifikasi, "Kualifikasi");
                        $this->lwphpword->set_value($template_tanda_baca_titik_dua, ":");
                        $this->lwphpword->set_value($template_kualifikasi_kelulusan, "Cukup Memuaskan");
                    } else {
                        $this->lwphpword->set_value($template_keterangan_lulus, "TELAH MENGIKUTI");
                        $this->lwphpword->set_value($template_label_kualifikasi, " ");
                        $this->lwphpword->set_value($template_tanda_baca_titik_dua, " ");
                        $this->lwphpword->set_value($template_kualifikasi_kelulusan, " ");
                    }

                    $this->lwphpword->set_value($template_nama_diklat, $detail->nama_diklat);
                    $this->lwphpword->set_value($template_angkatan, $detail->angkatan);
                    $this->lwphpword->set_value($template_tahun, $tahun_pelaksaan);
                    $this->lwphpword->set_value($template_tgl_pelaksanaan, $tgl_pelaksaan);
                    $this->lwphpword->set_value($template_tgl_selesai, $tgl_selesai);
                    $this->lwphpword->set_value($template_tgl_sttpp, $tgl_sttpp);
                    $this->lwphpword->set_value($template_penyelenggara, $detail->penyelenggara);
                    $this->lwphpword->set_value($template_alamat_lokasi, $detail->alamat_lokasi);
                    $this->lwphpword->set_value($template_total_jam, $detail->total_jam);
                    $this->lwphpword->set_value($template_total_jam, $detail->total_jam);
                    $this->lwphpword->set_value($template_jabatan_ttd, beautify_str($detail->jabatan_ttd_sttpp, TRUE));
                    $this->lwphpword->set_value($template_jabatan_ttd, beautify_str($detail->jabatan_ttd_sttpp, TRUE));
                    $this->lwphpword->set_value($template_uraian_atas_ttd, beautify_str($detail->uraian_bawah_ttd_sttpp, TRUE));
                    $this->lwphpword->set_value($template_gelar_depan_ttd, beautify_str($detail->gelar_depan_ttd_sttpp, TRUE));
                    $this->lwphpword->set_value($template_nama_sambung_ttd, beautify_str($detail->nama_sambung_sttpp, TRUE));
                    $this->lwphpword->set_value($template_gelar_belakang_ttd, beautify_str($detail->gelar_belakang_sttpp, TRUE));

                    $this->lwphpword->set_value($template_nip_ttd, beautify_str($detail->nip_sttpp, TRUE));
                }

                $save_document_success = $this->lwphpword->save_document();
                //$save_document_success = $this->lwphpword->save_to_pdf();
            }

//            exit;

            $attention_message = "Cetak SPT tidak dapat dilakukan.";
            if ($save_document_success) {
                $attention_message = "Cetak SPT sukses.";
                $output_filename = "STTPP-Diklat" . date('d-F-Y') . ".docx";
                //$this->lwphpword->download($save_document_success, $output_filename, 'pdf');
                $this->lwphpword->download($save_document_success, $output_filename);
            }
        }
    }

    /**
     * using clone block bro PHPWord
     * @param type $id_diklat
     */
    public function cetak_sttpp($id_diklat = FALSE) {
        if (!$id_diklat) {
            $this->attention_messages = "Data diklat tidak ditemukan.";
            redirect('back_end/' . $this->_name);
        }

        $detail = $this->{$this->model}->show_detail($id_diklat);

        $save_document_success = FALSE;
        $output_filename = "sttpp-diklat-";

        $this->load->model("model_tr_peserta_diklat");

        $records = FALSE;
        if ($detail) {
            $records = $this->model_tr_peserta_diklat->all_without_paging($id_diklat);
        }

        if ($detail && $records) {

            $this->load->library('lwphpword', array(
                "base_path" => APPPATH . "../_assets/sttpp/",
                "base_url" => base_url() . "_assets/sttpp/",
                "base_root" => base_url(),
            ));

            $template_file = "../_assets/template/TemplateSTTPP.docx";
//            $template_file = "../_assets/template/basic.docx";


            if ($detail->id_jenis_diklat == "2") {
//                $template_file = "../_assets/template/TemplateSPT_Penjenjangan.docx";
            }

            $this->lwphpword->save_path = APPPATH . "../_assets/sttpp_save_path/";

            $load_template_success = $this->lwphpword->load_template(APPPATH . $template_file);
            $load_template_success = 1;

            if ($load_template_success) {
                $peserta_diklat_found = count($records);

                $this->lwphpword->clone_row('no_sttpp', $peserta_diklat_found);

                foreach ($records as $key => $peserta_diklat) {
                    $template_string_nosttpp = 'no_sttpp#' . ($key + 1);
                    $template_string_postfix_no_sttpp = 'postfix_no_sttpp#' . ($key + 1);
                    $template_string_gelar_depan = 'gelar_depan#' . ($key + 1);
                    $template_string_nama_sambung = 'nama_sambung#' . ($key + 1);
                    $template_string_gelar_belakang = 'gelar_belakang#' . ($key + 1);
                    $template_string_nip = 'nip#' . ($key + 1);
                    $template_tempat_lahir = 'tempat_lahir#' . ($key + 1);
                    $template_tgl_lahir = 'tanggal_lahir#' . ($key + 1);
                    $template_pangkat = 'pangkat#' . ($key + 1);
                    $template_golongan = 'golongan#' . ($key + 1);
                    $template_jabatan = 'jabatan#' . ($key + 1);
                    $template_nama_skpd = 'nama_skpd#' . ($key + 1);
                    $template_keterangan_lulus = 'keterangan_lulus#' . ($key + 1);
                    $template_label_kualifikasi = 'label_kualifikasi#' . ($key + 1);
                    $template_tanda_baca_titik_dua = 'tanda_baca_titik_dua#' . ($key + 1);
                    $template_kualifikasi_kelulusan = 'kualifikasi_kelulusan#' . ($key + 1);
                    $template_nama_diklat = 'nama_diklat#' . ($key + 1);
                    $template_angkatan = 'angkatan#' . ($key + 1);
                    $template_tahun = 'tahun#' . ($key + 1);
                    $template_penyelenggara = 'penyelenggara#' . ($key + 1);
                    $template_tgl_pelaksanaan = 'tanggal_pelaksanaan#' . ($key + 1);
                    $template_tgl_selesai = 'tanggal_selesai#' . ($key + 1);
                    $template_alamat_lokasi = 'alamat_lokasi#' . ($key + 1);
                    $template_total_jam = 'total_jam#' . ($key + 1);
                    $template_tgl_sttpp = 'tgl_sttpp#' . ($key + 1);
                    $template_jabatan_ttd = 'jabatan_ttd#' . ($key + 1);
                    $template_uraian_atas_ttd = 'uraian_atas_ttd#' . ($key + 1);
                    $template_gelar_depan_ttd = 'gelar_depan_ttd#' . ($key + 1);
                    $template_nama_sambung_ttd = 'nama_sambung_ttd#' . ($key + 1);
                    $template_gelar_belakang_ttd = 'gelar_belakang_ttd#' . ($key + 1);
                    $template_nip_ttd = 'nip_ttd#' . ($key + 1);

                    $tgl_pelaksaan = $detail->tgl_pelaksanaan == NULL ? "-" : pg_date_to_text($detail->tgl_pelaksanaan, "d-m-Y", " ");
                    $tgl_selesai = $detail->tgl_selesai == NULL ? "-" : pg_date_to_text($detail->tgl_selesai, "d-m-Y", " ");
                    $tgl_sttpp = $detail->tgl_sttpp == NULL ? "-" : pg_date_to_text($detail->tgl_sttpp, "d-m-Y", " ");
                    $tgl_lahir = $peserta_diklat->tgl_lahir == NULL ? "-" : pg_date_to_text($peserta_diklat->tgl_lahir, "d-m-Y", " ");
                    $tahun_pelaksaan = $detail->tgl_pelaksanaan == NULL ? "-" : date('Y', strtotime($detail->tgl_pelaksanaan));
//                    $tgl_selesai_tahapan = $tahapan_diklat->tgl_selesai_tahapan == NULL ? "-" : pg_date_to_text($tahapan_diklat->tgl_selesai_tahapan, "d-m-Y", " ");
//                    $tgl_tahapan = $tgl_mulai_tahapan . " s.d.\n " . $tgl_selesai_tahapan;

                    $this->lwphpword->set_value($template_string_nosttpp, beautify_str($peserta_diklat->nomor_peserta, FALSE, "......"));
                    $this->lwphpword->set_value($template_string_postfix_no_sttpp, $detail->postfix_no_sttpp);
                    $this->lwphpword->set_value($template_string_gelar_depan, beautify_str($peserta_diklat->gelar_depan, TRUE, " "));
                    $this->lwphpword->set_value($template_string_gelar_belakang, beautify_str($peserta_diklat->gelar_belakang, TRUE, " "));
                    $this->lwphpword->set_value($template_string_nama_sambung, $peserta_diklat->nama_sambung);
                    $this->lwphpword->set_value($template_string_nip, $peserta_diklat->nip);
                    $this->lwphpword->set_value($template_tempat_lahir, beautify_str($peserta_diklat->tempat_lahir, FALSE, "-"));
                    $this->lwphpword->set_value($template_tgl_lahir, $tgl_lahir);
                    $this->lwphpword->set_value($template_pangkat, $peserta_diklat->keterangan_golongan);
                    $this->lwphpword->set_value($template_golongan, $peserta_diklat->golongan);
                    $this->lwphpword->set_value($template_jabatan, beautify_str($peserta_diklat->jabatan, FALSE, "-"));
                    $this->lwphpword->set_value($template_nama_skpd, $peserta_diklat->nama_skpd);

                    if ($detail->id_jenis_diklat == "2") {
                        $this->lwphpword->set_value($template_keterangan_lulus, "LULUS");
                        $this->lwphpword->set_value($template_label_kualifikasi, "Kualifikasi");
                        $this->lwphpword->set_value($template_tanda_baca_titik_dua, ":");
                        $this->lwphpword->set_value($template_kualifikasi_kelulusan, "Cukup Memuaskan");
                    } else {
                        $this->lwphpword->set_value($template_keterangan_lulus, "TELAH MENGIKUTI");
                        $this->lwphpword->set_value($template_label_kualifikasi, " ");
                        $this->lwphpword->set_value($template_tanda_baca_titik_dua, " ");
                        $this->lwphpword->set_value($template_kualifikasi_kelulusan, " ");
                    }

                    $this->lwphpword->set_value($template_nama_diklat, $detail->nama_diklat);
                    $this->lwphpword->set_value($template_angkatan, $detail->angkatan);
                    $this->lwphpword->set_value($template_tahun, $tahun_pelaksaan);
                    $this->lwphpword->set_value($template_tgl_pelaksanaan, $tgl_pelaksaan);
                    $this->lwphpword->set_value($template_tgl_selesai, $tgl_selesai);
                    $this->lwphpword->set_value($template_tgl_sttpp, $tgl_sttpp);
                    $this->lwphpword->set_value($template_penyelenggara, $detail->penyelenggara);
                    $this->lwphpword->set_value($template_alamat_lokasi, $detail->alamat_lokasi);
                    $this->lwphpword->set_value($template_total_jam, $detail->total_jam);
                    $this->lwphpword->set_value($template_total_jam, $detail->total_jam);
                    $this->lwphpword->set_value($template_jabatan_ttd, beautify_str($detail->jabatan_ttd_sttpp, TRUE));
                    $this->lwphpword->set_value($template_jabatan_ttd, beautify_str($detail->jabatan_ttd_sttpp, TRUE));
                    $this->lwphpword->set_value($template_uraian_atas_ttd, beautify_str($detail->uraian_bawah_ttd_sttpp, TRUE));
                    $this->lwphpword->set_value($template_gelar_depan_ttd, beautify_str($detail->gelar_depan_ttd_sttpp, TRUE));
                    $this->lwphpword->set_value($template_nama_sambung_ttd, beautify_str($detail->nama_sambung_sttpp, TRUE));
                    $this->lwphpword->set_value($template_gelar_belakang_ttd, beautify_str($detail->gelar_belakang_sttpp, TRUE));

                    $this->lwphpword->set_value($template_nip_ttd, beautify_str($detail->nip_sttpp, TRUE));
                }

                $save_document_success = $this->lwphpword->save_document();
                //$save_document_success = $this->lwphpword->save_to_pdf();
            }

//            exit;

            $attention_message = "Cetak SPT tidak dapat dilakukan.";
            if ($save_document_success) {
                $attention_message = "Cetak SPT sukses.";
                $output_filename = "STTPP-Diklat" . date('d-F-Y') . ".docx";
                //$this->lwphpword->download($save_document_success, $output_filename, 'pdf');
                $this->lwphpword->download($save_document_success, $output_filename);
            }
        }
    }

    public function cetak_spt($id_diklat = FALSE) {

        if (!$id_diklat) {
            $this->attention_messages = "Data diklat tidak ditemukan.";
            redirect('back_end/' . $this->_name);
        }

        $detail = $this->{$this->model}->show_detail($id_diklat);
//        var_dump($detail);
//        exit;
        $save_document_success = FALSE;
        $output_filename = "spt-diklat-";

        if ($detail) {

            $records = FALSE;
            if ($detail) {
                $this->load->model('model_tr_peserta_diklat');
                $records = $this->model_tr_peserta_diklat->all_without_paging($id_diklat);
            }

            $this->load->library('lwphpword', array(
                "base_path" => APPPATH . "../_assets/spt/",
                "base_url" => base_url() . "_assets/spt/",
                "base_root" => base_url(),
            ));

            $template_file = "../_assets/template/TemplateSPTWithQR.docx";
            if ($detail->id_jenis_diklat == "2") {
                $template_file = "../_assets/template/TemplateSPT_PenjenjanganWithQR.docx";
//                $template_file = "../_assets/template/TemplateSPT_Penjenjangan.docx";
            }

            $this->lwphpword->save_path = APPPATH . "../_assets/spt_save_path/";


            /**
             * QR embed
             */
            $qr_content = base_url('front_end') . "/fdaftar_diklat/cek_spt/" . md5(rand(2, 15)) . $detail->id_diklat;
            $this->load->library('lws_qr');
            $qr_png = $this->lws_qr->create($qr_content, "imgspt" . $detail->id_diklat . ".png", 2, 2, 95);
//            $this->lwphpword->set_image_value('image2.png', $qr_png);
            /**
             * END QR embed
             */
            $load_template_success = $this->lwphpword->load_template(APPPATH . $template_file, array('image2.png' => $qr_png));
            if ($load_template_success) {
                $this->lwphpword->set_value('nama_skpd', strtoupper(beautify_str($detail->nama_skpd, TRUE, " ")));
                $this->lwphpword->set_value('alamat_skpd', beautify_str($detail->alamat_skpd, TRUE, " "));
                $this->lwphpword->set_value('no_telp', $detail->no_telp == "" ? " " : $detail->no_telp);
                $this->lwphpword->set_value('jabatan_ttd', beautify_str($detail->jabatan_ttd, TRUE, " "));
                $this->lwphpword->set_value('spt_kepada', beautify_str($detail->spt_kepada, TRUE, " "));
                $this->lwphpword->set_value('nama_diklat', beautify_str($detail->nama_diklat, TRUE, " "));
                $this->lwphpword->set_value('penyelenggara', beautify_str($detail->penyelenggara, TRUE, " "));
                $this->lwphpword->set_value('alamat_lokasi', beautify_str($detail->alamat_lokasi, TRUE, " "));
                $this->lwphpword->set_value('tgl_pelaksanaan', $detail->tgl_pelaksanaan == NULL ? " " : pg_date_to_text($detail->tgl_pelaksanaan, "d-m-Y", " "));
                $this->lwphpword->set_value('tgl_selesai', $detail->tgl_selesai == NULL ? " " : pg_date_to_text($detail->tgl_selesai, "d-m-Y", " "));
                $this->lwphpword->set_value('tgl_spt', $detail->tgl_spt == NULL ? " " : pg_date_to_text($detail->tgl_spt, "d-m-Y", " "));
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
                        $template_string = 'spt_tembusan_item#' . $i;
                        $this->lwphpword->set_value($template_string, $i . ". " . beautify_str($tembusan));
                    }
                } else {
                    $this->lwphpword->set_value("spt_tembusan_item", " ");
                }

                if ($detail->spt_dasar != NULL && is_array($detail->spt_dasar)) {
                    $this->lwphpword->clone_row('spt_dasar_item', count($detail->spt_dasar));
                    foreach ($detail->spt_dasar as $key => $dasar) {
                        $i = $key + 1;
                        $template_string = 'spt_dasar_item#' . $i;
                        $this->lwphpword->set_value($template_string, $i . ". " . beautify_str($dasar));
                    }
                } else {
                    $this->lwphpword->set_value("spt_dasar_item", " ");
                }

                $i = 0;

                if ($detail->id_jenis_diklat == "2") {
                    $i = 1;
                    if ($detail->tahapan_diklat) {
                        $this->lwphpword->clone_row('ntd', count($detail->tahapan_diklat));

                        foreach ($detail->tahapan_diklat as $key => $tahapan_diklat) {
                            $template_string_number = 'ntd#' . ($key + 1);
                            $template_string_tahapan = 'tahapan#' . ($key + 1);
                            $template_string_tgl_tahapan = 'tgl_tahapan#' . ($key + 1);
                            $template_string_keterangan_tahapan = 'keterangan_tahapan#' . ($key + 1);

                            $tgl_mulai_tahapan = $tahapan_diklat->tgl_mulai_tahapan == NULL ? "-" : pg_date_to_text($tahapan_diklat->tgl_mulai_tahapan, "d-m-Y", " ");
                            $tgl_selesai_tahapan = $tahapan_diklat->tgl_selesai_tahapan == NULL ? "-" : pg_date_to_text($tahapan_diklat->tgl_selesai_tahapan, "d-m-Y", " ");
                            $tgl_tahapan = $tgl_mulai_tahapan . " s.d.\n " . $tgl_selesai_tahapan;

                            $this->lwphpword->set_value($template_string_number, ($key + 1) . ".");
                            $this->lwphpword->set_value($template_string_tahapan, $tahapan_diklat->tahapan);
                            $this->lwphpword->set_value($template_string_tgl_tahapan, $tgl_tahapan);
                            $this->lwphpword->set_value($template_string_keterangan_tahapan, $tahapan_diklat->keterangan_tahapan);
                        }
                    } else {
                        $this->lwphpword->set_value("ntd", " ");
                        $this->lwphpword->set_value("tahapan", " ");
                        $this->lwphpword->set_value("tgl_tahapan", " ");
                        $this->lwphpword->set_value("keterangan_tahapan", " ");
                    }
                }

                if ($detail->hal_perhatian) {
                    $this->lwphpword->clone_row('hal_perhatian', count($detail->hal_perhatian));
//                    $this->lwphpword->clone_row('uraian_hal_perhatian', count($detail->hal_perhatian));


                    $isub = 0;
                    $isubsub = 0;
                    $template_row_count = 0;
                    foreach ($detail->hal_perhatian as $key => $hal_perhatian) {
                        $template_row_count ++;

                        $template_string = 'hal_perhatian#' . $template_row_count;
                        $text_hal_perhatian = "";
                        if ($hal_perhatian->level == 1) {
                            $isub = 0;
                            $isubsub = 0;
                            $i++;
                            $text_hal_perhatian = $i . ". " . $hal_perhatian->uraian;
                        }

                        if ($hal_perhatian->level == 2) {
                            $isubsub = 0;
                            $isub++;

                            $text_hal_perhatian = "\t" . $i . "." . $isub . ". " . $hal_perhatian->uraian;
                        }

                        if ($hal_perhatian->level == 3) {
                            $isubsub++;

                            $text_hal_perhatian = "\t\t" . $i . "." . $isub . "." . $isubsub . ". " . $hal_perhatian->uraian;
                        }

                        $this->lwphpword->set_value($template_string, $text_hal_perhatian);
                    }
                } else {
                    $this->lwphpword->set_value("hal_perhatian", " ");
                }

                $no_spt_lengkap = array();

                if ($detail->no_spt_a != "") {
                    $no_spt_lengkap[] = $detail->no_spt_a;
                } else {
                    $no_spt_lengkap[] = "....";
                }

                if ($detail->no_spt_b != "") {
                    $no_spt_lengkap[] = "/" . $detail->no_spt_b;
                } else {
                    $no_spt_lengkap[] = "/....";
                }

                if ($detail->no_spt_c != "") {
                    $no_spt_lengkap[] = " - " . $detail->no_spt_c;
                } else {
                    $no_spt_lengkap[] = " - ....";
                }

                if ($detail->no_spt_d != "") {
                    $no_spt_lengkap[] = "/" . $detail->no_spt_d;
                } else {
                    $no_spt_lengkap[] = "";
                }

                if ($records) {
                    $this->lwphpword->clone_row('nopeg', count($records));

                    foreach ($records as $key => $record_peg) {

                        $template_string_number_peg = 'nopeg#' . ($key + 1);
                        $template_string_nama_sambung_peg = 'nama_sambung_peg#' . ($key + 1);
                        $template_string_nip_peg = 'nip_peg#' . ($key + 1);
                        $template_string_keterangan_golongan_peg = 'keterangan_golongan_peg#' . ($key + 1);
                        $template_string_golongan_peg = 'golongan_peg#' . ($key + 1);
                        $template_string_jabatan_peg = 'jabatan_peg#' . ($key + 1);

                        $peg_gol = beautify_str($record_peg->golongan, TRUE);
                        if (trim($peg_gol) !== "") {
                            $peg_gol = "(" . $peg_gol . ")";
                        }

                        $this->lwphpword->set_value($template_string_number_peg, ($key + 1) . ".");
                        $this->lwphpword->set_value($template_string_nama_sambung_peg, beautify_str($record_peg->nama_sambung, TRUE));
                        $this->lwphpword->set_value($template_string_nip_peg, beautify_str($record_peg->nip, TRUE));
                        $this->lwphpword->set_value($template_string_keterangan_golongan_peg, beautify_str($record_peg->keterangan_golongan, TRUE));
                        $this->lwphpword->set_value($template_string_golongan_peg, $peg_gol);
                        $this->lwphpword->set_value($template_string_jabatan_peg, beautify_str($record_peg->jabatan, TRUE));
                    }
                }

                $this->lwphpword->set_value("nomor_spt_lengkap", implode("", $no_spt_lengkap));

                $save_document_success = $this->lwphpword->save_document();
                //$save_document_success = $this->lwphpword->save_to_pdf();
            }

//            exit;

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