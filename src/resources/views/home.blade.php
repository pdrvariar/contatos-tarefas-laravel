@extends('layouts.app')

@section('header_title', 'Dashboard')
@section('content')
    <div class="container-fluid p-0">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card-modern p-4 text-center">
                    <div class="rounded-3 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; background: #e0e7ff; color: var(--primary); box-shadow: 0 8px 15px rgba(99, 102, 241, 0.2);">
                        <i class="fas fa-address-book fa-2x"></i>
                    </div>
                    <h5 class="fw-bold" style="color: var(--text-primary);">Contatos</h5>
                    <p class="text-muted small">Gerencie sua lista de contatos de forma simples e organizada.</p>
                    <a href="{{ route('contacts.index') }}" class="btn btn-outline-modern btn-modern">Acessar Contatos</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-modern p-4 text-center">
                    <div class="rounded-3 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; background: #ffe4e6; color: var(--accent); box-shadow: 0 8px 15px rgba(244, 63, 94, 0.2);">
                        <i class="fas fa-tasks fa-2x"></i>
                    </div>
                    <h5 class="fw-bold" style="color: var(--text-primary);">Tarefas</h5>
                    <p class="text-muted small">Organize suas tarefas diárias e acompanhe seus prazos.</p>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-modern btn-modern">Acessar Tarefas</a>
                </div>
            </div>
        </div>
    </div>
@endsection
