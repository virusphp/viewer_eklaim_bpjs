<!-- modal User -->
<div class="modal fade" id="modal-pulang-sep" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-md modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-md-6">
            <h5 class="modal-title" id="edit-modal-register">Update Tanggal Pulang Sep </h5>
        </div>
        <div class="col-md-4">
        <!-- <input class="form-control-plaintext" type="text" id="tglSep" nama="tgl_reg" readonly> -->
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-update-pulang" class="form-horizontal" method="POST">
        <div id="frame_error" class="alert alert-danger">
          
        </div>
        <div class="row">
            <!-- Detail Pegawai -->
            <div id="data-user" class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                    <strong>Update Tanggal Pulang Sep</strong>
                        <small>Pasien</small>
                    </div>
                    <div class="card-body">
                        <div class="form-group clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="vat">No SEP</label>
                                    <input class="form-control form-control-sm" id="noSep" name="noSep" tabindex="1" type="text" placeholder="No Sep" readonly>
                                    <input class="form-control form-control-sm" name="_token" type="hidden" value="{{ csrf_token() }}">
                                </div>
                                <div class="form-group">
                                    <label for="vat">Tanggal Pulang</label>
                                    <div class="input-group date {{ $errors->has('tglPulang') ? 'has-error' : '' }}" id="dtglPulang" >
                                        <div class="input-group-append">
                                            <span class="input-group-text input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>                        
                                        <input class="form-control form-control-sm" id="tglPulang" 
                                                placeholder="Tanggal Pulang" name="tglPulang"
                                                type="text"
                                                tabindex="2"
                                                data-date-format="YYYY-MM-DD"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="vat">User</label>
                                    <input class="form-control form-control-sm" tabindex="3" id="user" name="user" type="text" value="{{ Auth::user()->nama_pegawai }}" placeholder="User" readonly>
                                </div>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        </form>
      </div>
      <div class="modal-footer">
        <input id="update-pulang" type="button" class="btn btn-sm btn-primary" tabindex="4" value="Pulangkan">
        <button type="button" tabindex="5" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>