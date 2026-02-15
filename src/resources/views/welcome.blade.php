<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Rattes SA') }}</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --gray-50: #f9fafb;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(145deg, #f9fafb 0%, #f3f4f6 100%);
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
            border: none;
            border-radius: 2rem;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        }
        .btn-welcome {
            padding: 0.75rem 2rem;
            border-radius: 40px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-primary-welcome {
            background: var(--primary);
            color: white;
            border: none;
        }
        .btn-primary-welcome:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }
        .btn-outline-welcome {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }
        .btn-outline-welcome:hover {
            background: var(--primary);
            color: white;
        }
        .brand-icon-large {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }
    </style>
</head>
<body>
<div class="container hero">
    <div class="row align-items-center min-vh-100">
        <div class="col-lg-6 mb-5 mb-lg-0">
            <div class="pe-lg-5">
                <div class="brand-icon-large mb-4">
                    <i class="fas fa-rocket"></i>
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
