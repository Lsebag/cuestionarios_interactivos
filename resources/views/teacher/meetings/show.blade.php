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
                    <button class="btn btn-primary mt-4">Iniciar Sesión</button>
                </form>
            @else
                <p class="mt-4 text-green-600">Sesión en curso</p>
                <div class="mt-6">
                    <h3 class="text-lg font-bold mb-2">Preguntas del cuestionario</h3>

                    @foreach ($meeting->quiz->questions as $question)
                        <div class="mb-4">
                            <p class="font-semibold">{{ $question->text }}</p>
                            <ul class="list-disc ml-5">
                                @foreach ($question->options as $option)
                                    <li>{{ $option->text }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        Echo.channel('meeting.{{ $meeting->id }}')
            .listen('StudentJoined', (e) => {
                const ul = document.getElementById('participants-list');
                const li = document.createElement('li');
                li.textContent = e.user.name;
                ul.appendChild(li);
            })
            .listen('MeetingStarted', (e) => {
                document.getElementById('status').innerText = 'started';
            });
    </script>
</x-app-layout>
