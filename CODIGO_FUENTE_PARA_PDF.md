# CÓDIGO FUENTE PARA EL PDF - SISTEMA LOGIN + CRUD PRODUCTOS

## ESTRUCTURA DEL DOCUMENTO
### PARTE 1: SISTEMA DE LOGIN
### PARTE 2: CRUD DE PRODUCTOS
### PARTE 3: API REST (Servicio Web)
### PARTE 4: CAPTURAS DE PANTALLA

---

# ✅ PARTE 1: SISTEMA DE LOGIN

## 1.1 Configuración de Autenticación (config/auth.php)

Mostrar SOLO esta sección:

```php
<?php

return [
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\Usuario::class),
        ],
    ],
];
```

---

## 1.2 Modelo Usuario (app/Models/Usuario.php)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = "usuarios";
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    protected $fillable = [
        "username",
        "email",
        "password",
        "nombre",
        "estado",
        "ultimo_acceso",
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'ultimo_acceso' => 'datetime',
    ];
}
```

---

## 1.3 Middleware Personalizado (app/Http/Middleware/VerifySession.php)

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifySession
{
    /**
     * Verifica que el usuario tenga una sesión activa
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->session()->exists('data_session')) {
            return redirect('/login');
        }
        return $next($request);
    }
}
```

---

## 1.4 Registro del Middleware (bootstrap/app.php)

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'verify' => \App\Http\Middleware\VerifySession::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
```

---

## 1.5 Controlador de Usuarios (app/Http/Controllers/UsuarioController.php)

MOSTRAR COMPLETO - Mostra principalmente:
- login() - Retorna la vista de login
- verificarLogin() - Valida credenciales contra la BD
- logout() - Cierra sesión y limpia sesión
- dashboard() - Página protegida

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function verificarLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credenciales = [
            'email' => $request->email,
            'password' => $request->password,
            'estado' => 'A',
        ];

        if(Auth::guard('web')->attempt($credenciales)){
            $usuario = Auth::user();
            
            // Actualizar último acceso
            Usuario::where('id', $usuario->id)->update([
                'ultimo_acceso' => now()
            ]);

            // Crear sesión personalizada
            $data_session = [
                'status' => true,
                'nombre' => $usuario->nombre ?? $usuario->username,
                'email' => $usuario->email,
                'mensaje' => 'Bienvenido al sistema',
            ];

            Session::put('data_session', $data_session);

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas o el usuario está inactivo.',
        ])->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
```

---

## 1.6 Rutas (routes/web.php)

MOSTRAR COMPLETO - Explicar:
- Ruta raíz redirige a login
- Rutas públicas de autenticación (login, verificar, logout)
- Rutas protegidas con middleware 'verify'

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;

// Ruta principal redirige al login
Route::get('/', function () {
    return redirect('/login');
});

// Rutas de autenticación (públicas)
Route::get('/login', [UsuarioController::class, 'login'])->name('login');
Route::post('/login', [UsuarioController::class, 'verificarLogin'])->name('login.verificar');
Route::get('/logout', [UsuarioController::class, 'logout'])->name('logout');

// Rutas protegidas por middleware 'verify'
Route::middleware('verify')->group(function () {
    Route::get('/dashboard', [UsuarioController::class, 'dashboard'])->name('dashboard');
    Route::resource('productos', ProductoController::class);
});
```

---

## 1.7 Vista de Login (resources/views/auth/login.blade.php)

MOSTRAR LA ESTRUCTURA HTML (puedes resumir el CSS Tailwind)

Mostrar:
- Estructura HTML
- Validación de errores
- Formulario con @csrf
- Integración de Vite para Tailwind CSS

```html
<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex flex-col justify-center py-12 bg-gradient-to-br from-indigo-50 via-white to-purple-50">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="mx-auto h-16 w-16 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-xl">
            <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <h2 class="mt-6 text-center text-3xl font-bold text-gray-900">
            Bienvenido de nuevo
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl rounded-2xl">
            <form action="{{ route('login.verificar') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Correo Electrónico
                    </label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        required 
                        value="{{ old('email') }}"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
                        placeholder="ejemplo@correo.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Contraseña
                    </label>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        required
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-500 @enderror"
                        placeholder="••••••••">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-2.5 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition">
                    Iniciar Sesión
                </button>
            </form>
        </div>
    </div>
