<?php

namespace App\Models;

use App\Scopes\UserIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    use HasFactory;
    protected $fillable=['user_id','title','board_id'];
    /**
     * The booted method of the model.
     */
    protected static function booted()
    {
        static::addGlobalScope(new UserIdScope);
    }
    /**
     * Get the cards for the column
     */
     public function cards()
     {
         return $this->hasMany(Card::class);
     }

     /**
      * Get the board that owns the columns
    */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

}
