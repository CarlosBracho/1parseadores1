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

## Notas
- El esquema completo debe ser extraído del servidor remoto o del archivo `.sql` de respaldo más reciente.
- **VETO DE ESTRUCTURA**: Según la Regla 1.2, no se debe alterar la estructura de la BD directamente. Solicitar cambios al usuario.
- **Verificación 2026-05-21**: Se corroboró la existencia y fecha de modificación del archivo `apuestas_estructura.sql` en la raíz (modificado hoy mismo). No se realizaron alteraciones de esquema en MariaDB ni se crearon nuevos índices, respetando el veto de estructura.

