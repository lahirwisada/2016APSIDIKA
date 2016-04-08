<?php
$header_title = isset($header_title) ? $header_title : '';
$active_modul = isset($active_modul) ? $active_modul : 'none';
$detail = isset($detail) ? $detail : FALSE;
$cb_jenis_diklat = isset($cb_jenis_diklat) ? $cb_jenis_diklat : FALSE;
?>

<div class="row">
    <div class="col-md-12">

        <form enctype="multipart/form-data" method="POST" class="form-horizontal">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h3 class="panel-title">Formulir <strong><?php echo $header_title; ?></strong></h3>
                </div>
                <div class="panel-body">
                    <p><?php echo load_partial("back_end/shared/attention_message"); ?></p>
                </div>
                <div class="panel-body">

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Jenis Diklat *</label>
                        <div class="col-md-6 col-xs-12">
                            <?php
                            $inp_jenis_diklat_attr = "class='form-control select' id='cb_jenis_diklat'";
                            echo form_dropdown("id_jenis_diklat", $cb_jenis_diklat, ($detail ? $detail->nama_diklat : ""), $inp_jenis_diklat_attr);
                            ?>                      
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Nama Diklat *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="nama_diklat" class="form-control" value="<?php echo $detail ? $detail->nama_diklat : ""; ?>">
                            </div>                                            
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Angkatan *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="angkatan" class="form-control" value="<?php echo $detail ? $detail->angkatan : ""; ?>">
                            </div>                                            
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Penyelenggara</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="penyelenggara" class="form-control" value="<?php echo $detail ? $detail->penyelenggara : ""; ?>">
                            </div>                                            
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Tgl. Pelaksanaan</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text" name="tgl_pelaksanaan" class="form-control datepicker" value="<?php echo $detail ? $detail->tgl_pelaksanaan : ""; ?>">
                            </div>                                            
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Tgl. Selesai</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text" name="tgl_selesai" class="form-control datepicker" value="<?php echo $detail ? $detail->tgl_selesai : ""; ?>">
                            </div>                                            
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Total Jam Diklat *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="total_jam" class="form-control" value="<?php echo $detail ? $detail->total_jam : ""; ?>">
                            </div>                                            
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Nomor STTPP *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="postfix_no_sttpp" class="form-control" value="<?php echo $detail ? $detail->postfix_no_sttpp : ""; ?>">
                            </div>                                            
                            <span class="help-block">Tuliskan nomor STTPP.<br />contoh : /DIKLAT PRAJABATAN III/118/3201/LAN/2015</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Kota *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group col-md-6">
                                <select id="slc-kab-kota" class="form-control select2-basic" name="id_kabupaten_kota">
                                </select>

                                <?php // echo $detail ? $detail->id_kabupaten_kota : ""; ?>
                            </div>                                            
                            <span class="help-block">Pilih Kota tempat pelaksanaan diklat.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Alamat Lokasi *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="text" name="alamat_lokasi" class="form-control" value="<?php echo $detail ? $detail->alamat_lokasi : ""; ?>">
                            </div>                                            
                            <span class="help-block">Alamat Lokasi pelaksanaan Diklat.</span>
                        </div>
                    </div>

                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn-primary btn pull-right">Submit</button>
                    <a href="<?php echo base_url("back_end/" . $active_modul . "/index"); ?>" class="btn-default btn">Batal / Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>