<?php

if (!function_exists('formatPhoneNumber')) {
    function formatPhoneNumber($number)
    {
        $number = preg_replace('/[^0-9]/', '', $number);

        if (substr($number, 0, 2) === '62') {
            $formatted = '+62 ' . substr($number, 2, 3) . '-' . substr($number, 5, 4) . '-' . substr($number, 9);
        } else {
            $formatted = $number;
        }

        return $formatted;
    }
}
