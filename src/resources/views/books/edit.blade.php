@extends('layouts.app')

@section('header_title', 'Editar Livro')
@section('header_actions')
    <a href="{{ route('books.show', $book->id) }}" class="btn btn-outline-modern btn-modern me-2">
        <i class="fas fa-eye me-2"></i>Ver Livro
    </a>
    <a href="{{ route('books.index') }}" class="btn btn-outline-modern btn-modern">
        <i class="fas fa-arrow-left me-2"></i>Voltar
    </a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-modern p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background: var(--primary); color: white;">
                        <i class="fas fa-book fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--text-primary);">Editar Livro</h4>
                        <p class="text-muted mb-0">Atualize os detalhes do livro</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('books.update', $book->id) }}" enctype="multipart/form-data" id="bookForm">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-4 mb-3 text-center">
                            <label class="form-label fw-semibold small text-uppercase text-muted d-block">Capa do Livro</label>
                            <div class="position-relative d-inline-block">
                                <img id="cover_preview" src="{{ $book->cover_image_url ?? 'https://via.placeholder.com/150x200?text=Sem+Capa' }}" class="img-thumbnail mb-2" style="width: 150px; height: 200px; object-fit: cover; border-radius: 8px;">
                                <div class="mt-2">
                                    <input type="file" class="form-control form-control-sm @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" accept="image/*" onchange="previewImage(this)">
                                </div>
                                @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-uppercase text-muted">Título <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $book->title) }}" required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-uppercase text-muted">Autor <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-white @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author', $book->author) }}" required>
                                @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold small text-uppercase text-muted">ISBN</label>
                                    <input type="text" class="form-control bg-white @error('isbn') is-invalid @enderror" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}">
                                    @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold small text-uppercase text-muted">Editora</label>
                                    <input type="text" class="form-control bg-white @error('publisher') is-invalid @enderror" id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}">
                                    @error('publisher')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold small text-uppercase text-muted">Páginas</label>
                            <input type="number" class="form-control bg-white @error('pages') is-invalid @enderror" id="pages" name="pages" value="{{ old('pages', $book->pages) }}" min="1">
                            @error('pages')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold small text-uppercase text-muted">Data de Publicação</label>
                            <input type="date" class="form-control bg-white @error('published_at') is-invalid @enderror" id="published_at" name="published_at" value="{{ old('published_at', optional($book->published_at)->format('Y-m-d')) }}">
                            @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Descrição / Resumo</label>
                        <textarea class="form-control bg-white @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $book->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Tags</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-tags text-muted"></i></span>
                            <input type="text" class="form-control bg-white border-start-0" id="tags" name="tags" value="{{ old('tags', $book->tags->pluck('name')->implode(',')) }}">
                        </div>
                        <div class="form-text">Separe as tags com vírgula ou pressione Enter</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-outline-modern btn-modern px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary-modern btn-modern px-4">
                            <i class="fas fa-save me-2"></i>Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let tagifyInput;

        document.addEventListener('DOMContentLoaded', () => {
            initTagify();
        });

        async function initTagify() {
            const input = document.getElementById('tags');
            if (!input) return;

            let whitelist = [];
            try {
                const res = await fetch('/web-api/tags');
                whitelist = await res.json();
            } catch (e) {}

            const colorMap = {
                primary: { bg: '#DEEBFF', text: '#0747A6', border: '#B3D4FF' },
                dark: { bg: '#EAE6FF', text: '#403294', border: '#C0B6F2' },
                light: { bg: '#E3FCEF', text: '#006644', border: '#ABF5D1' },
                accent: { bg: '#FFF0B3', text: '#172B4D', border: '#FFE380' },
                soft: { bg: '#FFFAE6', text: '#FF8B00', border: '#FFF0B3' },
                danger: { bg: '#FFEBE6', text: '#BF2600', border: '#FFBDAD' }
            };

            const transformTag = (tagData) => {
                const colors = ['primary', 'dark', 'light', 'accent', 'soft', 'danger'];
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                const style = colorMap[randomColor];
                tagData.style = `--tag-bg: ${style.bg}; --tag-text-color: ${style.text}; --tag-hover: ${style.bg}; border: 1px solid ${style.border};`;
            };

            tagifyInput = new Tagify(input, {
                whitelist: whitelist,
                transformTag,
                dropdown: {
                    classname: "tags-look",
                    enabled: 0,
                    closeOnSelect: false
                },
                originalInputValueFormat: arr => arr.map(v => v.value).join(',')
            });

            // Pré-carregar tags do livro
            @if($book->tags->count())
            tagifyInput.addTags(@json($book->tags->map(fn($t) => ['value' => $t->name, 'color' => $t->color])));
            @endif
        }

        function hexToRgb(hex) {
            if (!hex) return '0,0,0';
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            return `${r}, ${g}, ${b}`;
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('cover_preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
