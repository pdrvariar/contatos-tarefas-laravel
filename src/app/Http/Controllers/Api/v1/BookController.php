<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Http\Requests\Api\v1\StoreBookRequest;
use App\Http\Requests\Api\v1\UpdateBookRequest;
use App\Http\Resources\Api\v1\BookResource;
use App\Interfaces\BookServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    use ApiResponse;

    protected $bookService;

    public function __construct(BookServiceInterface $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'tags']);
        $books = $this->bookService->getAllBooksForUser(Auth::user(), 6, $filters);

        return BookResource::collection($books)->additional([
            'status' => 'success',
            'message' => 'Lista de livros recuperada'
        ]);
    }

    public function store(StoreBookRequest $request)
    {
        $book = $this->bookService->createBookForUser(Auth::user(), $request->validated());

        return $this->successResponse(
            new BookResource($book),
            'Livro criado com sucesso',
            201
        );
    }

    public function show(Book $book)
    {
        Gate::authorize('view', $book);

        return (new BookResource($book->load('tags')))->additional([
            'status' => 'success',
            'message' => 'Livro recuperado com sucesso'
        ]);
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        Gate::authorize('update', $book);

        $this->bookService->updateBook($book, $request->validated());

        return $this->successResponse(
            new BookResource($book->load('tags')),
            'Livro atualizado com sucesso'
        );
    }

    public function destroy(Book $book)
    {
        Gate::authorize('delete', $book);

        $this->bookService->deleteBook($book);

        return $this->successResponse(null, 'Livro excluído com sucesso', 204);
    }
}
