<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventario;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'codigo' => 'INV-001',
                'nombre' => 'Disco Duro SSD Samsung 500GB',
                'descripcion' => 'Disco de estado sólido Samsung 870 EVO de 500GB, ideal para mejorar el rendimiento del sistema',
                'categoria' => 'Componentes',
                'marca' => 'Samsung',
                'modelo' => '870 EVO',
                'serie' => 'SN123456789',
                'stock_minimo' => 5,
                'stock_actual' => 15,
                'precio_compra' => 45.00,
                'precio_venta' => 65.00,
                'proveedor' => 'Distribuidora ABC',
                'ubicacion' => 'Almacén A, Estante 1',
                'estado' => 'activo',
                'fecha_compra' => '2024-01-15',
                'notas' => 'Producto de alta demanda, mantener stock mínimo'
            ],
            [
                'codigo' => 'INV-002',
                'nombre' => 'Memoria RAM DDR4 8GB',
                'descripcion' => 'Módulo de memoria RAM DDR4 de 8GB, velocidad 3200MHz',
                'categoria' => 'Componentes',
                'marca' => 'Kingston',
                'modelo' => 'Fury Beast',
                'serie' => 'SN987654321',
                'stock_minimo' => 10,
                'stock_actual' => 25,
                'precio_compra' => 25.00,
                'precio_venta' => 35.00,
                'proveedor' => 'Distribuidora XYZ',
                'ubicacion' => 'Almacén A, Estante 2',
                'estado' => 'activo',
                'fecha_compra' => '2024-01-20',
                'notas' => 'Compatible con la mayoría de placas base'
            ],
            [
                'codigo' => 'INV-003',
                'nombre' => 'Mouse Inalámbrico Logitech',
                'descripcion' => 'Mouse inalámbrico con sensor óptico de alta precisión',
                'categoria' => 'Periféricos',
                'marca' => 'Logitech',
                'modelo' => 'M185',
                'serie' => 'SN456789123',
                'stock_minimo' => 8,
                'stock_actual' => 3,
                'precio_compra' => 12.00,
                'precio_venta' => 18.00,
                'proveedor' => 'Distribuidora ABC',
                'ubicacion' => 'Almacén B, Estante 1',
                'estado' => 'activo',
                'fecha_compra' => '2024-01-10',
                'notas' => 'Stock bajo, reabastecer pronto'
            ],
            [
                'codigo' => 'INV-004',
                'nombre' => 'Teclado Mecánico RGB',
                'descripcion' => 'Teclado mecánico con switches Cherry MX y retroiluminación RGB',
                'categoria' => 'Periféricos',
                'marca' => 'Corsair',
                'modelo' => 'K70 RGB',
                'serie' => 'SN789123456',
                'stock_minimo' => 3,
                'stock_actual' => 0,
                'precio_compra' => 80.00,
                'precio_venta' => 120.00,
                'proveedor' => 'Distribuidora Premium',
                'ubicacion' => 'Almacén B, Estante 2',
                'estado' => 'agotado',
                'fecha_compra' => '2024-01-05',
                'notas' => 'Producto agotado, pedido en camino'
            ],
            [
                'codigo' => 'INV-005',
                'nombre' => 'Windows 11 Pro',
                'descripcion' => 'Licencia de Windows 11 Professional para un equipo',
                'categoria' => 'Software',
                'marca' => 'Microsoft',
                'modelo' => 'Windows 11 Pro',
                'serie' => 'LIC-W11-PRO-001',
                'stock_minimo' => 5,
                'stock_actual' => 12,
                'precio_compra' => 120.00,
                'precio_venta' => 180.00,
                'proveedor' => 'Microsoft Partner',
                'ubicacion' => 'Almacén C, Estante 1',
                'estado' => 'activo',
                'fecha_compra' => '2024-01-25',
                'notas' => 'Licencias digitales, entregar por email'
            ],
            [
                'codigo' => 'INV-006',
                'nombre' => 'Destornillador Phillips',
                'descripcion' => 'Destornillador Phillips de precisión para trabajos de reparación',
                'categoria' => 'Herramientas',
                'marca' => 'Stanley',
                'modelo' => 'PH-1',
                'serie' => 'SN111222333',
                'stock_minimo' => 15,
                'stock_actual' => 8,
                'precio_compra' => 8.00,
                'precio_venta' => 12.00,
                'proveedor' => 'Ferretería Central',
                'ubicacion' => 'Almacén D, Estante 1',
                'estado' => 'activo',
                'fecha_compra' => '2024-01-30',
                'notas' => 'Herramienta básica para reparaciones'
            ],
            [
                'codigo' => 'INV-007',
                'nombre' => 'Cable HDMI 2.0',
                'descripcion' => 'Cable HDMI de alta velocidad para 4K y HDR',
                'categoria' => 'Consumibles',
                'marca' => 'Belkin',
                'modelo' => 'HDMI-2.0-2M',
                'serie' => 'SN444555666',
                'stock_minimo' => 20,
                'stock_actual' => 35,
                'precio_compra' => 5.00,
                'precio_venta' => 8.00,
                'proveedor' => 'Distribuidora de Cables',
                'ubicacion' => 'Almacén E, Estante 1',
                'estado' => 'activo',
                'fecha_compra' => '2024-02-01',
                'notas' => 'Cable de 2 metros, alta calidad'
            ],
            [
                'codigo' => 'INV-008',
                'nombre' => 'Laptop HP Pavilion',
                'descripcion' => 'Laptop HP Pavilion con procesador Intel i5 y 8GB RAM',
                'categoria' => 'Equipos',
                'marca' => 'HP',
                'modelo' => 'Pavilion 15',
                'serie' => 'SN777888999',
                'stock_minimo' => 2,
                'stock_actual' => 1,
                'precio_compra' => 450.00,
                'precio_venta' => 650.00,
                'proveedor' => 'HP Distributor',
                'ubicacion' => 'Almacén F, Estante 1',
                'estado' => 'activo',
                'fecha_compra' => '2024-02-05',
                'notas' => 'Equipo de demostración disponible'
            ]
        ];

        foreach ($items as $item) {
            Inventario::create($item);
        }

        $this->command->info('Datos de ejemplo del inventario creados exitosamente.');
    }
}
