<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nueva Sesión') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('teacher.meetings.store') }}">
                    @csrf

                    {{-- Nombre de la sesión --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="meeting_name">Nombre de la sesión</label>
                        <input id="meeting_name" type="text" name="meeting_name" class="form-input w-full" value="{{ old('meeting_name') }}" required>
                    </div>

                    {{-- Selección de cuestionario --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="quiz_id">Seleccionar cuestionario</label>
                        <select id="quiz_id" name="quiz_id" class="form-select w-full" required>
                            <option value="">-- Selecciona un cuestionario --</option>
                            @foreach($quizzes as $quiz)
                                <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary">Crear Sesión</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
