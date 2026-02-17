@extends('layouts.app')

@section('header_title', 'Livros')
@section('header_actions')
    <a href="{{ route('books.create') }}" class="btn btn-primary-modern btn-modern">
        <i class="fas fa-plus me-2"></i>Novo Livro
    </a>
@endsection

@push('styles')
    <style>
        .book-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            transition: transform 0.25s ease, box-shadow 0.3s ease;
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0.02);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .book-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 24px -8px rgba(30, 74, 122, 0.15);
            border-color: rgba(30, 74, 122, 0.1);
        }

        .book-cover-wrapper {
            position: relative;
            width: 100%;
            aspect-ratio: 2 / 3; /* proporção padrão de livro */
            background-color: #fafafa;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #f0f0f0;
            padding: 12px;
        }

        .book-cover-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .book-card:hover .book-cover-img {
            transform: scale(1.02);
        }

        .book-info-wrapper {
            padding: 1rem 1rem 1.2rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .book-title {
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.3;
            color: #1e2b3c;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 0.2rem;
        }

        .book-author {
            font-size: 0.85rem;
            color: #5e6f88;
            font-weight: 400;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 0.4rem;
        }

        .book-meta {
            font-size: 0.75rem;
            color: #7a8ba3;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .book-meta-item {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .book-meta-item i {
            font-size: 0.7rem;
            color: #9aaec2;
        }

        .book-tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            margin-top: auto;
            padding-top: 0.5rem;
        }

        .book-actions-dropdown {
            position: absolute;
            top: 8px;
            right: 8px;
            z-index: 10;
        }

        .btn-action-trigger {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(2px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2c3e50;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: all 0.2s;
        }

        .btn-action-trigger:hover {
            background: white;
            color: #1e4a7a;
            transform: scale(1.1);
            box-shadow: 0 4px 10px rgba(30, 74, 122, 0.2);
        }

        .badge-isbn {
            background: #eef2f6;
            color: #2b4b6f;
            font-size: 0.65rem;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 500;
        }

        .badge-tag {
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 20px;
            font-weight: 500;
            transition: opacity 0.2s;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid p-0">
        <!-- Filtros -->
        <div class="card-modern p-3 mb-4">
            <form id="searchForm" onsubmit="event.preventDefault(); loadBooks(1);">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" class="form-control bg-light border-start-0" id="search_term" placeholder="Buscar por título, autor ou ISBN...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-tags text-muted"></i></span>
                            <input type="text" class="form-control bg-light border-start-0" id="search_tags" placeholder="Filtrar por tags">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary-modern btn-modern">
                            <i class="fas fa-filter me-2"></i>Filtrar
                        </button>
                        <button type="button" class="btn btn-outline-modern btn-modern" onclick="clearSearch()">
                            Limpar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Estatísticas -->
        @if(isset($stats) && count($stats))
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card-modern p-3">
                        <div class="d-flex flex-wrap gap-3 align-items-center">
                            @foreach($stats as $stat)
                                <span class="badge-tag" style="background-color: rgba(30,74,122,0.1); color: var(--primary, #1E4A7A);">
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

        <!-- Lista de Livros (inicialmente vazia, carregada via AJAX) -->
        <div class="row" id="books-list"></div>

        <div id="no-books" class="text-center py-5 d-none">
            <i class="fas fa-book fa-3x text-light mb-3"></i>
            <h5>Nenhum livro encontrado</h5>
            <p class="text-muted">Adicione um novo livro à sua coleção.</p>
            <a href="{{ route('books.create') }}" class="btn btn-primary-modern btn-modern">
                Adicionar Livro
            </a>
        </div>

        <div class="mt-4" id="books-pagination-nav"></div>
    </div>

    <!-- Modal de Livro (opcional, mas usaremos páginas separadas, então não precisamos de modal aqui) -->
@endsection

@push('scripts')
    <script>
        let tagifySearch;
        let currentBooksPage = 1;

        document.addEventListener('DOMContentLoaded', () => {
            initTagifySearch();
            loadBooks(1);
        });

        async function initTagifySearch() {
            const searchInput = document.getElementById('search_tags');
            if (!searchInput) return;

            let whitelist = [];
            try {
                const res = await fetch('/web-api/tags');
                whitelist = await res.json();
            } catch (e) {}

            const transformTag = (tagData) => {
                const colors = ['primary', 'dark', 'light', 'accent', 'soft', 'danger'];
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                const style = colorMap[randomColor];
                tagData.style = `--tag-bg: ${style.bg}; --tag-text-color: ${style.text}; --tag-hover: ${style.bg}; border: 1px solid ${style.border};`;
            };

            tagifySearch = new Tagify(searchInput, {
                whitelist: whitelist,
                transformTag,
                dropdown: {
                    classname: "tags-look",
                    enabled: 0,
                    closeOnSelect: false
                },
                originalInputValueFormat: arr => arr.map(v => v.value).join(',')
            });
        }

        async function loadBooks(page = 1) {
            currentBooksPage = page;
            const searchTerm = document.getElementById('search_term').value;
            const searchTags = document.getElementById('search_tags').value;

            let url = `/web-api/books?page=${page}&search=${encodeURIComponent(searchTerm)}`;
            if (searchTags) {
                // Com a correção do originalInputValueFormat, searchTags já é uma string separada por vírgulas
                url += `&tags=${encodeURIComponent(searchTags)}`;
            }

            const res = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const json = await res.json();

            renderBooksList(json.data);
            renderBooksPagination(json.meta);
        }

        function renderBooksList(books) {
            const list = document.getElementById('books-list');
            const empty = document.getElementById('no-books');

            if (books.length === 0) {
                list.innerHTML = '';
                empty.classList.remove('d-none');
                return;
            }

            empty.classList.add('d-none');
            list.innerHTML = books.map(book => {
                const tagsHtml = book.tags.map(tag =>
                    `<span class="badge-tag" style="${getTagStyle(tag.color)}">${escapeHtml(tag.name)}</span>`
                ).join('');

                const coverUrl = book.cover_image_url ?? 'https://via.placeholder.com/300x450?text=Sem+Capa';

                const publisherYear = [];
                if (book.publisher) publisherYear.push(`<span class="book-meta-item"><i class="fas fa-building"></i> ${escapeHtml(book.publisher)}</span>`);
                if (book.published_year) publisherYear.push(`<span class="book-meta-item"><i class="fas fa-calendar-alt"></i> ${escapeHtml(book.published_year)}</span>`);

                const isbnHtml = book.isbn ? `<span class="badge-isbn">ISBN: ${escapeHtml(book.isbn)}</span>` : '';

                return `
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-4">
            <div class="book-card">
                <div class="book-actions-dropdown">
                    <div class="dropdown">
                        <button class="btn-action-trigger" data-bs-toggle="dropdown" aria-label="Ações">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" style="border-radius: 12px; padding: 0.5rem;">
                            <li><a class="dropdown-item py-2" href="/books/${book.id}/edit"><i class="fas fa-edit me-2 text-primary"></i>Editar</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger" href="#" onclick="deleteBook('${book.id}')"><i class="fas fa-trash-alt me-2"></i>Excluir</a></li>
                        </ul>
                    </div>
                </div>
                <div class="book-cover-wrapper" onclick="window.location.href='/books/${book.id}'">
                    <img src="${coverUrl}" class="book-cover-img" alt="${escapeHtml(book.title)}" loading="lazy">
                </div>
                <div class="book-info-wrapper" onclick="window.location.href='/books/${book.id}'">
                    <h6 class="book-title" title="${escapeHtml(book.title)}">${escapeHtml(book.title)}</h6>
                    <p class="book-author" title="${escapeHtml(book.author)}">${escapeHtml(book.author)}</p>
                    <div class="book-meta">${publisherYear.join('')}</div>
                    <div class="book-tags-container">
                        ${isbnHtml}
                        ${tagsHtml}
                    </div>
                </div>
            </div>
        </div>
        `;
            }).join('');

            // Reinicializa dropdowns
            setTimeout(() => {
                document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(el => new bootstrap.Dropdown(el));
            }, 0);
        }

        const colorMap = {
            primary: { bg: '#DEEBFF', text: '#0747A6', border: '#B3D4FF' },
            dark: { bg: '#EAE6FF', text: '#403294', border: '#C0B6F2' },
            light: { bg: '#E3FCEF', text: '#006644', border: '#ABF5D1' },
            accent: { bg: '#FFF0B3', text: '#172B4D', border: '#FFE380' },
            soft: { bg: '#FFFAE6', text: '#FF8B00', border: '#FFF0B3' },
            danger: { bg: '#FFEBE6', text: '#BF2600', border: '#FFBDAD' },
            blue: { bg: '#DEEBFF', text: '#0747A6', border: '#B3D4FF' },
            green: { bg: '#E3FCEF', text: '#006644', border: '#ABF5D1' },
            yellow: { bg: '#FFFAE6', text: '#FF8B00', border: '#FFF0B3' },
            red: { bg: '#FFEBE6', text: '#BF2600', border: '#FFBDAD' },
            purple: { bg: '#EAE6FF', text: '#403294', border: '#C0B6F2' },
            teal: { bg: '#E6FFFA', text: '#055160', border: '#B2F5EA' },
            gray: { bg: '#F4F5F7', text: '#42526E', border: '#DFE1E6' }
        };
        function hexToRgb(hex) {
            if (!hex) return '0,0,0';
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            return `${r}, ${g}, ${b}`;
        }
        function getTagStyle(color) {
            if (color && color.startsWith && color.startsWith('#')) {
                return `background-color: rgba(${hexToRgb(color)}, 0.1); color: ${color}; border: 1px solid rgba(${hexToRgb(color)}, 0.2);`;
            }
            const c = colorMap[color] || colorMap['primary'];
            return `background: ${c.bg}; color: ${c.text}; border: 1px solid ${c.border};`;
        }

        function renderBooksPagination(meta) {
            const nav = document.getElementById('books-pagination-nav');
            if (meta.last_page <= 1) { nav.innerHTML = ''; return; }
            let html = '<ul class="pagination justify-content-center">';
            html += `<li class="page-item ${meta.current_page === 1 ? 'disabled' : ''}"><a class="page-link" href="#" onclick="loadBooks(${meta.current_page-1})">Anterior</a></li>`;
            for (let i = 1; i <= meta.last_page; i++) {
                if (i === 1 || i === meta.last_page || (i >= meta.current_page-2 && i <= meta.current_page+2)) {
                    html += `<li class="page-item ${i === meta.current_page ? 'active' : ''}"><a class="page-link" href="#" onclick="loadBooks(${i})">${i}</a></li>`;
                } else if (i === meta.current_page-3 || i === meta.current_page+3) {
                    html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }
            html += `<li class="page-item ${meta.current_page === meta.last_page ? 'disabled' : ''}"><a class="page-link" href="#" onclick="loadBooks(${meta.current_page+1})">Próximo</a></li>`;
            html += '</ul>';
            nav.innerHTML = html;
        }

        function clearSearch() {
            document.getElementById('search_term').value = '';
            if (tagifySearch) tagifySearch.removeAllTags();
            loadBooks(1);
        }

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
                const res = await fetch(`/web-api/books/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                });
                if (res.ok) {
                    loadBooks(currentBooksPage);
                    Swal.fire('Excluído!', 'Livro removido.', 'success');
                } else {
                    Swal.fire('Erro!', 'Não foi possível excluir.', 'error');
                }
            }
        }

        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
@endpush
