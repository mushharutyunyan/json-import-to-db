<?php

namespace App\Http\Controllers;

use App\Enum\Import\TypeEnum;
use App\Http\Repositories\ImportRepository;
use App\Http\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepository $repository;
    protected ImportRepository $importRepository;
    public function __construct(
        UserRepository $repository,
        ImportRepository $importRepository
    )
    {
        $this->repository = $repository;
        $this->importRepository = $importRepository;
    }

    public function getSummary(): JsonResponse
    {
        $lastImport = $this->importRepository->getLastByType(TypeEnum::Users);
        return $this->success($this->repository->getSummary(Carbon::parse($lastImport->created_at)));
    }
}
