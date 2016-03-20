<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Testlogin extends Front_end {

    public function __construct() {
        parent::__construct();
//        $this->_layout = "backend";
    }

    public function index($provider = 'Google') {
        $this->load->helper('url_helper');
        
//        var_dump(class_exists('spark'));exit;

//        $this->load->spark('oauth2/0.3.1');

        $provider = $this->oauth2->provider($provider, array(
            'id' => '361916777711-k7u11sas2hskpv0p95a5m7skkn8t04st.apps.googleusercontent.com',
            'secret' => 'QUlkN1oA5bmSZHmoAb_pP6rM',
        ));
        
//        var_dump($provider);exit;

        if (!$this->input->get('code')) {
            // By sending no options it'll come back here
            $provider->authorize();
        } else {
            // Howzit?
            try {
                $token = $provider->access($_GET['code']);

                $user = $provider->get_user_info($token);

                // Here you should use this information to A) look for a user B) help a new user sign up with existing data.
                // If you store it all in a cookie and redirect to a registration page this is crazy-simple.
                echo "<pre>Tokens: ";
                var_dump($token);

                echo "\n\nUser Info: ";
                var_dump($user);
            } catch (OAuth2_Exception $e) {
                show_error('That didnt work: ' . $e);
            }
        }
    }

}
