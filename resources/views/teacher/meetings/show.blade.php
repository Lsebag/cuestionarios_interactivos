<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles de la Sesión') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-2xl font-semibold mb-4">{{ $meeting->meeting_name }}</h3>

                <p><strong>Código de acceso:</strong> {{ $meeting->access_code }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($meeting->status) }}</p>
                <p><strong>Cuestionario:</strong> {{ $meeting->quiz->title }}</p>

                <div class="mt-6">
                    <a href="{{ route('teacher.meetings.index') }}" class="btn btn-secondary">Volver a sesiones</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
