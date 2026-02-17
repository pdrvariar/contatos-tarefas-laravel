<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'description' => $this->description,
            'isbn' => $this->isbn,
            'pages' => $this->pages,
            'publisher' => $this->publisher,
            'published_at' => $this->published_at ? $this->published_at->format('Y-m-d') : null,
            'cover_image_url' => $this->cover_image_url,
            'tags' => $this->tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name,
                    'color' => $tag->color,
                ];
            }),
            'tags_string' => $this->tags->pluck('name')->implode(','),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
