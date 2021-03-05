<?php


namespace Ssf\Copy\Tools;

use Carbon\Carbon;
use Ssf\Copy\Framework\Container;
use Symfony\Component\Dotenv\Dotenv;
use Throwable;

/**
 * Class Helpers
 * @package Ssf\Copy\Tools
 */
class Helpers
{

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public static function env($key, $default = null)
    {
        $envPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '.env';
        $dotenv = new Dotenv('APP_ENV');
        $dotenv->overload($envPath);
        return isset($_ENV[$key]) ? $_ENV[$key] ?: $default : $default;
    }

    /**
     * @param null $format
     * @return Carbon|string
     */
    public static function today($format = null)
    {
        return $format ? Carbon::now()->format($format) : Carbon::now();
    }

    /**
     * @param null $path
     * @return string
     */
    public static function storage_path($path = null)
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'storage' . ($path ? DIRECTORY_SEPARATOR . $path : null);
    }

    /**
     * @param null $key
     * @param null $default
     * @return mixed|null
     */
    public static function config($key = null, $default = null)
    {
        $configPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config';
        $path = explode('.', $key);
        $file = $path[0];
        unset($path[0]);
        $config = require $configPath . DIRECTORY_SEPARATOR . "$file.php";
        foreach ($path as $str)
            $config = $config && isset($config[$str]) ? $config[$str] : null;
        return $config ?: $default;
    }

    /**
     * @param null $abstract
     * @param array $parameters
     * @return mixed|Container|null
     */
    public static function app($abstract = null, array $parameters = [])
    {
        if (is_null($abstract)) {
            return Container::getInstance();
        }

        return Container::getInstance()->resolve($abstract);
    }

    /**
     * @param Throwable $e
     * @param bool $quiet
     */
    public static function signal(Throwable $e, bool $quiet = false)
    {
        if ($quiet === false && php_sapi_name() == "cli") {
            echo PHP_EOL . "\033[01;33m" . $e->getFile() . "(" . $e->getLine() . ") : \033[0m" . PHP_EOL . PHP_EOL;
            echo "\033[01;31m" . $e->getMessage() . "\033[0m" . PHP_EOL . PHP_EOL;
        }
        Log::error($e);
    }


}