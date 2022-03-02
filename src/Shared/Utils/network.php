<?php

if (!function_exists('ip')) {
    function ip(): ?string
    {
        return $_SERVER['HTTP_CLIENT_IP']
            ?? $_SERVER['HTTP_X_FORWARDED_FOR']
            ?? $_SERVER['HTTP_X_FORWARDED']
            ?? $_SERVER['HTTP_FORWARDED_FOR']
            ?? $_SERVER['HTTP_FORWARDED']
            ?? $_SERVER['REMOTE_ADDR']
            ?? null;
    }
}

if (!function_exists('url')) {
    function url(string $path): string
    {
        return $_ENV['APP_BASE_URL'] . str_replace('//', '/', "/{$path}");
    }
}
