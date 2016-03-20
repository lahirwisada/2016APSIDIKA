<?php

include_once APPPATH . "/controllers/front_end/front_end.php";

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Member extends Front_end {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_user');
    }

    public function access_rules() {

        return array(
            array(
                'allow',
                'actions' => array("index", "register", "login", "logout", "refresh_captcha"),
                'users' => array('*')
            ),
            array(
                'allow',
                'actions' => array("profil"),
                'users' => array('@')
            ),
            array(
                'allow',
                'actions' => array("asdeveloper"),
                'users' => array('@'),
                'roles' => array('anggota')
            )
        );
    }

    public function index() {
        if (!$this->lmanuser->is_front_end_authenticated()) {
            redirect($this->my_location . $this->_name . "/login");
        }
        redirect($this->my_location . $this->_name . "/profil");
    }

    /**
     * @todo check user is logged in
     */
    public function register() {

        if ($this->is_authenticated()) {
            $this->go_to_session_location();
        }

        $register_success = FALSE;
        $this->attention_messages = "";
        $this->model_user->set_register_rules(TRUE);

        if ($this->model_user->get_data_post()) {
            if ($this->model_user->is_valid()) {
                $this->model_user->apply_password();
                $this->load->model(array('model_ref_user', 'model_ref_user_role', 'model_tr_profil'));
                $model_user_attributes = $this->model_user->get_attributes();
                $this->model_ref_user->set_userdata_from_model_user($model_user_attributes);
                $id_user = $this->model_ref_user->save();
                $this->model_ref_user_role->save($id_user, $this->model_user->show_role_anggota());
                $this->model_tr_profil->set_userdata_from_model_user($model_user_attributes, $id_user);
                $this->model_tr_profil->save();
                $register_success = TRUE;
            } else {
                $this->attention_messages = $this->model_user->errors->get_html_errors("<br />", "line-wrap");
            }
        }

        $captcha_image = $this->model_user->get_captcha();

        $this->add_cssfiles(array("bootstrap/bootstrap.css", "bootstrap/bootstrap-theme.css"));
        $this->set('register_success', $register_success);
        $this->set('captcha_image', $captcha_image);
        $this->set('model_user_attributes', $this->model_user->get_attributes());
        $this->set("additional_js", "front_end/member/js/register_js");
    }

    public function refresh_captcha() {
        $captcha_image = $this->model_user->get_captcha("refresh");
        $this->to_json((object) array("img_url" => $captcha_image));
    }

    public function asdeveloper() {
        $this->load->model("model_ref_gurita_konten");

        $this->load->model(array("model_persetujuan", "model_ref_user_role"));
        if ($this->model_persetujuan->get_data_post()) {
            if ($this->model_persetujuan->is_valid()) {
                $user_detail = $this->get_user_detail_from_session();
                $this->model_ref_user_role->save($user_detail["id_user"], model_user::ROLE_PENGEMBANG);
                $this->relogin($user_detail["username"]);
                $this->session->set_userdata("attention_messages", "Pengajuan telah berhasil diproses.");
                redirect("front_end/member/profil");
            } else {
                $this->attention_messages = "Persetujaun dibutuhkan.";
            }
        }

        $developer_eula = $this->model_ref_gurita_konten->get_developer_eula();
        $this->set("developer_eula", $developer_eula);
    }

}

?>