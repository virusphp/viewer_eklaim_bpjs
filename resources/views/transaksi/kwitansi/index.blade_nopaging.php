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
        <!-- <strong class="controls align-middle">Kwitansi</strong> -->
        @include('layouts.search.datepicker') 
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm table-hover">
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
          <tbody id="table">
            @foreach($kwitansi as $data)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $data->no_kwitansi }}</td>
              <td>{{ tanggal($data->tgl_kwitansi) }}</td>
              <td>{{ $data->jenis_pasien }}</td>
              <td>{{ $data->jenis_rawat }}</td>
              <td>{{ $data->untuk }}</td>
              <td>{{ rupiah($data->tagihan) }}</td>
              <td>
                  <a href="{{ route('kwitansi.get', $data->no_kwitansi) }}" id="mtagihan" class="btn btn-success btn-sm">
                    <i class="icon-eye icons"></i> view
                  </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <nav>
          <ul class="pagination justify-content-end" id="pagination">
            <!-- {!! $kwitansi->appends(Request::all())->links() !!} -->
          </ul>
        </nav>
        <!-- {!! $kwitansi->appends(Request::all())->links() !!} -->
      </div>
  </div>
</div>

@endsection
@push('css')
<!-- <link rel="stylesheet" href="{{ asset('core-u/css/bootstrap.min.css') }}" /> -->
<link rel="stylesheet" href="{{ asset('core-ui/datepicker/css/bootstrap-datetimepicker.min.css') }}" />
@endpush
@push('scripts')
<script type="text/javascript" src="{{ asset('core-ui/moment/min/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('core-ui/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('core-ui/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker').datetimepicker({
            format: 'D-M-Y'
        });
    });

  //  $(document).on('submit', 'form#frm', function (event) {
  //   event.preventDefault();
  //   var form = $(this);
  //   var data = new FormData($(this)[0]);
  //   var url = form.attr("action");
  //   $.ajax({
  //       type: form.attr('method'),
  //       url: url,
  //       data: data,
  //       cache: false,
  //       contentType: false,
  //       processData: false,
  //       success: function (data) {
  //           $('.is-invalid').removeClass('is-invalid');
  //           if (data.fail) {
  //               for (control in data.errors) {
  //                   $('#' + control).addClass('is-invalid');
  //                   $('#error-' + control).html(data.errors[control]);
  //               }
  //           } else {
  //               ajaxLoad(data.redirect_url);
  //           }
  //       },
  //       error: function (xhr, textStatus, errorThrown) {
  //           alert("Error: " + errorThrown);
  //       }
  //     });
  //     return false;
  //   });

    
    function ajaxLoad() {
        // content = typeof content !== 'undefined' ? content : 'content';
        // $('.loading').show();
        var jnsRawat = $("#jns_rawat").val();
        var jnsPasien = $("#jns_pasien").val();
        var tgl= $("#tgl").val();
        $.ajax({
            type: "GET",
            data: {
                'jns_pasien': jnsPasien,
                'jns_rawat': jnsRawat,                
                'tgl': tgl
            },
            url:"{{ route('kwitansi.search')}}",
            contentType: false,
            success: function (data) {
                $('#table').html(data);
                // location.reload();
                // $('#pagination').html(pagination(data,pageSelected,'displayData',perPage));
                // $('.loading').hide();
                // if(data.success=='true'){
                //   var html = '<ul>';
                //   $.each( data.kwitansi , function( i , kwitansi ){    
                //       html += '<li><a href="/admin/transksi/kwitansi/'+ kwitansi.no_kwitansi +'"><b>' + kwitansi.no_kwitansi+ '</b></a></li>';});
                //   html += '</ul>';
                // }
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

</script>
@endpush