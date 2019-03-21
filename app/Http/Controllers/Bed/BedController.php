<?php

namespace App\Http\Controllers\Bed;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Bed\Bed;
use App\Service\Bed\ServiceBed;

class BedController extends Controller
{

    protected $bed, $serviceBed;

    public function __construct()
    {
        $this->bed = new Bed;
        $this->serviceBed = new ServiceBed;
    }

    public function index()
    {
        return view('simrs.bed.index');
    } 

    public function search(Request $request, Bed $bed)
    {
        if ($request->ajax()) {
            $no = 1;
            $data = json_decode($bed->getSearch());
            foreach($data as $q) {
               
                $query[] = [
                    'no' => $no++,
                    'kodekelas' => $q->kodekelas,
                    'koderuang' => $q->koderuang,
                    'namaruang' => $q->namaruang,
                    'kapasitas' => $q->kapasitas,
                    'tersedia' => $q->tersedia,
                    'tersediapria' => $q->tersediapria,
                    'tersediawanita' => $q->tersediawanita,
                    'tersediapriawanita' => $q->tersediapriawanita,
                ];
            }
            $result = isset($query) ? ['data' => $query] : ['data' => 0];
            return json_encode($result);
        }
    }

    public function postBed()
    {
       $data = json_decode($this->bed->getSearch());
       $result = [];
       foreach($data as $key => $v)
       {
        //   $result[$key]['kodekelas'] = $v->kodekelas;
        //   $result[$key]['koderuang'] = $v->koderuang;
           count($data) and print "Inserting data... \n".json_encode($v)."\n\n\n" and  $this->serviceBed->postBed(json_encode($v));
       }
    //    foreach($result as $val)
    //    {
    //        count($data) and print "Deleting data... \n".json_encode($val)."\n\n\n" and  $this->serviceBed->deleteBed(json_encode($val));
    //    }
       return;
    }
}
