@extends('layouts.app')

@section('header_title', 'Tarefas')

@section('header_actions')
<button class="btn btn-primary shadow-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#taskModal" onclick="clearTaskForm()">
    <i class="fas fa-plus me-2"></i>
    <span class="d-none d-sm-inline">Nova Tarefa</span>
</button>
@endsection

@section('content')
<div class="container-fluid p-0">
    <!-- Barra de Pesquisa Avançada -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form id="searchForm" onsubmit="event.preventDefault(); loadTasks(1);">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="search_term" placeholder="Buscar tarefa...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <!-- Removido o input-group com ícone para o Tagify ocupar o espaço corretamente -->
                        <input type="text" class="form-control" id="search_tags" placeholder="Filtrar por tags">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="search_status">
                            <option value="">Todos os Status</option>
                            <option value="Pendente">Pendente</option>
                            <option value="Em Andamento">Em Andamento</option>
                            <option value="Concluída">Concluída</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>
                    <div class="col-md-3 text-end">
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

    <div class="row" id="tasks-list">
        <!-- Preenchido via JS -->
    </div>

    <div id="no-tasks" class="text-center py-5 d-none">
        <div class="py-5">
            <i class="fas fa-clipboard-list fa-4x text-light mb-4"></i>
            <h5 class="fw-bold">Nenhuma tarefa encontrada</h5>
            <p class="text-muted">Tente ajustar os filtros ou crie uma nova tarefa.</p>
            <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#taskModal" onclick="clearTaskForm()">
                Criar Minha Primeira Tarefa
            </button>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <nav id="tasks-pagination-nav">
                <!-- Paginação JS -->
            </nav>
        </div>
    </div>
</div>

