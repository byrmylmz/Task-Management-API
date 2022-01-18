<?php

namespace App\Models;

use App\Scopes\UserIdScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laravel\Paddle\Billable;
use Spatie\Permission\Traits\HasRoles;





class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Billable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The booted method of the model.
     */
    protected static function booted()
    {
        static::addGlobalScope(new UserIdScope);
    }
    
    /**
     * Get todo item for the user
     */
    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    /**
     * Get the boards for the user
     */
    public function boards()
    {
        return $this->hasMany(Board::class);
    }
}
