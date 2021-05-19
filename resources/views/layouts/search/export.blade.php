<div class="col-md-12 form-inline">
    <div class="col-offset-3">
        <form action="{{ route('laporan.export') }}" id="form-export" class="form-horizontal" method="POST">
            @csrf
        <div class="form-inline">
            <div class="form-check form-check-inline mr-1">
                <input onclick="ajaxLoad()" class="form-check-input" type="radio" id="jns_rawat1" value="01" name="jns_rawat" checked>
                <label class="form-check-label" for="jns_rawat1">Rawat Jalan</label>
            </div>
            <div class="form-check form-check-inline mr-1">
                <input onclick="ajaxLoad()" class="form-check-input" type="radio" id="jns_rawat2" value="02" name="jns_rawat">
                <label class="form-check-label" for="jns_rawat2">Rawat Inap</label>
            </div>
            <div class="form-check form-check-inline mr-1">
                <input onclick="ajaxLoad()" class="form-check-input" type="radio" id="jns_rawat3" value="03" name="jns_rawat">
                <label class="form-check-label" for="jns_rawat3">IGD</label>
            </div>
        </div>
    </div>
    
    {{-- tanggal export --}}
    <div class="col-offset-3">
        <div class="form-inline">

            <div class="form-group">
                <div class="input-group date {{ $errors->has('tgl_awal') ? 'has-error' : '' }}" id="dt-awal" >
                    <label class="mx-2 my-1" for="tgl_awal">Tgl Awal</label>
                    <div class="input-group-append">
                        <span class="input-group-text input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                    </div>                        
                    <input class="form-control form-control-sm" id="tgl_awal" 
                            value="{{ date('Y-m-d') }}" 
                            placeholder="Tanggal Awal" name="tgl_awal"
                            type="text"/>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group date {{ $errors->has('tgl_akhir') ? 'has-error' : '' }}" id="dt-akhir" >
                    <label class="mx-2 my-1" for="tgl_akhir">Tgl Akhir</label>
                    <div class="input-group-append">
                        <span class="input-group-text input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                    </div>                        
                    <input class="form-control form-control-sm" id="tgl_akhir" 
                            value="{{ date('Y-m-d') }}" 
                            placeholder="Tanggal Akhir" name="tgl_akhir"
                            type="text"/>
                </div>
            </div>

        </div>
    </div>

    <div class="col-offset-3">
        <div class="form-group">
            <label class="mx-1 my-1" for="status-claim">Status</label>
            <select class="form-control form-control-sm" name="status_claim" id="status-claim">
                <option value="">All</option>
                <option value="1">Verified</option>
                <option value="2">Pending</option>
            </select>
        </div>
    </div>
    {{-- Tombol Export --}}
    <div class="col-offset-3">  
        
        <a id="export-eklaim" class="btn btn-outline-primary ml-3"><i class="fas fa-file-excel" aria-hidden="true"> Export</i></a>
    </div>
    </form>

</div>