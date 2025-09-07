<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'user' => new UserResource($this->user),
            'roles' => RoleResource::collection($this->roles),
            'tags' => TagResource::collection($this->tags),
            'comments_count' => $this->comments_count,
            'applications_count' => $this->applications_count
        ];
    }
}
