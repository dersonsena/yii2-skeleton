<?php

if (!function_exists('isDateUs')) {
    function isDateUs(string $date): bool
    {
        if (empty($date)) {
            return false;
        }

        return preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date) > 0;
    }
}

if (!function_exists('isDateTimeUs')) {
    function isDateTimeUs(string $dateTime): bool
    {
        if (empty($dateTime)) {
            return false;
        }

        return preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $dateTime) > 0;
    }
}

if (!function_exists('isDateTimeIso')) {
    function isDateTimeIso(string $dateTime): bool
    {
        if (empty($dateTime)) {
            return false;
        }

        return preg_match(
            '/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(Z|(\+|-)\d{2}(:?\d{2})?)$/',
            $dateTime
        ) > 0;
    }
}

if (!function_exists('convertDatetimeIsoToUs')) {
    function convertDatetimeIsoToUs(string $dateTime): string
    {
        if (empty($dateTime)) {
            return '';
        }

        return (new DateTimeImmutable($dateTime))->format('Y-m-d H:i:s');
    }
}
