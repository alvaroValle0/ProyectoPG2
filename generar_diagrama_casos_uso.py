#!/usr/bin/env python3
"""
Generador de Diagrama de Casos de Uso - Sistema HDC
Autor: Sistema HDC
Descripción: Script para generar diagramas de casos de uso automáticamente
"""

import json
import os
from datetime import datetime

class GeneradorDiagramaCasosUso:
    def __init__(self):
        self.actores = {
            'Administrador': {
                'icono': '👨‍💼',
                'color': '#ffebee',
                'casos_uso': [
                    'Gestionar Usuarios',
                    'Gestionar Técnicos', 
                    'Gestionar Clientes',
                    'Gestionar Equipos',
                    'Gestionar Reparaciones',
                    'Gestionar Inventario',
                    'Gestionar Tickets',
                    'Ver Dashboard Completo',
                    'Generar Reportes',
                    'Configurar Sistema',
                    'Gestionar Permisos'
                ]
            },
            'Técnico': {
                'icono': '🔧',
                'color': '#e8f5e8',
                'casos_uso': [
                    'Ver Tareas Asignadas',
                    'Gestionar Reparaciones Asignadas',
                    'Actualizar Estado Reparaciones',
                    'Gestionar Equipos',
                    'Ver Dashboard Personalizado',
                    'Generar Tickets',
                    'Gestionar Inventario Limitado'
                ]
            },
            'Usuario': {
                'icono': '👤',
                'color': '#fff3e0',
                'casos_uso': [
                    'Ver Dashboard Básico',
                    'Gestionar Clientes Limitado',
                    'Ver Reparaciones Solo Lectura',
                    'Ver Equipos Solo Lectura'
                ]
            },
            'Cliente': {
                'icono': '👥',
                'color': '#f1f8e9',
                'casos_uso': [
                    'Consultar Estado Reparación',
                    'Recibir Notificaciones',
                    'Firmar Tickets',
                    'Recibir Equipos Reparados'
                ]
            },
            'Sistema': {
                'icono': '🤖',
                'color': '#f3e5f5',
                'casos_uso': [
                    'Enviar Notificaciones',
                    'Generar Estadísticas',
                    'Backup Automático',
                    'Validar Datos'
                ]
            }
        }
        
        self.relaciones = [
            ('Gestionar Reparaciones', 'Gestionar Reparaciones Asignadas'),
            ('Gestionar Equipos', 'Gestionar Reparaciones'),
            ('Gestionar Clientes', 'Gestionar Equipos'),
            ('Gestionar Técnicos', 'Ver Tareas Asignadas'),
            ('Gestionar Usuarios', 'Gestionar Técnicos'),
            ('Gestionar Inventario', 'Gestionar Inventario Limitado'),
            ('Gestionar Tickets', 'Generar Tickets'),
            ('Ver Dashboard Completo', 'Ver Dashboard Personalizado'),
            ('Ver Dashboard Completo', 'Ver Dashboard Básico')
        ]

    def generar_mermaid_completo(self):
        """Genera el diagrama Mermaid completo"""
        mermaid = "graph TB\n"
        
        # Agregar actores
        for actor, info in self.actores.items():
            mermaid += f"    {actor.replace(' ', '')}[{info['icono']} {actor}]\n"
        
        # Agregar casos de uso
        uc_counter = 1
        for actor, info in self.actores.items():
            for caso_uso in info['casos_uso']:
                uc_id = f"UC{uc_counter}"
                mermaid += f"    {actor.replace(' ', '')} --> {uc_id}[{caso_uso}]\n"
                uc_counter += 1
        
        # Agregar relaciones entre casos de uso
        for origen, destino in self.relaciones:
            mermaid += f"    {origen.replace(' ', '')} --> {destino.replace(' ', '')}\n"
        
        # Agregar estilos
        mermaid += "\n    %% Estilos\n"
        mermaid += "    classDef actor fill:#e1f5fe,stroke:#01579b,stroke-width:3px\n"
        
        # Estilos por actor
        for actor, info in self.actores.items():
            color = info['color']
            stroke_color = self._get_stroke_color(color)
            actor_clean = actor.replace(' ', '')
            mermaid += f"    classDef {actor_clean.lower()} fill:{color},stroke:{stroke_color},stroke-width:2px\n"
        
        # Aplicar clases
        mermaid += f"    class {','.join([actor.replace(' ', '') for actor in self.actores.keys()])} actor\n"
        
        return mermaid

    def generar_mermaid_por_actor(self, actor_nombre):
        """Genera diagrama para un actor específico"""
        if actor_nombre not in self.actores:
            return "Actor no encontrado"
        
        info = self.actores[actor_nombre]
        mermaid = f"graph TB\n"
        mermaid += f"    {actor_nombre.replace(' ', '')}[{info['icono']} {actor_nombre}]\n"
        
        uc_counter = 1
        for caso_uso in info['casos_uso']:
            uc_id = f"UC{uc_counter}"
            mermaid += f"    {actor_nombre.replace(' ', '')} --> {uc_id}[{caso_uso}]\n"
            uc_counter += 1
        
        # Estilos
        mermaid += "\n    %% Estilos\n"
        mermaid += "    classDef actor fill:#e1f5fe,stroke:#01579b,stroke-width:3px\n"
        color = info['color']
        stroke_color = self._get_stroke_color(color)
        actor_clean = actor_nombre.replace(' ', '')
        mermaid += f"    classDef {actor_clean.lower()} fill:{color},stroke:{stroke_color},stroke-width:2px\n"
        mermaid += f"    class {actor_nombre.replace(' ', '')} actor\n"
        
        return mermaid

    def _get_stroke_color(self, fill_color):
        """Obtiene color de borde basado en color de relleno"""
        color_map = {
            '#ffebee': '#b71c1c',
            '#e8f5e8': '#1b5e20', 
            '#fff3e0': '#e65100',
            '#f1f8e9': '#33691e',
            '#f3e5f5': '#4a148c'
        }
        return color_map.get(fill_color, '#666')

    def generar_html_completo(self):
        """Genera archivo HTML completo con el diagrama"""
        html = f"""
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagrama de Casos de Uso - Sistema HDC</title>
    <script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js"></script>
    <style>
        body {{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }}
        .container {{
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }}
        .header {{
            background: linear-gradient(135deg, #27DB9F, #22c495);
            color: white;
            padding: 30px;
            text-align: center;
        }}
        .content {{
            padding: 30px;
        }}
        .diagram-container {{
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            min-height: 600px;
        }}
        .info-panel {{
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 0 8px 8px 0;
        }}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Diagrama de Casos de Uso - Sistema HDC</h1>
            <p>Generado automáticamente el {datetime.now().strftime('%d/%m/%Y a las %H:%M:%S')}</p>
        </div>
        
        <div class="content">
            <div class="info-panel">
                <h3>🎯 Información del Sistema</h3>
                <p>Este diagrama muestra todos los actores y casos de uso del Sistema HDC de Gestión de Reparaciones.</p>
            </div>
            
            <div class="diagram-container">
                <div id="diagrama"></div>
            </div>
        </div>
    </div>

    <script>
        mermaid.initialize({{
            startOnLoad: true,
            theme: 'default',
            themeVariables: {{
                primaryColor: '#27DB9F',
                primaryTextColor: '#333',
                primaryBorderColor: '#22c495'
            }}
        }});
    </script>
</body>
</html>
"""
        return html

    def generar_documentacion(self):
        """Genera documentación detallada de los casos de uso"""
        doc = f"""
# 📊 Documentación de Casos de Uso - Sistema HDC

## 🎯 Resumen del Sistema

**Sistema**: Gestión HDC - Servicios Electrónicos  
**Fecha de Generación**: {datetime.now().strftime('%d/%m/%Y %H:%M:%S')}  
**Total de Actores**: {len(self.actores)}  
**Total de Casos de Uso**: {sum(len(info['casos_uso']) for info in self.actores.values())}

## 👥 Actores del Sistema

"""
        
        for actor, info in self.actores.items():
            doc += f"""
### {info['icono']} {actor}

**Descripción**: {self._get_actor_description(actor)}  
**Casos de Uso**: {len(info['casos_uso'])}  
**Color**: {info['color']}

**Casos de Uso Asociados:**
"""
            for i, caso_uso in enumerate(info['casos_uso'], 1):
                doc += f"{i}. {caso_uso}\n"
            doc += "\n"

        doc += """
## 🔗 Relaciones entre Casos de Uso

"""
        for origen, destino in self.relaciones:
            doc += f"- **{origen}** → **{destino}**\n"

        doc += f"""
## 📈 Estadísticas del Sistema

- **Actores Principales**: {len([a for a in self.actores.keys() if a != 'Sistema'])}
- **Actores del Sistema**: 1
- **Casos de Uso por Actor**:
"""
        
        for actor, info in self.actores.items():
            doc += f"  - {actor}: {len(info['casos_uso'])} casos de uso\n"

        doc += f"""
- **Relaciones Identificadas**: {len(self.relaciones)}
- **Complejidad del Sistema**: {'Alta' if len(self.relaciones) > 10 else 'Media' if len(self.relaciones) > 5 else 'Baja'}

## 🛠️ Herramientas Recomendadas

1. **Mermaid Live Editor**: https://mermaid.live/
2. **Draw.io**: https://app.diagrams.net/
3. **Lucidchart**: https://www.lucidchart.com/
4. **Visio**: Para usuarios de Microsoft Office

## 📋 Próximos Pasos

1. Revisar y validar los casos de uso identificados
2. Detallar cada caso de uso con flujos específicos
3. Crear diagramas de secuencia para casos de uso complejos
4. Documentar reglas de negocio
5. Crear casos de prueba basados en los casos de uso

---
*Documento generado automáticamente por el Sistema HDC*
"""
        return doc

    def _get_actor_description(self, actor):
        """Obtiene descripción del actor"""
        descriptions = {
            'Administrador': 'Usuario con control total del sistema, puede gestionar todos los módulos y configuraciones.',
            'Técnico': 'Usuario especializado en reparaciones, maneja equipos y procesos técnicos.',
            'Usuario': 'Usuario con acceso limitado, puede consultar información básica del sistema.',
            'Cliente': 'Usuario externo que interactúa con el sistema para consultas y servicios.',
            'Sistema': 'Procesos automáticos del sistema que no requieren intervención humana.'
        }
        return descriptions.get(actor, 'Descripción no disponible')

    def guardar_archivos(self):
        """Guarda todos los archivos generados"""
        # Crear directorio si no existe
        os.makedirs('diagramas_casos_uso', exist_ok=True)
        
        # Generar y guardar diagrama completo
        mermaid_completo = self.generar_mermaid_completo()
        with open('diagramas_casos_uso/diagrama_completo.mmd', 'w', encoding='utf-8') as f:
            f.write(mermaid_completo)
        
        # Generar diagramas por actor
        for actor in self.actores.keys():
            mermaid_actor = self.generar_mermaid_por_actor(actor)
            with open(f'diagramas_casos_uso/diagrama_{actor.lower().replace(" ", "_")}.mmd', 'w', encoding='utf-8') as f:
                f.write(mermaid_actor)
        
        # Generar HTML completo
        html_completo = self.generar_html_completo()
        with open('diagramas_casos_uso/diagrama_interactivo.html', 'w', encoding='utf-8') as f:
            f.write(html_completo)
        
        # Generar documentación
        documentacion = self.generar_documentacion()
        with open('diagramas_casos_uso/documentacion_casos_uso.md', 'w', encoding='utf-8') as f:
            f.write(documentacion)
        
        # Generar JSON con datos
        datos_json = {
            'actores': self.actores,
            'relaciones': self.relaciones,
            'fecha_generacion': datetime.now().isoformat(),
            'version': '1.0'
        }
        with open('diagramas_casos_uso/datos_sistema.json', 'w', encoding='utf-8') as f:
            json.dump(datos_json, f, ensure_ascii=False, indent=2)
        
        print("✅ Archivos generados exitosamente en la carpeta 'diagramas_casos_uso'")
        print("📁 Archivos creados:")
        print("  - diagrama_completo.mmd")
        print("  - diagrama_administrador.mmd")
        print("  - diagrama_técnico.mmd")
        print("  - diagrama_usuario.mmd")
        print("  - diagrama_cliente.mmd")
        print("  - diagrama_sistema.mmd")
        print("  - diagrama_interactivo.html")
        print("  - documentacion_casos_uso.md")
        print("  - datos_sistema.json")

def main():
    """Función principal"""
    print("🚀 Generador de Diagrama de Casos de Uso - Sistema HDC")
    print("=" * 60)
    
    generador = GeneradorDiagramaCasosUso()
    
    print("\n📊 Generando diagramas...")
    generador.guardar_archivos()
    
    print("\n🎯 Para usar los diagramas:")
    print("1. Abre 'diagrama_interactivo.html' en tu navegador")
    print("2. Copia el código de 'diagrama_completo.mmd' a Mermaid Live Editor")
    print("3. Revisa la documentación en 'documentacion_casos_uso.md'")
    
    print("\n✨ ¡Diagramas generados exitosamente!")

if __name__ == "__main__":
    main()
