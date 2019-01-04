<div class="sidebar">
    <nav class="sidebar-nav">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/admin/home') }}">
            <i class="nav-icon icon-speedometer"></i> Dashboard
          </a>
        </li>
        <?php $user = Auth::user()->role; ?>
        <!-- Registrasi -->
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#master">
            <i class="nav-icon icon-pencil"></i> Registrasi</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('reg.rj.index') }}">
                <i class="nav-icon icon-puzzle"></i> Rawat Jalan</a>
            </li>
          </ul>
        </li>
        <!-- SEP -->
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#master">
            <i class="nav-icon icon-pencil"></i> SEP</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('sep.index') }}">
                <i class="nav-icon icon-puzzle"></i> Pembuatan SEP</a>
            </li>
            @if( $user == 'developer' || $user == 'superadmin')
            <li class="nav-item">
              <a class="nav-link" href="{{ route('sep.pulang.index') }}">
                <i class="nav-icon icon-puzzle"></i> Update Pulang SEP</a>
            </li>
            @endif
          </ul>
        </li>
        @if( $user == 'developer' || $user == 'superadmin')
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#master">
            <i class="nav-icon icon-pencil"></i> Manajement User</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('user.index') }}">
                <i class="nav-icon icon-puzzle"></i> Akun Users</a>
            </li>
          </ul>
        </li>
        @endif
      </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
  </div>