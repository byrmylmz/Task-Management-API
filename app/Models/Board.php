<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = ['id','user_id','category_id','title','order'];

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
    

}
