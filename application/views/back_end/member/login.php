<?php
$login_success = isset($login_success) ? $login_success : FALSE;
$model_user_attributes = isset($model_user_attributes) && array_have_value($model_user_attributes) ? $model_user_attributes : FALSE;
$attention_messages = isset($attention_messages) ? $attention_messages : FALSE;
?>
<form method="post" class="form-horizontal" style="margin-bottom: 0px !important;">
    <div class="panel-body">
        <h4 class="text-center" style="margin-bottom: 25px;">Silahkan melakukan Otentifikasi</h4>
        <?php echo load_partial("back_end/shared/attention_message"); ?>
        <div class="form-group">
            <div class="col-sm-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $model_user_attributes ? $model_user_attributes['username'] : ""; ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $model_user_attributes ? $model_user_attributes['password'] : ""; ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <div class="pull-right">
            <input type="reset" value="Reset" class="btn btn-default">
            <input type="submit" value="Masuk" class="btn btn-default">
        </div>
    </div>
</form>