@extends('layouts.simrs.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="{{ url('/admin/home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">Dashboard</li>
</ol>
@endsection

@section('content')
<div class="card">
  <div class="card-header text-center">
    Pengumuman
  </div>
  <div class="card-body">
    RSUD Kraton adalah Rumah sakit umum daerah Kabupaten Pekalongan
    ini adalah layanan Sistem Informasi Rumah Sakit minipack yang di desain
    dengan minimum service serta modul modul yang terintegrasi secara langsung
  </div>
</div>

@endsection
