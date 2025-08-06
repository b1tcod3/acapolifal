# ACA POLIFAL - Sistema de Gestión Académica

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<p align="center">
  <a href="https://github.com/b1tcod3/acapolifal/actions"><img src="https://github.com/b1tcod3/acapolifal/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Descripción del Proyecto

ACA POLIFAL es un sistema de gestión académica completo desarrollado con Laravel, Livewire y TailwindCSS. Este sistema permite administrar eficientemente todos los aspectos relacionados con la gestión educativa, incluyendo el control de estudiantes, docentes, instructores, horarios, asistencias, calificaciones y más.

## Características Principales

### 🔐 Sistema de Autenticación y Permisos
- Sistema de autenticación con Laravel Breeze
- Gestión de roles y permisos con Spatie Laravel Permission
- Perfiles de usuario personalizables
- Control de acceso basado en roles

### 👨‍🏫 Módulo de Gestión de Docentes
- **Registro de Docentes**: Gestión completa de información personal y profesional
- **Gestión de Horarios**: Asignación y visualización de horarios de clase
- **Control de Ausencias**: Registro y seguimiento de ausencias del personal docente
- **Asignación Académica**: Asignación de materias y grupos a los docentes
- **Gestión de Notas**: Registro y administración de calificaciones
- **Informes**: Generación de reportes estadísticos y académicos
- **Funcionalidad de Búsqueda**: Búsqueda avanzada de docentes por diversos criterios

### 👨‍🎓 Módulo de Gestión de Estudiantes
- **Registro de Estudiantes**: Gestión de información personal y de padres/tutores
- **Horarios**: Visualización de horarios de clase asignados
- **Control de Asistencias**: Registro de asistencias, inasistencias, retardos y permisos
- **Resultados de Notas**: Consulta de calificaciones y rendimiento académico
- **Informes Personales**: Generación de reportes individuales
- **Funcionalidad de Búsqueda**: Búsqueda avanzada de estudiantes

### 👨‍💼 Módulo de Gestión de Instructores
- **Registro de Instructores**: Gestión completa de información personal y profesional
- **Matrícula Asignada**: Visualización y gestión de grupos asignados
- **Informes Personales**: Generación de reportes individuales

### 📅 Módulo de Gestión de Horarios de Clase
- **Periodos de Clases**: Configuración de períodos académicos (inicio y fin)
- **Nombres de Aulas**: Gestión del inventario de aulas disponibles
- **Profesores/Instructores Asignados**: Asignación de personal a las clases
- **Asignaturas**: Gestión del catálogo de materias y cursos
- **Mostrar Horarios Completos**: Visualización integral de todos los horarios
- **Control de Asistencia**: Registro y seguimiento de asistencias
- **Bajas**: Gestión de solicitudes de bajas de estudiantes
- **Estadísticas**: Generación de reportes estadísticos sobre horarios y asistencias

### 📊 Sistema de Exportación de Datos
- **Exportación a Excel**: Generación de archivos Excel con datos filtrados
- **Exportación a CSV**: Creación de archivos CSV para análisis externo
- **Exportación a PDF**: Generación de informes en formato PDF
- **Filtros Avanzados**: Posibilidad de filtrar datos por múltiples criterios antes de exportar
- **Múltiples Módulos**: Exportación disponible para todos los módulos del sistema

## Tecnologías Utilizadas

- **Backend**: 
  - Laravel 10.x
  - PHP 8.1+
  
- **Frontend**:
  - Livewire
  - TailwindCSS
  - Alpine.js
  
- **Base de Datos**:
  - MySQL/MariaDB
  - Eloquent ORM
  
- **Autenticación y Permisos**:
  - Laravel Breeze
  - Spatie Laravel Permission
  
- **Exportación de Datos**:
  - Laravel Excel
  - PhpSpreadsheet

## Requisitos del Sistema

- PHP 8.1 o superior
- Composer
- MySQL/MariaDB 5.7+ o PostgreSQL 9.6+
- Node.js y NPM (para compilar assets)

## Instalación

1. **Clonar el repositorio**:
   ```bash
   git clone https://github.com/b1tcod3/acapolifal.git
   cd acapolifal
   ```

2. **Instalar dependencias de PHP**:
   ```bash
   composer install
   ```

3. **Instalar dependencias de Node.js**:
   ```bash
   npm install
   npm run build
   ```

4. **Configurar el entorno**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configurar la base de datos**:
   Editar el archivo `.env` con las credenciales de tu base de datos.

6. **Ejecutar migraciones y seeders**:
   ```bash
   php artisan migrate --seed
   ```

7. **Iniciar el servidor de desarrollo**:
   ```bash
   php artisan serve
   ```

## Uso

1. Accede a la aplicación en tu navegador: `http://localhost:8000`
2. Registra un nuevo usuario o inicia sesión con credenciales existentes
3. Navega por los diferentes módulos según los permisos asignados a tu rol

## Estructura del Proyecto

```
acapolifal/
├── app/
│   ├── Exports/           # Clases de exportación de datos
│   ├── Http/
│   │   ├── Controllers/   # Controladores de la aplicación
│   │   └── Livewire/      # Componentes Livewire
│   ├── Models/           # Modelos de Eloquent
│   └── Providers/        # Service providers
├── bootstrap/
├── config/
├── database/
│   ├── factories/        # Factorias de modelos
│   ├── migrations/       # Migraciones de la base de datos
│   └── seeders/          # Seeders de datos iniciales
├── public/
├── resources/
│   ├── js/               # Archivos JavaScript
│   ├── lang/             # Archivos de idioma
│   ├── livewire/         # Vistas de componentes Livewire
│   └── views/            # Vistas Blade
├── routes/
│   ├── api.php
│   ├── channels.php
│   ├── console.php
│   └── web.php
├── storage/
├── tests/
├── vendor/
└── .env.example
```

## Contribuir

Las contribuciones son bienvenidas. Por favor, sigue estos pasos:

1. Haz un fork del repositorio
2. Crea una rama de características (`git checkout -b feature/nueva-caracteristica`)
3. Realiza tus cambios y haz commit (`git commit -am 'Añadir nueva característica'`)
4. Empuja la rama (`git push origin feature/nueva-caracteristica`)
5. Crea un Pull Request

## Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más información.

## Contacto

Para cualquier consulta o soporte, por favor contacta a través de los issues del repositorio.

---

**Desarrollado con ❤️ para ACA POLIFAL**
