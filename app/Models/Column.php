<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'title',
        'board_id'
    ];
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
