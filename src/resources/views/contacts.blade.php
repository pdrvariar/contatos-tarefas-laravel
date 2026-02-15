@extends('layouts.app')

@section('header_title', 'Contatos')

@section('header_actions')
<button class="btn btn-primary shadow-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#contactModal" onclick="clearForm()">
    <i class="fas fa-plus me-2"></i>
    <span class="d-none d-sm-inline">Novo Contato</span>
</button>
@endsection

@section('content')
<div class="container-fluid p-0">
    <!-- Barra de Pesquisa Avançada -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form id="searchForm" onsubmit="event.preventDefault(); loadContacts(1);">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="search_term" placeholder="Buscar por nome, email ou telefone...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="search_tags" placeholder="Filtrar por tags">
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-filter me-2"></i>Filtrar
                        </button>
                        <button type="button" class="btn btn-light border ms-2" onclick="clearSearch()">
                            Limpar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0" id="contacts-card-body">
            <div class="table-responsive" id="contacts-table-container">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-bold text-uppercase small">Nome</th>
                            <th class="py-3 text-muted fw-bold text-uppercase small">E-mail</th>
                            <th class="py-3 text-muted fw-bold text-uppercase small">Telefone</th>
                            <th class="py-3 text-muted fw-bold text-uppercase small">Tags</th>
                            <th class="pe-4 py-3 text-end text-muted fw-bold text-uppercase small">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="contacts-list">
                        <!-- Preenchido via JS -->
                    </tbody>
                </table>
            </div>

            <div id="no-contacts" class="text-center py-5 d-none">
                <div class="py-5">
                    <i class="fas fa-address-book fa-4x text-light mb-4"></i>
                    <h5 class="fw-bold">Nenhum contato encontrado</h5>
                    <p class="text-muted">Sua agenda está vazia no momento ou nenhum resultado para a busca.</p>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#contactModal" onclick="clearForm()">
                        Adicionar Contato
                    </button>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            <nav id="pagination-nav"></nav>
        </div>
    </div>
</div>

