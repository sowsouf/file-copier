<?php
/**
 * This file contains FailedCopyException
 * This exception is thrown when copying
 * fails.
 *
 * @author Akbly Sofiane <sakbly@pndata.tech>
 */

namespace PNdata\Copy\Exceptions;


/**
 * Class FailedCopyException
 * @package PNdata\Copy\Exceptions;
 */
class FailedCopyException extends \Exception
{
    /**
     * FailedCopyException constructor.
     * @param string $source
     * @param string $target
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $source = '', string $target = '', int $code = 0, \Throwable $previous = null)
    {
        $message = sprintf('Cannot copy [%s] into [%s].', $source, $target);

        parent::__construct($message, $code, $previous);
    }
}
