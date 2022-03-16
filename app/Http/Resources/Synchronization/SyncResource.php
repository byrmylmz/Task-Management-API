<?php

namespace App\Http\Resources\Synchronization;

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
        return 
                [  
                    // 'full_sync'=>$this->fullSync,
                    'moved'=>$this->moved,
                    'categories'=>$this->category,
                    'boards'=>$this->board,
                    'columns'=>$this->column,
                    'cards'=>$this->card,
                    'tasks'=>$this->task,
                    'temp_id_mapping'=>$this->temp_id_mapping,
                    // 'user'=>auth()->user(),//new UserResource(auth()->user())
                    'user_plan_limits'=>$this->user_plan_limit,
                    'user_settings'=>$this->user_setting,


                ];
    }
}
