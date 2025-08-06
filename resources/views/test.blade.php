<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Prueba de Livewire
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Prueba de Livewire
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Este es un componente de prueba para verificar que Livewire está funcionando correctamente.
                            </p>
                        </div>
                        <div class="border-t border-gray-200">
                            <div class="px-4 py-5 sm:p-6">
                                @livewire('test-component')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>