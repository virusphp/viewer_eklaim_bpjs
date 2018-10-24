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
    <!-- <div id="frame_sep_success" class="alert alert-success">
    </div>
    <div id="frame_sep_error" class="alert alert-danger">
    </div> -->
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
              <th>Tanggal Reg</th>
              <th>Jenis Rawat</th>
              <th>Cara Bayar</th>
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

@include('simrs.registrasi.modals.ajax')
<script type="text/javascript">
    $(function () {
        $('#datetimepicker').datetimepicker({
            format: 'D-M-Y'
        });
    });

    $(document).ready(function () {
        getStart();
        $('.table').removeAttr('style');
        ajaxLoad();
    });

    $(document).on('click','#simpan-user', function(e) {
        var form = $('#form-pasien'),
            url = "",
            method = 'POST';
        console.log(form.serialize());
        // Reset validationo error
        form.find('.invalid-feedback').remove();
        form.find('input').removeClass('is-invalid');
        form.find('#asalRujukan').prop('disabled', false);   
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
                getPoli();
                getJnsPasien();
                getNoKartu();
            } 
        })
    });

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

    $(document).on('change', '#poli', function() {
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
                    "url": "{{ route('reg.rj.search')}}",
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
                    {"mData": "tgl_reg"},
                    {"mData": "jns_rawat"},
                    {"mData": "cara_bayar"},
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