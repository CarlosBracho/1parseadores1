# ACCESOS.md

## Credenciales de Desarrollo y APIs

### 1. Plataforma de Apuestas INH
*   **URL de Acceso**: `https://apuestas.inh.gob.ve/`
*   **Usuario (Email)**: `carlos.bracho25@gmail.com`
*   **Contraseña**: `Kh8ze7*.$BS.f`
*   **Moneda de Control**: `VES`

### 2. Base de Datos Remota
*   **Host**: `172.233.161.9`
*   **Base de Datos**: `apuestas`
*   **Usuario**: `externo95`
*   **Nota**: Las credenciales se administran de forma aislada a través de `Connections/conexionbanca.php`.

### 3. Entorno de Servidor Local
*   **Servidor**: Laragon (Apache/Nginx)
*   **Ruta de PHP**: `E:\laragon\bin\php\php-8.3.29-nts-Win32-vs16-x64\php.exe`
*   **Ruta de Datos**: `E:\laragon\www\1parseadores1`
* **Última Verificación**: 2026-05-22 - Concluida la auditoría, modernización y habilitación de trazabilidad de IP del módulo de alertas. Los scripts y vistas compilan correctamente tras las correcciones de linter. Corregido el problema de botones inactivos y del modal de historial en `alertas_lista.php` mediante controladores 100% nativos (XMLHttpRequest y JS inline) y timeout de autodesbloqueo para formularios, añadiendo visualización de tiempo transcurrido desde ejecución/llamado mediante subconsultas SQL.

