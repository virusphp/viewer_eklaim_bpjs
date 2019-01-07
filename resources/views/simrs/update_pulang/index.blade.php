@extends('layouts.simrs.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      Master
    </li>

    <li class="breadcrumb-item">
      <a href="{{ route('sep.index') }}">Update Pulang SEP</a>
    </li>
    <li class="breadcrumb-item active">Index</li>
    <li class="breadcrumb-menu d-md-down-none">
        <div class="btn-group" role="group" aria-label="Button group">
            
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
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
           
          </tbody>
        </table>
       
      </div>
  </div>
</div>

@include('simrs.sep.modals.modal_register')

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

@include('simrs.update_pulang.modals.ajax')

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
        resetSuccessSep();
        $('.table').removeAttr('style');
        ajaxLoad();
      
    });

    $('#modal-update-pulang').on('hidden.bs.modal', function() {
        var alertas = $('#form-sep'),
        tgl_reg = '{{ date('Y-m-d') }}';

        $("#edit-modal-sep span").remove(); 
        $("#poli-tujuan b span").remove();
        $("#tgl_rujukan").val(); 
        $("#tgl_rujukan").attr('readonly', false); 
        $('#asalRujukan').find("option[selected]").removeAttr('selected');
        $("#kodeDPJP").val([]).trigger("change")
        $("#tujuan").removeAttr("readonly");
        $('#noSuratLama').prop('type','hidden');
        $('#noSurat').prop('type','text');
        alertas.validate().resetForm();

        alertas.find('.error').removeClass('error');
    });

    $(document).on('change','#search', function() {
        ajaxLoad();
    })

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
