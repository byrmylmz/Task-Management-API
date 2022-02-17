<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class SynchronizeGoogleResource
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $synchronizable;
    protected $synchronization;

    public function __construct($synchronizable)
    {
        $this->synchronizable = $synchronizable;
        $this->synchronization = $synchronizable->synchronization;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pageToken = null;
        $syncToken = $this->synchronization->token;
        $service = $this->getGoogleService();

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
    }

    abstract public function getGoogleService();
    abstract public function getGoogleRequest($service, $options);
    abstract public function syncItem($item);
    abstract public function dropAllSyncedItems();

}
