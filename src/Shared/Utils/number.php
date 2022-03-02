<?php

if (!function_exists('force2Decimals')) {
    function force2Decimals(float $number): float
    {
        return floor($number * 100) / 100;
    }
}
