<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800|playfair-display:700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS (Mantemos o CSS do CDN para garantir estilos, mas o JS virá do Vite) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" />

    <!-- Scripts do Vite (Já incluem o Bootstrap JS) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            /* Nova paleta azul */
            --primary: #1E4A7A;
            --primary-dark: #0B2B5E;
            --secondary: #4A90E2;
            --accent: #2C3E50;
            --bg-body: #F4F9FF;
            --bg-card: #ffffff;
            --bg-sidebar: #0B2B5E;
            --bg-header: #0B2B5E;
            --border-color: #D4E3F0;
            --text-primary: #0B2B5E;
            --text-secondary: #1E4A7A;
            --text-muted: #4A90E2;
            --text-header: #ffffff;

            --sidebar-width: 280px;
            --header-height: 80px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            overflow-x: hidden;
            line-height: 1.6;
        }

        #wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: var(--bg-sidebar);
            transition: all 0.3s ease;
            position: sticky;
            top: 0;
            height: 100vh;
            z-index: 1000;
            /* 🔥 Borda direita substituída por sombra interna suave */
            box-shadow: inset -1px 0 0 rgba(255, 255, 255, 0.05), 5px 0 15px -10px rgba(0,0,0,0.3);
            border-right: none;
        }

        #sidebar.collapsed {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-header {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
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
            pointer-events: none;
        }

        .sidebar-search-input {
            width: 100%;
            height: 40px;
            padding-left: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.03);
            font-size: 0.85rem;
            color: #fff;
            transition: all 0.3s;
        }

        .sidebar-search-input:focus {
            outline: none;
            border-color: var(--secondary);
            background: rgba(255, 255, 255, 0.07);
            box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.1);
        }

        .sidebar-search-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .nav-section {
            padding: 1rem 0.75rem;
            list-style: none;
            margin: 0;
        }

        .nav-item {
            margin-bottom: 0.25rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 1rem;
            color: #B0C4DE;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.03);
        }

        .nav-item.active .nav-link {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 4px 6px -1px rgba(30, 74, 122, 0.2);
        }

        .nav-item.active .nav-link i {
            color: #fff;
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
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
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border-radius: 8px;
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
            color: rgba(255, 255, 255, 0.4);
        }

        /* ===== MAIN CONTENT ===== */
        #content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: var(--bg-body);
        }

        /* ===== HEADER ===== */
        .main-header {
            height: var(--header-height);
            background: var(--bg-header);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            /* 🔥 Borda inferior substituída por sombra + gradiente */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-bottom: none;
            z-index: 10;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Gradiente sutil na parte inferior do header para transição */
        .main-header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to bottom, rgba(0,0,0,0.02), transparent);
            pointer-events: none;
        }

        .main-header:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            transform: translateY(2px);
            background: #0A1F3A;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-brand-icon {
            width: 46px;
            height: 46px;
            background: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: white;
            box-shadow: 0 4px 10px rgba(30, 74, 122, 0.3);
            transition: all 0.4s ease;
        }

        .main-header:hover .header-brand-icon {
            transform: rotate(8deg) scale(1.05);
            background: var(--secondary);
            box-shadow: 0 6px 14px rgba(74, 144, 226, 0.4);
        }

        .header-title-wrapper {
            line-height: 1.2;
        }

        .header-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.85rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            color: var(--text-header);
            margin: 0;
            transition: all 0.3s ease;
        }

        .main-header:hover .header-title {
            letter-spacing: 0.01em;
            color: #fff;
        }

        .header-subtitle {
            font-size: 0.75rem;
            font-weight: 600;
            color: #B0C4DE;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 2;
        }

        .icon-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: #B0C4DE;
            transition: all 0.2s;
            font-size: 1.1rem;
        }

        .icon-btn:hover {
            background: rgba(255, 255, 255, 0.07);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .notification-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 10px;
            height: 10px;
            background: var(--accent);
            border-radius: 50%;
            border: 2px solid var(--bg-header);
        }

        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.5rem 0.5rem 1rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s;
            color: #f8fafc;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-dropdown-toggle:hover,
        .user-dropdown-toggle:focus,
        .user-dropdown-toggle:active {
            background: rgba(255, 255, 255, 0.07) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
        }

        .user-dropdown-toggle .user-avatar-small {
            width: 34px;
            height: 34px;
            background: var(--primary);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 4px 8px rgba(30, 74, 122, 0.2);
        }

        /* Botões de autenticação no header para guest */
        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn-header {
            padding: 0.5rem 1.2rem;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.2s;
            border: none;
            font-size: 0.85rem;
        }

        .btn-header-login {
            background: transparent;
            color: var(--text-primary);
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
        }

        .btn-header-login:hover {
            background: rgba(255,255,255,0.05);
        }

        .btn-header-register {
            background: var(--primary);
            color: white;
        }

        .btn-header-register:hover {
            background: var(--primary-dark);
        }

        /* ===== PAGE HERO ===== */
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
            color: var(--primary);
            font-weight: 600;
        }

        /* ===== CONTENT BODY ===== */
        .content-body {
            padding: 2rem;
            flex: 1;
            /* Leve afastamento do header para dar respiro */
            margin-top: 0.5rem;
        }

        /* ===== FOOTER ===== */
        .main-footer {
            padding: 1rem 2rem;
            background: var(--bg-card);
            /* 🔥 Borda superior substituída por sombra */
            box-shadow: 0 -4px 10px -8px rgba(0,0,0,0.1);
            border-top: none;
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        /* ===== CARDS, TABLES, BUTTONS ===== */
        .card-modern {
            background: var(--bg-card);
            border-radius: 16px; /* Aumentado para suavidade */
            border: 1px solid rgba(0,0,0,0.02);
            box-shadow: 0 8px 20px -12px rgba(0, 0, 0, 0.15);
            transition: all 0.2s;
        }

        .card-modern:hover {
            box-shadow: 0 12px 28px -12px rgba(0, 0, 0, 0.2);
        }

        .btn-modern {
            border-radius: 10px;
            padding: 0.6rem 1.25rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            border: none;
        }

        .btn-primary-modern {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 10px -4px rgba(30, 74, 122, 0.3);
        }

        .btn-primary-modern:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px -4px rgba(30, 74, 122, 0.4);
        }

        .btn-outline-modern {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-outline-modern:hover {
            background: #E6F0FA;
            color: var(--primary);
            border-color: var(--primary);
            transform: translateY(-1px);
        }

        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-modern th {
            background: #E6F0FA;
            padding: 1rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }

        .table-modern td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .table-modern tr:last-child td {
            border-bottom: none;
        }

        .table-modern tr:hover td {
            background: #F0F7FF;
        }

        .avatar-circle {
            width: 36px;
            height: 36px;
            background: #D4E3F0;
            color: var(--text-primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .badge-tag {
            padding: 0.25rem 0.6rem;
            border-radius: 6px; /* Mais quadrado, estilo Jira */
            font-size: 0.75rem;
            font-weight: 600;
            background: #E6F0FA;
            color: var(--text-secondary);
            border: 1px solid rgba(0,0,0,0.05);
            display: inline-flex;
            align-items: center;
            line-height: 1;
        }

        .overlay {
            display: none;
            position: fixed;
            width: 100vw;
            height: 100vh;
            background: rgba(11, 43, 94, 0.3);
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
                        <i class="fas fa-terminal"></i>
                    </div>
                    <div class="header-title-wrapper">
                        <h1 class="header-title">Task Manager</h1>
                        <p class="header-subtitle">Gestão Inteligente de Contatos</p>
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
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="far fa-user"></i> Perfil</a></li>
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
                        <h4 class="fw-bold mb-0" style="color: #0B2B5E;">@yield('header_title', 'Dashboard')</h4>
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

<!-- Scripts -->
<!-- Removido o Bootstrap Bundle CDN para evitar conflito com o Vite -->
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
