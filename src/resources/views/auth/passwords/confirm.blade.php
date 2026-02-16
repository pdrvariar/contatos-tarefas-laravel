@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <div class="brand-icon mx-auto mb-3" style="width: 68px; height: 68px; font-size: 1.6rem; background: var(--primary); color: white; border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(191, 105, 153, 0.3);">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="fw-bold" style="color: var(--text-primary);">Confirme sua senha</h3>
                    <p class="text-muted">Por segurança, confirme sua senha antes de continuar.</p>
                </div>

                <div class="card-modern p-4 p-md-5">
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold small text-muted text-uppercase">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);"><i class="fas fa-lock text-muted"></i></span>
                                <input id="password" type="password" class="form-control bg-white border-start-0 @error('password') is-invalid @enderror" name="password" required placeholder="••••••••" style="border-color: var(--border-color); padding: 0.75rem;">
                            </div>
                            @error('password')
                            <span class="text-danger small mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary-modern btn-modern w-100 py-3">
                            Confirmar senha
                        </button>

                        @if (Route::has('password.request'))
                            <div class="text-center mt-4">
                                <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: var(--primary);">
                                    Esqueceu sua senha?
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
