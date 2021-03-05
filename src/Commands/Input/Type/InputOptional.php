<?php
/**
 * This file contains InputOptional class.
 * @author Akbly Sofiane <sofiane.akbly@gmail.com>
 */

namespace Ssf\Copy\Commands\Input\Type;


use Ssf\Copy\Commands\Input\Input;

/**
 * Class InputOptional
 * Cette classe permet de définir des arguments & options facultatifs.
 * @package Ssf\Copy\Commands\Input\Type
 * @see Input
 */
class InputOptional extends Input
{

    /**
     * @param string $name
     * @param bool $required
     * @param mixed|null $default
     * @param string $description
     * @return array
     * @see Input::value()
     */
    protected static function value(string $name, bool $required = false, $default = null, string $description = ''): array
    {
        return parent::value($name, $required, $default, $description); // TODO: Change the autogenerated stub
    }

    /**
     * @param string $name
     * @param $default
     * @param string $description
     * @return array
     */
    public static function option(string $name, $default, $description = '')
    {
        return self::value($name, false, $default, $description);
    }

}