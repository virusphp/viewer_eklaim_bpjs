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

    public function index()
    {
        return response()->json($this->claimSep->getAll());
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
        if ($editClaim) {
            // dd($editClaim, $request->all());
            $editedClaim = $this->claimSep->update($request, $editClaim);
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
