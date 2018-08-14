<div class="form-inline float-right">
    <form id="search" action="{{ $route }}" class="form-inline" role="search" >
        <div class="form-group">
            <div class='input-group date {{ $errors->has('tgl') ? 'has-error' : '' }}' id='datetimepicker'>
                <input type='text' name="tgl" class="form-control" placeholder="Tanggal..." />              
                <div class="input-group-append">
                    <span class="input-group-text input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i>
                    </button>
		        </div>
            </div>
        </div>          
    </form> 
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