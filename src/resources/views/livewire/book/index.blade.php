<div>
    <x-slot name="header_title">Livros (Livewire)</x-slot>
    <x-slot name="header_actions">
        <a href="{{ route('books.create') }}" class="btn btn-primary-modern btn-modern" wire:navigate>
            <i class="fas fa-plus me-2"></i>Novo Livro
        </a>
    </x-slot>

    @push('styles')
        <style>
            .book-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04); transition: transform 0.25s ease, box-shadow 0.3s ease; cursor: pointer; border: 1px solid rgba(0, 0, 0, 0.02); height: 100%; display: flex; flex-direction: column; }
            .book-card:hover { transform: translateY(-6px); box-shadow: 0 20px 24px -8px rgba(30, 74, 122, 0.15); border-color: rgba(30, 74, 122, 0.1); }
            .book-cover-wrapper { position: relative; width: 100%; aspect-ratio: 2 / 3; background-color: #fafafa; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid #f0f0f0; padding: 12px; }
            .book-cover-img { width: 100%; height: 100%; object-fit: contain; transition: transform 0.3s ease; }
            .book-info-wrapper { padding: 1rem 1rem 1.2rem; flex: 1; display: flex; flex-direction: column; gap: 0.25rem; }
            .book-title { font-size: 1rem; font-weight: 700; line-height: 1.3; color: #1e2b3c; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 0.2rem; }
            .book-author { font-size: 0.85rem; color: #5e6f88; font-weight: 400; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 0.4rem; }
            .book-meta { font-size: 0.75rem; color: #7a8ba3; display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.5rem; }
            .badge-tag { display: inline-block; padding: 0.25rem 0.6rem; border-radius: 100px; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.025em; }
        </style>
    @endpush

    <div class="container-fluid py-4">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filtros Reativos -->
        <div class="card-modern p-4 mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input wire:model.live.debounce.300ms="search" type="text" class="form-control border-start-0" placeholder="Buscar por título ou autor...">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-tags text-muted"></i></span>
                        <input wire:model.live.debounce.300ms="tags" type="text" class="form-control border-start-0" placeholder="Filtrar por tags (separadas por vírgula)...">
                    </div>
                </div>
                <div class="col-md-2">
                    <button wire:click="clearFilters" class="btn btn-outline-modern btn-modern w-100" @if(!$search && !$tags) disabled @endif>
                        <i class="fas fa-filter-circle-xmark me-2"></i>Limpar
                    </button>
                </div>
            </div>
        </div>

        <!-- Estatísticas -->
        @if($stats && count($stats))
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card-modern p-3">
                        <div class="d-flex flex-wrap gap-3 align-items-center">
                            @foreach($stats as $stat)
                                <span class="badge-tag" style="background-color: rgba(30,74,122,0.1); color: #1E4A7A;">
                                    <i class="fas fa-book me-1"></i> {{ $stat->label }}: {{ $stat->count }}
                                </span>
                            @endforeach
                            <span class="text-muted small ms-auto">
                                <i class="fas fa-layer-group me-1"></i>Total: {{ $totalBooks }} livros
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Lista de Livros -->
        <div class="row g-4">
            @forelse($books as $book)
                <div class="col-xl-3 col-lg-4 col-md-6" wire:key="book-{{ $book->id }}">
                    <div class="book-card" onclick="window.location.href='{{ route('books.show', $book->id) }}'">
                        <div class="book-cover-wrapper">
                            @if($book->cover_image_url)
                                <img src="{{ $book->cover_image_url }}" class="book-cover-img" alt="{{ $book->title }}">
                            @else
                                <div class="text-center text-muted">
                                    <i class="fas fa-book fa-3x mb-2 opacity-25"></i>
                                    <p class="small mb-0">Sem capa</p>
                                </div>
                            @endif
                        </div>
                        <div class="book-info-wrapper">
                            <h3 class="book-title">{{ $book->title }}</h3>
                            <p class="book-author">por {{ $book->author }}</p>
                            <div class="book-meta">
                                <span class="book-meta-item"><i class="fas fa-calendar"></i> {{ $book->published_at?->format('Y') ?? 'N/A' }}</span>
                                @if($book->isbn)
                                    <span class="book-meta-item"><i class="fas fa-barcode"></i> {{ $book->isbn }}</span>
                                @endif
                            </div>
                            <div class="book-tags-container mt-2 d-flex flex-wrap gap-1">
                                @foreach($book->tags as $tag)
                                    <span class="badge-tag" style="background-color: rgba(30,74,122,0.1); color: #1E4A7A; font-size: 0.6rem; padding: 0.15rem 0.4rem;">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-outline-primary" onclick="event.stopPropagation()">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button wire:click.stop="deleteBook('{{ $book->id }}')" wire:confirm="Tem certeza que deseja remover este livro?" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-book fa-3x text-light mb-3"></i>
                    <h5>Nenhum livro encontrado</h5>
                    <p class="text-muted">Ajuste seus filtros ou adicione um novo livro.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $books->links() }}
        </div>
    </div>
</div>
