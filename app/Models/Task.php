<?php

namespace App\Models;

use App\Scopes\UserIdScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable=['temp_id','user_id','title','description','card_id','checked','order','start','end'];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order' => 'float',
    ];

    public function getStartAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-dTH:i:sZ');
    }

    public function getEndAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-dTH:i:sZ');
    }
    
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
