@extends('layouts.simrs.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      Master
    </li>

    <li class="breadcrumb-item">
      <a href="{{ route('user.index') }}">Menejemen Bed</a>
    </li>
    <li class="breadcrumb-item active">Index</li>
</ol>
@endsection
@section('content')
<div class="col-md-12">
  <div class="card">
      <div class="card-header">
        @include('layouts.search.bedsearch')
      </div>
      <div class="card-body">
      
        <table class="table table-responsive-sm table-bordered table-striped table-sm table-hover" id="mytable">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Kelasa</th>
              <th>Kode Ruang</th>
              <th>Nama Ruang</th>
              <th>Kapasitas</th>
              <th>Tersedia</th>
              <th>Tersedia Pria</th>
              <th>Tersedia Wanita</th>
              <th>Tersedia Pria dan Wanita</th>
            </tr>
          </thead>
          <tbody>
           
          </tbody>
        </table>
       
      </div>
  </div>
</div>

@include('simrs.user.modals.modal_user')

@endsection
@push('css')
<!-- <link rel="stylesheet" href="{{ asset('core-u/css/bootstrap.min.css') }}" /> -->
<link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
@endpush
@push('scripts')
<script type="text/javascript" src="{{ asset('datatables/js/jquery.dataTables.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('datatables/js/dataTables.bootstrap4.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('jquery-ui/jquery-ui.min.js') }}" ></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"  integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
@include('simrs.user.modals.ajax')
<script type="text/javascript">

    $(document).ready(function () {
        $('.table').removeAttr('style');
        ajaxLoad();
    });

    $(document).on('click', '#post_bed', function(e) {
        var url = 'bed/post',
            method = 'GET';

            $.ajax({
                url: url,
                method: method,
                data: {},
                success: function(response) {
                    console.log(response);
                }
            })
    });

    function ajaxLoad(){
            var search = $("#search").val();
            // $.fn.dataTable.ext.errMode = 'throw';
            $('#mytable').dataTable({
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
                    "url": "{{ route('bed.search')}}",
                    "type": "GET",
                    "data": {                   
                        'search' : search
                    }
                },
                "columns": [
                    {"mData": "no"},
                    {"mData": "kodekelas"},
                    {"mData": "koderuang"},
                    {"mData": "namaruang"},
                    {"mData": "kapasitas"},
                    {"mData": "tersedia"},
                    {"mData": "tersediapria"},
                    {"mData": "tersediawanita"},
                    {"mData": "tersediapriawanita"}
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