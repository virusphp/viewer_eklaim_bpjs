<script type="text/javascript">

$(document).on('click', "#edit-item", function(e) {
    // e.preventDefault();
    $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
    var date = moment().format("YYYY-MM-DD"),
        no_reg = $(this).val(),
        CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content'),
        options = {
            'backdrop' : 'static'
        },
        method = 'GET',
        url = '{{ route('sep.buat') }}';
    $('input#tgl_reg').val(formatDate(date));
    $('#update-sep').attr('id','cetak-sep').val('Buat Sep').removeClass('btn-warning').addClass('btn-primary')
    getStart();
    $.ajax({
        method : method,
        url : url,
        data : {
            _token : CSRF_TOKEN,
            no_reg : no_reg
        },
        dataType: "json",
        success: function(data) {
            getEditItem(data);
            getProvinsi();
        }
    });
    $('#modal-sep').modal(options);
});

$(document).on('click', '#print-sep', function() {
    // e.preverentDefault();
    var print = $(this),
        no_reg = print.data('print'),
        url = '{{ url('admin/sep/print') }}/'+no_reg; 
        console.log(no_reg);
        var w = window.open(url, "_blank", "width=850, height=600");
        // var w = window.open(url, "popupWindow", "width=850, height=600");
        // setTimeout(() => {
        //     w.print();
        // }, 0);
        // setTimeout(() => {
        //    w.document.close();
        //    w.close(); 
        // }, 0);
        // w.document.onfocus = function () { setTimeout(function () { w.document.close();w.close(); },w.close(), 0); }
});

// Rujukan cari
$('#cari_rujukan').on('click', function() {
    $(this).addClass('edit-item-trigger-clicked');
    var options = {
        'backdrop': 'static'
    };
    var no_kartu = $('#no_kartu').val();
    $('#tbl-rujukan').dataTable({
        "Processing": true,
        "ServerSide": true,
        "sDom" : "<t<p i>>",
        "iDisplayLength": 25,
        "bDestroy": true,
        "oLanguage": {
            "sLengthMenu": "_MENU_ ",
            "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
            "sSearch": "Search Data :  ",
            "sZeroRecords": "Tidak ada data",
            "sEmptyTable": "Data tidak tersedia",
            "sLoadingRecords": '<img src="{{asset('ajax-loader.gif')}}"> Loading...'
        },
        "ajax": {
            "url": "{{ route('bpjs.listrujukan')}}",
            "type": "GET",
            "data": {                   
                'no_kartu': no_kartu
            }
        },
        "columns": [
            {"mData": "no"},
            {"mData": "noKunjungan"},
            {"mData": "tglKunjungan"},
            {"mData": "nama"},
            {"mData": "poli"},
            {"mData": "ppkPerujuk"}
        ]
    
    });
    oTable = $('#tbl-rujukan').DataTable();  
    $('#no_kartu').keyup(function(){
        oTable.search($(this).val()).draw() ;
        $('.table').removeAttr('style');
    }); 
    
    $('#modal-rujukan').modal(options);
});

