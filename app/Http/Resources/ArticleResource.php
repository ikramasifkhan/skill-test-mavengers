<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "title"=> $this->title,
            "slug"=> $this->slug,
            "content" => $this->content,
            "user_id"=>$this->user_id,
            'author'=> new UserResource($this->whenLoaded('author')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'published_at'=> Carbon::parse($this->created_at)->format('d-m-y'),
			'status' => $this->status
        ];
    }
}
