<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} - FECOER
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">
                        Bienvenido, {{ Auth::user()->name }}
                    </h3>

                    <p class="text-sm text-gray-600 mb-6">
                        Rol:
                        @foreach(Auth::user()->roles as $role)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($role->name === 'admin') bg-red-100 text-red-800
                                @elseif($role->name === 'editor') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($role->name) }}
                            </span>
                        @endforeach
                    </p>

                    {{-- Cards resumen según permisos --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @can('registros.index')
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="font-semibold text-blue-800">Registros</h4>
                            <p class="text-2xl font-bold text-blue-600">0</p>
                            <p class="text-sm text-blue-500">Asistentes registrados</p>
                        </div>
                        @endcan

                        @can('boletas.index')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <h4 class="font-semibold text-green-800">Boletas</h4>
                            <p class="text-2xl font-bold text-green-600">0</p>
                            <p class="text-sm text-green-500">Boletas vendidas</p>
                        </div>
                        @endcan

                        @can('donaciones.index')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <h4 class="font-semibold text-yellow-800">Donaciones</h4>
                            <p class="text-2xl font-bold text-yellow-600">$0</p>
                            <p class="text-sm text-yellow-500">Total recaudado</p>
                        </div>
                        @endcan

                        @can('contactos.index')
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                            <h4 class="font-semibold text-purple-800">Contactos</h4>
                            <p class="text-2xl font-bold text-purple-600">0</p>
                            <p class="text-sm text-purple-500">Mensajes recibidos</p>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>