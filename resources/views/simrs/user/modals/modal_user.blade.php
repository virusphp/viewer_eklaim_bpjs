<!-- modal User -->
<div class="modal fade" id="modal-user" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-md modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <div class="col-md-4">
        <h5 class="modal-title" id="edit-modal-user">Manajemen Users </h5>
      </div>
      <div class="col-md-4">
        <!-- <input class="form-control-plaintext" type="text" id="tglSep" nama="tgl_reg" readonly> -->
      </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-user" action="" class="form-horizontal" method="POST">
        <!-- <div id="frame_error" class="alert alert-danger">
          
        </div> -->
      
        <div class="row">
            <!-- Akun Pegawai -->
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <strong>Pendaftaran</strong>
                        <small>Akun</small>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_pegawai">Nama pegawai</label>
                            <input class="form-control form-control-sm" id="nama_pegawai" name="nama_pegawai" type="text" placeholder="Nama Pegawai">
                            <input class="form-control form-control-sm" name="_token" type="hidden" value="{{ csrf_token() }}">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input class="form-control form-control-sm" id="username" name="username" type="text" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control form-control-sm" id="password" name="password" type="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" name="role" class="form-control form-control-sm">
                                    <option value="">-- Pilih --</option> 
                                    <option value="admin">Admin</option> 
                                    <option value="operator">Operator</option> 
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
                        <small>Akun Pegawai</small>
                    </div>
                    <div class="card-body">
                        <div class="form-group clearfix">
                            <div class="col-sm-4 float-left">
                                <img id="v-foto" src="" width="150" height="200" class="img-thumbnail">
                            </div>
                            <div class="col-sm-8 float-right">
                                <table>
                                    <tr>
                                        <th>Username</th>
                                        <td>:</td>
                                        <td><input type="text" id="v-username"></td>
                                    </tr>
                                    <tr>
                                        <th>Nama</th>
                                        <td>:</td>
                                        <td><input type="text" id="v-nama"></td>
                                    </tr> 
                                    <tr>
                                        <th>Alamat</th>
                                        <td>:</td>
                                        <td><input type="text" id="v-alamat"></td>
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
                                        <th>Unit Kerja</th>
                                        <td>:</td>
                                        <td><input type="text" id="v-unit-kerja"></td>
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