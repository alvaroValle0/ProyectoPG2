<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;

class ProveedorSeederUpdated extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar proveedores existentes
        Proveedor::query()->delete();

        $proveedores = [
            [
                'nombre_empresa' => 'TechSoluciones Guatemala',
                'nombre_contacto' => 'María González',
                'nombre_representante' => 'Carlos Mendoza',
                'telefono' => '5021-2345-6789',
                'telefono_fijo' => '5021-2345-6789',
                'telefono_movil' => '5021-9876-5432',
                'email' => 'contacto@techsoluciones.com',
                'email_alternativo' => 'ventas@techsoluciones.com',
                'direccion' => 'Zona 10, Guatemala City, Guatemala',
                'pagina_web' => 'https://www.techsoluciones.com',
                'nit' => '12345678-9',
                'tipo_proveedor' => 'fabricante',
                'categoria_productos' => 'Equipos de cómputo, laptops, impresoras',
                'descripcion_general' => 'Fabricante de equipos de cómputo con más de 10 años de experiencia en el mercado guatemalteco. Especialistas en reparación y mantenimiento.',
                'tiempo_entrega_promedio' => '24 horas para reparaciones, 3-5 días para equipos nuevos',
                'condiciones_pago' => 'Contado, Crédito 15/30 días',
                'observaciones' => 'Proveedor confiable con excelente servicio post-venta',
                'activo' => true,
            ],
            [
                'nombre_empresa' => 'Suministros Digitales S.A.',
                'nombre_contacto' => 'Roberto Silva',
                'nombre_representante' => 'Ana Rodríguez',
                'telefono' => '5022-9876-5432',
                'telefono_fijo' => '5022-9876-5432',
                'telefono_movil' => '5022-8765-4321',
                'email' => 'ventas@suministrosdigitales.com',
                'email_alternativo' => 'compras@suministrosdigitales.com',
                'direccion' => 'Centro Comercial Galerías del Sur, Zona 11',
                'pagina_web' => 'https://www.suministrosdigitales.com',
                'nit' => '87654321-0',
                'tipo_proveedor' => 'distribuidor',
                'categoria_productos' => 'Componentes electrónicos, cables, adaptadores',
                'descripcion_general' => 'Distribuidor mayorista de componentes electrónicos y accesorios para computadoras. Amplio inventario y precios competitivos.',
                'tiempo_entrega_promedio' => '2-3 días para pedidos regulares, 24 horas para urgencias',
                'condiciones_pago' => 'Crédito 30 días, descuentos por volumen',
                'observaciones' => 'Buenos precios en componentes, entrega rápida',
                'activo' => true,
            ],
            [
                'nombre_empresa' => 'Software Pro Guatemala',
                'nombre_contacto' => 'Patricia Morales',
                'nombre_representante' => 'Luis Pérez',
                'telefono' => '5023-4567-8901',
                'telefono_fijo' => '5023-4567-8901',
                'telefono_movil' => '5023-5678-9012',
                'email' => 'info@softwarepro.com',
                'email_alternativo' => 'soporte@softwarepro.com',
                'direccion' => 'Torre Empresarial, Zona 4, Guatemala City',
                'pagina_web' => 'https://www.softwarepro.com.gt',
                'nit' => '11223344-5',
                'tipo_proveedor' => 'mayorista',
                'categoria_productos' => 'Licencias de software, antivirus, sistemas operativos',
                'descripcion_general' => 'Distribuidor autorizado de software empresarial y herramientas de productividad. Soporte técnico incluido.',
                'tiempo_entrega_promedio' => 'Inmediato para licencias digitales, 1-2 días para físicas',
                'condiciones_pago' => 'Contado preferido, Crédito 15 días',
                'observaciones' => 'Distribuidor autorizado de Microsoft y otros proveedores importantes',
                'activo' => true,
            ],
            [
                'nombre_empresa' => 'Hardware Central',
                'nombre_contacto' => 'Miguel Torres',
                'nombre_representante' => 'Carmen Vásquez',
                'telefono' => '5024-7890-1234',
                'telefono_fijo' => '5024-7890-1234',
                'telefono_movil' => '5024-8901-2345',
                'email' => 'contacto@hardwarecentral.com',
                'email_alternativo' => 'ventas@hardwarecentral.com',
                'direccion' => 'Mercado de Electrónicos, Zona 1, Guatemala City',
                'pagina_web' => 'https://www.hardwarecentral.com.gt',
                'nit' => '55667788-9',
                'tipo_proveedor' => 'minorista',
                'categoria_productos' => 'Hardware nuevo y refurbished, procesadores, tarjetas gráficas',
                'descripcion_general' => 'Venta de hardware nuevo y refurbished: procesadores, tarjetas gráficas, memorias RAM, discos duros y más.',
                'tiempo_entrega_promedio' => '1-2 días para productos en stock',
                'condiciones_pago' => 'Contado, Crédito 30 días',
                'observaciones' => 'Excelente relación calidad-precio, productos garantizados',
                'activo' => true,
            ],
            [
                'nombre_empresa' => 'Mantenimiento Express',
                'nombre_contacto' => 'Fernando Castro',
                'nombre_representante' => 'Isabel Ramírez',
                'telefono' => '5025-2468-1357',
                'telefono_fijo' => '5025-2468-1357',
                'telefono_movil' => '5025-3579-2468',
                'email' => 'servicio@mantenimientoexpress.com',
                'email_alternativo' => 'emergencias@mantenimientoexpress.com',
                'direccion' => 'Zona 15, Guatemala City, Guatemala',
                'pagina_web' => 'https://www.mantenimientoexpress.com.gt',
                'nit' => '99887766-5',
                'tipo_proveedor' => 'otro',
                'categoria_productos' => 'Servicios de mantenimiento preventivo y correctivo',
                'descripcion_general' => 'Servicio de mantenimiento preventivo y correctivo para equipos de cómputo, limpieza de hardware y optimización.',
                'tiempo_entrega_promedio' => '4-6 horas para servicios a domicilio',
                'condiciones_pago' => 'Contado al finalizar servicio',
                'observaciones' => 'Servicio a domicilio disponible, técnicos certificados',
                'activo' => true,
            ]
        ];

        foreach ($proveedores as $proveedorData) {
            Proveedor::create($proveedorData);
        }
    }
}
