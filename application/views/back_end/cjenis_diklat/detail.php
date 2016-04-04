<?php
$detail = isset($detail) ? $detail : FALSE;
?>

<div class="row">
    <div class="col-md-12">

        <form enctype="multipart/form-data" method="POST" class="form-horizontal">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h3 class="panel-title">Formulir <strong>Modul</strong></h3>
                </div>
                <div class="panel-body">
                    <p><?php echo load_partial("back_end/shared/attention_message"); ?></p>
                </div>
                <div class="panel-body">

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Nama Modul *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <input type="text" name="nama_modul" class="form-control" value="<?php echo $detail ? $detail->nama_modul : ""; ?>">
                            </div>                                            
                            <span class="help-block">Isikan sesuai dengan nama <i>controller</i> yang akan dipanggil.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Label *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <input type="text" name="deskripsi_modul" class="form-control" value="<?php echo $detail ? $detail->deskripsi_modul : ""; ?>">
                            </div>                                            
                            <span class="help-block">Isikan dengan teks yang mudah dimengerti dan sesuai dengan nama modul.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Turunan Dari</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <input type="text" name="turunan_dari" class="form-control" value="<?php echo $detail ? $detail->turunan_dari : ""; ?>">
                            </div>                                            
                            <span class="help-block">
                                menjelaskan bahwa modul ini merupakan sub-modul (anak modul) dari modul lainnya.<br />
                                isikan sesuai dengan nama modul referensi yang dituju, kosongi jika bukan merupakan sub-modul.</span>
                        </div>
                    </div>

                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn-primary btn pull-right">Submit</button>
                    <a href="<?php echo base_url("back_bone/modul/index"); ?>" class="btn-default btn">Batal / Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>