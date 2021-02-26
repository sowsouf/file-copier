<?php
/**
 * This file contains CommandOptionMissingException
 * This exception is thrown when a wrong option
 * is provided to command.
 *
 * @author Akbly Sofiane <sakbly@pndata.tech>
 */

namespace PNdata\Copy\Exceptions;


use Throwable;

/**
 * Class CommandOptionMissingException
 * @package PNdata\Copy\Exceptions
 */
class CommandOptionMissingException extends \Exception
{

    public function __construct(string $command, string $option, $code = 0, Throwable $previous = null)
    {
        $message = sprintf("Option [%s] is missing for {%s} command", $option, $command);
        parent::__construct($message, $code, $previous);
    }

}
