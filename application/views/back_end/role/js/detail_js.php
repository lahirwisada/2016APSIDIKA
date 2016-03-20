<script type="text/javascript">
    $(document).ready(function () {
        $("#ck_check_all").change(function () {
            if (confirm("anda yakin ?")) {
                if ($("#ck_check_all").is(':checked')) {
                    $(".ck_hakakses").attr("checked", "checked");
                } else {
                    $(".ck_hakakses").removeAttr("checked");
                }
            }
        });
        
        $("#ck_check_all_read").change(function () {
            if (confirm("anda yakin ?")) {
                if ($(this).is(':checked')) {
                    $(".ck_hakakses_is_read").attr("checked", "checked");
                } else {
                    $(".ck_hakakses_is_read").removeAttr("checked");
                }
            }
        });
        
        $("#ck_check_all_write").change(function () {
            if (confirm("anda yakin ?")) {
                if ($(this).is(':checked')) {
                    $(".ck_hakakses_is_write").attr("checked", "checked");
                } else {
                    $(".ck_hakakses_is_write").removeAttr("checked");
                }
            }
        });
        
        $("#ck_check_all_update").change(function () {
            if (confirm("anda yakin ?")) {
                if ($(this).is(':checked')) {
                    $(".ck_hakakses_is_update").attr("checked", "checked");
                } else {
                    $(".ck_hakakses_is_update").removeAttr("checked");
                }
            }
        });
        
        $("#ck_check_all_delete").change(function () {
            if (confirm("anda yakin ?")) {
                if ($(this).is(':checked')) {
                    $(".ck_hakakses_is_delete").attr("checked", "checked");
                } else {
                    $(".ck_hakakses_is_delete").removeAttr("checked");
                }
            }
        });
    });
</script>