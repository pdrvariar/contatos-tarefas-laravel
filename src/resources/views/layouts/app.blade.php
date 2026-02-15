<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tagify CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/imask"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>

    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --sidebar-width: 280px;
            --sidebar-bg: #111827;
            --sidebar-hover: #1f2937;
            --content-bg: #f8fafc;
            --accent-color: #06b6d4;
        }
        body {
            background-color: var(--content-bg);
            font-family: 'Inter', 'Nunito', sans-serif;
            color: #1f2937;
            overflow-x: hidden;
        }
        #wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: #fff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: sticky;
            top: 0;
            height: 100vh;
            z-index: 1001;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }
        #sidebar.collapsed {
            margin-left: calc(-1 * var(--sidebar-width));
        }
        #sidebar .sidebar-header {
            padding: 2rem 1.5rem;
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .brand-logo {
            background: var(--primary-gradient);
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        #sidebar ul.components {
            padding: 1.5rem 0.75rem;
        }
        #sidebar ul li a {
            padding: 0.875rem 1.25rem;
            display: flex;
            align-items: center;
            color: #9ca3af;
            text-decoration: none;
            transition: all 0.2s;
            margin-bottom: 0.5rem;
            border-radius: 0.75rem;
            font-weight: 500;
        }
        #sidebar ul li a:hover {
            color: #fff;
            background: var(--sidebar-hover);
        }
        #sidebar ul li.active > a {
            color: #fff;
            background: var(--primary-color);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }
        #sidebar ul li a i {
            width: 24px;
            margin-right: 12px;
            font-size: 1.2rem;
            opacity: 0.8;
        }
        #content {
            flex: 1;
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
        }
        .main-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            padding: 0.75rem 2rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
            height: 70px;
        }
        .search-bar-header {
            max-width: 400px;
            width: 100%;
            position: relative;
        }
        .search-bar-header input {
            background: #f1f5f9;
            border: none;
            padding-left: 2.5rem;
            border-radius: 10px;
            font-size: 0.9rem;
            height: 40px;
            transition: all 0.2s;
        }
        .search-bar-header input:focus {
            background: #fff;
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
        }
        .search-bar-header i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        .page-hero {
            background: #fff;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #f1f5f9;
            margin-bottom: 0;
        }
        .content-body {
            padding: 2rem;
            flex: 1;
        }
        @media (max-width: 991.98px) {
            #sidebar {
                position: fixed;
                height: 100vh;
                margin-left: calc(-1 * var(--sidebar-width));
            }
            #sidebar.active {
                margin-left: 0;
            }
            .content-body {
                padding: 1.5rem 1rem;
            }
            .main-header {
                padding: 0.75rem 1rem;
            }
            .page-hero {
                padding: 1.25rem 1rem;
            }
        }
        .card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
            background: #fff;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        .main-footer {
            padding: 2rem;
            text-align: center;
            background: #fff;
            border-top: 1px solid #f1f5f9;
            color: #64748b;
            font-size: 0.875rem;
        }
        .btn {
            padding: 0.625rem 1.25rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
            opacity: 0.9;
        }
        .nav-icon-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            color: #64748b;
            transition: all 0.2s;
            position: relative;
        }
        .nav-icon-btn:hover {
            background: #f1f5f9;
            color: var(--primary-color);
        }
        .notification-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid #fff;
        }
        .dropdown-menu {
            border-radius: 1rem;
            padding: 0.75rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid #f1f5f9;
            animation: dropdownFade 0.2s ease-out;
        }
        @keyframes dropdownFade {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .dropdown-item {
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            color: #4b5563;
        }
        .dropdown-item:hover {
            background-color: #f3f4f6;
            color: var(--primary-color);
        }
        .dropdown-item i {
            width: 20px;
            margin-right: 8px;
            opacity: 0.7;
        }
        .user-avatar-rect {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #eef2ff;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border: 1px solid #e0e7ff;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }
        .table thead th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            border-top: none;
            background: #f8fafc;
        }
        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            font-size: 1.2rem;
            line-height: 1;
            vertical-align: middle;
        }
        .overlay {
            display: none;
            position: fixed;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            opacity: 0;
            transition: all 0.5s ease-in-out;
        }
        .overlay.active {
            display: block;
            opacity: 1;
        }

        /* Tagify Customization - Jira Style */
        .tagify {
            --tags-border-color: #dfe1e6; /* Jira border color */
            --tags-hover-border-color: #4c9aff; /* Jira focus color */
            --tags-focus-border-color: #4c9aff;
            --tag-bg: #ebecf0; /* Jira tag bg */
            --tag-hover: #dfe1e6;
            --tag-text-color: #172b4d;
            --tag-text-color--edit: #172b4d;
            --tag-pad: 0.2rem 0.5rem;
            --tag-inset-shadow-size: 1.1em;
            --tag-invalid-color: #ff5630;
            --tag-invalid-bg: rgba(255, 86, 48, 0.1);
            --tag-remove-bg: rgba(255, 86, 48, 0.1);
            --tag-remove-btn-color: #172b4d;
            --tag-remove-btn-bg: none;
            --tag-remove-btn-bg--hover: #ff5630;

            border-radius: 3px; /* Jira uses slightly rounded corners */
            width: 100%;
            background: #f4f5f7; /* Jira input background */
            padding: 0.25rem;
            min-height: 40px;
            transition: background-color 0.2s, border-color 0.2s;
        }

        .tagify:hover {
            background-color: #ebecf0;
        }

        .tagify--focus {
            background-color: #fff;
            border-color: #4c9aff;
            box-shadow: 0 0 0 2px rgba(76, 154, 255, 0.2);
        }

        .tagify__tag {
            border-radius: 3px;
            font-weight: 500;
            font-size: 0.85rem;
            margin-top: 4px;
            margin-bottom: 4px;
        }

        .tagify__tag > div {
            border-radius: 3px;
        }

        /* Dropdown de sugestões */
        .tagify__dropdown {
            z-index: 9999 !important; /* Ensure it's above modal */
        }

        .tagify__dropdown__wrapper {
            border: 1px solid #dfe1e6;
            box-shadow: 0 4px 8px -2px rgba(9, 30, 66, 0.25), 0 0 1px rgba(9, 30, 66, 0.31);
            border-radius: 3px;
            padding: 0;
            background: #fff;
        }

        .tagify__dropdown__item {
            padding: 0.5rem 1rem;
            margin: 0;
            font-size: 0.9rem;
            color: #172b4d;
        }

        .tagify__dropdown__item--active {
            background: #ebecf0;
            color: #172b4d;
        }
    </style>
