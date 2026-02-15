@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold mb-1">Bem-vindo, {{ Auth::user()->name }}!</h4>
            <p class="text-muted small">Aqui está um resumo do que você pode fazer.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4 text-center">
                    <div class="bg-primary rounded-circle p-3 d-inline-flex mb-3 shadow-sm" style="width: 60px; height: 60px; align-items: center; justify-content: center;">
                        <i class="fas fa-address-book text-white fa-lg"></i>
                    </div>
                    <h5 class="fw-bold">Contatos</h5>
                    <p class="text-muted small">Gerencie sua lista de contatos, adicione novos ou edite os existentes.</p>
                    <a href="{{ route('contacts.index') }}" class="btn btn-outline-primary btn-sm px-4">Ir para Contatos</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4 text-center">
                    <div class="bg-indigo rounded-circle p-3 d-inline-flex mb-3 shadow-sm" style="width: 60px; height: 60px; align-items: center; justify-content: center; background-color: #6366f1;">
                        <i class="fas fa-tasks text-white fa-lg"></i>
                    </div>
                    <h5 class="fw-bold">Tarefas</h5>
                    <p class="text-muted small">Organize seu dia com nossa lista de tarefas pendentes.</p>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-primary btn-sm px-4">Ir para Tarefas</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
