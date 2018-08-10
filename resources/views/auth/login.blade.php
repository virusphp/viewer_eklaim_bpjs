@extends ('layouts.login')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">RSUD KRATON</h1>
            <hr>
            <p class="text-center daiwabo">AKUNTANSI</p>
            <div class="account-wall">
               <img class="profile-img" src="{{ asset('img/logo-kraton.png') }}">
               <form class="form-signin" method="POST" action="{{ route('auth.login') }}">
                  {{ csrf_field() }}
                  <div class="form-group{{ $errors->has('idkaryawan') ? 'has-error' : '' }}">
                     <input id="idkaryawan" type="text" class="form-control" name="idkrayawan" placeholder="ID karyaywan" value="{{ old('idkaryawan') }}" required autofocus>
                      @if ($errors->has('idkaryawan'))
                         <span class="help-block">
                           <strong>{{ $errors->first('idkaryawan') }}</strong>
                        </span>
                     @endif
                  </div>
                  <div class="form-group{{ $errors->has('password') ? 'has-error' : '' }}">
                     <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                     @if ($errors->has('password'))
                        <span class="help-block">
                           <strong>{{ $errors->first('password') }}</strong>
                        </span>
                     @endif 
                  </div>
                  <div class="form-group">
                     <button class="btn btn-lg btn-primary btn-block" type="submit">Masuk</button>
                     <label class="pull-left">
                        <input type="checkbox" name="remember" value="remember-me" {{ old('remember') ? 'checked' : '' }}>
                        Remember Me
                     </label>
                  </div>
               </form>
            </div>
        </div>
    </div>
</div>
@endsection