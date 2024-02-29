<?php

declare(strict_types=1);

use App\Services\Post\Http\Controller\PostController;
use App\Services\User\Http\Controller\AuthController;
use App\Services\User\Http\Controller\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(
    function (): void {
        Route::prefix('user')->group(
            function (): void {
                Route::post('/register', [UserController::class, 'register']);
            }
        );
    }
);

Route::middleware('api')->prefix('auth')->group(
    function (): void {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    }
);

Route::middleware('auth:api')->group(
    function (): void {
        Route::prefix('v1')->group(
            function (): void {
                Route::prefix('user')->group(
                    function (): void {
                        Route::put('/updateUser', [UserController::class, 'updateUser']);
                    }
                );
            }
        );
    }
);

