<?php
/**
 * This file contains CannotMkdirException
 * @author Akbly Sofiane <sofiane.akbly@gmail.com>
 */

namespace Ssf\Copy\Exceptions;


/**
 * Class CannotMkdirException
 * This exception is thrown when make directory
 * fails.
 * @package Ssf\Copy\Exceptions
 */
class CannotMkdirException extends \Exception
{
    /**
     * CannotMkdirException constructor.
     * @param string $path
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $path = '', int $code = 0, \Throwable $previous = null)
    {
        $message = sprintf('Cannot mkdir "%s".', $path);

        parent::__construct($message, $code, $previous);
    }
}
