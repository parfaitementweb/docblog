<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

if (! function_exists('locale_url')) {
    function locale_url($url, $locale = null)
    {
        if (! $locale) {
            $locale = LaravelLocalization::getCurrentLocale();
        }

        return LaravelLocalization::getLocalizedURL($locale, $url);
    }
}
