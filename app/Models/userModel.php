<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class userModel extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password'];
    public $timestamps = false;

    public function articles():HasMany
    {
        return $this->hasMany(ArticleModel::class);
    }
    public function comments(): HasMany
    {
        return $this->hasMany(CommentModel::class);
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
