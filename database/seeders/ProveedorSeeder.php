<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proveedores = [
            [
                'nombre_empresa' => 'TechSoluciones Guatemala',
                'nombre_contacto' => 'María González',
                'telefono' => '5021-2345-6789',
                'email' => 'contacto@techsoluciones.com',
                'direccion' => 'Zona 10, Guatemala City, Guatemala',
                'nit' => '12345678-9',
                'tipo_servicio' => 'reparacion',
                'descripcion_servicios' => 'Especialistas en reparación de computadoras, laptops, impresoras y equipos de red. Servicio técnico certificado con garantía.',
                'tiempo_respuesta' => '24 horas',
                'calificacion' => 4.8,
                'observaciones' => 'Proveedor confiable con excelente servicio post-venta',
                'activo' => true,
            ],
            [
                'nombre_empresa' => 'Suministros Digitales S.A.',
                'nombre_contacto' => 'Carlos Mendoza',
                'telefono' => '5022-9876-5432',
                'email' => 'ventas@suministrosdigitales.com',
                'direccion' => 'Centro Comercial Galerías del Sur, Zona 11',
                'nit' => '87654321-0',
                'tipo_servicio' => 'suministros',
                'descripcion_servicios' => 'Venta de componentes electrónicos, cables, adaptadores, fuentes de poder y accesorios para computadoras.',
                'tiempo_respuesta' => '2-3 días',
                'calificacion' => 4.5,
                'observaciones' => 'Buenos precios en componentes, entrega rápida',
                'activo' => true,
            ],
            [
                'nombre_empresa' => 'Software Pro Guatemala',
                'nombre_contacto' => 'Ana Rodríguez',
                'telefono' => '5023-4567-8901',
                'email' => 'info@softwarepro.com',
                'direccion' => 'Torre Empresarial, Zona 4, Guatemala City',
                'nit' => '11223344-5',
                'tipo_servicio' => 'software',
                'descripcion_servicios' => 'Licencias de software, antivirus, sistemas operativos y herramientas de productividad. Soporte técnico incluido.',
                'tiempo_respuesta' => 'Inmediato',
                'calificacion' => 4.7,
                'observaciones' => 'Distribuidor autorizado de Microsoft y otros proveedores importantes',
                'activo' => true,
            ],
            [
                'nombre_empresa' => 'Hardware Central',
                'nombre_contacto' => 'Luis Pérez',
                'telefono' => '5024-7890-1234',
                'email' => 'contacto@hardwarecentral.com',
                'direccion' => 'Mercado de Electrónicos, Zona 1, Guatemala City',
                'nit' => '55667788-9',
                'tipo_servicio' => 'hardware',
                'descripcion_servicios' => 'Venta de hardware nuevo y refurbished: procesadores, tarjetas gráficas, memorias RAM, discos duros y más.',
                'tiempo_respuesta' => '1-2 días',
                'calificacion' => 4.3,
                'observaciones' => 'Excelente relación calidad-precio, productos garantizados',
                'activo' => true,
            ],
            [
                'nombre_empresa' => 'Mantenimiento Express',
                'nombre_contacto' => 'Roberto Silva',
                'telefono' => '5025-2468-1357',
                'email' => 'servicio@mantenimientoexpress.com',
                'direccion' => 'Zona 15, Guatemala City, Guatemala',
                'nit' => '99887766-5',
                'tipo_servicio' => 'mantenimiento',
                'descripcion_servicios' => 'Servicio de mantenimiento preventivo y correctivo para equipos de cómputo, limpieza de hardware y optimización.',
                'tiempo_respuesta' => '4-6 horas',
                'calificacion' => 4.6,
                'observaciones' => 'Servicio a domicilio disponible, técnicos certificados',
                'activo' => true,
            ],
            [
                'nombre_empresa' => 'Consultores IT Guatemala',
                'nombre_contacto' => 'Patricia Morales',
                'telefono' => '5026-1357-2468',
                'email' => 'consultoria@itguatemala.com',
                'direccion' => 'Edificio Corporativo, Zona 10, Guatemala City',
                'nit' => '44332211-0',
                'tipo_servicio' => 'consultoria',
                'descripcion_servicios' => 'Consultoría en tecnología, implementación de sistemas, auditorías de seguridad y capacitación técnica.',
                'tiempo_respuesta' => '3-5 días',
                'calificacion' => 4.9,
                'observaciones' => 'Equipo altamente calificado, experiencia en proyectos empresariales',
                'activo' => true,
            ],
            [
                'nombre_empresa' => 'Electrónicos del Valle',
                'nombre_contacto' => 'Miguel Torres',
                'telefono' => '5027-9753-1864',
                'email' => 'ventas@electronicosdelvalle.com',
                'direccion' => 'Centro Histórico, Antigua Guatemala, Sacatepéquez',
                'nit' => '77889900-1',
                'tipo_servicio' => 'suministros',
                'descripcion_servicios' => 'Venta de componentes electrónicos, herramientas de trabajo, multímetros, soldadores y equipos de medición.',
                'tiempo_respuesta' => '2-4 días',
                'calificacion' => 4.2,
                'observaciones' => 'Especializados en herramientas profesionales para técnicos',
                'activo' => true,
            ],
            [
                'nombre_empresa' => 'Servicios Técnicos Integrales',
                'nombre_contacto' => 'Carmen Vásquez',
                'telefono' => '5028-8642-1975',
                'email' => 'info@serviciostecnicos.com',
                'direccion' => 'Zona 7, Guatemala City, Guatemala',
                'nit' => '66554433-2',
                'tipo_servicio' => 'reparacion',
                'descripcion_servicios' => 'Reparación especializada de equipos Apple, laptops gaming, estaciones de trabajo y servidores.',
                'tiempo_respuesta' => '48 horas',
                'calificacion' => 4.4,
                'observaciones' => 'Especialistas en marcas premium, servicio express disponible',
                'activo' => true,
            ],
            [
                'nombre_empresa' => 'Distribuidora de Software',
                'nombre_contacto' => 'Fernando Castro',
                'telefono' => '5029-7531-8642',
                'email' => 'distribucion@software.com',
                'direccion' => 'Plaza Comercial, Zona 13, Guatemala City',
                'nit' => '22334455-6',
                'tipo_servicio' => 'software',
                'descripcion_servicios' => 'Distribución de software educativo, antivirus corporativos, herramientas de diseño y software de contabilidad.',
                'tiempo_respuesta' => 'Inmediato',
                'calificacion' => 4.1,
                'observaciones' => 'Precios competitivos para compras al mayoreo',
                'activo' => false,
            ],
            [
                'nombre_empresa' => 'Refacciones y Accesorios',
                'nombre_contacto' => 'Isabel Ramírez',
                'telefono' => '5030-6420-7531',
                'email' => 'ventas@refacciones.com',
                'direccion' => 'Mercado de Artesanías, Zona 1, Guatemala City',
                'nit' => '88990011-7',
                'tipo_servicio' => 'hardware',
                'descripcion_servicios' => 'Refacciones originales y compatibles para laptops, teclados, pantallas, baterías y cargadores.',
                'tiempo_respuesta' => '1-3 días',
                'calificacion' => 4.0,
                'observaciones' => 'Amplio inventario de refacciones para diferentes marcas',
                'activo' => true,
            ]
        ];

        foreach ($proveedores as $proveedorData) {
            Proveedor::create($proveedorData);
        }
    }
}
