<?php

namespace App\Livewire\Book;

use App\Interfaces\BookServiceInterface;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $title;
    public $author;
    public $description;
    public $isbn;
    public $pages;
    public $publisher;
    public $published_at;
    public $cover_image;
    public $tags;

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
        $validatedData = $this->validate();

        if ($this->cover_image) {
            $validatedData['cover_image'] = $this->cover_image;
        }

        $bookService->createBookForUser(Auth::user(), $validatedData);

        session()->flash('success', 'Livro criado com sucesso!');
        return redirect()->route('books.index');
    }

    public function render()
    {
        return view('livewire.book.create')->layout('layouts.app');
    }
}
