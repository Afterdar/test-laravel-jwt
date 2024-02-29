<?php

declare(strict_types=1);

namespace App\Services\User\Http\Controller;

use App\Http\Requests\User\registerUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\ActionsUser\Database\Repository\ActionsUserRepository;
use App\Services\User\Database\Repository\UserRepository;
use Exception;
use Gerfey\ResponseBuilder\ResponseBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    private UserRepository $userRepository;
    private ActionsUserRepository $actionsUserRepository;

    public function __construct(UserRepository $userRepository, ActionsUserRepository $actionsUserRepository)
    {
        $this->userRepository = $userRepository;
        $this->actionsUserRepository = $actionsUserRepository;
    }

    public function register(RegisterUserRequest $userRegisterRequest): JsonResponse
    {
        $registerUser = $this->userRepository->registerUser($userRegisterRequest);

        if ($registerUser === false)
        {
            throw new Exception('Произошла ошибка регистрации пользователя');
        }

        return ResponseBuilder::success(['Пользователь зарегистрирован']);
    }

    public function updateUser(UpdateUserRequest $updateUserRequest): JsonResponse
    {
        $user = auth()->user();

        $userUpdate = $this->userRepository->updateUser($updateUserRequest, $user['id']);

        if ($userUpdate === false)
        {
            throw new Exception('Произошла ошибка обновления пользователя');
        }

        $action = 'Пользователь обновил свой профиль';

        $addAction = $this->actionsUserRepository->addAction($action, $user['id']);

        return ResponseBuilder::success(['Пользователь успешно обновлен']);
    }
}
