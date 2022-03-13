<?php

namespace App\Http\Controllers;

use App\Http\Resources\Syncronization\SyncResource;
use Illuminate\Http\Request;

class SyncController extends Controller
{
    public function index()
    {
        return new SyncResource('');
    }
}
