<?php

namespace App\Models;

use App\Scopes\UserIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable=['user_id','title','description','card_id','checked','order'];
    /**
     * The booted method of the model.
     */
    protected static function booted()
    {
        static::addGlobalScope(new UserIdScope);
    }
    /**
     * Get the card that owns the tasks
     */

     public function card()
     {
         return $this->belongsTo(Card::class); 
     }
    
}
