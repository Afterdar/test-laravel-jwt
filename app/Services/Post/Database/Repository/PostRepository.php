<?php

declare(strict_types=1);

namespace App\Services\Post\Database\Repository;

use App\Http\Requests\Post\AddPostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Services\Post\Database\Models\Post;
use Carbon\Carbon;
use Gerfey\Repository\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PostRepository extends Repository
{
    protected $entity = Post::class;

    public function addPost(AddPostRequest $addPostRequest, int $id): bool
    {
        return $this->createQueryBuilder()
            ->insert([
                'title' => $addPostRequest['title'],
                'content' => $addPostRequest['content'],
                'user_id' => $id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
    }

    public function updatePost(UpdatePostRequest $updatePostRequest, int $idUser, int $id):bool
    {
        $post = $this->createQueryBuilder()
            ->where('id', '=', $id)
            ->where('user_id', '=', $idUser)
            ->first();

        if ($post === null)
        {
            return false;
        }

        $result = $post->fill([
            'title' => $updatePostRequest['title'],
            'content' => $updatePostRequest['content'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return $result->save();
    }

    public function deletePost(int $idUser, int $id):bool
    {
        $post = $this->createQueryBuilder()
            ->where('id', '=', $id)
            ->where('user_id', '=', $idUser)
            ->first();

        if ($post === null)
        {
            return false;
        }

        return $post->delete();
    }

    public function getListPostsUser(int $id): Collection|array
    {
        return $this->createQueryBuilder()
            ->where('user_id', '=', $id)
            ->get();
    }

    public function getPostById(int $idUser, int $id): Model|bool
    {
        $post = $this->createQueryBuilder()
            ->where('id', '=', $id)
            ->where('user_id', '=', $idUser)
            ->first();

        if ($post === null)
        {
            return false;
        }

        return $post;
    }
}
