<?php

use App\Helpers\SystemHelpers;

if (! function_exists('CurrentBtcRate')) {
    /**
     * @param       $url
     * @param array $attributes
     * @param null  $secure
     *
     * @return mixed
     */
    function CurrentBtcRate()
    {
        $jsnsrc = "https://blockchain.info/ticker";
        $json = file_get_contents($jsnsrc);
        $json = json_decode($json);
        $btcrate = $json->USD->last;
        return $btcrate;
    }
}