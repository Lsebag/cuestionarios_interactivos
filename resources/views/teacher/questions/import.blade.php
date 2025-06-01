<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Importar Preguntas al Cuestionario: ') . $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('teacher.questions.storeImport', $quiz) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="gift_file" class="block text-sm font-medium text-gray-700">Archivo GIFT (.txt)</label>
                        <input type="file" name="gift_file" id="gift_file" class="mt-1 block w-full" accept=".txt" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Importar Preguntas</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
