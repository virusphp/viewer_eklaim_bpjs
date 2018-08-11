<div class="form-inline float-left mb-2 mr-8">
   <form id="search"action="{{ $route }}" class="form-inline" role="search" >
        <div class="controls">
            <div class='input-group date {{ $errors->has('search') ? 'has-error' : '' }}'>
                <input type='text' name="search" class="form-control" placeholder="Cari..."/>
            </div>
        </div>
        <button type="submit" class="btn btn-secondary">
            <i class="fa fa-search"></i>
        </button>
    </form>
    <div class="clearfix"></div>
    <form id="search" action="{{ $route }}" class="form-inline" role="search" >
        <div class="controls">
            <div class='input-group date {{ $errors->has('tgl') ? 'has-error' : '' }}' id='datetimepicker'>
                <input type='text' name="tgl" class="form-control" placeholder="Tanggal..." />
                <span class="input-group-addon">
                    <span class="fa fa-calendar">
                    </span>
                </span>
            </div>
        </div>
        <button type="submit" class="btn btn-secondary">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>
<div class="form-inline float-right mb-2 mr-8">
    <form id="tanggal" action="{{ $route }}" class="form-inline" role="search" >
        <div class="controls">
            {{-- Tanggal pertama --}}
            <div class='input-group date {{ $errors->has('tgl1') ? 'has-error' : '' }}' id='datetimepicker1'>
                <input type='text' name="tgl1" class="form-control" placeholder="Dari..." />
                <span class="input-group-addon">
                    <span class="fa fa-calendar">
                    </span>
                </span>
            </div>
        </div>
            s/d
            {{-- Tanggal kedua --}}
        <div class="controls">
            <div class='input-group date {{ $errors->has('tgl2') ? 'has-error' : '' }}' id='datetimepicker2'>
                <input type='text' name="tgl2" class="form-control" placeholder="Sampai..." />
                <span class="input-group-addon">
                    <span class="fa fa-calendar">
                    </span>
                </span>
            </div>
        </div>
    <button type="submit" class="btn btn-secondary">
        <i class="fa fa-search"></i>
    </button>
    </form>
</div>