</head>
<body>
    <div id="wrapper">
        @auth
        <div class="overlay"></div>
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <div class="d-flex align-items-center">
                    <div class="brand-logo me-3">
                        <i class="fas fa-rocket text-white"></i>
                    </div>
                    <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.5px;">Rattes <span class="text-primary-light" style="color: #818cf8;">SA</span></h4>
                </div>
            </div>

            <ul class="list-unstyled components">
                <li class="{{ Request::routeIs('contacts.index') ? 'active' : '' }}">
                    <a href="{{ route('contacts.index') }}">
                        <i class="fas fa-address-book"></i> <span>Contatos</span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('tasks.index') ? 'active' : '' }}">
                    <a href="{{ route('tasks.index') }}">
                        <i class="fas fa-tasks"></i> <span>Tarefas</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer mt-auto p-4 d-none d-lg-block">
                <div class="bg-light bg-opacity-10 rounded-4 p-3 border border-white border-opacity-10">
                    <p class="small text-muted mb-2">Precisa de ajuda?</p>
                    <a href="#" class="btn btn-sm btn-outline-light w-100 py-2" style="font-size: 0.75rem;">Documentação</a>
                </div>
            </div>
        </nav>
        @endauth

        <!-- Page Content -->
        <div id="content">
            <header class="main-header">
                <div class="d-flex align-items-center flex-grow-1">
                    @auth
                    <button type="button" id="sidebarCollapse" class="nav-icon-btn btn btn-link p-0 me-3 border-0">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    @endauth

                    <div class="search-bar-header d-none d-md-block">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" placeholder="Pesquisar em todo o sistema...">
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    @auth
                    <a href="#" class="nav-icon-btn d-none d-sm-flex">
                        <i class="far fa-bell fa-lg"></i>
                        <span class="notification-badge"></span>
                    </a>
                    <a href="#" class="nav-icon-btn d-none d-sm-flex me-2">
                        <i class="far fa-question-circle fa-lg"></i>
                    </a>
                    @endauth

                    <div class="dropdown">
                        @guest
                            <div class="d-flex gap-2">
                                @if (Route::has('login'))
                                    <a class="btn btn-sm btn-outline-primary fw-bold px-3" href="{{ route('login') }}">{{ __('Entrar') }}</a>
                                @endif
                                @if (Route::has('register'))
                                    <a class="btn btn-sm btn-primary fw-bold px-3" href="{{ route('register') }}">{{ __('Cadastrar') }}</a>
                                @endif
                            </div>
                        @else
                            <button class="btn btn-link text-dark text-decoration-none dropdown-toggle d-flex align-items-center p-0 border-0" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar-rect me-2">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="text-start d-none d-sm-block">
                                    <div class="fw-bold mb-0 leading-tight" style="font-size: 0.85rem; line-height: 1;">{{ Auth::user()->name }}</div>
                                    <div class="text-muted small" style="font-size: 0.7rem;">Admin</div>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                                <li><h6 class="dropdown-header">Minha Conta</h6></li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="far fa-user"></i> Perfil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="fas fa-cog"></i> Configurações
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger d-flex align-items-center" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('Sair') }}
                                    </a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        @endguest
                    </div>
                </div>
            </header>

            @auth
            <div class="page-hero">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item small"><a href="#" class="text-decoration-none text-muted">Dashboard</a></li>
                                <li class="breadcrumb-item small active text-primary fw-semibold" aria-current="page">@yield('header_title', 'Visão Geral')</li>
                            </ol>
                        </nav>
                        <h3 class="fw-bold mb-0" style="letter-spacing: -0.5px;">@yield('header_title', 'Dashboard')</h3>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        @yield('header_actions')
                        <div class="d-none d-md-block">
                            <span class="badge bg-light text-dark border p-2 px-3 rounded-pill fw-medium">
                                <i class="far fa-calendar-alt me-2 text-primary"></i> {{ date('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endauth

            <main class="content-body">
                @yield('content')
            </main>

            <footer class="main-footer">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-md-start mb-3 mb-md-0">
                            <p class="mb-0 text-muted">
                                &copy; {{ date('Y') }} <span class="fw-bold text-dark">Rattes SA</span>. Todos os direitos reservados.
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item small"><a href="#" class="text-decoration-none text-muted">Termos</a></li>
                                <li class="list-inline-item small ms-3"><a href="#" class="text-decoration-none text-muted">Privacidade</a></li>
                                <li class="list-inline-item small ms-3"><a href="#" class="text-decoration-none text-muted">Suporte</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.overlay');
            const sidebarCollapse = document.getElementById('sidebarCollapse');

            if (sidebarCollapse) {
                sidebarCollapse.addEventListener('click', function() {
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
        });
    </script>
    @stack('scripts')
</body>
</html>
