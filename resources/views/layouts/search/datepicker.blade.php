<table class="table table-clear">
    <tr>
        <td style="vertical-align: center"><strong>Jenis Pasien</strong></td>
        <td>            
            <select id="jns_pasien" name="jns_pasien" class="form-control" onchange="ajaxLoad()">
            <option value="">JENIS PASIEN</option>
                @foreach($j_pasien as $jns)
                   <option value="{{ $jns->jenis_pasien }}">{{ $jns->jenis_pasien }}</option>
                @endforeach            
            </select>        
        </td>
        <td style="vertical-align: center"><strong>Jenis Rawat</strong></td>
        <td>
            <select id="jns_rawat" name="jns_rawat" class="form-control" onchange="ajaxLoad()">
            <option value="">JENIS RAWAT</option>
                @foreach($j_rawat as $jns)
                   <option value="{{ $jns->jenis_rawat }}">{{ $jns->jenis_rawat }}</option>
                @endforeach            
            </select>    
        </td>
        <td>
            <div class="form-inline float-right">
                <div class="form-group col-md-7">
                    <div class="input-group date {{ $errors->has('tgl') ? 'has-error' : '' }}" id="datetimepicker" >
                        <div class="input-group-append">
                            <span class="input-group-text input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>                        
                        <input class="form-control" id="tgl" 
                                value="{{ date('d-m-Y')}}" 
                                placeholder="Tanggal Kwitansi" name="tgl"
                                type="text"/>
                        <div class="input-group-append">                    
                            <button type="submit" class="btn btn-primary" onclick="ajaxLoad()">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class='input-group date'>
                        <input type='text' name="search" class="form-control"  id="searchInput" placeholder="Cari..."/>                        
                    </div>
                </div>     
            </div> 
        </td> 
    </tr>
</table>



