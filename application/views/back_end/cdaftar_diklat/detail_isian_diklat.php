<?php
$header_title = isset($header_title) ? $header_title : '';
$active_modul = isset($active_modul) ? $active_modul : 'none';
$detail = isset($detail) ? $detail : FALSE;
//var_dump($detail);exit;
$cb_jenis_diklat = isset($cb_jenis_diklat) ? $cb_jenis_diklat : FALSE;
?>

<div class="block">
    <p><?php echo load_partial("back_end/shared/attention_message"); ?></p>
</div>
<div class="block">

    <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label">Jenis Diklat *</label>
        <div class="col-md-6 col-xs-12">
            <?php
            $inp_jenis_diklat_attr = "class='form-control select' id='cb_jenis_diklat'";
            echo form_dropdown("id_jenis_diklat", $cb_jenis_diklat, ($detail ? $detail->id_jenis_diklat : ""), $inp_jenis_diklat_attr);
            ?>
            <span class="help-block"></span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label">Nama Diklat *</label>
        <div class="col-md-6 col-xs-12">
            <input type="text" name="nama_diklat" class="form-control" value="<?php echo $detail ? $detail->nama_diklat : ""; ?>">                      
            <span class="help-block"></span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label">Angkatan *</label>
        <div class="col-md-6 col-xs-12">
            <input type="text" name="angkatan" class="form-control" value="<?php echo $detail ? $detail->angkatan : ""; ?>">                      
            <span class="help-block"></span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label">Penyelenggara</label>
        <div class="col-md-6 col-xs-12">
            <input type="text" name="penyelenggara" class="form-control" value="<?php echo $detail ? $detail->penyelenggara : ""; ?>">                      
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
            <input type="text" name="total_jam" class="form-control" value="<?php echo $detail ? $detail->total_jam : ""; ?>">                      
            <span class="help-block"></span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label">Nomor STTPP *</label>
        <div class="col-md-6 col-xs-12">
            <input type="text" name="postfix_no_sttpp" class="form-control" value="<?php echo $detail ? $detail->postfix_no_sttpp : ""; ?>">                      
            <span class="help-block">Tuliskan nomor STTPP.<br />contoh : /DIKLAT PRAJABATAN III/118/3201/LAN/2015</span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label">Kota *</label>
        <div class="col-md-6 col-xs-12">
            <select id="slc-kab-kota" class="form-control select2-basic" name="id_kabupaten_kota">
            </select>                                       
            <span class="help-block">Pilih Kota tempat pelaksanaan diklat.<br />Masukkan kata kunci pada kotak inputan kemudian pilih kota yang dimaksud.</span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label">Alamat Lokasi *</label>
        <div class="col-md-6 col-xs-12">
            <input type="text" name="alamat_lokasi" class="form-control" value="<?php echo $detail ? $detail->alamat_lokasi : ""; ?>">                      
            <span class="help-block">Alamat Lokasi pelaksanaan Diklat.</span>
        </div>
    </div>

</div>