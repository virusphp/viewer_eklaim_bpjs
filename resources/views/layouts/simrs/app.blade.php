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
    <meta name="description" content="SIMRS RSUD KRATON PEKALONGAN">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIMRS Mini</title>
    <!-- Icons-->
    <link href="{{ asset('core-ui/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('core-ui/css/simple-line-icons.css') }}" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="{{ asset('core-ui/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('core-ui/datepicker/css/bootstrap-datetimepicker.min.css') }}" />
    <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css"> -->
    @stack('css')

  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    @include('layouts.simrs.partials.header')
    <div class="app-body">
        @include('layouts.simrs.partials.sidebar')
      <main class="main">
        <!-- Breadcrumb-->
        {{-- @include('layouts.simrs.partials.breadcrumb') --}}
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
    @include('layouts.simrs.partials.footer')
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('core-ui/jquery/jquery.min.js') }}"></script>
    <!-- <script src="//code.jquery.com/jquery-1.12.4.js"></script> -->
    <!-- <script src="{{ asset('core-ui/js/popper.min.js') }}"></script> -->
    <script src="{{ asset('core-ui/js/bootstrap.min.js') }}"></script>
    <!-- <script src="{{ asset('core-ui/js/pace.min.js') }}"></script> -->
    <!-- <script src="{{ asset('core-ui/js/perfect-scrollbar.min.js') }}"></script> -->
    <script src="{{ asset('core-ui/js/coreui.min.js') }}"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="{{ asset('core-ui/js/custom-tooltips.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('core-ui/moment/min/moment.min.js') }}"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> -->
    <!-- <script type="text/javascript" src="{{ asset('core-ui/js/bootstrap.min.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('core-ui/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    @stack('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
          var kd = '{{ Auth::user()->kd_pegawai }}',
              url = '{{ route('user.foto') }}',
              method = 'GET';
          $.ajax({
            method: method,
            url: url,
            data: { kd: kd },
            success: function(res) {
              if (res.foto == '↵') {
                $('#v-avatar').attr('src', '{{asset('core-ui/img/avatars/6.jpg')}}');
              } else {
                $('#v-avatar').attr('src', 'data:image/jpeg;base64,'+res.foto);
              }
            }
          })
        })
    </script>
  </body>
</html>