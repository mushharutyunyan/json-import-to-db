<?php

namespace App\Contracts;

use App\Enum\Import\TypeEnum;
use App\Http\DTO\Import\StoreDTO;
use App\Models\Import;

interface ImportUser
{
    public function prepare(): StoreDTO;
    public function handle(Import $import);
}
