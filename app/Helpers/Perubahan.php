<?php

function rupiah($nilai)
{
    return "Rp. ". number_format(ceil($nilai), "0",",",".");
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

function bulatan($nilai)
{
    return round($nilai, 2);
}

function noReg($nilai)
{
	return substr($nilai, 0, 2);
}

function formatTgl($nilai)
{
	return date('Y-m-d', strtotime($nilai));
}

function jenisRawat($nilai)
{
	return $nilai = 1 ? 'R Jalan' : $nilai = 2 ? 'R Inap' : 'IGD';
}

function caraBayar($nilai)
{
	$cara_bayar = [
		3 => 'Asuransi Lain',
		8 => 'BPJS',
		9 => 'UMUM',
		1 => 'UMUM',
		4 => 'Keringan Dispensasi'
	];

	return $cara_bayar[$nilai];
}
