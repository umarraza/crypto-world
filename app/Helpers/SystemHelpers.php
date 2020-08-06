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

        try {

            $json = file_get_contents($jsnsrc);
            $json = json_decode($json);
            $btcrate = $json->USD->last;
            return $btcrate;

        } catch (\Throwable $th) {

            throw new GeneralException(__('Something went wrong. Please try again latter.'));
        }



    }
}