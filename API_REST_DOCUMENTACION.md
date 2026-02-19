# 📡 API REST - DOCUMENTACIÓN COMPLETA

## DESCRIPCIÓN GENERAL

Servicio Web RESTful desarrollado en Laravel 12 para gestión de productos.
Proporciona endpoints CRUD con respuestas en JSON y validaciones completas.

---

## 🚀 ENDPOINTS

### 1. **LISTAR TODOS LOS PRODUCTOS**

**Endpoint:** `GET /api/productos`

**Descripción:** Obtiene el listado completo de todos los productos

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
      "created_at": "2026-02-18T21:27:55.000000Z",
      "updated_at": "2026-02-18T21:27:55.000000Z"
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
      "created_at": "2026-02-18T21:27:55.000000Z",
      "updated_at": "2026-02-18T21:27:55.000000Z"
    }
  ],
  "count": 2
}
```

---

### 2. **OBTENER UN PRODUCTO ESPECÍFICO**

**Endpoint:** `GET /api/productos/{id}`

**Descripción:** Obtiene los detalles de un producto específico

**Parámetros:**
- `id` (integer) - ID del producto (obligatorio)

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
    "descripcion": "Laptop profesional de alta gama con procesador Intel...",
    "precio": "1299.99",
    "stock": 10,
    "categoria": "Electrónica",
    "imagen": "producto-default.jpg",
    "estado": "A",
    "created_at": "2026-02-18T21:27:55.000000Z",
    "updated_at": "2026-02-18T21:27:55.000000Z"
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

### 3. **CREAR UN NUEVO PRODUCTO**

**Endpoint:** `POST /api/productos`

**Descripción:** Crea un nuevo producto en la base de datos

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
  "nombre": "Monitor LG 27\" 4K",
  "descripcion": "Monitor IPS 27 pulgadas con resolución 4K",
  "precio": 399.99,
  "stock": 8,
  "categoria": "Electrónica",
  "estado": "A"
}
```

**cURL Request:**
```bash
curl -X POST http://localhost:8000/api/productos \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "nombre": "Monitor LG 27\" 4K",
    "descripcion": "Monitor IPS 27 pulgadas con resolución 4K",
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
    "descripcion": "Monitor IPS 27 pulgadas con resolución 4K",
    "precio": "399.99",
    "stock": 8,
    "categoria": "Electrónica",
    "estado": "A",
    "updated_at": "2026-02-18T21:35:00.000000Z",
    "created_at": "2026-02-18T21:35:00.000000Z",
    "id": 9
  }
}
```

**Response (422 - Unprocessable Entity) - Validación fallida:**
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
    ],
    "estado": [
      "El estado debe ser A (Activo) o I (Inactivo)"
    ]
  }
}
```

---

### 4. **ACTUALIZAR UN PRODUCTO (PUT)**

**Endpoint:** `PUT /api/productos/{id}`

**Descripción:** Actualiza todos los campos de un producto

**Parámetros:**
- `id` (integer) - ID del producto (obligatorio)

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
  "nombre": "Monitor LG 27\" 4K UltraWide",
  "descripcion": "Monitor IPS ultrawide con tecnología HDR",
  "precio": 449.99,
  "stock": 12,
  "categoria": "Electrónica",
  "estado": "A"
}
```

