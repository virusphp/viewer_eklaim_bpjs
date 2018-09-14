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
            <i class="nav-icon icon-pencil"></i> SEP</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('sep.index') }}">
                <i class="nav-icon icon-puzzle"></i> Pembuatan SEP</a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
  </div>