<?php

namespace App\Services;

use App\Interfaces\ContactServiceInterface;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactService implements ContactServiceInterface
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function getAllContactsForUser(User $user, int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        $query = $user->contacts()->with('tags');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['tags'])) {
            $tags = explode(',', $filters['tags']);
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('name', $tags);
            });
        }

        return $query->orderBy('name', 'asc')->paginate($perPage);
    }

    public function createContactForUser(User $user, array $data): Contact
    {
        return DB::transaction(function () use ($user, $data) {
            $contact = $user->contacts()->create($data);

            if (isset($data['tags'])) {
                $this->tagService->syncTags($contact, $user, explode(',', $data['tags']));
            }

            return $contact->load('tags');
        });
    }

    public function updateContact(Contact $contact, array $data): bool
    {
        return DB::transaction(function () use ($contact, $data) {
            $updated = $contact->update($data);

            if (isset($data['tags'])) {
                $this->tagService->syncTags($contact, $contact->user, explode(',', $data['tags']));
            }

            return $updated;
        });
    }

    public function deleteContact(Contact $contact): bool
    {
        return $contact->delete();
    }
}
