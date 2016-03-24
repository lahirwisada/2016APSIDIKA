<?php
$active_modul = isset($active_modul) ? $active_modul : "";
$menu_item = isset($menu_item) ? build_atlant_menu($menu_item, $active_modul) : "";
?>


<ul class="x-navigation">
    <li class="xn-logo">
        <a href="<?php echo base_url(); ?>">BKPP</a>
        <a href="#" class="x-navigation-control"></a>
    </li>
    <li class="xn-profile">
        <a href="#" class="profile-mini">
            <img src="assets/images/users/avatar.jpg" alt="John Doe"/>
        </a>
        <div class="profile">
            <div class="profile-image">
                <img src="assets/images/users/avatar.jpg" alt="John Doe"/>
            </div>
            <div class="profile-data">
                <div class="profile-data-name">John Doe</div>
                <div class="profile-data-title">Web Designer</div>
            </div>
            <div class="profile-controls">
                <a href="pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
            </div>
        </div>                                                                        
    </li>
    <li class="xn-title">Menu</li>
    <?php echo $menu_item; ?>
</ul>