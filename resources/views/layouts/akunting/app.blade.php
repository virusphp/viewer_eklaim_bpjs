<!DOCTYPE html>
<!--
* Licensed under MIT (https://coreui.io/license)
-->
<html lang="{{ app()->getLocale() }}">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIMRS Mini</title>
    <!-- Icons-->
    <link href="{{ asset('core-ui/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('core-ui/css/simple-line-icons.css') }}" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="{{ asset('core-ui/css/style.css') }}" rel="stylesheet">
    @stack('css')

  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    @include('layouts.akunting.partials.header')
    <div class="app-body">
        @include('layouts.akunting.partials.sidebar')
      <main class="main">
        <!-- Breadcrumb-->
        {{-- @include('layouts.akunting.partials.breadcrumb') --}}
        @yield('breadcrumb')

        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>
      </main>
    </div>
    @include('layouts.akunting.partials.footer')
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('core-ui/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('core-ui/js/popper.min.js') }}"></script>
    <script src="{{ asset('core-ui/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('core-ui/js/pace.min.js') }}"></script>
    <script src="{{ asset('core-ui/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('core-ui/js/coreui.min.js') }}"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="{{ asset('core-ui/js/custom-tooltips.min.js') }}"></script>
    @stack('scripts')
  </body>
</html>