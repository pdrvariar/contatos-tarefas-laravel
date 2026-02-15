<?php

namespace App\Services;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TagService
{
    public function syncTags(Model $model, User $user, array $tagNames)
    {
        $tagIds = [];
        foreach ($tagNames as $tagName) {
            $tagName = trim($tagName);
            if (empty($tagName)) continue;

            $tag = Tag::firstOrCreate(
                ['name' => $tagName, 'user_id' => $user->id],
                ['color' => $this->getRandomColor()]
            );
            $tagIds[] = $tag->id;
        }
        $model->tags()->sync($tagIds);
    }

    private function getRandomColor()
    {
        $colors = ['blue', 'green', 'yellow', 'red', 'purple', 'teal', 'gray'];
        return $colors[array_rand($colors)];
    }
}
