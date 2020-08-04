<?php

namespace App\Repository\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class ApiRepository
{
    protected function sendMessage($params)
    {
        $text = $this->parsingMessage($params);
        // dd($text, env('TELEGRAM_GROUP_ID'));
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_GROUP_ID'),
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
    }

    protected function parsingMessage($params)
    {
        $text = "Data Viewer :\n"
                ."🙍🏻‍♂️ : ".maskCard($params->nama_pasien). "\n"
                ."💳‍ : ".maskCard($params->no_kartu)."\n"
                ."🏠 : $params->tempat_lahir\n"
                ."🚻 : ".kelamin($params->jns_kel) ."\n"
                ."Berhasil Di uploads";
        return $text;
    }
}