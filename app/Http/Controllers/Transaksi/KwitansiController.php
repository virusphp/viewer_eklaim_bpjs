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
    public function index()
    {
        return view('transaksi.kwitansi.index');
    }

    public function search(Request $request,KwitansiHeader $kw)
    {
        if($request->ajax()){
            $no=1;
            $getdata=$kw->getSearch($request);   
            foreach ($getdata as $q) {
                $query[] = array(
                    'no' => $no++,
                    'no_kwitansi' => $q->no_kwitansi,
                    'tgl_kwitansi' => tanggal($q->tgl_kwitansi),
                    'jenis_pasien' => $q->jenis_pasien,
                    'jenis_rawat' => $q->jenis_rawat,
                    'untuk' => $q->untuk,
                    'jml_tagihan' => rupiah($q->tagihan),
                    'aksi' => '<a href="'.route('kwitansi.get', $q->no_kwitansi).'" id="mtagihan" class="btn btn-success btn-sm">
                                    <i class="icon-eye icons"></i> view
                                </a>',
                );
            }
            $result = isset($query) ? array('data' => $query): array('data' => 0);
            return json_encode($result);
        }
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

    public function getKwitansi(Kwitansi $kw, $no_kwitansi)
    {
        $kwitansi = $kw->getDetail($no_kwitansi);
        return view('transaksi.kwitansi.rincian', compact('kwitansi'));
    }
}
