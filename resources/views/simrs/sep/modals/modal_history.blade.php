<!-- modal User -->
<div class="modal fade" id="modal-history-peserta" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-md modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <div class="col-md-6">
        <h5 class="modal-title" id="edit-modal-register">History Kunjungan Pasien </h5>
      </div>
      <div class="col-md-4">
        <!-- <input class="form-control-plaintext" type="text" id="tglSep" nama="tgl_reg" readonly> -->
      </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <!-- Akun Pegawai -->
            <div class="col-sm-2">
                <div class="card">
                    <div class="card-header">
                        <strong>Data</strong>
                        <small>Peserta</small>
                    </div>
                    <div class="card-body">
                        <img src="{{ asset('img/default_user.png') }}" alt="..." class="img-thumbnail">
                        <div class="form-group clearfix">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="form-group col-sm-10" id="x-no-rm">
                                        <label for="v-no-rm">No RM</label>
                                    </div>
                                    <div class="form-group col-sm-10" id="x-no-kartu">
                                        <label for="v-no-kartu">No Kartu</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Detail Pegawai -->
            <div id="data-user" class="col-sm-10">
                <div class="card">
                    <div class="card-header">
                        <strong>Daetail</strong>
                        <small>History Peserta</small>
                    </div>
                    <div class="card-body">
                        <table id="tabel-history-peserta" class="table table-responsive-sm table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>No Sep</th>
                                    <th>Tgl Sep</th>
                                    <th>Jns Rawat</th>
                                    <th>Poli</th>
                                    <th>No Rujukan</th>
                                    <th>Faskes</th>
                                </tr>
                            </thead>
                            <tbody id="isi-history">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>