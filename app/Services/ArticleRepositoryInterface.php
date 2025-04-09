<?php

namespace App\Services;

interface ArticleRepositoryInterface
{
    public function getByCategoryId($categoryId);
} 