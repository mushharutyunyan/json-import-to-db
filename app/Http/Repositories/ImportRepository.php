<?php

namespace App\Http\Repositories;

use App\Enum\Import\StatusEnum;
use App\Enum\Import\TypeEnum;
use App\Http\DTO\Import\FailedDTO;
use App\Http\DTO\Import\StoreDTO;
use App\Models\Import;
use Illuminate\Database\Eloquent\Model;

class ImportRepository
{
    public function getLastByType(TypeEnum $type): Import|Model|null
    {
        return Import::query()
            ->where('type', $type->value)
            ->orderBy('import_id', 'DESC')
            ->first();
    }

    public function store(StoreDTO $importData): Import
    {
        $import = new Import();
        $import->type = $importData->getType()->value;
        $import->file_url = $importData->getFileUrl();
        $import->rows_qty_per_request = $importData->getRowsQtyPerRequest();
        $import->file_pointer = $importData->getFilePointer();
        $import->save();
        return $import;
    }

    public function updateStatus(Import $import, StatusEnum $status): void
    {
        $import->status = $status->value;
        $import->save();
    }

    public function importToFailed(Import $import, FailedDTO $failedData): void
    {
        $import->failed_index = $failedData->getFailedIndex();
        $import->done_pct = $failedData->getDonePct();
        $import->status = StatusEnum::Failed->value;
        $import->save();
    }

}
