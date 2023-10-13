<?php
namespace App\Exceptions;

use Exception;

class ImportPendingException extends Exception
{
    public function __construct(string $message = "Ваш прошлый импорт еще в процессе.", int $code = 429, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
