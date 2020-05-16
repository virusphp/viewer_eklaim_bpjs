<!-- modal User -->
<div class="modal fade" id="modal-catatan" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-md-6">
            <h5 class="modal-title" id="edit-modal-register">Catatan Kelengkapan</h5>
        </div>
        <div class="col-md-4">
        <!-- <input class="form-control-plaintext" type="text" id="tglSep" nama="tgl_reg" readonly> -->
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <!-- Detail Pegawai -->
            <div id="data-user" class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                    <strong>Catatan Pending atau keterangan lain</strong>
                        <small>Eklaim</small>
                    </div>
                    <div class="card-body">
                        <div class="form-group clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="vat">No Rm</label>
                                    <input class="form-control form-control-sm" id="noRm"type="text" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="vat">No Sep</label>
                                    <input class="form-control form-control-sm" id="noSep"type="text" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="vat">Catatan</label>
                                    <textarea rows="2" class="form-control form-control-sm" id="catatan"type="textarea" readonly>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
      </div>
      <div class="modal-footer">
        <input id="update-pulang" type="button" class="btn btn-sm btn-primary" tabindex="4" value="Pulangkan">
        <button type="button" tabindex="5" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>