<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class SendNotification
{
    private $api_key = 'GE2vfRDLneB@wSCLSt+R';
    private $base_url = 'https://api.fonnte.com/send';

    public function sendMessageMasuk($number, $siswa)
    {
        $response = Http::acceptJson()->withHeaders(["Authorization" => $this->api_key])
                ->post($this->base_url, [
                    'target' => $number,
                    'message' => 'Anak Anda Bernama '.$siswa.' Sudah Masuk Sekolah',
                    'countryCode' => '62'
                ]);
        
        return $response->object();
    }
    public function sendMessagePulang($number, $siswa)
    {
        $response = Http::acceptJson()->withHeaders(["Authorization" => $this->api_key])
                ->post($this->base_url, [
                    'target' => $number,
                    'message' => 'Anak Anda Bernama '.$siswa.' Sudah Pulang dari Sekolah',
                    'countryCode' => '62'
                ]);

        return $response->object();
    }
}