<table class="table table-clear">
    <tr>
        <td style="vertical-align: middle"><strong>Jenis Pasien</strong></td>
        <td>            
            <select id="select" name="jns_pasien" class="form-control">
                <option value="UMUM">UMUM</option>
                <option value="PENJAMIN">PENJAMIN</option>               
            </select>        
        </td>
        <td style="vertical-align: middle"><strong>Jenis Rawat</strong></td>
        <td>
            <select id="select" name="jns_rawat" class="form-control">
                <option value="RJ">RAWAT JALAN</option>
                <option value="RI">RAWAT INAP</option>
                <option value="RD">RAWAT DARURAT</option>
            </select>    
        </td>
        <td>
            <div class="form-inline float-right">
                <div class="form-group">
                    <div class='input-group date {{ $errors->has('tgl') ? 'has-error' : '' }}' id='datetimepicker' >
                        <div class="input-group-append">
                            <span class="input-group-text input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                        <input type='text' name="tgl" class="form-control" placeholder="Tanggal..." value="{{ date('d-m-Y')}}" />              
                        <div class="input-group-append">                    
                            <button type="button" id="btn_tgl" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>       
                <!-- <form id="search" action="{{ $route }}" class="form-harizontal" role="search" >
                    
                    <div class="form-group">
                        <div class='input-group date {{ $errors->has('tgl') ? 'has-error' : '' }}' id='datetimepicker' >
                            <div class="input-group-append">
                                <span class="input-group-text input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input type='text' name="tgl" class="form-control" placeholder="Tanggal..." value="{{ date('d-m-Y')}}" />              
                            <div class="input-group-append">                    
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>          
                </form>  -->
                <form id="search"action="{{ $route }}" class="form-inline" role="search" >
                    <div class="form-group col-md-12">
                        <div class='input-group date {{ $errors->has('search') ? 'has-error' : '' }}'>
                            <input type='text' name="search" class="form-control" placeholder="Cari..."/>
                            <div class="input-group-append">                   
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>       
                </form>
            </div>
        </td>
    </tr>

</table>
