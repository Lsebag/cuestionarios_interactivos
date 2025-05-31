<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Cuestionario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('teacher.quizzes.update', $quiz) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="block font-medium text-sm text-gray-700">Título</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $quiz->title) }}" class="form-input mt-1 block w-full" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block font-medium text-sm text-gray-700">Descripción</label>
                        <textarea name="description" id="description" rows="4" class="form-input mt-1 block w-full">{{ old('description', $quiz->description) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar Cuestionario</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
