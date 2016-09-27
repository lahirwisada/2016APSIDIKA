<?php
$detail = isset($detail) ? $detail : FALSE;
/**
 * this is front_end authentication not back_end
 */
$is_authenticated = isset($is_authenticated) ? $is_authenticated : FALSE;
?>
<div class="page-content-wrap">
    <div class="page-content-holder">

        <div class="row">
            <div class="col-md-12 this-animate" data-animate="fadeInLeft">

                <div class="text-column">
                    <h4>Detail Diklat</h4>
                    <?php if (!$detail): ?>
                        <div class="text-column-info">
                            Mohon Maaf Diklat yang anda cari tidak ditemukan.
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <?php if ($detail): ?>
                        <div class="col-md-8">
                            <div class="fc-row">
                                <label>Nama Diklat</label> <?php echo $detail->nama_diklat; ?>
                            </div>
                            <div class="fc-row">
                                <label>Angkatan</label> <?php echo $detail->angkatan; ?>
                            </div>
                            <div class="fc-row">
                                <label>Nomor SPT</label> <?php echo $detail->no_spt_a . "/" . $detail->no_spt_b . "-" . $detail->no_spt_c . "/" . $detail->no_spt_d; ?> <label>Tanggal</label> <?php echo $detail->tgl_spt; ?>
                            </div>
                            <div class="fc-row">
                                <label>Penyelenggara</label>
                            </div>
                            <div class="fc-row">
                                <label>Pelaksanaan</label> <?php echo $detail->tgl_pelaksanaan; ?> - <?php echo $detail->tgl_selesai; ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                Untuk melakukan pendaftaran diklat ini anda harus memenuhi syarat sbb:
                                <ul>
                                    <li>Terdaftar dalam sistem.</li>
                                    <li>Memenuhi persyaratan yang dipersyaratkan oleh penyelenggara diklat.</li>
                                    <li>Terdaftar sebagai Pegawai Negeri Sipil Aktif Kota Tangerang Selatan.</li>
                                </ul>
                            </div>
                            <div class="row">
                                <?php if ($is_authenticated): ?>
                                    <a href="<?php echo base_url('front_end/fdaftar_diklat/daftar')."/".$detail->id_diklat_crypted; ?>" class="btn btn-primary">Daftar</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="col-md-12">
                            <div class="row">
                                Diklat yang anda cari tidak ditemukan.<br />Klik <a href="<?php echo base_url(); ?>">disini</a> untuk kembali.
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>
</div>