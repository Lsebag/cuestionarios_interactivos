<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Sala de espera para: {{ $meeting->meeting_name }}
        </h2>
    </x-slot>

   <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow text-center">
            <p class="text-lg">Esperando a que el profesor inicie la sesión...</p>
            <p class="mt-2 text-sm text-gray-500">Código: {{ $meeting->access_code }}</p>
        </div>
    </div>
    <script>
        Echo.channel('meeting.{{ $meeting->id }}')
            .listen('MeetingStarted', (e) => {
                // Redireccionar al estudiante a la vista donde responderá preguntas
                window.location.href = "{{ route('student.meetings.play', $meeting->access_code) }}";
            });
    </script>
</x-app-layout>
