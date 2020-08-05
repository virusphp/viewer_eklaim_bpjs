<?php

namespace App\Repository\Sep;
use Telegram\Bot\Laravel\Facades\Telegram;
use DB;

class SepRepository
{
    protected function sendMessage($data, $user_verified, $now)
    {
        $params = $this->getDataClaim($data->no_reg);
        $jumlah = $this->getJumlah($now);
        if ($data->periksa == 2) {
            $text = $this->parsingMessagePending($params, $user_verified, $now, $data->pesan );
        } else {
            $text = $this->parsingMessage($params, $user_verified, $now, $jumlah);
        }
        // dd($data->periksa, $params, $jumlah, $text); 
        
        // // dd($text, env('TELEGRAM_GROUP_ID'));
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_GROUP_ID'),
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
    }

    protected function parsingMessagePending($params, $user_verified, $now, $pesan)
    {
        $text = "Pending Verifikasi Data :\n"
                ."🙍🏻‍♂️ : $params->nama_pasien\n"
                ."💳‍ : ".maskCard($params->no_sep)."\n"
                ."🏥 : ".jenisRawat($params->jns_pelayanan) ."\n"
                ."Catatan : $pesan\n"
                ."Di Verifikasi Oleh : Testing\n"
                ."Data Pending pada : $now";
        return $text;
    }

    protected function parsingMessage($params, $user_verified, $now, $jumlah)
    {
        $text = "Verifikasi Data :\n"
                ."🙍🏻‍♂️ : $params->nama_pasien\n"
                ."💳‍ : ".maskCard($params->no_sep)."\n"
                ."🏥 : ".jenisRawat($params->jns_pelayanan) ."\n"
                ."Di Verifikasi Oleh : Testing\n"
                ."Jumlah Verified Hari ini : $jumlah\n"
                ."Data Terverifikasi pada : $now";
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