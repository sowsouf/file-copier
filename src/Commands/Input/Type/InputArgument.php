<?php
/**
 * This file contains InputArgument class.
 * Cette classe contient le code permettant de créer
 * le tableau contentant les arguments des commandes
 * console.
 *
 * @author Akbly Sofiane <sakbly@pndata.tech>
 */

namespace PNdata\Copy\Commands\Input\Type;


/**
 * Class InputArgument
 * @package PNdata\Copy\Commands\Input\Type
 */
class InputArgument
{

    /**
     * Crée un tableau contenant les variables de type
     * arguments.
     *
     * @param mixed ...$args
     * @return array
     */
    public static function create(...$args)
    {
        $arguments = array('type' => 'arguments', 'values' => []);
        foreach ($args as $arg)
            $arguments['values'][] = $arg;
        return $arguments;
    }

}