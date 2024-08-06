<?php

namespace App\Helpers;

class ConfigHelper
{
    public static function getWooCommerceUrl()
    {
        return env('WOOCOMMERCE_URL');
    }

    public static function getWooCommerceConsumerKey()
    {
        return env('WOOCOMMERCE_CONSUMER_KEY');
    }

    public static function getWooCommerceConsumerSecret()
    {
        return env('WOOCOMMERCE_CONSUMER_SECRET');
    }

    public static function getApiKey()
    {
        return env('API_KEY');
    }

    public static function getFdeClientId()
    {
        return env('FDE_CLIENT_ID');
    }
}
