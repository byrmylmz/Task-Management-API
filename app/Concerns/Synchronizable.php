<?php

namespace App\Concerns;

use App\Events\CalendarEventCreated;
use App\Services\Google;
use App\Models\Synchronization;

trait Synchronizable
{
    public static function bootSynchronizable()
    {   
        // Start a new synchronization once created.
        static::created(function ($synchronizable) {
            $synchronizable->synchronization()->create();
            $calendarId='ping';
            CalendarEventCreated::dispatch($calendarId);
        });

        // Stop and delete associated synchronization.
        static::deleting(function ($synchronizable) {
            optional($synchronizable->synchronization)->delete();
        });
    }

    public function synchronization()
    {
        return $this->morphOne(Synchronization::class, 'synchronizable');
    }

    public function getGoogleService($service)
    {
        return app(Google::class)
            ->connectWithSynchronizable($this)
            ->service($service);
    }
    

    abstract public function synchronize();
    abstract public function watch();
}