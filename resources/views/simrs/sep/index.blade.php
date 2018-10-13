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
              <th>Tanggal Reg</th>
              <th>Jenis Rawat</th>
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
<!-- <link rel="stylesheet" href="{{ asset('core-u/css/bootstrap.min.css') }}" /> -->
<link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
<link rel="stylesheet" href="{{ asset('selectize/css/selectize.css') }}" />

@endpush
@push('scripts')

<script type="text/javascript" src="{{ asset('datatables/js/jquery.dataTables.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('datatables/js/dataTables.bootstrap4.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('jquery-ui/jquery-ui.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('selectize/js/standalone/selectize.min.js') }}" ></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"  integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

@include('simrs.sep.modals.ajax')
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
        $('#dtgl_rujukan').datetimepicker({
            format: 'D-M-Y'
        });
    });

    $(document).ready(function () {
        getStart();
        resetSuccessSep();
        $('.table').removeAttr('style');
        ajaxLoad();
    });

    $('#modal-sep').on('hidden.bs.modal', function() {
        var alertas = $('#form-sep'),
            tgl_reg = '{{ date('Y-m-d') }}';
        
        $('#edit-modal-sep span').remove();
        $('#tgl_rujukan').val(); 
        $('#tgl_rujukan').attr('readonly', false); 
        alertas.validate().resetForm();
        alertas.find('.error').removeClass('error');
    });

    // Rujukan cari
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
                "url": "{{ route('bpjs.history')}}",
                "type": "GET",
                "data": {                   
                    no_kartu: no_kartu, akhir: akhir
                }
            },
            "columns": [
                {"mData": "no"},
                {"mData": "noSep"},
                {"mData": "tglSep"},
                {"mData": "noKartu"},
                {"mData": "namaPeserta"},
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
        console.log(sep);
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
                $('#tgl_rujukan').val(res.response.tglSep).attr('readonly','true');
                $('#ppk_rujukan').val(res.response.noSep.substr(0,8));
                $('#diagAwal').val(res.response.diagnosa);
                $('#tujuan').val(res.response.poli);
                $('#intern_rujukan').val(res.response.noSep).attr('readonly','true');
                $('#noRujukan').val(res.response.noSep);
                asalRujukan();
                katarak();
                getSkdp();

            }, 
            error: function() {
                $('#frame_error').show(100);
                $('#error_rujukan').html('Brigding lamban, sedang gangguan server bpjs');
            }
        
        });
        $('#modal-history').modal('hide');
        // console.log(rujukan);
    });

    $('#noRujukan').bind('keyup', function(event) {
        if(this.value.length < 17) return;
        var rujukan =$(this).val();
        // console.log(rujukan);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'get',
            url : '{{ route('bpjs.rujukan') }}',
            data : {rujukan: rujukan},
            success: function(data){
                // console.log(data);
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
                        $('#tgl_rujukan').val(response.tglKunjungan);
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

    // cari dbjp
    $(document).ready(function() {
        var src = "{{ route('bpjs.dpjp') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#kodeDPJP').autocomplete({
            source : function (request, response) {
                var jnsPel = $('#jns_pelayanan').val();
                var date = new Date();
                $.ajax({
                    url : src,
                    dataType : "json",
                    data : { term: request.term, jnsPel: jnsPel},
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
                $('#kodeDPJP').val(ui.item.value);
                $('#kd_dpjp').val(ui.item.id);
                return false;
            }
        });
    });

    function ajaxLoad(){
            var jnsRawat = $("#jns_rawat:checked").val();
            var caraBayar = $("#cara_bayar").val();
            var tglReg = $("#tgl_reg_filter").val();
            var search = $("#search").val();
            // $.fn.dataTable.ext.errMode = 'throw';
            $('#mytable').dataTable({
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
                    {"mData": "tgl_reg"},
                    {"mData": "jns_rawat"},
                    {"mData": "no_sjp"},
                    {"mData": "aksi"}            
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