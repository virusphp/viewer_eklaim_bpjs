<?php

namespace App\Http\Controllers\Transaksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Transaksi\KwitansiHeader;
use App\Repository\Transaksi\Kwitansi;
use DB;
use Validator;

class KwitansiController extends Controller
{
    protected $kw;
    public function __construct()
    {
        $this->kw = new Kwitansi();
    }

    public function index()
    {
        return view('transaksi.kwitansi.index');
    }

    public function search(Request $request,KwitansiHeader $kw)
    {
        if($request->ajax()){
            $no=1;
            $getdata=$kw->getSearch($request);
            // dd($getdata);  
            foreach ($getdata as $q) {
                $query[] = array(
                    'no' => $no++,
                    'no_kwitansi' => $q->no_kwitansi,
                    'tgl_kwitansi' => tanggal($q->tgl_kwitansi),
                    'jenis_pasien' => $q->jenis_pasien,
                    'jenis_rawat' => $q->jenis_rawat,
                    'untuk' => $q->untuk,
                    'jml_tagihan' => rupiah($q->tagihan),
                    'aksi' => '<form action="'.route('kwitansi.get').'" method="POST" id="mtagihan" class="btn btn-success btn-sm">
                                    <input type="hidden" name="no_kwitansi" value="'.$q->no_kwitansi.'">
                                    <input type="hidden" name="_token" value="'.csrf_token().'">
                                    <button type="submit" class="icon-eye icons"> view</button>
                                </form>',
                );
            }
            $result = isset($query) ? array('data' => $query): array('data' => 0);
            return json_encode($result);
        }
    }

    public function getKwitansi(Request $request)
    {
        // dd($request->all());
        $debet = $this->kw->getDebet($request->no_kwitansi);
        $kredit = $this->kw->getKredit($request->no_kwitansi);
        // dd($kredit);
        // return response()->json($kwitansi);
        return view('transaksi.kwitansi.rincian', compact('debet', 'kredit'));
    }

    public function search2(Request $request,KwitansiHeader $kw)
    {
        if($request->ajax()){
            $output=""; 
            $i=1;
            // dd($request->tgl,$request->jns_rawat,$request->jns_pasien);
            $data=$kw->getSearch($request);               
            if($data) {                
                foreach ($data as $key => $q) {                
                $output.='<tr>'.                
                    '<td>'.$i++.'</td>'.                
                    '<td>'.$q->no_kwitansi.'</td>'.                
                    '<td>'.tanggal($q->tgl_kwitansi).'</td>'.   
                    '<td>'.$q->jenis_pasien.'</td>'.  
                    '<td>'.$q->jenis_rawat.'</td>'.               
                    '<td>'.$q->untuk.'</td>'.    
                    '<td>'.rupiah($q->tagihan).'</td>'.   
                    '<td>
                        <a href="'.route("kwitansi.get", $q->no_kwitansi).'" id="mtagihan" class="btn btn-success btn-sm">
                            <i class="icon-eye icons"></i> view
                        </a>
                    </td>'.           
                    '</tr>';                
                }
                
            }
            return Response($output);
        }   
    }
}
