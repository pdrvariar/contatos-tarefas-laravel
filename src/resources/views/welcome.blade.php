<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Rattes SA') }}</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700|playfair-display:700" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #64748b;
            --secondary-dark: #475569;
            --accent: #f43f5e;
            --bg-body: #eef2ff;          /* Fundo destacado */
            --bg-card: #ffffff;
            --bg-sidebar: #0f172a;
            --border-color: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #334155;
            --text-muted: #64748b;
            --sidebar-width: 280px;
            --header-height: 80px;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .hero {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        .card-welcome {
            border: 1px solid var(--border-color);
            border-radius: 1.5rem;
            background: #ffffff;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .btn-welcome {
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-primary-welcome {
            background: var(--primary);
            color: #ffffff;
            border: none;
        }
        .btn-primary-welcome:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }
        .btn-outline-welcome {
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            background: #ffffff;
        }
        .btn-outline-welcome:hover {
            background: #f1f5f9;
            border-color: var(--primary);
            color: var(--primary);
        }
        .brand-icon-large {
            width: 64px;
            height: 64px;
            background: var(--primary);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
            transition: all 0.3s ease;
        }
        .brand-icon-large:hover {
            transform: rotate(15deg) scale(1.1);
            background: var(--accent);
            box-shadow: 0 10px 25px rgba(244, 63, 94, 0.4);
        }
        h1 {
            color: var(--text-primary);
            letter-spacing: -0.04em;
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>
<body>
<div class="container hero">
    <div class="row align-items-center min-vh-100">
        <div class="col-lg-6 mb-5 mb-lg-0">
            <div class="pe-lg-5">
                <div class="brand-icon-large mb-4">
                    <i class="fas fa-terminal"></i>
                </div>
                <h1 class="display-4 fw-bold mb-3">Organize seus contatos e tarefas com estilo</h1>
                <p class="lead text-muted mb-4">Rattes SA é a plataforma definitiva para profissionais que buscam produtividade e simplicidade.</p>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/contacts') }}" class="btn btn-primary-welcome btn-welcome me-2">Ir para o App</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary-welcome btn-welcome me-2">Entrar</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-welcome btn-welcome">Cadastrar</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card-welcome p-4 p-lg-5">
                <img src="https://via.placeholder.com/500x400?text=Dashboard+Preview" alt="Dashboard preview" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </div>
</div>
</body>
</html>
