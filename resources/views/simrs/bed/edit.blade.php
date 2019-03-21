@extends('layouts.simrs.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a href="{{ route('user.edit.profil', Auth::user()->id_user) }}">Profil Ku</a>
    </li>
    <li class="breadcrumb-item active">Index</li>
</ol>
@endsection
@section('content')
<div class="col-md-6">
  <div class="card">
      <div class="card-header">
        Edit Profil
      </div>
      <div class="card-body">

      <form autocomplete="off" method="POST" action="{{ route('user.update.profil', $user->id_user) }}" class="form-horizontal" >
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="form-group">
          <label for="username">Username</label>
          <input class="form-control form-control-sm" id="username" name="username" type="text" value="{{ $user->kd_pegawai }}" readonly>
        </div>
        <div class="form-group">
          <label for="password">Password</label> <span class="pesan-error"><?php echo $errors->first('password') ?></span>
          <input class="form-control form-control-sm" id="password" name="password" type="password" placeholder="Password" value="{{ old('password') }}">
        </div>
        <div class="form-group">
          <label for="password">Konfirmasi Password</label><?php echo $errors->first('password_confirmation') ?>
          <input class="form-control form-control-sm" name="password_confirmation" type="password" placeholder="Konfirmasi Password">
        </div>
        <button  type="submit" class="btn btn-sm btn-primary">Simpan</button> 
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
      </form>

      </div>
  </div>
</div>

@endsection


