<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    protected $fillable=['user_id','title','column_id'];

    /**
     * Get the tasks for the card.
     */
    public function cards()
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

