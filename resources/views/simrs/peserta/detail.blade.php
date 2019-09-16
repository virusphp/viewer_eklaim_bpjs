@extends('layouts.verifikasi.app')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    Master
  </li>

  <li class="breadcrumb-item">
    <a href="{{ route('sep.index') }}">Viewer</a>
  </li>
  <li class="breadcrumb-item active">Detail - {{ $noReg }}</li>
  <li class="breadcrumb-menu d-md-down-none">
  </li>
</ol>
@endsection
@section('content')
<div class="col-md-4">
  <div class="card">
    <div class="card-header">
      <strong>Data</strong> Peserta Bpjs
    </div>
    <div class="card-body">
      <div class="centering">
        <img src="{{ asset('img/default_user.png') }}" alt="..." class="img-thumbnail img-verifid">
      </div>
      <div class="form-group clearfix">
        <div class="col-sm-12">
          <label for="street">No Kartu</label>
          <input class="form-control form-control-sm" id="no_kartu" type="text" value="{{ $dataPeserta->noKartu }}" readonly>
        </div>
      </div>
      <div class="form-group clearfix">
        <div class="col-sm-12">
          <label for="street">No RM</label>
          <input class="form-control form-control-sm" id="no_rm" type="text" value="{{ $dataPeserta->no_rm }}" readonly>
        </div>
      </div>
      <div class="form-group clearfix">
        <div class="col-sm-12">
          <label for="street">Nama Peserta</label>
          <input class="form-control form-control-sm" id="nama_peserta" type="text" value="{{ $dataPeserta->nama }}" readonly>
        </div>
      </div>
      <div class="form-group clearfix">
        <div class="col-sm-12">
          <label for="street">Hak Kelas</label>
          <input class="form-control form-control-sm" id="hak_kelas" type="text" value="{{ $dataPeserta->hakKelas }}" readonly>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-md-8">
  <div class="card">
    <div class="card-header">
      <strong>Surat</strong> Elegibilitas Peserta
      <div class="card-header-actions">
        <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#sepPeserta" aria-expanded="true">
          <i class="icon-arrow-up"></i>
        </a>
      </div>
    </div>
    <div class="collapse show" id="sepPeserta" style="">
      <div class="card-body">
        <embed src="{{ asset('storage/verifikasi').'/'.$dataPeserta->pdfSep }}" width="725" height="373">
      </div>
    </div>
  </div>
  <!-- Rujukan -->
  <div class="card">
    <div class="card-header">
      <strong>Surat</strong> Rujukan Bpjs
      <div class="card-header-actions">
        <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#rujukanPeserta" aria-expanded="true">
          <i class="icon-arrow-up"></i>
        </a>
      </div>
    </div>
    <div class="collapse show" id="rujukanPeserta" style="">
      <div class="card-body">

        @if($dataRujukan->status == 0)
        <p>{{ $dataRujukan->pesan }}</p>
        @else
        <embed src="{{ asset('storage/verifikasi').'/'.$dataRujukan->pesan }}" width="725" height="373">
        @endif

      </div>
    </div>
  </div>
  <!-- Rujukan -->
  <div class="card">
    <div class="card-header">
      <strong>Surat</strong> Kontrol
      <div class="card-header-actions">
        <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#suratKontrol" aria-expanded="true">
          <i class="icon-arrow-up"></i>
        </a>
      </div>
    </div>
    <div class="collapse show" id="suratKontrol" style="">
      <div class="card-body">
        <!-- <table class="table table-sm">
        <thead>
          <tr>
            <th>No Surat</th>
            <th>No Sep</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($dataSuratKontrol as $v)
            <tr>
              <td>{{ $v->no_surat }} </td>
              <td>omdern</td>
              <td>tombol</td>
            </tr>
          @endforeach
        </tbody>
      </table> -->
      <form action="{{ route('surat.kontrol') }}" class="form-horizontal">
        <div class="row">
            <div class="form-group col-sm-8 clearfix">
              <input name="noSurat" class="form-control form-control-sm" id="no_surat" type="text" placeholder="No Surat">
            </div>
            <div class="form-group col-sm-4 clearfix">
              <input id="noRm" name="noRm" value="{{ $dataPeserta->no_rm }}" type="hidden">
              <input id="no_rujukan" name="noRujukan" type="hidden">
              <input id="tglSep" name="tglSep" type="hidden" value="{{ $dataPeserta->tglSep }}">
              <button type="submit" id="surat-verified" class="btn btn-sm btn-outline-success">Verified</button>
            </div>
        </div>
      </form>

      </div>
    </div>
  </div>
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
@endpush
@push('scripts')
<script type="text/javascript" src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript">
  // cari Surat Kontrol
  $(document).ready(function() {
    var src = "{{ route('nosurat.internal') }}",
      tglSep = $('#tglSep').val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $('#no_surat').autocomplete({
      source: function(request, response) {
        $.ajax({
          url: src,
          dataType: "json",
          data: {
            term: request.term,
            tglSep: tglSep
          },
          success: function(data) {
            var array = data.error ? [] : $.map(data, function(m) {
              return {
                id: m.No_Rujukan,
                value: m.No_Rujukan + " | " + m.no_rujukan_bpjs,
                bpjs: m.no_rujukan_bpjs
              };
            });
            response(array);
          }
        });
      },
      minLength: 3,
      select: function(event, ui) {
        $('#no_surat').val(ui.item.id);
        $('#no_rujukan').val(ui.item.bpjs);
        return false;
      }
    });
  });

  $('#surat-verified').on('click', function() {
    var no_surat = $('#no_surat').val(),
      no_rujukan = $('#no_rujukan').val()
    tglSep = $('#tglSep').val(),
      method = 'POST';
    var noSurat = no_surat.split('/'),
      surat = noSurat[0].substring(noSurat[0].length - 6),
      urlPrint = '/admin/verifikasi/surat/print/' + tglSep + '/' + surat + '/' + no_rujukan;

    // console.log(urlPrint);
    $.ajax({
      method: method,
      url: url,
      data: {
        _token: CSRF_TOKEN,
        noSurat: no_surat,
        noRujukan: no_rujukan
      },
      success: function(response) {
        window.open(urlPrint, "_blank", "width=850, height=600");
      }
    })

  })
</script>
@endpush