**cURL Request:**
```bash
curl -X PUT http://localhost:8000/api/productos/9 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "nombre": "Monitor LG 27\" 4K UltraWide",
    "descripcion": "Monitor IPS ultrawide con tecnología HDR",
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
    "descripcion": "Monitor IPS ultrawide con tecnología HDR",
    "precio": "449.99",
    "stock": 12,
    "categoria": "Electrónica",
    "imagen": "producto-default.jpg",
    "estado": "A",
    "created_at": "2026-02-18T21:35:00.000000Z",
    "updated_at": "2026-02-18T21:35:15.000000Z"
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

### 5. **ACTUALIZAR UN PRODUCTO (PATCH)**

**Endpoint:** `PATCH /api/productos/{id}`

**Descripción:** Actualiza solo los campos enviados (actualización parcial)

**Parámetros:**
- `id` (integer) - ID del producto (obligatorio)

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON) - Ejemplo: actualizar solo stock y precio:**
```json
{
  "precio": 499.99,
  "stock": 15
}
```

**cURL Request:**
```bash
curl -X PATCH http://localhost:8000/api/productos/9 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "precio": 499.99,
    "stock": 15
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
    "descripcion": "Monitor IPS ultrawide con tecnología HDR",
    "precio": "499.99",
    "stock": 15,
    "categoria": "Electrónica",
    "imagen": "producto-default.jpg",
    "estado": "A",
    "created_at": "2026-02-18T21:35:00.000000Z",
    "updated_at": "2026-02-18T21:35:20.000000Z"
  }
}
```

---

### 6. **ELIMINAR UN PRODUCTO**

**Endpoint:** `DELETE /api/productos/{id}`

**Descripción:** Elimina un producto de la base de datos

**Parámetros:**
- `id` (integer) - ID del producto (obligatorio)

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
    "descripcion": "Monitor IPS ultrawide con tecnología HDR",
    "precio": "499.99",
    "stock": 15,
    "categoria": "Electrónica",
    "imagen": "producto-default.jpg",
    "estado": "A",
    "created_at": "2026-02-18T21:35:00.000000Z",
    "updated_at": "2026-02-18T21:35:20.000000Z"
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

## 📋 TABLA DE REFERENCIA DE ENDPOINTS

| Método | Endpoint | Descripción | Status Code |
|--------|----------|-------------|------------|
| GET | `/api/productos` | Listar todos | 200 |
| GET | `/api/productos/{id}` | Obtener uno | 200/404 |
| POST | `/api/productos` | Crear | 201/422 |
| PUT | `/api/productos/{id}` | Actualizar completo | 200/404/422 |
| PATCH | `/api/productos/{id}` | Actualizar parcial | 200/404/422 |
| DELETE | `/api/productos/{id}` | Eliminar | 200/404 |

---

## 🔍 CÓDIGOS DE ESTADO HTTP

| Código | Significado | Descripción |
|--------|------------|-------------|
| **200** | OK | Operación exitosa |
| **201** | Created | Recurso creado exitosamente |
| **404** | Not Found | Recurso no encontrado |
| **422** | Unprocessable Entity | Error de validación |
| **500** | Internal Server Error | Error en el servidor |

---

## ✅ VALIDACIONES

### Campos Obligatorios
- `nombre`: String (max 255 caracteres)
- `precio`: Número (mínimo 0)
- `stock`: Número entero (mínimo 0)
- `estado`: "A" (Activo) o "I" (Inactivo)

### Campos Opcionales
- `descripcion`: String sin límite de caracteres
- `categoria`: String (max 100 caracteres)

### Mensajes de Error Personalizados
```json
{
  "nombre.required": "El nombre del producto es obligatorio",
  "nombre.max": "El nombre no puede exceder 255 caracteres",
  "precio.required": "El precio es obligatorio",
  "precio.numeric": "El precio debe ser un número",
  "precio.min": "El precio no puede ser negativo",
  "stock.required": "El stock es obligatorio",
  "stock.integer": "El stock debe ser un número entero",
  "stock.min": "El stock no puede ser negativo",
  "estado.required": "El estado es obligatorio",
  "estado.in": "El estado debe ser A (Activo) o I (Inactivo)"
}
```

---

## 🧪 TESTING CON POSTMAN

### 1. **Crear una colección en Postman**

1. Abre Postman
2. Crea una nueva colección llamada "Productos API"
3. Agrega las 6 solicitudes siguientes

### 2. **REQUEST: Listar Productos**

**Method:** GET  
**URL:** `{{base_url}}/api/productos`  
**Headers:**
```
Accept: application/json
```

### 3. **REQUEST: Obtener Producto**

**Method:** GET  
**URL:** `{{base_url}}/api/productos/1`  
**Headers:**
```
Accept: application/json
```

### 4. **REQUEST: Crear Producto**

**Method:** POST  
**URL:** `{{base_url}}/api/productos`  
**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (raw JSON):**
```json
{
  "nombre": "Nueva Webcam 4K",
  "descripcion": "Webcam profesional 4K Ultra HD",
  "precio": 199.99,
  "stock": 20,
  "categoria": "Accesorios",
  "estado": "A"
}
```

### 5. **REQUEST: Actualizar Producto (PUT)**

**Method:** PUT  
**URL:** `{{base_url}}/api/productos/1`  
**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (raw JSON):**
```json
{
  "nombre": "Laptop Dell Actualizada",
  "descripcion": "Descripción actualizada",
  "precio": 1399.99,
  "stock": 15,
  "categoria": "Electrónica",
  "estado": "A"
}
```

### 6. **REQUEST: Actualizar Producto (PATCH)**

**Method:** PATCH  
**URL:** `{{base_url}}/api/productos/1`  
**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (raw JSON):**
```json
{
  "stock": 20
}
```

### 7. **REQUEST: Eliminar Producto**

**Method:** DELETE  
**URL:** `{{base_url}}/api/productos/1`  
**Headers:**
```
Accept: application/json
```

---

## 🌍 VARIABLES DE ENTORNO (Postman)

Crear una variable `base_url`:
- **Initial value:** `http://localhost:8000`
- **Current value:** `http://localhost:8000`

---

## 📂 ESTRUCTURA DE ARCHIVOS

```
app/Http/Controllers/Api/
└── ProductoApiController.php      (Controlador API)

routes/
└── api.php                         (Rutas API)
```

---

## 🔧 CARACTERÍSTICAS TÉCNICAS

✅ **Respuestas JSON estandarizadas**
- Campo `success` (boolean)
- Campo `message` (string)
- Campo `data` (objeto/array)
- Campo `count` (para listados)

✅ **Validaciones Server-Side**
- Validación de tipos
- Validación de rangos
- Mensajes de error personalizados

✅ **Manejo de Errores**
- Try-catch en cada método
- Códigos HTTP correctos
- Mensajes de error descriptivos

✅ **RESTful Completo**
- Método GET para lectura
- Método POST para creación
- Método PUT para actualización completa
- Método PATCH para actualización parcial
- Método DELETE para eliminación

---

## 📝 NOTAS IMPORTANTES

1. **Base URL:** `http://localhost:8000`
2. **Prefijo API:** `/api`
3. **Content-Type:** `application/json`
4. **Accept:** `application/json`
5. El servidor debe estar corriendo con `php artisan serve`

---

## 🚀 PRÓXIMOS PASOS

- Implementar autenticación Bearer Token (opcional)
- Agregar paginación en listados
- Implementar búsqueda y filtrado
- Agregar rate limiting
- Documentación OpenAPI/Swagger

---
