<?php

namespace Alex\ManagementSystem\classes;

class CriptoApiClasses
{

    public function getQuotesData($id_cripto)
    {
        $data = array();

        if($id_cripto = 1){
            $cripto_url = "BITSTAMP_SPOT_BTC_USD";
        }elseif($id_cripto = 2){
            $cripto_url = "BITSTAMP_SPOT_ETH_USD";
        }

        $ch = curl_init();
        $headers = [
            'X-CoinAPI-Key: 046EEBE9-D117-4EF5-99E3-E51C7D1B91C8',
        ];
        $url = "https://rest.coinapi.io/v1/quotes/current?filter_symbol_id=".$cripto_url;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $req_output = (curl_exec($ch));

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($http_code >= 200 && $http_code < 400)
            $data = json_decode($req_output,true);

        return $data;
    }
}
