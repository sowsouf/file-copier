<?php


namespace PNdata\Copy\Facades;


/**
 * Class File
 * @package PNdata\Copy\Facades
 */
class File
{

    /**
     * @param string $path
     * @param array|string[] $separators
     * @return string
     */
    public static function dirname(string $path, array $separators = ['/', '\\']): string
    {
        if (!is_null($path)) {
            if (in_array(($separator = $path[strlen($path) - 1]), $separators)) {
                $path = str_replace($separators, DIRECTORY_SEPARATOR, $path);
                $values = array_filter(
                    explode(DIRECTORY_SEPARATOR, $path),
                    fn($item) => $item && $item !== ''
                );
                return DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $values);
            }
        }

        return str_replace($separators, DIRECTORY_SEPARATOR, dirname($path));
    }

}