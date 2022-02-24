<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventCollection;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;
use App\Services\Google;


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
            'summary' => $request->summary,
            'start' => array(
              'dateTime' => '2022-02-24T09:00:00-02:00',
              'timeZone' => 'Europe/Istanbul',
            ),
            'end' => array(
              'dateTime' => '2022-02-24T05:00:00-07:00',
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
                'name' => $request->summary,
                'description' => '',
              
                'started_at' => Carbon::parse('2022-02-09T05:00:00-07:00')->setTimezone('UTC'), 
                'ended_at' => Carbon::parse('2022-02-09T05:00:00-07:00')->setTimezone('UTC'), 
            ]
        );
    }
}
