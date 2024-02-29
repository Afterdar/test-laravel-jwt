<?php

declare(strict_types=1);

namespace App\Services\User\Database\Repository;

use App\Http\Requests\User\registerUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\User\Database\Models\User;
use Carbon\Carbon;
use Gerfey\Repository\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserRepository extends Repository
{
    protected $entity = User::class;

    public function registerUser(registerUserRequest $userRegisterRequest): bool
    {
        return $this->createQueryBuilder()
            ->insert([
                'name' => $userRegisterRequest['name'],
                'email' => $userRegisterRequest['email'],
                'password' => Hash::make($userRegisterRequest['password']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
    }

    public function updateUser(UpdateUserRequest $updateUserRequest, int $id): bool
    {
        $user = $this->createQueryBuilder()
            ->where('id', '=', $id)
            ->first();

        if ($user === null)
        {
            return false;
        }

        $result =  $user->fill([
            'name' => $updateUserRequest['name'],
            'email' => $updateUserRequest['email'],
            'password' => Hash::make($updateUserRequest['password']),
        ]);

        return $result->save();
    }
}
