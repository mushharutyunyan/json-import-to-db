<?php

namespace App\Enum\Import;

enum StatusEnum: string
{
    case Pending = 'pending';
    case Finished = 'finished';
    case Failed = 'failed';

}
