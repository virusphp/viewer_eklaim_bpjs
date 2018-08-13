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
        @include('master.search.search') 
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>No Kwitansi</th>
              <th>Nama Pasien</th>
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
              <td>{{ $data->nama_pasien }}</td>
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