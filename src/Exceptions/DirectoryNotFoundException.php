<?php
/**
 * This file contains DirectoryNotFoundException
 * @author Akbly Sofiane <sofiane.akbly@gmail.com>
 */

namespace Ssf\Copy\Exceptions;


/**
 * Class DirectoryNotFoundException
 * This exception is thrown when a directory is
 * not found.
 *
 * @package Ssf\Copy\Exceptions
 */
class DirectoryNotFoundException extends \Exception
{
    /**
     * DirectoryNotFoundException constructor.
     * @param string $path
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $path = '', int $code = 0, \Throwable $previous = null)
    {
        $message = sprintf('Directory "%s" could not be found.', $path);

        parent::__construct($message, $code, $previous);
    }
}
