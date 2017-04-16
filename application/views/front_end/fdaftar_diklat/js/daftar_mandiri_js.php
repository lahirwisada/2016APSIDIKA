<?php
$detail = isset($detail) ? $detail : FALSE;
?>
<script type="text/javascript">

    var dfmandiri = {
        registrasi_diklat: function () {
            $("#frm-daftar-diklat-mandiri").submit(function (e) {
                e.preventDefault();

                modalConfirm({
                    id: 'message-box-confirm',
                    title: 'Mohon Tunggu',
                    msg: 'Sedang menyimpan data ...',
                    showButton: false,
                    onCancel: function () {
                        return false;
                    },
                    onOk: function () {
                        return false;
                    }
                });
                var data = new FormData();
                
                $.each($("#inp-pernyataan")[0].files, function(i, file){
                    data.append('file-pernyataan-'+i, file);
                });
                
                $.ajax({
                    url: "<?php echo base_url('front_end/fdaftar_diklat/mendaftar') . "/" . $detail->id_diklat_crypted; ?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    success: function (response, textStatus) {
                        window.location.href = "<?php echo base_url("front_end"); ?>";
                    }
                });

                return false;
            });
            return false;
        },
        init: function () {
//            $("#btn-submit-pernyataan").click(function () {
                dfmandiri.registrasi_diklat();
//            });
        }
    };

</script>
