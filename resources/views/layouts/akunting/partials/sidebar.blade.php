<div class="sidebar">
    <nav class="sidebar-nav">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/admin/home') }}">
            <i class="nav-icon icon-speedometer"></i> Dashboard
          </a>
        </li>
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#master">
            <i class="nav-icon icon-pencil"></i> Master</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('akun.perkiraan') }}">
                <i class="nav-icon icon-puzzle"></i> Akun Perkiraan</a>
            </li>
          </ul>
        </li>
        <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#transaksi">
              <i class="nav-icon icon-pencil"></i> Transaksi</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('kwitansi') }}">
                  <i class="nav-icon icon-puzzle"></i> Kwitansi</a>
              </li>
            </ul>
        </li>
        <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
              <i class="nav-icon icon-note"></i> Jurnal</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="nav-icon icon-puzzle"></i> Jurnal LO</a>
              </li>
            </ul>
        </li>
      </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
  </div>