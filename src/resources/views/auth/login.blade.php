@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <div class="brand-icon mx-auto mb-3" style="width: 68px; height: 68px; font-size: 1.6rem; background: var(--primary); color: white; border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(30, 74, 122, 0.3); transition: all 0.3s ease;">
                        <i class="fas fa-terminal"></i>
                    </div>
                    <h3 class="fw-bold" style="color: var(--text-primary); font-family: 'Playfair Display', serif;">Bem-vindo de volta!</h3>
                    <p class="text-muted">Acesse sua conta para gerenciar seus contatos e tarefas.</p>
                </div>
                <div class="card-modern p-4 p-md-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold small text-muted text-uppercase">E-mail</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);"><i class="fas fa-envelope text-muted"></i></span>
                                <input id="email" type="email" class="form-control bg-white border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="seu@email.com" style="border-color: var(--border-color); padding: 0.75rem;">
                            </div>
                            @error('email')
                            <span class="text-danger small mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label fw-semibold small text-muted text-uppercase">Senha</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="small text-decoration-none" style="color: var(--primary);">Esqueceu a senha?</a>
                                @endif
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);"><i class="fas fa-lock text-muted"></i></span>
                                <input id="password" type="password" class="form-control bg-white border-start-0 @error('password') is-invalid @enderror" name="password" required placeholder="••••••••" style="border-color: var(--border-color); padding: 0.75rem;">
                            </div>
                            @error('password')
                            <span class="text-danger small mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">Lembrar de mim</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-modern btn-modern w-100 py-3">
                            Entrar
                        </button>

                        <div class="text-center mt-4">
                            <span class="text-muted">Ainda não tem conta?</span>
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: var(--primary);">Cadastre-se</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
