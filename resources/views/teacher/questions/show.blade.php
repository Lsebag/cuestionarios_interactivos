<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Preguntas del Cuestionario: ') . $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @foreach($quiz->questions as $question)
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-lg text-gray-800 mb-2">🔹 {{ $question->text }}</h3>

                    <ul class="list-disc pl-6 text-gray-700">
                        @foreach($question->options as $option)
                            <li @if($option->is_correct) class="font-bold text-green-600" @endif>
                                {{ $option->text }}
                                @if($option->is_correct)
                                    <span class="text-sm text-green-500">(correcta)</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            <div class="mt-6">
                <a href="{{ route('teacher.quizzes.index') }}" class="btn btn-secondary">⬅️ Volver a cuestionarios</a>
            </div>
        </div>
    </div>
</x-app-layout>
