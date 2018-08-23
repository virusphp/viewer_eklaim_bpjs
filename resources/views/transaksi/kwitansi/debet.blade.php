<div class="card">
      <div class="card-header">
        Kwitansi Header
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>No Kwitansi</th>
              <th>Jenis Pasien</th>
              <th>Jenis Rawat</th>
              <th>Keperluan</th>
              <th>Tagihan</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
           <tr>
              <td>#</td>
              <td>{{ $debet->no_kwitansi }}</td>
              <td>{{ $debet->jenis_pasien }}</td>
              <td>{{ $debet->jenis_rawat }}</td>
              <td>{{ $debet->untuk }}</td>
              <td>{{ rupiah($debet->debet) }}</td>
              <td>{{ $debet->status_bayar }}</td>
            </tr>
            <td colspan="4" class="text-center">Total Debet</td>
            <td><strong></strong></td>
            <td><strong>{{ rupiah($debet->tagihan) }}</strong></td>
            <td><strong></strong></td>
            <td class="badge badge-success"></td>
          </tbody>
        </table>
  </div>
</div>