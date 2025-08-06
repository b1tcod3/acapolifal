@extends('layouts.app')

@section('content')
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
@endsection