<div class="col-md-4 float-right">
<form action="{{ $route }}">
    <div class="controls">
    <div class="input-group">
        <input name="search" value="{{ Request::get("search") }}" class="form-control" placeholder="Cari..." type="text">
        <span class="input-group-append">
        <button class="btn btn-secondary" type="submit">Cari!</button>
        </span>
    </div>
    </div>
</form>
</div>