<?php
namespace App\Exceptions;

use Exception;

class ImportRuntimeException extends Exception
{
    public function __construct(string $message = "Импорт на данный момент не возможен. Попробуйте немного позже.", int $code = 429, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
