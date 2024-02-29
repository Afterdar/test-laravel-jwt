<?php

declare(strict_types=1);

namespace App\Services\User\Http\Controller;

use App\Http\Controllers\Controller;
use App\Services\ActionsUser\Database\Repository\ActionsUserRepository;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     *
     */
    private ActionsUserRepository $actionsUserRepository;

    public function __construct(ActionsUserRepository $actionsUserRepository)
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->actionsUserRepository = $actionsUserRepository;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth()->user();
        $action = 'Пользователь залогинился';

        $addAction = $this->actionsUserRepository->addAction($action, $user['id']);

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        $user = auth()->user();
        $action = 'Пользователь запросил свой аккаунт';

        $addAction = $this->actionsUserRepository->addAction($action, $user['id']);

        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = auth()->user();
        $action = 'Пользователь вышел из аккаунта';

        $addAction = $this->actionsUserRepository->addAction($action, $user['id']);

        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $user = auth()->user();
        $action = 'Пользователь обновил токен';

        $addAction = $this->actionsUserRepository->addAction($action, $user['id']);

        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
