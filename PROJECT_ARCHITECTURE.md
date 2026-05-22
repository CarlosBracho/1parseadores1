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
El orquestador `parseadores_ia/web_scraping_inh.php` crea de forma automatizada carreras nuevas e inscritos en la base de datos, concilia y muta directamente los estados en la tabla `inscritos`, delega el reintegro e invalidación de apuestas al motor de tickets (`includes/procesar_ticket_retirados_hnac.php` y `includes/procesar_ticket_reintegraret_hnac.php`) en tiempo real, e intercepta la transición de estados de carreras para automatizar localmente el cierre de las mismas mutando la tabla `carrera_hnac` y registrando el evento en la tabla `bitacora`. También evalúa la consistencia de arranque ante estados cerrados preexistentes en la red, previene bucles infinitos de procesamiento de retirados, e intercepta el arribo de ganadores y dividendos para realizar la pre-carga atómica activa de resultados simples en `resultados_oficiales_hnac` y forzar el estatus de revisión humana `est_confirmacion_hnac = 2` en caliente.

## Módulo de Alertas y Trazabilidad
Se cuenta con un sistema de auditoría y monitoreo sobre las alertas de sincronización (`includes/watchandwager_creador.php` y `includes/mtp_betbird.php`). Toda invocación (Llamado - Tipo 0) o corrida exitosa tras superar los filtros de reposo (Ejecución Efectiva - Tipo 1) es registrada en la tabla `alertas_registros` indicando la IP física del servidor mediante una rutina multi-entorno robusta. El panel administrativo (`admin/alertas_lista.php` y `admin/alertas_edit.php`) ha sido rediseñado con Bootstrap y un visor modal asíncrono (`admin/alertas_historial_ajax.php`) cargado por jQuery AJAX para inspeccionar los últimos 100 movimientos de cada alerta de forma fluida.
