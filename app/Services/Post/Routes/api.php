<?php

declare(strict_types=1);

use App\Services\Post\Http\Controller\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(
    function (): void {
        Route::prefix('v1')->group(
            function (): void {
                Route::prefix('post')->group(
                    function (): void {
                        Route::post('/addPost', [PostController::class, 'addPost']);
                        Route::put('/updatePost/{id}', [PostController::class, 'updatePost']);
                        Route::delete('/deletePost/{id}', [PostController::class, 'deletePost']);

                        Route::get('/listPosts', [PostController::class, 'getListPostUser']);
                        Route::get('/getPostById/{id}', [PostController::class, 'getPostById']);
                    }
                );
            }
        );
    }
);
