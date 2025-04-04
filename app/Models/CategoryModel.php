<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryModel extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = ['name', 'url_key'];

    public function articles():HasMany
    {
        return $this->hasMany(ArticleModel::class, 'category_id');
    }

}
