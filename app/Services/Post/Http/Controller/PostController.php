<?php

declare(strict_types=1);

namespace App\Services\Post\Http\Controller;

use App\Http\Requests\Post\AddPostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Services\ActionsUser\Database\Repository\ActionsUserRepository;
use App\Services\Post\Database\Repository\PostRepository;
use Exception;
use Gerfey\ResponseBuilder\ResponseBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class PostController extends BaseController
{
    private PostRepository $postRepository;
    private ActionsUserRepository $actionsUserRepository;

    public function __construct(PostRepository $postRepository, ActionsUserRepository $actionsUserRepository)
    {
        $this->postRepository = $postRepository;
        $this->actionsUserRepository = $actionsUserRepository;
    }

    public function addPost(AddPostRequest $addPostRequest): JsonResponse
    {
        $user = auth()->user();

        $addPost = $this->postRepository->addPost($addPostRequest, $user['id']);

        if ($addPost === false)
        {
            throw new Exception('Ошибка создания поста');
        }

        $action = 'Пользователь создал пост';

        $addAction = $this->actionsUserRepository->addAction($action, $user['id']);

        return ResponseBuilder::success(['Пост создан']);
    }

    public function updatePost(UpdatePostRequest $updatePostRequest, int $id): JsonResponse
    {
        $user = auth()->user();

        $updatePost = $this->postRepository->updatePost($updatePostRequest, $user['id'], $id);

        if ($updatePost === false)
        {
            throw new Exception('Ошибка обновления поста, неверный id');
        }

        $action = "Пользователь обновил пост №$id";

        $addAction = $this->actionsUserRepository->addAction($action, $user['id']);

        return ResponseBuilder::success(['Пост обновлен']);
    }

    public function deletePost(int $id): JsonResponse
    {
        $user = auth()->user();

        $deletePost = $this->postRepository->deletePost($user['id'], $id);

        if ($deletePost === false)
        {
            throw new Exception('Ошибка удаления поста, неверный id');
        }

        $action = "Пользователь удалил пост №$id";

        $addAction = $this->actionsUserRepository->addAction($action, $user['id']);

        return ResponseBuilder::success(['Пост успешно удален']);
    }

    public function getListPostUser(): JsonResponse
    {
        $user = auth()->user();

        $listPosts = $this->postRepository->getListPostsUser($user['id']);

        if (empty($listPosts->toArray()))
        {
            throw new Exception('У пользователя нет постов');
        }

        $action = 'Пользователь запросил список постов';

        $addAction = $this->actionsUserRepository->addAction($action, $user['id']);

        return ResponseBuilder::success($listPosts->toArray());
    }

    public function getPostById(int $id): JsonResponse
    {
        $user = auth()->user();

        $post = $this->postRepository->getPostById($user['id'], $id);

        if ($post === false)
        {
            throw new Exception('Пост не найден, неверный id');
        }

        $action = "Пользователь запросил пост $id";

        $addAction = $this->actionsUserRepository->addAction($action, $user['id']);

        return ResponseBuilder::success($post->toArray());
    }
}
