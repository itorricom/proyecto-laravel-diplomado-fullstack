<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $producto->nombre }} | Sistema Laravel</title>

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
        <main class="py-10 overflow-auto">
            <div class="px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('productos.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $producto->nombre }}</h1>
                            <p class="mt-2 text-sm text-gray-700">Detalles del producto</p>
                        </div>
                    </div>
                </div>

                <!-- Product Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 sm:p-8">
                        <!-- Product Image -->
                        <div class="md:col-span-1">
                            <div class="bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg aspect-square flex items-center justify-center overflow-hidden">
                                <svg class="h-32 w-32 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                            </div>
                            <div class="mt-4">
                                @if($producto->estado == 'A')
                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-800">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-800">
                                        Inactivo
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="md:col-span-2">
                            <div class="space-y-4">
                                <!-- Precio -->
                                <div class="pb-4 border-b border-gray-200">
                                    <p class="text-sm text-gray-500 uppercase tracking-wide">Precio</p>
                                    <p class="text-4xl font-bold text-gray-900 mt-1">
                                        ${{ number_format($producto->precio, 2) }}
                                    </p>
                                </div>

                                <!-- Categoría -->
                                <div class="pb-4 border-b border-gray-200">
                                    <p class="text-sm text-gray-500 uppercase tracking-wide">Categoría</p>
                                    <p class="text-lg font-semibold text-gray-900 mt-1">
                                        {{ $producto->categoria ?? 'Sin categoría' }}
                                    </p>
                                </div>

                                <!-- Stock -->
                                <div class="pb-4 border-b border-gray-200">
                                    <p class="text-sm text-gray-500 uppercase tracking-wide">Stock</p>
                                    <div class="flex items-baseline gap-2 mt-1">
                                        <p class="text-2xl font-bold text-gray-900">{{ $producto->stock }}</p>
                                        <p class="text-sm text-gray-500">unidades disponibles</p>
                                    </div>
                                </div>

                                <!-- Descripción -->
                                @if($producto->descripcion)
                                <div class="pb-4 border-b border-gray-200">
                                    <p class="text-sm text-gray-500 uppercase tracking-wide">Descripción</p>
                                    <p class="text-gray-900 mt-2 leading-relaxed">{{ $producto->descripcion }}</p>
                                </div>
                                @endif

                                <!-- Fechas -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500 uppercase tracking-wide">Creado</p>
                                        <p class="text-sm font-semibold text-gray-900 mt-1">
                                            {{ $producto->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 uppercase tracking-wide">Última actualización</p>
                                        <p class="text-sm font-semibold text-gray-900 mt-1">
                                            {{ $producto->updated_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="border-t border-gray-200 px-6 py-4 sm:px-8 flex justify-end gap-4 bg-gray-50">
                        <a href="{{ route('productos.index') }}" class="rounded-lg border border-gray-300 px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-colors">
                            Volver
                        </a>
                        <a href="{{ route('productos.edit', $producto->id) }}" class="rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:from-indigo-700 hover:to-purple-700 transition-all transform hover:scale-105">
                            Editar Producto
                        </a>
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg bg-red-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-700 transition-colors">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
