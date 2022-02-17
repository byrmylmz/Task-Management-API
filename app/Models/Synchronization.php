<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Synchronization extends Model
{
    // Tell Laravel we are not auto-incrementing.

    public $incrementing = false;

    protected $fillable = [
        'token', 'last_synchronized_at','resource_id', 'expired_at'
    ];

    protected $casts = [
        'last_synchronized_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    // Ask the synchronizable to dispatch the relevant job.
    public function ping()
    {
        return $this->synchronizable->synchronize();
    }

    public function startListeningForChanges()
    {
        return $this->synchronizable->watch();
    }

    public function stopListeningForChanges()
    {
        if (! $this->resource_id) {
            return;
        }

        $this->synchronizable
            ->getGoogleService('Calendar')
            ->channels->stop($this->asGoogleChannel());
    }

    public function refreshWebhook()
    {
        $this->stopListeningForChanges();

        // Update the UUID since the previous one has 
        // already been associated to a Google Channel.
        $this->id = Uuid::uuid4();
        $this->save();

        $this->startListeningForChanges();

        return $this;
    }

    public function asGoogleChannel()
    {
        return tap(new \Google_Service_Calendar_Channel(), function ($channel) {
            $channel->setId($this->id);
            $channel->setResourceId($this->resource_id);
            $channel->setType('web_hook');
            $channel->setAddress(config('services.google.webhook_uri'));
        });
    }

    // Create a polymorphic relationship to Google accounts and Calendars.
    public function synchronizable()
    {
        return $this->morphTo();
    }

    // Add global model listeners
    public static function boot()
    {
        parent::boot();

        static::creating(function ($synchronization) {
            $synchronization->id = Uuid::uuid4();
            $synchronization->last_synchronized_at = now();
        });

        static::created(function ($synchronization) {
            $synchronization->startListeningForChanges();
            $synchronization->ping();
        });

        static::deleting(function ($synchronization) {
            $synchronization->stopListeningForChanges();
        });
    }
}