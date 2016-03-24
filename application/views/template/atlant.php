<?php
$app_author = isset($app_author) ? $app_author : 'Lahir Wisada Santoso';
$global_search_action = isset($global_search_action) ? $global_search_action : "#";
$page_title = isset($page_title) ? $page_title : "My Application";
$app_name = isset($app_name) ? $app_name : "My Application";

$site_description = isset($site_description) ? $site_description : "";
$site_keyword = isset($site_keyword) ? $site_keyword : "";

$view_js_default = isset($js_default) ? $js_default : '';
$view_css_default = isset($css_default) ? $css_default : '';

$template_body_class = isset($template_body_class) ? $template_body_class : '';

/**
 * User information
 */
$target_sub_page = isset($target_sub_page) ? $target_sub_page : FALSE;
$slogan = isset($slogan) ? $slogan : FALSE;

$currentusername = isset($currentusername) ? $currentusername : "Tidak Dikenal";
$current_user_profil_name = isset($current_user_profil_name) ? $current_user_profil_name : "Tidak Dikenal";
$current_user_roles = isset($current_user_roles) ? $current_user_roles : "Tamu";
?>
<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title><?php echo $page_title; ?></title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="<?php echo $site_description; ?>" />
        <meta name="author" content="<?php echo $app_author; ?>" />

        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo css(); ?>atlant/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->                                    
    </head>
    <body class="<?php echo $template_body_class; ?>">
        <!-- START PAGE CONTAINER -->
        <div class="page-container">

            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <?php echo load_partial('template/atlant/menu'); ?>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->

            <!-- PAGE CONTENT -->
            <div class="page-content">

                <!-- START X-NAVIGATION VERTICAL -->
                <?php echo load_partial('template/atlant/vertical_menu'); ?>
                <!-- END X-NAVIGATION VERTICAL -->                     

                <!-- START BREADCRUMB -->
                <?php echo load_partial('template/atlant/breadcrumb'); ?>
                <!-- END BREADCRUMB -->                       

                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <?php echo $content_for_layout; ?>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Anda yakin melakukan log out?</p>                    
                        <p>Tekan Tidak untuk batal log out. Tekan Ya untuk menutup sesi saat ini.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="pages-login.html" class="btn btn-success btn-lg">Ya</a>
                            <button class="btn btn-default btn-lg mb-control-close">Tidak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <div id="whateverelement"></div>

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="<?php echo assets(); ?>audio/atlant/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="<?php echo assets(); ?>audio/atlant/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->                  


        


        <!-- START SCRIPTS -->
        <?php echo load_partial('template/atlant/default_scripts'); ?>

        <?php echo isset($js) ? $js : ''; ?>

        <script type="text/javascript" src="<?php echo assets(); ?>js/helper/general_helper.js"></script>

        <?php echo load_partial('template/additional_js'); ?>
        <?php echo $view_js_default; ?>
        <!-- END SCRIPTS -->         
    </body>
</html>






