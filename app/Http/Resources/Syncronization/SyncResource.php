<?php

namespace App\Http\Resources\Syncronization;

use Illuminate\Http\Resources\Json\JsonResource;

class SyncResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {   
        return $this->fullSync 
                ?[
                    // 'full_sync'=>$this->fullSync,
                    'moved'=>$this->moved,

                    'categories'=>auth()->user()->categories,
                    'boards'=>auth()->user()->boards,
                    'columns'=>auth()->user()->columns,
                    'cards'=>auth()->user()->cards,
                    'tasks'=>auth()->user()->tasks,
                    'temp_id_mapping'=>'temp id mapping',
                    'user'=>auth()->user(),//new UserResource(auth()->user())
                    'user_plan_limits'=>'user plan limits',
                    'user_settings'=>'user settings'
                 ]
                
                :[  
                    // 'full_sync'=>$this->fullSync,
                    'moved'=>$this->moved,
                    'categories'=>$this->categories,
                    'boards'=>$this->boards,
                    'columns'=>$this->columns,
                    'cards'=>$this->cards,
                    'tasks'=>$this->tasks,
                    'temp_id_mapping'=>$this->temp_id_mapping,
                    // 'user'=>auth()->user(),//new UserResource(auth()->user())
                    'user_plan_limits'=>$this->user_plan_limits,
                    'user_settings'=>$this->user_settings,


                ];
    }
}
