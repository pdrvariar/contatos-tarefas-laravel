<?php

namespace App\Interfaces;

use App\Models\User;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;

interface BookServiceInterface
{
    public function getAllBooksForUser(User $user, int $perPage = 10, array $filters = []): LengthAwarePaginator;
    public function createBookForUser(User $user, array $data): Book;
    public function updateBook(Book $book, array $data): Book;
    public function deleteBook(Book $book): bool;
}
