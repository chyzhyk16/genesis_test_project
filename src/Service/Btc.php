<?php


namespace App\Service;


class Btc
{
    public function getBtcRate(){
        $url = 'https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=5';
        $response = file_get_contents($url);
        if ($response) {
            $rates = json_decode($response);
            foreach ($rates as $exchangeRate) {
                if (isset($exchangeRate->ccy) && $exchangeRate->ccy === 'USD') {
                    $usd_rate = ($exchangeRate->buy + $exchangeRate->sale) / 2;
                } elseif (isset($exchangeRate->ccy) && $exchangeRate->ccy === 'BTC') {
                    $btc_rate = ($exchangeRate->buy + $exchangeRate->sale) / 2;
                }
            }
            if ($usd_rate && $btc_rate){
                return  $btc_rate * $usd_rate;
            }
        }
        return null;
    }
}