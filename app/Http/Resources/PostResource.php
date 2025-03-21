<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "image"=>assert($this->image),
            "category_id"=>$this->category_id,
            "title"=>$this->title,
            "content"=>$this->content,
            "smallDesc"=>$this->smallDesc,
            "blog"=>$this->smallDesc . $this->content,
            "writer"=>$this->whenLoaded('user'),
            "category"=>CategoryResource::make($this->whenLoaded('category')),
        ];
    }
}
