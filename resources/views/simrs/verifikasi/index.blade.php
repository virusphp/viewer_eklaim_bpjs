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
    <li class="breadcrumb-menu d-md-down-none mfe-2">
      <div class="form-inline">
        {{-- @include('simrs.sep.partials.radio_faskes') --}}
        <form id="form-download" method="POST" action="{{ route('viewer.download') }}" class="form-inline">
        @csrf
        <div class="col-md-6">
          <div class="col-offset-3">
            <div class="form-group">
              <div class="input-group date {{ $errors->has('tgl_akhir') ? 'has-error' : '' }}" id="dt-awal" >
                  <label class="file-download">Tgl Awal </label>
                  <div class="input-group-append">
                      <span class="input-group-text input-group-addon">
                          <i class="fa fa-calendar"></i>
                      </span>
                  </div>                        
                  <input class="form-control" id="tgl_awal" 
                          value="{{ date('d-m-Y') }}" 
                          placeholder="Tanggal Awal" name="tgl_awal"
                          type="text"/>
                 
              </div>
            </div>
          </div>

        </div>

        <div class="col-md-6">
          <div class="col-offset-3">
            <div class="form-group">
              <div class="input-group date {{ $errors->has('tgl_akhir') ? 'has-error' : '' }}" id="dt-akhir" >
                  <label class="file-download">Tgl Akhir</label>
                  <div class="input-group-append">
                      <span class="input-group-text input-group-addon">
                          <i class="fa fa-calendar"></i>
                      </span>
                  </div>                        
                  <input class="form-control" id="tgl_akhir" 
                          value="{{ date('d-m-Y') }}" 
                          placeholder="Tanggal Akhir" name="tgl_akhir"
                          type="text"/>
                  <button type="button" id="download" class="btn btn-dark">
                    Download
                  </button>
              </div>
            
            </div>
          </div>
          
        </div>
        </form>
      </div>
    </li>
</ol>
@endsection
@section('content')
  <div class="card">
      <div class="card-header">
        @include('layouts.search.search')
      </div>
      <div class="card-body">
        <form action="#" id="form-checked" method="POST">
        <table class="table table-sm table-responsive-sm table-bordered table-striped table-hover" id="mytable">
          <thead>
            <tr>
              <th class="check-all" width="20"><input type="checkbox"> All</th>
              <th>No Kartu</th>
              <th>No Sep</th>
              <th>No RM</th>
              <th>Nama Pasien</th>
              <th>Tgl Sep</th>
              <th>Tgl Sep</th>
              <th>Tgl Pulang</th>
              <th>View</th>
              <th><button id="verif-all" type="button" class="btn btn-sm btn-outline-primary">Verif All</button></th>
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
        $('#dt-akhir').datetimepicker({
            format: 'D-M-Y'
        });
        $('#dt-awal').datetimepicker({
            format: 'D-M-Y'
        });
        $('#datetimepicker_sep').datetimepicker({
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


    // Verifikasi semua yang di checklist

    $('#verif-all').on('click', function() {
      var form = $("#form-checked");
      var checked = form.find('input#check-access[name="checkModule[]"]:checked'),
          nilai = checked.val();

      var noReg = [];
      checked.each(function(index) {
        noReg[index] = $(this).data('reg');
      })
      // console.log(checked);

      if (nilai == 1) {
        icon = "success";
        title = "Yakin Sudah di cek?!"
        pesan = "Jumlah Verified ada "+ checked.length + " sudah di cek!";
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
          // checked.each(function(index) {
            UnverifiedAll(nilai, noReg);
          // }) 
        } else {
          swal("Kamu Belum Review dan Verified!");
        }
        // ajaxLoad()
      });

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

    function UnverifiedAll(nilai, NoReg) {
      var url = 'viewer/verified/all/petugas', 
          token = $('meta[name="csrf-token"]').attr('content'),
          method = 'POST';

        $.ajax({
          url: url,
          method: method,
          data: { periksa: nilai, data: NoReg, _token: token },
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

    function sweetProses(title, pesan, icon, button) {
      swal({
        title: title,
        text:  pesan,
        icon: icon,
        buttons: button
      })
      .then((willVerified) => {
        if (willVerified) {
          $('#form-download').submit();
          swal({
            title: notif,
            text: 'Silahkan tunggu untuk proses download!',
            icon: "success",
          })
        } else {
          swal("Batal", "Tidak jadi download");
        }
      })
    }

    $('#download').on('click', function(e) {
      // e.preventDefault();
     
      var url = 'viewer/download',
          tglAwal = $('#tgl_awal').val(),
          tglAkhir = $('#tgl_akhir').val(),
          awal = new Date(tglAwal).getTime(), 
          akhir = new Date(tglAkhir).getTime(), 
          nilai = akhir - awal;
          form = $('#form-download');

          if (nilai >= 0) {
            icon = "success";
            title = "Yakin Sudah di cek?!"
            pesan = "Anda akan mendownload file dari tanggal " + tglAwal + " Sampai " + tglAkhir ;
            notif = "Sukses!, Kamu berhasil melakukan proses download mohon tunggu!";
            sweetProses(title,pesan,icon,true)
          } else {
            swal("Error", " Tidak bisa DOWNLOAD, Tanggal awal " +tglAwal+ " lebih besar dari tanggal akhir "+ tglAkhir)
          } 


    ;

          // $.ajax({
          //   url:ur.getContent()l,
          //   method:method,
          //   data: form.serialize(),
          //   success: function(response) {
          //     console.log(response)
          //     window.location = response;
          //   }
          // })
    })

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
                        'tgl_plg': tglPlg,
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
                    {"mData": "no_kartu", "width": "15"},
                    {"mData": "sep", "width": "15"},
                    {"mData": "no_rm"},
                    {"mData": "nama_pasien"},
                    {"mData": "tgl_sep"},
                    {"mData": "tgl_sep"},
                    {"mData": "tgl_plg"},
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
