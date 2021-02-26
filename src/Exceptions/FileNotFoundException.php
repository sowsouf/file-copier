<?php
/**
 * This file contains an exception thrown when file
 * path not found.
 *
 * @author Akbly Sofiane <sakbly@pndata.tech>
 */

namespace PNdata\Copy\Exceptions;


/**
 * Class FileNotFoundException
 * @package App\Exceptions
 */
class FileNotFoundException extends \Exception
{
    /**
     * FileNotFoundException constructor.
     * @param string $path
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $path = '', int $code = 0, \Throwable $previous = null)
    {
        $message = sprintf('File "%s" could not be found.', $path);

        parent::__construct($message, $code, $previous);
    }
}
