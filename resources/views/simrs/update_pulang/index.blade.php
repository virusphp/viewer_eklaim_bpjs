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
      @include('layouts.search.risearch')
      </div>
      <div class="card-body">
      
        <table class="table table-responsive-sm table-bordered table-striped table-sm table-hover" id="mytable">
          <thead>
            <tr>
              <th>No</th>
              <th>No Reg</th>
              <th>No RM</th>
              <th>Nama Pasien</th>
              <th>Tanggal Masuk</th>
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

@include('simrs.update_pulang.modals.modal_pulang_sep')

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
        $('#dtglPulang').datetimepicker({
            format: 'D-M-Y'
        });
        $('#datetimepicker').datetimepicker({
            format: 'D-M-Y'
        });
    });

    $(document).ready(function () {
        resetSuccessSep();
        $('.table').removeAttr('style');
        ajaxLoad();
    });

    $('#modal-pulang-sep').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        // $('#tglPulang').val("").datepicker('update','');
        // $('#tglPulang').datepicker({
        //     clearBtn: true
        // });
        alertas.find('.error').removeClass('error');
    });

    $(document).on('click','#edit-pulang', function() {
        $(this).addClass('edit-item-trigger-clicked');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content'),
            noSep = $(this).data('sep'),
            noReg = $(this).val(),
            options = {
                'backdrop' : 'static'
            };
           $('#noSep').val(noSep);
           $('#noReg').val(noReg);
        $('#modal-pulang-sep').modal(options);
    });

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
                    $('#frame_error').show().html("<span class='text-danger' id='error_sep'></span>");
                    $('#error_sep').html("No Sep: "+$('#noSep').val()+" "+data.metaData.message).hide()
                    .fadeIn(1500, function() { $('#error_sep'); });
                    setTimeout(resetAll,5000);
                }
            }
        })
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
                    "url": "{{ route('sep.ri.search')}}",
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
                    {"mData": "aksi", "width": "3%"}
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
