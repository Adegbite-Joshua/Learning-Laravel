<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
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
            "id"=> $this->id,
            "name"=> $this->name,
            "description"=> $this->description,
            "priority"=> $this->priority,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
            "relationships"=> [
                "id"=> $this->user->id,
                "user name"=> $this->user->name,
                "user email"=> $this->user->email,
            ]
        ];
    }
}
