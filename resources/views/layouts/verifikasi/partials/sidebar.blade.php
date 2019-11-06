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
        <!-- SEP -->
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#master">
            <i class="nav-icon icon-pencil"></i> Viewer</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('viewer.index') }}">
                <i class="nav-icon icon-puzzle"></i>Penjamin</a>
            </li>
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