<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Webhooks can have two states `exists` or `sync`.
        // `sync` webhooks are just notifications telling us that a
        // new webhook has been created. Since we already performed
        // an initial synchronization we can safely ignore them.
        if ($request->header('x-goog-resource-state') !== 'exists') {
            return;
        }

        Synchronization::query()
            ->where('id', $request->header('x-goog-channel-id'))
            ->where('resource_id', $request->header('x-goog-resource-id'))
            ->firstOrFail()
            ->ping();
    }
}
