<?php

namespace App\Jobs;

use App\Events\CalendarSync;
use App\Models\Calendar;
use Illuminate\Support\Str;


abstract class SynchronizeGoogleResource
{
    protected $synchronizable;
    protected $synchronization;

    public function __construct($synchronizable)
    {
        $this->synchronizable = $synchronizable;
        $this->synchronization = $synchronizable->synchronization;
    }

    public function handle()
    {
        $pageToken = null;
        $syncToken = $this->synchronization->token;
     
        $service = $this->synchronizable->getGoogleService('Calendar');

        do {
            $tokens = compact('pageToken', 'syncToken');

            try {
                $list = $this->getGoogleRequest($service, $tokens); 
            } catch (\Google_Service_Exception $e) {    
                if ($e->getCode() === 410) {
                    $this->synchronization->update(['token' => null]);  
                    $this->dropAllSyncedItems();    
                    return $this->handle(); 
                }   
                throw $e;   
            }

            foreach ($list->getItems() as $item) {
                $this->syncItem($item);
            }

            $pageToken = $list->getNextPageToken();
        } while ($pageToken);

        $this->synchronization->update([
            'token' => $list->getNextSyncToken(),
            'last_synchronized_at' => now(),
        ]);


        /**
         * here is my dispatch
         */
        $slice = Str::afterLast($this->synchronization->synchronizable_type, '\\');
        if($slice === 'Calendar')
        {
            $userId = Calendar::find($this->synchronization->synchronizable_id)->googleAccount['user_id'];
            CalendarSync::dispatch($userId);
        }


    }

    abstract public function getGoogleRequest($service, $options);
    abstract public function syncItem($item);
    abstract public function dropAllSyncedItems();
}