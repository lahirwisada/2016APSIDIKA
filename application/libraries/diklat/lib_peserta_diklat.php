<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lib_peserta_diklat
 *
 * @author nurfadillah
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class lib_peserta_diklat {

    private $_ci = NULL;
    private $_const_excel_content_title = 'RANCANGAN RPJM DESA';
    private $_const_excel_content_header = array(
        8 => array(
            1 => 'no'
        ),
        10 => array(
            2 => 'bidang',
            4 => 'sub bidang',
            5 => 'jenis kegiatan',
            16 => 'sumber',
            17 => 'swakelola',
            18 => 'kerjasama antar desa',
            19 => 'kerjasama pihak ketiga',
        )
    );
    private $_const_excel_content_jumlah = array(
        1 => "jumlah per bidang 1",
        2 => "jumlah per bidang 2",
        3 => "jumlah per bidang 3",
        4 => "jumlah per bidang 4",
        "total" => "jumlah total",
    );
    public $is_valid_template = array(
        "content_title_ok" => FALSE,
        "header_ok" => TRUE,
        "tahun_anggaran_ok" => FALSE
    );
    public $id_master_rancangan_rpjm = FALSE;
    public $upload_data = FALSE;
    public $excel_content = FALSE;
    public $tahun_anggaran = NULL;
    public $tahun_anggaran_awal = NULL;
    public $tahun_anggaran_akhir = NULL;
    public $rpjm_datas = array();

    /**
     * Sesuaikan dengan field name pada tabel tbl_rp_rancangan_rpjm_desa
     * @var type
     */
    public $rpjm_row_template = array(
//        "bidang" => NULL,
        "sub_bidang" => NULL,
        "jenis_kegiatan" => NULL,
        "lokasi_rt_rw" => NULL,
        "prakiraan_volume" => NULL,
        "sasaran_manfaat" => NULL,
        "tahun_pelaksanaan_1" => NULL,
        "tahun_pelaksanaan_2" => NULL,
        "tahun_pelaksanaan_3" => NULL,
        "tahun_pelaksanaan_4" => NULL,
        "tahun_pelaksanaan_5" => NULL,
        "tahun_pelaksanaan_6" => NULL,
        "jumlah_biaya" => NULL,
        "sumber_dana" => NULL,
        "swakelola" => NULL,
        "kerjasama_antar_desa" => NULL,
        "kerjasama_pihak_ketiga" => NULL,
        "id_bidang" => NULL,
        "id_coa" => NULL,
        "id_tahun_anggaran" => NULL,
        "id_m_rancangan_rpjm_desa" => NULL
    );

    /**
     * Sesuaikan dengan field name pada tabel tbl_rp_m_rancangan_rpjm_desa
     * @var type 
     */
    public $master_rpjm_row_template = array(
        "tahun_awal" => NULL,
        "tahun_akhir" => NULL,
        "tahun_anggaran" => NULL,
        "nama_file" => NULL,
        "total_bidang_1" => NULL,
        "total_bidang_2" => NULL,
        "total_bidang_3" => NULL,
        "total_bidang_4" => NULL,
        "total_keseluruhan" => NULL,
        "tanggal_disusun" => NULL,
        "disusun_oleh" => NULL,
        "kepala_desa" => NULL,
        "id_desa" => NULL,
        "id_kecamatan" => NULL,
        "id_kab_kota" => NULL,
        "id_provinsi" => NULL
    );

    public function __construct() {
        $this->_ci = get_instance();
    }

    public function excel_uploaded() {
        return $this->upload_data && is_array($this->upload_data) && !array_key_exists('error', $this->upload_data);
    }

    private function read_excel_content() {
        $this->_ci->load->library('excel_reader');
        $this->_ci->excel_reader->setOutputEncoding('CP1251');

        $file = $this->upload_data['file_info'];

        $this->_ci->excel_reader->read($file);
        error_reporting(E_ALL ^ E_NOTICE);

        $this->excel_content = $this->_ci->excel_reader->sheets[0];
        unset($file);
    }

    /**
     * 
     * @param type $x_index
     * @param type $y_index
     * @param type $default_value
     * @param type $boolean
     * @param type $reverse
     * @return type
     */
    private function get_cell_value($x_index = FALSE, $y_index = FALSE, $default_value = FALSE, $boolean = FALSE, $reverse = FALSE) {
        $cell_value = $default_value;

        if ($x_index && $y_index) {
            $cell_value = array_key_exists($x_index, $this->excel_content['cells']) ? (array_key_exists($y_index, $this->excel_content['cells'][$x_index]) ? $this->excel_content['cells'][$x_index][$y_index] : FALSE) : FALSE;
        }
        if ($boolean && $reverse) {
            return intval(!$cell_value);
        } elseif ($boolean && !$reverse) {
            return intval($cell_value);
        }

        return $cell_value;
    }

    private function cell_have_value($x_index = FALSE, $y_index = FALSE) {
        return array_key_exists($x_index, $this->excel_content['cells']) ? (array_key_exists($y_index, $this->excel_content['cells'][$x_index]) ? 1 : 0) : 0;
    }

    public function is_valid_template() {

        if ($this->excel_uploaded() && $this->excel_content['numRows'] > 0) {
            $tahun_anggaran_ok = FALSE;

            /** check title */
            $template_content_title = $this->get_cell_value(1, 1);
            $content_title_ok = $template_content_title && $template_content_title == $this->_const_excel_content_title;
            /** check header */
            $header_ok = TRUE;

            foreach ($this->_const_excel_content_header as $index_x => $array_content_header) {
                foreach ($array_content_header as $index_y => $content_header) {
                    $header_val = $this->get_cell_value($index_x, $index_y);
                    $header_ok = $header_ok && strtolower($header_val) == $content_header;
                }
            }

            $this->tahun_anggaran = $this->get_cell_value(2, 9);
            if ($this->tahun_anggaran) {
                $_arr_tahun_anggaran = explode('-', $this->tahun_anggaran);
                $tahun_anggaran_ok = count($_arr_tahun_anggaran) > 0 && is_numeric(trim($_arr_tahun_anggaran[0])) && is_numeric(trim($_arr_tahun_anggaran[1]));
                if ($tahun_anggaran_ok) {
                    $this->tahun_anggaran_awal = $_arr_tahun_anggaran[0];
                    $this->tahun_anggaran_akhir = $_arr_tahun_anggaran[1];
                }
            }

            $this->is_valid_template = array(
                "content_title_ok" => $content_title_ok,
                "header_ok" => $header_ok,
                "tahun_anggaran_ok" => $tahun_anggaran_ok
            );

            return $content_title_ok && $header_ok && $tahun_anggaran_ok;
        }
        return FALSE;
    }

    public function get_nearest_word($input_text = '', $array_comparison = array(), $return_key = FALSE) {
        $shortest = -1;
        $closest = FALSE;
        $closest_key = FALSE;
        foreach ($array_comparison as $key => $word) {
            $lev = levenshtein(strtolower(trim($input_text)), strtolower(trim($word)));

            if ($lev == 0) {
                $closest = $word;
                $closest_key = $key;
                $shortest = 0;

                /* break out loop */
                break;
            }

            if ($lev <= $shortest || $shortest < 0) {
                $closest = $word;
                $closest_key = $key;
                $shortest = $lev;
            }
        }

        if ($return_key) {
            return $closest_key;
        }

        return $closest;
    }

    public function get_array_top_level_bidang() {
        $this->_ci->load->model('rencanaPembangunan/m_bidang');

        $rs = $this->_ci->m_bidang->getTopLevelBidang();

        $arr_result = FALSE;
        if ($rs) {
            foreach ($rs as $record) {
                $arr_result[$record["id_bidang"]] = strtolower(trim($record["deskripsi"]));
            }
        }
        return $arr_result;
    }

    public function get_array_provinsi() {
        $this->_ci->load->model('m_provinsi');
        return $this->_ci->m_provinsi->getArray();
    }

    public function get_array_kota($id_provinsi) {
        $this->_ci->load->model('m_kabkota');
        return $this->_ci->m_kabkota->getArray($id_provinsi);
    }

    public function get_array_kecamatan($id_kab_kota) {
        $this->_ci->load->model('m_kec');
        return $this->_ci->m_kec->getArray($id_kab_kota);
    }

    public function get_array_desa($id_kecamatan) {
        $this->_ci->load->model('m_desa');
        return $this->_ci->m_desa->getArray($id_kecamatan);
    }

    public function save_data($data = FALSE, $j = 1) {
        if ($data) {
//            $this->_ci->load->model('rencanaPembangunan/m_rancangan_rpjm_desa');
            $this->_ci->db->insert('tbl_rp_rancangan_rpjm_desa', $data);
            /* echo $j . ". >>>  " . $this->_ci->db->last_query() . "<br />"; */
        }
    }

    public function save_master_rpjm($data = FALSE) {
        if ($data) {
            $this->_ci->db->insert('tbl_rp_m_rancangan_rpjm_desa', $data);
            return $this->_ci->db->insert_id();
        }
        return FALSE;
    }

    public function update_master_rpjm($data = FALSE) {
        if ($data && $this->id_master_rancangan_rpjm) {
            $this->_ci->db->where('id_m_rancangan_rpjm_desa', $this->id_master_rancangan_rpjm);
            $this->_ci->db->update('tbl_rp_m_rancangan_rpjm_desa', $data);
            return TRUE;
        }
        return FALSE;
    }

    public function save_content_excel($upload_data=FALSE) {
        if(!$upload_data){
            return FALSE;
        }
        $this->upload_data = $upload_data;
        return $this->get_content_excel(TRUE);
    }

    private function get_idx_total($text_total = FALSE) {

        $idx = $this->get_nearest_word($text_total, $this->_const_excel_content_jumlah, TRUE);

        $idx_found = FALSE;
        switch ($idx) {
            case 1:
                $idx_found = "total_bidang_1";
                break;
            case 2:
                $idx_found = "total_bidang_2";
                break;
            case 3:
                $idx_found = "total_bidang_3";
                break;
            case 4:
                $idx_found = "total_bidang_4";
                break;
            case "total":
                $idx_found = "total_keseluruhan";
                break;
            default:
                $idx_found = FALSE;
                break;
        }

        return $idx_found;
    }

    public function get_content_excel($save_data = FALSE) {
        $this->read_excel_content();
        $valid_template = $this->is_valid_template();
        $top_level_bidang = $this->get_array_top_level_bidang();

        if ($this->is_valid_template() && $top_level_bidang) {
            $last_bidang = '';
            $last_sub_bidang = '';

            $master_rpjm = $this->master_rpjm_row_template;

            $master_rpjm["nama_file"] = $this->upload_data['file_name_uploaded'];

            $this->_ci->db->trans_off();
            $done = FALSE;
            do {
                if ($save_data) {
                    $this->_ci->db->trans_begin();
                    $this->_ci->db->trans_strict(FALSE);
                }
                $j = 1;


                /**
                 * Ambil data Nama Desa, Kecamatan, Kabupaten dan Provinsi
                 */
                $nama_provinsi = trim($this->get_cell_value(6, 3, ''));
                $arr_provinsi = $this->get_array_provinsi();
                $id_kab_kota = FALSE;
                $id_kecamatan = FALSE;
                $id_desa = FALSE;

                $master_rpjm["tahun_awal"] = intval(trim($this->tahun_anggaran_awal));
                $master_rpjm["tahun_akhir"] = intval(trim($this->tahun_anggaran_akhir));
                $master_rpjm["tahun_anggaran"] = trim($this->tahun_anggaran_awal) . " - " . trim($this->tahun_anggaran_akhir);

                if ($arr_provinsi) {
                    $id_provinsi = $this->get_nearest_word($nama_provinsi, $arr_provinsi, TRUE);
                    $master_rpjm["id_provinsi"] = $id_provinsi != 0 ? $id_provinsi : NULL;



                    $arr_kota = $this->get_array_kota($id_provinsi);
                    if ($arr_kota) {
                        $nama_kab_kota = trim($this->get_cell_value(5, 3, ''));
                        $id_kab_kota = $this->get_nearest_word($nama_kab_kota, $arr_kota, TRUE);
                        $master_rpjm["id_kab_kota"] = $id_kab_kota != 0 ? $id_kab_kota : NULL;
                    }

                    $arr_kecamatan = $this->get_array_kecamatan($id_kab_kota);
                    if ($arr_kecamatan) {
                        $nama_kecamatan = trim($this->get_cell_value(4, 3, ''));
                        $id_kecamatan = $this->get_nearest_word($nama_kecamatan, $arr_kecamatan, TRUE);
                        $master_rpjm["id_kecamatan"] = $id_kecamatan != 0 ? $id_kecamatan : NULL;
                    }

                    $arr_desa = $this->get_array_desa($id_kecamatan);
                    if ($arr_desa) {
                        $nama_desa = trim($this->get_cell_value(3, 3, ''));
                        $id_desa = $this->get_nearest_word($nama_desa, $arr_desa, TRUE);
                        $master_rpjm['id_desa'] = $id_desa != 0 ? $id_desa : NULL;
                    }
                }

                if ($save_data) {
                    $this->id_master_rancangan_rpjm = $this->save_master_rpjm($master_rpjm);
                }

                $bidang = NULL;

                for ($i = 12; $i <= $this->excel_content['numRows']; $i++) {

                    /**
                     * cek jika jumlah total
                     */
                    $text_jumlah_total = $this->get_cell_value($i, 1);
//                echo $text_jumlah_total."<br />"; 
                    if (!is_numeric($text_jumlah_total) && !(count($this->excel_content['cells'][$i]) > 2)) {
//                        $_const_excel_content_jumlah
                        $text_total = $this->get_cell_value($i, 1, '');
                        $jumlah_total = $this->get_cell_value($i, 15, '');
                        $idx_total = $this->get_idx_total($text_total);
                        if ($idx_total && $jumlah_total) {
                            $master_rpjm[$idx_total] = $jumlah_total;
                        }
                        continue;
                    }

                    /**
                     * cek jika jumlah perbidang
                     */
                    if (count($this->excel_content['cells'][$i]) > 2) {
                        $current_row = $this->rpjm_row_template;

                        if (is_null($bidang)) {
                            $bidang = $this->get_cell_value($i, 2, '');
                        }else{
                            $new_bidang = $this->get_cell_value($i, 2, '');
                            if($new_bidang){
                                $bidang = $new_bidang;
                            }
                        }
                        $current_row["sub_bidang"] = $this->get_cell_value($i, 4, '');
                        $current_row["jenis_kegiatan"] = $this->get_cell_value($i, 5, '');

//                        if (!$current_row["bidang"] && $current_row["jenis_kegiatan"]) {
//                            $current_row["bidang"] = $last_bidang;
//                        } else {
//                            $current_row["bidang"] = addslashes($current_row["bidang"]);
//                        }
//                        $last_bidang = $current_row["bidang"];

                        if (!$current_row["sub_bidang"] && $current_row["jenis_kegiatan"]) {
                            $current_row["sub_bidang"] = $last_sub_bidang;
                        } else {
                            $current_row["sub_bidang"] = addslashes($current_row["sub_bidang"]);
                        }
                        $last_sub_bidang = $current_row["sub_bidang"];

                        $current_row["lokasi_rt_rw"] = addslashes($this->get_cell_value($i, 6, ''));
                        $current_row["prakiraan_volume"] = addslashes($this->get_cell_value($i, 7, ''));
                        $current_row["sasaran_manfaat"] = addslashes($this->get_cell_value($i, 8, ''));

                        $th_1 = $this->cell_have_value($i, 9, 0);
                        $current_row["tahun_pelaksanaan_1"] = $th_1 ? $this->tahun_anggaran_awal : 0;
                        $th_2 = $this->cell_have_value($i, 10, 0);
                        $current_row["tahun_pelaksanaan_2"] = $th_2 ? $this->tahun_anggaran_awal + 1 : 0;
                        $th_3 = $this->cell_have_value($i, 11, 0);
                        $current_row["tahun_pelaksanaan_3"] = $th_3 ? $this->tahun_anggaran_awal + 2 : 0;
                        $th_4 = $this->cell_have_value($i, 12, 0);
                        $current_row["tahun_pelaksanaan_4"] = $th_4 ? $this->tahun_anggaran_awal + 3 : 0;
                        $th_5 = $this->cell_have_value($i, 13, 0);
                        $current_row["tahun_pelaksanaan_5"] = $th_5 ? $this->tahun_anggaran_awal + 4 : 0;
                        $th_6 = $this->cell_have_value($i, 14, 0);
                        $current_row["tahun_pelaksanaan_6"] = $th_6 ? $this->tahun_anggaran_awal + 5 : 0;

                        $current_row["jumlah_biaya"] = $this->get_cell_value($i, 15, '');
                        $current_row["sumber_dana"] = addslashes($this->get_cell_value($i, 16, ''));
                        $current_row["swakelola"] = $this->cell_have_value($i, 17, '');
                        $current_row["kerjasama_antar_desa"] = $this->cell_have_value($i, 18, '');
                        $current_row["kerjasama_pihak_ketiga"] = $this->cell_have_value($i, 19, '');
//                        $current_row["tahun_awal"] = intval(trim($this->tahun_anggaran_awal));
//                        $current_row["tahun_akhir"] = intval(trim($this->tahun_anggaran_akhir));
                        $current_row["id_bidang"] = $this->get_nearest_word($bidang, $top_level_bidang, TRUE);
                        if (!$current_row["id_bidang"]) {
                            $current_row["id_bidang"] = NULL;
//                        unset($current_row["id_bidang"]);
                        }

                        if ($this->id_master_rancangan_rpjm) {
                            $current_row["id_m_rancangan_rpjm_desa"] = $this->id_master_rancangan_rpjm;
                        }

                        unset($current_row["id_coa"], $current_row["id_tahun_anggaran"]);
//                    $current_row["id_coa"] = $this->get_cell_value($i, 5, '');
//                    $current_row["id_tahun_anggaran"] = $this->get_cell_value($i, 5, '');
                        if ($save_data) {
                            $this->save_data($current_row, $j);
                            $j++;
                        } else {
                            $this->rpjm_datas[] = $current_row;
                        }
                    }
                }

                $this->update_master_rpjm($master_rpjm);

                if ($save_data) {
                    $this->_ci->db->trans_complete();
                }
                $done = TRUE;
            } while ($this->excel_content['numRows'] && !$done);
            if ($save_data) {

                if ($this->_ci->db->trans_status() === FALSE) {
                    //if something went wrong, rollback everything
                    return FALSE;
                    $this->_ci->db->trans_rollback();
//                    return FALSE;
                }
                //if everything went right, commit the data to the database
                $this->_ci->db->trans_commit();
                return TRUE;

//                $this->_ci->db->trans_complete();
//                $this->_ci->db->trans_commit();
            }
            return $this->rpjm_datas;
        }
        return FALSE;
    }

    /**
     * 
     * @return boolean
     */
//    public function upload_excel($form_upload_field_name = 'file') {
//
//        $config['upload_path'] = "./uploads/temp_upload_excel/rpjm/";
//        $config['allowed_types'] = "xls|xlsx";
//
//        $this->_ci->load->library('upload', $config);
//
//
//        // 'file_excel'
//        if (!$this->_ci->upload->do_upload($form_upload_field_name)) {
//            return FALSE;
//        }
//
//        $this->upload_data = array('error' => FALSE);
//
//        /** upload data */
//        $this->upload_data = $this->_ci->upload->data();
//        $rename_to = (string) strtolower(str_replace(' ', '_', $this->upload_data['raw_name'])) . date('d-m-Y_His') . $this->upload_data['file_ext'];
//        $rename_to = 'rpjm_' . $rename_to;
//
//        rename($this->upload_data['file_info'], $this->upload_data['file_path'] . $rename_to);
//
//        $this->upload_data['file_info'] = $this->upload_data['file_path'] . $rename_to;
//        $this->upload_data['message'] = 'Upload Sukses.';
//        $this->upload_data['file_name_uploaded'] = $rename_to;
//        $this->upload_data['file_info'] = $this->upload_data['file_path'] . $rename_to;
//        /** End Upload data */
//        return TRUE;
//    }

}
