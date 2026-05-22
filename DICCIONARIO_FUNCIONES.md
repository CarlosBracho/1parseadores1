# DICCIONARIO_FUNCIONES.md

## Módulo: WatchandWager

| Componente | Tipo | Descripción |
|------------|------|-------------|
| **Bloque Detección AJAX** | Lógica PHP | Intercepta peticiones con `?ajax=1` para retornar exclusivamente el HTML de la tabla de resultados. |
| **resultsModal** | UI (HTML/CSS) | Contenedor modal premium con overlay para visualización de detalles. |
| **fetch(Results)** | JavaScript | Función asíncrona que carga el detalle de la carrera en el modal sin recargar la página. |
| **Stream Context** | PHP (Context) | Configuración de User-Agent para peticiones seguras a servidores externos. |
| **watchandwager_creador.php** | Script | Automatización de programación de carreras. Incluye validación de Alerta 41 y filtrado de hipódromos. |
| **Normalización (UPPER+TRIM)** | Lógica PHP | Técnica de comparación de strings para asegurar el emparejamiento entre API y BD local. |
| **Módulo Visual Diagnóstico** | UI/Lógica | Desglose analítico de dividendos, detección de Dead Heats y formateo de exóticas ( - a / ) en el modal. |
| **Premium UI Results** | HTML/CSS | Maquetación de alta fidelidad (image_dccfd6.png) con cabecera azul y cuerpo gris para resultados oficiales. |
| **Iteración Anidada Payouts** | Lógica PHP | Doble bucle `foreach` sobre `pools` y `payouts` para asegurar la extracción total de dividendos y exóticas. |
| **Algoritmo Conteo Único** | Lógica PHP | Uso de `preg_replace` y arrays asociativos para contar ejemplares sin duplicidad por sufijos (1, 1a). |
| **Verificación Integridad** | Lógica PHP | Comparación atómica de `can_caballos` entre API y BD para actualizar carreras existentes. |
| **Búsqueda Dinámica Carrera** | Lógica PHP | Localización de objeto de carrera por atributo `number` mediante `foreach`, evitando errores por indexación lineal del array. |
| **alreadyLoggedIn** | JavaScript | Lógica de detección de estado de sesión persistente en `inh_bot.js` mediante evaluación de texto en el DOM de la SPA para omitir flujos redundantes de autenticación. |
| **launchOptions (userDataDir, ignoreDefaultArgs)** | Opciones de Lanzamiento | Parámetros avanzados de Puppeteer configurados dinámicamente para persistencia de perfil y evasión del WAF (Cloudflare). |
| **Network.webSocketFrameReceived** | Event Listener CDP | Intercepta tramas del WebSocket de INH en tiempo real para escribirlas de forma síncrona en disco en archivos JSON cronológicos bajo `img/` con mitigación síncrona de errores y control de buffer en stdout. |
| **page.waitForFunction (Competición de Hidratación)** | Lógica de Sincronización | Espera condicional competitiva en `inh_bot.js` de hasta 15s que compite entre la visualización del saldo `'VES'` y el botón de inicio de sesión, mitigando condiciones de carrera. |
| **Bypass Modal Pago Móvil (try/catch)** | Despacho de Interceptores | Bloque defensivo en `inh_bot.js` que detecta y realiza clics síncronos en el checkbox de aceptación y en el botón de continuación del modal obligatorio de información de pago. |
| **Sanitización de Transporte (Prefijo 42)** | Sanitización de Red | Recorta posicionalmente los dos primeros bytes (`42`) de la trama del WebSocket para aislar la cadena JSON nativa. |
| **Navegación Defensiva GQL** | Parseo en Memoria | Itera de forma defensiva sobre la colección GraphQL `allTracks.nodes` e `racesByTracksId.nodes` descartando nodos nulos o de control. |
| **Formateador Unificado (stdout)** | Formateo de Red | Concatena estados de carreras bajo la sintaxis `r,${raceNumber},${statusId}` delimitados por puntos (`.`) y vaciados en una sola línea continua en `stdout`. |
| **Extracción trackName** | Lógica GQL | Extrae de manera segura la propiedad string `trackNode.trackName` para identificar la pista del evento hípico. |
| **despacharAlertaTelegram** | Despachador PHP | Envía alertas a Telegram vía cURL con codificación nativa UTF-8 sin usar `utf8_encode()`, deshabilitando opcionalmente la verificación de certificados SSL para mayor resiliencia. |
| **Matriz estadoCarreras** | Memoria Volátil | Array bidimensional en PHP (`$estadoCarreras[$trackName][$raceNumber] = $statusId`) para mantener los estados y efectuar la intercepción diferencial. |
| **Alerta Cierre Manual (cURL)** | Envío Telegram | Bloque cURL síncrono inyectado en `admin_apertura_cierre.php` que formatea el mensaje de cierre manual del usuario con hora, minutos y segundos exactos mediante `date()`, con límites estrictos de latencia de 3 segundos para el entorno Linux. |
| **Alerta Cierre Manual HNAC (cURL)** | Envío Telegram | Bloque cURL síncrono inyectado en `admin_apertura_cierre_hnac.php` que formatea el mensaje de cierre manual de carrera nacional del usuario con hora, minutos y segundos exactos mediante `date()`, con límites estrictos de latencia de 3 segundos para el entorno Linux. |
| **Manejadores de Salida Fail-Fast** | Event Listeners JS | Escuchadores `page.on('error')`, `page.on('disconnected')` y `browser.on('disconnected')` en `inh_bot.js` para abortar de forma rápida y limpia ante colapsos de Chromium y alertar al supervisor de PHP. |
| **Lazo Supervisor No Bloqueante** | Robustez / Resiliencia | Estructura iterativa `while (true)` en `web_scraping_inh.php` que lee el flujo del bot mediante streams no bloqueantes, valida timeouts de inactividad de 120s, y asegura la liberación de descriptores de archivos de perfil mediante retardos controlados de 5 segundos. |
| **horsesRacesByRacesId.nodes** | Iteración GQL | Nodo profundo de colección de caballos procesado en `bot/inh_bot.js` para extraer dorsales de participación y banderas de retiro. |
| **maxProgramNumber** | Variable JS | Acumulador dinámico en `bot/inh_bot.js` que captura el valor entero más alto de `programNumber` por carrera (densidad de ejemplares inscritos). |
| **retiradosArr / retiradosString** | Matriz / Cadena JS | Vector de control que recolecta e integra mediante guiones (`-`) los caballos retirados de la carrera (`statusId === '2'`), asignando `'0'` por defecto si no existen retirados. |
| **resultsInhsByRacesId.nodes** | Iteración GQL | Nodo profundo de dividendos oficiales procesado defensivamente en `bot/inh_bot.js` para extraer las posiciones oficiales de llegada. |
| **ganadoresArr / dividendosArr** | Matrices JS | Vectores de recolección temporal en `bot/inh_bot.js` para retener caballos en `position === 1` y sus dividendos `win` respectivos. |
| **ganadorString / dividendoString** | Cadenas JS / PHP | Cadenas de texto que consolidan ganadores y dividendos con soporte para empates múltiples y fallback condicional de `0` en ambos lenguajes. |
| **Separador de Tres Puntos (...)** | Tokenización | Delimitador structural de alta resiliencia integrado para segmentar bloques de carrera individuales sin riesgo de colisión. |
| **date('g:i s') . 's'** | Telemetría | Formateador dinámico nativo de PHP para prefijar el instante exacto de procesamiento del bloque de carrera en consola. |
| **inicializacionNotificada** | Bandera Global | Control booleano global en `web_scraping_inh.php` para disparar el mensaje de inicialización de red única ("nacionales automaticas activadas") a Telegram. |
| **estadoCarreras (Multidimensional)** | Memoria Volátil | Estructura indexada `$estadoCarreras[$trackName][$raceNumber]` que retiene un array asociativo con estados individuales de estatus, retirados, ganador y dividendo por carrera. |
| **Trazabilidad SQL (updateSQL)** | Trazabilidad | Comentario interno `/* Origen: web_scraping_inh.php */` en la consulta UPDATE para identificar de manera unívoca la procedencia de la mutación física de retirados. |
| **procesar_ticket_reintegraret_hnac.php** | Script PHP | Script optimizado para el reintegro de tickets de caballos nacionales (HNAC). Unifica la lectura en una sola consulta y utiliza Bulk Update en lotes para eliminar la latencia de red. |
| **Bulk Update (IN chunks)** | Optimización BD | Técnica de actualización masiva estructurada en lotes de 200 IDs en `procesar_ticket_reintegraret_hnac.php` para evitar sobrecargar MariaDB y optimizar la escritura WAN. |
| **alerta_cierre_enviada** | Bandera Volátil | Flag en la caché `$estadoCarreras` para evitar el procesamiento redundante y la duplicidad de sentencias SQL en MariaDB ante ráfagas del WebSocket. |
| **cierreCarreraSQL / insertBitacoraSQL** | Lógica SQL | Sentencias SQL locales estructuradas en `web_scraping_inh.php` para emular el cierre físico de una carrera nacional y registrar el evento en `bitacora` (activadas en producción). |
| **Filtro Consistencia Arranque** | Lógica PHP | Evaluación condicional `!isset($viejo['status'])` en `web_scraping_inh.php` para detectar e interceptar tramas cerradas iniciales contra MariaDB. |
| **Precedencia Topológica (Retirados/Consistencia)** | Regla de Diseño | Orden lineal en `web_scraping_inh.php` donde retirados se procesa tras resolver `$codCarreraReal`, conviviendo con la consistencia de arranque de forma no bloqueante. |
| **Creaciones Automáticas (Fase 3)** | Lógica SQL (I/O) | Bloque transaccional de creación que inserta automáticamente carreras e inscritos (plantilla con caballos SIN ASIGNAR, estatus activo 1) en MariaDB 10 cuando compruebaCarr_hnac() retorna 0. |
| **dividendos_registrados** | Bandera Volátil | Flag en la caché `$estadoCarreras` para mitigar duplicados e impedir ejecuciones de inserción redundantes de dividendos. |
| **Conversión Matemática de Dividendos** | Algoritmo PHP | Conversión proporcional de base de 100 del stream a escala de 10 de taquillas mediante división por 10 y redondeo a 2 decimales. |
| **insLugar1SQL a insLugar4SQL / updateConfirmacionSQL** | Lógica SQL | Sentencias locales para la pre-carga atómica de los 4 resultados oficiales obligatorios y la actualización de cabecera a revisión (confirmación 2), activas en producción. |
| **obtener_ip_servidor** | Función PHP | Rutina multi-entorno tolerante a fallos para capturar la IP física real del servidor en entornos Web y CLI/consola. |
| **finalizar_script_alertas** | Función PHP | Finalizador limpio compatible con la Regla 9.3 para scripts CLI que asegura la limpieza del buffer y la salida ordenada. |
| **alertas_historial_ajax.php** | Script AJAX | Controlador AJAX ligero para consultar y retornar la tabla con los últimos 100 movimientos de una alerta en `alertas_registros`. |
| **admin/alertas_lista.php (Clásico)** | UI / Lógica PHP | Panel principal de alertas reestructurado en base a una tabla clásica compacta y de alta densidad que hereda `.contentAdmin` y `.xfirefox` de `estilo/admin.css` sobre fondo `#E5E5E5`, cargando explícitamente la librería `alertify` para solventar ReferenceError ante caídas de red. |
| **Bypass Híbrido Historial (JS)** | Script JS | Mecanismo en `alertas_lista.php` desacoplado de las librerías JS de Bootstrap mediante CSS moderno personalizado que neutraliza estilos heredados de Bootstrap 2.0.3 y un disparador directo jQuery con delegación de eventos. |
| **admin/alertas_edit.php (Clásico)** | UI / Lógica PHP | Formulario clásico de configuración con ancho de 920px, fondo `#E1E1E1`, contenedores de tabla clásicos y cajas de texto de clase `.textbox`, manteniendo intacta la lógica horaria manual. |
| **chequearEnvio** | Función JavaScript | Función global de seguridad que previene envíos redundantes o dobles clics en formularios de administración usando la bandera `statusEnvio`. |
