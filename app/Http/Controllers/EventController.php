<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventCollection;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\Google;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $events=auth()->user()->events()->orderBy('started_at','desc')->get();

        return new EventCollection($events);
    }
    
    public function store(Request $request, Google $google)
    {
        $token= auth()->user()->googleAccounts()->first()->token;
        
        $service = $google->connectUsing($token)->service('Calendar');
        
        // Print the next 10 events on the user's calendar.
        $calendarId = 'alakodcontact@gmail.com';
        
        $event = new \Google_Service_Calendar_Event(array(
            'summary' => $request->name,
            'start' => array(
                'dateTime' => Carbon::now(),
                'timeZone' => 'Europe/Istanbul',
            ),
            'end' => array(
                'dateTime' => Carbon::now()->addHour(),
                'timeZone' => 'Europe/Istanbul',
            ),
        ));
        
        
        $results = $service->events->insert($calendarId,$event);
        printf('Event created: %s\n', $results->id);
        
        auth()->user()->googleAccounts()->first()->calendars()->first()->events()->updateOrCreate(
            [
                'google_id' => $results->id,
            ],
            [
                'name' => $request->name,
                'description' => '',
                
                'started_at' => Carbon::now()->setTimeZone('UTC'), 
                'ended_at' => Carbon::now()->addHour()->setTimeZone('UTC'), 
                ]
            );
        }

        public function destroy(Request $request)
        {
            $token= auth()->user()->googleAccounts()->first()->token;
        
            $service = $google->connectUsing($token)->service('Calendar');

            $service->events->get('primary', $request->google_id);

            $event = Event::where('google_id',$request->google_id);
            $event->delete();

        }
    }
    