<!-- Modal para criar/editar contato -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="contactModalLabel">Novo Contato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="contactForm">
                    <input type="hidden" id="contact_id">
                    <div class="mb-3">
                        <label for="name" class="form-label text-muted fw-semibold small">Nome Completo</label>
                        <div class="input-group shadow-none border rounded-3">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-user text-muted"></i></span>
                            <input type="text" class="form-control border-0 ps-0 bg-transparent" id="name" placeholder="Ex: João Silva" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label text-muted fw-semibold small">E-mail</label>
                        <div class="input-group shadow-none border rounded-3">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" class="form-control border-0 ps-0 bg-transparent" id="email" placeholder="Ex: joao@email.com">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label text-muted fw-semibold small">Telefone / WhatsApp</label>
                        <div class="input-group shadow-none border rounded-3">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-phone text-muted"></i></span>
                            <input type="text" class="form-control border-0 ps-0 bg-transparent" id="phone" placeholder="(00) 00000-0000" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tags" class="form-label text-muted fw-semibold small">Tags</label>
                        <input type="text" class="form-control" id="tags" placeholder="Digite e pressione Enter...">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-light px-4 border shadow-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary px-4 shadow-sm" onclick="saveContact()">
                    <i class="fas fa-save me-2"></i>Salvar Contato
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .table thead th {
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-size: 0.75rem;
    }
    .table tbody td {
        padding-top: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }
    @media (max-width: 768px) {
        .avatar-circle { width: 30px; height: 30px; font-size: 0.8rem; }
        .table tbody td { padding-top: 0.5rem; padding-bottom: 0.5rem; font-size: 0.85rem; }
    }
    .avatar-circle {
        width: 38px;
        height: 38px;
        background-color: #e0e7ff;
        color: #4f46e5;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }
    .btn-action {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
        border: none;
        margin-left: 0.25rem;
    }
    .btn-edit { color: #0891b2; background-color: #ecfeff; }
    .btn-edit:hover { background-color: #0891b2; color: white; }
    .btn-delete { color: #e11d48; background-color: #fff1f2; }
    .btn-delete:hover { background-color: #e11d48; color: white; }
    .tag-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 3px;
        margin-right: 0.25rem;
        display: inline-block;
    }

    /* Tagify JIRA-like Customization */
    .tagify {
        --tags-border-color: #dfe1e6;
        --tags-hover-border-color: #4c9aff;
        --tags-focus-border-color: #4c9aff;
        --tag-bg: #f4f5f7;
        --tag-text-color: #42526e;
        --tag-remove-btn-bg--hover: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .tagify__tag {
        margin: 3px;
        border-radius: 3px;
    }

    .tagify__tag > div {
        border-radius: 3px;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.2rem 0.5rem;
    }

    .tagify__tag__removeBtn {
        margin-right: 3px;
        margin-left: 2px;
    }

    .tagify__dropdown.tags-look .tagify__dropdown__item {
        display: inline-block;
        border-radius: 3px;
        padding: 0.3em 0.5em;
        border: 1px solid #dfe1e6;
        background: #fff;
        margin: 0.2em;
        font-size: 0.85rem;
        transition: 0s;
    }

    .tagify__dropdown.tags-look .tagify__dropdown__item--active {
        background: #4c9aff;
        color: #fff;
    }

    .tagify__dropdown.tags-look .tagify__dropdown__item:hover {
        background: #deebff;
        color: #0747a6;
    }
</style>
@endsection

@push('scripts')
<script>
    let userRole = '{{ Auth::user()->role }}';
    let currentPage = 1;
    let phoneMask;
    let tagifyInput, tagifySearch;

    const colorMap = {
        blue: { bg: '#deebff', text: '#0747a6' },
        green: { bg: '#e3fcef', text: '#006644' },
        yellow: { bg: '#fffae6', text: '#826a00' },
        red: { bg: '#ffebe6', text: '#bf2600' },
        purple: { bg: '#eae6ff', text: '#403294' },
        teal: { bg: '#e6fcff', text: '#008da6' },
        gray: { bg: '#f4f5f7', text: '#42526e' }
    };

    function getTagStyle(tagColor) {
        const color = colorMap[tagColor] || colorMap.gray;
        return `--tag-bg: ${color.bg}; --tag-text-color: ${color.text}; --tag-remove-btn-color: ${color.text}`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadContacts();
        initTagify();

        const phoneInput = document.getElementById('phone');
        phoneMask = IMask(phoneInput, {
            mask: [
                { mask: '(00) 0000-0000' },
                { mask: '(00) 00000-0000' }
            ]
        });
    });

    async function initTagify() {
        let whitelist = [];
        try {
            const response = await fetch('/web-api/tags', {
                headers: { 'Accept': 'application/json' }
            });
            whitelist = await response.json();
        } catch (e) {}

        setupTagifyInstances(whitelist);
    }

    function setupTagifyInstances(whitelist) {
        // Função para transformar tags em objetos coloridos estilo JIRA
        function transformTag(tagData) {
            const colorKeys = Object.keys(colorMap);
            const existingTag = whitelist.find(t => t.value.toLowerCase() === tagData.value.toLowerCase());

            let tagColor;
            if (existingTag && existingTag.color && colorMap[existingTag.color]) {
                tagColor = existingTag.color;
            } else {
                // Se não tiver cor definida ou for nova, atribui uma baseada no hash do nome
                let hash = 0;
                for (let i = 0; i < tagData.value.length; i++) {
                    hash = tagData.value.charCodeAt(i) + ((hash << 5) - hash);
                }
                tagColor = colorKeys[Math.abs(hash) % colorKeys.length];
            }

            tagData.style = getTagStyle(tagColor);
        }

        const config = {
            whitelist: whitelist,
            transformTag: transformTag,
            dropdown: {
                maxItems: 20,
                classname: "tags-look",
                enabled: 0,
                closeOnSelect: false,
                highlightFirst: true
            },
            originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
        };

        // Tagify no Modal
        const input = document.getElementById('tags');
        if (input) {
            // Destruir instância anterior se existir para evitar duplicação
            if (tagifyInput) tagifyInput.destroy();
            tagifyInput = new Tagify(input, config);
        }

        // Tagify na Pesquisa
        const searchInput = document.getElementById('search_tags');
        if (searchInput) {
            if (tagifySearch) tagifySearch.destroy();
            tagifySearch = new Tagify(searchInput, config);
        }
    }

    async function loadContacts(page = 1) {
        currentPage = page;
        const searchTerm = document.getElementById('search_term').value;

        let searchTags = document.getElementById('search_tags').value;

        let url = '/web-api/contacts?page=' + page;
        if (searchTerm) url += '&search=' + encodeURIComponent(searchTerm);
        if (searchTags) url += '&tags=' + encodeURIComponent(searchTags);

        try {
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const data = await response.json();
            renderContacts(data.data);
            renderPagination(data);
        } catch (error) {
            console.error('Erro ao carregar contatos:', error);
        }
    }

    function clearSearch() {
        document.getElementById('search_term').value = '';
        if (tagifySearch) tagifySearch.removeAllTags();
        loadContacts(1);
    }

    function renderContacts(contacts) {
        const list = document.getElementById('contacts-list');
        const noContacts = document.getElementById('no-contacts');
        const tableContainer = document.getElementById('contacts-table-container');
        list.innerHTML = '';

        if (!contacts || contacts.length === 0) {
            noContacts.classList.remove('d-none');
            tableContainer.classList.add('d-none');
            return;
        }

        noContacts.classList.add('d-none');
        tableContainer.classList.remove('d-none');
        contacts.forEach(contact => {
            const tr = document.createElement('tr');
            let deleteBtn = '';
            if (userRole === 'admin') {
                deleteBtn = `
                    <button class="btn-action btn-delete" onclick="deleteContact(${contact.id})" title="Excluir">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
            }

            let tagsHtml = '';
            if (contact.tags && contact.tags.length > 0) {
                contact.tags.forEach(tag => {
                    const color = colorMap[tag.color] || colorMap.gray;
                    tagsHtml += `<span class="tag-badge" style="background-color: ${color.bg}; color: ${color.text}">${tag.name}</span>`;
                });
            } else {
                tagsHtml = '<span class="text-muted small">-</span>';
            }

            tr.innerHTML = `
                <td class="ps-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar-circle me-3">
                            ${contact.name.charAt(0).toUpperCase()}
                        </div>
                        <span class="fw-bold text-dark">${contact.name}</span>
                    </div>
                </td>
                <td><span class="text-muted">${contact.email || '-'}</span></td>
                <td><span class="badge bg-light text-secondary border fw-normal">${contact.phone}</span></td>
                <td>${tagsHtml}</td>
                <td class="pe-4 text-end">
                    <button class="btn-action btn-edit" onclick="editContact(${contact.id})" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    ${deleteBtn}
                </td>
            `;
            list.appendChild(tr);
        });
    }

    function renderPagination(data) {
        const nav = document.getElementById('pagination-nav');
        if (data.last_page <= 1) {
            nav.innerHTML = '';
            return;
        }

        let html = '<ul class="pagination">';
        html += '<li class="page-item ' + (data.current_page === 1 ? 'disabled' : '') + '">';
        html += '<a class="page-link" href="#" onclick="loadContacts(' + (data.current_page - 1) + ')">Anterior</a>';
        html += '</li>';

        for (let i = 1; i <= data.last_page; i++) {
            if (i === 1 || i === data.last_page || (i >= data.current_page - 2 && i <= data.current_page + 2)) {
                html += '<li class="page-item ' + (i === data.current_page ? 'active' : '') + '">';
                html += '<a class="page-link" href="#" onclick="loadContacts(' + i + ')">' + i + '</a>';
                html += '</li>';
            } else if (i === data.current_page - 3 || i === data.current_page + 3) {
                html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        html += '<li class="page-item ' + (data.current_page === data.last_page ? 'disabled' : '') + '">';
        html += '<a class="page-link" href="#" onclick="loadContacts(' + (data.current_page + 1) + ')">Próximo</a>';
        html += '</li>';

        html += '</ul>';
        nav.innerHTML = html;
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
            const response = await fetch('/web-api/contacts/' + id, {
                headers: { 'Accept': 'application/json' }
            });
            const jsonResponse = await response.json();
            const contact = jsonResponse.data;

            document.getElementById('contact_id').value = contact.id;
            document.getElementById('name').value = contact.name;
            document.getElementById('email').value = contact.email || '';
            phoneMask.value = contact.phone;

            // Preencher tags no Tagify
            if (tagifyInput) {
                tagifyInput.removeAllTags();
                if (contact.tags && contact.tags.length > 0) {
                    const tagsData = contact.tags.map(t => ({
                        value: t.name,
                        color: t.color,
                        style: getTagStyle(t.color)
                    }));
                    tagifyInput.addTags(tagsData);
                }
            }

            document.getElementById('contactModalLabel').innerText = 'Editar Contato';
            const modal = new bootstrap.Modal(document.getElementById('contactModal'));
            modal.show();
        } catch (error) {
            console.error(error);
            Swal.fire('Erro!', 'Não foi possível carregar os dados.', 'error');
        }
    }

    async function saveContact() {
        const id = document.getElementById('contact_id').value;

        // Obter tags do Tagify
        let tagsValue = document.getElementById('tags').value;

        const data = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            phone: phoneMask.value,
            tags: tagsValue
        };

        const url = id ? '/web-api/contacts/' + id : '/web-api/contacts';
        const method = id ? 'PUT' : 'POST';

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                const modalElement = document.getElementById('contactModal');
                const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modal.hide();
                loadContacts(currentPage);
                initTagify(); // Recarregar whitelist
                Swal.fire({
                    icon: 'success',
                    title: id ? 'Contato atualizado!' : 'Contato criado!',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true,
                    position: 'top-end'
                });
            } else {
                const errData = await response.json();
                Swal.fire('Erro!', errData.message || 'Verifique os dados.', 'error');
            }
        } catch (error) {
            Swal.fire('Erro!', 'Ocorreu um problema ao salvar.', 'error');
        }
    }

    async function deleteContact(id) {
        const result = await Swal.fire({
            title: 'Tem certeza?',
            text: "Esta ação não pode ser revertida!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch('/web-api/contacts/' + id, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (response.ok) {
                    loadContacts(currentPage);
                    Swal.fire('Excluído!', 'O contato foi removido.', 'success');
                } else {
                    const errData = await response.json();
                    Swal.fire('Erro!', errData.message || 'Erro ao excluir.', 'error');
                }
            } catch (error) {
                Swal.fire('Erro!', 'Não foi possível excluir o contato.', 'error');
            }
        }
    }
</script>
@endpush
