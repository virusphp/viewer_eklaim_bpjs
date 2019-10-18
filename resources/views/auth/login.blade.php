@extends ('layouts.login')

@section ('content')
<div class="container">
    <div class="row justify-content-md-center h-100">
        <div class="col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">RSUD KRATON</h1>
            <hr>
            <p class="text-center daiwabo">E-Klaim SIRM Mini</p>
            <div class="account-wall">
               <img class="profile-img" src="{{ asset('img/logo.png') }}">
               <form class="form-signin" method="POST" action="{{ route('login.post') }}">
                  {{ csrf_field() }}
                  <div class="form-group">
                     <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" placeholder="Username" value="{{ old('username') }}"  autofocus>
                      @if ($errors->has('username'))
                         <span class="invalid-feedback">
                           <strong>{{ $errors->first('username') }}</strong>
                        </span>
                     @endif
                  </div>
                  <div class="form-group">
                     <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" >
                     @if ($errors->has('password'))
                        <span class="invalid-feedback">
                           <strong>{{ $errors->first('password') }}</strong>
                        </span>
                     @endif 
                  </div>
                  <div class="form-group">
                     <button class="btn btn-lg btn-primary btn-block" type="submit">Masuk</button>
                     <br>
                     <!-- <label class="pull-left">
                        <input type="checkbox" name="remember" value="remember-me" {{ old('remember') ? 'checked' : '' }}>
                        Remember Me
                     </label> -->
                  </div>
               </form>
            </div>
        </div>
    </div>
</div>
@endsection