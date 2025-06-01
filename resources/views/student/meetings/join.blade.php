<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Unirse a una Sesión') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('student.join') }}">
                @csrf
                <label class="block mb-2">
                    Código de acceso:
                    <input type="text" name="access_code" class="border rounded w-full p-2 mt-1" required>
                </label>
                <button type="submit" class="btn btn-primary rounded">
                    Unirse
                </button>
            </form>
        </div>
    </div>

</x-app-layout>
