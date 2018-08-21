@extends('layouts.akunting.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      Master
    </li>

    <li class="breadcrumb-item">
      <a href="{{ route('kwitansi') }}">Kwitansi</a>
    </li>
    <li class="breadcrumb-item active">Index</li>
</ol>
@endsection
@section('content')
<div class="col-md-12">
  <div class="card">
      <div class="card-header">
        @include('layouts.search.datepicker') 
      </div>
      <div class="card-body">
      
        <table class="table table-responsive-sm table-bordered table-striped table-sm table-hover" id="mytable">
          <thead>
            <tr>
              <th>No</th>
              <th>No Kwitansi</th>
              <th>Tanggal Kwitansi</th>
              <th>Jenis Pasien</th>
              <th>Jenis Rawat</th>
              <th>Untuk</th>
              <th>Tagihan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
           
          </tbody>
        </table>       
        
      </div>
  </div>
</div>

@endsection
@push('css')

<link rel="stylesheet" href="{{ asset('core-ui/datepicker/css/bootstrap-datetimepicker.min.css') }}" />
@endpush
@push('scripts')
<script type="text/javascript" src="{{ asset('core-ui/moment/min/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('core-ui/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('core-ui/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('datatables/js/jquery.dataTables.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('datatables/js/dataTables.bootstrap4.min.js') }}" ></script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker').datetimepicker({
            format: 'D-M-Y'
        });
    });
    $(document).ready(function () {
      $('.table').removeAttr('style');
    //   ajaxLoad();
    });

    function ajaxLoad(){
        var jnsPasien = $("#jns_pasien").val();
        var jnsRawat = $("#jns_rawat").val();
        var tgl = $("#tgl").val();
        $.fn.dataTable.ext.errMode = 'throw';
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
                "sEmptyTable": "Data tidak tersedia"
            },           
            "ajax": {
                "url": "{{ route('kwitansi.search')}}",
                "type": "GET",
                "data": {                   
                      'jns_pasien': jnsPasien,
                      'jns_rawat': jnsRawat,                
                      'tgl': tgl
                }
            },
            "columns": [
                  {"mData": "no"},
                  {"mData": "no_kwitansi"},
                  {"mData": "tgl_kwitansi"},
                  {"mData": "jenis_pasien"},
                  {"mData": "jenis_rawat"},
                  {"width": "30%", "mData": "untuk"},
                  {"mData": "jml_tagihan"},
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