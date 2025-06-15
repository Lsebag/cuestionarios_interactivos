<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalles de la Sesión: {{ $meeting->meeting_name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <p><strong>Código de acceso:</strong> {{ $meeting->access_code }}</p>
            <p><strong>Estado:</strong> <span id="status">{{ $meeting->status }}</span></p>

{{--             <h3 class="mt-4 font-semibold">Participantes:</h3>
            <ul id="participants-list">
                @foreach($meeting->participants as $participant)
                    <li>{{ $participant->name }}</li>
                @endforeach
            </ul> --}}

            @if ($meeting->status === 'waiting')
                <form action="{{ route('teacher.meetings.start', $meeting) }}" method="POST">
                    @csrf
                    <button class="btn btn-primary mt-4">Comenzar Sesión</button>
                </form>
            @else
                <p class="mt-4 text-green-600">Sesión en curso</p>

                @php
                    $current = $meeting->currentQuestion;
                    $allQuestions = $meeting->quiz->questions;
                    $currentIndex = $allQuestions->search(fn($q) => $q->id === optional($current)->id);
                    $nextQuestion = $allQuestions->get($currentIndex + 1);
                @endphp

                @if ($current)
                    <div class="mt-6 bg-gray-100 p-6 rounded-lg shadow">
                        <h3 class="text-xl font-bold mb-4">Pregunta actual</h3>
                        <p class="text-lg font-semibold">{{ $current->text }}</p>

                        <ul class="mt-4 space-y-2">
                            @foreach ($current->options as $i => $option)
                                <li>
                                    <span class="font-bold">{{ chr(65 + $i) }}.</span> {{ $option->text }}
                                </li>
                            @endforeach
                        </ul>

                        @if ($nextQuestion)
                            <form method="POST" action="{{ route('teacher.show.question', [$meeting, $nextQuestion]) }}" class="mt-6">
                                @csrf
                                <button class="bg-blue-600 hover:bg-blue-700 text-black font-semibold px-4 py-2 rounded shadow">
                                    Siguiente pregunta
                                </button>
                            </form>
                        @else
                            <p class="mt-6 text-gray-600 italic">No hay más preguntas.</p>
                            <form method="POST" action="{{ route('teacher.finish.meeting', $meeting) }}" class="mt-6">
                                @csrf
                                <button class="bg-green-600 hover:bg-green-700 text-black font-bold px-4 py-2 rounded shadow">
                                    Visualizar resultados
                                </button>
                            </form>
                        @endif
                    </div>
                @else
                    <p class="mt-4 text-red-500 font-semibold">No hay pregunta actual asignada.</p>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
