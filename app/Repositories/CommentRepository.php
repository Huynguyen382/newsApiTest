<?php

namespace App\Repositories;

use App\Models\CommentModel;

class CommentRepository implements CommentRepositoryInterface
{
    protected $model;

    public function __construct(CommentModel $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $comment = $this->find($id);
        if ($comment) {
            $comment->update($data);
        }
        return $comment;
    }

    public function delete($id)
    {
        $comment = $this->find($id);
        if ($comment) {
            $comment->delete();
        }
        return $comment;
    }
    
    public function getByArticleId($articleId)
    {
        return $this->model->where('article_id', $articleId)->get();
    }
    
    public function getByUserId($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }
    
    public function approve($id)
    {
        $comment = $this->find($id);
        if ($comment) {
            $comment->status = 'approved';
            $comment->save();
        }
        return $comment;
    }
    
    public function reject($id)
    {
        $comment = $this->find($id);
        if ($comment) {
            $comment->status = 'rejected';
            $comment->save();
        }
        return $comment;
    }
}


