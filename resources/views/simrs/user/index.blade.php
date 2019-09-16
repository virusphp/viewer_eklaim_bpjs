@extends('layouts.verifikasi.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      Master
    </li>

    <li class="breadcrumb-item">
      <a href="{{ route('user.index') }}">User Manajemen</a>
    </li>
    <li class="breadcrumb-item active">Index</li>
</ol>
@endsection
@section('content')
<div class="col-md-12">
    <div id="frame_user_success" class="alert alert-success">

    </div>
    <div id="frame_user_error" class="alert alert-danger">

    </div>
  <div class="card">
      <div class="card-header">
        @include('layouts.search.usersearch')
      </div>
      <div class="card-body">
      
        <table class="table table-responsive-sm table-bordered table-striped table-sm table-hover" id="mytable">
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Nama Pegawai</th>
              <th>Role</th>
              <th>Aksi</th>
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
        getStart();
        resetSuccessUser();
        $('.table').removeAttr('style');
        ajaxLoad();
    });

    // simpan user akun
    $(document).on('click', '#simpan-user', function (e) {
        var form = $('#form-user'),
            url = '{{ route('user.simpan') }}',
            method = 'POST';
        console.log(form);
        $.ajax({
            url: url,
            method: method,
            data: form.serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status == 'success') {
                    $('#frame_user_success').show().html("<span class='text-success' id='success_user'></span>");
                        $('#success_user').html(response.message).hide()
                        .fadeIn(1500, function() { $('#success_user'); });
                        setTimeout(resetSuccessUser,4000);
                        ajaxLoad();
                }
                $('#modal-user').modal('hide');
            }, 
            error : function(xhr) {
                var errors = xhr.responseJSON; 
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

     // simpan user akun
    $(document).on('click', '#delete-user', function (e) {
        var kode = $(this).data('user'),
            url = '{{ route('user.delete') }}',
            token = $('meta[name="csrf-token"]').attr('content'),
            method = 'DELETE';
        $.ajax({
            url: url,
            method: method,
            data: { kode: kode , _token: token },
            success: function(response) {
                if (response.status == 'success') {
                    $('#frame_user_success').show().html("<span class='text-success' id='success_user'></span>");
                        $('#success_user').html(response.message).hide()
                        .fadeIn(1500, function() { $('#success_user'); });
                        setTimeout(resetSuccessUser,4000);
                        ajaxLoad();
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON; 
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

    // cari pegawai
    $(document).ready(function() {
            var url = "{{ route('user.pegawai') }}";
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#nama_pegawai').autocomplete({
                source : function (request, response) {
                    $.ajax({
                        url : url,
                        dataType : "json",
                        data : { term: request.term },
                        success: function(data) {
                            var array = data.error ? [] : $.map(data, function(m) {
                                return {
                                    id : m.kd_pegawai,
                                    value : m.nama_pegawai,
                                    alamat : m.alamat,
                                    tglLahir : m.tgl_lahir,
                                    tmptLahir : m.tempat_lahir,
                                    unitKerja : m.unit_kerja,
                                    foto : m.foto
                                };
                            });
                            response(array);
                        }
                    });
                },
                minLength: 3,
                select : function (event, ui) {
                    $('#nama_pegawai').val(ui.item.value);
                    $('#username').val(ui.item.id).attr('readonly', true);
                    $('#v-username').val(ui.item.id).attr('readonly', true);
                    $('#v-nama').val(ui.item.value).attr('readonly', true);
                    $('#v-alamat').val(ui.item.alamat).attr('readonly', true);
                    $('#v-tgl-lahir').val(ui.item.tglLahir).attr('readonly', true);
                    $('#v-tmpt-lahir').val(ui.item.tmptLahir).attr('readonly', true);
                    $('#v-unit-kerja').val(ui.item.unitKerja).attr('readonly', true);
                    // $('#v-foto').attr('src', 'data:image/jpeg;base64,'+ui.item.foto);
                    $('#v-foto').attr('src', '{{ asset('images/user') }}/'+ui.item.foto);
                    return false;
                },
                autoFocus: true
            });
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
                    "url": "{{ route('user.search')}}",
                    "type": "GET",
                    "data": {                   
                        'search' : search
                    }
                },
                "columns": [
                    {"mData": "no"},
                    {"mData": "kd_pegawai"},
                    {"mData": "nama_pegawai"},
                    {"mData": "role"},
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