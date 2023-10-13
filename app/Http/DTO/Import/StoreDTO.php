<?php

namespace App\Http\DTO\Import;

use App\Enum\Import\TypeEnum;

class StoreDTO
{
    private TypeEnum $type;
    private string $fileUrl;
    private int $rowsQtyPerRequest;
    private ?string $filePointer;

    public function __construct(
        TypeEnum $type,
        string $fileUrl,
        int $rowsQtyPerRequest,
        ?string $filePointer
    )
    {
        $this->type = $type;
        $this->fileUrl = $fileUrl;
        $this->rowsQtyPerRequest = $rowsQtyPerRequest;
        $this->filePointer = $filePointer;
    }

    /**
     * @return TypeEnum
     */
    public function getType(): TypeEnum
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getFileUrl(): string
    {
        return $this->fileUrl;
    }

    /**
     * @return int
     */
    public function getRowsQtyPerRequest(): int
    {
        return $this->rowsQtyPerRequest;
    }

    /**
     * @return string|null
     */
    public function getFilePointer(): ?string
    {
        return $this->filePointer;
    }


}
