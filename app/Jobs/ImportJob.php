<?php

namespace App\Jobs;

use App\Contracts\ImportUser;
use App\Models\Import;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Import $importRow;
    private ImportUser $service;
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 1;

    /**
     * Create a new job instance.
     */
    public function __construct(Import $importRow)
    {
        $this->importRow = $importRow;
    }

    /**
     * Execute the job.
     */
    public function handle(ImportUser $service): void
    {
        $service->handle($this->importRow);
    }
}
