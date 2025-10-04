# 🎨 Guía de Uso - PlantUML para Sistema HDC

## 📋 **Archivos PlantUML Creados**

### 1. **`diagrama_plantuml_hdc.puml`** - Diagrama Completo
- **Descripción**: Diagrama completo con todos los actores y casos de uso
- **Actores**: Administrador, Técnico, Usuario, Cliente, Sistema
- **Casos de Uso**: 30 casos de uso identificados
- **Relaciones**: Incluye dependencias e inclusiones
- **Uso**: Para documentación completa del sistema

### 2. **`diagrama_plantuml_simple.puml`** - Versión Simplificada
- **Descripción**: Versión limpia y fácil de leer
- **Actores**: Administrador, Técnico, Usuario, Cliente
- **Casos de Uso**: Casos principales sin detalles excesivos
- **Relaciones**: Dependencias básicas
- **Uso**: Para presentaciones y documentación general

### 3. **`diagrama_plantuml_administrador.puml`** - Solo Administrador
- **Descripción**: Diagrama específico para el rol de Administrador
- **Actores**: Solo Administrador
- **Casos de Uso**: 12 casos de uso del administrador
- **Relaciones**: Dependencias específicas del administrador
- **Uso**: Para documentar funcionalidades administrativas

## 🚀 **Cómo Usar en PlantUML**

### **Paso 1: Acceder a PlantUML**
1. Ve a **https://www.plantuml.com/plantuml/uml/**
2. O usa **PlantUML Online**: https://www.plantuml.com/plantuml/

### **Paso 2: Copiar el Código**
1. Abre el archivo `.puml` que quieras usar
2. Copia **todo el contenido** del archivo
3. Pégalo en el editor de PlantUML

### **Paso 3: Generar el Diagrama**
1. El diagrama se generará automáticamente
2. Si no aparece, haz clic en **"Submit"** o **"Refresh"**
3. Espera a que se procese el código

### **Paso 4: Exportar**
1. Haz clic en **"PNG"** para descargar como imagen
2. Haz clic en **"SVG"** para descargar como vector
3. Usa **"ASCII Art"** para texto plano

## 🎯 **Código Listo para Copiar**

### **Para Diagrama Completo:**
```plantuml
@startuml DiagramaCasosUsoHDC

!theme plain
skinparam backgroundColor #FFFFFF
skinparam actor {
    BackgroundColor #E1F5FE
    BorderColor #01579B
    FontColor #000000
}
skinparam usecase {
    BackgroundColor #F3E5F5
    BorderColor #4A148C
    FontColor #000000
}

title Diagrama de Casos de Uso - Sistema HDC\nServicios Electrónicos

left to right direction

' Actores del Sistema
actor "👨‍💼 Administrador" as Admin
actor "🔧 Técnico" as Tecnico
actor "👤 Usuario" as Usuario
actor "👥 Cliente" as Cliente
actor "🤖 Sistema" as Sistema

' Rectángulo del sistema
rectangle "Sistema HDC - Gestión de Reparaciones" {
    
    ' Casos de Uso del Administrador
    usecase "Gestionar Usuarios" as UC1
    usecase "Gestionar Técnicos" as UC2
    usecase "Gestionar Clientes" as UC3
    usecase "Gestionar Equipos" as UC4
    usecase "Gestionar Reparaciones" as UC5
    usecase "Gestionar Inventario" as UC6
    usecase "Gestionar Tickets" as UC7
    usecase "Ver Dashboard Completo" as UC8
    usecase "Generar Reportes" as UC9
    usecase "Configurar Sistema" as UC10
    usecase "Gestionar Permisos" as UC11
    
    ' Casos de Uso del Técnico
    usecase "Ver Tareas Asignadas" as UC12
    usecase "Gestionar Reparaciones Asignadas" as UC13
    usecase "Actualizar Estado Reparaciones" as UC14
    usecase "Gestionar Equipos" as UC15
    usecase "Ver Dashboard Personalizado" as UC16
    usecase "Generar Tickets" as UC17
    usecase "Gestionar Inventario Limitado" as UC18
    
    ' Casos de Uso del Usuario
    usecase "Ver Dashboard Básico" as UC19
    usecase "Gestionar Clientes Limitado" as UC20
    usecase "Ver Reparaciones Solo Lectura" as UC21
    usecase "Ver Equipos Solo Lectura" as UC22
    
    ' Casos de Uso del Cliente
    usecase "Consultar Estado Reparación" as UC23
    usecase "Recibir Notificaciones" as UC24
    usecase "Firmar Tickets" as UC25
    usecase "Recibir Equipos Reparados" as UC26
    
    ' Casos de Uso del Sistema
    usecase "Enviar Notificaciones" as UC27
    usecase "Generar Estadísticas" as UC28
    usecase "Backup Automático" as UC29
    usecase "Validar Datos" as UC30
    
    ' Casos de Uso de Autenticación (Comunes)
    usecase "Iniciar Sesión" as UC_AUTH1
    usecase "Cerrar Sesión" as UC_AUTH2
    usecase "Recuperar Contraseña" as UC_AUTH3
    usecase "Cambiar Contraseña" as UC_AUTH4
}

' Relaciones del Administrador
Admin --> UC1
Admin --> UC2
Admin --> UC3
Admin --> UC4
Admin --> UC5
Admin --> UC6
Admin --> UC7
Admin --> UC8
Admin --> UC9
Admin --> UC10
Admin --> UC11
Admin --> UC_AUTH1
Admin --> UC_AUTH2
Admin --> UC_AUTH3
Admin --> UC_AUTH4

' Relaciones del Técnico
Tecnico --> UC12
Tecnico --> UC13
Tecnico --> UC14
Tecnico --> UC15
Tecnico --> UC16
Tecnico --> UC17
Tecnico --> UC18
Tecnico --> UC_AUTH1
Tecnico --> UC_AUTH2
Tecnico --> UC_AUTH3
Tecnico --> UC_AUTH4

' Relaciones del Usuario
Usuario --> UC19
Usuario --> UC20
Usuario --> UC21
Usuario --> UC22
Usuario --> UC_AUTH1
Usuario --> UC_AUTH2
Usuario --> UC_AUTH3
Usuario --> UC_AUTH4

' Relaciones del Cliente
Cliente --> UC23
Cliente --> UC24
Cliente --> UC25
Cliente --> UC26

' Relaciones del Sistema
Sistema --> UC27
Sistema --> UC28
Sistema --> UC29
Sistema --> UC30

' Relaciones entre casos de uso (Dependencias)
UC5 ..> UC13 : <<include>>
UC4 ..> UC5 : <<include>>
UC3 ..> UC4 : <<include>>
UC2 ..> UC12 : <<include>>
UC1 ..> UC2 : <<include>>
UC6 ..> UC18 : <<include>>
UC7 ..> UC17 : <<include>>
UC8 ..> UC16 : <<include>>
UC8 ..> UC19 : <<include>>

@enduml
```

