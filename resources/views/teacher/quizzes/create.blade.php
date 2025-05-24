@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Cuestionario</h1>

    <form action="{{ route('teacher.quizzes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('teacher.quizzes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
