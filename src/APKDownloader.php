<?php

class APKDownloader{

    private $time;
    private $token;

    public function __construct(){
        $ch = curl_init('https://apps.evozi.com/apk-downloader/');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36',
            CURLOPT_FOLLOWLOCATION => 3,
        ]);
        $data = curl_exec($ch);
        if(preg_match('/{t:(.*?),/', $data, $time) && preg_match('/bccddbffabafc:(.*?),/', $data, $key)){
            $token_key = trim($key[1]);
            if(preg_match('/var '.$token_key.' = (.*?);/', $data, $match)){
                $this->time = trim($time[1]);
                $this->token = trim(trim($match[1]), '\'');
            } else {
                throw new Exception('Can\'t fetch download token from Evozi APK Downloader.');
            }
        } else {
            throw new Exception('Can\'t fetch download token key from Evozi APK Downloader.');
        }
    }

    public function fetch($package_name, $force_refetch = false){
        $force_refetch = ($force_refetch) ? 'true' : 'false';
        $data = http_build_query(['t' => $this->time, 'efcbfdeaacebadc' => $package_name, 'bccddbffabafc' => $this->token, 'fetch' => $force_refetch]);
        $ch = curl_init('https://api-apk.evozi.com/download');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36',
            CURLOPT_HTTPHEADER => ['accept: application/json, text/javascript, */*; q=0.01', 'accept-language: en-US,en;q=0.9,hi;q=0.8', 'cache-control: no-cache', 'content-length: '.strlen($data), 'content-type: application/x-www-form-urlencoded; charset=UTF-8', 'origin: https://apps.evozi.com', 'pragma: no-cache', 'referer: https://apps.evozi.com/apk-downloader/'],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data
        ]);
        $data = curl_exec($ch);
        $response = @json_decode($data);
        if($response){
            return $response;
        } else {
            return false;
        }
    }

}
