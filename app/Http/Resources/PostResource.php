<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'status' => $this->status,
            'published_at' => $this->published_at?->format('Y-m-d H:i:s'),
            'author' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'comments_count' => $this->when($this->relationLoaded('comments'), 
                fn() => $this->comments->count()
            ),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
