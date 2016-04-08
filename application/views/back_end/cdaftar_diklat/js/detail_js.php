<?php
$detail = isset($detail) ? $detail : FALSE;
?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#slc-kab-kota").select2({
            ajax: {
                url: "<?php echo base_url(); ?>back_end/cref_kabupaten_kota/get_like",
                placeholder: 'Pilih Kota',
                dataType: 'json',
                delay: 250,
                method: 'post',
                width: '100%',
                data: function (params) {
                    return {
                        keyword: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {

                    var data = $.map(data, function (obj) {
                        obj.id = obj.id || obj.id_kabupaten_kota;
                        obj.text = obj.text || obj.kode_kabupaten + " " + obj.nama_kabupaten;

                        return obj;
                    });

                    params.page = params.page || 1;

                    return {
                        results: data
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 2
        });
<?php if ($detail && $detail->id_kabupaten_kota != ""): ?>
            $("#slc-kab-kota").select2("val", "<?php echo $detail->id_kabupaten_kota ?>");
<?php endif; ?>
    });
</script>