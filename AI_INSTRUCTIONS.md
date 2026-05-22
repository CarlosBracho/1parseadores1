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
*   **Persistencia Real**: En entornos productivos, asegurar que todas las sentencias de mutación de base de datos (`mysqli_query`) (incluyendo creación de carreras, retirados, cierres en caliente, consistencia de arranque y pre-carga de dividendos simples) estén activas y no permanezcan comentadas.
*   **Optimización de Consultas (N+1 / Bulk Update)**: Evita bucles que disparen consultas a la base de datos de manera reiterada. Consolida la lectura en consultas `SELECT` unificadas que usen `JOIN`s, y realiza actualizaciones masivas (`UPDATE`) utilizando arrays divididos en lotes (`array_chunk`) con la cláusula `IN (...)` para proteger la red WAN y no saturar `max_allowed_packet` en MariaDB.
*   **Filtro de Consistencia en Arranque**: En orquestadores orientados a eventos (daemons), implementa filtros de consistencia inicial (como `!isset($viejo['status'])`) para procesar estados críticos preexistentes. Realiza una verificación SELECT defensiva y resguarda la ejecución de escrituras comentadas o activas mediante flags de caché para evitar duplicidades I/O bajo ráfagas intensas de red.
*   **Creación Automática (Fase 3)**: Al habilitar inserciones automatizadas de carreras, se debe estructurar la inserción física de la cabecera (`carrera_hnac`) y la plantilla de competidores (`inscritos`), empleando obligatoriamente el sanitizador rígido `GetSQLValueString` con tipos específicos y asignando el estatus inicial reglamentario (`5` en carrera y cierre).
*   **Pre-carga de Dividendos y Redondeo**: Para acoplar dividendos a la escala de taquillas, divide el dividendo del stream (base 100) estrictamente entre 10 y redondea a 2 decimales. Inserta 4 registros correspondientes a las líneas 11, 12, 13 y 14 en `resultados_oficiales_hnac` y actualiza `carrera_hnac` fijando `est_confirmacion_hnac = 2`. Controla la redundancia en ráfagas utilizando una bandera lógica (`dividendos_registrados`) en caché volátil.
*   **Módulo de Alertas y Trazabilidad**: En scripts de control y alertas (CLI/Cron), implementa la captura de IP multi-entorno mediante fallback dinámico (Web a CLI) y finalizadores seguros (Regla 9.3) para evitar bloqueos. En vistas de edición y listados, rediseña utilizando clases nativas de Bootstrap 4 y delega cargas de datos pesadas/historiales a endpoints asíncronos AJAX (`alertas_historial_ajax.php`) para no sobrecargar el hilo de renderizado principal. Valida siempre la sintaxis con el linter de PHP CLI ante cualquier refactorización lógica para evitar desbalances de llaves, y asegura que la bandera `statusEnvio` y la función `chequearEnvio()` estén definidas en todas las vistas con formularios para evitar ReferenceError en el cliente.
