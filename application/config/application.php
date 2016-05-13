<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* custom setting */

$config['appname'] = 'Si Dika';
$config['copyright'] = 'Copyright &copy; 2016,.';


$config['hashed'] = 'VFUUl2rWS6I5EdSFU2JJyQ==';

$config['appkey'] = '1029384756';

$config['lmanuser.usingbackendfrontend'] = FALSE;
$config['user_id_column_name'] = "id_user";
$config['profil_id_column_name'] = "id_profil";
$config['backend_login_uri'] = 'back_end/member/login';

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