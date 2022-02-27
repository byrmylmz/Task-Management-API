<?php

namespace App\Models;

use App\Scopes\UserIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = ['id','user_id','category_id','title','order'];
    /**
     * The booted method of the model.
     */
    protected static function booted()
    {
        static::addGlobalScope(new UserIdScope);
    }

    /**
     * Get the columns for the board.
     */
     public function columns()
     {
         return $this->hasMany(Column::class);
     }

     /**
      * Get the user that owns the board.
      */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
     /**
      * Get the user that owns the board.
      */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    

}
