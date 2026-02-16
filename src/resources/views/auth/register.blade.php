@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <div class="brand-icon mx-auto mb-3" style="width: 68px; height: 68px; font-size: 1.6rem; background: var(--primary); color: white; border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(191, 105, 153, 0.3); transition: all 0.3s ease;">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3 class="fw-bold" style="color: var(--text-primary); font-family: 'Playfair Display', serif;">Crie sua conta</h3>
                    <p class="text-muted">Junte-se a nós e organize sua vida profissional.</p>
                </div>
                <div class="card-modern p-4 p-md-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold small text-muted text-uppercase">Nome completo</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);"><i class="fas fa-user text-muted"></i></span>
                                <input id="name" type="text" class="form-control bg-white border-start-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="João Silva" style="border-color: var(--border-color); padding: 0.75rem;">
                            </div>
                            @error('name')
                            <span class="text-danger small mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small text-muted text-uppercase">E-mail</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);"><i class="fas fa-envelope text-muted"></i></span>
                                <input id="email" type="email" class="form-control bg-white border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="seu@email.com" style="border-color: var(--border-color); padding: 0.75rem;">
                            </div>
                            @error('email')
                            <span class="text-danger small mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold small text-muted text-uppercase">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);"><i class="fas fa-lock text-muted"></i></span>
                                <input id="password" type="password" class="form-control bg-white border-start-0 @error('password') is-invalid @enderror" name="password" required placeholder="••••••••" style="border-color: var(--border-color); padding: 0.75rem;">
                            </div>
                            @error('password')
                            <span class="text-danger small mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-semibold small text-muted text-uppercase">Confirmar senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);"><i class="fas fa-check text-muted"></i></span>
                                <input id="password-confirm" type="password" class="form-control bg-white border-start-0" name="password_confirmation" required placeholder="••••••••" style="border-color: var(--border-color); padding: 0.75rem;">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-modern btn-modern w-100 py-3">
                            Cadastrar
                        </button>

                        <div class="text-center mt-4">
                            <span class="text-muted">Já tem uma conta?</span>
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: var(--primary);">Entrar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
