@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <div class="brand-icon mx-auto mb-3" style="width: 68px; height: 68px; font-size: 1.6rem; background: var(--primary); color: white; border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(30, 74, 122, 0.3);">
                        <i class="fas fa-key"></i>
                    </div>
                    <h3 class="fw-bold" style="color: var(--text-primary);">Redefinir senha</h3>
                    <p class="text-muted">Digite seu e-mail para receber o link de redefinição.</p>
                </div>

                <div class="card-modern p-4 p-md-5">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert" style="background: #E6F0FA; color: #0B2B5E; border: none;">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
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

                        <button type="submit" class="btn btn-primary-modern btn-modern w-100 py-3">
                            Enviar link
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
