<?php

namespace App\Models;

use App\Scopes\UserIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = ['temp_id','user_id','category_id','title','order','inbox_board'];
    
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
    
     /**
      * Test for the draggable remove it 
      */
    public function boards()
    {
        return $this->hasmany(Boards::class,'category_id','id');
    }
    

}
