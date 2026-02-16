<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --color-dark-purple: #211c33;
            --color-teal: #2b818c;
            --color-peach: #ffc994;
            --color-pink: #ed2860;
            --color-magenta: #990069;

            --primary: var(--color-teal);
            --primary-dark: #1e6a73;
            --secondary: var(--color-pink);
            --secondary-dark: #7a0050;
            --accent: var(--color-peach);

            --bg-body: #fefaf5;
            --bg-card: #ffffff;
            --bg-sidebar: var(--color-dark-purple);
            --border-color: #ffe0c0;
            --text-primary: #211c33;
            --text-secondary: #4b3b5e;
            --text-muted: #7b6b8c;

            --sidebar-width: 280px;
            --header-height: 110px; /* Aumentado para destacar */
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            overflow-x: hidden;
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
            box-shadow: 10px 0 40px -15px rgba(0, 0, 0, 0.3);
        }

        #sidebar.collapsed {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-header {
            padding: 1.5rem 1.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255, 201, 148, 0.2);
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
            color: var(--color-peach);
            font-size: 0.85rem;
            pointer-events: none;
        }

        .sidebar-search-input {
            width: 100%;
            height: 40px;
            padding-left: 2.5rem;
            border: 1px solid rgba(255, 201, 148, 0.3);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            font-size: 0.85rem;
            color: #fff;
            transition: all 0.3s;
        }

        .sidebar-search-input:focus {
            outline: none;
            border-color: var(--color-peach);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 4px rgba(255, 201, 148, 0.2);
        }

        .sidebar-search-input::placeholder {
            color: rgba(255, 201, 148, 0.7);
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--color-teal), var(--color-pink));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .nav-section {
            padding: 1rem 1rem;
            list-style: none;
        }

        .nav-item {
            margin-bottom: 0.25rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            color: var(--color-peach);
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
        }

        .nav-link i {
            width: 24px;
            font-size: 1.2rem;
            margin-right: 12px;
            color: rgba(255, 201, 148, 0.7);
        }

        .nav-link:hover {
            background: rgba(255, 201, 148, 0.15);
            color: #fff;
        }

        .nav-link:hover i {
            color: #fff;
        }

        .nav-item.active .nav-link {
            background: var(--color-teal);
            color: #fff;
            font-weight: 600;
        }

        .nav-item.active .nav-link i {
            color: #fff;
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(255, 201, 148, 0.2);
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
            background: var(--color-teal);
            color: white;
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
            color: #fff;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--color-peach);
        }

        /* MAIN CONTENT */
        #content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: var(--bg-body);
        }

        /* ===== HEADER CRIATIVO ===== */
        .main-header {
            height: var(--header-height);
            background: linear-gradient(145deg, #2b818c 0%, #ed2860 40%, #ffc994 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 15px 30px -10px rgba(33, 28, 51, 0.3);
            border-bottom: 4px solid #990069;
            z-index: 10;
        }

        /* Elementos decorativos no header */
        .main-header::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .main-header::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: -50px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,201,148,0.2) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 2rem;
            position: relative;
            z-index: 2;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-brand-icon {
            width: 55px;
            height: 55px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.2);
        }

        .header-title-wrapper {
            line-height: 1.2;
        }

        .header-title {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: white;
            margin: 0;
            text-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .header-subtitle {
            font-size: 0.85rem;
            font-weight: 500;
            color: rgba(255,255,255,0.85);
            margin: 0;
            letter-spacing: 0.5px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 2;
        }

        .icon-btn {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            transition: all 0.2s;
            font-size: 1.2rem;
            box-shadow: 0 8px 15px -5px rgba(0,0,0,0.2);
        }

        .icon-btn:hover {
            background: rgba(255, 255, 255, 0.35);
            transform: translateY(-2px);
            box-shadow: 0 15px 20px -5px rgba(0,0,0,0.3);
            border-color: white;
        }

        .notification-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 10px;
            height: 10px;
            background: #ffc994;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.5);
        }

        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.3rem 0.3rem 0.3rem 0.8rem;
            border-radius: 40px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.3);
            transition: all 0.2s;
            color: white;
            box-shadow: 0 8px 15px -5px rgba(0,0,0,0.2);
        }

        .user-dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.35);
            border-color: white;
            transform: translateY(-2px);
        }

        .user-dropdown-toggle .user-avatar-small {
            width: 36px;
            height: 36px;
            background: white;
            color: #2b818c;
            border-radius: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
        }

        /* Botões de autenticação no header para guest */
        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn-header {
            padding: 0.6rem 1.8rem;
            border-radius: 40px;
            font-weight: 600;
            transition: all 0.2s;
            border: none;
            font-size: 0.95rem;
            box-shadow: 0 8px 15px -5px rgba(0,0,0,0.2);
        }

        .btn-header-login {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(8px);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .btn-header-login:hover {
            background: rgba(255,255,255,0.35);
            transform: translateY(-2px);
        }

        .btn-header-register {
            background: #ffc994;
            color: #211c33;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .btn-header-register:hover {
            background: #ffb96b;
            transform: translateY(-2px);
        }

        /* Page hero area (breadcrumb e título da página) */
        .page-hero {
            padding: 1.5rem 2rem 0;
            background: transparent;
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
            color: var(--color-teal);
            font-weight: 600;
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

        /* Cards, tabelas, etc (mantidos iguais) */
        .card-modern {
            background: var(--bg-card);
            border-radius: 24px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(33, 28, 51, 0.1);
            transition: all 0.2s;
        }

        .card-modern:hover {
            box-shadow: 0 20px 25px -5px rgba(33, 28, 51, 0.2);
            border-color: var(--color-teal);
        }

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
            box-shadow: 0 4px 6px -1px rgba(43, 129, 140, 0.3);
        }

        .btn-primary-modern:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(43, 129, 140, 0.4);
        }

        .btn-secondary-modern {
            background: var(--secondary);
            color: #fff;
        }

        .btn-secondary-modern:hover {
            background: var(--secondary-dark);
        }

        .btn-outline-modern {
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline-modern:hover {
            background: var(--primary);
            color: #fff;
        }

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
            box-shadow: 0 4px 6px -1px rgba(33, 28, 51, 0.1);
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

        .badge-tag {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            margin-right: 0.25rem;
            display: inline-block;
        }

        .overlay {
            display: none;
            position: fixed;
            width: 100vw;
            height: 100vh;
            background: rgba(33, 28, 51, 0.5);
            backdrop-filter: blur(4px);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .overlay.active {
            display: block;
            opacity: 1;
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
            .header-brand-icon {
                width: 45px;
                height: 45px;
                font-size: 1.4rem;
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
        <!-- HEADER CRIATIVO -->
        <header class="main-header">
            <div class="header-content">
                <div class="header-brand">
                    <div class="header-brand-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div class="header-title-wrapper">
                        <h1 class="header-title">Task Manager</h1>
                        <p class="header-subtitle">Organize com estilo</p>
                    </div>
                </div>
                @auth
                    <button type="button" id="sidebarCollapse" class="icon-btn d-lg-none">
                        <i class="fas fa-bars"></i>
                    </button>
                @endauth
            </div>

            <div class="header-actions">
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
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn-header btn-header-login">Entrar</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-header btn-header-register">Cadastrar</a>
                        @endif
                    </div>
                @else
                    <div class="dropdown">
                        <button class="user-dropdown-toggle btn" type="button" data-bs-toggle="dropdown">
                            <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                            <div class="user-avatar-small">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
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
                        <h4 class="fw-bold mb-0" style="color: #211c33;">@yield('header_title', 'Dashboard')</h4>
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
