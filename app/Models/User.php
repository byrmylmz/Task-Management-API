<?php

namespace App\Models;

use App\Models\Event;
use App\Models\GoogleAccount;
use App\Scopes\UserIdScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Paddle\Billable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
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
    protected $appends = ['free_trial_days_left','is_admin_first'];

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
     * Get todo item for the user
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the boards for the user
     */
    public function boards()
    {
        return $this->hasMany(Board::class);
    }

    /**
     * Get the columns for the user
     */
    public function columns()
    {
        return $this->hasMany(Column::class);
    }

    /**
     * Get the cards for the user
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    /**
     * Get the tasks for the user
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }


    /**
     * Messeage and idadmin for the package of laravel vue spa
     */
    public function getIsAdminFirstAttribute()
    {
        foreach ($this->getRoleNames() as $key => $role) {
            if($role === 'super-admin'){
                return $this->attribute = true;
            }else{
                return $this->attribute = false;
            }
        }
        return false;
    }
    /**
     * test for laravel vue admin panel 
     */
    public function messages()
    {
      return $this->hasMany(Message::class);
    }

    public function isAdmin(): bool
    {
       return $this->is_admin_first;
    }
    /**
     * Google account table
     */
    public function googleAccounts()
    {
        return $this->hasMany(GoogleAccount::class);
    }
    
    public function events()
    {
        // Or use: https://github.com/staudenmeir/eloquent-has-many-deep
        return Event::whereHas('calendar', function ($calendarQuery) {
            $calendarQuery->whereHas('googleAccount', function ($accountQuery) {
                $accountQuery->whereHas('user', function ($userQuery) {
                    $userQuery->where('id', $this->id);
                });
            });
        });
    }
}
