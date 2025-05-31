<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Cuestionarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('teacher.quizzes.create') }}" class="btn btn-success mb-4">Crear Cuestionario</a>

            @foreach($quizzes as $quiz)
                <div class="bg-white shadow-md rounded-lg p-6 mb-4">
                    <h3 class="text-lg font-semibold">{{ $quiz->title }}</h3>
                    <p class="text-gray-600">{{ $quiz->description }}</p>
                    <div class="mt-3">
                        <a href="{{ route('teacher.quizzes.edit', $quiz) }}" class="btn btn-warning btn-sm">Editar</a>
                        <a href="{{ route('teacher.questions.import', $quiz) }}" class="btn btn-info btn-sm">Cargar Preguntas</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
