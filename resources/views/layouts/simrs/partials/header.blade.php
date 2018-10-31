<header class="app-header navbar">
      <?php $user = Auth::user(); ?> 
      <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="{{asset('img/logo.png')}}" width="89" height="25" alt="CoreUI Logo">
        <!-- <img class="navbar-brand-minimized" src="img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo"> -->
      </a>
      <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
          <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link" href="#">Settings</a>
        </li>
      </ul>
      <ul class="nav navbar-nav ml-auto"> 
          <div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
              <span class="semi-bold">{{ $user->nama_pegawai}}</span>
          </div>       
          <li class="nav-item dropdown">
       
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <img id="v-avatar" class="img-avatar" src="{{asset('core-ui/img/avatars/6.jpg')}}" alt="">
            </a>
            
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-header text-center">
                <strong></strong>
              </div>           
              <a class="dropdown-item" href="{{ route('user.edit.profil', $user->id_user) }}">
                <i class="fa fa-user"></i> {{ $user->role}}
              </a>            
              <div class="divider"></div>            
              <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i>
                  {{ __('Logout') }}
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </div>
          </li>
      </ul>      
    </header>