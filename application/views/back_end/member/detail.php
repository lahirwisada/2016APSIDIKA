<?php
$register_success = isset($register_success) ? $register_success : FALSE;
$redirect_uri = isset($redirect_uri) ? $redirect_uri : "back_end/member";
$model_user_attributes = isset($model_user_attributes) && array_have_value($model_user_attributes) ? $model_user_attributes : FALSE;
?>
<div id="page-heading">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url("back_end/home"); ?>">Home</a></li>
        <li><a href="<?php echo base_url($redirect_uri); ?>">Kelola Pengguna Gurita Store</a></li>
        <li class="active">Form Pendaftaran Pengguna</li>
    </ol>

    <h1>Pendaftaran Pengguna</h1>
</div>

<div class="container">
    <div class="panel panel-midnightblue">
        <div class="panel-heading">
            <h4>Detil</h4>
        </div>
        <div class="panel-body collapse in">
            <?php echo load_partial("back_end/shared/attention_message"); ?>
            <form enctype="multipart/form-data" method="POST" class="form-horizontal row-border">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Username *</label>
                    <div class="col-sm-6">
                        <input type="text" name="username" class="form-control" value="<?php echo $model_user_attributes ? $model_user_attributes['username'] : ""; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Password *</label>
                    <div class="col-sm-6">
                        <input type="password" name="password" class="form-control" value="<?php echo $model_user_attributes ? $model_user_attributes['password'] : ""; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-6">
                        <input type="text" name="email_profil" class="form-control" value="<?php echo $model_user_attributes ? $model_user_attributes['email_profil'] : ""; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nama *</label>
                    <div class="col-sm-6">
                        <input type="text" name="nama_profil" class="form-control" value="<?php echo $model_user_attributes ? stripslashes($model_user_attributes['nama_profil']) : ""; ?>">
                    </div>
                </div>
                
                <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="btn-toolbar">
                            <button type="submit" class="btn-primary btn">Simpan</button>
                            <a href="<?php echo base_url($redirect_uri); ?>" class="btn-default btn">Batal / Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>

    </div>
</div>