<?php

namespace App\Models;

use App\Scopes\UserIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable=['user_id','title'];
    /**
     * The booted method of the model.
     */
    protected static function booted()
    {
        static::addGlobalScope(new UserIdScope);
    }

}