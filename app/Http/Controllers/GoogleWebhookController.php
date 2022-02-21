<?php

namespace App\Http\Controllers;

use App\Models\Synchronization;
use Illuminate\Http\Request;

class GoogleWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->header('x-goog-resource-state') !== 'exists') {
            return;
        }

       $sync= Synchronization::query()
            ->where('id', $request->header('x-goog-channel-id'))
            ->where('resource_id', $request->header('x-goog-resource-id'))
            ->firstOrFail()
            ->ping();

            if ($sync){
                $createdEvents='periodic snyronziaton';
                CalendarEventCreated::dispatch($createdEvents);
            }
    }
}