<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sala de espera') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mt-4">
                        <h3> Esperando al profesor para iniciar </h3>
                        <div id="status">Estado: Esperando</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        Echo.channel('meeting.{{ $meeting->id }}')
            .listen('MeetingStarted', (e) => {
                document.getElementById('status').innerText = '¡Sesión iniciada!';
                window.location.href = `/quiz/live/{{ $meeting->code }}`;
            });
    </script>
</x-app-layout>
