# 🚀 Sistema de Gestión de Productos - Práctica Nro. 4

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

---

## 📋 Descripción General

**Sistema Web completo con API REST** desarrollado en Laravel 12 para la gestión de productos. Implementa autenticación personalizada, CRUD web responsivo y servicio API RESTful con validaciones completas.

**Proyecto:** Práctica Nro. 4 - Dos ejercicios integrados
- **Pregunta 1:** Sistema Web con Login + CRUD de Productos
- **Pregunta 2:** Servicio Web (API REST) para gestión de productos

---

## ✨ Características Principales

### 🔐 Autenticación
- ✅ Sistema de login personalizado (sin Breeze/Jetstream)
- ✅ Middleware personalizado `VerifySession` para proteger rutas
- ✅ Manejo de sesiones en base de datos
- ✅ Registro de último acceso de usuarios

### 🌐 Web CRUD
- ✅ Listado de productos con tabla responsiva
- ✅ Crear nuevos productos con formulario validado
- ✅ Ver detalles de productos
- ✅ Editar productos existentes
- ✅ Eliminar productos con confirmación
- ✅ Validación en servidor con mensajes personalizados

### 📡 API REST
- ✅ 6 endpoints CRUD en JSON
- ✅ GET /api/productos - Listar todos
- ✅ POST /api/productos - Crear producto
- ✅ GET /api/productos/{id} - Obtener por ID
- ✅ PUT /api/productos/{id} - Actualizar completo
- ✅ PATCH /api/productos/{id} - Actualizar parcial
- ✅ DELETE /api/productos/{id} - Eliminar
- ✅ Respuestas JSON estandarizadas
- ✅ Manejo de errores con try-catch
- ✅ Códigos HTTP apropiados (200, 201, 404, 422, 500)

### 🎨 Diseño
- ✅ Styling con Tailwind CSS (100% responsive)
- ✅ Integración con Vite para assets
- ✅ Diseño móvil-first
- ✅ UX mejorado con gradientes y animaciones

### 🗄️ Base de Datos
- ✅ Migraciones para usuarios y productos
- ✅ Seeders con datos de prueba
- ✅ Relaciones Eloquent
- ✅ Castings de tipos (decimal, integer)

---

## 🛠️ Tecnologías Utilizadas

| Tecnología | Versión | Propósito |
|-----------|---------|----------|
| **Laravel** | 12.0 | Framework backend |
| **PHP** | 8.2+ | Lenguaje servidor |
| **MySQL** | 5.7+ | Base de datos |
| **Tailwind CSS** | 3.x | Framework CSS |
| **Vite** | 4.x | Bundler de assets |
| **Eloquent ORM** | - | ORM para BD |
| **Postman** | - | Testing API |

---

## 📦 Instalación y Configuración

### 1. **Clonar/Preparar el Proyecto**
```bash
cd c:\laragon\www\project-laravel-final
```

### 2. **Instalar Dependencias**
```bash
# Backend (PHP)
composer install

# Frontend (Node.js)
npm install
```

### 3. **Configurar Variables de Entorno**
```bash
# Copiar ejemplo de .env
copy .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### 4. **Configurar Base de Datos**
```bash
# Editar .env y asegurar:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel-final
DB_USERNAME=root
DB_PASSWORD=
```

### 5. **Ejecutar Migraciones y Seeders**
```bash
# Crear tablas y cargar datos de prueba
php artisan migrate:fresh --seed
```

### 6. **Compilar Assets**
```bash
# Compilar CSS y JS con Vite
npm run build

# O desarrollo con watch
npm run dev
```

### 7. **Iniciar Servidor**
```bash
php artisan serve
```

**Acceso:**
- 🌐 Web: http://localhost:8000
- 📡 API: http://localhost:8000/api/productos

---

## 👤 Credenciales de Prueba

| Campo | Valor |
|-------|-------|
| Email | `admin@example.com` |
| Contraseña | `password123` |

---

## 📂 Estructura de Archivos

```
project-laravel-final/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── UsuarioController.php      (Login/Logout)
│   │   │   ├── ProductoController.php     (Web CRUD)
│   │   │   └── Api/
│   │   │       └── ProductoApiController.php  (API CRUD)
│   │   └── Middleware/
│   │       └── VerifySession.php          (Protección sesión)
│   └── Models/
│       ├── Usuario.php                    (Modelo usuario)
│       └── Producto.php                   (Modelo producto)
├── routes/
│   ├── web.php                            (Rutas web)
│   └── api.php                            (Rutas API)
├── database/
│   ├── migrations/                        (Esquema BD)
│   └── seeders/                           (Datos de prueba)
├── resources/views/
│   ├── auth/login.blade.php              (Vista login)
│   ├── dashboard.blade.php               (Dashboard protegido)
│   └── productos/
│       ├── index.blade.php               (Listado)
│       ├── create.blade.php              (Formulario crear)
│       ├── edit.blade.php                (Formulario editar)
│       └── show.blade.php                (Detalle)
├── bootstrap/
│   └── app.php                           (Configuración app)
├── config/
│   └── auth.php                          (Config autenticación)
├── CODIGO_FUENTE_PARA_PDF.md            (Código completo)
├── API_REST_DOCUMENTACION.md            (Documentación API)
├── postman_collection.json              (Colección Postman)
└── README.md                            (Este archivo)
```

---

## 🔍 Uso de la Aplicación

### 1️⃣ **Iniciar Sesión**
1. Accede a http://localhost:8000
2. Serás redirigido a `/login` automáticamente
3. Ingresa credenciales: `admin@example.com` / `password123`
4. Serás redirigido al dashboard

### 2️⃣ **Gestionar Productos (Web)**
```
GET  /productos          → Lista todos los productos
POST /productos          → Crear nuevo producto
GET  /productos/{id}     → Ver detalle
GET  /productos/{id}/edit → Editar producto
PUT  /productos/{id}     → Guardar cambios
DELETE /productos/{id}   → Eliminar producto
```

### 3️⃣ **API REST (JSON)**
```
GET    /api/productos         → Listar (200)
POST   /api/productos         → Crear (201/422)
GET    /api/productos/{id}    → Obtener (200/404)
PUT    /api/productos/{id}    → Actualizar (200/404/422)
PATCH  /api/productos/{id}    → Actualizar parcial (200)
DELETE /api/productos/{id}    → Eliminar (200/404)
```

---

## 📡 Testing de API con Postman

### Importar Colección
1. Abre Postman
2. Click en **Import**
3. Selecciona `postman_collection.json`
4. Se importará automáticamente "Productos API - Práctica 4"

### Variables de Entorno
```
base_url = http://localhost:8000
```

### Ejemplos de Requests

**GET - Listar productos:**
```bash
curl -X GET http://localhost:8000/api/productos \
  -H "Accept: application/json"
