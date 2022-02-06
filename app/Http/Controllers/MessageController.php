<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreMessageRequest;


class MessageController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $messages = Message::orderByDesc('created_at')->paginate(6);
      return MessageResource::collection($messages);

     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMessageRequest $request)
    {
        $user = Auth::user();
        $message = new Message(['body' => $request->body]);
        $user->messages()->save($message);

        $messages = Message::orderByDesc('created_at')->paginate(6);
        return MessageResource::collection($messages);
    }
}
