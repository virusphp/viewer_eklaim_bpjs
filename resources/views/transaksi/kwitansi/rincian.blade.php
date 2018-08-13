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
         INVOICE #{{ $kwitansi[0]->no_kwitansi }} 
         <div class="float-right">
            <div class="controls">
              <div class="input-group">
                <button class="btn btn-dark" onclick="goBack()">BACK</button>
              </div>
            </div>
         </div>
      </div>
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-sm-4">
           <div> #Dari </div>
           <div><strong>{{ $kwitansi[0]->no_rm }}</strong> </div>
          </div>
          <div class="col-sm-4">
            <div> #Pembayaran</div>
          </div>
          <div class="col-sm-4">
            <div> #Detail</div>
            <div> Invoice #{{ $kwitansi[0]->no_kwitansi }}</div>
          </div>
        </div>
        <table class="table table-responsive-block table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>No Bukti</th>
              <th>Kelompok</th>
              <th>Unit</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Tunai</th>
              <th>Piutang</th>
              <th>Tagihan</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php $total = 0 ?>
            @foreach($kwitansi as $data)
           <tr>
              <td>#</td>
              <td>{{ $data->no_bukti }}</td>
              <td>{{ $data->kelompok }}</td>
              <td>{{ $data->kd_sub_unit }}</td>
              <td>{{ rupiah($data->harga) }}</td>
              <td>{{ $data->jumlah }}</td>
              <td>{{ rupiah($data->tunai) }}</td>
              <td>{{ rupiah($data->piutang) }}</td>
              <td>{{ rupiah($data->tagihan) }}</td>
              <td>
                <span class="badge badge-{{ $data->status_bayar == 'SUDAH' ? 'success' : 'secondary' }}">
                  {{ $data->status_bayar }}
                </span>
              </td>
            </tr>
            <?php $total += $data->tagihan ?>
            @endforeach
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Total</td>
            <td>{{ rupiah($total) }}</td>
            <td></td>
          </tbody>
        </table>
      </div>
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