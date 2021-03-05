<?php
/**
 * This file contains ArgvNotExistsException
 * @author Akbly Sofiane <sofiane.akbly@gmail.com>
 */

namespace Ssf\Copy\Exceptions;


use Throwable;

/**
 * Class ArgvNotExistsException
 * This exception is thrown when a wrong argv
 * provided to command.
 * @package Ssf\Copy\Exceptions
 */
class ArgvNotExistsException extends \Exception
{

    /**
     * ArgvNotExistsException constructor.
     * @param $type
     * @param $value
     * @param $command
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($type, $value, $command, $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf(
            "The %s %s doesn't exists in %s command",
            $value,
            $type,
            $command
        ), $code, $previous);
    }

}