<?php

namespace App\Http\Resources\Synchronization;

use Illuminate\Http\Resources\Json\JsonResource;

class FullSyncResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
                 [    
                    'categories'=>auth()->user()->categories,
                    'boards'=>auth()->user()->boards,
                    'columns'=>auth()->user()->columns,
                    'cards'=>auth()->user()->cards,
                    'tasks'=>auth()->user()->tasks,
                    'temp_id_mapping'=>'temp id mapping',
                    'user'=>auth()->user(),//new UserResource(auth()->user())
                    'user_plan_limits'=>'user plan limit',
                    'user_settings'=>'user settings'
                 ];
    }
}
