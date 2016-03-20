<?php

$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$records = isset($records) ? $records : FALSE;
$field_id = isset($field_id) ? $field_id : FALSE;
$paging_set = isset($paging_set) ? $paging_set : FALSE;
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
?>
<div id="page-heading">
    <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li class="active">Kelola <?php echo $header_title; ?></li>
    </ol>

    <h1><?php echo $header_title; ?></h1>
</div>

<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-sky">
                <div class="panel-heading">
                    <h4>Daftar Kategori <?php echo $header_title; ?></h4>
                </div>
                <?php echo load_partial("back_end/shared/attention_message"); ?>
                <div class="panel-body collapse in">
                    <div class="row">
                        <p>
                            <a href="<?php echo backend_url('role/detail'); ?>" class="btn btn-default"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
                        </p>
                    </div>
                    <div class="row">
                        <form action="" class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <input type="text" name="keyword" class="form-control" value="<?php echo $keyword; ?>">
                                        <div class="input-group-btn">
                                            <button type="Submit" class="btn btn-info">Cari!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="table-type-of-leave">
                            <thead>
                                <tr>
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Role
                                    </th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($records != FALSE): ?>
                                    <?php foreach ($records as $key => $record): ?>
                                        <tr>
                                            <td>
                                                <?php echo $next_list_number; ?>
                                            </td>
                                            <td>
                                                <?php echo beautify_str($record->nama_role) ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-default" href="<?php echo base_url("back_end/role/detail") . "/" . $record->id_role; ?>">Ubah</a>
                                                <a class="btn btn-default" onclick="return confirm('Anda yakin akan menghapus berkas ini?');" href="<?php echo base_url("back_end/role/delete") . "/" . $record->id_role; ?>">Hapus</a>
                                            </td>
                                        </tr>
                                        <?php $next_list_number++; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php
                        echo $paging_set;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
