<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentModel extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = ['article_id', 'user_id', 'content','status'];

    public function article()
    {
        return $this->belongsTo(ArticleModel::class);
    }
    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }
}
