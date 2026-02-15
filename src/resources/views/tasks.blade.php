@extends('layouts.app')

@section('header_title', 'Tarefas')
@section('header_actions')
    <button class="btn btn-primary-modern btn-modern" data-bs-toggle="modal" data-bs-target="#taskModal" onclick="clearTaskForm()">
        <i class="fas fa-plus me-2"></i>Nova Tarefa
    </button>
@endsection

@section('content')
    <div class="container-fluid p-0">
        <!-- Filtros -->
        <div class="card-modern p-3 mb-4">
            <form id="searchForm" onsubmit="event.preventDefault(); loadTasks(1);">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control bg-light" id="search_term" placeholder="Buscar tarefa...">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control bg-light" id="search_tags" placeholder="Tags">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select bg-light" id="search_status">
                            <option value="">Todos os status</option>
                            <option value="Pendente">Pendente</option>
                            <option value="Em Andamento">Em Andamento</option>
                            <option value="Concluída">Concluída</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary-modern btn-modern">Filtrar</button>
                        <button type="button" class="btn btn-outline-modern btn-modern" onclick="clearSearch()">Limpar</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Cards de tarefas -->
        <div class="row g-4" id="tasks-list"></div>

        <div id="no-tasks" class="text-center py-5 d-none">
            <i class="fas fa-clipboard-list fa-3x text-light mb-3"></i>
            <h5>Nenhuma tarefa encontrada</h5>
            <p class="text-muted">Crie sua primeira tarefa agora.</p>
            <button class="btn btn-primary-modern btn-modern" data-bs-toggle="modal" data-bs-target="#taskModal" onclick="clearTaskForm()">
                Nova Tarefa
            </button>
        </div>

        <div class="mt-4" id="tasks-pagination-nav"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 28px;">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" id="taskModalLabel">Nova Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="taskForm">
                        <input type="hidden" id="task_id">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Descrição</label>
                            <textarea class="form-control rounded-3" id="description" rows="2" required></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Prazo</label>
                                <input type="datetime-local" class="form-control rounded-3" id="due_date">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Status</label>
                                <select class="form-select rounded-3" id="status">
                                    <option value="Pendente">Pendente</option>
                                    <option value="Em Andamento">Em Andamento</option>
                                    <option value="Concluída">Concluída</option>
                                    <option value="Cancelada">Cancelada</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Tags</label>
                            <input type="text" class="form-control rounded-3" id="tags" placeholder="Digite e pressione Enter...">
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-outline-modern btn-modern" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary-modern btn-modern" onclick="saveTask()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .task-card {
            border: none;
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            transition: all 0.2s;
            height: 100%;
            border: 1px solid var(--gray-200);
        }
        .task-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        }
        .status-badge {
            font-size: 0.6rem;
            font-weight: 700;
            padding: 0.2rem 0.8rem;
            border-radius: 20px;
            text-transform: uppercase;
        }
        .status-Pendente { background: #fef3c7; color: #92400e; }
        .status-Em-Andamento { background: #e0e7ff; color: #3730a3; }
        .status-Concluída { background: #dcfce7; color: #166534; }
        .status-Cancelada { background: #fee2e2; color: #991b1b; }
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

        function getTagStyle(color) {
            const c = colorMap[color] || colorMap.gray;
            return `background: ${c.bg}; color: ${c.text};`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadTasks();
            initTagify();
        });

        async function initTagify() {
            let whitelist = [];
            try {
                const res = await fetch('/web-api/tags');
                whitelist = await res.json();
            } catch (e) {}

            const transformTag = (tagData) => {
                const existing = whitelist.find(t => t.value.toLowerCase() === tagData.value.toLowerCase());
                const color = existing?.color || Object.keys(colorMap)[Math.abs(tagData.value.split('').reduce((a,b)=>a+b.charCodeAt(0),0)) % 7];
                tagData.style = getTagStyle(color);
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

        async function loadTasks(page = 1) {
            currentTasksPage = page;
            const term = document.getElementById('search_term').value;
            const tags = document.getElementById('search_tags').value;
            const status = document.getElementById('search_status').value;
            let url = `/web-api/tasks?page=${page}`;
            if (term) url += `&search=${encodeURIComponent(term)}`;
            if (tags) url += `&tags=${encodeURIComponent(tags)}`;
            if (status) url += `&status=${encodeURIComponent(status)}`;

            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            renderTasks(data.data);
            renderTasksPagination(data);
        }

        function renderTasks(tasks) {
            const container = document.getElementById('tasks-list');
            const noTasks = document.getElementById('no-tasks');
            if (!tasks || tasks.length === 0) {
                container.innerHTML = '';
                noTasks.classList.remove('d-none');
                return;
            }
            noTasks.classList.add('d-none');

            container.innerHTML = tasks.map(t => {
                const tags = t.tags?.map(tag => `<span class="badge-tag me-1" style="${getTagStyle(tag.color)}">${tag.name}</span>`).join('') || '';
                const statusClass = t.status.replace(' ', '-');
                const due = t.due_date ? new Date(t.due_date).toLocaleString('pt-BR', {day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit'}) : 'Sem prazo';
                return `
                <div class="col-md-6 col-lg-4">
                    <div class="task-card p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="status-badge status-${statusClass}">${t.status}</span>
                            <div class="dropdown">
                                <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                    <li><a class="dropdown-item" href="#" onclick="editTask(${t.id})"><i class="fas fa-edit me-2 text-warning"></i>Editar</a></li>
                                    ${t.status !== 'Concluída' ? `<li><a class="dropdown-item" href="#" onclick="completeTask(${t.id})"><i class="fas fa-check me-2 text-success"></i>Concluir</a></li>` : ''}
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteTask(${t.id})"><i class="fas fa-trash me-2"></i>Excluir</a></li>
                                </ul>
                            </div>
                        </div>
                        <p class="fw-semibold mb-3">${t.description}</p>
                        <div class="mb-2">${tags}</div>
                        <div class="d-flex align-items-center text-muted small mt-3">
                            <i class="far fa-calendar me-2"></i>
                            <span>${due}</span>
                        </div>
                    </div>
                </div>
            `;
            }).join('');
        }

        function renderTasksPagination(data) {
            const nav = document.getElementById('tasks-pagination-nav');
            if (data.last_page <= 1) { nav.innerHTML = ''; return; }
            let html = '<ul class="pagination justify-content-center">';
            html += `<li class="page-item ${data.current_page === 1 ? 'disabled' : ''}"><a class="page-link" href="#" onclick="loadTasks(${data.current_page-1})">Anterior</a></li>`;
            for (let i = 1; i <= data.last_page; i++) {
                if (i === 1 || i === data.last_page || (i >= data.current_page-2 && i <= data.current_page+2)) {
                    html += `<li class="page-item ${i === data.current_page ? 'active' : ''}"><a class="page-link" href="#" onclick="loadTasks(${i})">${i}</a></li>`;
                } else if (i === data.current_page-3 || i === data.current_page+3) {
                    html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }
            html += `<li class="page-item ${data.current_page === data.last_page ? 'disabled' : ''}"><a class="page-link" href="#" onclick="loadTasks(${data.current_page+1})">Próximo</a></li>`;
            html += '</ul>';
            nav.innerHTML = html;
        }

        function clearSearch() {
            document.getElementById('search_term').value = '';
            document.getElementById('search_status').value = '';
            if (tagifySearch) tagifySearch.removeAllTags();
            loadTasks(1);
        }

        function clearTaskForm() {
            document.getElementById('task_id').value = '';
            document.getElementById('taskForm').reset();
            if (tagifyInput) tagifyInput.removeAllTags();
            document.getElementById('taskModalLabel').innerText = 'Nova Tarefa';
        }

        async function editTask(id) {
            const res = await fetch(`/web-api/tasks/${id}`, { headers: { 'Accept': 'application/json' } });
            const json = await res.json();
            const t = json.data;
            document.getElementById('task_id').value = t.id;
            document.getElementById('description').value = t.description;
            if (t.due_date) document.getElementById('due_date').value = t.due_date.substring(0,16);
            document.getElementById('status').value = t.status;
            if (tagifyInput) {
                tagifyInput.removeAllTags();
                if (t.tags?.length) {
                    tagifyInput.addTags(t.tags.map(tag => ({ value: tag.name, color: tag.color, style: getTagStyle(tag.color) })));
                }
            }
            document.getElementById('taskModalLabel').innerText = 'Editar Tarefa';
            new bootstrap.Modal(document.getElementById('taskModal')).show();
        }

        async function saveTask() {
            const id = document.getElementById('task_id').value;
            const data = {
                description: document.getElementById('description').value,
                due_date: document.getElementById('due_date').value,
                status: document.getElementById('status').value,
                tags: document.getElementById('tags').value
            };
            const url = id ? `/web-api/tasks/${id}` : '/web-api/tasks';
            const method = id ? 'PUT' : 'POST';
            const res = await fetch(url, {
                method,
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify(data)
            });
            if (res.ok) {
                bootstrap.Modal.getInstance(document.getElementById('taskModal')).hide();
                loadTasks(currentTasksPage);
                initTagify();
                Swal.fire({ icon: 'success', title: id ? 'Tarefa atualizada!' : 'Tarefa criada!', toast: true, position: 'top-end', timer: 2000 });
            } else {
                const err = await res.json();
                Swal.fire('Erro!', err.message || 'Verifique os dados.', 'error');
            }
        }

        async function completeTask(id) {
            const res = await fetch(`/web-api/tasks/${id}/complete`, { method: 'PATCH', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
            if (res.ok) {
                loadTasks(currentTasksPage);
                Swal.fire({ icon: 'success', title: 'Tarefa concluída!', toast: true, position: 'top-end', timer: 2000 });
            } else {
                Swal.fire('Erro!', 'Não foi possível concluir.', 'error');
            }
        }

        async function deleteTask(id) {
            const confirm = await Swal.fire({ title: 'Excluir tarefa?', text: 'Esta ação não pode ser desfeita.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#6b7280', confirmButtonText: 'Sim, excluir' });
            if (confirm.isConfirmed) {
                const res = await fetch(`/web-api/tasks/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                if (res.ok) {
                    loadTasks(currentTasksPage);
                    Swal.fire('Excluída!', 'Tarefa removida.', 'success');
                } else {
                    Swal.fire('Erro!', 'Não foi possível excluir.', 'error');
                }
            }
        }
    </script>
@endpush
