<?php

namespace App\Livewire\Book;

use App\Interfaces\BookServiceInterface;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $tags = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'tags' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTags()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'tags']);
        $this->resetPage();
    }

    public function deleteBook(Book $book, BookServiceInterface $bookService)
    {
        $this->authorize('delete', $book);
        $bookService->deleteBook($book);
        session()->flash('success', 'Livro removido com sucesso!');
    }

    public function render()
    {
        $query = Auth::user()->books()->with('tags');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('author', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->tags) {
            $tagArray = array_map('trim', explode(',', $this->tags));
            foreach ($tagArray as $tag) {
                if ($tag) {
                    $query->whereHas('tags', function($q) use ($tag) {
                        $q->where('name', 'like', '%' . $tag . '%');
                    });
                }
            }
        }

        $books = $query->latest()->paginate(12);

        $stats = Auth::user()->books()
            ->select('author as label', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->groupBy('author')
            ->limit(3)
            ->get();

        return view('livewire.book.index', [
            'books' => $books,
            'totalBooks' => Auth::user()->books()->count(),
            'stats' => $stats
        ])->layout('layouts.app');
    }
}