```

**POST - Crear producto:**
```bash
curl -X POST http://localhost:8000/api/productos \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Monitor LG 27 4K",
    "precio": 399.99,
    "stock": 8,
    "estado": "A"
  }'
```

**PUT - Actualizar:**
```bash
curl -X PUT http://localhost:8000/api/productos/1 \
  -H "Content-Type: application/json" \
  -d '{"precio": 449.99}'
```

**DELETE - Eliminar:**
```bash
curl -X DELETE http://localhost:8000/api/productos/1
```

---

## 📊 Validaciones

### Campos Obligatorios
| Campo | Tipo | Restricción |
|-------|------|------------|
| `nombre` | String | Max 255 caracteres |
| `precio` | Número | Mínimo 0 |
| `stock` | Entero | Mínimo 0 |
| `estado` | String | "A" o "I" |

### Campos Opcionales
| Campo | Tipo |
|-------|------|
| `descripcion` | String |
| `categoria` | String (Max 100) |

### Respuesta de Error de Validación
```json
{
  "success": false,
  "message": "Error de validación",
  "errors": {
    "nombre": ["El nombre es obligatorio"],
    "precio": ["El precio debe ser un número"]
  }
}
```

---

## 🔐 Seguridad

✅ **Implementaciones de seguridad:**
- Middleware personalizado para verificar sesión activa
- Protección CSRF en formularios
- Validación de entrada en servidor
- Contraseñas hasheadas con bcrypt
- Sesiones en base de datos (no cookies)
- Códigos HTTP apropiados según situación

---

## 📚 Documentación Adicional

- 📄 [CODIGO_FUENTE_PARA_PDF.md](CODIGO_FUENTE_PARA_PDF.md) - Código fuente completo organizado
- 📡 [API_REST_DOCUMENTACION.md](API_REST_DOCUMENTACION.md) - Documentación detallada de endpoints
- 📮 [postman_collection.json](postman_collection.json) - Colección Postman importable

---

## 🎯 Requisitos Completados

### ✅ Pregunta 1: Sistema Web
- [x] Autenticación personalizada sin Breeze
- [x] Middleware para proteger rutas
- [x] CRUD completo (Create, Read, Update, Delete)
- [x] Formularios con validación
- [x] Diseño responsivo con Tailwind CSS
- [x] Base de datos con migraciones

### ✅ Pregunta 2: Servicio Web (API)
- [x] 6 endpoints CRUD en JSON
- [x] Validaciones con mensajes personalizados
- [x] Códigos HTTP apropiados
- [x] Manejo de errores con try-catch
- [x] Testing con Postman

---

## 🚀 Comandos Útiles

```bash
# Ver todas las rutas
php artisan route:list

# Ver rutas API
php artisan route:list --path=api

# Resetear base de datos
php artisan migrate:fresh --seed

# Clear cachés
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Crear modelo y migración
php artisan make:model NombreModelo -m

# Ejecutar seeders específicos
php artisan db:seed --class=ProductoSeeder
```

---

## 📝 Notas Importantes

1. **Puerto del servidor**: Por defecto `8000` - puedes cambiar con `--port=8001`
2. **Base de datos**: Asegúrate de que MySQL esté corriendo
3. **Vite**: En desarrollo usa `npm run dev` para hot reload
4. **Postman**: Descarga desde [postman.com](https://www.postman.com/downloads/)
5. **Credenciales**: Solo para pruebas, cambiar en producción

---

## 👨‍💻 Autor

**Isidoro Torrico M**  
itorrico.m@gmail.com

---

## 📄 Licencia

Este proyecto está bajo la licencia MIT.
