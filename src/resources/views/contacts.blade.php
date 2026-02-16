@extends('layouts.app')

@section('header_title', 'Contatos')
@section('header_actions')
    <button class="btn btn-primary-modern btn-modern" data-bs-toggle="modal" data-bs-target="#contactModal" onclick="clearForm()">
        <i class="fas fa-plus me-2"></i>Novo Contato
    </button>
@endsection

@section('content')
    <div class="container-fluid p-0">
        <!-- Filtros -->
        <div class="card-modern p-3 mb-4">
            <form id="searchForm" onsubmit="event.preventDefault(); loadContacts(1);">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control bg-light" id="search_term" placeholder="Buscar por nome, email ou telefone...">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control bg-light" id="search_tags" placeholder="Filtrar por tags">
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

        <!-- Tabela de contatos -->
        <div class="card-modern p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table-modern" id="contacts-table">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Tags</th>
                        <th class="text-end">Ações</th>
                    </tr>
                    </thead>
                    <tbody id="contacts-list"></tbody>
                </table>
            </div>

            <div id="no-contacts" class="text-center py-5 d-none">
                <i class="fas fa-address-book fa-3x text-light mb-3"></i>
                <h5>Nenhum contato encontrado</h5>
                <p class="text-muted">Comece adicionando um novo contato.</p>
                <button class="btn btn-primary-modern btn-modern" data-bs-toggle="modal" data-bs-target="#contactModal" onclick="clearForm()">
                    Adicionar Contato
                </button>
            </div>

            <div class="p-3 border-top" id="pagination-nav"></div>
        </div>
    </div>

    <!-- Modal de Contato (refinado) -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true" style="--bs-modal-width: 500px;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 12px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
                <!-- Cabeçalho sóbrio -->
                <div class="modal-header border-0 bg-light p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: var(--primary); color: white;">
                            <i class="fas fa-address-book fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold" id="contactModalLabel" style="color: var(--text-primary); font-size: 1.25rem;">Novo Contato</h5>
                            <p class="small text-muted mb-0">Preencha os dados abaixo</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <form id="contactForm">
                        <input type="hidden" id="contact_id">

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-uppercase text-muted">Nome completo</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" class="form-control bg-white border-start-0" id="name" required placeholder="Ex.: João Silva" style="border-color: var(--border-color); padding: 0.6rem 0.75rem;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-uppercase text-muted">E-mail</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" class="form-control bg-white border-start-0" id="email" placeholder="Ex.: joao@email.com" style="border-color: var(--border-color); padding: 0.6rem 0.75rem;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-uppercase text-muted">Telefone</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);"><i class="fas fa-phone-alt text-muted"></i></span>
                                <input type="text" class="form-control bg-white border-start-0" id="phone" required placeholder="(11) 99999-9999" style="border-color: var(--border-color); padding: 0.6rem 0.75rem;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-uppercase text-muted">Tags</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);"><i class="fas fa-tags text-muted"></i></span>
                                <input type="text" class="form-control bg-white border-start-0" id="tags" placeholder="Digite e pressione Enter..." style="border-color: var(--border-color); padding: 0.6rem 0.75rem;">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-outline-modern btn-modern" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary-modern btn-modern" onclick="saveContact()">Salvar</button>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>

    <style>
        .avatar-circle {
            width: 40px;
            height: 40px;
            background: #e0e7ff;
            color: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            border: 1px solid var(--border-color);
            background: white;
            color: var(--text-secondary);
            margin-left: 0.25rem;
        }
        .btn-edit:hover {
            color: var(--primary);
            border-color: var(--primary);
            background: #f1f5f9;
        }
        .btn-delete:hover {
            color: #ef4444;
            border-color: #ef4444;
            background: #fef2f2;
        }

        /* Inputs com foco mais elegante */
        .form-control:focus, .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.1) !important;
        }

        /* Ajuste no input-group-text para combinar */
        .input-group-text {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            transition: all 0.2s;
        }
        .input-group:focus-within .input-group-text {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Badges de tags no modal (se aparecerem) */
        .tagify__tag {
            border-radius: 30px !important;
            font-size: 0.85rem !important;
        }
    </style>
@endsection

@push('scripts')
    <script>
        let userRole = '{{ Auth::user()->role }}';
        let currentPage = 1;
        let phoneMask, tagifyInput, tagifySearch;

        const colorMap = {
            blue: { bg: '#dbeafe', text: '#1e40af' },
            slate: { bg: '#f1f5f9', text: '#334155' },
            emerald: { bg: '#d1fae5', text: '#065f46' },
            amber: { bg: '#fef3c7', text: '#92400e' },
            rose: { bg: '#ffe4e6', text: '#9f1239' }
        };

        function getTagStyle(color) {
            const c = colorMap[color] || colorMap.slate;
            return `background: ${c.bg}; color: ${c.text}; border: 1px solid rgba(0,0,0,0.05);`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadContacts();
            initTagify();
            phoneMask = IMask(document.getElementById('phone'), { mask: [{ mask: '(00) 0000-0000' }, { mask: '(00) 00000-0000' }] });
        });

        async function initTagify() {
            let whitelist = [];
            try {
                const res = await fetch('/web-api/tags');
                whitelist = await res.json();
            } catch (e) {}

            const transformTag = (tagData) => {
                const colors = ['blue', 'slate', 'emerald', 'amber', 'rose'];
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                tagData.style = getTagStyle(randomColor);
            };

            const config = {
                whitelist,
                transformTag,
                dropdown: { classname: "tags-look", enabled: 0 },
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

            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            renderContacts(data.data);
            renderPagination(data);
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
                const deleteBtn = userRole === 'admin' ? `<button class="btn-icon btn-delete" onclick="deleteContact(${c.id})"><i class="fas fa-trash"></i></button>` : '';
                return `
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle me-2">${c.name.charAt(0).toUpperCase()}</div>
                            <span class="fw-semibold">${c.name}</span>
                        </div>
                    </td>
                    <td>${c.email || '-'}</td>
                    <td><span class="badge bg-light text-dark">${c.phone}</span></td>
                    <td>${tags}</td>
                    <td class="text-end">
                        <button class="btn-icon btn-edit" onclick="editContact(${c.id})"><i class="fas fa-edit"></i></button>
                        ${deleteBtn}
                    </td>
                </tr>
            `;
            }).join('');
        }

        function renderPagination(data) {
            const nav = document.getElementById('pagination-nav');
            if (data.last_page <= 1) { nav.innerHTML = ''; return; }
            let html = '<ul class="pagination justify-content-center">';
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
                    tagifyInput.addTags(c.tags.map(t => ({ value: t.name, color: t.color, style: getTagStyle(t.color) })));
                }
            }
            document.getElementById('contactModalLabel').innerText = 'Editar Contato';
            new bootstrap.Modal(document.getElementById('contactModal')).show();
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
            const res = await fetch(url, {
                method,
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify(data)
            });
            if (res.ok) {
                bootstrap.Modal.getInstance(document.getElementById('contactModal')).hide();
                loadContacts(currentPage);
                initTagify();
                Swal.fire({ icon: 'success', title: id ? 'Contato atualizado!' : 'Contato criado!', toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
            } else {
                const err = await res.json();
                Swal.fire('Erro!', err.message || 'Verifique os dados.', 'error');
            }
        }

        async function deleteContact(id) {
            const confirm = await Swal.fire({ title: 'Excluir contato?', text: 'Esta ação não pode ser desfeita.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#6b7280', confirmButtonText: 'Sim, excluir' });
            if (confirm.isConfirmed) {
                const res = await fetch(`/web-api/contacts/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                if (res.ok) {
                    loadContacts(currentPage);
                    Swal.fire('Excluído!', 'Contato removido.', 'success');
                } else {
                    Swal.fire('Erro!', 'Não foi possível excluir.', 'error');
                }
            }
        }
    </script>
@endpush
