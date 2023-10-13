<?php

namespace App\Enum\Import;

enum TypeEnum: string
{
    case Users = 'users';

    public static function values(): array
    {
        return [
            self::Users->value
        ];
    }
}
