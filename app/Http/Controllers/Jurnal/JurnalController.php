<?php

namespace App\Http\Controllers\Jurnal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JurnalController extends Controller
{
    //
    public function indexLo()
    {
        return view('jurnal.lo.index');
    }
}
