<?php

namespace App\Repository\Sep;
use Telegram\Bot\Laravel\Facades\Telegram;
use DB;

class SepRepository
{
    protected function sendMessage($data, $user_verified, $now)
    {
        $params = $this->getDataClaim($data->reg);
        $jumlah = $this->getJumlah($now);
        $text = $this->parsingMessage($params, $user_verified, $now, $jumlah);
        
        // // dd($text, env('TELEGRAM_GROUP_ID'));
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_GROUP_ID'),
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
    }

    protected function parsingMessage($params, $user_verified, $now, $jumlah)
    {
        $text = "Data Viewer :\n"
                ."🙍🏻‍♂️ : $params->nama_pasien\n"
                ."💳‍ : ".maskCard($params->no_sep)."\n"
                ."🚻 : ".kelamin($params->jns_kel) ."\n"
                ."🏥 : ".jenisRawat($params->jns_pelayanan) ."\n"
                ."User Verifikasi : $user_verified verifikasi pada : $now\n"
                ."Jumlah Verified Hari ini : $jumlah\n"
                ."Data berhasil Di uploads";
        return $text;
    }

    protected function getJumlah($now)
    {
        return DB::table('sep_claim')->where([
            ['periksa', 1],
            ['tgl_verified', $now]
        ])->count();
    }

    protected function getDataClaim($noReg)
    {
        return DB::table('sep_claim as sc')
        ->select('sc.no_sep','sc.user_verified','jns_pelayanan','p.nama_pasien') 
        ->where(
            'no_reg', $noReg
        )
        ->join('pasien as p', 'sc.no_rm','=','p.no_rm')
        ->first();
    }

}