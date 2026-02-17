<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Interfaces\BookServiceInterface;
use App\Http\Requests\Api\v1\StoreBookRequest;
use App\Http\Requests\Api\v1\UpdateBookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookServiceInterface $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index()
    {
        $user = Auth::user();
        $totalBooks = $user->books()->count();

        // Exemplo simples de estatísticas por autor
        $stats = $user->books()
            ->select('author as label', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->groupBy('author')
            ->limit(3)
            ->get();

        return view('books.index', compact('totalBooks', 'stats'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(StoreBookRequest $request)
    {
        $this->bookService->createBookForUser(Auth::user(), $request->validated());
        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso!');
    }

    public function show(Book $book)
    {
        Gate::authorize('view', $book);
        $book->load('tags');
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        Gate::authorize('update', $book);
        $book->load('tags');
        return view('books.edit', compact('book'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        Gate::authorize('update', $book);
        $this->bookService->updateBook($book, $request->validated());
        return redirect()->route('books.show', $book->id)->with('success', 'Livro atualizado!');
    }

    public function destroy(Book $book)
    {
        Gate::authorize('delete', $book);
        $this->bookService->deleteBook($book);
        return redirect()->route('books.index')->with('success', 'Livro removido!');
    }
}
