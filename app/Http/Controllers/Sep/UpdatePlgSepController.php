<?php

namespace App\Http\Controllers\Sep;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Sep\Registrasi;
Use DateTime;
use App\Repository\Sep\Sep;

class UpdatePlgSepController extends Controller
{
    protected $conn; 

    public function __construct()
    {
        $this->conn = new Sep();
      
    }

    public function index()
    {
        return view('simrs.update_pulang.index');
    } 

    /**
     * search function
     *
     * @param Request $request
     * @param Registrasi $ri
     * @return void
     */ 
    public function search(Request $request, Registrasi $ri)
    {
        if ($request->ajax()) {
            $no = 1;
            $data = $ri->getSearchRi($request);
            foreach($data as $q) {
                $tgl = new DateTime($q->tgl_reg);
                if ($q->no_sjp <= 15) {
                    $button = '<button type="button" class="btn btn-sm btn-warning" id="edit-item" disabled>Update Pulang</button>';
                } else {
                    $button = '<button type="button" value="'.$q->no_reg.'" class="btn btn-sm btn-warning" id="edit-pulang" data-sep="'.$q->no_sjp.'">Update Pulang</button>';
                }
                $query[] = [
                    'no' => $no++,
                    'no_reg' => $q->no_reg,
                    'no_rm' => $q->no_rm,
                    'nama_pasien' => $q->nama_pasien,
                    'tgl_reg' => $tgl->format('Y-m-d'),
                    'jns_rawat' => jenisRawat($q->jns_rawat),
                    'no_sjp' => $q->no_sjp,
                    'kd_cara_bayar' => caraBayar($q->kd_cara_bayar),
                    'aksi' => $button
                ];
            }
            $result = isset($query) ? ['data' => $query] : ['data' => 0];
            return json_encode($result);
        }
    }

    public function simpanPulang(Request $req)
    {
        if ($req->ajax()) {
            $data = $req->all();
            $data['ppkPelayanan'] = ppk($data['noSep']);
            $result = $this->conn->simpanPulang($data);
            return $result;
        }
    }
}
