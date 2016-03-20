<?php
$doctors = isset($doctors) ? $doctors : FALSE;
$polies = isset($polies) ? $polies : FALSE;
$doctor_images_location = isset($doctor_images_location) ? $doctor_images_location : upload_location();

$records = isset($records) ? $records : FALSE;
$paging_set = isset($paging_set) ? $paging_set : FALSE;
$keyword = isset($keyword) ? $keyword : "";
$next_list_number = isset($next_list_number) ? $next_list_number : 1;

$currentusername = isset($currentusername) ? $currentusername : FALSE;
?>
<section id="content" class="tour">
    <div class="search-box-wrapper">
        <div class=" container">
            <form action="" class="">
                <div class="row">
                    <div class="form-group col-sm-10 col-md-10">
                        <div class="col-xs-12">
                            <input type="text" placeholder="Masukkan Kata Kunci" name="keyword" class="input-text full-width" value="<?php echo $keyword; ?>">
                        </div>
                    </div>
                    <div class="form-group col-sm-2 col-md-2 fixheight">
                        <button type="Submit" class="full-width icon-check full-width">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="section">
        <?php if ($currentusername): ?>
            <div class="container shortcode">
                <h1><a href="<?php echo backend_url(); ?>">Menu Operator (Back End)</a></h1>
                <div class="row block">
                    <div class="col-sm-4">
                        <a href="<?php echo backend_url('pendaftaran'); ?>">
                            <div class="pricing-table blue box">
                                <div class="header clearfix">
                                    <i class="soap-icon-friends circle white-color"></i><h4 class="box-title"><span>Pendaftaran<small>Penghuni Baru</small></span></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a href="<?php echo backend_url('rekap_pembayaran/detail'); ?>">
                            <div class="pricing-table green box">
                                <div class="header clearfix">
                                    <i class="soap-icon-savings circle white-color"></i><h4 class="box-title"><span>Catat Pembayaran<small>Bayar Kos</small></span></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a href="<?php echo backend_url('rekap_pembayaran/payment_in_arrears'); ?>">
                            <div class="pricing-table yellow box">
                                <div class="header clearfix">
                                    <i class="soap-icon-notice circle white-color"></i><h4 class="box-title"><span>Daftar Tunggakan<small>Penghuni yang Menunggak</small></span></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="container">
            <div id="main">
                <div class="items-container isotope image-box style9 row">
                    <?php if ($records != FALSE): ?>
                        <?php $i = 0; ?>
                        <?php foreach ($records as $key => $record): ?>
                            <div class="iso-item col-xs-12 col-sms-6 col-sm-6 col-md-2">
                                <a href="<?php echo base_url('front_end/home/detail/' . $record->id_petak); ?>">
                                    <article class="box">
                                        <?php
                                        $i++;
                                        ?>
                                        <figure>
                                            <a class="hover-effect" title="" href="<?php echo base_url('front_end/home/detail/' . $record->id_petak); ?>">
                                                <?php if ($record->nama_file != NULL): ?>

                                                    <img width="270" height="161" alt="" src="<?php echo upload_location() ?>petak/<?php echo $record->nama_file; ?>" >

                                                <?php else: ?>

                                                    <img width="270" height="161" alt="" src="<?php echo upload_location() ?>images/petak/<?php echo $i; ?>/1.jpg" >

                                                <?php endif; ?>
                                            </a>
                                        </figure>
                                        <?php
                                        if ($i == 3) {
                                            $i = 0;
                                        }
                                        ?>
                                        <div class="details">
                                            <h4 class="box-title"><?php echo beautify_str($record->nama_petak); ?></h4>
                                        </div>
                                    </article>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <?php
                echo $paging_set;
                ?>
            </div>
        </div>
    </div>
</section>