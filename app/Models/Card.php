<?php

namespace App\Models;

use App\Scopes\UserIdScope;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory;
    
    protected $fillable=['temp_id','user_id','title','description','column_id','order','checked','start','end'];

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
     * Get the tasks for the card.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);  
    }

    /**
     * Get the Column that owns the card.
     */
    public function column()
    {
        return $this->belongsTo(Column::class);
    }
}

