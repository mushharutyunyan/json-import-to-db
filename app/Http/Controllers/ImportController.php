<?php

namespace App\Http\Controllers;

use App\Contracts\ImportUser;
use App\Enum\Import\StatusEnum;
use App\Enum\Import\TypeEnum;
use App\Exceptions\ImportPendingException;
use App\Http\Repositories\ImportRepository;
use App\Jobs\ImportJob;
use App\Models\Import;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    protected ImportUser $service;
    protected ImportRepository $repository;

    public function __construct(
        ImportUser       $service,
        ImportRepository $repository
    )
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function getLastImport(string $type): JsonResponse
    {
        return $this->success($this->repository->getLastByType(TypeEnum::from($type)));
    }

    /**
     * @throws ImportPendingException
     */
    public function users(): JsonResponse
    {
        $lastImport = $this->repository->getLastByType(TypeEnum::Users);
        if (!$lastImport || $lastImport->status === StatusEnum::Finished->value) {
            $import = $this->repository->store($this->service->prepare());
            // Job
            ImportJob::dispatch($import);
        } else {
            if ($lastImport->status === StatusEnum::Failed->value) {
                $this->repository->updateStatus($lastImport, StatusEnum::Pending);
                // Job
                ImportJob::dispatch($lastImport);
            } else {
                throw new ImportPendingException();
            }
        }
        return $this->success(['message' => 'Импорт началось...']);
    }
}
