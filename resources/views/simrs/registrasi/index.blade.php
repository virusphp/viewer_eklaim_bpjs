@extends('layouts.simrs.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      Master
    </li>

    <li class="breadcrumb-item">
      <a href="{{ route('reg.rj.index') }}">Registrasi</a>
    </li>
    <li class="breadcrumb-item active">Index</li>
</ol>
@endsection
@section('content')
<div class="col-md-12">
    <div id="frame_success" class="alert alert-success">
    </div>

  <div class="card">
      <div class="card-header">
        @include('layouts.search.rjsearch')
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
            </tr>
          </thead>
          <tbody>
           
          </tbody>
        </table>
       
      </div>
  </div>
</div>

@include('simrs.registrasi.modals.modal_register')

@endsection
@push('css')
<!-- <link rel="stylesheet" href="{{ asset('core-u/css/bootstrap.min.css') }}" /> -->
<link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" />

@endpush
@push('scripts')

<script type="text/javascript" src="{{ asset('datatables/js/jquery.dataTables.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('datatables/js/dataTables.bootstrap4.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('jquery-ui/jquery-ui.min.js') }}" ></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@include('simrs.registrasi.modals.ajax')
<script type="text/javascript">
    $(function () {
        $('#datetimepicker').datetimepicker({
            format: 'D-M-Y'
        });
    });

    $(document).ready(function () {
        getStart();
        resetSuccessReg();
        $('.table').removeAttr('style');
        ajaxLoad(); 
        
        $('input').bind('keypress', function (eInner) {
            if (eInner.keyCode == 13) //if its a enter key
            {
                var tabindex = $(this).attr('tabindex');
                tabindex++; //increment tabindex
                //after increment of tabindex ,make the next element focus
                $('[tabindex=' + tabindex + ']').focus();

                //Just to print some msgs to see everything is working
                $('#Msg').text($(this).id + " tabindex: " + tabindex 
                + " next element: " +  $('[tabindex=' + tabindex + ']').id);
                return false; // to cancel out Onenter page postback in asp.net
            }
        });
    });

    $('#simpan-user').keypress(function(event) {
        if (event.keyCode === 13) {
            $(this).click();
        }
    })

    $(document).on('click','#simpan-user', function(e) {
        var form = $('#form-pasien'),
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
                    $('#frame_error').show().html("<span class='text-danger' id='error_reg'></span>");
                    $('#error_reg').html(res.pesan).hide()
                        .fadeIn(1500, function() { $('#error_reg'); });
                    setTimeout(resetAll,5000);
                } else {
                    $('#frame_success').show().html("<span class='text-success' id='success_reg'></span>");
                    $('#modal-register').modal('hide');
                    $('#success_reg').html("<ul><li>"+res.pesan+"</li><li>No Antrian :"+res.no_antrian+"</li><ul>").hide()
                        .fadeIn(1500, function() { $('#success_reg'); });
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

    $(document).on('click','#daftar-pasien', function() {
        $(this).addClass('edit-item-trigger-clicked');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content'),
            options = {
                'backdrop' : 'static'
            };

        $('#modal-register').modal(options);
    });

    // cari pasien
    $('#no_rm').bind('keyup', function(event) {
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
                $('#v-no-telp').val(res.no_telp).attr('readonly', true);
                $('#no_rm').attr('readonly', true);
                $('#poli').attr('readonly', false);
                // getPoli();
                // getJnsPasien();
                getNoKartu();
                // $("#poli").select2({
                //     placeholder: 'Select an option'
                // });
                // $("#jnsPasien").select2({
                //     placeholder: 'Select an option'
                // });
                
                // $('#poli').next('.select2').find('.select2-selection').one('focus', select2Focus).on('blur', function () {
                //     $(this).prop('tabindex', tabindex)
                // })

                // $('#jnsPasien').next('.select2').find('.select2-selection').one('focus', select2Focus).on('blur', function () {
                //     $(this).prop('tabindex', tabindex)
                // })
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
                $('#v-no-kartu').val(res.no_kartu).attr('readonly',true);
            }
        })
    }

    $(document).on('change', '#poli2', function() {
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
                $('#tarif').val(d.hasil.harga).attr('readonly', true);
                $('#kd_tarif').val(d.hasil.kd_tarif).attr('readonly', true);
                $('#rek_p').val(d.hasil.Rek_P).attr('readonly', true);
                $('#jnsPasien').attr('readonly', false);
                getDokter();
                $('#kdDokter').attr('readonly', false);
            } 
        });
    });

    function getDokter() {
        var kdPoli = $('#poli').val(),
            url = '{{ route('simrs.poli.dokter') }}',
            method = 'GET',
            CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: method,
            url: url,
            data: { kdPoli: kdPoli },
            success: function(res) {
                // console.log(res);
                $('#kdDokter').html(res);
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
                $('#poli').html(res);
            }
        })
    }

    // cari nama_poliklinik
    $(document).ready(function() {
        var src = "{{ route('simrs.poli') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#nama_poli').autocomplete({
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
                $('#poli').val(ui.item.id);
                $('#tarif').val(ui.item.harga);
                $('#kd_tarif').val(ui.item.kdTarif);
                $('#rek_p').val(ui.item.rekP);
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
                $('#jnsPasien').html(res);
            }
        })
    }

    // cari cara bayar
    $(document).ready(function() {
        var src = "{{ route('simrs.carabayar') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#nama_bayar').autocomplete({
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
                $('#jnsPasien').val(ui.item.id);
                return true;
            }
        });
   });

    function ajaxLoad(){
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
                    "url": "{{ route('reg.ri.search')}}",
                    "type": "GET",
                    "data": {                   
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
                    {"mData": "tgl_reg"},
                    {"mData": "jns_rawat"},
                    {"mData": "kd_cara_bayar"},
                    {"mData": "no_sjp"}
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