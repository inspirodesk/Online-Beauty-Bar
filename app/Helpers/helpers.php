<?php


if (!function_exists('formatSriLankanMobileNumber')) {
    function formatSriLankanMobileNumber($input) {
        // Remove all non-numeric characters
        $number = preg_replace('/\D/', '', $input);

        // Handle different cases
        if (strpos($number, '00') === 0) {
            $number = substr($number, 2);
        } elseif (strpos($number, '0') === 0) {
            $number = '94' . substr($number, 1);
        } elseif (strpos($number, '94') === 0 && strlen($number) === 10) {
            $number = '94' . $number;
        }

        // Ensure it starts with '94' and is 11 characters long
        if (strpos($number, '94') === 0 && strlen($number) === 11) {
            return $number;
        } else {
            return 'Invalid number';
        }
    }
}
