<div class="col-md-12 form-inline">
    <div class="col-md-3 col-offset-3">
        <div class="col-md-12 col-form-label form-inline">
            <div class="form-check form-check-inline mr-1">
                <input class="form-check-input" type="radio" id="jns_rawat1" value="01" name="jns_rawat" checked>
                <label class="form-check-label" for="jns_rawat1">Rawat Jalan</label>
            </div>
            <div class="form-check form-check-inline mr-1">
                <input class="form-check-input" type="radio" id="jns_rawat2" value="02" name="jns_rawat">
                <label class="form-check-label" for="jns_rawat2">Rawat Inap</label>
            </div>
            <div class="form-check form-check-inline mr-1">
                <input class="form-check-input" type="radio" id="jns_rawat3" value="03" name="jns_rawat">
                <label class="form-check-label" for="jns_rawat3">IGD</label>
            </div>
        </div>
    </div>
    
    {{-- tanggal sep --}}
    <div class="col-md-3 col-offset-3">
        <div class="form-group">
            <div class="input-group date {{ $errors->has('tgl_sep') ? 'has-error' : '' }}" id="datetimepicker_sep" >
            <label for="tgl_sep_filter" class="foram-check-label">Tgl Sep </label>
                <div class="input-group-append">
                    <span class="input-group-text input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>                        
                <input class="form-control" id="tgl_sep_filter" 
                        value="{{ date('d-m-Y') }}" 
                        placeholder="Tanggal Kwitansi" name="tgl_sep"
                        type="text"/>
                <div class="input-group-append">                    
                    <button type="submit" class="btn btn-primary" onclick="ajaxLoad()">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- tanggal pulang -->
    <div class="col-md-3 col-offset-3">
        {{-- <div class="form-group">
            <div class="input-group date {{ $errors->has('tgl_plg') ? 'has-error' : '' }}" id="datetimepicker_plg" >
            <label for="tgl_plg_filter" class="foram-check-label">Tgl Plg </label>
                <div class="input-group-append">
                    <span class="input-group-text input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>                        
                <input class="form-control" id="tgl_plg_filter" 
                        value="{{ date('d-m-Y') }}" 
                        placeholder="Tanggal Kwitansi" name="tgl_plg"
                        type="text"/>
                <div class="input-group-append">                    
                    <button type="submit" class="btn btn-primary" onclick="ajaxLoad()">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div> --}}
    </div>

    <div class="col-md-3 col-offset-3">
        <div class="controls">
            <div class="input-group">
                <input name="search" id="search" value="" class="form-control" placeholder="Cari..." type="text">
                <span class="input-group-append">
                <button class="btn btn-secondary" type="submit" onclick="ajaxLoad()">Cari!</button>
                </span>
            </div>
        </div>
    </div>
</div>