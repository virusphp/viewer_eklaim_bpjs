@extends('layouts.akunting.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      Master
    </li>

    <li class="breadcrumb-item">
      <a href="{{ route('kwitansi') }}">Kwitansi </a>
    </li>
    <li class="breadcrumb-item active">Index</li>
</ol>
@endsection
@section('content')
<div class="col-md-12">
<div class="card">
      <div class="card-header">
        Kwitansi Details
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>No Akun</th>
              <th>Nama Akun</th>
              <th>Keterangan</th>
              <th>Debet</th>
              <th>Kredit</th>
            </tr>
          </thead>
          <tbody>
            <?php $kre = 0 ?>
            <tr>
              <td>#</td>
              <td>{{ $debet->no_perkiraan }}</td>
              <td>{{ $debet->nama_perkiraan }}</td>
              <td>{{ $debet->untuk }}</td>
              <td>{{ rupiah($debet->debet) }}</td>
              <td>{{ rupiah($debet->kredit) }}</td>
            </tr>
            @foreach($kredit as $data)
           <tr>
              <td>#</td>
              <td>{{ $data->no_perkiraan_8 }}</td>
              <td>{{ $data->nama_perkiraan }}</td>
              <td>{{ $data->nama_tarif }}</td>
              <td></td>
              <td>{{ rupiah($data->tagihan) }}</td>
            </tr>
            <?php $kre += $data->tagihan ?>
            @endforeach
            <td colspan="4" class="text-center">Total Kredit</td>
            <td><strong>{{ rupiah($debet->debet) }}</strong></td>
            <td><strong>{{ rupiah($kre) }}</strong></td>
            <td><strong>{{ if ($debet->debet == $kre) ? 'Balance' : 'Not Balance' }}</strong></td>
          </tbody>
        </table>
        <div class="float-right"><button class="btn btn-sm btn-success" onclick="goBack()">BUAT</button></div>
  </div>
</div>
@endsection
@push('scripts')
<script>
function goBack() {
    window.history.back();
}
</script>
@endpush