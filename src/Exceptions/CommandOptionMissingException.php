<?php
/**
 * This file contains CommandOptionMissingException
 * @author Akbly Sofiane <sofiane.akbly@gmail.com>
 */

namespace Ssf\Copy\Exceptions;


use Throwable;

/**
 * Class CommandOptionMissingException
 * This exception is thrown when a wrong option
 * is provided to command.
 *
 * @package Ssf\Copy\Exceptions
 */
class CommandOptionMissingException extends \Exception
{

    public function __construct(string $command, string $option, $code = 0, Throwable $previous = null)
    {
        $message = sprintf("Option [%s] is missing for {%s} command", $option, $command);
        parent::__construct($message, $code, $previous);
    }

}
