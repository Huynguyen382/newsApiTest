<?php

namespace App\Repositories;

interface CommentRepositoryInterface
{
    public function getAll();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getByArticleId($articleId);
    public function getByUserId($userId);
    public function approve($id);
    public function reject($id);
}
