<?php

namespace App\Repository\Api;

use DB;
use File;
use Illuminate\Support\Facades\Storage;

class ClaimSep
{
    public function getAll()
    {
        $data = DB::table('sep_claim')->get();
        if ($data->count() != 0) {
            $result = $data;
        } else {
            $result = ['kode' => 201, 'pesan' => 'Data belum ada'];
        }
        return  $result;
    }

    public function getKlaim($noSep)
    {
        $data = DB::table('sep_claim')->where('no_sep', $noSep)->first();
        $data->file_claim = $this->getFile($data->tgl_sep) . $data->file_claim;
        return $data;
    }

    public function getFile($tanggal)
    {
        return url("/") . '/storage/verifikasi/' . \tanggalPdf($tanggal) . "/";
    }

    public function cari($no_reg)
    {
        $data = DB::table('sep_claim')->where('no_reg', $no_reg)->first();
        return $data;
    }

    public function simpan($request)
    {
        $data = $this->handleFile($request);
        // dd(substr($data['no_reg'], 0, 2));
        $simpan = DB::table('sep_claim')
            ->insert([
                'no_reg'        => $data['no_reg'],
                'no_rm'         => $data['no_rm'],
                'no_sep'        => $data['no_sep'],
                'tgl_sep'       => $data['tgl_sep'],
                'file_claim'    => $data['file_claim'],
                'jns_pelayanan' => substr($data['no_reg'], 0, 2),
            ]);

        if ($simpan) {
            $message = ['kode' => 200, 'pesan' => 'Data berhasil di simpan!'];
        } else {
            $message = ['kode' => 500, 'pesan' => 'Ada kesalahan sistem'];
        }

        return $message;
    }

    public function update($request, $claimOld)
    {
        $oldFile = $claimOld->file_claim;
        // dd($claimOld->file_claim);
        if ($oldFile !== $request->file_claim) {
            $this->deleteFile($claimOld);
        }

        $data = $this->handleFile($request);

        $update = DB::table('sep_claim')
            ->where('no_reg', $claimOld->no_reg)
            ->update([
                'no_rm'         => $data['no_rm'],
                'no_sep'        => $data['no_sep'],
                'tgl_sep'       => $data['tgl_sep'],
                'file_claim'    => $data['file_claim'],
                'jns_pelayanan' => substr($data['no_reg'], 0, 2)
            ]);

        return $this->Message($update, "update");
    }

    public function delete($request)
    {
        $data = DB::table('sep_claim')->where('no_reg', $request->no_reg)->first();

        if (!empty($data->file_claim)) {
            $this->deleteFile($data);
        }

        $delete = DB::table('sep_claim')->where('no_reg', $request->no_reg)->delete();

        return $this->message($delete, "delete");

        // return $message;
    }

    public function deleteFile($data)
    {
        $path = $this->getDestination($data->tgl_sep) .  $data->file_claim;
        // dd($path);
        return Storage::disk('public')->delete($path);
    }

    public function handleFile($request)
    {
        $data = $request->all();

        if ($request->hasFile('file_claim')) {
            $file =  $request->file('file_claim');
            $extensi = $file->getClientOriginalExtension();
            $formatName = str_replace(' ', '_', $data['no_rm'] . ' ' . $data['no_sep'] . '.' . $extensi);
            $pathFile = $this->getDestination($data['tgl_sep']) . $formatName;
            // dd($pathFile);
            $urlPath = $data['tgl_sep'] . '/' . $formatName;

            Storage::disk('public')->put($pathFile, File::get($file));

            $data['file_claim'] = $formatName;
            $data['full_path'] = $urlPath;
        }

        return $data;
    }

    public function getDestination($tanggal)
    {
        return 'verifikasi' . DIRECTORY_SEPARATOR . tanggalPdf($tanggal) . DIRECTORY_SEPARATOR;
    }

    public function Message($data, $pesan)
    {
        if ($data) {
            $message = ['kode' => 200, 'pesan' => 'Data berhasil di ' . $pesan . '!'];
        } else {
            $message = ['kode' => 500, 'pesan' => 'Ada kesalahan sistem'];
        }

        return $message;
    }
}
