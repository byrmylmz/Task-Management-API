<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Board\BoardWithColumnResource;

class CategoryResource extends JsonResource
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
            'order'=>$this->order,
            'boards'=>BoardWithColumnResource::collection($this->boards->load('columns')),
        ];
    }
}
