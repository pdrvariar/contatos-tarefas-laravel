@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <div class="brand-icon mx-auto mb-3" style="width: 70px; height: 70px; font-size: 1.8rem;">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3 class="fw-bold">Bem-vindo de volta!</h3>
                    <p class="text-muted">Acesse sua conta para gerenciar seus contatos e tarefas.</p>
                </div>
                <div class="card-modern p-4 p-md-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold small">E-mail</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input id="email" type="email" class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="seu@email.com">
                            </div>
                            @error('email')
                            <span class="text-danger small mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label fw-semibold small">Senha</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="small text-decoration-none">Esqueceu a senha?</a>
                                @endif
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                <input id="password" type="password" class="form-control bg-light border-start-0 @error('password') is-invalid @enderror" name="password" required placeholder="••••••••">
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

                        <button type="submit" class="btn btn-primary-modern btn-modern w-100 py-2">
                            <i class="fas fa-sign-in-alt me-2"></i> Entrar
                        </button>

                        <div class="text-center mt-4">
                            <span class="text-muted">Ainda não tem conta?</span>
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Cadastre-se</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