// Rujukan cari
$('#cari_rujukan_rs').on('click', function() {
    $(this).addClass('edit-item-trigger-clicked');
    var options = {
        'backdrop': 'static'
    };
    var no_kartu = $('#no_kartu').val();
    $('#tbl-rujukan-rs').dataTable({
        "Processing": true,
        "ServerSide": true,
        "sDom" : "<t<p i>>",
        "iDisplayLength": 25,
        "bDestroy": true,
        "oLanguage": {
            "sLengthMenu": "_MENU_ ",
            "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
            "sSearch": "Search Data :  ",
            "sZeroRecords": "Tidak ada data",
            "sEmptyTable": "Data tidak tersedia",
            "sLoadingRecords": '<img src="{{asset('ajax-loader.gif')}}"> Loading...'
        },
        "ajax": {
            "url": "{{ route('bpjs.listrujukan.rs')}}",
            "type": "GET",
            "data": {                   
                'no_kartu': no_kartu
            }
        },
        "columns": [
            {"mData": "no"},
            {"mData": "noKunjungan"},
            {"mData": "tglKunjungan"},
            {"mData": "nama"},
            {"mData": "poli"},
            {"mData": "ppkPerujuk"}       
        ]
    
    });
    oTable = $('#tbl-rujukan').DataTable();  
    $('#no_kartu').keyup(function(){
        oTable.search($(this).val()).draw() ;
        $('.table').removeAttr('style');
    }); 
    
    $('#modal-rujukan-rs').modal(options);
});
// Rujukan cari
$('#cari_no_surat').on('click', function() {
    $(this).addClass('edit-item-trigger-clicked');
    var options = {
        'backdrop': 'static'
    };
    var noRujukan = $('#noRujukan').val();
    $('#tbl-nosurat').dataTable({
        "Processing": true,
        "ServerSide": true,
        "sDom" : "<t<p i>>",
        "iDisplayLength": 5,
        "bDestroy": true,
        "oLanguage": {
            "sLengthMenu": "_MENU_ ",
            "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
            "sSearch": "Search Data :  ",
            "sZeroRecords": "Tidak ada data",
            "sEmptyTable": "Data tidak tersedia",
            "sLoadingRecords": '<img src="{{asset('ajax-loader.gif')}}"> Loading...'
        },
        "ajax": {
            "url": "{{ route('nosurat.internal')}}",
            "type": "GET",
            "data": {                   
                'noRujukan': noRujukan
            }
        },
        "columns": [
            {"mData": "no"},
            {"mData": "noSurat"},
            {"mData": "kdPoliDpjp"},
            {"mData": "noRujukan"},
            {"mData": "namaDokter"}
        ]
    
    });
    oTable = $('#tbl-nosurat').DataTable();  
    $('#no_kartu').keyup(function(){
        oTable.search($(this).val()).draw() ;
        $('.table').removeAttr('style');
    }); 
    
    $('#modal-nosurat').modal(options);
});

$(document).on('click', '#h-no-surat', function() {
    var noSurat = $(this).data('surat'),
        kdDpjp = $(this).val();
        noDpjp = noSurat.split('/');
        $('#noSurat').val(noDpjp[0].substring(noDpjp[0].length - 6));
        $('#kdPoliDPJP').val(kdDpjp);
        $('#kodeDPJP').attr('disabled', false);
        $('#modal-nosurat').modal('hide');
        
    var kdPoliDPJP = $('#kdPoliDPJP').val(),
        jnsPel = $('#jns_pelayanan').val(),
        method = 'GET',
        url = '{{ route('bpjs.dpjp.dokter') }}';
    $.ajax({
        method: method,
        url: url,
        data: { term: kdPoliDPJP, jnsPel: jnsPel },
        success: function(res) {
            console.log(res);
            $('#kodeDPJP').html(res);
            // di sini
        }
    })
});

// Rujukan keyup
$(document).on('click','#h-rujukan', function() {
    var rujukan = $(this).data('rujukan');
    // console.log(rujukan);
    $('#no_rujukan').val(rujukan);
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: 'get',
        url : '{{ route('bpjs.rujukan') }}',
        data : {rujukan: rujukan},
        success: function(data){
            d = JSON.parse(data);
            response = d.response.rujukan;
            if ($('#no_kartu').val() == response.peserta.noKartu) {
                $('#tgl_rujukan').val(response.tglKunjungan).attr('readonly','true');
                $('#ppk_rujukan').val(response.provPerujuk.kode);
                $('#diagAwal').val(response.diagnosa.nama);
                $('#kd_diagnosa').val(response.diagnosa.kode).attr('readonly','true');
                $('#tujuan').val(response.poliRujukan.nama);
                $('#kd_poli').val(response.poliRujukan.kode).attr('readonly','true');
                $('#intern_rujukan').val(response.noKunjungan).attr('readonly','true');
                $('#noRujukan').val(response.noKunjungan);
                asalRujukan();
                katarak();
                getSkdp();
                ceNoSurat();
                $('.select2').removeAttr('style');
            } else {
                $('#frame_error').show().html("<span class='text-danger' id='error_rujukan'></span>");
                $('#error_rujukan').html('No Rujukan tidak cocok').hide()
                    .fadeIn(1500, function() { $('#error_rujukan'); });
                    setTimeout(resetAll,3000);
            }
        }, 
        error: function() {
            $('#frame_error').show(100);
            $('#error_rujukan').html('Brigding lamban, sedang gangguan server bpjs');
        }
    
    });
    $('#modal-rujukan').modal('hide');
    // console.log(rujukan);
});

