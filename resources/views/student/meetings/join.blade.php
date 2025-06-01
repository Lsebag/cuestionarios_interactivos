<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Unirse a una Sesión') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('student.joinMeeting') }}">
                @csrf

                <div class="mb-4">
                    <label for="access_code" class="block text-sm font-medium text-gray-700">Código de acceso</label>
                    <input type="text" name="access_code" id="access_code" class="form-input mt-1 block w-full" required>
                </div>

                <button type="submit" class="btn btn-primary">Unirse</button>
            </form>
        </div>
    </div>
</x-app-layout>
