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
        JURNAL
         <div class="float-right">
            <div class="controls">
              <div class="input-group">
                <button class="btn btn-sm btn-dark" onclick="goBack()">BACK</button>
              </div>
            </div>
         </div>
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>No Akun</th>
              <th>Nama Akun</th>
              <th>Debet</th>
              <th>Kredit</th>
              <th>Keterangan</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php $kre = 0 ?>
            <?php $deb = 0 ?>
            @foreach($kwitansi as $data)
           <tr>
              <td>#</td>
              <td>{{ $data->no_perkiraan }}</td>
              <td>{{ $data->nama_perkiraan }}</td>
              <td>{{ rupiah($data->debet) }}</td>
              <td>{{ rupiah($data->kredit) }}</td>
              <td>{{ $data->untuk }}</td>
              <td>
              </td>
            </tr>
            <?php $kre += $data->kredit ?>
            <?php $deb += $data->debet ?>
            @endforeach
            <td colspan="3" class="text-center">Total</td>
            <td><strong>{{ rupiah($deb) }}</strong></td>
            <td><strong>{{ rupiah($kre) }}</strong></td>
            <td><strong></strong></td>
            <td class="badge badge-{{ $deb == $kre ? 'success': 'secondary' }}"><?php echo $deb == $kre ? 'Balance' : 'Not Balance'; ?></td>
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