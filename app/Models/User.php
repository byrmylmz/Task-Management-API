<?php

namespace App\Models;

use App\Scopes\UserIdScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
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
        'trial_until',
        'provider_name',
        'provider_id',
        'provider_token'
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
     * the attributes that will use carbon operation
     */
    protected $dates = [
        'trial_until'
    ];

    /**
     *  The accessorts to append to the Model's array form
     *  free_trial_days_left
     */
    protected $appends = ['free_trial_days_left'];

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
     | Attribute for how many days remain as trial.
     */

    public function getFreeTrialDaysLeftAttribute()
    {
        // Future field which will be implement after payment.
        // if($this->plan_until){
        //     return 0;
        // }

        return $this->attributes = array(now()->diffInDays($this->trial_until,false));
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
