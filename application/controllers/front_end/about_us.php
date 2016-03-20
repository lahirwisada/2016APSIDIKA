<?php

include_once APPPATH . "/controllers/front_end/front_end.php";
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class About_us extends Front_end {

    public function __construct() {
        parent::__construct();
        $this->set("template_body_class", "single");
        $this->set("active_menu", array('about_us' => TRUE));
//        $this->load->model("model_ref_tipe_statik");
    }

    /*
      public function access_rules() {

      return array(
      array(
      'allow',
      'actions' => array("index"),
      'users' => array('*')
      ),
      array(
      'allow',
      'actions' => array("feedback"),
      'users' => array('@')
      ),
      );
      }
     */

    private function set_about_us_categories() {
        $about_us_categories = $this->model_ref_tipe_statik->get_types_by_parent_id(1);
        $this->set('about_us_categories', $about_us_categories);
        return $about_us_categories;
    }

    public function index() {
//        $this->load->model("model_ref_gurita_konten");
//        $about_us_categories = $this->set_about_us_categories();
//        $qttg = $this->input->get("qttg");
//        $record = $this->model_ref_gurita_konten->get_about_us_content($about_us_categories, $qttg);
//        $this->set("record", $record);
//        if ($qttg == model_ref_gurita_konten::FAQ) {
//            $this->set("additional_css", "front_end/about_us/css/faq_css");
//        }
    }

    /**
     * todo: harus dibuat juga halaman adminnya
     * todo: kasih captcha
     */
    public function feedback() {
        $this->set_about_us_categories();

        $this->load->model("model_tr_umpan_balik");
        $this->model_tr_umpan_balik->set_feedback_rules();
        $error_found = FALSE;
        $feedback = FALSE;
        if ($this->model_tr_umpan_balik->get_data_post()) {
            if ($this->model_tr_umpan_balik->is_valid()) {
                $user_detail = $this->get_user_detail_from_session();
                $this->model_tr_umpan_balik->nama_pengirim = $user_detail["nama_profil"];
                $this->model_tr_umpan_balik->email_pengirim = $user_detail["email_profil"];
                $this->model_tr_umpan_balik->id_tipe_statik = model_ref_tipe_statik::UMPAN_BALIK;
                $this->model_tr_umpan_balik->save();
                unset($user_detail);
                $this->attention_messages = "Terima kasih atas umpan balik yang telah diberikan.";
            } else {
                $this->attention_messages = $this->model_tr_umpan_balik->errors->get_html_errors("<br />", "line-wrap");
                $error_found = $this->model_tr_umpan_balik->errors->error_found;
                $feedback = array_have_value($this->model_tr_umpan_balik->attributes) ? $this->model_tr_umpan_balik->attributes : FALSE;
            }
        }

        $this->set("feedback", $feedback);
        $this->set("error_found", $error_found);
        $this->add_cssfiles(array("bootstrap/bootstrap.css", "bootstrap/bootstrap-theme.css"));
    }

}
