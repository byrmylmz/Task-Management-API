<?php

namespace App\Http\Resources\Card;

use App\Http\Resources\Task\TaskResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       return[
           'id'=>$this->id,
           'title'=>$this->title,
           'tasks'=>TaskResource::collection($this->tasks),
       ];

    }
}