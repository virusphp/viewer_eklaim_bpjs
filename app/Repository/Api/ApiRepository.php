<?php

namespace App\Repository\Api;
use Telegram\Bot\Laravel\Facades\Telegram;
use DB;

class ApiRepository
{
    protected function sendMessage($pasien, $pegawai, $pelayanan, $status, $data)
    {
        $jumlahUpload = $this->getJumlah($pegawai->kd_pegawai);
        $text = $this->parsingMessage($pasien, $pegawai, $pelayanan, $status, $jumlahUpload, $data);
        
        // // dd($text, env('TELEGRAM_GROUP_ID'));
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_GROUP_ID'),
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
    }

    protected function parsingMessage($params, $pegawai, $pelayanan, $status, $jumlah, $data)
    {
        $text = "Data Viewer :\n"
                ."💳‍ : $params->no_rm\n"
                ."🙍🏻‍♂️ : $params->nama_pasien\n"
                ."💳‍ : ".maskCard($params->no_kartu)."\n"
                ."🏠 : $params->tempat_lahir\n"
                ."🚻 : ".kelamin($params->jns_kel) ."\n"
                ."🏥 : ".jenisRawat($pelayanan) ."\n"
                ."User $status : $pegawai->nama_pegawai\n"
                ."Jumlah Upload Hari ini : $jumlah\n"
                ."Data berhasil Di uploads";
        return $text;
    }

    protected function getJumlah($kdPegawai)
    {
        $tglCreated = date('Y-m-d');
        return DB::table('sep_claim')->where([
            ['user_created', $kdPegawai],
            ['tgl_created', $tglCreated]
        ])->count();
    }

}