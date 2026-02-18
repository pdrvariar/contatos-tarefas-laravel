<?php

namespace App\Livewire\Book;

use App\Interfaces\BookServiceInterface;
use App\Models\Book;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Book $book;
    public $title;
    public $author;
    public $description;
    public $isbn;
    public $pages;
    public $publisher;
    public $published_at;
    public $cover_image;
    public $tags;

    public function mount(Book $book)
    {
        Gate::authorize('update', $book);
        $this->book = $book;
        $this->title = $book->title;
        $this->author = $book->author;
        $this->description = $book->description;
        $this->isbn = $book->isbn;
        $this->pages = $book->pages;
        $this->publisher = $book->publisher;
        $this->published_at = $book->published_at ? $book->published_at->format('Y-m-d') : null;
        $this->tags = $book->tags->pluck('name')->implode(',');
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'isbn' => 'nullable|string|max:20',
            'pages' => 'nullable|integer|min:1',
            'publisher' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|string',
        ];
    }

    public function save(BookServiceInterface $bookService)
    {
        Gate::authorize('update', $this->book);
        $validatedData = $this->validate();

        if ($this->cover_image) {
            $validatedData['cover_image'] = $this->cover_image;
        }

        $bookService->updateBook($this->book, $validatedData);

        session()->flash('success', 'Livro atualizado com sucesso!');
        return redirect()->route('books.index');
    }

    public function render()
    {
        return view('livewire.book.edit')->layout('layouts.app');
    }
}
