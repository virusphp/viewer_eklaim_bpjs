<?php

namespace App\Http\Controllers\Sep;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Rujukan;

class RujukanController extends Controller
{
    public function getRujukanInternal(Request $request, Rujukan $rujukan)
    {
        $data = $request->all();
        $getRujukan = $rujukan->getRujukan($data); 
        return response()->json($getRujukan);
    }
}
