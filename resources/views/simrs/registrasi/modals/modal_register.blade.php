<!-- modal User -->
<div class="modal fade" id="modal-register" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-md modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <div class="col-md-6">
        <h5 class="modal-title" id="edit-modal-register">Registrasi Pasien Rawat Jalan </h5>
      </div>
      <div class="col-md-4">
        <!-- <input class="form-control-plaintext" type="text" id="tglSep" nama="tgl_reg" readonly> -->
      </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-pasien" action="" class="form-horizontal" method="POST">
        <!-- <div id="frame_error" class="alert alert-danger">
          
        </div> -->
      
        <div class="row">
            <!-- Akun Pegawai -->
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <strong>Pendaftaran</strong>
                        <small>Pasien</small>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="no_rm">No Rekam Medis</label>
                            <input class="form-control form-control-sm" id="no_rm" name="no_rm" type="text" placeholder="No Reka Medis">
                            <input class="form-control form-control-sm" name="_token" type="hidden" value="{{ csrf_token() }}">
                        </div>
                        <div class="form-group">
                            <label for="poli">Poliklinik</label>
                            <select id="poli" name="poli" class="form-control form-control-sm">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tarif">tarif</label>
                            <input class="form-control form-control-sm" id="tarif" name="tarif" type="text" placeholder="Tarif">
                        </div>
                        <div class="form-group">
                            <label for="dokter">dokter</label>
                            <input class="form-control form-control-sm" id="kdDokter" name="kdDokter" type="text" placeholder="Dokter">
                        </div>
                        <div class="form-group">
                            <label for="jnsPasien">Jenis Pasien</label>
                            <select id="jnsPasien" name="jnsPasien" class="form-control form-control-sm">
                                    <option value="">-- Pilih Pembayaran --</option> 
                                    <option value="jan">jan</option> 
                                    <option value="mata">mata</option> 
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Detail Pegawai -->
            <div id="data-user" class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <strong>Daetail</strong>
                        <small>Profil Peserta</small>
                    </div>
                    <div class="card-body">
                        <div class="form-group clearfix">
                            <div class="col-sm-12">
                                <table>
                                    <tr>
                                        <th>No RM</th>
                                        <td>:</td>
                                        <td><input type="text" id="v-no-rm"></td>
                                    </tr>
                                    <tr>
                                        <th>Nama</th>
                                        <td>:</td>
                                        <td><input type="text" id="v-nama-pasien"></td>
                                    </tr> 
                                    <tr>
                                        <th>Alamat</th>
                                        <td>:</td>
                                        <td><input type="text" id="v-alamat-reg"></td>
                                    </tr> 
                                    <tr>
                                        <th>Kelamin</th>
                                        <td>:</td>
                                        <td><input type="text" id="v-jns-kel"></td>
                                    </tr> 
                                    <tr>
                                        <th>Tgl Lahir</th>
                                        <td>:</td>
                                        <td><input type="text" id="v-tgl-lahir"></td>
                                    </tr> 
                                    <tr>
                                        <th>Tmpt Lahir</th>
                                        <td>:</td>
                                        <td><input type="text" id="v-tmpt-lahir"></td>
                                    </tr> 
                                    <tr>
                                        <th>No Telp</th>
                                        <td>:</td>
                                        <td><input type="text" id="v-no-telp"></td>
                                    </tr> 
                                    <tr>
                                        <th>No BPJS</th>
                                        <td>:</td>
                                        <td><input type="text" id="v-no-kartu"></td>
                                    </tr> 
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        </form>
      </div>
      <div class="modal-footer">
        <input id="simpan-user" type="button" class="btn btn-sm btn-primary" tabindex="8" value="Simpan">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>