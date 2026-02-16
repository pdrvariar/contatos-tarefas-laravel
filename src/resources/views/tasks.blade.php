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

    <!-- Modal de Tarefa -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true" style="--bs-modal-width: 550px;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 12px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
                <div class="modal-header border-0 bg-light p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: var(--primary); color: white;">
                            <i class="fas fa-tasks fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold" id="taskModalLabel" style="color: var(--text-primary); font-size: 1.25rem;">Nova Tarefa</h5>
                            <p class="small text-muted mb-0">Organize seu dia</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <form id="taskForm">
                        <input type="hidden" id="task_id">

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-uppercase text-muted">Descrição</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);"><i class="fas fa-align-left text-muted"></i></span>
                                <textarea class="form-control bg-white border-start-0" id="description" rows="3" required placeholder="Ex.: Reunião com cliente" style="border-color: var(--border-color); padding: 0.6rem 0.75rem;"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase text-muted">Prazo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);"><i class="far fa-calendar text-muted"></i></span>
                                    <input type="datetime-local" class="form-control bg-white border-start-0" id="due_date" style="border-color: var(--border-color); padding: 0.6rem 0.75rem;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase text-muted">Status</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);"><i class="fas fa-tag text-muted"></i></span>
                                    <select class="form-select bg-white border-start-0" id="status" style="border-color: var(--border-color); padding: 0.6rem 0.75rem;">
                                        <option value="Pendente">Pendente</option>
                                        <option value="Em Andamento">Em Andamento</option>
                                        <option value="Concluída">Concluída</option>
                                        <option value="Cancelada">Cancelada</option>
                                    </select>
                                </div>
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
                    <button type="button" class="btn btn-primary-modern btn-modern" onclick="saveTask()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .task-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.25rem;
            transition: all 0.2s;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .task-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }
        .status-badge {
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: 700;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            letter-spacing: 0.05em;
        }
        .status-Pendente { background: #F2B29B; color: #2D1240; }
        .status-Em-Andamento { background: #BF6999; color: #ffffff; }
        .status-Concluída { background: #642F73; color: #F2B29B; }
        .status-Cancelada { background: #e6d2db; color: #2D1240; }

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
        }
        .btn-edit:hover { color: var(--primary); border-color: var(--primary); background: #f1e0e8; }
        .btn-delete:hover { color: #ef4444; border-color: #ef4444; background: #fef2f2; }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 0.25rem rgba(191, 105, 153, 0.1) !important;
        }

        .input-group-text {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            transition: all 0.2s;
        }
        .input-group:focus-within .input-group-text {
            border-color: var(--primary);
            color: var(--primary);
        }

        .tagify__tag {
            border-radius: 30px !important;
            font-size: 0.85rem !important;
        }
    </style>
@endsection

@push('scripts')
    <script>
        let currentTasksPage = 1;
        let tagifyInput, tagifySearch;

        // Cores das tags baseadas na nova paleta
        const colorMap = {
            primary: { bg: '#BF6999', text: '#ffffff' },
            dark: { bg: '#642F73', text: '#ffffff' },
            darker: { bg: '#2D1240', text: '#F2B29B' },
            peach: { bg: '#F2B29B', text: '#2D1240' },
            coral: { bg: '#F2937E', text: '#2D1240' }
        };

        function getTagStyle(color) {
            const c = colorMap[color] || colorMap.peach;
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
                const colors = ['primary', 'dark', 'darker', 'peach', 'coral'];
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
