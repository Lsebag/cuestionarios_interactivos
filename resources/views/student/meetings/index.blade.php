<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sesiones en las que has participado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @forelse($meetings as $meeting)
                <div class="bg-white shadow-md rounded-lg p-6 mb-4">
                    <h3 class="text-lg font-semibold">{{ $meeting->meeting_name }}</h3>
                    <p class="text-gray-600">Cuestionario: {{ $meeting->quiz->title }}</p>
                    <p class="text-sm text-gray-500">Estado: {{ ucfirst($meeting->status) }}</p>
                </div>
            @empty
                <p>No has participado en ninguna sesión todavía.</p>
            @endforelse

            <a href="{{ route('student.joinMeetingForm') }}" class="btn btn-primary mt-4">Unirse a una sesión</a>
        </div>
    </div>
</x-app-layout>
