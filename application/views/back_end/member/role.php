<?php
$detail = isset($detail) ? $detail : FALSE;
$user_roles = isset($user_roles) ? $user_roles : FALSE;
?>
<div id="page-heading">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url("back_end/home"); ?>">Home</a></li>
        <li><a href="<?php echo base_url("back_end/user"); ?>">Daftar Pengguna</a></li>
        <li class="active">Role Pengguna</li>
    </ol>

    <h1>Kelola Role Pengguna</h1>
</div>

<div class="container">
    <form enctype="multipart/form-data" method="POST" class="form-horizontal row-border">
        <div class="panel panel-midnightblue">
            <div class="panel-heading">
                <h4>Detil</h4>
            </div>
            <div class="panel-body collapse in">

                <div class="row">
                    <a href="<?php echo base_url("back_end/user"); ?>" class="btn-default btn">Batal / Kembali</a>
                </div>
                <div class="row">
                    <?php echo load_partial("back_end/shared/attention_message"); ?>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-sm-3">Nama Pengguna</div>
                    <div class="col-sm-6">
                        <?php echo $detail ? $detail->username : ""; ?>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="panel panel-midnightblue">
                        <div class="panel-heading">
                            <h4>Detil Role Pengguna</h4>
                            <div class="options">   
                                <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                            </div>
                        </div>
                        <div class="panel-body collapse in">
                            <?php if ($user_roles): ?>
                                <div class="row">
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="table-type-of-leave">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">
                                                    Nama Role
                                                </th>
                                                <th>
                                                    Akses&nbsp;<?php /* <input name="ck_check_all" type="checkbox" id="ck_check_all" value="1"> (check semua) */ ?>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($user_roles as $key => $user_role): ?>
                                                <tr>
                                                    <td>
                                                        <?php echo beautify_str($user_role->nama_role); ?>
                                                    </td>
                                                    <td>
                                                        <input class="ck_role" name="ck_role[]" type="checkbox" <?php echo ($user_role->selected == 1 ? "checked=\"checked\"" : ""); ?> value="<?php echo $user_role->id_role; ?>">
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    Tidak ditemukan data role sama sekali.
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
                            <a href="<?php echo base_url("back_end/user"); ?>" class="btn-default btn">Batal / Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
