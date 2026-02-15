@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center py-md-5">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 60px; height: 60px;">
                    <i class="fas fa-rocket text-white fa-lg"></i>
                </div>
                <h3 class="fw-bold">Bem-vindo de volta!</h3>
                <p class="text-muted small">Acesse sua conta para gerenciar seus contatos.</p>
            </div>
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label text-muted fw-semibold small">{{ __('Endereço de E-mail') }}</label>
                            <div class="input-group shadow-none border rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input id="email" type="email" class="form-control border-0 bg-transparent @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="seu@email.com">
                            </div>
                            @error('email')
                                <span class="text-danger small mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label text-muted fw-semibold small">{{ __('Senha') }}</label>
                                @if (Route::has('password.request'))
                                    <a class="small text-primary text-decoration-none" href="{{ route('password.request') }}">
                                        {{ __('Esqueceu a senha?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="input-group shadow-none border rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-muted"></i></span>
                                <input id="password" type="password" class="form-control border-0 bg-transparent @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                            </div>
                            @error('password')
                                <span class="text-danger small mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted small" for="remember">
                                    {{ __('Lembrar de mim') }}
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                                <i class="fas fa-sign-in-alt me-2"></i> {{ __('Entrar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4">
                <p class="text-muted small">Ainda não tem uma conta? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Cadastre-se</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
