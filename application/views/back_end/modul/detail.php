<?php
$detail = isset($detail) ? $detail : FALSE;
?>
<div id="page-heading">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url("back_end/home"); ?>">Home</a></li>
        <li><a href="<?php echo base_url("back_end/modul"); ?>">Daftar Modul</a></li>
        <li class="active">Form Modul</li>
    </ol>

    <h1>Modul</h1>
</div>

<div class="container">
    <div class="panel panel-midnightblue">
        <div class="panel-heading">
            <h4>Detil</h4>
        </div>
        <div class="panel-body collapse in">
            <p>
                <a href="<?php echo base_url("back_end/modul/index"); ?>" class="btn-default btn">Batal / Kembali</a>
            </p>
            <p>
            <?php echo load_partial("back_end/shared/attention_message"); ?>
            <form enctype="multipart/form-data" method="POST" class="form-horizontal row-border">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nama Modul *</label>
                    <div class="col-sm-6">
                        <input type="text" name="nama_modul" class="form-control" value="<?php echo $detail ? $detail->nama_modul : ""; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Label *</label>
                    <div class="col-sm-6">
                        <input type="text" name="deskripsi_modul" class="form-control" value="<?php echo $detail ? $detail->deskripsi_modul : ""; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Turunan Dari</label>
                    <div class="col-sm-6">
                        <input type="text" name="turunan_dari" class="form-control" value="<?php echo $detail ? $detail->turunan_dari : ""; ?>">
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class="btn-toolbar">
                                <button type="submit" class="btn-primary btn">Submit</button>
                                <a href="<?php echo base_url("back_end/modul/index"); ?>" class="btn-default btn">Batal / Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </p>
        </div>

    </div>
</div>