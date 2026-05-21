# AI_INSTRUCTIONS.md

## Reglas y Directrices para Agentes de IA

Este documento recopila las instrucciones operativas y técnicas para cualquier IA que interactúe con el repositorio `1parseadores1`.

---

### 1. Entorno y Rutas del Sistema
*   **SO Local**: Windows (Laragon)
*   **Binario PHP local**: `E:\laragon\bin\php\php-8.3.29-nts-Win32-vs16-x64\php.exe`
*   **SO Producción**: Linux (VPS AlmaLinux)
*   **Binario Puppeteer Linux**: `/usr/lib64/chromium-browser/chromium-browser`
*   **Aislamiento**: Siempre realiza pruebas e instrumentaciones bajo `pruebas_ia/` utilizando el canal de terminal PowerShell dividido.

### 2. Estructura y Patrones en Puppeteer (`bot/inh_bot.js`)
*   **Persistencia de Perfil**: Utiliza `userDataDir` apuntando a `../bot_profile` de forma relativa. Esto previene re-autenticaciones excesivas y mitiga el bloqueo por Cloudflare ("Rate exceeded").
*   **Control de Regresión en Login**: Al usar perfiles persistentes, la sesión puede estar previamente iniciada. Siempre verifica si el texto `"VES"` se encuentra en el DOM antes de disparar el modal de login.
*   **Evasión Anti-WAF**:
    *   Inyecta `--disable-blink-features=AutomationControlled` a las banderas de lanzamiento.
    *   Remueve los argumentos predeterminados nativos agregando `ignoreDefaultArgs: ['--enable-automation']` para evitar exponer la propiedad `navigator.webdriver`.
*   **Persistencia de Datos del WebSocket**:
    *   Las tramas masivas del listener CDP (`Network.webSocketFrameReceived`) no deben enviarse a `stdout` para no saturar los descriptores de salida del orquestador PHP.
    *   Persiste cada trama en disco síncronamente como JSON utilizando marcas de tiempo en milisegundos (`Date.now()`) bajo la ruta relativa `imgDir`.
    *   Usa siempre `process.platform !== 'win32'` para aplicar `fs.chmodSync(filePath, 0o644)` sin arrojar errores en desarrollo local bajo Windows.

### 3. Buenas Prácticas y Calidad
*   **DRY (Don't Repeat Yourself)**: Evita duplicar constantes globales como `imgDir`. Declara y crea el directorio una sola vez antes de registrar los listeners.
*   **Modificaciones Quirúrgicas**: Realiza ediciones mínimas en líneas específicas en lugar de reescribir funciones completas para mantener el control de cambios limpio.
*   **Trazabilidad SQL**: Toda consulta SQL debe tener un comentario inicial describiendo su origen (ej. `/* Origen: NombreFuncion / Archivo.php */` o `/* Origen: Archivo.php */`).
*   **Persistencia Real**: En entornos productivos, asegurar que las sentencias de mutación de base de datos (`mysqli_query`) y la inclusión de scripts transaccionales (`procesar_ticket_retirados_hnac.php`) estén activas y no permanezcan comentadas.
*   **Optimización de Consultas (N+1 / Bulk Update)**: Evita bucles que disparen consultas a la base de datos de manera reiterada. Consolida la lectura en consultas `SELECT` unificadas que usen `JOIN`s, y realiza actualizaciones masivas (`UPDATE`) utilizando arrays divididos en lotes (`array_chunk`) con la cláusula `IN (...)` para proteger la red WAN y no saturar `max_allowed_packet` en MariaDB.
*   **Filtro de Consistencia en Arranque**: En orquestadores orientados a eventos (daemons), implementa filtros de consistencia inicial (como `!isset($viejo['status'])`) para procesar estados críticos preexistentes. Realiza una verificación SELECT defensiva y resguarda la ejecución de escrituras comentadas o activas mediante flags de caché para evitar duplicidades I/O bajo ráfagas intensas de red.

