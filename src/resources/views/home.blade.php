@extends('layouts.app')

@section('header_title', 'Dashboard')
@section('content')
    <div class="container-fluid p-0">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card-modern p-4 text-center">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: rgba(43, 129, 140, 0.15);">
                        <i class="fas fa-address-book fa-2x" style="color: #2b818c;"></i>
                    </div>
                    <h5 class="fw-bold" style="color: #211c33;">Contatos</h5>
                    <p class="text-muted small">Gerencie sua lista de contatos de forma simples.</p>
                    <a href="{{ route('contacts.index') }}" class="btn btn-outline-modern btn-modern">Acessar Contatos</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-modern p-4 text-center">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: rgba(237, 40, 96, 0.15);">
                        <i class="fas fa-tasks fa-2x" style="color: #ed2860;"></i>
                    </div>
                    <h5 class="fw-bold" style="color: #211c33;">Tarefas</h5>
                    <p class="text-muted small">Organize suas tarefas e acompanhe prazos.</p>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-modern btn-modern">Acessar Tarefas</a>
                </div>
            </div>
        </div>
    </div>
@endsection
