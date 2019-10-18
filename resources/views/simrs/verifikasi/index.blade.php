@extends('layouts.verifikasi.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      Master
    </li>

    <li class="breadcrumb-item">
      <a href="{{ route('sep.index') }}">Viewer</a>
    </li>
    <li class="breadcrumb-item active">Index</li>
    <li class="breadcrumb-menu d-md-down-none">
    </li>
</ol>
@endsection
@section('content')
<div class="col-md-12">
    {{-- <div id="frame_sep_success" class="alert alert-success">
        <!-- success message -->
    </div>
    <div id="frame_sep_error" class="alert alert-danger">
        <!-- success message --> --}}
    {{-- </div> --}}
  <div class="card">
      <div class="card-header">
        @include('layouts.search.search')
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm table-hover" id="mytable">
          <thead>
            <tr>
              <th>No</th>
              <th>No Kartu</th>
              <th>No RM</th>
              <th>Nama Pasien</th>
              <th>Tanggal SEP</th>
              <th>Sep</th>
              <th>View</th>
              {{-- <th>Periksa</th> --}}
            </tr>
          </thead>
          <tbody>
           
          </tbody>
        </table>
       
      </div>
  </div>
</div>

{{-- @include('simrs.verifikasi.modals.partials.register_pasien') --}}
@include('simrs.verifikasi.modals.modal_viewer')

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

@include('simrs.verifikasi.modals.ajax')
{{-- @include('simrs.verifikasi.modals.ajax_register') --}}
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

    $(document).ready(function () {
        // getStart();
        // r_getStart();
        // resetSuccessSep();
        // r_resetSuccessReg();
        ajaxLoad();
        $('table .table').removeAttr('style');
    });
    
    // $(document).on('click', '#print-sep', function() {
    //     var print = $(this),
    //         no_reg = print.data('print'),
    //         url = '{{ url('admin/sep/print') }}/'+no_reg; 
    //     window.open(url, "_blank", "width=850, height=600");
    // });
    
    // $(document).on('click', '#print-rujukan', function() {
    //     var print = $(this),
    //         noSep = print.data('rujukan');
    //         url = '{{ url('admin/rujukan/print') }}/'+noSep;
    //     window.open(url, "_blank", "width=850, height=600");
    // })

    $(document).on('click', '#viewer-eklaim', function(e) {
      // e.preventDefault();
      var viewer = $(this).val();
      $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
      options = {
        'backdrop' : 'static'
      },
      $('#id-viewer').attr('src', viewer)
      $('#modal-viewer').modal(options);
    });

    function ajaxLoad(){
            var jnsRawat = $("input[name=jns_rawat]:checked").val();
            var tglSep = $("#tgl_sep_filter").val();
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
                        'tgl_sep': tglSep,
                        'search' : search
                    }
                },
                "columns": [
                    {"mData": "no"},
                    {"mData": "no_kartu"},
                    {"mData": "no_rm"},
                    {"mData": "nama_pasien"},
                    {"mData": "tgl_sep"},
                    {"mData": "sep"},
                    {"mData": "action"},
                    // {"mData": "checked"},
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
