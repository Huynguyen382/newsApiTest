<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleModel extends Model
{
    use HasFactory;

    protected $table = 'articles';
    protected $fillable = [
        'title',
        'url_key',
        'content',
        'image',
        'category_id',
        'user_id',
        'status',
        'view',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryModel::class);
    }
    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }
    public function comments()
    {
        return $this->hasMany(CommentModel::class);
    }

}
