<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tagify CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        /* Tema Claro (padrão) */
        :root {
            --primary-light: #eef2ff;
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #f59e0b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;

            --bg-body: #f9fafb;
            --bg-card: #ffffff;
            --bg-header: #ffffff;
            --bg-header-alpha: rgba(255, 255, 255, 0.8);
            --bg-sidebar: #ffffff;
            --border-color: #e5e7eb;
            --text-primary: #111827;
            --text-secondary: #4b5563;
            --text-muted: #6b7280;
            --text-light: #9ca3af;
            --hover-bg: #f3f4f6;
            --input-bg: #f9fafb;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);

            --sidebar-width: 280px;
            --header-height: 90px;
        }

        /* Tema Escuro */
        .dark {
            --primary-light: #2e2a5e;
            --primary: #6366f1;
            --primary-dark: #4f46e5;

            --bg-body: #111827;
            --bg-card: #1f2937;
            --bg-header: #1f2937;
            --bg-header-alpha: rgba(31, 41, 55, 0.8);
            --bg-sidebar: #1f2937;
            --border-color: #374151;
            --text-primary: #f9fafb;
            --text-secondary: #d1d5db;
            --text-muted: #9ca3af;
            --text-light: #6b7280;
            --hover-bg: #374151;
            --input-bg: #374151;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            overflow-x: hidden;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
        }

        #wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: var(--bg-sidebar);
            border-right: none;
            transition: all 0.3s ease;
            position: sticky;
            top: 0;
            height: 100vh;
            z-index: 1000;
            box-shadow: 10px 0 40px -15px rgba(0, 0, 0, 0.1);
        }

        #sidebar.collapsed {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-header {
            padding: 1.5rem 1.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: linear-gradient(to bottom, var(--bg-sidebar) 90%, var(--border-color));
            border-bottom: none;
        }

        .sidebar-search-wrapper {
            position: relative;
            width: 100%;
        }

        .sidebar-search-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.85rem;
            transition: all 0.2s;
            pointer-events: none;
        }

        .sidebar-search-input {
            width: 100%;
            height: 40px;
            padding-left: 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            background: var(--input-bg);
            font-size: 0.85rem;
            color: var(--text-primary);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-search-input:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 4px var(--primary-light);
        }

        .sidebar-search-input:focus + i {
            color: var(--primary);
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .brand-text {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--text-primary);
        }

        .nav-section {
            padding: 1rem 1rem;
        }

        .nav-item {
            margin-bottom: 0.25rem;
            list-style: none;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            color: var(--text-secondary);
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
        }

        .nav-link i {
            width: 24px;
            font-size: 1.2rem;
            margin-right: 12px;
            color: var(--text-light);
        }

        .nav-link:hover {
            background: var(--hover-bg);
            color: var(--primary);
        }

        .nav-link:hover i {
            color: var(--primary);
        }

        .nav-item.active .nav-link {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
        }

        .nav-item.active .nav-link i {
            color: var(--primary);
        }

        .sidebar-footer {
            padding: 1.5rem;
            background: linear-gradient(to top, var(--bg-sidebar) 90%, var(--border-color));
            border-top: none;
            margin-top: auto;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .user-details {
            line-height: 1.3;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-primary);
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Main content */
        #content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: var(--bg-body);
        }

        .main-header {
            height: var(--header-height);
            background: var(--bg-header-alpha);
            border-bottom: none;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 10px 40px -15px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .header-title {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 50%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0;
            position: relative;
            display: inline-block;
            transition: all 0.3s ease;
            filter: drop-shadow(0 2px 10px rgba(79, 70, 229, 0.1));
        }

        .header-title:hover {
            transform: translateY(-1px);
            filter: drop-shadow(0 4px 15px rgba(79, 70, 229, 0.25));
        }

        .header-title::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), transparent);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .header-title:hover::after {
            width: 100%;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .icon-btn {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 42px;
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            transition: all 0.2s;
        }

        .icon-btn:hover {
            background: var(--hover-bg);
            color: var(--primary);
            border-color: var(--primary);
        }

        .notification-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid var(--bg-header);
        }

        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.5rem 0.25rem 0.25rem;
            border-radius: 40px;
            border: 1px solid var(--border-color);
            background: transparent;
            transition: all 0.2s;
            color: var(--text-primary);
        }

        .user-dropdown-toggle:hover {
            background: var(--hover-bg);
            border-color: var(--primary);
        }

        .dropdown-menu {
            border: none;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            padding: 0.5rem;
            min-width: 220px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
        }

        .dropdown-item {
            padding: 0.6rem 1rem;
            border-radius: 12px;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 0.5rem;
            color: var(--text-muted);
        }

        .dropdown-item:hover {
            background: var(--hover-bg);
            color: var(--primary);
        }

        .page-hero {
            padding: 2rem 2rem 0;
            background: linear-gradient(to bottom, var(--bg-header-alpha), transparent);
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 0.25rem;
        }

        .breadcrumb-item a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.8rem;
        }

        .breadcrumb-item.active {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.8rem;
        }

        .content-body {
            padding: 2rem;
            flex: 1;
        }

        .main-footer {
            padding: 1rem 2rem;
            background: var(--bg-card);
            border-top: 1px solid var(--border-color);
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        /* Cards */
        .card-modern {
            background: var(--bg-card);
            border-radius: 24px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow);
            transition: all 0.2s;
        }

        .card-modern:hover {
            box-shadow: var(--shadow-lg);
        }

        /* Buttons */
        .btn-modern {
            padding: 0.6rem 1.5rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary-modern {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }

        .btn-primary-modern:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        .btn-outline-modern {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .btn-outline-modern:hover {
            background: var(--hover-bg);
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Table */
        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table-modern thead th {
            background: transparent;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            font-weight: 600;
            padding: 0.5rem 1rem;
            border: none;
        }

        .table-modern tbody tr {
            background: var(--bg-card);
            border-radius: 20px;
            box-shadow: var(--shadow);
        }

        .table-modern tbody td {
            padding: 1rem;
            border: none;
            vertical-align: middle;
            color: var(--text-secondary);
        }

        .table-modern tbody tr:first-child td:first-child {
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
        }

        .table-modern tbody tr:first-child td:last-child {
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        /* Badges */
        .badge-tag {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            margin-right: 0.25rem;
            display: inline-block;
            background: var(--input-bg);
            color: var(--text-secondary);
        }

        /* Overlay */
        .overlay {
            display: none;
            position: fixed;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.3);
            backdrop-filter: blur(4px);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .overlay.active {
            display: block;
            opacity: 1;
        }

        /* Dark mode toggle button */
        .theme-toggle {
            cursor: pointer;
        }

        @media (max-width: 991.98px) {
            #sidebar {
                position: fixed;
                margin-left: calc(-1 * var(--sidebar-width));
            }
            #sidebar.active {
                margin-left: 0;
            }
            .content-body {
                padding: 1.5rem 1rem;
            }
            .main-header {
                padding: 0 1rem;
            }
            .header-title {
                font-size: 1.6rem;
            }
            .header-title::after {
                height: 2px;
                bottom: -2px;
            }
        }

        @media (max-width: 480px) {
            .header-title {
                font-size: 1.2rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
<div id="wrapper">
    @auth
        <div class="overlay"></div>
        <nav id="sidebar" class="d-flex flex-column">
            <div class="sidebar-header">
                <div class="sidebar-search-wrapper">
                    <input type="text" class="sidebar-search-input" id="sidebarSearch" placeholder="Pesquisar menu...">
                    <i class="fas fa-search"></i>
                </div>
            </div>

            <ul class="nav-section flex-grow-1">
                <li class="nav-item {{ Request::routeIs('contacts.index') ? 'active' : '' }}">
                    <a href="{{ route('contacts.index') }}" class="nav-link">
                        <i class="fas fa-address-book"></i>
                        <span>Contatos</span>
                    </a>
                </li>
                <li class="nav-item {{ Request::routeIs('tasks.index') ? 'active' : '' }}">
                    <a href="{{ route('tasks.index') }}" class="nav-link">
                        <i class="fas fa-tasks"></i>
                        <span>Tarefas</span>
                    </a>
                </li>
            </ul>

        </nav>
    @endauth

    <div id="content">
        <header class="main-header">
            <div class="d-flex align-items-center flex-grow-1">
                @auth
                    <button type="button" id="sidebarCollapse" class="icon-btn me-3 d-lg-none">
                        <i class="fas fa-bars"></i>
                    </button>
                @endauth

                <div class="header-title-container">
                    <h1 class="header-title">Task Manager System</h1>
                </div>
            </div>

            <div class="header-actions">
                <!-- Botão de alternar tema -->
                <button class="icon-btn theme-toggle" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>

                @auth
                    <button class="icon-btn position-relative">
                        <i class="far fa-bell"></i>
                        <span class="notification-badge"></span>
                    </button>
                    <button class="icon-btn">
                        <i class="far fa-question-circle"></i>
                    </button>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn-modern btn-outline-modern">Entrar</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-modern btn-primary-modern">Cadastrar</a>
                    @endif
                @else
                    <div class="dropdown">
                        <button class="user-dropdown-toggle btn" type="button" data-bs-toggle="dropdown">
                            <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-muted small"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">Minha Conta</h6></li>
                            <li><a class="dropdown-item" href="#"><i class="far fa-user"></i> Perfil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Configurações</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Sair
                                </a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                @endguest
            </div>
        </header>

        @auth
            <div class="page-hero">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">@yield('header_title', 'Visão Geral')</li>
                            </ol>
                        </nav>
                        <h4 class="fw-bold mb-0">@yield('header_title', 'Dashboard')</h4>
                    </div>
                    <div>
                        @yield('header_actions')
                    </div>
                </div>
            </div>
        @endauth

        <main class="content-body">
            @yield('content')
        </main>

        <footer class="main-footer">
            <div class="d-flex justify-content-between align-items-center">
                <span>&copy; {{ date('Y') }} Rattes SA. Todos os direitos reservados.</span>
                <span>
                        <a href="#" class="text-muted text-decoration-none me-3">Termos</a>
                        <a href="#" class="text-muted text-decoration-none">Privacidade</a>
                    </span>
            </div>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

<script>
    // Dark mode toggle
    (function() {
        const themeToggle = document.getElementById('themeToggle');
        const htmlElement = document.documentElement;
        const icon = themeToggle?.querySelector('i');

        // Verificar preferência salva
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            htmlElement.classList.add('dark');
            if (icon) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
        }

        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                if (htmlElement.classList.contains('dark')) {
                    htmlElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    if (icon) {
                        icon.classList.remove('fa-sun');
                        icon.classList.add('fa-moon');
                    }
                } else {
                    htmlElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    if (icon) {
                        icon.classList.remove('fa-moon');
                        icon.classList.add('fa-sun');
                    }
                }
            });
        }
    })();

    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.overlay');
        const toggleBtn = document.getElementById('sidebarCollapse');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                } else {
                    sidebar.classList.toggle('collapsed');
                }
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        }

        // Sidebar Menu Filter
        const sidebarSearch = document.getElementById('sidebarSearch');
        if (sidebarSearch) {
            sidebarSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                const navItems = document.querySelectorAll('.nav-section .nav-item');

                navItems.forEach(item => {
                    const text = item.querySelector('span')?.textContent.toLowerCase() || '';
                    if (text.includes(searchTerm)) {
                        item.style.display = '';
                        item.style.opacity = '1';
                    } else {
                        item.style.display = 'none';
                        item.style.opacity = '0';
                    }
                });
            });
        }
    });
</script>
@stack('scripts')
</body>
</html>
