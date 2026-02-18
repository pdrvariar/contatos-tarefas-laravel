<div>
    <x-slot name="header_title">Editar Livro (Livewire)</x-slot>
    <x-slot name="header_actions">
        <a href="{{ route('books.index') }}" class="btn btn-outline-modern btn-modern">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </x-slot>

    <div class="row justify-content-center py-4">
        <div class="col-lg-8">
            <div class="card-modern p-4 shadow-sm border-0" style="border-radius: 20px;">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background: #1E4A7A; color: white;">
                        <i class="fas fa-edit fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1" style="color: #1e2b3c;">Editar Livro</h4>
                        <p class="text-muted mb-0">Atualize os detalhes do seu livro</p>
                    </div>
                </div>

                <form wire:submit.prevent="save">
                    <div class="row">
                        <div class="col-md-4 mb-3 text-center">
                            <label class="form-label fw-semibold small text-uppercase text-muted d-block">Capa do Livro</label>
                            <div class="position-relative d-inline-block">
                                @if ($cover_image)
                                    <img src="{{ $cover_image->temporaryUrl() }}" class="img-thumbnail mb-2" style="width: 150px; height: 200px; object-fit: cover; border-radius: 8px;">
                                @elseif($book->cover_image_url)
                                    <img src="{{ $book->cover_image_url }}" class="img-thumbnail mb-2" style="width: 150px; height: 200px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <img src="https://via.placeholder.com/150x200?text=Sem+Capa" class="img-thumbnail mb-2" style="width: 150px; height: 200px; object-fit: cover; border-radius: 8px;">
                                @endif

                                <div class="mt-2" wire:loading.class="opacity-50" wire:target="cover_image">
                                    <input type="file" wire:model="cover_image" class="form-control form-control-sm @error('cover_image') is-invalid @enderror" id="cover_image" accept="image/*">
                                    <div wire:loading wire:target="cover_image" class="small text-muted mt-1">
                                        <i class="fas fa-spinner fa-spin"></i> Carregando...
                                    </div>
                                </div>
                                @error('cover_image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-uppercase text-muted">Título <span class="text-danger">*</span></label>
                                <input type="text" wire:model.blur="title" class="form-control bg-white @error('title') is-invalid @enderror" placeholder="Título do livro">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-uppercase text-muted">Autor <span class="text-danger">*</span></label>
                                <input type="text" wire:model.blur="author" class="form-control bg-white @error('author') is-invalid @enderror" placeholder="Nome do autor">
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold small text-uppercase text-muted">ISBN</label>
                                    <input type="text" wire:model.blur="isbn" class="form-control bg-white @error('isbn') is-invalid @enderror" placeholder="ISBN">
                                    @error('isbn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold small text-uppercase text-muted">Editora</label>
                                    <input type="text" wire:model.blur="publisher" class="form-control bg-white @error('publisher') is-invalid @enderror" placeholder="Editora">
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
                            <input type="number" wire:model.blur="pages" class="form-control bg-white @error('pages') is-invalid @enderror" min="1">
                            @error('pages')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold small text-uppercase text-muted">Data de Publicação</label>
                            <input type="date" wire:model.blur="published_at" class="form-control bg-white @error('published_at') is-invalid @enderror">
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Descrição / Resumo</label>
                        <textarea wire:model.blur="description" class="form-control bg-white @error('description') is-invalid @enderror" rows="4" placeholder="Uma breve descrição sobre o livro..."></textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Tags</label>
                        <div class="input-group" wire:ignore>
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-tags text-muted"></i></span>
                            <input type="text" id="tags-input" wire:model.blur="tags" class="form-control bg-white border-start-0" placeholder="Ex: Ficção, Mistério, Clássico (separados por vírgula)">
                        </div>
                        <div class="form-text">Separe as tags com vírgula</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('books.index') }}" class="btn btn-outline-modern btn-modern px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary-modern btn-modern px-4">
                            <span wire:loading.remove wire:target="save">
                                <i class="fas fa-save me-2"></i>Atualizar Livro
                            </span>
                            <span wire:loading wire:target="save">
                                <i class="fas fa-spinner fa-spin me-2"></i>Salvando...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:navigated', () => {
        const input = document.querySelector('#tags-input');
        if (input && !input.classList.contains('tagify--host')) {
            const tagify = new Tagify(input, {
                originalInputValueFormat: arr => arr.map(v => v.value).join(',')
            });
            tagify.on('change', e => {
                @this.set('tags', e.detail.value);
            });
        }
    });
    // Fallback para carregamento inicial sem wire:navigate
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.querySelector('#tags-input');
        if (input && !input.classList.contains('tagify--host')) {
            const tagify = new Tagify(input, {
                originalInputValueFormat: arr => arr.map(v => v.value).join(',')
            });
            tagify.on('change', e => {
                @this.set('tags', e.detail.value);
            });
        }
    });
</script>
@endpush
