<?php

namespace App\Repository;
use DB;

class AkunPerkiraan
{
    public function getData($request)
    {
        $data = DB::table('akun_perkiraan')->select('no_perkiraan','nama_perkiraan')
            ->where(function($query) use ($request){
                if (($term = $request->get('search')) ) 
                {
                     $keywords = '%'. $term .'%';
                     $query->orWhere('no_perkiraan','LIKE', $keywords);
                     $query->orWhere('nama_perkiraan', 'LIKE', $keywords);
                } 
            })
            ->paginate(10);
        return $data;
    }
}