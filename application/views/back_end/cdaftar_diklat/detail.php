<?php
$header_title = isset($header_title) ? $header_title : '';
$active_modul = isset($active_modul) ? $active_modul : 'none';
$detail = isset($detail) ? $detail : FALSE;
//var_dump($detail);exit;
$cb_jenis_diklat = isset($cb_jenis_diklat) ? $cb_jenis_diklat : FALSE;
?>

<div class="row">
    <div class="col-md-12">

        <form id="frm-daftar-diklat" enctype="multipart/form-data" method="POST" class="form-horizontal">
            <div class="panel panel-default tabs">

                <div class="panel-heading">
                    <h3 class="panel-title">Formulir <strong><?php echo $header_title; ?></strong></h3>
                </div>

                <div class="tabs">

                    <ul class="nav nav-tabs nav-justified">
                        <li class="active"><a href="#isian-diklat" data-toggle="tab">Isian Diklat</a></li>
                        <li><a href="#konfigurasi-spt" data-toggle="tab">Konfigurasi SPT</a></li>
                        <li><a href="#dasar-spt" data-toggle="tab">Dasar SPT</a></li>
                        <li><a href="#tembusan-spt" data-toggle="tab">Tembusan SPT</a></li>
                    </ul>

                    <div class="panel-body tab-content">
                        <div class="tab-pane" id="konfigurasi-spt">
                            <?php echo load_partial('back_end/cdaftar_diklat/detail_konfigurasi_spt'); ?>
                        </div>
                        <div class="tab-pane" id="dasar-spt">
                            <?php echo load_partial('back_end/cdaftar_diklat/detail_dasar_spt'); ?>
                        </div>
                        <div class="tab-pane" id="tembusan-spt">
                            <?php echo load_partial('back_end/cdaftar_diklat/detail_tembusan_spt'); ?>
                        </div>
                        <div class="tab-pane active" id="isian-diklat">
                            <?php echo load_partial('back_end/cdaftar_diklat/detail_isian_diklat'); ?>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button id="btn-submit-form-daftar-diklat" type="submit" class="btn-primary btn pull-right">Submit</button>
                    <a href="<?php echo base_url("back_end/" . $active_modul . "/index"); ?>" class="btn-default btn">Batal / Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>