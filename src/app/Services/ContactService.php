<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ContactService
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function getAllContactsForUser(User $user, int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        try {
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
        } catch (\Exception $e) {
            // Se falhar ao carregar tags (tabela inexistente), tenta carregar sem tags
            Log::error("Erro ao carregar contatos com tags: " . $e->getMessage());
            return $user->contacts()->orderBy('name', 'asc')->paginate($perPage);
        }
    }

    public function createContactForUser(User $user, array $data): Contact
    {
        $contact = $user->contacts()->create($data);

        if (isset($data['tags'])) {
            try {
                $this->tagService->syncTags($contact, $user, explode(',', $data['tags']));
            } catch (\Exception $e) {
                Log::error("Erro ao salvar tags no contato: " . $e->getMessage());
            }
        }

        // Tenta carregar tags, se falhar retorna sem tags
        try {
            return $contact->load('tags');
        } catch (\Exception $e) {
            return $contact;
        }
    }

    public function updateContact(Contact $contact, array $data): bool
    {
        $updated = $contact->update($data);

        if (isset($data['tags'])) {
            try {
                $this->tagService->syncTags($contact, $contact->user, explode(',', $data['tags']));
            } catch (\Exception $e) {
                Log::error("Erro ao atualizar tags no contato: " . $e->getMessage());
            }
        }

        return $updated;
    }

    public function deleteContact(Contact $contact): bool
    {
        return $contact->delete();
    }
}
