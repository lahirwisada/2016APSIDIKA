<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* custom setting */

$config['appname'] = 'Si Dika';
$config['copyright'] = 'Copyright &copy; 2016,.';


$config['hashed'] = 'VFUUl2rWS6I5EdSFU2JJyQ==';

$config['appkey'] = '1029384756';

$config['appsalt'] = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

$config['lmanuser.usingbackendfrontend'] = TRUE;
$config['user_id_column_name'] = "id_user";
$config['profil_id_column_name'] = "id_profil";

/**
 * tabel profil lain yang digunakan selain backbone_profil
 */
$config['another_profil_tablename'] = "sc_sidika.tr_pegawai_profil";
$config['another_profil_properties']['partial_form_view'] = "back_bone/member/atlant/tr_pegawai_profil";
$config['another_profil_properties']['form_config'] = array(
    "using_select2" => TRUE,
    "input_name" => "id_pegawai",
    "input_type" => "select",
    "additional_js" => array(
        "back_bone/member/atlant/js/tr_pegawai_profil_js",
    ),
    "add_cssfiles" => array("plugins/select2/select2.min.css"),
    "add_jsfiles" => array(
        "plugins/select2/select2.full.min.js",
        "atlant/plugins/summernote/summernote.js",
    ),
);
$config['another_profil_properties']['foreign_key'] = "id_profil";
$config['another_profil_properties']['foreign_key_to_another_profile'] = "id_pegawai";
$config['another_profil_properties']['columns'] = array();
$config['another_profil_properties']['related_tables'] = array(
    "sc_sidika.ref_pegawai" => array(
        "fkey" => "id_pegawai",
        "reference_to" => "sc_sidika.tr_pegawai_profil",
        "columns" => array(
            "gelar_depan",
            "gelar_belakang",
            "nama_depan",
            "nama_tengah",
            "nama_belakang",
            "nama_sambung",
            "tgl_lahir",
            "tempat_lahir",
            "nip",
            "no_kep",
            "tmt_peg",
            "foto_profil",
            "id_pegawai_crypted",
            "npwp",
            "id_user",
        ),
        "referenced" => "LEFT"
    ),
    "sc_sidika.ref_status_perkawinan" => array(
        "fkey" => "id_status_perkawinan",
        "reference_to" => "sc_sidika.ref_pegawai",
        "columns" => array(
            "id_status_perkawinan",
            "status_perkawinan",
            "kode_status_perkawinan",
        ),
        "referenced" => "LEFT"
    ),
    "sc_sidika.tr_pegawai_skpd" => array(
        "fkey" => "id_pegawai",
        "table_alias" => "trpegskpd",
        "reference_to" => "sc_sidika.ref_pegawai",
        "columns" => array(
            "id_pegawai_skpd",
            array("tgl_mulai", "tgl_mulai_peg_skpd"),
            array("tgl_berakhir", "tgl_berakhir_peg_skpd"),
            array("keterangan", "keterangan_peg_skpd"),
        ),
        "conditions" => array(
            "is_active = '1'",
            "record_active = '1'",
        ),
        "referenced" => "LEFT"
    ),
    "sc_sidika.ref_skpd" => array(
        "fkey" => "id_skpd",
        "reference_to" => "trpegskpd",
        "columns" => array(
            "id_skpd",
            "nama_skpd",
            "abbr_skpd",
            "alamat_skpd",
            "kodepos",
            "no_telp",
            "email",
            "website",
        ),
        "referenced" => "LEFT"
    ),
    "sc_sidika.tr_pegawai_skpd_jabatan" => array(
        "fkey" => "id_pegawai_skpd",
        "table_alias" => "trpegskpdjab",
        "reference_to" => "trpegskpd",
        "columns" => array(
            "id_pegawai_skpd_jabatan",
            "masa_kerja_jabatan_bulan",
            "masa_kerja_jabatan_tahun",
            "tmt_eselon",
        ),
        "conditions" => array(
            "is_active = '1'",
            "record_active = '1'",
        ),
        "referenced" => "LEFT"
    ),
    "sc_sidika.ref_jabatan" => array(
        "fkey" => "id_jabatan",
        "table_alias" => "trjab",
        "reference_to" => "trpegskpdjab",
        "columns" => array(
            "id_jabatan",
            "jabatan",
        ),
        "referenced" => "LEFT"
    ),
    "sc_sidika.tr_pegawai_golongan" => array(
        "fkey" => "id_pegawai",
        "table_alias" => "trpeggol",
        "reference_to" => "sc_sidika.ref_pegawai",
        "columns" => array(
            "id_pegawai_golongan",
            "tgl_ditetapkan",
            "tgl_berakhir",
        ),
        "conditions" => array(
            "is_active = '1'",
            "record_active = '1'",
        ),
        "referenced" => "LEFT"
    ),
    "sc_sidika.ref_golongan" => array(
        "fkey" => "id_golongan",
        "table_alias" => "trgol",
        "reference_to" => "trpeggol",
        "columns" => array(
            "id_golongan",
            "kode_golongan",
            array("keterangan", "keterangan_golongan"),
            "golongan",
        ),
        "referenced" => "LEFT"
    ),
);

$config['backend_login_uri'] = 'back_bone/login';

$config['application_upload_location'] = '_assets/uploads/';

$config['application_active_layout'] = 'atlant';

/**
 * ini digunakan untuk memberikan nama schema
 * ketika menggunakan basis data postgres
 */
$config['application_db_schema_name'] = 'sc_sidika';

/** ini digunakan ketika aplikasi telah diupload ke hosting */
$config['application_path_location'] = '/home/ikatifau/public_html/';

$config['front_end_css_files'] = array("bootstrap/bootstrap.css", "bootstrap/bootstrap-theme.css");

$config['paging_using_template_name'] = TRUE;


$config["pdf_paper_size"] = 'A5';
$config["pdf_paper_orientation"] = 'L';


/**
 * core/LW_Model.php
 * 
 */
$config['using_insert_and_update_properties'] = TRUE;

$config['created_date'] = 'created_date';
$config['modified_date'] = 'modified_date';
$config['created_by'] = 'created_by';
$config['modified_by'] = 'modified_by';
$config['record_active'] = 'record_active';

$config['default_limit_row'] = 20;
$config['limit_key_param'] = 'limit';
$config['offset_key_param'] = 'offset';
$config['keyword_key_param'] = 'keyword';

/**
 * modul configuration
 * array("nama_modul"=>array("nama_aksi"=>array("nama_aksi_dikontroller")))
 */
$config['modul_action_configuration'] = array(
    "cdaftar_diklat" => array(
        "insert" => array("cetak_sttpp", "cetak_sttpp_peserta", "cetak_spt", "detail"),
        "update" => array("detail"),
        "delete" => array("delete"),
        "read" => array("index", "cek_spt"),
    ),
    "cpeserta_diklat" => array(
        "insert" => array("upload", "read_and_save_excel_content", "detail"),
        "update" => array("detail", "read_and_save_excel_content", "upload"),
        "delete" => array("delete"),
        "read" => array("index", "get_like"),
    ),
    "cref_pegawai" => array(
        "insert" => array("detail", "history_detail"),
        "update" => array("detail", "history_detail"),
        "delete" => array("delete"),
        "read" => array("index", "get_like", "history"),
    ),
);


/**
 * konstanta id role dengan nama role pegawai negeri sipil
 * digunakan untuk memberikan role secara otomatis pada PNS ketika menambahkan PNS pada referensi data PNS
 * karena ketika menambahkan PNS aplikasi membuatkan username dan password secara otomatis
 */
$config['id_role_pegawai_negeri_sipil'] = 13;