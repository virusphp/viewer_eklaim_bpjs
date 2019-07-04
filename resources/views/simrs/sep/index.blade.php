@extends('layouts.simrs.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      Master
    </li>

    <li class="breadcrumb-item">
      <a href="{{ route('sep.index') }}">SEP</a>
    </li>
    <li class="breadcrumb-item active">Index</li>
    <li class="breadcrumb-menu d-md-down-none">
        <div class="btn-group" role="group" aria-label="Button group">
            {{-- @include('simrs.sep.partials.radio_faskes') --}}
            <div class="col-md-5 col-form-label form-inline">
                History Peserta Bpjs
            </div>
            <input name="cek_no_rm" id="cek-no-rm" value="" class="form-control" placeholder="Scan No RM..." type="text">
            <a id="cek-history-peserta" class="btn btn-sm">
                <i class="icons tengah font-4xl icon-credit-card"></i>
            </a>
            <a id="daftar-pasien" class="btn btn-sm">
                <i class="icons tengah font-4xl icon-user-follow"></i>
            </a>
        </div>
    </li>
</ol>
@endsection
@section('content')
<div class="col-md-12">
    <div id="frame_sep_success" class="alert alert-success">
        <!-- success message -->
    </div>
    <div id="frame_sep_error" class="alert alert-danger">
        <!-- success message -->
    </div>
  <div class="card">
      <div class="card-header">
        @include('layouts.search.search')
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm table-hover" id="mytable">
          <thead>
            <tr>
              <th>No</th>
              <th>No Reg</th>
              <th>No RM</th>
              <th>Nama Pasien</th>
              <th>Tanggal Reg</th>
              <th>Jns Rawat</th>
              <th>Jns Pasien</th>
              <th>No SJP/SEP</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
           
          </tbody>
        </table>
       
      </div>
  </div>
</div>

@include('simrs.sep.modals.modal_sep')

@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" />

@endpush
@push('scripts')

<script type="text/javascript" src="{{ asset('datatables/js/jquery.dataTables.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('datatables/js/dataTables.bootstrap4.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('jquery-ui/jquery-ui.min.js') }}" ></script>
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"  integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

@include('simrs.sep.modals.ajax')
@include('simrs.sep.modals.ajax_register')
@include('simrs.sep.modals.insert_sep')
@include('simrs.sep.modals.update_sep')
<script type="text/javascript">
    $(function () {
        $('#datetimepicker').datetimepicker({
            format: 'D-M-Y'
        });
        $('#dtgl_kejadian').datetimepicker({
            format: 'D-M-Y'
        });
        $('#tglRujukan').datetimepicker({
            format: 'D-M-Y'
        });
        $('#dtglPulang').datetimepicker({
            format: 'D-M-Y'
        });
    });

    // $(document).ready(function() {
    //     $("#kodeDPJP").select2({
    //         placeholder: 'Select an option'
    //     });
    // });

    $(document).ready(function () {
        getStart();
        r_getStart();
        resetSuccessSep();
        r_resetSuccessReg();
        ajaxLoad();
        $('table .table').removeAttr('style');

        // $('input').bind('keypress', function (eInner) {
        //     if (eInner.keyCode == 13) //if its a enter key
        //     {
        //         var tabindex = $(this).attr('tabindex');
        //         tabindex++; //increment tabindex
        //         //after increment of tabindex ,make the next element focus
        //         $('[tabindex=' + tabindex + ']').focus();

        //         //Just to print some msgs to see everything is working
        //         $('#Msg').text($(this).id + " tabindex: " + tabindex 
        //         + " next element: " +  $('[tabindex=' + tabindex + ']').id);
        //         return false; // to cancel out Onenter page postback in asp.net
        //     }
        // });
    });

    $('#noSurat').on('change', function(){
        return event.charCode >= 48 && event.charCode <= 57
    })

    $('#modal-register').on('hidden.bs.modal', function(){
        $(this).find('form')[0].reset();
        
        $('#r_no_rm').attr('readonly', false);
    });

    $('#modal-sep').on('hidden.bs.modal', function() {
        var alertas = $('#form-sep'),
        tgl_reg = '{{ date('Y-m-d') }}';

        $("#edit-modal-sep span").remove(); 
        $("#poli-tujuan b span").remove();
        $("#status-prb b span").remove();
        $("#nama_pelayanan b span").remove();
        $("#tglRujukan").val(); 
        $("#tglRujukan").attr('readonly', false); 
        $('#asalRujukan').find("option[selected]").removeAttr('selected');
        $("#kodeDPJP").val([]).trigger("change")
        $("#tujuan").removeAttr("readonly");
        $('#noSuratLama').prop('type','hidden');
        $('#noSurat').prop('type','text');
        alertas.validate().resetForm();

        alertas.find('.error').removeClass('error');
    });

    $('#modal-history-peserta').on('hidden.bs.modal', function() {
        $("#tabel-history-peserta #isi-history tr").remove(); 
        $("#x-no-rm p").remove(); 
        $("#x-no-kartu p").remove(); 
    });

    // cari SKO sdf
    $('#cari_sko').on('click', function() {
        $(this).addClass('edit-item-trigger-clicked');
        var options = {
            'backdrop': 'static'
        };
        var no_kartu = $('#no_kartu').val(),
            akhir = moment().format("YYYY-MM-DD");
        $('#tbl-history').dataTable({
            "Processing": true,
            "ServerSide": true,
            "sDom" : "<t<p i>>",
            "iDisplayLength": 3,
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
                "url": "/admin/bpjs/history",
                "type": "GET",
                "data": {                   
                    no_kartu: no_kartu, akhir: akhir
                }
            },
            "columns": [
                {"mData": "no"},
                {"mData": "noSep"},
                {"mData": "tglSep"},
                {"mData": "namaPeserta"},
                {"mData": "jnsPelayanan"},
                {"mData": "namaPoli"},
                {"mData": "ppkPerujuk"}
            ]
        
        });
        oTable = $('#tbl-history').DataTable();  
        $('#no_kartu').keyup(function(){
            oTable.search($(this).val()).draw() ;
            $('.table').removeAttr('style');
        }); 
        
        $('#modal-history').modal(options);
    });

    // Rujukan keyup
    $(document).on('click','#h-sep', function() {
        var sep = $(this).data('sep');
        $('#no_rujukan').val(sep);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content'),
            url = '{{ route('bpjs.sep') }}',
            method = 'GET';
        $.ajax({
            method: method,
            url: url,
            data : {sep: sep},
            success: function(response){
                res = JSON.parse(response);
                // console.log(res);
                $('#form-skdp').show();
                $('#tglRujukan').val(res.response.tglSep).attr('readonly','true');
                $('#ppk_rujukan').val(res.response.noSep.substr(0,8));
                // $('#diagAwal').val(res.response.diagnosa);
                // $('#tujuan').val(res.response.poli);
                $('#intern_rujukan').val(res.response.noSep).attr('readonly','true');
                $('#noRujukan').val(res.response.noSep);
                asalRujukan();
                katarak();
                getSkdp();
                ceNoSurat();
                getDokterDpjp();
            }, 
            error: function() {
                $('#frame_error').show(100);
                $('#error_rujukan').html('Brigding lamban, sedang gangguan server bpjs');
            }
        
        });
        $('#modal-history').modal('hide');
    });

    $('#noRujukan').bind('keyup', function(event) {
        if(this.value.length < 17) return;
        var rujukan =$(this).val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'get',
            url : '{{ route('bpjs.rujukan') }}',
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
                        $('#tglRujukan').val(response.tglKunjungan);
                        $('#ppk_rujukan').val(response.provPerujuk.kode);
                        $('#diagAwal').val(response.diagnosa.nama);
                        $('#kd_diagnosa').val(response.diagnosa.kode).attr('readonly','true');
                        $('#tujuan').val(response.poliRujukan.nama);
                        $('#kd_poli').val(response.poliRujukan.kode).attr('readonly','true');
                        $('#intern_rujukan').val(response.noKunjungan).attr('readonly','true');
                        $('#no_rujukan').val(response.noKunjungan);
                        // getDiagnosa(response.diagnosa.kode, response.diagnosa.nama);
                        // getPoli(response.plliRujukan.kode, response.poliRujukan.nama)
                        asalRujukan();
                        katarak();
                        getSkdp();

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
           
        })
    });

    // cari diagnosa
    $(document).ready(function() {
        var src = "{{ route('bpjs.diagnosa') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#diagAwal').autocomplete({
            source : function (request, response) {
                $.ajax({
                    url : src,
                    dataType : "json",
                    data : { term: request.term },
                    success: function(data) {
                        var array = data.error ? [] : $.map(data, function(m) {
                            return {
                                id : m.kode,
                                value : m.nama
                            };
                        });
                        response(array);
                    }
                });
            },
            minLength: 3,
            select : function (event, ui) {
                $('#diagAwal').val(ui.item.value);
                $('#kd_diagnosa').val(ui.item.id);
                return false;
            }
        });
   });
   
    // cari poli bpjs
    $(document).ready(function() {
        var src = "{{ route('bpjs.poli') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#tujuan').autocomplete({
            source : function (request, response) {
                $.ajax({
                    url : src,
                    dataType : "json",
                    data : { term: request.term },
                    success: function(data) {
                        var array = data.error ? [] : $.map(data, function(m) {
                            return {
                                id : m.kode,
                                value : m.nama
                            };
                        });
                        
                        response(array);
                    }
                });
            },
            minLength: 3,
            select : function (event, ui) {
                $('#tujuan').val(ui.item.value);
                $('#kd_poli').val(ui.item.id); 
                katarak();
                return false;
            }
        });
    });

    // cari dbjp
    $(document).ready(function() {
        var src = "{{ route('bpjs.faskes') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#nama_faskes').autocomplete({
            source : function (request, response) {
                var asalRujukan = $('#asalRujukan').val();
                var date = new Date();
                $.ajax({
                    url : src,
                    dataType : "json",
                    data : { term: request.term, asalRujukan: asalRujukan},
                    success: function(data) {
                        var array = data.error ? [] : $.map(data, function(m) {
                            return {
                                id : m.kode,
                                value : m.nama
                            };
                        });
                        response(array);
                    }
                });
            },
            minLength: 3,
            select : function (event, ui) {
                $('#nama_faskes').val(ui.item.value);
                $('#ppk_rujukan').val(ui.item.id);
                return false;
            }
        });
    });

    // // cari dbjp
    $('#kodeDPJP').on('change',function() {
        var kdDPJP = $(this).val();
        $('#kd_dpjp').val(kdDPJP);         
    })

    //  $('#txtkodeDPJP').on('change',function() {
    //     var kdDPJP = $(this).val();
    //     $('#kd_dpjp').val(kdDPJP);         
    // })

    // $(document).ready(function() {
    //     var src = "{{ route('bpjs.dpjp') }}";
    //     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    //     $('#txtkodeDPJP').autocomplete({
    //         source : function (request, response) {
    //             var jnsPel = $('#jns_pelayanan').val();
    //             var date = new Date();
    //             $.ajax({
    //                 url : src,
    //                 dataType : "json",
    //                 data : { term: request.term, jnsPel: jnsPel},
    //                 success: function(data) {
    //                     console.log(data);
    //                     // var array = data.error ? [] : $.map(data, function(m) {
    //                     //     return {
    //                     //         id : m.kode,
    //                     //         value : m.nama
    //                     //     };
    //                     // });
    //                     // response(array);
    //                 }
    //             });
    //         },
    //         minLength: 3,
    //         select : function (event, ui) {
    //             $('#txtkodeDPJP').val(ui.item.value);
    //             $('#kd_dpjp').val(ui.item.id);
    //             return false;
    //         }
    //     });
    // });

    // Pulangkan Pasien
    $(document).on('click','#h-sep-p', function() {
        $(this).addClass('edit-item-trigger-clicked');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content'),
            noSep = $(this).data('sep'),
            noReg = $(this).val(),
            options = {
                'backdrop' : 'static'
            }; 
            console.log(noReg);
           $('#noSep-pulang').val(noSep);
           $('#noReg-pulang').val(noReg);
        $('#modal-pulang-sep').modal(options);
        $('#modal-history-peserta').modal('hide');
    })

    $(document).on('click','#update-pulang', function(e) {
        var form = $('#form-update-pulang'),
            method = 'POST',
            url = "/admin/sep/pulang";

        $.ajax({
            method: method,
            url: url,
            data: form.serialize(),
            dataType: "json",
            success: function(data) {
                console.log(data.metaData.message);
                if (data.response !== null) {
                    $('#frame_success').show().html("<span class='text-success' id='success_sep'></span>");
                    $('#success_sep').html("Pasien berhasil di pulangkan!").hide()
                    .fadeIn(1500, function() { $('#success_sep'); });
                    setTimeout(resetSuccessSep,5000);
                    ajaxLoad();
                    $('#modal-pulang-sep').modal('hide');
                } else {
                    $('#frame-pulang-error').show().html("<span class='text-danger' id='error_sep'></span>");
                    $('#error_sep').html("No Sep: "+$('#noSep').val()+" "+data.metaData.message).hide()
                    .fadeIn(1500, function() { $('#error_sep'); });
                    setTimeout(resetAll,5000);
                }
            }
        })
    });

    // cari history
    $('#cek-history-peserta').on('click', function() {
        historyPeserta();
    })

    function historyPeserta() {
        $(this).addClass('edit-item-trigger-clicked');

         var noRm = $('#cek-no-rm').val(),
             akhir = moment().format("YYYY-MM-DD");
             method = "GET",
             url = "/admin/bpjs/history/peserta",
             _token = $('meta[name="csrf-token"]').attr('content');
        if(no_rm.length < 6) return;

        $.ajax({
            method: method,
            url: url,
            data : {noRm: noRm, akhir: akhir},
            success: function(response){
                console.log(response.metaData.code == 200)
                if (response.metaData.code == 200) {
                    console.log("masuk sini")
                    $('#x-no-rm').append('<p id="v-no-rm">'+response.metaData.noRm+'</p>')
                    $('#x-no-kartu').append('<p id="v-no-kartu">'+response.metaData.noKartu+'</p>')
                    var history = '';
                    $.each(response.response.histori, function(key, val){
                        history += '<tr>';
                        history += '<td><div class="btn-group"><button data-sep="'+val.noSep+'" id="h-sep-p" class="btn btn-sencodary btn-xs btn-cus">'+ val.noSep +'</div></td>';
                        history += '<td>'+val.tglSep+'</td>';
                        history += '<td>'+((val.jnsPelayanan == 2) ? 'R Jalan' : 'R Inap')+'</td>';
                        history += '<td>'+val.poli+'</td>';
                        history += '<td>'+val.noRujukan+'</td>';
                        history += '<td>'+val.ppkPelayanan+'</td>';
                        history += '</tr>';
                    });
                    $('#tabel-history-peserta tbody').append(history);
                } 
            }
        })

        var options = {
            'backdrop': 'static'
        };

        $('#modal-history-peserta').modal(options);
    }

    // cari Rujukan Terakhir
    $('#cek-no-kartu').on('change', function() {
        pencarian();
    });

    $('#cek-x').on('click', function() {
        pencarian();
    });

    function pencarian() {
        $(this).addClass('edit-item-trigger-clicked');

        var no_kartu = $('#cek-no-kartu').val(),
            akhir = moment().format("YYYY-MM-DD"),
            _token = $('meta[name="csrf-token"]').attr('content');
        if(no_kartu.length < 9) return;

        var options = {
            'backdrop': 'static'
        };
        if ($('#fktp:checked').val() == 2) {
            var url = '{{ route('bpjs.cek.rujukan.rs') }}';
        } else {
            var url = '{{ route('bpjs.cek.rujukan') }}';
        }
        console.log($('#fktp:checked').val());

      
        $('#tbl-rujukan').dataTable({
            "Processing": true,
            "ServerSide": true,
            "sDom" : "<t<p i>>",
            "iDisplayLength": 3,
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
                "url": url,
                "type": "GET",
                "data": {                   
                    '_token': _token,
                    'no_kartu': no_kartu
                }
            },
            "columns": [
                {"mData": "no"},
                {"mData": "noKunjungan"},
                {"mData": "tglKunjungan"},
                {"mData": "nama"},
                {"mData": "poli"},
                {"mData": "pelayanan"},
                {"mData": "ppkPerujuk"}
            ]
        
        });
        oTable = $('#tbl-history').DataTable();  
        $('#no_kartu').keyup(function(){
            oTable.search($(this).val()).draw() ;
            $('.table').removeAttr('style');
        }); 
        
        $('#modal-rujukan').modal(options);
    }

    $(document).on('change','#search', function() {
        ajaxLoad();
    })

    function ajaxLoad(){
            var jnsRawat = $("input[name=jns_rawat]:checked").val();
            var caraBayar = $("#cara_bayar").val();
            var tglReg = $("#tgl_reg_filter").val();
            var search = $("#search").val();
            // $.fn.dataTable.ext.errMode = 'throw';
            $('#mytable').dataTable({
                "Processing": true,
                "responsive": true,
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
                    "url": "{{ route('sep.search')}}",
                    "type": "GET",
                    "data": {                   
                        'jns_rawat': jnsRawat,
                        'kd_cara_bayar': caraBayar,
                        'tgl_reg': tglReg,
                        'search' : search
                    }
                },
                "columns": [
                    {"mData": "no"},
                    {"mData": "no_reg"},
                    {"mData": "no_rm"},
                    {"mData": "nama_pasien"},
                    {"width": "10%", "mData": "tgl_reg"},
                    {"mData": "jns_rawat"},
                    {"width": "5%", "mData": "kd_cara_bayar"},
                    {"mData": "no_sjp"},
                    {"width": "15%", "mData": "aksi"}            
                ]
            });
            oTable = $('#mytable').DataTable();  
            $('#searchInput').keyup(function(){
                oTable.search($(this).val()).draw() ;
                $('.table').removeAttr('style');
            }); 
        }   
</script>
@endpush
