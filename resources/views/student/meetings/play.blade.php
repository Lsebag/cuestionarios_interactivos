<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $meeting->quiz->title }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-12">
            @if(session('success'))
                <div class="mb-4 text-green-600 font-semibold text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 text-red-600 font-semibold text-center">
                    {{ session('error') }}
                </div>
            @endif
        <div class="text-center mb-8">
            <h3 class="text-2xl font-bold mb-4">Seleccione la respuesta correcta:</h3>
        </div>

        @php
            $question = $meeting->currentQuestion;
        @endphp

        @if ($question)
            <div class="grid grid-cols-2 gap-6">
            @php $letters = ['A','B','C','D']; @endphp
            @foreach ($letters as $index => $letter)
                <form method="POST" action="{{ route('student.answer') }}">
                    @csrf
                    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                    <input type="hidden" name="choice" value="{{ $index }}"> {{-- 0‑3 --}}
                    <button
                        type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 font-semibold py-6 px-4 rounded-2xl text-xl shadow-lg">
                        Opción {{ $letter }}
                    </button>
                </form>
            @endforeach
            </div>
        @else
            <div class="text-center text-red-500 font-semibold mt-6">
                No hay pregunta activa en este momento.
            </div>
        @endif
    </div>
    <div class="mt-8 text-center">
        <div class="text-center text-black-500 mt-6">
            Cuando el profesor finalice la sesión podrá hacer click en el siguiente botón para revisar sus respuestas:
        </div>
        <a href="{{ route('student.results', ['meeting' => $meeting->id]) }}"
        class="bg-green-600 text-black font-bold py-2 px-4 rounded hover:bg-green-700">
            Visualizar Resultados
        </a>
    </div>
</x-app-layout>
