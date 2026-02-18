<?php
namespace Tests\Feature;
use App\Models\User;
use App\Livewire\Book\Index;
use App\Livewire\Book\Create;
use App\Livewire\Book\Edit;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
class BookLivewireTest extends TestCase
{
    use RefreshDatabase;
    public function test_book_index_is_accessible()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/books');
        $response->assertStatus(200);
        $response->assertSee('Livros (Livewire)');
    }
    public function test_book_create_is_accessible()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/books/create');
        $response->assertStatus(200);
        $response->assertSee('Novo Livro (Livewire)');
    }
    public function test_book_edit_is_accessible()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->get("/books/{$book->id}/edit");
        $response->assertStatus(200);
        $response->assertSee('Editar Livro (Livewire)');
    }

    public function test_can_create_book_with_tags()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Create::class)
            ->set('title', 'Livro Teste')
            ->set('author', 'Autor Teste')
            ->set('tags', 'tag1, tag2')
            ->call('save')
            ->assertRedirect('/books');

        $book = Book::where('title', 'Livro Teste')->first();
        $this->assertNotNull($book);
        $this->assertEquals(2, $book->tags()->count());
        $this->assertTrue($book->tags->pluck('name')->contains('tag1'));
        $this->assertTrue($book->tags->pluck('name')->contains('tag2'));
    }

    public function test_can_delete_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(Index::class)
            ->call('deleteBook', $book->id)
            ->assertHasNoErrors();

        $this->assertSoftDeleted($book);
    }

    public function test_can_clear_filters()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Index::class)
            ->set('search', 'Termo Busca')
            ->set('tags', 'tag1')
            ->call('clearFilters')
            ->assertSet('search', '')
            ->assertSet('tags', '');
    }
}
