<?php
/**
 * This file contains InputOption class.
 * Cette classe contient le code permettant de créer
 * le tableau contentant les options des commandes
 * console.
 *
 * @author Akbly Sofiane <sakbly@pndata.tech>
 */

namespace PNdata\Copy\Commands\Input\Type;


/**
 * Class InputOption
 * @package PNdata\Copy\Commands\Input\Type
 */
class InputOption
{

    /**
     * Crée un tableau contenant les variables de type
     * arguments.
     *
     * @static
     * @param mixed ...$args
     * @return array
     */
    public static function create(...$args)
    {
        $options = array('type' => 'options', 'values' => []);
        foreach ($args as $arg)
            $options['values'][] = $arg;
        return $options;
    }

}