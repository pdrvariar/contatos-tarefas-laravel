<?php

namespace App\Interfaces;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ContactServiceInterface
{
    public function getAllContactsForUser(User $user, int $perPage = 10, array $filters = []): LengthAwarePaginator;

    public function createContactForUser(User $user, array $data): Contact;

    public function updateContact(Contact $contact, array $data): bool;

    public function deleteContact(Contact $contact): bool;
}
