<?php

class CurlHandler
{
    public function execute(string $url, array $headers): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response === false) {
            throw new \Exception('cURL error: ' . curl_error($curl));
        }

        return $response;
    }
}
