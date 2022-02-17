<?php

namespace App\Models;

use App\Concerns\Synchronizable;
use App\Models\Event;
use App\Models\GoogleAccount;
use App\Jobs\SynchronizeGoogleEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;
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
    
    public function synchronize()
    {
        SynchronizeGoogleEvents::dispatch($this);
    }

    
}
