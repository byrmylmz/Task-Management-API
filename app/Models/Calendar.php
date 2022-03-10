<?php

namespace App\Models;

use App\Concerns\Synchronizable;
use App\Models\Event;
use App\Models\GoogleAccount;
use App\Models\User;
use App\Jobs\SynchronizeGoogleEvents;
use App\Jobs\WatchGoogleEvents;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use Synchronizable;

    protected $fillable = [
        'google_id', 'name', 'color', 'timezone',
    ];


    public function googleAccount()
    {
        return $this->belongsTo(GoogleAccount::class);
    }
    
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, GoogleAccount::class);
    }

    public function synchronize()
    {
        
        SynchronizeGoogleEvents::dispatch($this);
        
    }

    public function watch()
    {
        WatchGoogleEvents::dispatch($this);
    }
}