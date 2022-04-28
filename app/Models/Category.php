<?php

namespace App\Models;

use App\Scopes\UserIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable=['temp_id','user_id','title','order'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order' => 'float',
    ];
    /**
     * The booted method of the model.
     */
    protected static function booted()
    {
        static::addGlobalScope(new UserIdScope);
    }

    /**
     * get the boards for the category.
     */
    public function boards()
    {
        return $this->hasMany(Board::class)->OrderBy('order');
    }
    
    /**
     * get the boards for the category.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
