<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Resultados: {{ $meeting->meeting_name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            @foreach ($questions as $index => $question)
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-2">{{ $index + 1 }}. {{ $question->text }}</h3>
                    <ul class="space-y-1">
                        @foreach ($question->options as $option)
                            @php
                                $count = $option->answers->where('participation.meeting_id', $meeting->id)->count();
                                $isCorrect = $option->is_correct;
                            @endphp
                            <li class="px-3 py-2 rounded @if($isCorrect) bg-green-100 @else bg-gray-100 @endif">
                                <span class="font-bold">{{ $option->text }}</span>
                                - {{ $count }} respuesta(s)
                                @if ($isCorrect)
                                    <span class="text-green-600 font-semibold ml-2">(Correcta)</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
