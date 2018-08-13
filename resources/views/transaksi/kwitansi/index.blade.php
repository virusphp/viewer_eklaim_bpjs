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
        <strong class="controls align-middle">Kwitansi</strong>
        @include('layouts.search.datepicker') 
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>No Kwitansi</th>
              <th>Tanggal Kwitansi</th>
              <th>Untuk</th>
              <th>Tagihan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($kwitansi as $data)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $data->no_kwitansi }}</td>
              <td>{{ tanggal($data->tgl_kwitansi) }}</td>
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
        {!! $kwitansi->appends(Request::all())->links() !!}
      </div>
  </div>
</div>

@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('core-ui/css/bootstrap.min.css') }}" />
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

</script>
@endpush