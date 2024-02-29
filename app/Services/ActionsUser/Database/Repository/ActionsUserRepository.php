<?php

namespace App\Services\ActionsUser\Database\Repository;

use App\Services\ActionsUser\Database\Models\ActionUser;
use Carbon\Carbon;
use Gerfey\Repository\Repository;

class ActionsUserRepository extends Repository
{
    protected $entity = ActionUser::class;

    public function addAction(string $action, int $idUser): bool
    {
        return $this->createQueryBuilder()
            ->insert([
                'action' => $action,
                'user_id' => $idUser,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
    }
}
