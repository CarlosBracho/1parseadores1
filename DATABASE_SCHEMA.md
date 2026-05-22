# DATABASE_SCHEMA.md

## Información de Conexión
- **Host**: `172.233.161.9` (Remoto)
- **Base de Datos**: `apuestas`
- **Usuario**: `externo95`

## Tablas Identificadas
- `usuario`: Gestión de acceso y perfiles.
  - Campos detectados: `id_usuario`, `nom_usuario`, `pas_usuario`, `tip_usuario`, `est_usuario`, `hor_inicio`, `hor_fin`, `cod_taquilla`, `dia_entrada`, `niv_acceso`, `ZonaHorario`.
- `inscritos`: Registro de caballos de una carrera nacional.
  - Campos detectados: `cod_inscrito_hnac`, `cod_carrera_hnac`, `num_caballo_hnac`, `nom_caballo_hnac`, `nom_jinete_hnac`, `est_inscrito_hnac`.
- `carrera_hnac`: Registro de carreras nacionales.
  - Campos detectados: `cod_carrera_hnac`, `cod_hipodromo_hnac`, `num_carrera_hnac`, `fec_carrera_hnac`, `hor_carrera_hnac`, `est_carrera_hnac`, `can_caballos_hnac`.
- `venta_hnac`: Registro de transacciones de venta.
  - Campos detectados: `fec_venta_hnac`, `cod_carrera_hnac`, `num_ticket_hnac`, `mon_venta_hnac`, `num_caballo_hnac`, `cod_tventa_hnac`, `est_ticket_hnac`, `pag_premio_hnac`, `est_calculo_hnac`, `id_usuario`.
- `bitacora`: Registro de eventos y auditoría del sistema de apuestas.
  - Campos detectados: `des_bitacora`, `hor_bitacora`, `fec_bitacora`.
- `resultados_oficiales_hnac`: Registro de los dividendos y ganadores oficiales para carreras nacionales.
  - Campos detectados: `fec_resultado_hnac`, `cod_carrera_hnac`, `num_caballo_hnac`, `div_pago_hnac`, `fac_div_hnac`, `lin_dividendo`, `cod_tventa_hnac`, `est_empate_hnac`.
- `alertas_registros`: Trazabilidad e historial de auditoría de llamados y ejecuciones efectivas de las alertas.
  - Campos detectados: `id`, `id_alerta`, `tipo` (0 = Llamado, 1 = Ejecución Efectiva), `fecha_hora`, `ip_servidor`.

## Notas
- El esquema completo debe ser extraído del servidor remoto o del archivo `.sql` de respaldo más reciente.
- **VETO DE ESTRUCTURA**: Según la Regla 1.2, no se debe alterar la estructura de la BD directamente. Solicitar cambios al usuario.
- **Verificación 2026-05-21**: Se corroboró la existencia y fecha de modificación del archivo `apuestas_estructura.sql` en la raíz (modificado hoy mismo). No se realizaron alteraciones de esquema en MariaDB ni se crearon nuevos índices, respetando el veto de estructura, y se activaron por completo las escrituras transaccionales I/O reales en caliente para cierres de carrera y pre-carga de dividendos simples (estatus de confirmación 2).
- **Verificación 2026-05-22**: Los ajustes correctivos de la interfaz y botones en el módulo de alertas se realizaron sin modificar la estructura o esquema de base de datos.
- **Verificación 2026-05-22 (2)**: La corrección quirúrgica del modal de historial asíncrono se completó sin alteraciones a las tablas, campos o datos en la base de datos.
