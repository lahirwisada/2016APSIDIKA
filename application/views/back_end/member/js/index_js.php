<script type="text/javascript">



    $(document).ready(function () {
        var fnResetPassword = function (uname) {
            $.ajax({
                url: "<?php echo base_url('back_end/member/reset_password'); ?>",
                method: "POST",
                data: {uname: uname.substring(2)},
                success: function (response) {
                    $(".msg-reset-pass").empty();
                    $(".msg-reset-pass").html('<div id="alert-msg-reset" class="alert alert-dismissable alert-warning">Password Telah sukses di reset.<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>');
                    backToTop();
                }
            });
        };
        $(".resetusername").click(function () {
            if (confirm("Password akan dikembalikan menjadi default yaitu : 12345.\nAnda yakin?")) {
                fnResetPassword($(this).attr("id"));
            }
        });
    });
</script>