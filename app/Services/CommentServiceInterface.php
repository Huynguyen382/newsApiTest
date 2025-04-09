<?php

namespace App\Services;

interface CommentServiceInterface
{
    public function getAllComments();
    public function findComment($id);
    public function createComment(array $data);
    public function updateComment($id, array $data);
    public function deleteComment($id);
    public function getCommentsByArticle($articleId);
    public function getCommentsByUser($userId);
    public function approveComment($id);
    public function rejectComment($id);
} 