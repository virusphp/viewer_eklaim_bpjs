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
        if ($data) {
            $data->file_claim = $this->getFile($data->tgl_sep) . $data->file_claim;
            $meta = ["kode" => 200, "pesan" => "Sukses"];
            $response = $this->remap($meta, $data);
        } else {
            $meta = ["kode" => 201, "pesan" => "Data tidak ditemukan!!!"];
            $response = $this->remap($meta, null);
        }

        // dd($response);
        return $response;
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
        $unique = DB::table('sep_claim')->select('no_reg')->where('no_reg', $request->no_reg)->first();

        if ($unique) {
            if ($unique->no_reg === $request->no_reg) {
                $message = ['kode' => 422, 'pesan' => 'No Registrasi sudah ada mohon edit untuk mengubah'];
            } else {
              $message = $this->handleSimpan($request); 
            }
        } else {
            $message = $this->handleSimpan($request); 
        }
        
        return $message;
    }

    private function cekPasien($noRm)
    {
        return DB::table('pasien')->select('nama_pasien')->where('no_rm', $noRm)->first();
    }

    private function handleSimpan($request) 
    {
        $pasien = $this->cekPasien($request->no_rm);

        if (!$pasien) {
            $message = ['kode' => 201, 'pesan' => 'No RM tidak di ketahui'];
        } else {
            $data = $this->handleFile($request, $pasien->nama_pasien);
        
            $simpan = DB::table('sep_claim')
                ->insert([
                    'no_reg'        => $data['no_reg'],
                    'no_rm'         => $data['no_rm'],
                    'no_sep'        => $data['no_sep'],
                    'tgl_sep'       => $data['tgl_sep'],
                    'tgl_pulang'    => $data['tgl_pulang'],
                    'file_claim'    => $data['file_claim'],
                    'jns_pelayanan' => substr($data['no_reg'], 0, 2),
                    'tgl_created'   => date('Y-m-d'),
                    'user_created'  => $data['user_id']
                ]);

            if ($simpan) {
                 $message = $this->Message($simpan, "simpan");
            }
        }
        return $message;
    }

    public function update($request, $claimOld)
    {
        $pasien = DB::table('pasien')->select('nama_pasien')->where('no_rm', $request->no_rm)->first();
        
        if (!$pasien) {
             $message = ['kode' => 201, 'pesan' => 'No RM tidak di ketahui'];
        } else {

            $oldFile = $claimOld->file_claim;

            if ($oldFile !== $request->file_claim) {
                $this->deleteFile($claimOld);
            }
            
            $data = $this->handleFile($request, $pasien->nama_pasien);

            $update = DB::table('sep_claim')
                ->where('no_reg', $claimOld->no_reg)
                ->update([
                    'no_rm'         => $data['no_rm'],
                    'no_sep'        => $data['no_sep'],
                    'tgl_sep'       => $data['tgl_sep'],
                    'tgl_pulang'    => $data['tgl_pulang'],
                    'file_claim'    => $data['file_claim'],
                    'jns_pelayanan' => substr($data['no_reg'], 0, 2),
                    'tgl_updated'   => date('Y-m-d'),
                    'user_updated'  => $data['user_id']
                ]);
        }

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
    }

    public function deleteFile($data)
    {
        $path = $this->getDestination($data->tgl_sep) .  $data->file_claim;
        
        return Storage::disk('public')->delete($path);
    }

    public function handleFile($request, $namaPasien)
    {
        $data = $request->all();

        if ($request->hasFile('file_claim')) {
            $file =  $request->file('file_claim');
            $extensi = $file->getClientOriginalExtension();
            $formatName = str_replace(' ', '_', $data['no_sep'] . ' ' . $namaPasien .' '. $data['no_rm'] . '.' . $extensi);
            $pathFile = $this->getDestination($data['tgl_sep']) . $formatName;

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

    private function remap($status, $data)
    {
        $res['metaData'] = $status;
        $res['response'] = $data;

        return $res;
    }

}
