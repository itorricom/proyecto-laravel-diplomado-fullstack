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
            // Validar datos
            $validated = $request->validate([
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

            // Crear producto
            $producto = Producto::create($validated);

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

            // Validar datos
            $validated = $request->validate([
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

            // Actualizar producto
            $producto->update($validated);

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

            // Guardar datos antes de eliminar
            $dataProducto = $producto;
            $producto->delete();

            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado exitosamente',
                'data' => $dataProducto
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
