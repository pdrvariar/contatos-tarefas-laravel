@extends('layouts.app')

@section('header_title', 'Meu Perfil')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status') === 'profile-updated')
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> Perfil atualizado com sucesso!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white py-3" style="border-radius: 15px 15px 0 0; border-bottom: 1px solid var(--border-color);">
                    <h5 class="mb-0 fw-bold" style="color: var(--primary);">Informações do Perfil</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold small text-muted text-uppercase">Nome</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" style="padding: 0.75rem; border-radius: 8px;">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold small text-muted text-uppercase">E-mail</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email" style="padding: 0.75rem; border-radius: 8px;">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4" style="opacity: 0.1;">

                        <h6 class="fw-bold mb-3" style="color: var(--primary);">Alterar Senha</h6>
                        <p class="text-muted small mb-4">Deixe em branco se não desejar alterar a senha.</p>

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold small text-muted text-uppercase">Senha Atual</label>
                            <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current-password" style="padding: 0.75rem; border-radius: 8px;">
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="new_password" class="form-label fw-semibold small text-muted text-uppercase">Nova Senha</label>
                                <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" autocomplete="new-password" style="padding: 0.75rem; border-radius: 8px;">
                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="new_password_confirmation" class="form-label fw-semibold small text-muted text-uppercase">Confirmar Nova Senha</label>
                                <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" autocomplete="new-password" style="padding: 0.75rem; border-radius: 8px;">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-bold" style="background-color: var(--primary); border: none; border-radius: 8px;">
                                <i class="fas fa-save me-2"></i> Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
