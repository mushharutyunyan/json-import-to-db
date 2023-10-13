<?php

namespace App\Http\DTO\Import;

class FailedDTO
{
    private int $failedIndex;
    private float $donePct;

    public function __construct(
        int $failedIndex,
        float $donePct
    )
    {
        $this->failedIndex = $failedIndex;
        $this->donePct = $donePct;
    }

    /**
     * @return int
     */
    public function getFailedIndex(): int
    {
        return $this->failedIndex;
    }

    /**
     * @return float
     */
    public function getDonePct(): float
    {
        return $this->donePct;
    }


}
