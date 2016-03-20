<?php
$user_detail = isset($user_detail) ? $user_detail : FALSE;
$attention_messages = isset($attention_messages) ? $attention_messages : FALSE;
$error_found = isset($error_found) ? $error_found : FALSE;
$roles = isset($roles) ? $roles : FALSE;
?>
<div id="page-heading">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url("back_end/home"); ?>">Home</a></li>
        <li><a href="<?php echo base_url("back_end/member/administrator"); ?>">Kelola Pengguna Gurita Store</a></li>
        <li class="active">Form Profil</li>
    </ol>

    <h1>Profil</h1>
</div>

<div class="container">
    <div class="panel panel-midnightblue">
        <div class="panel-heading">
            <h4>Detil</h4>
        </div>
        <div class="panel-body collapse in">
            <?php echo load_partial("back_end/shared/attention_message"); ?>
            <?php if ($user_detail): ?>
            <form enctype="multipart/form-data" method="POST" class="form-horizontal row-border">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-6">
                        <?php echo $user_detail['username']; ?>
                        <?php if ($roles): ?>
                            <br />
                            <small>(<?php echo $roles; ?>)</small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Password (lama) *</label>
                    <div class="col-sm-6">
                        <input type="password" name="oldpassword" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Password (baru)</label>
                    <div class="col-sm-6">
                        <input type="password" name="newpassword" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Email *</label>
                    <div class="col-sm-6">
                        <input type="text" name="email_profil" class="form-control" value="<?php echo $user_detail['email_profil']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nama *</label>
                    <div class="col-sm-6">
                        <input type="text" name="nama_profil" class="form-control" value="<?php echo stripslashes($user_detail['nama_profil']); ?>">
                    </div>
                </div>

                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class="btn-toolbar">
                                <button type="submit" class="btn-primary btn">Simpan Perubahan</button>
                                <a href="<?php echo base_url("back_end/home/"); ?>" class="btn-default btn">Batal / Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php else: ?>
            <p>Penggna Tidak ditemukan.</p>
            <?php endif; ?>
        </div>

    </div>
</div>