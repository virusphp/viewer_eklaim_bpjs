<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Akuntansi') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

    @yield('content')
      
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}" defer></script>  
</body>
</html>
<script>
  @if(Session::has('message'))
    $(document).ready(function() {         
        var type = "{{ Session::get('type', 'info') }}";
        switch(type){
          case 'info':
              toastr.info("{{ Session::get('message') }}");
              break;              
          case 'warning':
              toastr.warning("{{ Session::get('message') }}");
              break;
          case 'success':
              toastr.success("{{ Session::get('message') }}");
              break;
          case 'error':
              toastr.error("{{ Session::get('message') }}");
              break;
        }       
    });
  @endif
</script>