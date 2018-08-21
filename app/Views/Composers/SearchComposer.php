<?php
namespace App\Views\Composers;

use Illuminate\View\View;
use DB;

class SearchComposer
{
    public function compose(View $view)
	{
		$this->composeJPasien($view);
		$this->composeJRawat($view);
	}

    public function composeJPasien(View $view)
    {
        $j_pasien = DB::connection('sqlsrv')->table('Kwitansi_Header')
            ->select('jenis_pasien')->where('jenis_pasien', '!=', '0')->groupBy('jenis_pasien')->get();
        $view->with('j_pasien', $j_pasien);
    }

    public function composeJRawat(View $view)
    {
        $j_rawat = DB::connection('sqlsrv')->table('Kwitansi_Header')
            ->select('jenis_rawat')->where('jenis_rawat', '!=', '0')->groupBy('jenis_rawat')->get();
        $view->with('j_rawat', $j_rawat);
    }
}