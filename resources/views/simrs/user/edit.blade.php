@extends('layouts.verifikasi.app')

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


<div class="col-md-3">
    <div class="uploader">
        <div class="card">
            <label for="file-upload" id="file-drag">
                <div id="show-form">
                    <img id="img" class="img-thumb" src="{{ asset('/img/template-user.png') }}">
                    <div class="clearfix"></div>
                    <input id="file-upload" type="file" name="fileUpload" accept="image/*," />
                    <span id="file-upload-btn" class="btn btn-primary btn-md mt-3"><i class="fa fa-camera"></i> Select a
                        photo</span>
                </div>
            </label>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            Edit Profil
        </div>
        <div class="card-body">

            <form autocomplete="off" method="POST" action="{{ route('user.update.profil', $user->id_user) }}"
                class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control form-control-sm" id="username" name="username" type="text"
                        value="{{ $user->kd_pegawai }}" readonly>
                </div>
                <div class="form-group">
                    <label for="password">Password</label> <span
                        class="pesan-error"><?php echo $errors->first('password') ?></span>
                    <input class="form-control form-control-sm" id="password" name="password" type="password"
                        placeholder="Password" value="{{ old('password') }}">
                </div>
                <div class="form-group">
                    <label for="password">Konfirmasi
                        Password</label><?php echo $errors->first('password_confirmation') ?>
                    <input class="form-control form-control-sm" name="password_confirmation" type="password"
                        placeholder="Konfirmasi Password">
                </div>

               
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
@endpush
@push('scripts')
<script type="text/javascript">
    $('#file-upload').on('change', function(e) {
		var file = this;
		if (file.files[0])
		{
			var reader = new FileReader();
			reader.onload = function(e)
			{
				$('#img').attr('src', e.target.result);
			}
			reader.readAsDataURL(file.files[0]);
		}
	});

</script>
@endpush