<!-- Modal para criar/editar tarefa -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="taskModalLabel">Nova Tarefa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="taskForm">
                    <input type="hidden" id="task_id">
                    <div class="mb-3">
                        <label for="description" class="form-label text-muted fw-semibold small">O que precisa ser feito?</label>
                        <textarea class="form-control shadow-none border rounded-3 bg-transparent" id="description" rows="3" placeholder="Ex: Finalizar relatório de vendas" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="due_date" class="form-label text-muted fw-semibold small">Prazo</label>
                            <input type="datetime-local" class="form-control shadow-none border rounded-3 bg-transparent" id="due_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label text-muted fw-semibold small">Situação</label>
                            <select class="form-select shadow-none border rounded-3 bg-transparent" id="status" required>
                                <option value="Pendente">Pendente</option>
                                <option value="Em Andamento">Em Andamento</option>
                                <option value="Concluída">Concluída</option>
                                <option value="Cancelada">Cancelada</option>
                            </select>
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
                <button type="button" class="btn btn-primary px-4 shadow-sm" onclick="saveTask()">
                    <i class="fas fa-save me-2"></i>Salvar Tarefa
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .task-card {
        border-radius: 1rem;
        transition: all 0.2s;
        border: 1px solid #f1f5f9;
    }
    .task-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
    }
    .status-badge {
        font-size: 0.7rem;
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .status-Pendente { background-color: #fef3c7; color: #92400e; }
    .status-Em-Andamento { background-color: #e0e7ff; color: #3730a3; }
    .status-Concluída { background-color: #dcfce7; color: #166534; }
    .status-Cancelada { background-color: #fee2e2; color: #991b1b; }
    .tag-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.2rem 0.6rem;
        border-radius: 3px;
        margin-right: 0.25rem;
        display: inline-block;
        margin-top: 0.25rem;
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
    let currentTasksPage = 1;
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
        loadTasks();
        initTagify();
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

    async function loadTasks(page = 1) {
        currentTasksPage = page;
        const searchTerm = document.getElementById('search_term').value;
        const searchStatus = document.getElementById('search_status').value;

        let searchTags = document.getElementById('search_tags').value;

        let url = `/web-api/tasks?page=${page}`;
        if (searchTerm) url += '&search=' + encodeURIComponent(searchTerm);
        if (searchTags) url += '&tags=' + encodeURIComponent(searchTags);
        if (searchStatus) url += '&status=' + encodeURIComponent(searchStatus);

        try {
            const response = await fetch(url, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await response.json();
            renderTasks(data.data);
            renderTasksPagination(data);
        } catch (error) {
            console.error('Erro ao carregar tarefas:', error);
        }
    }

    function clearSearch() {
        document.getElementById('search_term').value = '';
        if (tagifySearch) tagifySearch.removeAllTags();
        document.getElementById('search_status').value = '';
        loadTasks(1);
    }

    function renderTasks(tasks) {
        const list = document.getElementById('tasks-list');
        const noTasks = document.getElementById('no-tasks');
        list.innerHTML = '';

        if (!tasks || tasks.length === 0) {
            noTasks.classList.remove('d-none');
            return;
        }

        noTasks.classList.add('d-none');
        tasks.forEach(task => {
            const statusClass = task.status.replace(' ', '-');
            const dueDate = task.due_date ? new Date(task.due_date).toLocaleString('pt-BR') : 'Não definida';
            const createdAt = new Date(task.created_at).toLocaleString('pt-BR');
            const completedAt = task.completed_at ? new Date(task.completed_at).toLocaleString('pt-BR') : '-';

            let tagsHtml = '';
            if (task.tags && task.tags.length > 0) {
                tagsHtml = '<div class="mt-2">';
                task.tags.forEach(tag => {
                    const color = colorMap[tag.color] || colorMap.gray;
                    tagsHtml += `<span class="tag-badge" style="background-color: ${color.bg}; color: ${color.text}">${tag.name}</span>`;
                });
                tagsHtml += '</div>';
            }

            const col = document.createElement('div');
            col.className = 'col-md-6 col-lg-4 mb-4';
            col.innerHTML = `
                <div class="card h-100 task-card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="status-badge status-${statusClass}">${task.status}</span>
                            <div class="dropdown">
                                <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                    <li><a class="dropdown-item d-flex align-items-center" href="#" onclick="editTask(${task.id})"><i class="fas fa-edit me-2 text-warning"></i> Editar</a></li>
                                    ${task.status !== 'Concluída' ? `<li><a class="dropdown-item d-flex align-items-center" href="#" onclick="completeTask(${task.id})"><i class="fas fa-check me-2 text-success"></i> Concluir</a></li>` : ''}
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="deleteTask(${task.id})"><i class="fas fa-trash me-2"></i> Excluir</a></li>
                                </ul>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-1 text-dark" style="min-height: 3rem;">${task.description}</h6>
                        ${tagsHtml}
                        <div class="pt-3 border-top mt-auto">
                            <div class="d-flex align-items-center text-muted small mb-2">
                                <i class="far fa-calendar me-2"></i>
                                <span>Criada: ${createdAt.substring(0, 10)}</span>
                            </div>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="far fa-clock me-2"></i>
                                <span>Prazo: ${dueDate.substring(0, 16)}</span>
                            </div>
                            ${task.completed_at ? `
                                <div class="d-flex align-items-center text-success small mt-2 fw-bold">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span>Concluída</span>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
            list.appendChild(col);
        });
    }

    function renderTasksPagination(data) {
        const nav = document.getElementById('tasks-pagination-nav');
        if (data.last_page <= 1) {
            nav.innerHTML = '';
            return;
        }

        let html = '<ul class="pagination">';
        html += `<li class="page-item ${data.current_page === 1 ? 'disabled' : ''}"><a class="page-link shadow-sm border-0 mx-1 rounded" href="#" onclick="loadTasks(${data.current_page - 1})">Anterior</a></li>`;

        for (let i = 1; i <= data.last_page; i++) {
            if (i === 1 || i === data.last_page || (i >= data.current_page - 2 && i <= data.current_page + 2)) {
                html += `<li class="page-item ${i === data.current_page ? 'active' : ''}"><a class="page-link shadow-sm border-0 mx-1 rounded" href="#" onclick="loadTasks(${i})">${i}</a></li>`;
            } else if (i === data.current_page - 3 || i === data.current_page + 3) {
                html += `<li class="page-item disabled"><span class="page-link border-0">...</span></li>`;
            }
        }

        html += `<li class="page-item ${data.current_page === data.last_page ? 'disabled' : ''}"><a class="page-link shadow-sm border-0 mx-1 rounded" href="#" onclick="loadTasks(${data.current_page + 1})">Próximo</a></li>`;
        html += '</ul>';
        nav.innerHTML = html;
    }

    function clearTaskForm() {
        document.getElementById('task_id').value = '';
        document.getElementById('taskForm').reset();
        if (tagifyInput) tagifyInput.removeAllTags();
        document.getElementById('taskModalLabel').innerText = 'Nova Tarefa';
    }

    async function editTask(id) {
        try {
            const response = await fetch(`/web-api/tasks/${id}`, { headers: { 'Accept': 'application/json' } });
            const jsonResponse = await response.json();
            const task = jsonResponse.data;

            document.getElementById('task_id').value = task.id;
            document.getElementById('description').value = task.description;
            if (task.due_date) {
                document.getElementById('due_date').value = task.due_date.substring(0, 16);
            }
            document.getElementById('status').value = task.status;

            // Preencher tags no Tagify
            if (tagifyInput) {
                tagifyInput.removeAllTags();
                if (task.tags && task.tags.length > 0) {
                    const tagsData = task.tags.map(t => ({
                        value: t.name,
                        color: t.color,
                        style: getTagStyle(t.color)
                    }));
                    tagifyInput.addTags(tagsData);
                }
            }

            document.getElementById('taskModalLabel').innerText = 'Editar Tarefa';
            new bootstrap.Modal(document.getElementById('taskModal')).show();
        } catch (error) {
            console.error(error);
            Swal.fire('Erro!', 'Não foi possível carregar os dados.', 'error');
        }
    }

    async function saveTask() {
        const id = document.getElementById('task_id').value;

        // Obter tags do Tagify
        let tagsValue = document.getElementById('tags').value;

        const data = {
            description: document.getElementById('description').value,
            due_date: document.getElementById('due_date').value,
            status: document.getElementById('status').value,
            tags: tagsValue
        };

        const url = id ? `/web-api/tasks/${id}` : '/web-api/tasks';
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
                const modalElement = document.getElementById('taskModal');
                const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modal.hide();
                loadTasks(currentTasksPage);
                initTagify(); // Recarregar whitelist
                Swal.fire({ icon: 'success', title: id ? 'Tarefa atualizada!' : 'Tarefa criada!', showConfirmButton: false, timer: 1500, toast: true, position: 'top-end' });
            } else {
                const errData = await response.json();
                Swal.fire('Erro!', errData.message || 'Verifique os dados.', 'error');
            }
        } catch (error) {
            Swal.fire('Erro!', 'Ocorreu um problema ao salvar.', 'error');
        }
    }

    async function completeTask(id) {
        try {
            const response = await fetch(`/web-api/tasks/${id}/complete`, {
                method: 'PATCH',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            if (response.ok) {
                loadTasks(currentTasksPage);
                Swal.fire({ icon: 'success', title: 'Tarefa concluída!', showConfirmButton: false, timer: 1500, toast: true, position: 'top-end' });
            }
        } catch (error) {
            Swal.fire('Erro!', 'Não foi possível concluir a tarefa.', 'error');
        }
    }

    async function deleteTask(id) {
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
                const response = await fetch(`/web-api/tasks/${id}`, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                if (response.ok) {
                    loadTasks(currentTasksPage);
                    Swal.fire('Excluída!', 'A tarefa foi removida.', 'success');
                }
            } catch (error) {
                Swal.fire('Erro!', 'Não foi possível excluir a tarefa.', 'error');
            }
        }
    }
</script>
@endpush
