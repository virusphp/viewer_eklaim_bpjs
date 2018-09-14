<?php
namespace App\Views\Composers;

use Illuminate\View\View;
use DB;

class SearchComposer
{
    public function compose(View $view)
	{
		$this->composeCaraBayar($view);
		$this->composeJRawat($view);
	}

    public function composeCaraBayar(View $view)
    {
        $cara_bayar = DB::table('cara_bayar')
            ->select('kd_cara_bayar','keterangan')->where('kd_cara_bayar', '!=', '0')->get();
        $view->with('cara_bayar', $cara_bayar);
    }

    public function composeJRawat(View $view)
    {
        $j_rawat = DB::connection('sqlsrv')->table('Kwitansi_Header')
            ->select('jenis_rawat')->where('jenis_rawat', '!=', '0')->groupBy('jenis_rawat')->get();
        $view->with('j_rawat', $j_rawat);
    }
}