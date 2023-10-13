<?php

namespace App\Services;

use App\Contracts\ImportUser;
use App\Enum\Import\StatusEnum;
use App\Enum\Import\TypeEnum;
use App\Exceptions\ImportRuntimeException;
use App\Helpers\FilesHelper;
use App\Http\DTO\Import\FailedDTO;
use App\Http\DTO\Import\StoreDTO;
use App\Http\Repositories\ImportRepository;
use App\Http\Repositories\UserRepository;
use App\Models\Import;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use JsonMachine\Items;

class ImportUserService implements ImportUser
{
    private int $qtyPerDBRequest = 1000;
    private array $currentLoopData;
    private int $startIndex = 0;
    private int $donePct = 0;
    private ImportRepository $repository;
    private UserRepository $userRepository;

    public function __construct(
        ImportRepository $repository,
        UserRepository   $userRepository
    )
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws ImportRuntimeException
     */
    public function handle(Import $import)
    {
        try {
            $fileSize = FilesHelper::getFileSize($import->file_url);
            $products = Items::fromFile($import->file_url, ['pointer' => $import->file_pointer, 'debug' => true]);
            $i = 0;
            foreach ($products as $index => $product) {

                // check last index and continue after it
                if ($import->failed_index && $index < $import->failed_index) {
                    continue;
                }

                // save startIndex in loop
                if (!$i) {
                    $this->startIndex = $index;
                }

                // insert or update
                if ($i === $import->rows_qty_per_request) {
                    $this->userRepository->insertOrUpdate($this->currentLoopData);
                    $i = 0;
                    $this->donePct = intval($products->getPosition() / $fileSize * 100);
                }

                // collect
                $this->currentLoopData[] = [
                    'first_name' => $product->name->first,
                    'last_name' => $product->name->last,
                    'email' => $product->email,
                    'age' => $product->dob->age,
                    'created_at' => Carbon::now()->toDateTimeString()
                ];
                $i++;
            }

            // rest data
            if ($this->donePct < 100) {
                $this->userRepository->insertOrUpdate($this->currentLoopData);
            }

            // finish
            $this->repository->updateStatus($import, StatusEnum::Finished);
        } catch (\Exception $exception) {
            Log::error($exception);
            // update import row
            $this->repository->importToFailed($import, new FailedDTO(
                $this->startIndex,
                $this->donePct
            ));
            throw new ImportRuntimeException();
        }

    }

    public function prepare(): StoreDTO
    {
        return new StoreDTO(
            TypeEnum::Users,
            env('USER_IMPORT_URL'),
            $this->qtyPerDBRequest,
            '/results',
        );
    }


}
