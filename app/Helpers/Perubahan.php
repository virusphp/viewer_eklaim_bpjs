<?php

function rupiah($nilai)
{
    return "Rp. ". number_format(ceil($nilai), "0",",",".");
}

function kelamin($nilai)
{
	return $nilai == 1 ? "Perempuan" : "Laki-laki";
}

function maskCard($nilai) 
{
	$leng = strlen($nilai);
	for($i=0; $i<$leng-4;$i++) {
		if($nilai[$i] == '-'){continue;}
		$nilai[$i] = 'X';
	}
	return $nilai;
}

function bulan($tanggal)
{
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', date('Y-m-d', strtotime($tanggal)));
	$bln = isset($pecahkan[1]) ? (int)$pecahkan[1] : ' ';
	return $bulan[$bln];
}

function tanggal($tanggal)
{
    $bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
    $pecahkan = explode('-', date('Y-m-d', strtotime($tanggal)));
    $bln = isset($pecahkan[1]) ? (int)$pecahkan[1] : ' ';
    return $pecahkan[2].'-'.$bulan[$bln].'-'.$pecahkan[0];
}

function tanggalPdf($tanggal)
{
    $bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
    $pecahkan = explode('-', date('Y-m-d', strtotime($tanggal)));
    $bln = isset($pecahkan[1]) ? (int)$pecahkan[1] : ' ';
    return $pecahkan[2].'_'.$bulan[$bln].'_'.$pecahkan[0];
}

function bulatan($nilai)
{
    return round($nilai, 2);
}

function noReg($nilai)
{
	return substr($nilai, 0, 2);
}

function ppk($nilai)
{
	return substr($nilai, 0, 8);
}

function formatTgl($nilai)
{
	return date('Y-m-d', strtotime($nilai));
}

function typeRawat($nilai) 
{
	return substr($nilai, 0, 2);
}

function jenisRawat($nilai)
{
	// dd(($nilai == 1) ? "R Jalan" : (($nilai == 2) ? "R Inap" : "IGD"));
	return ($nilai == 1) ? "R Jalan" : (($nilai == 2) ? "R Inap" : "IGD");
}

function jenisPelayanan($nilai)
{
	// dd(($nilai == 1) ? "R Jalan" : (($nilai == 2) ? "R Inap" : "IGD"));
	return ($nilai == 1) ? "R INAP" : "R JALAN" ;
}

function caraBayar($nilai)
{
	$cara_bayar = [
		1 => 'UMUM',
		3 => 'Asuransi Lain',
		4 => 'Keringan Dispensasi',
		5 => 'Keringan Tidak Mampu',
		6 => 'Gratis Dispensasi',
		8 => 'BPJS',
		9 => 'UMUM'
	];

	return $cara_bayar[$nilai];
}

function AmbilKelas()
{
	$cara_bayar = [
		1 => 'Kelas I',
		2 => 'Kelas II',
		3 => 'Kelas III'
	];

	return $cara_bayar;
}

function namaKelas($nilai)
{
	$namaKelas = [
		1 => 'Kelas I',
		2 => 'Kelas II',
		3 => 'Kelas III'
	];

	return $namaKelas[$nilai];
}

function dateRange($awal, $akhir, $step = '+1 day', $format = 'Y-m-d') {
	$dates = [];
	$current = strtotime($awal);
	$akhir = strtotime($akhir);

	while($current <= $akhir) {
		$dates[] = date($format, $current);
		$current = strtotime($step, $current);
	}

	return $dates;
}