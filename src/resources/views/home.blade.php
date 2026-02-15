@extends('layouts.app')

@section('header_title', 'Dashboard')
@section('content')
    <div class="container-fluid p-0">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card-modern p-4 text-center">
                    <div class="bg-primary-light rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; background: var(--primary-light);">
                        <i class="fas fa-address-book fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Contatos</h5>
                    <p class="text-muted small">Gerencie sua lista de contatos de forma simples.</p>
                    <a href="{{ route('contacts.index') }}" class="btn btn-outline-modern btn-modern">Acessar Contatos</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-modern p-4 text-center">
                    <div class="bg-success-light rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; background: #e3fcef;">
                        <i class="fas fa-tasks fa-2x text-success"></i>
                    </div>
                    <h5 class="fw-bold">Tarefas</h5>
                    <p class="text-muted small">Organize suas tarefas e acompanhe prazos.</p>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-modern btn-modern">Acessar Tarefas</a>
                </div>
            </div>
        </div>
    </div>
@endsection
