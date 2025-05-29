<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\Comment;
use App\Models\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Interfaces\ICrud;

class CommentService implements ICrud
{
    /** @override */
    public function findAll()
    {
        $comments = Comment::all();
        return $comments;
    }

    /** @override */
    public function paginate()
    {
        $paginatedData = Comment::paginate();
        return $paginatedData;
    }

    /** @override */
    public function create(array $data)
    {
        try {
            $comment = Comment::create(Auditor::create($data));
            return $comment;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function update(array $data, string $id)
    {
        try {
            $comment = $this->findById($id);
            $comment->update($data);
            return $comment;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function delete(string $id): void
    {
        try {
            $comment = $this->findById($id);
            $comment->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function findById(string $idOrUuid)
    {
        try {
            $comment = Comment::findOrFail($idOrUuid);
            return $comment;
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }
}