</body>
</html>
```

---

# ✅ PARTE 2: CRUD DE PRODUCTOS

## 2.1 Modelo Producto (app/Models/Producto.php)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria',
        'imagen',
        'estado',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'id' => 'integer',
    ];

    protected $attributes = [
        'imagen' => 'producto-default.jpg',
        'estado' => 'A',
        'stock' => 0,
    ];
}
```

---

## 2.2 Controlador de Productos (app/Http/Controllers/ProductoController.php)

MOSTRAR COMPLETO - Explicar cada método:
- index() - Lista todos los productos
- create() - Formulario de creación
- store() - Guarda en BD
- show() - Detalle del producto
- edit() - Formulario de edición
- update() - Actualiza en BD
- destroy() - Elimina de BD

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Listar todos los productos
     */
    public function index()
    {
        $productos = Producto::orderBy('created_at', 'desc')->get();
        return view('productos.index', compact('productos'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Guardar producto en la base de datos
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria' => 'nullable|string|max:100',
            'estado' => 'required|in:A,I'
        ]);

        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria' => $request->categoria,
            'estado' => $request->estado,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Mostrar un producto específico
     */
    public function show(string $id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    /**
     * Actualizar producto en la base de datos
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria' => 'nullable|string|max:100',
            'estado' => 'required|in:A,I'
        ]);

        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria' => $request->categoria,
            'estado' => $request->estado,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Eliminar producto
     */
    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
```

---

## 2.3 Rutas en routes/web.php

YA MOSTRADO EN PUNTO 1.6 - Destacar esta línea:

```php
Route::resource('productos', ProductoController::class);
```

Esta línea genera automáticamente 7 rutas CRUD:
- GET /productos (index)
- GET /productos/create (create)
- POST /productos (store)
- GET /productos/{id} (show)
- GET /productos/{id}/edit (edit)
- PUT/PATCH /productos/{id} (update)
- DELETE /productos/{id} (destroy)

---

## 2.4 Vistas del CRUD

### Vista de Listado (resources/views/productos/index.blade.php)

Mostrar la estructura principal:

```html
<div class="flex flex-1 flex-col lg:pl-72">
    <!-- TOPBAR -->
    <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm">
        <span class="ml-4 text-sm font-semibold text-gray-900">{{ session('data_session.nombre', 'Usuario') }}</span>
    </div>

    <!-- MAIN CONTENT -->
    <main class="py-10">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Productos</h1>
                <a href="{{ route('productos.create') }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 text-white font-semibold hover:bg-indigo-700">
                    <svg class="-ml-0.5 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Nuevo Producto
                </a>
            </div>

            @if($productos->count() > 0)
            <table class="min-w-full divide-y divide-gray-300 bg-white rounded-xl shadow">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Nombre</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Categoría</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Precio</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Stock</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Estado</th>
                        <th class="relative py-3.5 pl-3 pr-4 sm:pr-6">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($productos as $producto)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900">{{ $producto->nombre }}</td>
                        <td class="px-3 py-4 text-sm text-gray-500">{{ $producto->categoria ?? 'Sin categoría' }}</td>
                        <td class="px-3 py-4 text-sm text-gray-500">${{ number_format($producto->precio, 2) }}</td>
                        <td class="px-3 py-4 text-sm text-gray-500">{{ $producto->stock }}</td>
                        <td class="px-3 py-4 text-sm">
                            <span class="inline-flex rounded-full {{ $producto->estado == 'A' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-2 py-1 text-xs font-semibold">
                                {{ $producto->estado == 'A' ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="py-4 pl-3 pr-4 text-right text-sm font-medium">
                            <a href="{{ route('productos.show', $producto->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Ver</a>
                            <a href="{{ route('productos.edit', $producto->id) }}" class="text-blue-600 hover:text-blue-900 mr-4">Editar</a>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </main>
</div>
```

### Vista de Crear/Editar (resources/views/productos/create.blade.php y edit.blade.php)

Mostrar estructura del formulario:

```html
<form action="{{ route('productos.store') }}" method="POST" class="p-6 sm:p-8">
    @csrf
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <!-- Nombre -->
        <div class="sm:col-span-2">
            <label for="nombre" class="block text-sm font-semibold text-gray-900 mb-2">
                Nombre del Producto *
            </label>
            <input 
                type="text" 
                id="nombre" 
                name="nombre" 
                value="{{ old('nombre') }}"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror"
                placeholder="Ej: Laptop Dell XPS 15">
            @error('nombre')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Descripción -->
        <div class="sm:col-span-2">
            <label for="descripcion" class="block text-sm font-semibold text-gray-900 mb-2">
                Descripción
            </label>
            <textarea 
                id="descripcion" 
                name="descripcion"
                rows="4"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                {{ old('descripcion') }}
            </textarea>
        </div>

        <!-- Precio -->
        <div>
            <label for="precio" class="block text-sm font-semibold text-gray-900 mb-2">
                Precio *
            </label>
            <input 
                type="number" 
                id="precio" 
                name="precio"
                value="{{ old('precio') }}"
                step="0.01"
                min="0"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Stock -->
        <div>
            <label for="stock" class="block text-sm font-semibold text-gray-900 mb-2">
                Stock *
            </label>
            <input 
                type="number" 
                id="stock" 
                name="stock"
                value="{{ old('stock', 0) }}"
                min="0"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Categoría -->
        <div>
            <label for="categoria" class="block text-sm font-semibold text-gray-900 mb-2">
                Categoría
            </label>
            <input 
                type="text" 
                id="categoria" 
                name="categoria"
                value="{{ old('categoria') }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Estado -->
        <div>
            <label for="estado" class="block text-sm font-semibold text-gray-900 mb-2">
                Estado *
            </label>
            <select 
                id="estado" 
                name="estado"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Selecciona un estado</option>
                <option value="A">Activo</option>
                <option value="I">Inactivo</option>
            </select>
        </div>
    </div>

    <!-- Buttons -->
    <div class="mt-8 flex justify-end gap-4">
        <a href="{{ route('productos.index') }}" class="rounded-lg border border-gray-300 px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
            Cancelar
        </a>
        <button 
            type="submit"
            class="rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-2.5 text-sm font-semibold text-white hover:from-indigo-700 hover:to-purple-700">
            Guardar
        </button>
    </div>
</form>
```

### Vista de Detalle (resources/views/productos/show.blade.php)

Mostrar la estructura:

```html
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
    <!-- Imagen del Producto -->
    <div class="bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg aspect-square flex items-center justify-center">
        <svg class="h-32 w-32 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632..." />
        </svg>
    </div>

    <!-- Detalles -->
    <div class="md:col-span-2 space-y-4">
        <h1 class="text-3xl font-bold text-gray-900">{{ $producto->nombre }}</h1>
        
        <div class="pb-4 border-b border-gray-200">
            <p class="text-4xl font-bold text-gray-900">${{ number_format($producto->precio, 2) }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Categoría</p>
            <p class="text-lg font-semibold text-gray-900">{{ $producto->categoria ?? 'Sin categoría' }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Stock</p>
            <p class="text-2xl font-bold text-gray-900">{{ $producto->stock }} unidades</p>
        </div>

        @if($producto->descripcion)
        <div>
            <p class="text-sm text-gray-500">Descripción</p>
            <p class="text-gray-900 mt-2">{{ $producto->descripcion }}</p>
        </div>
        @endif
    </div>
</div>

<!-- Acciones -->
<div class="border-t border-gray-200 px-6 py-4 flex justify-end gap-4 bg-gray-50">
    <a href="{{ route('productos.index') }}" class="rounded-lg border border-gray-300 px-6 py-2.5 text-gray-700 hover:bg-gray-100">
        Volver
    </a>
    <a href="{{ route('productos.edit', $producto->id) }}" class="rounded-lg bg-indigo-600 px-6 py-2.5 text-white hover:bg-indigo-700">
        Editar
    </a>
    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="rounded-lg bg-red-600 px-6 py-2.5 text-white hover:bg-red-700">
            Eliminar
        </button>
    </form>
</div>
```

---

# ✅ PARTE 3: API REST (SERVICIO WEB)

## 3.1 Controlador API (app/Http/Controllers/Api/ProductoApiController.php)

MOSTRAR COMPLETO - Explicar:
- index() - Lista todos los productos en JSON
- show() - Obtiene un producto específico
- store() - Crea un nuevo producto con validación
- update() - Actualiza un producto (PUT y PATCH)
- destroy() - Elimina un producto
- Manejo de errores con try-catch
- Respuestas estandarizadas en JSON

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductoApiController extends Controller
{
    /**
     * GET /api/productos
     * Listar todos los productos
     */
    public function index()
    {
        try {
            $productos = Producto::orderBy('created_at', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Productos obtenidos correctamente',
                'data' => $productos,
                'count' => $productos->count()
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener productos',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * GET /api/productos/{id}
     * Mostrar un producto específico
     */
    public function show($id)
    {
        try {
            $producto = Producto::find($id);
            
            if (!$producto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no encontrado'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'message' => 'Producto obtenido correctamente',
                'data' => $producto
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el producto',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * POST /api/productos
     * Crear un nuevo producto
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'precio' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'categoria' => 'nullable|string|max:100',
                'estado' => 'required|in:A,I'
            ], [
                'nombre.required' => 'El nombre del producto es obligatorio',
                'nombre.max' => 'El nombre no puede exceder 255 caracteres',
                'precio.required' => 'El precio es obligatorio',
                'precio.numeric' => 'El precio debe ser un número',
                'precio.min' => 'El precio no puede ser negativo',
                'stock.required' => 'El stock es obligatorio',
                'stock.integer' => 'El stock debe ser un número entero',
                'stock.min' => 'El stock no puede ser negativo',
                'estado.required' => 'El estado es obligatorio',
                'estado.in' => 'El estado debe ser A (Activo) o I (Inactivo)'
            ]);

            $producto = Producto::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'stock' => $request->stock,
                'categoria' => $request->categoria,
                'estado' => $request->estado,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Producto creado exitosamente',
                'data' => $producto
            ], Response::HTTP_CREATED);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el producto',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * PUT/PATCH /api/productos/{id}
     * Actualizar un producto
     */
    public function update(Request $request, $id)
    {
        try {
            $producto = Producto::find($id);
            
            if (!$producto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no encontrado'
                ], Response::HTTP_NOT_FOUND);
            }

            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'precio' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'categoria' => 'nullable|string|max:100',
                'estado' => 'required|in:A,I'
            ], [
                'nombre.required' => 'El nombre del producto es obligatorio',
                'precio.numeric' => 'El precio debe ser un número',
                'stock.integer' => 'El stock debe ser un número entero',
                'estado.in' => 'El estado debe ser A o I'
            ]);

            $producto->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'stock' => $request->stock,
                'categoria' => $request->categoria,
                'estado' => $request->estado,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado exitosamente',
                'data' => $producto
            ], Response::HTTP_OK);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el producto',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * DELETE /api/productos/{id}
     * Eliminar un producto
     */
    public function destroy($id)
    {
        try {
            $producto = Producto::find($id);
            
            if (!$producto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no encontrado'
                ], Response::HTTP_NOT_FOUND);
            }

            $producto->delete();

            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado exitosamente',
                'data' => $producto
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el producto',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
```

---

## 3.2 Rutas API (routes/api.php)

MOSTRAR COMPLETO - Explicar:
- Prefix /api para todos los endpoints
- 6 rutas CRUD (GET, POST, GET {id}, PUT {id}, PATCH {id}, DELETE {id})
- Middleware 'api' aplicado a todos

```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductoApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('api')->group(function () {
    // API de Productos (CRUD RESTful)
    Route::prefix('productos')->group(function () {
        Route::get('/', [ProductoApiController::class, 'index'])->name('api.productos.index');
        Route::post('/', [ProductoApiController::class, 'store'])->name('api.productos.store');
        Route::get('{id}', [ProductoApiController::class, 'show'])->name('api.productos.show');
        Route::put('{id}', [ProductoApiController::class, 'update'])->name('api.productos.update');
        Route::patch('{id}', [ProductoApiController::class, 'update'])->name('api.productos.patch');
        Route::delete('{id}', [ProductoApiController::class, 'destroy'])->name('api.productos.destroy');
    });
});
```

---

## 3.3 Ejemplos de Requests y Responses

### GET /api/productos (Listar todos)

**Request:**
```bash
curl -X GET http://localhost:8000/api/productos \
  -H "Accept: application/json"
```

**Response (200 - OK):**
```json
{
  "success": true,
  "message": "Productos obtenidos correctamente",
  "data": [
    {
      "id": 1,
      "nombre": "Laptop Dell XPS 15",
      "descripcion": "Laptop profesional de alta gama...",
      "precio": "1299.99",
      "stock": 10,
      "categoria": "Electrónica",
      "imagen": "producto-default.jpg",
      "estado": "A",
      "created_at": "2026-02-19T00:25:51.000000Z",
      "updated_at": "2026-02-19T00:25:51.000000Z"
    },
    {
      "id": 2,
      "nombre": "Mouse Logitech MX Master 3",
      "descripcion": "Mouse profesional inalámbrico...",
      "precio": "99.99",
      "stock": 25,
      "categoria": "Accesorios",
      "imagen": "producto-default.jpg",
      "estado": "A",
      "created_at": "2026-02-19T00:25:51.000000Z",
      "updated_at": "2026-02-19T00:25:51.000000Z"
    }
  ],
  "count": 2
}
```

---

### POST /api/productos (Crear producto)

**Request:**
```bash
curl -X POST http://localhost:8000/api/productos \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "nombre": "Monitor LG 27\" 4K",
    "descripcion": "Monitor IPS con resolución 4K",
    "precio": 399.99,
    "stock": 8,
    "categoria": "Electrónica",
    "estado": "A"
  }'
```

**Response (201 - Created):**
```json
{
  "success": true,
  "message": "Producto creado exitosamente",
  "data": {
    "nombre": "Monitor LG 27\" 4K",
    "descripcion": "Monitor IPS con resolución 4K",
    "precio": "399.99",
    "stock": 8,
    "categoria": "Electrónica",
    "estado": "A",
    "updated_at": "2026-02-19T00:35:00.000000Z",
    "created_at": "2026-02-19T00:35:00.000000Z",
    "id": 9
  }
}
```

**Response (422 - Validation Error):**
```json
{
  "success": false,
  "message": "Error de validación",
  "errors": {
    "nombre": [
      "El nombre del producto es obligatorio"
    ],
    "precio": [
      "El precio debe ser un número"
    ]
  }
}
```

---

### GET /api/productos/{id} (Obtener uno)

**Request:**
```bash
curl -X GET http://localhost:8000/api/productos/1 \
  -H "Accept: application/json"
```

**Response (200 - OK):**
```json
{
  "success": true,
  "message": "Producto obtenido correctamente",
  "data": {
    "id": 1,
    "nombre": "Laptop Dell XPS 15",
    "descripcion": "Laptop profesional...",
    "precio": "1299.99",
    "stock": 10,
    "categoria": "Electrónica",
    "imagen": "producto-default.jpg",
    "estado": "A",
    "created_at": "2026-02-19T00:25:51.000000Z",
    "updated_at": "2026-02-19T00:25:51.000000Z"
  }
}
```

**Response (404 - Not Found):**
```json
{
  "success": false,
  "message": "Producto no encontrado"
}
```

---

### PUT /api/productos/{id} (Actualizar)

**Request:**
```bash
curl -X PUT http://localhost:8000/api/productos/9 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "nombre": "Monitor LG 27\" 4K UltraWide",
    "descripcion": "Monitor IPS ultrawide con HDR",
    "precio": 449.99,
    "stock": 12,
    "categoria": "Electrónica",
    "estado": "A"
  }'
```

**Response (200 - OK):**
```json
{
  "success": true,
  "message": "Producto actualizado exitosamente",
  "data": {
    "id": 9,
    "nombre": "Monitor LG 27\" 4K UltraWide",
    "descripcion": "Monitor IPS ultrawide con HDR",
    "precio": "449.99",
    "stock": 12,
    "categoria": "Electrónica",
    "estado": "A",
    "created_at": "2026-02-19T00:35:00.000000Z",
    "updated_at": "2026-02-19T00:35:15.000000Z"
  }
}
```

---

### DELETE /api/productos/{id} (Eliminar)

**Request:**
```bash
curl -X DELETE http://localhost:8000/api/productos/9 \
  -H "Accept: application/json"
```

**Response (200 - OK):**
```json
{
  "success": true,
  "message": "Producto eliminado exitosamente",
  "data": {
    "id": 9,
    "nombre": "Monitor LG 27\" 4K UltraWide",
    "descripcion": "Monitor IPS ultrawide con HDR",
    "precio": "449.99",
    "stock": 12,
    "categoria": "Electrónica",
    "estado": "A",
    "created_at": "2026-02-19T00:35:00.000000Z",
    "updated_at": "2026-02-19T00:35:15.000000Z"
  }
}
```

---

## 3.4 Tabla de Endpoints

| Método | Endpoint | Descripción | Código HTTP |
|--------|----------|-------------|------------|
| GET | `/api/productos` | Listar todos los productos | 200 |
| POST | `/api/productos` | Crear nuevo producto | 201/422 |
| GET | `/api/productos/{id}` | Obtener un producto | 200/404 |
| PUT | `/api/productos/{id}` | Actualizar producto | 200/404/422 |
| PATCH | `/api/productos/{id}` | Actualizar parcial | 200/404/422 |
| DELETE | `/api/productos/{id}` | Eliminar producto | 200/404 |

---

## 3.5 Testing con Postman

### Pasos para importar colección Postman:

1. Abre Postman
2. Click en "Import" en la esquina superior izquierda
3. Selecciona el archivo `postman_collection.json`
4. Se importará automáticamente la colección "Productos API - Práctica 4"
5. Actualiza la variable `base_url` en la colección a `http://localhost:8000`
6. ¡Prueba todos los endpoints!

### Variables de Entorno:

Crea una variable base_url:
- **Clave:** `base_url`
- **Valor:** `http://localhost:8000`

### Respuestas JSON Estandarizadas:

Todos los endpoints retornan un JSON con la siguiente estructura:

```json
{
  "success": true/false,
  "message": "Descripción clara de la operación",
  "data": { ...producto... },
  "errors": { ...errores de validación... }
}
```

---

# ✅ PARTE 4: CAPTURAS DE PANTALLA RECOMENDADAS

Tomar screenshots de:

1. **Pantalla de Login**
   - Mostrar el formulario con email/contraseña
   - Los campos con estilos Tailwind

2. **Dashboard**
   - Página protegida después de login
   - Mostrar sidebar y topbar

3. **Listado de Productos (Index)**
   - Tabla con productos
   - Botones de acciones (Ver, Editar, Eliminar)
   - Botón "Nuevo Producto"

4. **Formulario de Crear Producto (Create)**
   - Todos los campos visibles
   - Validación si es posible

5. **Formulario de Editar Producto (Edit)**
   - Datos precargados
   - Diferencia con create

6. **Vista de Detalle del Producto (Show)**
   - Información completa del producto
   - Botones de editar/eliminar

7. **Ejemplo de Validación**
   - Error cuando falta llenar un campo
   - Error de credenciales inválidas

8. **Mensaje de Éxito**
   - Después de crear/editar/eliminar un producto

---

# 📋 TABLA RESUMEN DE ARCHIVOS

| Componente | Archivo | Carpeta |
|-----------|---------|---------|
| Configuración Auth | config/auth.php | config/ |
| Modelo Usuario | Usuario.php | app/Models/ |
| Modelo Producto | Producto.php | app/Models/ |
| Middleware | VerifySession.php | app/Http/Middleware/ |
| Controller Usuario | UsuarioController.php | app/Http/Controllers/ |
| Controller Producto (Web) | ProductoController.php | app/Http/Controllers/ |
| Controller Producto (API) | ProductoApiController.php | app/Http/Controllers/Api/ |
| Rutas Web | web.php | routes/ |
| Rutas API | api.php | routes/ |
| Bootstrap | app.php | bootstrap/ |
| Vista Login | login.blade.php | resources/views/auth/ |
| Vista Index | index.blade.php | resources/views/productos/ |
| Vista Create | create.blade.php | resources/views/productos/ |
| Vista Edit | edit.blade.php | resources/views/productos/ |
| Vista Show | show.blade.php | resources/views/productos/ |
| Colección Postman | postman_collection.json | root/ |

---

# 📊 CREDENCIALES DE PRUEBA

Para las capturas de pantalla, usa:

| Usuario | Email | Contraseña |
|---------|-------|-----------|
| admin | admin@example.com | password123 |

Con estos accesos puedes capturar todas las funcionalidades del sistema.

---

# 🎨 INFORMACIÓN ADICIONAL

## Tecnologías Utilizadas

- **Backend**: Laravel 12
- **Frontend**: Tailwind CSS (con Vite)
- **Base de Datos**: MySQL
- **Autenticación**: Sistema manual con Session
- **Seguridad**: Middleware personalizado, validación de formularios
- **API REST**: JSON con respuestas estandarizadas

## Características Clave

1. **Autenticación Manual**
   - Sin usar Breeze ni Jetstream
   - Middleware personalizado para verificar sesión
   - Validación contra base de datos

2. **CRUD Web Completo**
   - Create: Crear nuevos productos via formulario
   - Read: Listar y ver detalles en Blade
   - Update: Editar productos
   - Delete: Eliminar productos

3. **API REST Completo**
   - GET /api/productos - Listar
   - POST /api/productos - Crear
   - GET /api/productos/{id} - Obtener
   - PUT /api/productos/{id} - Actualizar
   - PATCH /api/productos/{id} - Actualizar parcial
   - DELETE /api/productos/{id} - Eliminar
   - Respuestas estandarizadas en JSON
   - Validaciones con mensajes personalizados
   - Manejo de errores con try-catch

4. **Diseño Responsivo**
   - Sidebar colapsable
   - Topbar con información del usuario
   - Tabla responsive
   - Formularios completos
   - Compatibilidad mobile

5. **Validación Completa**
   - Validación en lado servidor (web y API)
   - Mensajes de error personalizados
   - Preservación de datos en formularios
   - Validación de tipos y rangos

## Pasos para Ejecutar

1. **Clonar/Preparar el proyecto**
   ```bash
   cd c:\laragon\www\project-laravel-final
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   npm install
   ```

3. **Configurar variables de entorno**
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

4. **Ejecutar migraciones y seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Compilar assets**
   ```bash
   npm run build
   ```

6. **Iniciar servidor**
   ```bash
   php artisan serve
   ```

7. **Acceder a la aplicación**
   - URL web: http://localhost:8000
   - URL API: http://localhost:8000/api/productos
   - Credenciales: admin@example.com / password123

---
