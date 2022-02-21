<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventCollection;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events=auth()->user()->events()->orderBy('started_at','desc')->get();

        return new EventCollection($events);
    }
}
