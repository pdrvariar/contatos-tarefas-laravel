@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center py-md-5">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 60px; height: 60px;">
                    <i class="fas fa-user-plus text-white fa-lg"></i>
                </div>
                <h3 class="fw-bold">Crie sua conta</h3>
                <p class="text-muted small">Junte-se a nós para organizar seus contatos e tarefas.</p>
            </div>
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label text-muted fw-semibold small">{{ __('Nome Completo') }}</label>
                            <div class="input-group shadow-none border rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-user text-muted"></i></span>
                                <input id="name" type="text" class="form-control border-0 bg-transparent @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Ex: João Silva">
                            </div>
                            @error('name')
                                <span class="text-danger small mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-muted fw-semibold small">{{ __('Endereço de E-mail') }}</label>
                            <div class="input-group shadow-none border rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input id="email" type="email" class="form-control border-0 bg-transparent @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="seu@email.com">
                            </div>
                            @error('email')
                                <span class="text-danger small mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-muted fw-semibold small">{{ __('Senha') }}</label>
                            <div class="input-group shadow-none border rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-muted"></i></span>
                                <input id="password" type="password" class="form-control border-0 bg-transparent @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="••••••••">
                            </div>
                            @error('password')
                                <span class="text-danger small mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label text-muted fw-semibold small">{{ __('Confirmar Senha') }}</label>
                            <div class="input-group shadow-none border rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-check text-muted"></i></span>
                                <input id="password-confirm" type="password" class="form-control border-0 bg-transparent" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                                <i class="fas fa-user-check me-2"></i> {{ __('Cadastrar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4">
                <p class="text-muted small">Já tem uma conta? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Entrar</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
