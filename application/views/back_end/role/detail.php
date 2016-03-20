<?php
$detail = isset($detail) ? $detail : FALSE;
$modul_role_access = isset($modul_role_access) ? $modul_role_access : FALSE;
?>
<div id="page-heading">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url("back_end/home"); ?>">Home</a></li>
        <li><a href="<?php echo base_url("back_end/role"); ?>">Kelola Role</a></li>
        <li class="active">Form Role</li>
    </ol>

    <h1>Kelola Role</h1>
</div>

<div class="container">
    <form enctype="multipart/form-data" method="POST" class="form-horizontal row-border">
        <div class="panel panel-midnightblue">
            <div class="panel-heading">
                <h4>Detil</h4>
            </div>
            <div class="panel-body collapse in">

                <div class="row">
                    <a href="<?php echo base_url("back_end/role/index"); ?>" class="btn-default btn">Batal / Kembali</a>
                </div>
                <div class="row">
                    <?php echo load_partial("back_end/shared/attention_message"); ?>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Role *</label>
                        <div class="col-sm-6">
                            <input type="text" name="nama_role" class="form-control" value="<?php echo $detail ? $detail->nama_role : ""; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="panel panel-midnightblue">
                        <div class="panel-heading">
                            <h4>Detil Modul Akses</h4>
                            <div class="options">   
                                <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                            </div>
                        </div>
                        <div class="panel-body collapse in">
                            <?php if ($modul_role_access): ?>
                                <div class="row">
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="table-type-of-leave">
                                        <thead>
                                            <tr>
                                                <td rowspan="2">
                                                    Nama Modul
                                                </td>
                                                <td rowspan="1" colspan="4">
                                                    Hak Akses&nbsp;<?php /* <input name="ck_check_all" type="checkbox" id="ck_check_all" value="1"> (check semua) */ ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td rowspan="1">
                                                    Baca&nbsp;<?php /* <input name="ck_check_all_read" type="checkbox" id="ck_check_all_read" value="1"> <!-- is_read --> */ ?>
                                                </td>
                                                <td rowspan="1">
                                                    Buat Baru&nbsp;<?php /* <input name="ck_check_all_write" type="checkbox" id="ck_check_all_write" value="1"> <!-- is_write --> */ ?>
                                                </td>
                                                <td rowspan="1">
                                                    Perbarui (update)&nbsp;<?php /* <input name="ck_check_all_update" type="checkbox" id="ck_check_all_update" value="1"> <!-- is_update --> */ ?>
                                                </td>
                                                <td rowspan="1">
                                                    Hapus&nbsp;<?php /* <input name="ck_check_all_delete" type="checkbox" id="ck_check_all_delete" value="1"> <!-- is_delete --> */ ?>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($modul_role_access as $key => $record_role_access): ?>
                                                <tr>
                                                    <td rowspan="1">
                                                        <?php echo beautify_str($record_role_access->deskripsi_modul); ?>
                                                        <input type="hidden" name="id_modul[<?php echo $record_role_access->nama_modul; ?>]" value="<?php echo $record_role_access->id_modul; ?>" id="txtInputIdx<?php echo $record_role_access->nama_modul; ?>">
                                                    </td>
                                                    <td rowspan="1">
                                                        <input class="ck_hakakses ck_hakakses_is_read" name="ck_<?php echo $record_role_access->nama_modul; ?>[is_read]" type="checkbox" <?php echo ($record_role_access->access->is_read == 1? "checked=\"checked\"":""); ?> id="<?php echo $record_role_access->nama_modul; ?>_is_read" value="1">
                                                    </td>
                                                    <td rowspan="1">
                                                        <input class="ck_hakakses ck_hakakses_is_write" name="ck_<?php echo $record_role_access->nama_modul; ?>[is_write]" type="checkbox" <?php echo ($record_role_access->access->is_write == 1? "checked=\"checked\"":""); ?> id="<?php echo $record_role_access->nama_modul; ?>_is_write" value="1">
                                                    </td>
                                                    <td rowspan="1">
                                                        <input class="ck_hakakses ck_hakakses_is_update" name="ck_<?php echo $record_role_access->nama_modul; ?>[is_update]" type="checkbox" <?php echo ($record_role_access->access->is_update == 1? "checked=\"checked\"":""); ?> id="<?php echo $record_role_access->nama_modul; ?>_is_update" value="1">
                                                    </td>
                                                    <td rowspan="1">
                                                        <input class="ck_hakakses ck_hakakses_is_delete" name="ck_<?php echo $record_role_access->nama_modul; ?>[is_delete]" type="checkbox" <?php echo ($record_role_access->access->is_delete == 1? "checked=\"checked\"":""); ?> id="<?php echo $record_role_access->nama_modul; ?>_is_delete" value="1">
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    Tidak ditemukan data modul sama sekali.
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="btn-toolbar">
                            <button type="submit" class="btn-primary btn">Submit</button>
                            <a href="<?php echo base_url("back_end/role/index"); ?>" class="btn-default btn">Batal / Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>