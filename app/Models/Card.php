<?php

namespace App\Models;

use App\Scopes\UserIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    
    protected $fillable=['temp_id','user_id','title','description','column_id','order'];

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

