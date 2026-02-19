<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            [
                'nombre' => 'Laptop Dell XPS 15',
                'descripcion' => 'Laptop profesional de alta gama con procesador Intel de última generación, pantalla 4K y 16GB de RAM',
                'precio' => 1299.99,
                'stock' => 10,
                'categoria' => 'Electrónica',
                'imagen' => 'producto-default.jpg',
                'estado' => 'A',
            ],
            [
                'nombre' => 'Mouse Logitech MX Master 3',
                'descripcion' => 'Mouse profesional inalámbrico con múltiples botones programables y conexión USB-C',
                'precio' => 99.99,
                'stock' => 25,
                'categoria' => 'Accesorios',
                'imagen' => 'producto-default.jpg',
                'estado' => 'A',
            ],
            [
                'nombre' => 'Teclado Mecánico Cherry MX',
                'descripcion' => 'Teclado mecánico RGB con switches Cherry MX Brown, ideal para programadores y gamers',
                'precio' => 179.99,
                'stock' => 15,
                'categoria' => 'Accesorios',
                'imagen' => 'producto-default.jpg',
                'estado' => 'A',
            ],
            [
                'nombre' => 'Monitor LG 27" 4K',
                'descripcion' => 'Monitor IPS 27 pulgadas con resolución 4K, soporte para HDR y ajuste de altura',
                'precio' => 399.99,
                'stock' => 8,
                'categoria' => 'Electrónica',
                'imagen' => 'producto-default.jpg',
                'estado' => 'A',
            ],
            [
                'nombre' => 'Webcam Logitech 4K',
                'descripcion' => 'Webcam 4K Ultra HD con micrófono integrado y enfoque automático, perfecta para videollamadas profesionales',
                'precio' => 149.99,
                'stock' => 20,
                'categoria' => 'Accesorios',
                'imagen' => 'producto-default.jpg',
                'estado' => 'A',
            ],
            [
                'nombre' => 'SSD Samsung 1TB NVMe',
                'descripcion' => 'Unidad de estado sólido NVMe PCIe 4.0 con velocidades de lectura hasta 7,100 MB/s',
                'precio' => 129.99,
                'stock' => 30,
                'categoria' => 'Almacenamiento',
                'imagen' => 'producto-default.jpg',
                'estado' => 'A',
            ],
            [
                'nombre' => 'RAM DDR5 32GB Kingston',
                'descripcion' => 'Memoria RAM DDR5 32GB (2x16GB) con velocidad de 5600MHz, ideal para gaming y tareas profesionales',
                'precio' => 249.99,
                'stock' => 12,
                'categoria' => 'Componentes',
                'imagen' => 'producto-default.jpg',
                'estado' => 'A',
            ],
            [
                'nombre' => 'Tarjeta Gráfica RTX 4070',
                'descripcion' => 'GPU NVIDIA RTX 4070 con 12GB GDDR6X, ideal para gaming en 1440p y rendering profesional',
                'precio' => 599.99,
                'stock' => 5,
                'categoria' => 'Componentes',
                'imagen' => 'producto-default.jpg',
                'estado' => 'A',
            ],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}
