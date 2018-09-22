@extends('layouts.simrs.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      Master
    </li>

    <li class="breadcrumb-item">
      <a href="{{ route('sep.index') }}">Kwitansi</a>
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
<script type="text/javascript">
    $(function () {
        $('#datetimepicker').datetimepicker({
            format: 'D-M-Y'
        });
        $('#dtgl_kejadian').datetimepicker({
            format: 'D-M-Y'
        });
    });

    $(document).ready(function () {
        getStart();
        resetSuccessSep();
        $('.table').removeAttr('style');
        ajaxLoad();
    });

    $(document).ready(function() {
        var src = "{{ route('bpjs.diagnosa') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#diagnosa').autocomplete({
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
                $('#diagnosa').val(ui.item.value);
                $('#kd_diagnosa').val(ui.item.id);
                return false;
            }
        });
    })

    $(document).ready(function() {
        var src = "{{ route('bpjs.dpjp') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#namadpjp').autocomplete({
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
                $('#namadpjp').val(ui.item.value);
                $('#kd_dpjp').val(ui.item.id);
                return false;
            }
        });
    })

    $(document).ready(function() {
        var src = "{{ route('bpjs.poli') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#poli').autocomplete({
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
                $('#poli').val(ui.item.value);
                $('#kd_poli').val(ui.item.id); 
                katarak();
                return false;
            }
        });
    })
    
    $(document).on('click', "#h-rujukan", function() {
        var rujukan = $('#h-rujukan').data('rujukan');
        $('#no_rujukan').val(rujukan);
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
                        $('#tgl_rujukan').val(response.tglKunjungan);
                        $('#ppk_rujukan').val(response.provPerujuk.kode);
                        $('#diagnosa').val(response.diagnosa.nama);
                        $('#kd_diagnosa').val(response.diagnosa.kode).attr('readonly','true');
                        $('#poli').val(response.poliRujukan.nama);
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
           
        });
        $('#modal-rujukan').modal('hide');
        console.log(rujukan);
    })

    $(document).on('click', "#edit-item", function() {
        $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
        var date = moment().format("YYYY-MM-DD");
        $('input#tgl_reg').val(formatDate(date));
        getStart();
       
        var options = {
        'backdrop': 'static'
        };
        var no_reg = $(this).val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type : 'post',
            url : '{{ route('sep.buat') }}',
            data : {
                _token : CSRF_TOKEN,
                no_reg : no_reg
            },
            success:function(data) {
                // console.log(data);
                getEditItem(data);
                if ($('#no_kartu').val() !== '') {
                    getPeserta();
                }
                getProvinsi();
               
                if($('#jns_pelayanan').val() == 2) {
                    $('#nama_pelayanan').val('Rawat Jalan');
                } else {
                    $('#nama_pelayanan').val('Rawat Inap');
                }
                 
            }
        })
        $('#edit-modal').modal(options)
    })


    $('#no_rujukan').bind('keyup', function(event) {
        // var rujukan = $('#no_rujukan').val();
        if(this.value.length < 17) return;
        var rujukan =$(this).val();
        // console.log(rujukan);
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
                        $('#tgl_rujukan').val(response.tglKunjungan);
                        $('#ppk_rujukan').val(response.provPerujuk.kode);
                        $('#diagnosa').val(response.diagnosa.nama);
                        $('#kd_diagnosa').val(response.diagnosa.kode).attr('readonly','true');
                        $('#poli').val(response.poliRujukan.nama);
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
    })

    function getSkdp()
    {
        var internal = $('#intern_rujukan').val();
        if (internal !== 0) {
            $.ajax({
                url : '{{ route('rujukan.internal') }}',
                type: 'get',
                data: {internal: internal},
                success: function(data) {
                    if (data.length > 0) {
                        $('#form-skdp').show();
                    }
                }
            })
        }

    }

    $('#edit-modal').on('hidden.bs.modal', function() {
        var $alertas = $('#form-sep');
        $alertas.validate().resetForm();
        $alertas.find('.error').removeClass('error');
    });

    function sepValidation()
    {
        $("#form-sep").validate({
            rules: {
                noRujukan: {
                    required: true,
                    minlength: 8
                },
                asalRujukan: "required",
                jnsFaskes: "required",
                diagnosa: "required",
                namaPoli: "required"
            },
            messages: {
                noRujukan: {
                    required: "Kolom tidak boleh kosong!",
                    minlength: "Rujukana kurang dari 17 digit"
                },
                asalRujukan: "Kolom tidak boleh kosong!",
                jnsFaskes: "Kolom tidak boleh kosong!",
                diagnosa: "Kolom tidak boleh kosong!",
                namaPoli: "Kolom tidak boleh kosong!"
            }
        });
    }


    $('#cetak-sep').click(function(e) {
        var form = $('#form-sep').serialize();
        sepValidation();
        var url = $('#form-sep').attr("action");
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
        $.ajax({
            type : 'POST',
            url : url,
            data : form,
            success :function(data) {
                // console.log(data)
                if (data.response !== null) {
                    var no_reg = $('#no_reg').val();
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
                    // console.log(no_reg, data.response.sep.noSep);
                    $.ajax({
                        type : 'POST',
                        url : '{{ route('sep.simpan') }}',
                        data : { _token: CSRF_TOKEN, no_reg : no_reg, no_sep: data.response.sep.noSep},
                        success : function(response) {
                            // console.log(data); 
                            $('#frame_sep_success').show().html("<span class='text-success' id='success_sep'></span>");
                            $('#success_sep').html(data.metaData.message+" No SEP :"+data.response.sep.noSep).hide()
                            .fadeIn(1500, function() { $('#success_sep'); });
                            setTimeout(resetSuccessSep,4000);
                            ajaxLoad(0);
                        }
                    })
                } else {
                    $('#frame_sep_error').show().html("<span class='text-danger' id='error_sep'></span>");
                    $('#error_sep').html(data.metaData.message+" Silahkan lengkapi").hide()
                    .fadeIn(1500, function() { $('#error_sep'); });
                    setTimeout(resetSuccessSep,4000);
                }
               
            }, 
            error : function(data) {
                $('#frame_sep_error').show().html("<span class='text-danger' id='error_sep'></span>");
                $('#error_sep').html("Data yang di input belum lengkap!").hide()
                    .fadeIn(1500, function() { $('#error_sep'); });
                    setTimeout(resetSuccessSep,4000);
            }
        })

    })

    $(document).on('click', "#cari_rujukan", function() {
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
                  {"mData": "noKartu"},
                  {"mData": "nama"},
                  {"mData": "ppkPerujuk"},
                  {"mData": "poli"}            
            ]
           
        });
        oTable = $('#tbl-rujukan').DataTable();  
        $('#no_kartu').keyup(function(){
            oTable.search($(this).val()).draw() ;
            $('.table').removeAttr('style');
        }); 
        
        $('#modal-rujukan').modal(options);
    })

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
                      'tgl_reg': tglReg
                }
            },
            "columns": [
                  {"mData": "no"},
                  {"mData": "no_reg"},
                  {"mData": "no_rm"},
                  {"mData": "tgl_reg"},
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