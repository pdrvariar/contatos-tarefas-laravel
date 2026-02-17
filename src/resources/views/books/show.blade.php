@extends('layouts.app')

@section('header_title', $book->title)
@section('header_actions')
    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary-modern btn-modern me-2">
        <i class="fas fa-edit me-2"></i>Editar
    </a>
    <a href="{{ route('books.index') }}" class="btn btn-outline-modern btn-modern">
        <i class="fas fa-arrow-left me-2"></i>Voltar
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card-modern p-4 mb-4">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="{{ $book->cover_image_url ?? 'https://via.placeholder.com/300x400?text=Sem+Capa' }}" class="img-fluid rounded-3 shadow-sm" style="max-height: 300px; object-fit: cover;">
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h2 class="fw-bold" style="color: var(--text-primary);">{{ $book->title }}</h2>
                            <div class="dropdown">
                                <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                    <li><a class="dropdown-item" href="{{ route('books.edit', $book->id) }}"><i class="fas fa-edit me-2 text-primary"></i>Editar</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteBook('{{ $book->id }}')"><i class="fas fa-trash-alt me-2"></i>Excluir</a></li>
                                </ul>
                            </div>
                        </div>
                        <p class="text-muted mb-3"><i class="fas fa-user me-2"></i>{{ $book->author }}</p>

                        @if($book->tags->count())
                            <div class="mb-3">
                                @foreach($book->tags as $tag)
                                    <span class="badge-tag me-1" style="background-color: rgba({{ implode(',', sscanf($tag->color, '#%02x%02x%02x')) }}, 0.1); color: {{ $tag->color }}; border: 1px solid rgba({{ implode(',', sscanf($tag->color, '#%02x%02x%02x')) }}, 0.2);">
                                    {{ $tag->name }}
                                </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <div class="bg-light rounded-3 p-3">
                                    <small class="text-muted d-block">ISBN</small>
                                    <span class="fw-bold">{{ $book->isbn ?? '—' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="bg-light rounded-3 p-3">
                                    <small class="text-muted d-block">Editora</small>
                                    <span class="fw-bold">{{ $book->publisher ?? '—' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="bg-light rounded-3 p-3">
                                    <small class="text-muted d-block">Páginas</small>
                                    <span class="fw-bold">{{ $book->pages ?? '—' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="bg-light rounded-3 p-3">
                                    <small class="text-muted d-block">Publicação</small>
                                    <span class="fw-bold">{{ $book->published_at ? $book->published_at->format('d/m/Y') : '—' }}</span>
                                </div>
                            </div>
                        </div>

                        @if($book->description)
                            <div class="mt-3">
                                <h6 class="fw-bold mb-2">Descrição</h6>
                                <div class="bg-light rounded-3 p-3">
                                    {{ $book->description }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Timeline do livro (informações de criação/atualização) -->
            <div class="card-modern p-4">
                <h6 class="fw-bold mb-3">Histórico do Livro</h6>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <span class="fw-bold">Criado</span>
                            <p class="small text-muted">{{ $book->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-secondary"></div>
                        <div class="timeline-content">
                            <span class="fw-bold">Última atualização</span>
                            <p class="small text-muted">{{ $book->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @if($book->deleted_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-danger"></div>
                            <div class="timeline-content">
                                <span class="fw-bold text-danger">Arquivado</span>
                                <p class="small text-muted">{{ $book->deleted_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }
        .timeline-marker {
            position: absolute;
            left: -30px;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 3px solid #fff;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: -25px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
        }
    </style>
@endsection

@push('scripts')
    <script>
        async function deleteBook(id) {
            const confirm = await Swal.fire({
                title: 'Excluir livro?',
                text: 'Esta ação não pode ser desfeita.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sim, excluir'
            });
            if (confirm.isConfirmed) {
                const res = await fetch(`/api/books/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                if (res.ok) {
                    window.location.href = '{{ route('books.index') }}';
                    Swal.fire('Excluído!', 'Livro removido.', 'success');
                } else {
                    Swal.fire('Erro!', 'Não foi possível excluir.', 'error');
                }
            }
        }
    </script>
@endpush
