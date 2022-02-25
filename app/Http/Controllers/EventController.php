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
        //printf('Event created: %s\n', $results->start->dateTime);
        
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
            
            return response([
                'google_id'=>$results->id,
                'started_at'=>$results->start->dateTime,
                'name'=>$results->summary,
                'duration'=> $this->getDurationAttribute($results->start->dateTime,$results->end->dateTime),
            ]);
            
        }
        
        public function getDurationAttribute($start,$end)
        {
            return Carbon::parse($start)->diffForHumans(Carbon::parse($end), true);
        }
        
        public function destroy(Request $request, Google $google, $google_id)
        {      
            $event = Event::where('google_id',$google_id);

            $event->delete();

            $calendarId = 'alakodcontact@gmail.com';

            $token= auth()->user()->googleAccounts()->first()->token;
        
            $service = $google->connectUsing($token)->service('Calendar');

            $service->events->delete($calendarId, $google_id);


        }

        public function update(Request $request,Google $google,$google_id)
        {   
            $data=Event::where('google_id',$google_id);
            $data->update([
                'name'=>$request->name
            ]);

            $token= auth()->user()->googleAccounts()->first()->token;
        
            $service = $google->connectUsing($token)->service('Calendar');

            $calendarId = 'alakodcontact@gmail.com';

            $event = $service->events->get($calendarId, $google_id);

            $event->setSummary($request->name);

            $service->events->update($calendarId, $event->getId(), $event);

        }
    }
    