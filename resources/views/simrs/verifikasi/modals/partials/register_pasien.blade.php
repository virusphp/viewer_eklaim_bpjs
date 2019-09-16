<!-- modal User -->
<div class="modal fade" id="modal-register" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
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
          <form id="r_form-pasien" class="form-horizontal" method="POST">
          <div id="r_frame_error" class="alert alert-danger">
            
          </div>
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
                              <input class="form-control form-control-sm" tabindex="1" id="r_no_rm" name="no_rm" type="text" placeholder="No Reka Medis" autofocus>
                              <input class="form-control form-control-sm" name="_token" type="hidden" value="{{ csrf_token() }}">
                          </div>
                          <div class="form-group">
                              <label for="poli">Poliklinik</label>
                              <input id="r_nama_poli" tabindex="2" type="text" class="form-control form-control-sm" >
                              <input id="r_poli" name="kd_sub_unit" type="hidden">
                              <!-- <select id="poli" tabindex="2" name="kd_sub_unit" class="form-control form-control-sm">
                              </select> -->
                          </div>
                          <div class="form-group">
                              <label for="tarif">tarif</label>
                              <input class="form-control form-control-sm" id="r_tarif" name="tarif" type="text" placeholder="Tarif">
                              <input class="form-control form-control-sm" id="r_kd_tarif" name="kd_tarif" type="hidden" placeholder="Tarif">
                              <input class="form-control form-control-sm" id="r_rek_p" name="Rek_P" type="hidden" placeholder="Tarif">
                          </div>
                          <div class="form-group">
                              <label for="dokter">dokter</label>
                              <select id="r_kdDokter" name="kd_pegawai" class="form-control form-control-sm">
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="jnsPasien">Jenis Pasien</label>
                              <!-- <select id="jnsPasien" tabindex="3" name="kd_cara_bayar" class="form-control form-control-sm"> -->
                              <input id="r_nama_bayar" tabindex="3" type="text" class="form-control form-control-sm" >
                              <input id="r_jnsPasien" type="hidden" name="kd_cara_bayar">
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
                                  <div class="row">
                                      <div class="form-group col-sm-4">
                                          <label for="v-no-rm">No RM</label>
                                          <input class="form-control form-control-sm" id="v-no-rm" type="text" placeholder="No Rekam Medis">
                                      </div>
                                      <div class="form-group col-sm-8">
                                          <label for="v-nama-pasien">Nama</label>
                                          <input class="form-control form-control-sm" id="v-nama-pasien" type="text" placeholder="Nama Pasien">
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="form-group col-sm-8">
                                          <label for="v-alamat-reg">Alamat</label>
                                          <input class="form-control form-control-sm" id="v-alamat-reg" type="text" placeholder="Alamat Pasien">
                                      </div>
                                      <div class="form-group col-sm-4">
                                          <label for="v-jns-kel">Kelamin</label>
                                          <input class="form-control form-control-sm" id="v-jns-kel" type="text" placeholder="Jenis Kelamin">
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="form-group col-sm-8">
                                          <label for="v-tmpt-lahir">Tempat Lahir</label>
                                          <input class="form-control form-control-sm" id="v-tmpt-lahir" type="text" placeholder="Tempat Lahir">
                                      </div>
                                      <div class="form-group col-sm-4">
                                          <label for="v-tgl-lahir">Tgl Lahir</label>
                                          <input class="form-control form-control-sm" id="v-tgl-lahir" type="text" placeholder="Tanggal Lahir">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="v-no-telp">No Telp</label>
                                      <input class="form-control form-control-sm" name="no_telp" id="v-no-telp" type="text" tabindex="4" placeholder="No Telp">
                                  </div>
                                  <div class="row">
                                      <div class="form-group col-sm-8">
                                          <label for="v-no-kartu">No BPJS</label>
                                          <input class="form-control form-control-sm" name="noKartu" id="v-no-kartu" type="text" tabindex="5" placeholder="No BPJS">
                                      </div>
                                      <div class="form-group col-sm-4">
                                          <label for="v-jns-penjamin">Jenis Kartu</label>
                                          <input class="form-control form-control-sm" id="v-jns-penjamin" type="text" tabindex="6" placeholder="Jenis Penjamin">
                                          <input name="kdPenjamin" id="v-kd-penjamin" type="hidden">
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="form-group col-sm-8">
                                          <label for="v-nama-kartu">Nama From BPJS</label>
                                          <input class="form-control form-control-sm" id="v-nama-kartu" type="text" placeholder="Nama Bpjs">
                                      </div>
                                      <div class="form-group col-sm-4">
                                      <label for="v-hak-kelas">Hak Kelas</label>
                                      <input class="form-control form-control-sm" name="hakKelas" id="v-hak-kelas" type="text" placeholder="Hak Kelas">
                                      </div>
                                  </div>
                                  <!-- <table>
                                      <tr>
                                          <th>No RM</th>
                                          <td>:</td>
                                          <td><input type="text" id="v-no-rm" class="form-control"></td>
                                      </tr>
                                      <tr>
                                          <th>Nama</th>
                                          <td>:</td>
                                          <td><input type="text" id="v-nama-pasien" class="form-control"></td>
                                      </tr> 
                                      <tr>
                                          <th>Alamat</th>
                                          <td>:</td>
                                          <td><input type="text" id="v-alamat-reg" class="form-control"></td>
                                      </tr> 
                                      <tr>
                                          <th>Kelamin</th>
                                          <td>:</td>
                                          <td><input type="text" id="v-jns-kel" class="form-control"></td>
                                      </tr> 
                                      <tr>
                                          <th>Tgl Lahir</th>
                                          <td>:</td>
                                          <td><input type="text" id="v-tgl-lahir" class="form-control"></td>
                                      </tr> 
                                      <tr>
                                          <th>Tmpt Lahir</th>
                                          <td>:</td>
                                          <td><input type="text" id="v-tmpt-lahir" class="form-control"></td>
                                      </tr> 
                                      <tr>
                                          <th>No Telp</th>
                                          <td>:</td>
                                          <td><input name="no_telp" type="text" id="v-no-telp" class="form-control" tabindex="4"></td>
                                      </tr> 
                                      <tr>
                                          <th>No BPJS</th>
                                          <td>:</td>
                                          <td><input type="text" id="v-no-kartu" name="noKartu" class="form-control" tabindex="5"></td>
                                      </tr> 
                                      <tr>
                                          <th colspan="1">Hak Kelas</th>
                                          <td>:</td>
                                          <td><input id="v-hak-kelas" name="hakKelas" type="text" class="form-control col-md-3" tabindex="6"></td>
                                          <th colspan="1">PBI</th>
                                          <td>:</td>
                                          <td><input id="v-hak-kelas" name="hakKelas" type="text" class="form-control col-md-6" tabindex="6"></td>
                                      </tr> 
                                  </table> -->
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
         
          </form>
        </div>
        <div class="modal-footer">
          <input id="r_simpan-user" type="button" class="btn btn-sm btn-primary" tabindex="7" value="Simpan">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>