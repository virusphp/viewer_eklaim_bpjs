@extends('layouts.akunting.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      Master
    </li>

    <li class="breadcrumb-item">
      <a href="{{ url('/admin/home') }}">Akun Perkiraan</a>
    </li>
    <li class="breadcrumb-item active">Index</li>
</ol>
@endsection
@section('content')
<div class="col-md-12">
  <div class="card">
      <div class="card-header">
        <strong class="controls align-middle">Akun Perkiraan</strong>
        @include('layouts.search.search') 
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>No Perkiraan</th>
              <th>Nama Perkiraan</th>
            </tr>
          </thead>
          <tbody>
            @foreach($ak_perkiraan as $data)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $data->no_perkiraan }}</td>
              <td>{{ $data->nama_perkiraan }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {!! $ak_perkiraan->links() !!}
      </div>
  </div>
</div>

@endsection