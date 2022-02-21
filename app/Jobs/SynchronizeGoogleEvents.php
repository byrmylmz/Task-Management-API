<?php

namespace App\Jobs;

use App\Events\CalendarEventCreated;
use App\Events\CalendarEventUpdated;
use App\Jobs\SynchronizeGoogleResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use App\Events\Hello;
use App\Models\Event;

class SynchronizeGoogleEvents extends SynchronizeGoogleResource implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function getGoogleRequest($service, $options)
    {
        return $service->events->listEvents(
            $this->synchronizable->google_id, $options
        );
    }

    public function syncItem($googleEvent)
    {
        if ($googleEvent->status === 'cancelled') {

            // DISPATCH EVENT FOR STATE.
            // $createdEvents='deneme';
            // CalendarEventCreated::dispatch($createdEvents);

            return $this->synchronizable->events()
                ->where('google_id', $googleEvent->id)
                ->delete(); 
        }

         $this->synchronizable->events()->updateOrCreate(
            [
                'google_id' => $googleEvent->id,
            ],
            [
                'name' => $googleEvent->summary ?? '(No title)',
                'description' => $googleEvent->description,
                'allday' => $this->isAllDayEvent($googleEvent), 
                'started_at' => $this->parseDatetime($googleEvent->start), 
                'ended_at' => $this->parseDatetime($googleEvent->end), 
            ]
        );
        // DISPATCH FOR NEW CREATED EVENT.
        $createdEvents=$this->synchronizable->events()->get();
        CalendarEventCreated::dispatch($createdEvents);
    }

    public function dropAllSyncedItems()    
    {   
        $this->synchronizable->events()->delete();  
    }

    protected function isAllDayEvent($googleEvent)
    {
        return ! $googleEvent->start->dateTime && ! $googleEvent->end->dateTime;
    }

    protected function parseDatetime($googleDatetime)
    {
        $rawDatetime = $googleDatetime->dateTime ?: $googleDatetime->date;

        return Carbon::parse($rawDatetime)->setTimezone('UTC');
    }
}