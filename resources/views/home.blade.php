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

  <div class="col-md-12">
    <div class="card text-center">
      <div class="card-header">Chart</div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Pilih Tahun :</label>
              <select class="sel form-control" name="tahun">
                <option value="2020">2020</option>
                <option value="2019">2019</option>
                <option value="2018">2018</option>
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Pilih Jenis Pasien :</label>
              <select id="pelayanan" class="form-control" name="tahun">
                <option value="01">Rawat Jalan</option>
                <option value="02">Rawat Inap</option>
                <option value="03">Rawat Darurat</option>
              </select>
            </div>
          </div>
        <div class="col-sm-12 col-md-8 col-lg-8">
          {!! $chart->container() !!}
        </div>
      </div>
      </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
{!! $chart->script() !!}
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

  $(document).ready(function() {
    autoload();
  })
   
    var original_api_url = {{ $chart->id }}_api_url;
    $(".sel").change(function() {
      var tahun = $(this).val(),
          pelayanan = $('#pelayanan').val();
      {{ $chart->id }}_refresh(original_api_url + "?tahun=" + tahun + "&pelayanan=" + pelayanan)
    });

    $("#pelayanan").change(function() {
      var pelayanan = $(this).val(),
          tahun = $('.sel').val();
      <?php echo $chart->id ?>_refresh(original_api_url + "?tahun=" + tahun + "&pelayanan=" + pelayanan)
    });

    function autoload() {
      var tahun = $('.sel').val(),
          pelayanan = $('#pelayanan').val();
      <?php echo $chart->id ?>_refresh(original_api_url + "?tahun=" + tahun + "&pelayanan=" + pelayanan)
    }
</script>
@endpush