@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mis Cuestionarios</h1>

    <a href="{{ route('teacher.quizzes.create') }}" class="btn btn-success mb-3">Crear Cuestionario</a>

    @foreach($quizzes as $quiz)
        <div class="card mb-2">
            <div class="card-body">
                <h5>{{ $quiz->title }}</h5>
                <p>{{ $quiz->description }}</p>

                <a href="{{ route('teacher.quizzes.edit', $quiz) }}" class="btn btn-warning btn-sm">Editar</a>
                <a href="{{ route('teacher.questions.import', $quiz) }}" class="btn btn-info btn-sm">Cargar Preguntas</a>
            </div>
        </div>
    @endforeach
</div>
@endsection
