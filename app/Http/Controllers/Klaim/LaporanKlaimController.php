<?php

namespace App\Http\Controllers\Klaim;

use App\Exports\LaporanExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Sep\Eklaim;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LaporanKlaimController extends Controller
{
    protected $eklaim;

    public function __construct()
    {
        $this->eklaim = new Eklaim;
    }
    /**
     * Show All data claim
     * @params request
     */
    public function index()
    {
        return view('simrs.laporan.index');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $no = 1;
            $user = Auth::user()->role;
            $userUpload = Auth::user()->kd_pegawai;
            $data = $this->eklaim->getLaporan($request);
            foreach($data as $q) {
                $query[] = [
                    'no'          => $no++,
                    'no_kartu'    => $q->no_kartu,
                    'no_sep'      => $q->no_sep,
                    'no_rm'       => $q->no_rm,
                    'nama_pasien' => $q->nama_pasien,
                    'status'      => statusKlaim($q->periksa),
                    'tgl_sep'     => date('d-m-Y', strtotime($q->tgl_sep)),
                    'tgl_pulang'  => date('d-m-Y', strtotime($q->tgl_pulang)),
                    'user'        => $user == "operator" ? "n" : $q->user_verified
                    // 'checked' => $btnCheck,
                ];
            }
            $result = isset($query) ? ['data' => $query] : ['data' => 0];
            return json_encode($result);
        } 
    }

    public function export(Request $request)
    {
        return Excel::download(new LaporanExport($request), 'Export-Eklaim-' .$request->tgl_plg.'.xls'); 
    }
}
