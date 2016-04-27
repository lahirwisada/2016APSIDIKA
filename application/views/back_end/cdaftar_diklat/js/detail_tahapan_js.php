<?php
$detail = isset($detail) ? $detail : FALSE;
?>
<script type="text/javascript">

    var tabTahapanDiklat = {
        idTable: '',
        init: function () {
            var self = this;
            self.hide();

            $("#cb_jenis_diklat").change(function () {
                if ($(this).val() == 2) {
                    self.show();
                } else {
                    self.hide();
                }
            });

            $(".disabled").click(function () {
//                $("#form-input-diklat-tab a:first").tab("show");
                $("li#li-tahapan-diklat").removeClass("active");
                $("li#li-isian-diklat").addClass("active");
            });

            $("#add-tahapan-diklat").click(self.tambahData);

        },
        __addRow: function (dataRow) {
            var tblTr = $("<tr class=\"tr-tahapan-diklat\"></tr>"), tblTdTahapan = $("<td></td>"), tblTdTanggal = $("<td></td>"), tblTdKeterangan = $("<td></td>"), tblTdAksi = $("<td></td>");

            var btnGroup = $("<div class=\"btn-group btn-group-sm\"></div>");

            var btnEdit = $("<a></a>");
            var btnRemove = $("<a></a>");

            var self = this;

            btnRemove.click(function () {

                var selfBtn = this;
                modalConfirm({
                    id: 'message-box-confirm',
                    title: 'Mohon Perhatian',
                    msg: 'Anda yakin akan menghapus berkas ini?',
                    onOk: function () {
                        $(selfBtn).parent().parent().parent().remove();
                    }
                });

                return false;
            });

            btnEdit.click(function () {


                var selfBtn = this, dataRow = $(selfBtn).parent().parent().parent().data();

                modalConfirm({
                    id: 'message-box-confirm',
                    title: 'Mohon Perhatian',
                    msg: 'Anda akan melakukan pengubahan data, sebelum mengakhiri pastikan anda menekan tombol tambah, Baik setelah mengubah data atau batal mengubah data.<br />Anda yakin akan melanjutkan?',
                    onOk: function () {
                        $(selfBtn).parent().parent().parent().remove();
                        self.editData(dataRow);
                    }
                });

                return false;
            });

            btnEdit.addClass("btn").addClass("btn-default").addClass("editRowTahapanDiklat").attr("href", "#").text("Ubah");
            btnRemove.addClass("btn").addClass("btn-default").addClass("btn-hapus-row").addClass("removeRowTahapanDiklat").attr("href", "#").text("Hapus");

            btnGroup.append(btnEdit).append(btnRemove);

//            tblTdAksi.html(btnGroup);
            tblTdAksi.append(btnGroup);

            tblTdTahapan.text(dataRow.tahapan);
            tblTdTanggal.text(dataRow.tgl_mulai_tahapan + " s.d. " + dataRow.tgl_selesai_tahapan);
            tblTdTanggal.attr("tgl_mulai_tahapan", dataRow.tgl_mulai_tahapan);
            tblTdTanggal.attr("tgl_selesai_tahapan", dataRow.tgl_selesai_tahapan);
            tblTdKeterangan.text(dataRow.keterangan);
            tblTr.append(tblTdTahapan);
            tblTr.append(tblTdTanggal);
            tblTr.append(tblTdKeterangan);
            tblTr.append(tblTdAksi);

            tblTr.data(dataRow);

            $("#DataTables_Table_tahapan_diklat tbody:last").append(tblTr);

            self.__sortByDate();
        },
        __removeRow: function (remBtnInstance) {
            var self = remBtnInstance;
            $(self).parent().parent().parent().remove();
        },
        __sortByDate: function () {

            $("tr.tr-tahapan-diklat").each(function () {
                var dataRow = $(this).data(), tgl_mulai = dataRow.tgl_mulai_tahapan, arrTglMulai = tgl_mulai.split('-'), tglMT = new Date(arrTglMulai[2], arrTglMulai[1] - 1, arrTglMulai[0]);
                dataRow._tgl_mulai_tahapan = tglMT.getTime();
                $(this).data(dataRow);
            }).sort(function (a, b) {
                return $(a).data('_tgl_mulai_tahapan') > $(b).data('_tgl_mulai_tahapan');
            }).appendTo('tbody');

        },
        collectData: function () {
            
            var dataTahapan = [];
            $("tr.tr-tahapan-diklat").each(function(){
                var dataRow = $(this).data();
                dataTahapan.push(dataRow);
                dataRow = undefined;
            });
            
            return dataTahapan;
        },
        editData: function (dataRow) {
            $("#txt-tahapan").val(dataRow.tahapan);
            $("#txt-tgl_mulai_tahapan").val(dataRow.tgl_mulai_tahapan);
            $("#txt-tgl_selesai_tahapan").val(dataRow.tgl_selesai_tahapan);
            $("#txtarea-keterangan_tahapan").val(dataRow.keterangan);
        },
        reset: function () {
            $("#txt-tahapan").val("");
            $("#txt-tgl_mulai_tahapan").val("");
            $("#txt-tgl_selesai_tahapan").val("");
            $("#txtarea-keterangan_tahapan").val("");
        },
        tambahData: function () {

            var formTahapanData = {
                tahapan: $("#txt-tahapan").val(),
                tgl_mulai_tahapan: $("#txt-tgl_mulai_tahapan").val(),
                tgl_selesai_tahapan: $("#txt-tgl_selesai_tahapan").val(),
                keterangan: $("#txtarea-keterangan_tahapan").val()
            };

            if (formTahapanData.tahapan.trim() == "" || formTahapanData.tgl_mulai_tahapan.trim() == "" || formTahapanData.tgl_selesai_tahapan.trim() == "") {
                modalAlert({
                    id: 'message-box-warning',
                    type: 'message-box-warning',
                    title: 'Mohon Perhatian',
                    titleIcon: 'fa fa-check',
                    msg: 'Beberapa kotak isian bertanda bintang (*) masih kosong, mohon perbaiki isian anda dan teliti kembali ..'
                });
                return false;
            }

            tabTahapanDiklat.__addRow(formTahapanData);

            tabTahapanDiklat.reset(formTahapanData);
            $("#hidden-status-form-tahapan-diklat").val("new");
        },
        show: function () {
            $("a#a-tahapan-diklat").attr("href", "#tahapan-diklat");
            $("a#a-tahapan-diklat").removeAttr("onclick");
            $("a#a-tahapan-diklat").removeClass("disabled");
            $("li#li-tahapan-diklat").removeClass("disabled");
        },
        hide: function () {
            $("a#a-tahapan-diklat").attr("href", "#");
            $("a#a-tahapan-diklat").attr("onclick", "javascript:void();");
            $("a#a-tahapan-diklat").addClass("disabled");
            $("li#li-tahapan-diklat").addClass("disabled");
//            $("div#tahapan-diklat").hide();
        }
    };

    $(document).ready(function () {
        tabTahapanDiklat.init();
    });

</script>