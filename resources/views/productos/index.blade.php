<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Productos | Sistema Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full overflow-hidden flex">

    <!-- DESKTOP SIDEBAR -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gradient-to-b from-indigo-900 to-purple-900 px-6 pb-4">
            <div class="flex h-16 shrink-0 items-center">
                <div class="h-10 w-10 rounded-xl bg-white/10 flex items-center justify-center text-white font-bold shadow-lg">L</div>
                <span class="ml-3 text-white font-bold text-xl tracking-tight">Laravel App</span>
            </div>
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="-mx-2 space-y-1">
                            <li>
                                <a href="{{ route('dashboard') }}" class="text-indigo-50 hover:text-white hover:bg-indigo-700 group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-semibold transition-colors duration-200">
                                    <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('productos.index') }}" class="bg-indigo-700 text-white group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-semibold">
                                    <svg class="h-6 w-6 shrink-0 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                                    Productos
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="mt-auto">
                        <form method="GET" action="{{ route('logout') }}">
                            <button type="submit" class="group -mx-2 flex gap-x-3 rounded-lg p-2.5 text-sm font-semibold leading-6 text-indigo-50 hover:bg-indigo-700 hover:text-white w-full">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                                Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex flex-1 flex-col lg:pl-72">
        <!-- TOPBAR -->
        <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:px-6 lg:px-8">
            <div class="flex flex-1 gap-x-4 self-stretch">
                <div class="relative flex flex-1"></div>
                <div class="flex items-center gap-x-4">
                    <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200"></div>
                    <div class="flex items-center">
                        <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(session('data_session.nombre', 'Usuario')) }}&color=7F9CF5&background=EBF4FF" alt="">
                        <span class="ml-4 text-sm font-semibold text-gray-900">{{ session('data_session.nombre', 'Usuario') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN -->
        <main class="py-10">
            <div class="px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="sm:flex sm:items-center mb-8">
                    <div class="sm:flex-auto">
                        <h1 class="text-3xl font-bold text-gray-900">Productos</h1>
                        <p class="mt-2 text-sm text-gray-700">Listado completo de productos del sistema</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a href="{{ route('productos.create') }}" class="inline-flex items-center rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:from-indigo-700 hover:to-purple-700 transition-all transform hover:scale-105">
                            <svg class="-ml-0.5 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Nuevo Producto
                        </a>
                    </div>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                <div class="mb-6 rounded-lg bg-green-50 p-4 border border-green-200">
                    <div class="flex">
                        <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="ml-3 text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                <!-- Table -->
                @if($productos->count() > 0)
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-xl">
                    <table class="min-w-full divide-y divide-gray-300 bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Nombre</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Categoría</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Precio</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Stock</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Estado</th>
                                <th class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Acciones</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($productos as $producto)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                    {{ $producto->nombre }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <span class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800">
                                        {{ $producto->categoria ?? 'Sin categoría' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    ${{ number_format($producto->precio, 2) }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $producto->stock }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                    @if($producto->estado == 'A')
                                    <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Activo</span>
                                    @else
                                    <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">Inactivo</span>
                                    @endif
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <a href="{{ route('productos.show', $producto->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Ver</a>
                                    <a href="{{ route('productos.edit', $producto->id) }}" class="text-blue-600 hover:text-blue-900 mr-4">Editar</a>
                                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <!-- Empty State -->
                <div class="text-center rounded-xl border-2 border-dashed border-gray-300 p-12 bg-white">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No hay productos</h3>
                    <p class="mt-1 text-sm text-gray-500">Comienza creando tu primer producto.</p>
                    <div class="mt-6">
                        <a href="{{ route('productos.create') }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                            <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Nuevo Producto
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
