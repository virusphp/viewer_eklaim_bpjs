@extends('layouts.verifikasi.app')

@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item">
     <a href="{{ route('export.index') }}">Laporan</a> 
    </li>
  </ol>
</nav>
@endsection
@section('content')
  <div class="card">
      <div class="card-header">
        @include('layouts.search.export')
      </div>
      <div class="card-body">
        <table class="table table-sm table-responsive-sm table-bordered table-striped table-hover" id="tabel-laporan">
          <thead>
            <tr>
              <th>No Sep</th>
              <th>No RM</th>
              <th>Nama Pasien</th>
              <th>Tgl Sep</th>
              <th>Tgl Pulang</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
           
          </tbody>
        </table>
      </div>
  </div>

@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}" />

@endpush
@push('scripts')

<script type="text/javascript" src="{{ asset('datatables/js/jquery.dataTables.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('datatables/js/dataTables.select.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('datatables/js/dataTables.bootstrap4.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('jquery-ui/jquery-ui.min.js') }}" ></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>

<script type="text/javascript">
    function getId(id) {
        return document.getElementById(id);
    }

    function getName(name) {
        return document.getElementsByName(name);
    }

    function getData(el, data) {
        return el.getAttribute(data);
    }

    function setSelected(id, value){
        getId(id).value = value;
        return getId(id).dispatchEvent(new Event('change'));
    }

    function getJenisRawat(noReg) {
        return noReg.substring(0,2);
    }

    function tanggalIndo(tanggal) {
        return moment(tanggal, "DD-MM-YYYY").format('DD-MMMM-YYYY');
    }

    function appendSpan(id, value) {
        let node = document.createElement("span");
        let textNode = document.createTextNode(value);
        node.appendChild(textNode);
        return getId(id).appendChild(node);
    }

    $(function () {
        $('#dt-akhir').datetimepicker({
            format: 'Y-M-D'
        });
        $('#dt-awal').datetimepicker({
            format: 'Y-M-D'
        });
    });

    $(document).ready(function () {
        ajaxLoad();
        // $('table .table').removeAttr('style');
    });

    function formatDate(date) {
      return date.split("-").reverse().join("-");
    }

    $('#dt-akhir').on("dp.change", function() {
      ajaxLoad()
    })

    $('#status-claim').on('change', function() {
      ajaxLoad()
    })

    $('#export-eklaim').on('click', function() {
      let status = getId('status-claim').value;
      var jns_rawat = $("input[name=jns_rawat]:checked").val();
      var tglawal = formatDate($("#tgl_awal").val());
      var tglakhir = formatDate($("#tgl_akhir").val());

        if (jns_rawat == '01') {
          jnsRawat = "Rawat Jalan"
        } else if (jns_rawat == '02') {
          jnsRawat = "Rawat Inap"
        } else {
          jnsRawat = "Rawat Darurat"
        }
  
       swal({
          title: 'Anda akan mengeksport data ke excel??',
          text: "Tanggal: "+tglawal+" Sampai "+tglakhir+"  Jenis Rawat: "+jnsRawat,
          icon: 'success',
          buttons: true
        }).then((willVerified) => {
          if (willVerified) {
                  $('#form-export').submit();
                  swal({
                    title : "Sukses!!!",
                    text: "Data berhasil di export",
                    icon: "success" 
                  })
          } else {
            swal( 'Dibatalkan', 'Data Eklaim terpilih batal di export:)', 'error')
          }
        })
  })

    function ajaxLoad(){
          let status = getId('status-claim').value;
          var jnsRawat = $("input[name=jns_rawat]:checked").val();
          var tglawal = formatDate($("#tgl_awal").val());
          var tglakhir = formatDate($("#tgl_akhir").val());
          var nilaiAwal = new Date(tglawal);
          var nilaiAkhir = new Date(tglakhir);
          console.log(status);
          if (Date.parse(nilaiAwal) >  Date.parse(nilaiAkhir)) 
          {
            swal("INFO!!!", "Tanggal awal tidak boleh lebih besar dari tanggal akhir!!");
          } else {
            $('#tabel-laporan').DataTable({
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
                    "url": "search",
                    "type": "GET",
                    "data": {                   
                        'jns_rawat': jnsRawat,
                        'tgl_awal': tglawal,
                        'tgl_akhir': tglakhir,
                        'status_claim': status
                    }
                },
                "columns": [
                    {"mData": "no_sep", "width": "15"},
                    {"mData": "no_rm"},
                    {"mData": "nama_pasien"},
                    {"mData": "tgl_sep"},
                    {"mData": "tgl_pulang"},
                    {"mData": "status"}
                ]
            });

            $('#searchInput').keyup(function(){
                table.search($(this).val()).draw() ;
            }); 
          }
          
        }   
</script>
@endpush
