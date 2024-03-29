<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserBasicResource;
use App\Models\User;
use App\Scopes\UserIdScope;

class MessageResource extends JsonResource
{    
 
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user' => new UserBasicResource($this->user),
            'createdAt' => $this->created_at->diffForHumans(),
          ];
    }
}
