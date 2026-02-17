@extends('layouts.app')

@section('header_title', 'Contatos')
@section('header_actions')
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactModal" onclick="clearForm()">
        <i class="fas fa-plus me-2"></i>Novo Contato
    </button>
@endsection

@section('content')
    <div class="container-fluid p-0">
        <!-- Filtros -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3">
                <form id="searchForm" onsubmit="event.preventDefault(); loadContacts(1);">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" id="search_term" placeholder="Buscar por nome, email ou telefone...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="search_tags" placeholder="Filtrar por tags">
                        </div>
                        <div class="col-md-4 d-flex gap-2 justify-content-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-filter me-2"></i>Filtrar
                            </button>
                            <button type="button" class="btn btn-light border" onclick="clearSearch()">
                                Limpar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabela de contatos -->
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="contacts-table">
                    <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted fw-bold text-uppercase small">Nome</th>
                        <th class="py-3 text-muted fw-bold text-uppercase small">E-mail</th>
                        <th class="py-3 text-muted fw-bold text-uppercase small">Telefone</th>
                        <th class="py-3 text-muted fw-bold text-uppercase small">Tags</th>
                        <th class="pe-4 py-3 text-end text-muted fw-bold text-uppercase small">Ações</th>
                    </tr>
                    </thead>
                    <tbody id="contacts-list"></tbody>
                </table>
            </div>

            <div id="no-contacts" class="text-center py-5 d-none">
                <div class="py-4">
                    <i class="fas fa-address-book fa-3x text-light mb-3"></i>
                    <h5 class="fw-bold">Nenhum contato encontrado</h5>
                    <p class="text-muted">Comece adicionando um novo contato à sua lista.</p>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#contactModal" onclick="clearForm()">
                        Adicionar Contato
                    </button>
                </div>
            </div>

            <div class="card-footer bg-white border-0 py-3" id="pagination-nav"></div>
        </div>
    </div>

    <!-- Modal de Contato -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center bg-primary text-white" style="width: 40px; height: 40px;">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold" id="contactModalLabel">Novo Contato</h5>
                            <p class="small text-muted mb-0">Preencha as informações do contato</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <form id="contactForm">
                        <input type="hidden" id="contact_id">

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Nome Completo</label>
                            <input type="text" class="form-control" id="name" required placeholder="Ex: João Silva">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted text-uppercase">E-mail</label>
                            <input type="email" class="form-control" id="email" placeholder="Ex: joao@email.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Telefone</label>
                            <input type="text" class="form-control" id="phone" required placeholder="(00) 00000-0000">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Tags</label>
                            <input type="text" class="form-control" id="tags" placeholder="Digite e pressione Enter...">
                        </div>
                    </form>
                </div>

                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary px-4" onclick="saveContact()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar-circle {
            width: 38px;
            height: 38px;
            background-color: #e0e7ff;
            color: var(--primary-color);
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }
        .btn-action {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: all 0.2s;
            border: 1px solid var(--border-color);
            background: transparent;
            color: var(--text-muted);
            margin-left: 0.25rem;
        }
        .btn-action:hover {
            background-color: var(--bg-hover);
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-delete:hover {
            color: #ef4444;
            border-color: #ef4444;
            background-color: #fef2f2;
        }
        .badge-tag {
            font-size: 0.7rem;
            padding: 0.2rem 0.6rem;
            border-radius: 4px;
            margin-right: 4px;
            font-weight: 600;
            display: inline-block;
            margin-top: 2px;
        }
    </style>
@endsection

@push('scripts')
    <script>
        let userRole = '{{ Auth::user()->role }}';
        let currentPage = 1;
        let phoneMask, tagifyInput, tagifySearch;

        // Mapa de cores para tags (Jira style)
        const colorMap = {
            primary: { bg: '#DEEBFF', text: '#0747A6', border: '#B3D4FF' },
            dark: { bg: '#EAE6FF', text: '#403294', border: '#C0B6F2' },
            light: { bg: '#E3FCEF', text: '#006644', border: '#ABF5D1' },
            accent: { bg: '#FFF0B3', text: '#172B4D', border: '#FFE380' },
            soft: { bg: '#FFFAE6', text: '#FF8B00', border: '#FFF0B3' },
            danger: { bg: '#FFEBE6', text: '#BF2600', border: '#FFBDAD' }
        };

        function getTagStyle(color) {
            const colors = ['primary', 'dark', 'light', 'accent', 'soft', 'danger'];
            // Se a cor vier do banco (hex), tentamos usar, senão pegamos uma do mapa
            if (color && color.startsWith('#')) {
                return `background: ${color}20; color: ${color}; border: 1px solid ${color}40;`;
            }
            const c = colorMap[color] || colorMap[colors[Math.floor(Math.random() * colors.length)]];
            return `background: ${c.bg}; color: ${c.text}; border: 1px solid ${c.border};`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadContacts();
            initTagify();
            phoneMask = IMask(document.getElementById('phone'), {
                mask: [{ mask: '(00) 0000-0000' }, { mask: '(00) 00000-0000' }]
            });
        });

        async function initTagify() {
            let whitelist = [];
            try {
                const res = await fetch('/web-api/tags');
                whitelist = await res.json();
            } catch (e) {}

            const transformTag = (tagData) => {
                const colors = ['primary', 'dark', 'light', 'accent', 'soft', 'danger'];
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                const style = colorMap[randomColor];
                // Aplica estilo inline para o componente Tagify
                tagData.style = `--tag-bg: ${style.bg}; --tag-text-color: ${style.text}; --tag-hover: ${style.bg}; --tags-border-color: ${style.border};`;
            };

            const config = {
                whitelist,
                transformTag,
                dropdown: { classname: "tags-look", enabled: 0, closeOnSelect: false },
                originalInputValueFormat: arr => arr.map(v => v.value).join(',')
            };

            if (document.getElementById('tags')) {
                if (tagifyInput) tagifyInput.destroy();
                tagifyInput = new Tagify(document.getElementById('tags'), config);
            }
            if (document.getElementById('search_tags')) {
                if (tagifySearch) tagifySearch.destroy();
                tagifySearch = new Tagify(document.getElementById('search_tags'), config);
            }
        }

        async function loadContacts(page = 1) {
            currentPage = page;
            const term = document.getElementById('search_term').value;
            const tags = document.getElementById('search_tags').value;
            let url = `/web-api/contacts?page=${page}`;
            if (term) url += `&search=${encodeURIComponent(term)}`;
            if (tags) url += `&tags=${encodeURIComponent(tags)}`;

            try {
                const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                const data = await res.json();
                renderContacts(data.data);
                renderPagination(data);
            } catch (error) {
                console.error(error);
            }
        }

        function renderContacts(contacts) {
            const tbody = document.getElementById('contacts-list');
            const noContacts = document.getElementById('no-contacts');
            const table = document.getElementById('contacts-table');

            if (!contacts || contacts.length === 0) {
                tbody.innerHTML = '';
                noContacts.classList.remove('d-none');
                table.classList.add('d-none');
                return;
            }

            noContacts.classList.add('d-none');
            table.classList.remove('d-none');

            tbody.innerHTML = contacts.map(c => {
                const tags = c.tags?.map(t => `<span class="badge-tag" style="${getTagStyle(t.color)}">${t.name}</span>`).join('') || '-';
                const deleteBtn = userRole === 'admin' ? `<button class="btn-action btn-delete" onclick="deleteContact(${c.id})" title="Excluir"><i class="fas fa-trash"></i></button>` : '';

                return `
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle me-3">${c.name.charAt(0).toUpperCase()}</div>
                            <span class="fw-bold">${c.name}</span>
                        </div>
                    </td>
                    <td>${c.email || '-'}</td>
                    <td><span class="badge bg-light text-dark border fw-normal">${c.phone}</span></td>
                    <td>${tags}</td>
                    <td class="pe-4 text-end">
                        <button class="btn-action" onclick="editContact(${c.id})" title="Editar"><i class="fas fa-edit"></i></button>
                        ${deleteBtn}
                    </td>
                </tr>
            `;
            }).join('');
        }

        function renderPagination(data) {
            const nav = document.getElementById('pagination-nav');
            if (data.last_page <= 1) { nav.innerHTML = ''; return; }

            let html = '<ul class="pagination justify-content-center mb-0">';
            html += `<li class="page-item ${data.current_page === 1 ? 'disabled' : ''}"><a class="page-link" href="#" onclick="loadContacts(${data.current_page-1})">Anterior</a></li>`;

            for (let i = 1; i <= data.last_page; i++) {
                if (i === 1 || i === data.last_page || (i >= data.current_page-2 && i <= data.current_page+2)) {
                    html += `<li class="page-item ${i === data.current_page ? 'active' : ''}"><a class="page-link" href="#" onclick="loadContacts(${i})">${i}</a></li>`;
                } else if (i === data.current_page-3 || i === data.current_page+3) {
                    html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }

            html += `<li class="page-item ${data.current_page === data.last_page ? 'disabled' : ''}"><a class="page-link" href="#" onclick="loadContacts(${data.current_page+1})">Próximo</a></li>`;
            html += '</ul>';
            nav.innerHTML = html;
        }

        function clearSearch() {
            document.getElementById('search_term').value = '';
            if (tagifySearch) tagifySearch.removeAllTags();
            loadContacts(1);
        }

        function clearForm() {
            document.getElementById('contact_id').value = '';
            document.getElementById('contactForm').reset();
            phoneMask.value = '';
            if (tagifyInput) tagifyInput.removeAllTags();
            document.getElementById('contactModalLabel').innerText = 'Novo Contato';
        }

        async function editContact(id) {
            try {
                const res = await fetch(`/web-api/contacts/${id}`, { headers: { 'Accept': 'application/json' } });
                const json = await res.json();
                const c = json.data;

                document.getElementById('contact_id').value = c.id;
                document.getElementById('name').value = c.name;
                document.getElementById('email').value = c.email || '';
                phoneMask.value = c.phone;

                if (tagifyInput) {
                    tagifyInput.removeAllTags();
                    if (c.tags?.length) {
                        tagifyInput.addTags(c.tags.map(t => ({
                            value: t.name,
                            color: t.color,
                            style: getTagStyle(t.color).replace('background:', '--tag-bg:').replace('color:', '--tag-text-color:')
                        })));
                    }
                }

                document.getElementById('contactModalLabel').innerText = 'Editar Contato';
                new bootstrap.Modal(document.getElementById('contactModal')).show();
            } catch (e) {
                Swal.fire('Erro!', 'Não foi possível carregar os dados.', 'error');
            }
        }

        async function saveContact() {
            const id = document.getElementById('contact_id').value;
            const data = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: phoneMask.value,
                tags: document.getElementById('tags').value
            };

            const url = id ? `/web-api/contacts/${id}` : '/web-api/contacts';
            const method = id ? 'PUT' : 'POST';

            try {
                const res = await fetch(url, {
                    method,
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(data)
                });

                if (res.ok) {
                    // Fecha o modal e remove backdrop manualmente se necessário
                    const modalEl = document.getElementById('contactModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();

                    // Força a remoção de possíveis backdrops residuais e restaura o scroll
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';

                    loadContacts(currentPage);
                    initTagify(); // Atualiza whitelist

                    Swal.fire({
                        icon: 'success',
                        title: id ? 'Contato atualizado!' : 'Contato criado!',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    const err = await res.json();
                    Swal.fire('Erro!', err.message || 'Verifique os dados.', 'error');
                }
            } catch (e) {
                Swal.fire('Erro!', 'Ocorreu um problema ao salvar.', 'error');
            }
        }

        async function deleteContact(id) {
            const confirm = await Swal.fire({
                title: 'Excluir contato?',
                text: 'Esta ação não pode ser desfeita.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Cancelar'
            });

            if (confirm.isConfirmed) {
                const res = await fetch(`/web-api/contacts/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });

                if (res.ok) {
                    loadContacts(currentPage);
                    Swal.fire({
                        icon: 'success',
                        title: 'Excluído!',
                        text: 'Contato removido.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    Swal.fire('Erro!', 'Não foi possível excluir.', 'error');
                }
            }
        }
    </script>
@endpush
