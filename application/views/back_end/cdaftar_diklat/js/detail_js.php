<script type="text/javascript">
    var eventRemoveListItem = function (e) {
        e.preventDefault();
        $(this).parents('a').remove();
    };
    
    var formDetailDiklat = {
        data: {
            spt_dasar: [],
            spt_tembusan: [],
            spt_tahapan: [],
            spt_hal_perhatian: [],
            id_jenis_diklat: null,
            nama_diklat: null,
            angkatan: null,
            penyelenggara: null,
            tgl_pelaksanaan: null,
            tgl_selesai: null,
            total_jam: null,
            postfix_no_sttpp: null,
            id_kabupaten_kota: null,
            alamat_lokasi: null,
            no_spt_a: null,
            no_spt_b: null,
            no_spt_c: null,
            no_spt_d: null,
            tgl_spt: null,
            id_ref_ttd: null,
            spt_kepada: null,
        },
        collectData: function(){
            var self = this;
            
            
            self.data.spt_dasar = [];
            /**
             * collect spt_dasar
             */
            $(".inp-spt-dasar").each(function(){
                self.data.spt_dasar.push($(this).val());
            });
            
            
            self.data.spt_tembusan = [];
            /**
             * collect spt_tembusan
             */
            $(".inp-spt-tembusan").each(function(){
                self.data.spt_tembusan.push($(this).val());
            });
            
            /**
             * collect spt_tahapan
             */
            self.data.spt_tahapan = tabTahapanDiklat.collectData();
            self.data.spt_hal_perhatian = tabHalPerhatianSpt.collectData();
            self.data.id_jenis_diklat = $("#cb_jenis_diklat").val();
            self.data.nama_diklat = $("#txt-nama_diklat").val();
            self.data.angkatan = $("#txt-angkatan_diklat").val();
            self.data.penyelenggara = $("#txt-penyelenggara_diklat").val();
            self.data.tgl_pelaksanaan = $("#txt-tgl_pelaksanaan").val();
            self.data.tgl_selesai = $("#txt-tgl_selesai").val();
            self.data.total_jam = $("#txt-total_jam").val();
            self.data.postfix_no_sttpp = $("#txt-postfix_no_sttpp").val();
            self.data.id_kabupaten_kota = $("#slc-kab-kota").val();
            self.data.alamat_lokasi = $("#txt-alamat_lokasi").val();
            self.data.no_spt_a = $("#txt-no_spt_a").val();
            self.data.no_spt_b = $("#txt-no_spt_b").val();
            self.data.no_spt_c = $("#txt-no_spt_c").val();
            self.data.no_spt_d = $("#txt-no_spt_d").val();
            self.data.tgl_spt = $("#txt-tgl_spt").val();
            self.data.id_ref_ttd = $("#slc-ttd").val();
            self.data.spt_kepada = $("#txt-spt_kepada").val();
            
            return self.data;
        }
    };
    
    $(document).ready(function () {
        $(".btn-remove-list").click(eventRemoveListItem);
        
        $("#frm-daftar-diklat").submit(function(e){
            e.preventDefault();
            
            var data = formDetailDiklat.collectData();
            $.ajax({
                url: "<?php echo base_url('back_end/cdaftar_diklat/detail'); ?>",
                data: data,
                method: 'POST',
                success: function(response, textStatus){
                    window.location.href = "<?php echo base_url("back_end/cdaftar_diklat"); ?>";
                }
            });
            
            return false;
        });
    });
</script>