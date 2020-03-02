<!-- modal User -->
<div class="modal fade" id="modal-viewer" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-md modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <div class="col-md-4">
        <h5 class="modal-title" id="edit-modal-guide">Viewer Dokumen Eklaim </h5>
      </div>
      {{-- <div class="col-md-4"> --}}
        <!-- <input class="form-control-plaintext" type="text" id="tglSep" nama="tgl_reg" readonly> -->
      {{-- </div> --}}
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <div class="row" id="viewer">
            <embed id="id-viewer" src="{{ asset('guide/guide_simrs_mini.pdf') }}#toolbar=1&navpanes=0&scrollbar=0" type="application/pdf" width="1020" height="500" />
        </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>