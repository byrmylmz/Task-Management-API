<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Board\BoardResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'boards'=>BoardResource::collection($this->boards),
        ];
    }
}