### **Para Diagrama Simplificado:**
```plantuml
@startuml SistemaHDC

!theme plain
skinparam backgroundColor #FFFFFF
skinparam actor {
    BackgroundColor #E1F5FE
    BorderColor #01579B
    FontColor #000000
}
skinparam usecase {
    BackgroundColor #F3E5F5
    BorderColor #4A148C
    FontColor #000000
}

title Sistema HDC - Diagrama de Casos de Uso

left to right direction

' Actores
actor "Administrador" as Admin
actor "Técnico" as Tecnico  
actor "Usuario" as Usuario
actor "Cliente" as Cliente

' Sistema
rectangle "Sistema HDC" {
    
    ' Casos de Uso Administrador
    usecase "Gestionar Usuarios" as UC1
    usecase "Gestionar Técnicos" as UC2
    usecase "Gestionar Clientes" as UC3
    usecase "Gestionar Equipos" as UC4
    usecase "Gestionar Reparaciones" as UC5
    usecase "Gestionar Inventario" as UC6
    usecase "Gestionar Tickets" as UC7
    usecase "Ver Dashboard Completo" as UC8
    usecase "Generar Reportes" as UC9
    usecase "Configurar Sistema" as UC10
    
    ' Casos de Uso Técnico
    usecase "Ver Tareas Asignadas" as UC12
    usecase "Gestionar Reparaciones Asignadas" as UC13
    usecase "Actualizar Estado Reparaciones" as UC14
    usecase "Ver Dashboard Personalizado" as UC16
    usecase "Generar Tickets" as UC17
    
    ' Casos de Uso Usuario
    usecase "Ver Dashboard Básico" as UC19
    usecase "Gestionar Clientes Limitado" as UC20
    usecase "Ver Reparaciones Solo Lectura" as UC21
    usecase "Ver Equipos Solo Lectura" as UC22
    
    ' Casos de Uso Cliente
    usecase "Consultar Estado Reparación" as UC23
    usecase "Recibir Notificaciones" as UC24
    usecase "Firmar Tickets" as UC25
    usecase "Recibir Equipos Reparados" as UC26
    
    ' Autenticación
    usecase "Iniciar Sesión" as UC_AUTH
    usecase "Cerrar Sesión" as UC_LOGOUT
}

' Relaciones Administrador
Admin --> UC1
Admin --> UC2
Admin --> UC3
Admin --> UC4
Admin --> UC5
Admin --> UC6
Admin --> UC7
Admin --> UC8
Admin --> UC9
Admin --> UC10
Admin --> UC_AUTH
Admin --> UC_LOGOUT

' Relaciones Técnico
Tecnico --> UC5
Tecnico --> UC12
Tecnico --> UC13
Tecnico --> UC14
Tecnico --> UC16
Tecnico --> UC17
Tecnico --> UC_AUTH
Tecnico --> UC_LOGOUT

' Relaciones Usuario
Usuario --> UC19
Usuario --> UC20
Usuario --> UC21
Usuario --> UC22
Usuario --> UC_AUTH
Usuario --> UC_LOGOUT

' Relaciones Cliente
Cliente --> UC23
Cliente --> UC24
Cliente --> UC25
Cliente --> UC26

' Dependencias entre casos de uso
UC5 ..> UC13 : <<include>>
UC4 ..> UC5 : <<include>>
UC3 ..> UC4 : <<include>>
UC2 ..> UC12 : <<include>>
UC1 ..> UC2 : <<include>>

@enduml
```

