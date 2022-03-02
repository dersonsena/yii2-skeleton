<?php

if (!function_exists('stripAccents')) {
    function stripAccents(string $value): string
    {
        return strtr(
            $value,
            'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
            'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'
        );
    }
}

if (!function_exists('dashesToCamelCase')) {
    function dashesToCamelCase(string $string, bool $capitalizeFirst = false): string
    {
        $string = str_replace('-', '', ucwords($string, '-'));

        if (!$capitalizeFirst) {
            $string = lcfirst($string);
        }

        return $string;
    }
}

if (!function_exists('underscoreToCamelCase')) {
    function underscoreToCamelCase(string $string, bool $capitalizeFirst = false): string
    {
        $string = str_replace('_', '', ucwords($string, '_'));

        if (!$capitalizeFirst) {
            $string = lcfirst($string);
        }

        return $string;
    }
}

if (!function_exists('camelCaseToUnderscores')) {
    function camelCaseToUnderscores(string $string, bool $capitalizeFirst = false): string
    {
        $string = mb_strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));

        if (!$capitalizeFirst) {
            $string = lcfirst($string);
        }

        return $string;
    }
}

if (!function_exists('getFileNameFromFullPath')) {
    function getFileNameFromFullPath(string $fullPath): string
    {
        $fileName = explode(DIRECTORY_SEPARATOR, $fullPath);
        return end($fileName);
    }
}

if (!function_exists('getStringFileExtension')) {
    function getStringFileExtension(string $fileName): string
    {
        $n = strrpos($fileName, ".");
        return ($n === false) ? "" : substr($fileName, $n + 1);
    }
}

if (!function_exists('imagePathToBase64')) {
    function imagePathToBase64(string $path): string
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return "data:image/{$type};base64," . base64_encode($data);
    }
}
