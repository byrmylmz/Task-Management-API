<?php

namespace App\Http\Resources\Board;

use App\Http\Resources\Column\ColumnResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BoardResource extends JsonResource
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
            'inbox_board'=>$this->inbox_board,
            'category_id'=>$this->category_id
        ];

    }
}
