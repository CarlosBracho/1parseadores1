# PROJECT_ARCHITECTURE.md

## Descripción General
Este proyecto es una aplicación Web basada en PHP para la gestión de apuestas hípicas y loterías. Utiliza Laragon como entorno de desarrollo local.

## Tecnologías Utilizadas
- **Backend**: PHP 8.x
- **Base de Datos**: MySQL (Conexión remota detectada en `Connections/conexionbanca.php`)
- **Frontend**: HTML, CSS (Bootstrap 4/5), JavaScript (jQuery, SpryAssets)
- **Servidor**: Apache/Nginx (Laragon)

## Estructura de Directorios Principal
- `admin/`: Módulo de administración.
- `agente/`: Módulo para agentes.
- `distri/`: Módulo para distribuidores.
- `includes/`: Lógica central, funciones y librerías.
- `Connections/`: Configuraciones de conexión a base de datos.
- `ventas/`: Módulos de venta y taquilla.
- `parseadores_ia/`: Scripts relacionados con el procesamiento de datos externos e IA.

## Flujo de Datos
La aplicación se conecta a una base de datos remota para gestionar usuarios, apuestas y resultados. Los "parseadores" se encargan de obtener información de carreras en tiempo real.
