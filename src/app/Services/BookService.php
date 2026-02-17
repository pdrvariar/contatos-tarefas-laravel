<?php

namespace App\Services;

use App\Interfaces\BookServiceInterface;
use App\Models\Book;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookService implements BookServiceInterface
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function getAllBooksForUser(User $user, int $perPage = 6, array $filters = []): LengthAwarePaginator
    {
        $query = $user->books()->with('tags');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['tags'])) {
            $tags = is_array($filters['tags']) ? $filters['tags'] : explode(',', $filters['tags']);
            // Garantir que as tags não sejam vazias e remover possíveis resquícios de JSON se o Tagify falhar
            $tags = array_filter(array_map(function($t) {
                $t = trim($t);
                if (strpos($t, '{') === 0) {
                    try {
                        $json = json_decode($t, true);
                        return $json['value'] ?? $t;
                    } catch (\Exception $e) { return $t; }
                }
                return $t;
            }, $tags));

            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('name', $tags);
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function createBookForUser(User $user, array $data): Book
    {
        return DB::transaction(function () use ($user, $data) {
            if (isset($data['cover_image']) && $data['cover_image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['cover_image'] = $data['cover_image']->store('book_covers', 'public');
            }

            $book = $user->books()->create($data);

            if (isset($data['tags'])) {
                $tags = is_array($data['tags']) ? $data['tags'] : explode(',', $data['tags']);
                // Robustez extra para processar tags
                $tags = array_filter(array_map(function($t) {
                    $t = trim($t);
                    if (strpos($t, '{') === 0) {
                        try {
                            $json = json_decode($t, true);
                            return $json['value'] ?? $t;
                        } catch (\Exception $e) { return $t; }
                    }
                    return $t;
                }, $tags));

                $this->tagService->syncTags($book, $user, $tags);
            }

            return $book->load('tags');
        });
    }

    public function updateBook(Book $book, array $data): Book
    {
        return DB::transaction(function () use ($book, $data) {
            if (isset($data['cover_image']) && $data['cover_image'] instanceof \Illuminate\Http\UploadedFile) {
                if ($book->cover_image) {
                    Storage::disk('public')->delete($book->cover_image);
                }
                $data['cover_image'] = $data['cover_image']->store('book_covers', 'public');
            }

            $book->update($data);

            if (isset($data['tags'])) {
                $tags = is_array($data['tags']) ? $data['tags'] : explode(',', $data['tags']);
                // Robustez extra para processar tags
                $tags = array_filter(array_map(function($t) {
                    $t = trim($t);
                    if (strpos($t, '{') === 0) {
                        try {
                            $json = json_decode($t, true);
                            return $json['value'] ?? $t;
                        } catch (\Exception $e) { return $t; }
                    }
                    return $t;
                }, $tags));

                $this->tagService->syncTags($book, $book->user, $tags);
            }

            return $book->load('tags');
        });
    }

    public function deleteBook(Book $book): bool
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        return $book->delete();
    }
}
