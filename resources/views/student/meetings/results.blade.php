<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Resultados de la sesión: {{ $meeting->meeting_name }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10">
        <div class="bg-white shadow p-6 rounded-lg">
            <h3 class="text-2xl font-semibold mb-6">Tus respuestas</h3>

            @foreach($meeting->quiz->questions as $question)
                <div class="mb-6">
                    <p class="font-medium">{{ $question->text }}</p>
                    <ul class="mt-2 space-y-1">
                        @foreach($question->options as $option)
                            @php
                                $userAnswer = $participation->answers->firstWhere('question_id', $question->id);
                                $isCorrect = $option->is_correct;
                                $isSelected = $userAnswer && $userAnswer->option_id == $option->id;
                            @endphp
                            <li class="@if($isSelected && $isCorrect) text-green-600 @elseif($isSelected) text-red-600 @endif">
                                @if($isSelected) ➤ @endif {{ $option->text }}
                                @if($isCorrect) <span class="text-sm text-green-500">(Correcta)</span> @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
