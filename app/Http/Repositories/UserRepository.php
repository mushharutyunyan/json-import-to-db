<?php

namespace App\Http\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function insertOrUpdate(array $users): void
    {
        User::insertOnDuplicateKey($users, ['email', 'age', 'updated' => 1, 'updated_at' => 'now()']);
    }

    public function getSummary(Carbon $from): array
    {
        $summary = DB::query()->select([
            DB::raw('SUM(qty) as qty'),
            DB::raw('SUM(updated) as updated'),
            DB::raw('SUM(new) as new'),
        ])
            ->fromSub(
                User::query()
                    ->select([
                        DB::raw('COUNT(user_id) as qty'),
                        DB::raw('CASE WHEN updated = 1 AND updated_at > \'' . $from->toDateTimeString() . '\' THEN COUNT(user_id) ELSE 0 END as updated'),
                        DB::raw('CASE WHEN updated = 0 AND created_at > \'' . $from->toDateTimeString() . '\' THEN COUNT(user_id) ELSE 0 END as new'),
                    ])
                    ->groupBy(['updated', 'updated_at', 'created_at']),
                'summary'
            )
            ->first();
        return [
            'qty' => $summary?->qty,
            'updated' => $summary?->updated,
            'new' => $summary?->new,
        ];
    }
}
