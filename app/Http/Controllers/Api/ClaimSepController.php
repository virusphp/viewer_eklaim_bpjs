<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequest;
use App\Http\Requests\UpdateRequest;
use App\Repository\Api\ClaimSep;

class ClaimSepController extends Controller
{
    protected $claimSep;

    public function __construct()
    {
        $this->claimSep = new ClaimSep();
    }

    public function index($noSep)
    {
        $request = $this->claimSep->getKlaim($noSep);

        return response()->json($request);
    }

    public function create(CreateRequest $request)
    {
        $saveClaim = $this->claimSep->simpan($request);
        return response()->json($saveClaim);
    }

    public function update(UpdateRequest $request, $noReg)
    {
        // dd($request->all());
        $editClaim = $this->claimSep->cari($noReg);
        // dd($editClaim);
        if ($editClaim->periksa == 0 || $editClaim->periksa == 2) {
            // dd($editClaim->periksa, $request->all());
            $editedClaim = $this->claimSep->update($request, $editClaim);
        } else if($editClaim->periksa == 1) {
            $editedClaim = ['kode' => 403, 'pesan' => 'Data yang di edit Sudah di verifikasi'];
        } else {
            $editedClaim = ['kode' => 500, 'pesan' => 'Data yang di edit tidak di temukan'];
        }

        return response()->json($editedClaim);
    }

    public function delete(Request $request)
    {
        $deleteClaim = $this->claimSep->delete($request);

        return response()->json($deleteClaim);
    }
}
