@extends('layouts.verifikasi.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      Master
    </li>

    <li class="breadcrumb-item">
      <a href="{{ route('viewer.index') }}">Viewer</a>
    </li>
    <li class="breadcrumb-item active">Index</li>
    <li class="breadcrumb-menu d-md-down-none">
    </li>
</ol>
@endsection
@section('content')
  <div class="card">
      <div class="card-header">
        @include('layouts.search.search')
      </div>
      <div class="card-body">
        <form action="#" id="form-checked">
        <table class="table table-sm table-responsive-sm table-bordered table-striped table-hover" id="mytable">
          <thead>
            <tr>
              <th class="check-all" width="20"><input type="checkbox"> All</th>
              <th>No Kartu</th>
              <th>No Sep</th>
              <th>No RM</th>
              <th>Nama Pasien</th>
              <th>Tgl Pulang</th>
              <th>Tgl Sep</th>
              <th>View</th>
              <th><button id="verif-all" type="submit" class="btn btn-sm btn-outline-primary">Verif All</button></th>
              <th>User</th>
            </tr>
          </thead>
          <tbody>
           
          </tbody>
        </table>
        </form>
      </div>
  </div>

@include('simrs.verifikasi.modals.modal_viewer')

@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}" />

@endpush
@push('scripts')

<script type="text/javascript" src="{{ asset('datatables/js/jquery.dataTables.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('datatables/js/dataTables.select.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('datatables/js/dataTables.bootstrap4.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('jquery-ui/jquery-ui.min.js') }}" ></script>
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"  integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> -->
<script src="{{ asset('js/sweetalert.min.js') }}"></script>

{{-- @include('simrs.verifikasi.modals.ajax') --}}
{{-- @include('simrs.verifikasi.modals.ajax_register') --}}
<script type="text/javascript">
    $(function () {
        $('#datetimepicker_sep').datetimepicker({
            format: 'D-M-Y'
        });
        $('#datetimepicker_plg').datetimepicker({
            format: 'D-M-Y'
        });
        $('#dtgl_kejadian').datetimepicker({
            format: 'D-M-Y'
        });
        $('#dtglPulang').datetimepicker({
            format: 'D-M-Y'
        });
    });

    $(document).ready(function () {
        // r_resetSuccessReg();
        ajaxLoad();
        $('table .table').removeAttr('style');
    });

    $('#form-checked').on('submit', function() {
      var form = this;
      console.log(form);
    })
    
    $(document).on('click', '#verifikasi-eklaim', function() {
      var nilai = $(this).val(),
          no_reg = $(this).data("reg");
          if (nilai == 1) {
            icon = "success";
            title = "Yakin Sudah di cek?!"
            pesan = "Klik tombol OK jika sudah di cek!";
            notif = "Sukses!, Kamu berhasil Review dan Verified!";
          } else {
            icon = "warning";
            title = "Yakin ingin mereview ulang?!"
            pesan = "Klik tombol OK jika ingin di cek ulang!";
            notif = "Sukses!, Kamu membatalkan review dan veried!";
          }
      swal({
        title: title,
        text:  pesan,
        icon: icon,
        buttons: true
      })
      .then((willVerified) => {
        if (willVerified) {
          swal(notif, {
            icon: "success",
          });
          Uverified(nilai, no_reg);
        } else {
          swal("Kamu Belum Review dan Verified!");
        }
      });
    })

    function Uverified(nilai, no_reg)
    {
      var nilai = nilai,
        no_reg = no_reg,
        url = 'viewer/verified/petugas',
        token = $('meta[name="csrf-token"]').attr('content'),
        method = 'POST';
        $.ajax({
          url: url,
          method: method,
          data: { periksa: nilai, no_reg: no_reg, _token: token },
          success: function(response) {
              if (response.kode === 200) {
                $('#mytable').DataTable().ajax.reload();
              }
          },
          error: function(xhr) {
            console.log(xhr);
          }
        })
    }

    $(document).on('click', '#viewer-eklaim', function(e) {
      var viewer = $(this).val();
      $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
      options = {
        'backdrop' : 'static'
      },
      $('#id-viewer').attr('src', viewer)
      $('#modal-viewer').modal(options);
    });

    $('#modal-viewer').on('hidden.bs.modal', function(){
        $('#id-viewer').remove();
        $('#viewer').append('<embed id="id-viewer" src=""#toolbar=1&navpanes=0&scrollbar=0" type="application/pdf" width="1020" height="500">');
    });

    function ajaxLoad(){
            var jnsRawat = $("input[name=jns_rawat]:checked").val();
            var tglSep = $("#tgl_sep_filter").val();
            var tglPlg = $("#tgl_plg_filter").val();
            var search = $("#search").val();
            // $.fn.dataTable.ext.errMode = 'throw';
           var tabel = $('#mytable').DataTable({
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
                    "url": "viewer/search",
                    "type": "GET",
                    "data": {                   
                        'jns_rawat': jnsRawat,
                        'tgl_sep': tglSep,
                        'search' : search
                    }
                },
                "drawCallback": function() {
                  // $('input#ver-eklaim').iCheck({
                  //   checkboxClass: 'icheckbox_square-green'
                  // });
                  // $('input.check-access').iCheck({
                  //   checkboxClass: 'icheckbox_square-yellow'
                  // });
                  // $('input.all').iCheck({
                  //   checkboxClass: 'icheckbox_square-blue'
                  // });
                  $('input[type="checkbox"]').iCheck({
                    checkboxClass : 'icheckbox_square-blue'
                  })
                },
                'columnDefs': [
                  {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true,
                        'selectCallback': function(nodes, selected){
                            $('input[type="checkbox"]', nodes).iCheck('update');
                            $('input#ver-ekalim', nodes).iCheck('update');
                            
                            // $('input.check-modules', nodes).iCheck('update');
                        },
                        'selectAllCallback': function(nodes, selected, indeterminate){
                            $('input[type="checkbox"]', nodes).iCheck('update');
                            $('input#ver-eklaim', nodes).iCheck('update');
                            // $('input.check-modules', nodes).iCheck('update');
                        }
                      }
                  }
                ],
                'select': 'multi',
                "order" : [[1, "asc"]],
                "columns": [
                    {"mData": "list_check"},
                    {"mData": "no_kartu"},
                    {"mData": "sep", "width": "25"},
                    {"mData": "no_rm"},
                    {"mData": "nama_pasien"},
                    {"mData": "tgl_plg"},
                    {"mData": "tgl_sep"},
                    {"mData": "aksi"},
                    {"mData": "checked"},
                    {"mData": "user"},
                ]
            });

            $('#searchInput').keyup(function(){
                table.search($(this).val()).draw() ;
                // $('.table').removeAttr('style');
            }); 

            $(tabel.table().container()).on('ifChanged ifUnchecked', '.check-all input[type="checkbox"]', function(event) {
              // console.log(event.type);
              var cell = tabel.cells().nodes('td');
              var checkboxes =  $(cell).find('input.check-access');
              if (event.type == 'ifChanged') {
                checkboxes.iCheck('check');
              } else {
                checkboxes.iCheck('uncheck');
              }
              // console.log(event);
            });
         
           
        }   
</script>
{{-- @include('simrs.verifikasi.script') --}}
@endpush
