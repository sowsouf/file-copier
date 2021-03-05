<?php
/**
 * This file contains FailedCopyException
 * @author Akbly Sofiane <sofiane.akbly@gmail.com>
 */

namespace Ssf\Copy\Exceptions;


/**
 * Class FailedCopyException
 * This exception is thrown when copying
 * fails.
 *
 * @package Ssf\Copy\Exceptions;
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
