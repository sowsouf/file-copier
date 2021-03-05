<?php
/**
 * This file contains Input class.
 * @see \Ssf\Copy\Commands\Input\Input::value()
 *
 * @author Akbly Sofiane <sofiane.akbly@gmail.com>
 */


namespace Ssf\Copy\Commands\Input;

/**
 * Class Input
 * Cette classe est la classe mère des arguments et
 * options des commandes console. Elle permet de définir
 * la structure d'un <input> et de le créer
 * La structure d'un champ <input> est definie
 * au niveau de la méthode value
 * @package Ssf\Copy\Commands\Input
 */
class Input
{
    /**
     * @param string $name Nom du champ, tel que souhaité en ligne de commande.
     * @param bool $required Définir si le champ est requis ou non.
     * @param mixed|null $default Valeur par défaut
     * @param string $description Description courte (ou pas) du champ
     * @return array
     */
    protected static function value(string $name, bool $required, $default = null, string $description = ''): array
    {
        return [
            'name'        => $name,
            'required'    => $required,
            'default'     => $default,
            'description' => $description
        ];
    }
}