<script type="text/javascript">

     $(document).on('click','#daftar-pasien', function() {
        $(this).addClass('edit-item-trigger-clicked');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content'),
            options = {
                'backdrop' : 'static'
            };

        $('#modal-register').modal(options);
    });
    $('#r_simpan-user').keypress(function(event) {
        if (event.keyCode === 13) {
            $(this).click();
        }
    })

    $(document).on('click','#r_simpan-user', function(e) {
        var form = $('#r_form-pasien'),
            url = "{{ route('reg.pasien.rj') }}",
            method = 'POST';
        // Reset validationo error
        form.find('.invalid-feedback').remove();
        form.find('input').removeClass('is-invalid');
        form.find('#asalRujukan').prop('disabled', false);   
        
        $.ajax({
            url: url,
            method: method,
            data: form.serialize(),
            success: function(res) {
                res = JSON.parse(res);
                console.log(res);
                if(res.ok == false) {
                    $('#r_frame_error').show().html("<span class='text-danger' id='r_error_reg'></span>");
                    $('#r_error_reg').html(res.pesan).hide()
                        .fadeIn(1500, function() { $('#r_error_reg'); });
                    setTimeout(resetAll,5000);
                } else {
                    $('#r_frame_success').show().html("<span class='text-success' id='r_success_reg'></span>");
                    $('#modal-register').modal('hide');
                    $('#r_success_reg').html("<ul><li>"+res.pesan+"</li><li>No Antrian :"+res.no_antrian+"</li><ul>").hide()
                        .fadeIn(1500, function() { $('#r_success_reg'); });
                    setTimeout(resetSuccessReg,5000);
                    ajaxLoad();
                }
            },
            error : function(xhr) {
                var errors = xhr.responseJSON; 
                // console.log(xhr);
                errorsHtml = '<ul>';
                $.each( errors.errors, function( key, value ) {
                    $("#" + key)
                            .addClass('is-invalid')
                            .closest('.form-group')
                            .append('<span class="invalid-feedback"><strong>' +value[0]+ '</strong></span>');
                });
            }
        })
        
    });

    // cari pasien
    $('#r_no_rm').bind('keyup', function(event) {
        if(this.value.length < 6) return;
        var noRm = $(this).val(),
            url = '{{ route('reg.pasien.search') }}',
            method = 'GET';
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // console.log(noRm);
        $.ajax({
            method: method,
            url : url,
            data : { noRm: noRm},
            success: function(res){
                $('#v-no-rm').val(res.no_RM).attr('readonly', true);
                $('#v-nama-pasien').val(res.nama_pasien).attr('readonly', true);
                $('#v-alamat-reg').val(res.alamat).attr('readonly', true);
                $('#v-jns-kel').val(res.jns_kel).attr('readonly', true);
                $('#v-tgl-lahir').val(res.tgl_lahir).attr('readonly', true);
                $('#v-tmpt-lahir').val(res.tempat_lahir).attr('readonly', true);
                $('#v-no-telp').val(res.no_telp);
                $('#r_no_rm').attr('readonly', true);
                $('#r_poli').attr('readonly', false);
                getNoKartu();
            } 
        })
    });

    function select2Focus() {
        $(this).closest('.select2').prev('select').select2('open');
    }

    function getNoKartu()
    {
        var noRm = $('#v-no-rm').val(),
            url = '{{ route('reg.pasien.kartu') }}',
            method = 'GET';
        $.ajax({
            method: method,
            url: url,
            data: { noRm: noRm },
            success: function(res) {
                $('#v-no-kartu').val(res.no_kartu);
                $('#v-kd-penjamin').val(res.kd_penjamin);
                $('#v-jns-penjamin').val(res.nama_penjamin);
                getHakKelas();
            }
        })
    }

    $(document).on('change', '#v-no-kartu', function() {
        console.log($(this).val());
        getHakKelas();
    })

    $(document).on('change', '#r_poli2', function() {
        var kdPoli = $(this).val(),
            method = 'GET',
            url = '{{ route('simrs.poli.harga') }}',
            CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: method,
            url : url,
            data : {kdPoli: kdPoli},
            success: function(res) {
                // console.log(res);
                d = JSON.parse(res);
                $('#r_tarif').val(d.hasil.harga).attr('readonly', true);
                $('#r_kd_tarif').val(d.hasil.kd_tarif).attr('readonly', true);
                $('#r_rek_p').val(d.hasil.Rek_P).attr('readonly', true);
                $('#r_jnsPasien').attr('readonly', false);
                getDokter();
                $('#r_kdDokter').attr('readonly', false);
            } 
        });
    });

    function getDokter() {
        var kdPoli = $('#r_poli').val(),
            url = '{{ route('simrs.poli.dokter') }}',
            method = 'GET',
            CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: method,
            url: url,
            data: { kdPoli: kdPoli },
            success: function(res) {
                // console.log(res);
                $('#r_kdDokter').html(res);
            }
        })
            
    }

    function getPoli() {
        var noRm = $('#v-no-rm').val(),
            token = $('meta[name="csrf-token"]').attr('content'),
            url = '{{ route('simrs.poli') }}',
            method = 'GET';
            if(noRm.length < 6) return;
        $.ajax({
            method: method,
            url: url,
            data : {_token: token},
            success: function(res) {
                $('#r_poli').html(res);
            }
        })
    }

    // cari nama_poliklinik
    $(document).ready(function() {
        var src = "{{ route('simrs.poli') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#r_nama_poli').autocomplete({
            source : function (request, response) {
                $.ajax({
                    url : src,
                    dataType : "json",
                    data : { term: request.term },
                    success: function(data) {
                        var array = data.error ? [] : $.map(data, function(m) {
                            return {
                                id : m.kd_sub_unit,
                                value : m.nama_sub_unit,
                                harga : m.harga,
                                kdTarif : m.kd_tarif,
                                rekP : m.Rek_P
                            };
                        });
                        response(array);
                    }
                });
            },
            minLength: 4,
            selectFirst: true,
            select : function (event, ui) {
                $(this).val(ui.item.value);
                $('#r_poli').val(ui.item.id);
                $('#r_tarif').val(ui.item.harga);
                $('#r_kd_tarif').val(ui.item.kdTarif);
                $('#r_rek_p').val(ui.item.rekP);
                getDokter();
                return true;
            }
        });
   });
    
    function getJnsPasien() {
        var token = $('meta[name="csrf-token"]').attr('content'),
            url = '{{ route('simrs.carabayar') }}',
            method = 'GET';
        $.ajax({
            method: method,
            url: url,
            data : {_token: token},
            success: function(res) {
                $('#r_jnsPasien').html(res);
            }
        })
    }

    // cari cara bayar
    $(document).ready(function() {
        var src = "{{ route('simrs.carabayar') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#r_nama_bayar').autocomplete({
            source : function (request, response) {
                $.ajax({
                    url : src,
                    dataType : "json",
                    data : { term: request.term },
                    success: function(data) {
                        var array = data.error ? [] : $.map(data, function(m) {
                            return {
                                id : m.kd_cara_bayar,
                                value : m.keterangan
                            };
                        });
                        response(array);
                    }
                });
            },
            minLength: 4,
            selectFirst: true,
            select : function (event, ui) {
                $(this).val(ui.item.value);
                $('#r_jnsPasien').val(ui.item.id);
                return true;
            }
        });
   });

    // cari cara bayar
    $(document).ready(function() {
        var src = "{{ route('simrs.jenispenjamin') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#v-jns-penjamin').autocomplete({
            source : function (request, response) {
                $.ajax({
                    url : src,
                    dataType : "json",
                    data : { term: request.term },
                    success: function(data) {
                        var array = data.error ? [] : $.map(data, function(m) {
                            return {
                                id : m.kd_penjamin,
                                value : m.nama_penjamin
                            };
                        });
                        response(array);
                    }
                });
            }, 
            minLength: 3,
            selectFirst: true,
            select : function (event, ui) {
                $(this).val(ui.item.value);
                $('#v-kd-penjamin').val(ui.item.id);
                return true;
            }
        });
   });
</script>