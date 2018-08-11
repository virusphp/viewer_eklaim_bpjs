<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\AkunPerkiraan;

class AkunPerkiraanController extends Controller
{
    public function index(Request $request, AkunPerkiraan $ak_p)
    {
        $ak_perkiraan = $ak_p->getData($request);
        $route = Route('akun.perkiraan');
        return view('master.akun_perkiraan.index', compact('ak_perkiraan', 'route'));
    }
}
