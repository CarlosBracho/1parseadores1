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