// Rujukan keyup
$(document).on('click','#h-rujukan-rs', function() {
    var rujukan = $(this).data('rujukanrs');
    // console.log(rujukan);
    $('#no_rujukan').val(rujukan);
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: 'get',
        url : '{{ route('bpjs.rujukan.rs') }}',
        data : {rujukan: rujukan},
        success: function(data){
            d = JSON.parse(data);
            // console.log(d);
            if (d.response === null) {
                $('#frame_error').show().html("<span class='text-danger' id='error_rujukan'></span>");
                $('#error_rujukan').html('No Rujukan tidak ada').hide()
                    .fadeIn(1500, function() { $('#error_rujukan'); });
                    setTimeout(resetAll,3000);
            } else {
                response = d.response.rujukan;
                if ($('#no_kartu').val() === response.peserta.noKartu) {
                    $('#tgl_rujukan').val(response.tglKunjungan).attr('readonly','true');
                    $('#ppk_rujukan').val(response.provPerujuk.kode);
                    $('#diagAwal').val(response.diagnosa.nama);
                    $('#kd_diagnosa').val(response.diagnosa.kode).attr('readonly','true');
                    $('#tujuan').val(response.poliRujukan.nama);
                    $('#kd_poli').val(response.poliRujukan.kode).attr('readonly','true');
                    $('#intern_rujukan').val(response.noKunjungan).attr('readonly','true');
                    $('#noRujukan').val(response.noKunjungan);
                    asalRujukan();
                    katarak();
                    getSkdp();
                    ceNoSurat();
                } else {
                    $('#frame_error').show().html("<span class='text-danger' id='error_rujukan'></span>");
                    $('#error_rujukan').html('No Rujukan tidak cocok').hide()
                        .fadeIn(1500, function() { $('#error_rujukan'); });
                        setTimeout(resetAll,3000);
                }
            }
        
        }, 
        error: function() {
            $('#frame_error').show(100);
            $('#error_rujukan').html('Brigding lamban, sedang gangguan server bpjs');
        }
    
    });
    $('#modal-rujukan-rs').modal('hide');
    // console.log(rujukan);
});

// CETAK SEP
$(document).on('click','#cetak-sep', function(e) {
    // e.preventDefault();
    var form = $('#form-sep'),
            method = 'POST';

    // Reset validationo error
    form.find('.invalid-feedback').remove();
    form.find('input').removeClass('is-invalid');
    form.find('#asalRujukan').prop('disabled', false);
    $.ajax({
        method : method,
        url : '{{ route('sep.insert') }}',
        data : form.serialize(),
        dataType: "json",
        success :function(data) {
            // console.log(data)
            if (data.response !== null) {
                var no_reg = $('#no_reg').val(),
                    no_rujukan = $('#noRujukan').val();
                    console.log(no_rujukan);
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
                $.ajax({
                    type : 'POST',
                    url : '{{ route('sep.simpan') }}',
                    data : { _token: CSRF_TOKEN, no_reg: no_reg, no_rujukan: no_rujukan, sep: data.response.sep.noSep},
                    success : function(response) {
                        console.log(response); 
                        $('#frame_sep_success').show().html("<span class='text-success' id='success_sep'></span>");
                        $('#success_sep').html(data.metaData.message+" No SEP :"+data.response.sep.noSep).hide()
                        .fadeIn(1500, function() { $('#success_sep'); });
                        setTimeout(resetSuccessSep,5000);
                        ajaxLoad();
                    }
                });
                $('#modal-sep').modal('hide');
            } else {
                // e.preventDefault();
                $('#frame_error').show().html("<span class='text-danger' id='error_sep'></span>");
                $('#error_sep').html(data.metaData.message+" Silahkan lengkapi").hide()
                .fadeIn(1500, function() { $('#error_sep'); });
                setTimeout(resetAll,5000);
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
    });

});
</script>