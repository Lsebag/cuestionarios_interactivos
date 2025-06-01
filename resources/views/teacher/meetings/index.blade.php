<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Sesiones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Botón para crear nueva sesión --}}
            <a href="{{ route('teacher.meetings.create') }}" class="btn btn-success mb-4">Crear Sesión</a>

            {{-- Lista de sesiones existentes --}}
            @forelse($meetings as $meeting)
                <div class="bg-white shadow-md rounded-lg p-6 mb-4">
                    <h3 class="text-lg font-semibold">{{ $meeting->meeting_name ?? 'Sesión sin nombre' }}</h3>
                    <p class="text-gray-600">Código de acceso: <strong>{{ $meeting->access_code }}</strong></p>
                    <p class="text-gray-500">Estado: {{ $meeting->status }}</p>
                    <p class="text-sm text-gray-500">Cuestionario: {{ $meeting->quiz->title ?? 'N/A' }}</p>
                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('teacher.meetings.show', $meeting->id) }}" class="btn btn-primary btn-sm">Ver Detalles</a>
                        {{-- Puedes agregar más botones como iniciar sesión, eliminar, etc. --}}
                    </div>
                </div>
            @empty
                <p class="text-gray-600">Aún no has creado ninguna sesión.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
