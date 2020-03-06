@extends('layouts.verifikasi.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="{{ url('/admin/home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">Dashboard</li>
</ol>
@endsection

@section('content')
  <div class="card text-center">
    <div class="card-header">
      Pengumuman
    </div>
    <div class="card-body">
      RSUD Kraton adalah Rumah sakit umum daerah Kabupaten Pekalongan
      ini adalah layanan Sistem Informasi Rumah Sakit minipack yang di desain
      dengan minimum service serta modul modul yang terintegrasi secara langsung
    </div>
  </div>

 
 

@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
<link href="{{ asset('css/cobaslide.css') }}" rel="stylesheet">
@endpush
@push('scripts')
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/moze.min.js') }}"></script>
<script src="{{ asset('js/jquery.cslider.js') }}"></script>
<script type="text/javascript">
  @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
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
  @endif
  $(function() {

    $('#da-slider').cslider({
      autoplay: true,
      bgincrement: 450
    });

  });

    $(function() {
      $('.slider-post').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        arrows: false,
        dots: false,
        pauseOnHover: false,
        responsive: [{
          breakpoint: 768,
          settings: {
            slidesToShow: 2
          }
        }, {
          breakpoint: 520,
          settings: {
            slidesToShow: 1
          }
        }]
      });
    });

</script>
@endpush