<?php


namespace App\Services\Person\Http;


class Request
{
    public function get($endpoint, array $getFields = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint . http_build_query($getFields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $data = curl_exec($ch);
        if (json_decode($data) === false) {
            throw new \Exception(curl_error($ch), curl_errno($ch));
        }
        curl_close($ch);
        return $data;
    }
}