## 🎨 **Personalización de Colores**

### **Colores del Sistema HDC:**
```plantuml
skinparam actor {
    BackgroundColor #E1F5FE  ' Azul claro
    BorderColor #01579B      ' Azul oscuro
    FontColor #000000        ' Negro
}
skinparam usecase {
    BackgroundColor #F3E5F5  ' Morado claro
    BorderColor #4A148C      ' Morado oscuro
    FontColor #000000        ' Negro
}
```

### **Colores por Rol:**
```plantuml
' Administrador - Rojo
skinparam actor {
    BackgroundColor #FFEBEE
    BorderColor #B71C1C
}

' Técnico - Verde
skinparam actor {
    BackgroundColor #E8F5E8
    BorderColor #1B5E20
}

' Usuario - Naranja
skinparam actor {
    BackgroundColor #FFF3E0
    BorderColor #E65100
}

' Cliente - Verde claro
skinparam actor {
    BackgroundColor #F1F8E9
    BorderColor #33691E
}
```

## 📊 **Tipos de Relaciones en PlantUML**

### **1. Asociación Simple:**
```plantuml
Actor --> UseCase
```

### **2. Inclusión (Include):**
```plantuml
UseCase1 ..> UseCase2 : <<include>>
```

### **3. Extensión (Extend):**
```plantuml
UseCase1 ..> UseCase2 : <<extend>>
```

### **4. Generalización:**
```plantuml
UseCase1 --|> UseCase2
```

## 🛠️ **Herramientas Alternativas**

### **1. PlantUML Online (Recomendado)**
- URL: https://www.plantuml.com/plantuml/
- No requiere instalación
- Exporta a múltiples formatos

### **2. PlantUML Local**
- Instalar Java
- Descargar PlantUML JAR
- Usar desde línea de comandos

### **3. VS Code con PlantUML**
- Instalar extensión "PlantUML"
- Vista previa en tiempo real
- Exportación integrada

### **4. IntelliJ IDEA**
- Plugin PlantUML integrado
- Generación automática
- Integración con documentación

## 🎯 **Consejos de Uso**

### **✅ Mejores Prácticas:**
1. **Usa nombres descriptivos** para actores y casos de uso
2. **Agrupa casos de uso** relacionados en el mismo rectángulo
3. **Usa relaciones apropiadas** (include, extend, asociación)
4. **Mantén el diagrama legible** - no sobrecargues con detalles
5. **Usa colores consistentes** para diferentes tipos de elementos

### **❌ Evita:**
1. **Demasiados casos de uso** en un solo diagrama
2. **Relaciones cruzadas** excesivas
3. **Nombres muy largos** que dificulten la lectura
4. **Colores muy contrastantes** que cansen la vista
5. **Diagramas muy complejos** sin documentación adicional

## 📈 **Métricas del Sistema HDC**

- **Total de Actores**: 5
- **Total de Casos de Uso**: 30
- **Casos de Uso por Actor**:
  - Administrador: 11
  - Técnico: 7
  - Usuario: 4
  - Cliente: 4
  - Sistema: 4
- **Relaciones Identificadas**: 9
- **Complejidad**: Media-Alta

## 🚀 **Próximos Pasos**

1. **Copia el código** que prefieras usar
2. **Pégalo en PlantUML Online**
3. **Genera el diagrama**
4. **Exporta en el formato** que necesites
5. **Personaliza los colores** según tu marca
6. **Agrega más detalles** si es necesario

**¡Tu diagrama de casos de uso está listo para usar en PlantUML! 🎉**
