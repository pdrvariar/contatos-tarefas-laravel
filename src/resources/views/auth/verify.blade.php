@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <div class="brand-icon mx-auto mb-3" style="width: 68px; height: 68px; font-size: 1.6rem; background: var(--primary); color: white; border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(30, 74, 122, 0.3);">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3 class="fw-bold" style="color: var(--text-primary);">Verifique seu e-mail</h3>
                    <p class="text-muted">Enviamos um link de verificação para o seu endereço de e-mail.</p>
                </div>

                <div class="card-modern p-4 p-md-5 text-center">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert" style="background: #E6F0FA; color: #0B2B5E; border: none;">
                            Um novo link de verificação foi enviado.
                        </div>
                    @endif

                    <p>Antes de continuar, verifique seu e-mail e clique no link de verificação.</p>
                    <p>Se você não recebeu o e-mail,</p>
                    <form method="POST" action="{{ route('verification.resend') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline" style="color: var(--primary); text-decoration: underline;">clique aqui para reenviar</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
