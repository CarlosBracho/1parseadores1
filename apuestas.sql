# Host: 172.233.161.9  (Version 11.8.6-MariaDB-log)
# Date: 2026-05-20 06:25:31
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "agencia"
#

CREATE TABLE `agencia` (
  `cod_agencia` int(11) NOT NULL AUTO_INCREMENT,
  `nom_agencia` varchar(30) NOT NULL,
  `nom_representante` varchar(30) DEFAULT NULL,
  `cod_banca` int(11) NOT NULL,
  `dir_agencia` varchar(30) DEFAULT '',
  `cor_agencia` varchar(30) NOT NULL,
  `tel_agencia` varchar(15) DEFAULT NULL,
  `tel_agencia2` varchar(15) DEFAULT '',
  `tel_agencia3` varchar(15) DEFAULT '',
  `cre_agencia` decimal(10,2) NOT NULL,
  `est_agencia` int(1) NOT NULL DEFAULT 0,
  `agen_vende_ame` int(1) DEFAULT NULL,
  `agen_por_ame` decimal(10,2) DEFAULT NULL,
  `agen_por_ame_tipo` int(2) DEFAULT 0,
  `agen_vende_hnac` int(1) DEFAULT NULL,
  `agen_cob_hnac` decimal(10,2) DEFAULT 0.00,
  `agen_cob_hnac_tipo` int(11) DEFAULT 0,
  `agen_vende_parley` int(1) DEFAULT NULL,
  `agen_por_parley` decimal(10,2) DEFAULT NULL,
  `agen_por_parley_tipo` int(2) DEFAULT 0,
  `por_agencia_hnac` decimal(10,2) DEFAULT 0.00,
  `agen_vende_ani` int(11) DEFAULT 0,
  `agen_por_ani` decimal(10,2) DEFAULT 0.00,
  `agen_por_ani_tipo` int(2) DEFAULT 0,
  `cob_agencia_hnac` decimal(10,2) DEFAULT 0.00,
  `por_agencia_lot` decimal(10,2) DEFAULT 0.00,
  `por_agencia_macu` decimal(10,2) DEFAULT 0.00,
  `alerta_corte_age` int(1) DEFAULT 0,
  `tipo_pagoa` int(12) DEFAULT 0,
  `saldoactuala` decimal(12,2) DEFAULT NULL,
  `sinoclaves` int(11) DEFAULT 0,
  `sinomoneda` int(2) DEFAULT 0,
  `reporte_new_ag` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cod_agencia`),
  UNIQUE KEY `cod_agencia` (`cod_agencia`),
  UNIQUE KEY `nom_agencia` (`nom_agencia`),
  KEY `cod_banca` (`cod_banca`)
) ENGINE=InnoDB AUTO_INCREMENT=1566 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "agencialoterias"
#

CREATE TABLE `agencialoterias` (
  `id_agelot` int(11) NOT NULL AUTO_INCREMENT,
  `id_agencia` int(11) NOT NULL,
  `id_loteria` int(11) NOT NULL,
  `est_agelot` tinyint(1) NOT NULL,
  `top_ventaage` decimal(10,2) NOT NULL,
  `lun_loteria` tinyint(1) NOT NULL,
  `mar_loteria` tinyint(1) NOT NULL,
  `mie_loteria` tinyint(1) NOT NULL,
  `jue_loteria` tinyint(1) NOT NULL,
  `vie_loteria` tinyint(1) NOT NULL,
  `sab_loteria` tinyint(1) NOT NULL,
  `dom_loteria` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_agelot`),
  UNIQUE KEY `id_agelot` (`id_agelot`),
  KEY `id_agencia` (`id_agencia`),
  KEY `id_loteria` (`id_loteria`),
  KEY `est_agelot` (`est_agelot`),
  KEY `lun_loteria` (`lun_loteria`),
  KEY `mar_loteria` (`mar_loteria`),
  KEY `mie_loteria` (`mie_loteria`),
  KEY `jue_loteria` (`jue_loteria`),
  KEY `vie_loteria` (`vie_loteria`),
  KEY `sab_loteria` (`sab_loteria`),
  KEY `dom_loteria` (`dom_loteria`)
) ENGINE=InnoDB AUTO_INCREMENT=904 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "alertas"
#

CREATE TABLE `alertas` (
  `Idalertas` int(11) NOT NULL AUTO_INCREMENT,
  `nombrealerta` varchar(255) DEFAULT '',
  `contadoralerta` int(11) DEFAULT 0,
  `fec_alerta` date DEFAULT '0000-00-00',
  `hor_alerta` time DEFAULT '00:00:00',
  `cont_fallos_reporte` int(2) DEFAULT 0,
  `contadorfallos` int(5) DEFAULT 0,
  `ultima_bien` datetime DEFAULT '0000-00-00 00:00:00',
  `timestamp_alertas` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pausa` int(2) DEFAULT 0,
  `activo_archivo` int(1) DEFAULT 3,
  `horainicio` time DEFAULT '00:00:00',
  `horafin` time DEFAULT '00:00:00',
  `min_para_reportar` int(11) DEFAULT 30,
  `mensajealerta` varchar(255) DEFAULT '0',
  `id_chat` varchar(50) DEFAULT '0',
  `id_chat_error` varchar(50) DEFAULT '0',
  `mini_para_repetir` int(11) DEFAULT 1,
  `link_principal` varchar(255) DEFAULT 'Aqui se coloca el linkd e donde se ejecutan de manera utomatica',
  `comentario` varchar(255) DEFAULT 'Aqui se coloca como funciona',
  `mensajealerta_error` varchar(255) DEFAULT '0',
  `tiem_sin_ejecucion_permitido` int(4) DEFAULT 500,
  PRIMARY KEY (`Idalertas`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "ani1_loterias_y_nombres"
#

CREATE TABLE `ani1_loterias_y_nombres` (
  `id_Loterias_y_nombres_ani1` int(11) NOT NULL AUTO_INCREMENT,
  `nom_Loterias_y_nombres_ani1` varchar(50) DEFAULT NULL,
  `animales_Loterias_y_nombres_ani1` varchar(1500) DEFAULT NULL,
  `horas_solteos_ani1` varchar(500) DEFAULT NULL,
  `estado_ani1` int(11) DEFAULT 0,
  `multiplooficial_ani1` int(11) DEFAULT 0,
  PRIMARY KEY (`id_Loterias_y_nombres_ani1`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "ani2_topes"
#

CREATE TABLE `ani2_topes` (
  `id_tope_ani2` int(11) NOT NULL AUTO_INCREMENT,
  `topes_puesto_x_ani2` int(11) DEFAULT NULL,
  `topes_tipo_ani2` int(11) DEFAULT NULL,
  `monto_tope_ani2` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id_tope_ani2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "ani3_reglas_taquilla"
#

CREATE TABLE `ani3_reglas_taquilla` (
  `id_reglas_taquilla_ani3` int(11) NOT NULL AUTO_INCREMENT,
  `cod_taquilla_ani3` int(11) DEFAULT NULL,
  `monto_minimo_jugada_ani3` decimal(12,2) DEFAULT NULL,
  `monto_maximo_jugada_ani3` decimal(12,2) DEFAULT NULL,
  `monto_minimo_ticket_ani3` decimal(12,2) DEFAULT NULL,
  `monto_maximo_ticket_ani3` decimal(12,2) DEFAULT NULL,
  `solteos_excluidos_ani3` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_reglas_taquilla_ani3`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "ani4_solteos"
#

CREATE TABLE `ani4_solteos` (
  `id_solteo_ani4` int(11) NOT NULL AUTO_INCREMENT,
  `id_Loterias_y_nombres_ani4` int(11) DEFAULT NULL,
  `fechahora_solteo_ani4` datetime DEFAULT NULL,
  `estado_ani4` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_solteo_ani4`),
  KEY `fechahora_solteo_ani4` (`fechahora_solteo_ani4`),
  KEY `idx_fecha_solteo` (`fechahora_solteo_ani4`)
) ENGINE=InnoDB AUTO_INCREMENT=157962 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "ani5_jugadas"
#

CREATE TABLE `ani5_jugadas` (
  `id_ticket_ani5` int(11) NOT NULL AUTO_INCREMENT,
  `num_ticket_ani5` int(11) DEFAULT NULL,
  `can_ticket_ani5` int(11) DEFAULT NULL,
  `ser_venta_ani5` bigint(20) DEFAULT NULL,
  `id_loteria_ani5` int(11) DEFAULT NULL,
  `id_solteo_ani5` int(11) DEFAULT NULL,
  `id_animalito_ani5` int(11) DEFAULT NULL,
  `jug_num_ani5` int(11) DEFAULT NULL,
  `cod_taquilla_ani5` int(11) DEFAULT NULL,
  `id_usuario_ani5` int(11) DEFAULT NULL,
  `fechahora_creacion_ani5` datetime NOT NULL,
  `linea_ticket_ani5` int(11) DEFAULT NULL,
  `mon_venta_ani5` decimal(12,2) DEFAULT NULL,
  `ip_venta_ani5` varchar(50) DEFAULT NULL,
  `mon_pago_ani5` decimal(12,2) DEFAULT NULL,
  `ip_pago_ani5` varchar(50) DEFAULT NULL,
  `fechahora_pago_ani5` datetime DEFAULT NULL,
  `estado_ticket_ani5` int(11) DEFAULT NULL,
  `moneda_ani5` int(11) NOT NULL DEFAULT 0,
  `estadojugada_ani5` int(11) NOT NULL DEFAULT 0,
  `ani_verificado_ani5` int(1) DEFAULT 0,
  PRIMARY KEY (`id_ticket_ani5`,`fechahora_creacion_ani5`),
  KEY `reporte_ani` (`cod_taquilla_ani5`,`fechahora_creacion_ani5`,`id_solteo_ani5`,`linea_ticket_ani5`,`id_ticket_ani5`) USING BTREE,
  KEY `usuario_fecha_ani5` (`id_usuario_ani5`,`fechahora_creacion_ani5`),
  KEY `fecha_ani5` (`fechahora_creacion_ani5`),
  KEY `idx_optimizacion_sorteo_estado` (`id_solteo_ani5`,`estado_ticket_ani5`,`id_ticket_ani5`),
  KEY `idx_ticket_busqueda_rapida` (`num_ticket_ani5`,`estadojugada_ani5`),
  KEY `idx_reporte_diario_usuario` (`id_usuario_ani5`,`fechahora_creacion_ani5`,`fechahora_pago_ani5`),
  KEY `idx_opt_ani5_reporte` (`cod_taquilla_ani5`,`fechahora_creacion_ani5`,`linea_ticket_ani5`)
) ENGINE=InnoDB AUTO_INCREMENT=6313242 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci
 PARTITION BY RANGE (to_days(`fechahora_creacion_ani5`))
(PARTITION `p_historico` VALUES LESS THAN (739982) ENGINE = InnoDB,
 PARTITION `p2026_01` VALUES LESS THAN (740013) ENGINE = InnoDB,
 PARTITION `p2026_02` VALUES LESS THAN (740041) ENGINE = InnoDB,
 PARTITION `p2026_03` VALUES LESS THAN (740072) ENGINE = InnoDB,
 PARTITION `p2026_04` VALUES LESS THAN (740102) ENGINE = InnoDB,
 PARTITION `p2026_05` VALUES LESS THAN (740133) ENGINE = InnoDB,
 PARTITION `p2026_06` VALUES LESS THAN (740163) ENGINE = InnoDB,
 PARTITION `p2026_07` VALUES LESS THAN (740194) ENGINE = InnoDB,
 PARTITION `p2026_08` VALUES LESS THAN (740225) ENGINE = InnoDB,
 PARTITION `p2026_09` VALUES LESS THAN (740255) ENGINE = InnoDB,
 PARTITION `p2026_10` VALUES LESS THAN (740286) ENGINE = InnoDB,
 PARTITION `p2026_11` VALUES LESS THAN (740316) ENGINE = InnoDB,
 PARTITION `p2026_12` VALUES LESS THAN (740347) ENGINE = InnoDB,
 PARTITION `p_futuro` VALUES LESS THAN MAXVALUE ENGINE = InnoDB);

#
# Structure for table "ani6_resultados"
#

CREATE TABLE `ani6_resultados` (
  `id_resultado_ani6` int(11) NOT NULL AUTO_INCREMENT,
  `id_solteo_ani6` int(11) DEFAULT NULL,
  `resultado_ani6` int(11) DEFAULT NULL,
  `fechahora_resultado_ani6` datetime DEFAULT NULL,
  PRIMARY KEY (`id_resultado_ani6`) USING BTREE,
  KEY `fechahora_aniresultados` (`fechahora_resultado_ani6`),
  KEY `idx_opt_sorteo_fecha` (`id_solteo_ani6`,`fechahora_resultado_ani6`),
  KEY `idx_solteo_resultado` (`id_solteo_ani6`,`fechahora_resultado_ani6`)
) ENGINE=InnoDB AUTO_INCREMENT=136645 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "ani7_opc"
#

CREATE TABLE `ani7_opc` (
  `id_ani7` int(11) NOT NULL AUTO_INCREMENT,
  `cod_taquilla` int(11) NOT NULL,
  `sorteos_ani_bloq` varchar(250) NOT NULL,
  `fecha_ani7` date NOT NULL,
  `limite_global_d` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_ani7`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "animales"
#

CREATE TABLE `animales` (
  `id_animal` int(11) NOT NULL AUTO_INCREMENT,
  `num_animal` varchar(2) NOT NULL,
  `nom_animal` varchar(30) NOT NULL,
  `nom_corto` varchar(5) NOT NULL,
  `img_animal` varchar(300) NOT NULL,
  PRIMARY KEY (`id_animal`),
  UNIQUE KEY `cod_signo` (`id_animal`),
  KEY `cod_signo_2` (`id_animal`),
  KEY `nom_corto` (`nom_corto`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "balance"
#

CREATE TABLE `balance` (
  `id_balance` int(11) NOT NULL AUTO_INCREMENT,
  `id_factura` int(11) NOT NULL,
  `fec_balance` date NOT NULL,
  `cod_banca` int(11) NOT NULL,
  `des_balance` varchar(500) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tip_balance` int(1) NOT NULL,
  `sem_factura` varchar(7) NOT NULL,
  `mon_balance` double(10,2) NOT NULL,
  `fec_proceso` date NOT NULL,
  `hor_balance` time NOT NULL,
  `est_balance` int(1) NOT NULL,
  PRIMARY KEY (`id_balance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "balance_detalle"
#

CREATE TABLE `balance_detalle` (
  `id_bdetalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_balance` int(11) NOT NULL,
  `doc_balance` text NOT NULL,
  `id_cuenta` int(11) NOT NULL,
  PRIMARY KEY (`id_bdetalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "balanceclientes"
#

CREATE TABLE `balanceclientes` (
  `Idbalancecli` int(11) NOT NULL AUTO_INCREMENT,
  `numticket` bigint(5) NOT NULL DEFAULT 0,
  `cod_taquilla` int(11) NOT NULL,
  `monto` decimal(12,2) DEFAULT NULL,
  `jugada` text NOT NULL,
  `fec_venta` date DEFAULT NULL,
  `hor_venta` time DEFAULT NULL,
  `saldoactualc` decimal(12,2) DEFAULT NULL,
  `monedac` int(11) DEFAULT 0,
  `tipo` int(11) NOT NULL DEFAULT 0,
  `modulo` int(11) DEFAULT 0,
  `agregadox` int(11) DEFAULT 0,
  `newconomonetario` int(11) DEFAULT 0,
  PRIMARY KEY (`Idbalancecli`),
  KEY `cod_taquilla_saldo` (`cod_taquilla`),
  KEY `idx_opt_balance_taq_mon` (`cod_taquilla`,`monedac`,`Idbalancecli`),
  KEY `idx_opt_chat_pago` (`numticket`,`modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=817230 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "balanceclientes2"
#

CREATE TABLE `balanceclientes2` (
  `Idbalancecli` int(11) NOT NULL AUTO_INCREMENT,
  `numticket` bigint(5) NOT NULL DEFAULT 0,
  `cod_taquilla` int(11) NOT NULL,
  `monto` decimal(12,2) DEFAULT NULL,
  `jugada` text NOT NULL,
  `fec_venta` date DEFAULT NULL,
  `hor_venta` time DEFAULT NULL,
  `saldoactualc` decimal(12,2) DEFAULT NULL,
  `monedac` int(11) DEFAULT 0,
  `tipo` int(11) NOT NULL DEFAULT 0,
  `modulo` int(11) DEFAULT 0,
  `agregadox` int(11) DEFAULT 0,
  `newconomonetario` int(11) DEFAULT 0,
  PRIMARY KEY (`Idbalancecli`),
  KEY `cod_taquilla_saldo` (`cod_taquilla`)
) ENGINE=InnoDB AUTO_INCREMENT=42761 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "banca"
#

CREATE TABLE `banca` (
  `cod_banca` int(11) NOT NULL AUTO_INCREMENT,
  `nom_banca` varchar(30) NOT NULL,
  `tel_banca` varchar(15) DEFAULT '',
  `tel_banca2` varchar(15) DEFAULT '',
  `tel_banca3` varchar(15) DEFAULT '',
  `cor_banca` varchar(30) NOT NULL,
  `dir_banca` varchar(30) DEFAULT '',
  `fec_banca` date NOT NULL,
  `nom_representante` varchar(30) DEFAULT '',
  `marquesina` text NOT NULL,
  `info1` varchar(30) DEFAULT NULL,
  `info11` varchar(300) DEFAULT NULL,
  `info2` varchar(30) DEFAULT NULL,
  `info22` varchar(300) DEFAULT NULL,
  `info3` varchar(30) DEFAULT NULL,
  `info33` varchar(300) DEFAULT NULL,
  `info4` varchar(30) DEFAULT NULL,
  `info44` varchar(300) DEFAULT NULL,
  `info5` varchar(30) DEFAULT NULL,
  `info55` varchar(300) DEFAULT NULL,
  `est_banca` int(1) NOT NULL DEFAULT 0,
  `dist_vende_ame` int(1) DEFAULT NULL,
  `dist_por_ame` decimal(10,2) DEFAULT NULL,
  `dist_vende_hnac` int(1) DEFAULT NULL,
  `dist_cob_hnac` decimal(10,2) DEFAULT NULL,
  `por_banca_hnac` decimal(10,2) NOT NULL DEFAULT 0.00,
  `por_banca_lot` decimal(10,2) NOT NULL DEFAULT 0.00,
  `por_banca_macu` decimal(10,2) NOT NULL DEFAULT 0.00,
  `con_tope` int(1) NOT NULL,
  `top_triple_lot` decimal(10,2) NOT NULL,
  `top_terminal_lot` decimal(10,2) NOT NULL,
  `mod_resultado` int(1) DEFAULT NULL,
  `alerta_corte_dis` int(1) DEFAULT 0,
  `dist_vende_parley` int(1) DEFAULT NULL,
  `dist_por_parley` decimal(10,2) DEFAULT NULL,
  `sinoclavesdistri` int(11) DEFAULT 0,
  `sinomonedadistri` int(2) DEFAULT 0,
  `cobrodirectoDT` int(1) DEFAULT 0,
  `cod_multidistriMDBA` int(11) DEFAULT 0,
  `dist_vende_ani` int(11) DEFAULT 0,
  `dist_por_ani` decimal(10,2) DEFAULT 0.00,
  `dist_cob_hnac_tipo` int(2) DEFAULT 0,
  `cierre_hnac` varchar(500) NOT NULL,
  `fecha_cierre_hnac` date NOT NULL,
  `acceso_bloq` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cod_banca`)
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "bancaloterias"
#

CREATE TABLE `bancaloterias` (
  `id_banlot` int(11) NOT NULL AUTO_INCREMENT,
  `id_banca` int(11) NOT NULL,
  `id_loteria` int(11) NOT NULL,
  `est_banlot` int(1) NOT NULL,
  `hor_cierre` time NOT NULL,
  `top_venta` decimal(10,2) DEFAULT NULL,
  `pre_loteria` decimal(10,2) NOT NULL,
  `lun_loteriabanca` int(1) NOT NULL,
  `mar_loteriabanca` int(1) NOT NULL,
  `mie_loteriabanca` int(1) NOT NULL,
  `jue_loteriabanca` int(1) NOT NULL,
  `vie_loteriabanca` int(1) NOT NULL,
  `sab_loteriabanca` int(1) NOT NULL,
  `dom_loteriabanca` int(1) NOT NULL,
  PRIMARY KEY (`id_banlot`)
) ENGINE=InnoDB AUTO_INCREMENT=3613 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "bancos"
#

CREATE TABLE `bancos` (
  `id_banco` int(11) NOT NULL AUTO_INCREMENT,
  `nom_banco` varchar(50) NOT NULL,
  `est_banco` int(1) NOT NULL,
  PRIMARY KEY (`id_banco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "bitacora"
#

CREATE TABLE `bitacora` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `des_bitacora` varchar(200) DEFAULT NULL,
  `fec_bitacora` date DEFAULT NULL,
  `hor_bitacora` time DEFAULT NULL,
  `codtaquilla` int(11) DEFAULT 0,
  PRIMARY KEY (`Id`),
  KEY `codtaquilla` (`codtaquilla`)
) ENGINE=InnoDB AUTO_INCREMENT=240697 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "bloqueadoloterias"
#

CREATE TABLE `bloqueadoloterias` (
  `id_bloqueado` int(11) NOT NULL AUTO_INCREMENT,
  `num_bloqueado` varchar(3) NOT NULL,
  `id_sorteo` int(11) NOT NULL,
  `id_loteria` int(11) NOT NULL,
  `tip_rango` int(1) NOT NULL,
  `des_bloqueado` date NOT NULL,
  `has_bloqueado` date NOT NULL,
  `id_taquilla` int(11) NOT NULL,
  `id_agencia` int(11) NOT NULL,
  `id_banca` int(11) NOT NULL,
  `tip_modulo` int(1) NOT NULL,
  PRIMARY KEY (`id_bloqueado`),
  UNIQUE KEY `cod_bloqueado` (`id_bloqueado`),
  KEY `num_bloqueado` (`num_bloqueado`),
  KEY `id_banca` (`id_banca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "carrera"
#

CREATE TABLE `carrera` (
  `cod_carrera` int(11) NOT NULL AUTO_INCREMENT,
  `cod_banca` int(11) NOT NULL,
  `cod_hipodromo` int(11) NOT NULL DEFAULT 0,
  `nom_hipodromo` varchar(30) NOT NULL,
  `nom_hipodromo_hpi` varchar(40) NOT NULL,
  `fec_carrera` date NOT NULL,
  `hor_carrera` time NOT NULL,
  `num_carrera` int(11) NOT NULL,
  `est_carrera` int(11) NOT NULL,
  `est_cierre` int(1) NOT NULL,
  `est_confirmacion` int(1) NOT NULL,
  `can_caballos` int(11) NOT NULL,
  `eje_primero` int(11) DEFAULT 0,
  `div_primero_gan` decimal(10,2) DEFAULT NULL,
  `div_primero_pla` decimal(10,2) NOT NULL,
  `div_primero_sho` decimal(10,2) NOT NULL,
  `eje_segundo` int(11) NOT NULL,
  `div_segundo_pla` decimal(10,2) NOT NULL,
  `div_segundo_sho` decimal(10,2) NOT NULL,
  `eje_tercero` int(11) NOT NULL,
  `div_tercero_sho` decimal(10,2) NOT NULL,
  `eje_cuarto` int(11) NOT NULL,
  `eje_doble_primero` int(11) NOT NULL,
  `div_doble_primero_gan` decimal(10,2) NOT NULL,
  `div_doble_primero_pla` decimal(10,2) NOT NULL,
  `div_doble_primero_sho` decimal(10,2) NOT NULL,
  `eje_doble_segundo` int(11) NOT NULL,
  `div_doble_segundo_pla` decimal(10,2) NOT NULL,
  `div_doble_segundo_sho` decimal(10,2) NOT NULL,
  `eje_doble_tercero` int(11) NOT NULL,
  `div_doble_tercero_sho` decimal(10,2) NOT NULL,
  `eje_doble_cuarto` int(11) NOT NULL,
  `eje_triple_primero` int(11) NOT NULL,
  `div_triple_primero_gan` decimal(10,2) NOT NULL,
  `div_triple_primero_pla` decimal(10,2) NOT NULL,
  `div_triple_primero_sho` decimal(10,2) NOT NULL,
  `eje_triple_segundo` int(11) NOT NULL,
  `div_triple_segundo_pla` decimal(10,2) NOT NULL,
  `div_triple_segundo_sho` decimal(10,2) NOT NULL,
  `eje_triple_tercero` int(11) NOT NULL,
  `div_triple_tercero_sho` decimal(10,2) NOT NULL,
  `eje_triple_cuarto` int(11) NOT NULL,
  `div_exacta` decimal(10,2) NOT NULL,
  `fac_exacta` decimal(10,2) NOT NULL,
  `div_trifecta` decimal(10,2) NOT NULL,
  `fac_trifecta` decimal(10,2) NOT NULL,
  `div_superfecta` decimal(10,2) NOT NULL,
  `fac_superfecta` decimal(10,2) NOT NULL,
  `hor_mtp` time NOT NULL,
  `mtp_control` int(11) NOT NULL DEFAULT 0,
  `div_exacta_doble` decimal(10,2) DEFAULT NULL,
  `div_trifecta_doble` decimal(10,2) DEFAULT NULL,
  `div_superfecta_doble` decimal(10,2) DEFAULT NULL,
  `div_exacta_triple` decimal(10,2) DEFAULT NULL,
  `div_trifecta_triple` decimal(10,2) DEFAULT NULL,
  `div_superfecta_triple` decimal(10,2) DEFAULT NULL,
  `ord_exacta` varchar(5) DEFAULT NULL,
  `ord_exacta_doble` varchar(5) DEFAULT NULL,
  `ord_exacta_triple` varchar(5) DEFAULT NULL,
  `ord_trifecta` varchar(8) DEFAULT NULL,
  `ord_trifecta_doble` varchar(8) DEFAULT NULL,
  `ord_trifecta_triple` varchar(8) DEFAULT NULL,
  `ord_superfecta` varchar(22) DEFAULT NULL,
  `ord_superfecta_doble` varchar(11) DEFAULT NULL,
  `ord_superfecta_triple` varchar(11) DEFAULT NULL,
  `control_dividendo` int(1) NOT NULL DEFAULT 0,
  `mtp_tipo` int(2) NOT NULL DEFAULT 0,
  `supercontrol` int(11) NOT NULL DEFAULT 0,
  `CERRADOX` varchar(255) DEFAULT '',
  `pau_ventas` int(1) NOT NULL,
  `pau_pagos` int(1) NOT NULL,
  `contador_cierres` int(11) NOT NULL DEFAULT 0,
  `mtp1` int(11) DEFAULT 0,
  `mtp2` int(11) DEFAULT 0,
  `mtp3` int(11) DEFAULT 0,
  `mtp4` int(11) DEFAULT 0,
  `mtp5` int(11) DEFAULT 0,
  `mtp6` int(11) DEFAULT 0,
  `mtp7` int(11) DEFAULT 0,
  `delayapertura` int(11) DEFAULT 0,
  `betbirdvista` int(2) DEFAULT 0,
  `confirmandox` int(11) DEFAULT 0,
  `ABIERTOX` varchar(30) DEFAULT '0',
  `horaapertura` time DEFAULT '00:00:00',
  `hconfir` time DEFAULT '00:00:00',
  `simulcast` int(1) DEFAULT 0,
  `TipoApuestas` varchar(255) DEFAULT '0',
  `pickresultados` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT '0',
  `cod_racebets` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cod_carrera`),
  UNIQUE KEY `cod_carrera` (`cod_carrera`),
  KEY `cod_banca` (`cod_banca`),
  KEY `fec_carrera` (`fec_carrera`),
  KEY `hor_carrera` (`hor_carrera`),
  KEY `num_carrera` (`num_carrera`),
  KEY `est_carrera` (`est_carrera`),
  KEY `est_cierre` (`est_cierre`),
  KEY `est_confirmacion` (`est_confirmacion`),
  KEY `nom_hipodromo` (`nom_hipodromo`),
  KEY `idx_opt_carrera_offtrack_filtro` (`fec_carrera`,`est_carrera`,`est_cierre`,`simulcast`,`eje_primero`)
) ENGINE=InnoDB AUTO_INCREMENT=942540 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "carrera_hnac"
#

CREATE TABLE `carrera_hnac` (
  `cod_carrera_hnac` int(11) NOT NULL AUTO_INCREMENT,
  `cod_hipodromo_hnac` int(11) NOT NULL,
  `fec_carrera_hnac` date NOT NULL,
  `hor_carrera_hnac` time NOT NULL,
  `est_carrera_hnac` int(1) NOT NULL,
  `est_cierre_hnac` int(1) NOT NULL,
  `can_caballos_hnac` int(3) NOT NULL,
  `num_carrera_hnac` int(2) NOT NULL,
  `dis_carrera_hnac` int(5) NOT NULL,
  `mtp_control_hnac` int(1) NOT NULL,
  `est_confirmacion_hnac` int(1) NOT NULL,
  `aperturadelay` int(1) NOT NULL DEFAULT 0,
  `cierredelay` int(1) NOT NULL DEFAULT 0,
  `pau_ventas_hnac` int(1) DEFAULT 0,
  `pau_pagos_hnac` int(1) DEFAULT 0,
  `xcierres` int(11) DEFAULT 0,
  PRIMARY KEY (`cod_carrera_hnac`),
  KEY `cod_carrera_hnac` (`cod_carrera_hnac`),
  KEY `cod_hipodromo_hnac` (`cod_hipodromo_hnac`),
  KEY `fec_carrera_hnac` (`fec_carrera_hnac`),
  KEY `est_carrera_hnac` (`est_carrera_hnac`),
  KEY `est_cierre_hnac` (`est_cierre_hnac`),
  KEY `est_confirmacion_hnac` (`est_confirmacion_hnac`),
  KEY `mtp_control_hnac` (`mtp_control_hnac`)
) ENGINE=InnoDB AUTO_INCREMENT=10136 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "chat2"
#

CREATE TABLE `chat2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from1` varchar(255) NOT NULL DEFAULT '',
  `to1` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `sentdate` date NOT NULL,
  `senttime` time NOT NULL,
  `recd` int(10) unsigned NOT NULL DEFAULT 0,
  `id_taquilla` int(11) NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT 0,
  `nom_sup` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sentdate` (`sentdate`),
  KEY `recd` (`recd`),
  KEY `tipo` (`tipo`),
  KEY `from1` (`from1`),
  KEY `to1` (`to1`),
  KEY `id_taquilla` (`id_taquilla`)
) ENGINE=InnoDB AUTO_INCREMENT=172909 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "chat7"
#

CREATE TABLE `chat7` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from1` varchar(30) NOT NULL,
  `to1` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `sentdate` date NOT NULL,
  `senttime` time NOT NULL,
  `recd` int(11) NOT NULL DEFAULT 0,
  `tipo` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `from1` (`from1`),
  KEY `to1` (`to1`),
  KEY `sentdate` (`sentdate`)
) ENGINE=InnoDB AUTO_INCREMENT=22532 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "cobranza"
#

CREATE TABLE `cobranza` (
  `idcobranzaCOB` bigint(11) NOT NULL AUTO_INCREMENT,
  `tipoCOB` int(2) DEFAULT NULL,
  `comentarioCOB` varchar(500) DEFAULT NULL,
  `tipoclienteCOB` int(2) DEFAULT NULL,
  `identificadorCOB` int(2) DEFAULT NULL,
  `montoagregarCOB` decimal(12,0) DEFAULT NULL,
  `montototalCOB` decimal(12,0) DEFAULT NULL,
  `confirmadoCOB` int(2) DEFAULT NULL,
  `fechacreacionCOB` datetime DEFAULT NULL,
  `fechaconfirmacionCOB` datetime DEFAULT NULL,
  `quiencobraCOB` int(2) DEFAULT NULL,
  PRIMARY KEY (`idcobranzaCOB`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "cobro_hnac"
#

CREATE TABLE `cobro_hnac` (
  `id_cobrohnacpunto` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `fec_creacion` date NOT NULL,
  `cod_taquilla` int(11) NOT NULL,
  `cod_agencia` int(11) NOT NULL,
  `cod_banca` int(11) NOT NULL,
  PRIMARY KEY (`id_cobrohnacpunto`),
  KEY `cod_taquilla` (`cod_taquilla`),
  KEY `fec_creacion` (`fec_creacion`),
  KEY `cod_agencia` (`cod_agencia`),
  KEY `cod_banca` (`cod_banca`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=23636 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

#
# Structure for table "control_panel"
#

CREATE TABLE `control_panel` (
  `id_control_panel` int(11) NOT NULL AUTO_INCREMENT,
  `control_nombre` varchar(250) DEFAULT NULL,
  `control_estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_control_panel`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "cookies"
#

CREATE TABLE `cookies` (
  `id_cookie` int(11) NOT NULL AUTO_INCREMENT,
  `cookinombre` varchar(50) DEFAULT NULL,
  `cookiefull` varchar(10000) DEFAULT NULL,
  `errorcookie` int(11) DEFAULT 0,
  PRIMARY KEY (`id_cookie`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "ctrol_ventpag_global_ame"
#

CREATE TABLE `ctrol_ventpag_global_ame` (
  `cod_ctrol_ventpag_global_ame` int(10) NOT NULL AUTO_INCREMENT,
  `est_control_ventas_ame` int(1) NOT NULL,
  `est_control_pagos_ame` int(1) NOT NULL,
  PRIMARY KEY (`cod_ctrol_ventpag_global_ame`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "ctrol_ventpag_global_hnac"
#

CREATE TABLE `ctrol_ventpag_global_hnac` (
  `cod_ctrol_ventpag_global_hnac` int(10) NOT NULL AUTO_INCREMENT,
  `est_control_ventas_hnac` int(1) NOT NULL,
  `est_control_pagos_hnac` int(1) NOT NULL,
  PRIMARY KEY (`cod_ctrol_ventpag_global_hnac`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "ctrol_ventpag_global_lot"
#

CREATE TABLE `ctrol_ventpag_global_lot` (
  `cod_ctrol_ventpag_global_lot` int(10) NOT NULL AUTO_INCREMENT,
  `est_control_ventas_lot` int(1) NOT NULL,
  `est_control_pagos_lot` int(1) NOT NULL,
  PRIMARY KEY (`cod_ctrol_ventpag_global_lot`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "cuentas"
#

CREATE TABLE `cuentas` (
  `id_cuenta` int(11) NOT NULL AUTO_INCREMENT,
  `rep_cuenta` varchar(50) NOT NULL,
  `id_metodopago` int(11) NOT NULL,
  `id_banco` int(11) NOT NULL,
  `nro_cuenta` varchar(25) NOT NULL,
  `ced_cuenta` varchar(15) NOT NULL,
  `sal_cuenta` decimal(10,2) NOT NULL,
  `man_cambio` int(1) NOT NULL,
  `mon_cambio` decimal(10,2) NOT NULL,
  `est_cuenta` int(1) NOT NULL,
  PRIMARY KEY (`id_cuenta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "div_oficiales_macu"
#

CREATE TABLE `div_oficiales_macu` (
  `cod_dividendo_macu` int(11) NOT NULL AUTO_INCREMENT,
  `fec_dividendo_macu` date NOT NULL,
  `div_pago_macu` decimal(10,2) NOT NULL,
  `cod_tventa_macu` int(1) NOT NULL,
  `hor_dividendo_macu` time NOT NULL,
  PRIMARY KEY (`cod_dividendo_macu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "div_taquilla_macu"
#

CREATE TABLE `div_taquilla_macu` (
  `cod_dividendo_macu` int(11) NOT NULL AUTO_INCREMENT,
  `cod_taquilla` int(11) NOT NULL,
  `fec_dividendo_macu` date NOT NULL,
  `div_pago_macu` decimal(10,2) NOT NULL,
  `cod_tventa_macu` int(1) NOT NULL,
  `hor_dividendo_macu` time NOT NULL,
  PRIMARY KEY (`cod_dividendo_macu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "egresos"
#

CREATE TABLE `egresos` (
  `id_egreso` int(11) NOT NULL AUTO_INCREMENT,
  `des_egreso` varchar(80) NOT NULL,
  `est_egreso` int(1) NOT NULL,
  PRIMARY KEY (`id_egreso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "estadisticas"
#

CREATE TABLE `estadisticas` (
  `id_estadistica` int(20) NOT NULL AUTO_INCREMENT,
  `tipo_estadistica` int(2) NOT NULL COMMENT '0 ame taquillas 1 ame jugadas 2 naci taquillas 3 naci jugadas 4 parl taquillas 5 parl jugadas',
  `can_estadisitcas` int(20) NOT NULL,
  `tiempo_estadistica` date NOT NULL,
  PRIMARY KEY (`id_estadistica`)
) ENGINE=InnoDB AUTO_INCREMENT=10883 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "exploradorversion"
#

CREATE TABLE `exploradorversion` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `exploradorversion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `exploradorversionTODO` (`exploradorversion`)
) ENGINE=InnoDB AUTO_INCREMENT=47734 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "factura"
#

CREATE TABLE `factura` (
  `id_factura` bigint(10) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `des_factura` decimal(10,2) NOT NULL,
  `fec_factura` date NOT NULL,
  `hor_factura` time NOT NULL,
  `tot_factura` double(10,2) NOT NULL,
  `id_formapago` int(11) NOT NULL,
  `id_metodopago` int(11) NOT NULL,
  `det_pago` text NOT NULL,
  `sem_factura` varchar(100) NOT NULL,
  `mon_abonado` decimal(10,2) NOT NULL,
  `est_factura` int(1) NOT NULL,
  `fec_cancelado` date NOT NULL,
  `ref_factura` int(18) NOT NULL,
  PRIMARY KEY (`id_factura`),
  KEY `idx_opt_factura_usuario` (`id_usuario`,`id_factura`)
) ENGINE=InnoDB AUTO_INCREMENT=409 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "factura_detalle"
#

CREATE TABLE `factura_detalle` (
  `id_detalle` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `can_producto` int(11) NOT NULL,
  `pre_producto` decimal(10,2) NOT NULL,
  `det_producto` text NOT NULL,
  `mon_iva` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_detalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "forma_pago"
#

CREATE TABLE `forma_pago` (
  `id_formapago` int(11) NOT NULL AUTO_INCREMENT,
  `nom_formapago` varchar(30) NOT NULL,
  PRIMARY KEY (`id_formapago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "frutas"
#

CREATE TABLE `frutas` (
  `id_fruta` int(11) NOT NULL AUTO_INCREMENT,
  `num_fruta` varchar(2) NOT NULL,
  `nom_fruta` varchar(30) NOT NULL,
  `nom_corto` varchar(5) NOT NULL,
  `img_fruta` varchar(300) NOT NULL,
  PRIMARY KEY (`id_fruta`),
  UNIQUE KEY `cod_signo` (`id_fruta`),
  KEY `cod_signo_2` (`id_fruta`),
  KEY `nom_corto` (`nom_corto`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "gastos"
#

CREATE TABLE `gastos` (
  `id_gasto` int(11) NOT NULL AUTO_INCREMENT,
  `des_gasto` text NOT NULL,
  `mon_gasto` decimal(10,2) NOT NULL,
  `fec_gasto` date NOT NULL,
  `id_egreso` int(1) NOT NULL,
  `tip_gasto` int(1) NOT NULL,
  `est_gasto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_gasto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "grupo_loterias"
#

CREATE TABLE `grupo_loterias` (
  `id_grupo_lot` int(11) NOT NULL AUTO_INCREMENT,
  `nom_grupo_lot` varchar(30) NOT NULL,
  `est_grupo_lot` int(1) NOT NULL,
  PRIMARY KEY (`id_grupo_lot`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "hipodromo"
#

CREATE TABLE `hipodromo` (
  `cod_hipodromo` int(10) NOT NULL AUTO_INCREMENT,
  `nom_hipodromo` varchar(40) NOT NULL,
  `pre_hipodromo` varchar(10) NOT NULL,
  `nom_hipodromo_hpi` varchar(40) NOT NULL,
  `mtp_WatchandWager` int(1) NOT NULL DEFAULT 0,
  `nom_hipodromo_sup` varchar(40) NOT NULL DEFAULT '',
  `nom_hipodromo_rac` varchar(40) NOT NULL DEFAULT '',
  `dir_pagcarreras` varchar(90) NOT NULL,
  `ext_pagcarreras` varchar(15) NOT NULL,
  `dir_pagresultado` varchar(90) NOT NULL,
  `ext_pagresultado` varchar(15) NOT NULL,
  `dir_retirado` varchar(150) NOT NULL DEFAULT '',
  `ext_retirado` varchar(50) NOT NULL DEFAULT '',
  `est_hipodromo` int(1) NOT NULL,
  `dif_horaria` time NOT NULL,
  `suma_resta` int(1) NOT NULL,
  `dir_pagresultado_tvg` varchar(120) DEFAULT NULL,
  `ext_pagresultado_tvg` varchar(15) NOT NULL DEFAULT '&RaceNum=',
  `bus_resultado_tip` int(1) DEFAULT NULL,
  `cod_confirmacion` int(1) DEFAULT NULL,
  `pro_desde` int(1) DEFAULT NULL,
  `cod_pagina_rb` varchar(400) DEFAULT NULL,
  `bus_retirado` int(1) DEFAULT NULL,
  `pre_build` varchar(40) DEFAULT NULL,
  `nom_betbird` varchar(40) NOT NULL DEFAULT '',
  `mtp_betbird` int(1) NOT NULL DEFAULT 0,
  `mtp_paribetnom` varchar(40) NOT NULL DEFAULT 'NADA',
  `mtp_paribet` int(1) NOT NULL DEFAULT 0,
  `nom_hipodromo_twi` varchar(30) NOT NULL,
  `pre_twin` varchar(4) NOT NULL,
  `mtp_twinspire` int(11) NOT NULL DEFAULT 0,
  `tip_hipodromo` int(1) NOT NULL,
  `mtp_ameridatos` int(1) NOT NULL DEFAULT 0,
  `mtp_betamericanom` varchar(40) DEFAULT 'NADA',
  `mtp_betamerica` int(11) DEFAULT 0,
  `valorbuildabet` int(11) NOT NULL DEFAULT 1,
  `bus_auto` int(1) NOT NULL,
  `mtp_tvg` int(1) DEFAULT 0,
  `nom_racebets` varchar(50) DEFAULT '0',
  `mtp_racebets` int(1) DEFAULT 0,
  `offtrack_cod` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '0',
  `offtrack_num_link` int(7) DEFAULT 0,
  `offtrack_sino` int(2) DEFAULT 0,
  PRIMARY KEY (`cod_hipodromo`),
  UNIQUE KEY `cod_hipodromo` (`cod_hipodromo`),
  KEY `bus_retirado` (`bus_retirado`),
  KEY `est_hipodromo` (`est_hipodromo`),
  KEY `nom_hipodromo` (`nom_hipodromo`),
  KEY `pre_hipodromo` (`pre_hipodromo`),
  KEY `nom_hipodromo_hpi` (`nom_hipodromo_hpi`),
  KEY `nom_hipodromo_sup` (`nom_hipodromo_sup`),
  KEY `nom_hipodromo_rac` (`nom_hipodromo_rac`),
  KEY `mtp_betbird` (`mtp_betbird`),
  KEY `pre_twin` (`pre_twin`),
  KEY `tip_hipodromo` (`tip_hipodromo`),
  KEY `pre_build` (`pre_build`)
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "hipodromo_hnac"
#

CREATE TABLE `hipodromo_hnac` (
  `cod_hipodromo_hnac` int(11) NOT NULL AUTO_INCREMENT,
  `nom_hipodromo_hnac` varchar(30) NOT NULL,
  `dia_hipodromo_hnac` varchar(8) NOT NULL,
  `est_hipodromo_hnac` int(1) NOT NULL,
  `bus_resultado_hnac` int(1) NOT NULL,
  `bus_inscrito_hnac` int(1) NOT NULL,
  `bus_retirado_hnac` int(1) NOT NULL,
  `cod_pagina_accionhipica2` int(11) DEFAULT NULL,
  PRIMARY KEY (`cod_hipodromo_hnac`),
  KEY `est_hipodromo_hnac` (`est_hipodromo_hnac`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "inscritos"
#

CREATE TABLE `inscritos` (
  `cod_inscrito_hnac` int(11) NOT NULL AUTO_INCREMENT,
  `cod_carrera_hnac` int(11) NOT NULL,
  `num_caballo_hnac` int(2) NOT NULL,
  `nom_caballo_hnac` varchar(20) NOT NULL,
  `nom_jinete_hnac` varchar(20) NOT NULL,
  `est_inscrito_hnac` int(1) NOT NULL,
  `est_favorito_hnac` int(1) DEFAULT 0,
  `fecha_inscritos` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`cod_inscrito_hnac`),
  KEY `cod_carrera_hnac` (`cod_carrera_hnac`),
  KEY `cod_inscrito_hnac` (`cod_inscrito_hnac`)
) ENGINE=InnoDB AUTO_INCREMENT=97895 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "iva"
#

CREATE TABLE `iva` (
  `id_iva` int(11) NOT NULL AUTO_INCREMENT,
  `tip_iva` int(1) NOT NULL,
  `mon_iva` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_iva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "load_average"
#

CREATE TABLE `load_average` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `load_1_min` decimal(10,2) NOT NULL,
  `load_5_min` decimal(10,2) NOT NULL,
  `load_15_min` decimal(10,2) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34280 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "loterias"
#

CREATE TABLE `loterias` (
  `id_loteria` int(11) NOT NULL AUTO_INCREMENT,
  `nom_loteria` varchar(30) NOT NULL,
  `let_loteria` varchar(1) NOT NULL,
  `tip_loteria` tinyint(1) NOT NULL,
  `id_terminal` int(11) NOT NULL,
  `id_triple` int(11) NOT NULL,
  `est_loteria` tinyint(1) NOT NULL,
  `ord_loteria` int(11) NOT NULL,
  `id_sorteo` int(11) NOT NULL,
  PRIMARY KEY (`id_loteria`),
  UNIQUE KEY `cod_loteria` (`id_loteria`),
  KEY `cod_terminal` (`id_terminal`),
  KEY `cod_triple` (`id_triple`),
  KEY `est_loteria` (`est_loteria`),
  KEY `ord_loteria` (`ord_loteria`),
  KEY `est_loteria_2` (`est_loteria`),
  KEY `cod_terminal_2` (`id_terminal`),
  KEY `tip_loteria` (`tip_loteria`),
  KEY `id_terminal` (`id_terminal`),
  KEY `id_triple` (`id_triple`),
  KEY `est_loteria_3` (`est_loteria`),
  KEY `ord_loteria_2` (`ord_loteria`)
) ENGINE=InnoDB AUTO_INCREMENT=306 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "mensaje"
#

CREATE TABLE `mensaje` (
  `cod_mensaje` int(5) NOT NULL AUTO_INCREMENT,
  `pri_linea` varchar(50) NOT NULL,
  `seg_linea` varchar(50) NOT NULL,
  `pie_linea` varchar(70) NOT NULL,
  `est_mensaje` int(1) NOT NULL,
  `contacto1` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `contacto2` varchar(20) NOT NULL DEFAULT '',
  `whatsapp` varchar(20) NOT NULL DEFAULT '',
  `pin` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`cod_mensaje`),
  UNIQUE KEY `cod_mensaje` (`cod_mensaje`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "mensajes"
#

CREATE TABLE `mensajes` (
  `Id_mensajes` int(11) NOT NULL AUTO_INCREMENT,
  `mensaje` varchar(200) NOT NULL DEFAULT '',
  `est_mensaje` int(11) DEFAULT 0,
  PRIMARY KEY (`Id_mensajes`),
  KEY `est_mensaje` (`est_mensaje`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

#
# Structure for table "mensajesyalertas"
#

CREATE TABLE `mensajesyalertas` (
  `Id_mensajesyalertas` int(11) NOT NULL AUTO_INCREMENT,
  `eviadoel` timestamp NOT NULL DEFAULT current_timestamp(),
  `mostrarhasta` date NOT NULL DEFAULT '0000-00-00',
  `mensaje` text NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT 0,
  `para` int(11) NOT NULL DEFAULT 0,
  `creadopor` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id_mensajesyalertas`),
  KEY `mostrarhasta` (`mostrarhasta`),
  KEY `idx_opt_msg_tipo_para_fec` (`tipo`,`para`,`mostrarhasta`)
) ENGINE=InnoDB AUTO_INCREMENT=1309 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "metodo_pago"
#

CREATE TABLE `metodo_pago` (
  `id_metodopago` int(11) NOT NULL AUTO_INCREMENT,
  `nom_metodopago` varchar(50) NOT NULL,
  `ico_metodopago` text NOT NULL,
  `man_cuenta` int(1) NOT NULL,
  `man_banco` int(1) NOT NULL,
  `est_metodopago` int(1) NOT NULL,
  PRIMARY KEY (`id_metodopago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "multidistriMD"
#

CREATE TABLE `multidistriMD` (
  `cod_multidistriMD` bigint(11) NOT NULL AUTO_INCREMENT,
  `nom_multidistriMD` varchar(30) DEFAULT NULL,
  `tel_multidistriMD` varchar(15) DEFAULT NULL,
  `est_multidistriMD` int(1) DEFAULT NULL,
  `multi_vende_ameMD` int(1) DEFAULT NULL,
  `multi_por_ameMD` decimal(10,2) DEFAULT NULL,
  `multi_vende_hnacMD` int(1) DEFAULT NULL,
  `multipor_banca_hnacMD` decimal(10,2) DEFAULT NULL,
  `multi_tipo_hnacMD` int(2) DEFAULT 0,
  `multi_vende_parleyMD` int(1) DEFAULT NULL,
  `multi_por_parleyMD` decimal(10,2) DEFAULT NULL,
  `multi_vende_aniMD` int(2) DEFAULT 0,
  `multi_por_aniMD` decimal(10,2) DEFAULT 0.00,
  `cod_usuario_md` int(11) NOT NULL,
  PRIMARY KEY (`cod_multidistriMD`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "nada"
#

CREATE TABLE `nada` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nada` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=350 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

#
# Structure for table "opciones_parley"
#

CREATE TABLE `opciones_parley` (
  `id_opcionp` int(11) NOT NULL,
  `nom_opcion` varchar(255) NOT NULL DEFAULT '',
  `Swicht` int(11) NOT NULL,
  `parseo_sella` text DEFAULT NULL,
  `parseo_activo` text DEFAULT NULL,
  PRIMARY KEY (`id_opcionp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "p10juegos"
#

CREATE TABLE `p10juegos` (
  `Id_p2juegosp2` int(11) NOT NULL AUTO_INCREMENT,
  `idequipo1p2` int(11) DEFAULT NULL,
  `idequipo2p2` int(11) DEFAULT NULL,
  `deportep2` varchar(50) DEFAULT NULL,
  `competicionp2` varchar(50) DEFAULT NULL,
  `paisp2` varchar(50) DEFAULT NULL,
  `pichee1p2` varchar(50) DEFAULT '0',
  `pichee2p2` varchar(50) DEFAULT '0',
  `iniciodtp2` datetime DEFAULT '0000-00-00 00:00:00',
  `cod_wuaosite` int(11) DEFAULT 0,
  `cod_wuaosite_empate` int(11) DEFAULT 0,
  `codWiningBet` int(11) DEFAULT 0,
  `codWiningBet_empate` int(11) DEFAULT 0,
  `parseconp2` int(11) DEFAULT 0,
  `quinregistrap2` varchar(200) DEFAULT NULL,
  `p2time` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `p2vecesactualizado` int(20) DEFAULT 0,
  `jexterno` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id_p2juegosp2`)
) ENGINE=InnoDB AUTO_INCREMENT=139003 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

#
# Structure for table "p10logros"
#

CREATE TABLE `p10logros` (
  `Id_p3logrosp3` int(11) NOT NULL AUTO_INCREMENT,
  `idjuegop3` int(11) DEFAULT NULL,
  `Id_p1equiposp3` int(11) DEFAULT NULL,
  `tipojugadap3` varchar(16) DEFAULT NULL,
  `logrop3` decimal(10,0) DEFAULT NULL,
  `equipop3` int(11) DEFAULT NULL,
  `logroABoRLp3` varchar(5) DEFAULT '',
  `logrodtp3` datetime DEFAULT '0000-00-00 00:00:00',
  `logroactualdt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `actxp3` int(1) DEFAULT 0,
  PRIMARY KEY (`Id_p3logrosp3`),
  KEY `index_logrodtp3` (`logrodtp3`)
) ENGINE=InnoDB AUTO_INCREMENT=770851 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

#
# Structure for table "p1equipos"
#

CREATE TABLE `p1equipos` (
  `Id_p1equiposp1` int(11) NOT NULL AUTO_INCREMENT,
  `nomequipop1` varchar(255) NOT NULL DEFAULT '',
  `nomdimp1` varchar(255) DEFAULT NULL,
  `deportep1` int(11) NOT NULL DEFAULT 0,
  `ligap1` varchar(255) DEFAULT '',
  `ordenp1` int(11) DEFAULT NULL,
  `nomwuaosite` varchar(255) DEFAULT '',
  `WiningBet` varchar(255) DEFAULT '',
  `nomwinningbet` varchar(255) DEFAULT '',
  `nommara` varchar(255) DEFAULT '',
  `nommarapais` varchar(20) DEFAULT NULL,
  `nomsella` varchar(255) DEFAULT '',
  `liga` varchar(50) DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `array_mara` varchar(600) DEFAULT ',',
  `array_sella` varchar(600) DEFAULT ',',
  `array_wining` varchar(600) DEFAULT ',',
  `UltimaUsado` date DEFAULT '2000-01-01',
  `nom_parley` varchar(600) DEFAULT NULL,
  PRIMARY KEY (`Id_p1equiposp1`),
  KEY `nomwinningbet` (`nomwinningbet`),
  KEY `nomsella` (`nomsella`),
  KEY `idx_opt_p1_dep_mara` (`deportep1`,`nommara`),
  KEY `idx_opt_p1_dep_sella` (`deportep1`,`nomsella`),
  KEY `idx_opt_p1_dep_nom` (`deportep1`,`nomequipop1`),
  KEY `idx_opt_p1_cobertura_q10` (`deportep1`,`nomequipop1`,`nom_parley`(255))
) ENGINE=InnoDB AUTO_INCREMENT=13686 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

#
# Structure for table "p2juegos"
#

CREATE TABLE `p2juegos` (
  `Id_p2juegosp2` int(11) NOT NULL AUTO_INCREMENT,
  `idequipo1p2` int(11) DEFAULT NULL,
  `idequipo2p2` int(11) DEFAULT NULL,
  `deportep2` varchar(50) DEFAULT NULL,
  `competicionp2` varchar(50) DEFAULT NULL,
  `paisp2` varchar(50) DEFAULT NULL,
  `pichee1p2` varchar(50) DEFAULT '0',
  `pichee2p2` varchar(50) DEFAULT '0',
  `iniciodtp2` datetime DEFAULT '0000-00-00 00:00:00',
  `cod_wuaosite` int(11) DEFAULT 0,
  `cod_wuaosite_empate` int(11) DEFAULT 0,
  `codWiningBet` int(11) DEFAULT 0,
  `codWiningBet_empate` int(11) DEFAULT 0,
  `parseconp2` int(11) DEFAULT 0,
  `quinregistrap2` varchar(200) DEFAULT NULL,
  `p2time` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `p2vecesactualizado` int(20) DEFAULT 0,
  `jexterno` int(1) NOT NULL DEFAULT 0,
  `hora_creacion` timestamp NULL DEFAULT current_timestamp(),
  `logros_funcion` int(1) NOT NULL,
  `maradeportes_nosi` int(1) DEFAULT 0,
  `sellaresultados_nosi` int(1) DEFAULT 0,
  `jerarquia` int(1) DEFAULT NULL,
  PRIMARY KEY (`Id_p2juegosp2`),
  KEY `id_iniciop2` (`Id_p2juegosp2`,`iniciodtp2`),
  KEY `iniciop2` (`iniciodtp2`)
) ENGINE=InnoDB AUTO_INCREMENT=387279 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

#
# Structure for table "p3logros"
#

CREATE TABLE `p3logros` (
  `Id_p3logrosp3` int(11) NOT NULL AUTO_INCREMENT,
  `idjuegop3` int(11) DEFAULT NULL,
  `Id_p1equiposp3` int(11) DEFAULT NULL,
  `tipojugadap3` varchar(16) DEFAULT NULL,
  `logrop3` decimal(10,0) DEFAULT NULL,
  `equipop3` int(11) DEFAULT NULL,
  `logroABoRLp3` varchar(5) DEFAULT '',
  `logrodtp3` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logroactualdt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `actxp3` int(1) DEFAULT 0,
  `mara_logros` int(11) NOT NULL,
  PRIMARY KEY (`Id_p3logrosp3`,`logrodtp3`),
  KEY `indexp3time` (`logrodtp3`),
  KEY `idx_opt_p3_juego_eq_tipo` (`idjuegop3`,`equipop3`,`tipojugadap3`)
) ENGINE=InnoDB AUTO_INCREMENT=4202169 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC
 PARTITION BY RANGE (to_days(`logrodtp3`))
(PARTITION `p_historico` VALUES LESS THAN (739982) ENGINE = InnoDB,
 PARTITION `p2026_01` VALUES LESS THAN (740013) ENGINE = InnoDB,
 PARTITION `p2026_02` VALUES LESS THAN (740041) ENGINE = InnoDB,
 PARTITION `p2026_03` VALUES LESS THAN (740072) ENGINE = InnoDB,
 PARTITION `p2026_04` VALUES LESS THAN (740102) ENGINE = InnoDB,
 PARTITION `p2026_05` VALUES LESS THAN (740133) ENGINE = InnoDB,
 PARTITION `p2026_06` VALUES LESS THAN (740163) ENGINE = InnoDB,
 PARTITION `p2026_07` VALUES LESS THAN (740194) ENGINE = InnoDB,
 PARTITION `p2026_08` VALUES LESS THAN (740225) ENGINE = InnoDB,
 PARTITION `p2026_09` VALUES LESS THAN (740255) ENGINE = InnoDB,
 PARTITION `p2026_10` VALUES LESS THAN (740286) ENGINE = InnoDB,
 PARTITION `p2026_11` VALUES LESS THAN (740316) ENGINE = InnoDB,
 PARTITION `p2026_12` VALUES LESS THAN (740347) ENGINE = InnoDB,
 PARTITION `p_futuro` VALUES LESS THAN MAXVALUE ENGINE = InnoDB);

#
# Structure for table "p4jugadas"
#

CREATE TABLE `p4jugadas` (
  `Id_p4jugadasp4` bigint(11) NOT NULL AUTO_INCREMENT,
  `nticketp4` bigint(5) DEFAULT 0,
  `pcan_ticket` int(11) DEFAULT 0,
  `ser_ventap4` varchar(15) DEFAULT '',
  `cod_taquillap4` int(11) DEFAULT 0,
  `jugadadtp4` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip_ventap4` varchar(16) NOT NULL DEFAULT '',
  `mon_ventap4` decimal(12,2) DEFAULT NULL,
  `id_usuariop4` int(11) DEFAULT 0,
  `codigop4` varchar(11) DEFAULT '',
  `tipojp4` varchar(16) DEFAULT NULL,
  `referenciap4` int(11) DEFAULT 0,
  `logrop4` varchar(11) DEFAULT '',
  `equipop4` varchar(50) DEFAULT '',
  `juegop4` int(11) DEFAULT 0,
  `numerojp4` int(11) DEFAULT 0,
  `padrep4` int(11) DEFAULT 0,
  `deportep4` int(11) DEFAULT 0,
  `lineatp4` int(11) DEFAULT 0,
  `estadojugadap4` int(11) DEFAULT 0,
  `ab_o_rlp4` varchar(7) DEFAULT '0',
  `estadoticketp4` int(11) DEFAULT 0,
  `premioapagarp4` double(12,2) DEFAULT 0.00,
  `monedap4` int(11) DEFAULT 0,
  `jugadadtp4pago` datetime DEFAULT '0000-00-00 00:00:00',
  `pcod_cliente` varchar(11) DEFAULT '',
  `pverificado` int(11) DEFAULT 0,
  `quien_apruebap4` varchar(15) DEFAULT NULL,
  `tipot` int(2) DEFAULT 0,
  `Validar` int(11) NOT NULL,
  PRIMARY KEY (`Id_p4jugadasp4`,`jugadadtp4`),
  KEY `jugadadtp4` (`jugadadtp4`),
  KEY `nticketp4` (`nticketp4`),
  KEY `juegop4` (`juegop4`),
  KEY `cod_taquillap4` (`cod_taquillap4`),
  KEY `idusuarioydate` (`id_usuariop4`,`jugadadtp4`),
  KEY `idx_opt_taquilla_ticket` (`cod_taquillap4`,`nticketp4`),
  KEY `idx_opt_p4_reporte` (`cod_taquillap4`,`jugadadtp4`,`lineatp4`),
  KEY `idx_opt_p4_padre_fecha` (`padrep4`,`jugadadtp4`)
) ENGINE=InnoDB AUTO_INCREMENT=1262090 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC
 PARTITION BY RANGE (to_days(`jugadadtp4`))
(PARTITION `p_historico` VALUES LESS THAN (739982) ENGINE = InnoDB,
 PARTITION `p2026_01` VALUES LESS THAN (740013) ENGINE = InnoDB,
 PARTITION `p2026_02` VALUES LESS THAN (740041) ENGINE = InnoDB,
 PARTITION `p2026_03` VALUES LESS THAN (740072) ENGINE = InnoDB,
 PARTITION `p2026_04` VALUES LESS THAN (740102) ENGINE = InnoDB,
 PARTITION `p2026_05` VALUES LESS THAN (740133) ENGINE = InnoDB,
 PARTITION `p2026_06` VALUES LESS THAN (740163) ENGINE = InnoDB,
 PARTITION `p2026_07` VALUES LESS THAN (740194) ENGINE = InnoDB,
 PARTITION `p2026_08` VALUES LESS THAN (740225) ENGINE = InnoDB,
 PARTITION `p2026_09` VALUES LESS THAN (740255) ENGINE = InnoDB,
 PARTITION `p2026_10` VALUES LESS THAN (740286) ENGINE = InnoDB,
 PARTITION `p2026_11` VALUES LESS THAN (740316) ENGINE = InnoDB,
 PARTITION `p2026_12` VALUES LESS THAN (740347) ENGINE = InnoDB,
 PARTITION `p_futuro` VALUES LESS THAN MAXVALUE ENGINE = InnoDB);

#
# Structure for table "p5resultadosj"
#

CREATE TABLE `p5resultadosj` (
  `Id_p5resultadosjp5` int(11) NOT NULL AUTO_INCREMENT,
  `deportep5` varchar(50) DEFAULT '0',
  `juegop5` int(11) DEFAULT 0,
  `equipo1p5` varchar(50) DEFAULT '',
  `equipo2p5` varchar(50) DEFAULT '',
  `anotaprimerop5` varchar(50) DEFAULT '0',
  `tiemposjugadosp5` int(11) DEFAULT 0,
  `r1p5` int(11) DEFAULT NULL,
  `r2p5` int(11) DEFAULT NULL,
  `r3p5` int(11) DEFAULT NULL,
  `r4p5` int(11) DEFAULT NULL,
  `r5p5` int(11) DEFAULT NULL,
  `r6p5` int(11) DEFAULT NULL,
  `r7p5` int(11) DEFAULT NULL,
  `r8p5` int(11) DEFAULT NULL,
  `r9p5` int(11) DEFAULT NULL,
  `r10p5` int(11) DEFAULT NULL,
  `r11p5` int(11) DEFAULT NULL,
  `r12p5` int(11) DEFAULT NULL,
  `r13p5` int(11) DEFAULT NULL,
  `r14p5` int(11) DEFAULT NULL,
  `r15p5` int(11) DEFAULT NULL,
  `r16p5` int(11) DEFAULT NULL,
  `r17p5` int(11) DEFAULT NULL,
  `r18p5` int(11) DEFAULT NULL,
  `r19p5` int(11) DEFAULT NULL,
  `r20p5` int(11) DEFAULT NULL,
  `r21p5` int(11) DEFAULT NULL,
  `r22p5` int(11) DEFAULT NULL,
  `r23p5` int(11) DEFAULT NULL,
  `r24p5` int(11) DEFAULT NULL,
  `r25p5` int(11) DEFAULT NULL,
  `r26p5` int(11) DEFAULT NULL,
  `r27p5` int(11) DEFAULT NULL,
  `r28p5` int(11) DEFAULT NULL,
  `r29p5` int(11) DEFAULT NULL,
  `r30p5` int(11) DEFAULT NULL,
  `iniciodtp5` datetime DEFAULT '0000-00-00 00:00:00',
  `estadop5` int(11) DEFAULT 0,
  `quienmete` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_p5resultadosjp5`),
  KEY `iniciodtp5` (`iniciodtp5`),
  KEY `juegop5` (`juegop5`)
) ENGINE=InnoDB AUTO_INCREMENT=145628 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

#
# Structure for table "p6logrosind"
#

CREATE TABLE `p6logrosind` (
  `idp6logrosind` int(11) NOT NULL AUTO_INCREMENT,
  `idlogrop6` int(11) DEFAULT NULL,
  `idjuegop6` int(11) DEFAULT NULL,
  `equipop6` int(11) DEFAULT NULL,
  `tipojugadap6` varchar(50) DEFAULT NULL,
  `logrop6` decimal(10,0) DEFAULT NULL,
  `logroABoRLp6` varchar(50) DEFAULT NULL,
  `logrodtp6` datetime DEFAULT NULL,
  `acceso_logro` int(11) NOT NULL,
  `logroa_taquillap6` int(11) DEFAULT NULL,
  `taquillas_guardadas` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`idp6logrosind`),
  KEY `logrodtp6` (`logrodtp6`)
) ENGINE=InnoDB AUTO_INCREMENT=3022 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "p7histolg"
#

CREATE TABLE `p7histolg` (
  `Id_p7logrosp7` int(11) NOT NULL AUTO_INCREMENT,
  `idjuegop7` int(11) DEFAULT NULL,
  `Id_p1equiposp7` int(11) DEFAULT NULL,
  `tipojugadap7` varchar(16) DEFAULT NULL,
  `logrop7` varchar(10) DEFAULT NULL,
  `equipop7` int(11) DEFAULT NULL,
  `logroABoRLp7` varchar(5) DEFAULT NULL,
  `logroactualdtp7` datetime NOT NULL DEFAULT current_timestamp(),
  `actxp7` int(1) DEFAULT NULL,
  PRIMARY KEY (`Id_p7logrosp7`,`logroactualdtp7`)
) ENGINE=InnoDB AUTO_INCREMENT=16074109 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci
 PARTITION BY RANGE (to_days(`logroactualdtp7`))
(PARTITION `p_historico` VALUES LESS THAN (739982) ENGINE = InnoDB,
 PARTITION `p2026_01` VALUES LESS THAN (740013) ENGINE = InnoDB,
 PARTITION `p2026_02` VALUES LESS THAN (740041) ENGINE = InnoDB,
 PARTITION `p2026_03` VALUES LESS THAN (740072) ENGINE = InnoDB,
 PARTITION `p2026_04` VALUES LESS THAN (740102) ENGINE = InnoDB,
 PARTITION `p2026_05` VALUES LESS THAN (740133) ENGINE = InnoDB,
 PARTITION `p2026_06` VALUES LESS THAN (740163) ENGINE = InnoDB,
 PARTITION `p2026_07` VALUES LESS THAN (740194) ENGINE = InnoDB,
 PARTITION `p2026_08` VALUES LESS THAN (740225) ENGINE = InnoDB,
 PARTITION `p2026_09` VALUES LESS THAN (740255) ENGINE = InnoDB,
 PARTITION `p2026_10` VALUES LESS THAN (740286) ENGINE = InnoDB,
 PARTITION `p2026_11` VALUES LESS THAN (740316) ENGINE = InnoDB,
 PARTITION `p2026_12` VALUES LESS THAN (740347) ENGINE = InnoDB,
 PARTITION `p_futuro` VALUES LESS THAN MAXVALUE ENGINE = InnoDB);

#
# Structure for table "palos_cartas"
#

CREATE TABLE `palos_cartas` (
  `id_palo` int(11) NOT NULL AUTO_INCREMENT,
  `num_palo` int(1) NOT NULL,
  `nom_palo` varchar(20) NOT NULL,
  `nom_corto` varchar(3) NOT NULL,
  PRIMARY KEY (`id_palo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "parseo"
#

CREATE TABLE `parseo` (
  `Idparseo` int(11) NOT NULL AUTO_INCREMENT,
  `parseotiempo` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `parseotipo` varchar(255) DEFAULT 'NO DEFINIDO',
  `parseojson` mediumblob DEFAULT NULL,
  PRIMARY KEY (`Idparseo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

#
# Structure for table "precio_fijo_hnac"
#

CREATE TABLE `precio_fijo_hnac` (
  `id_pfijo_hnac` int(11) NOT NULL AUTO_INCREMENT,
  `fec_carrera_hnac` date NOT NULL,
  `cod_carrera_hnac` int(11) NOT NULL,
  `cod_inscrito_hnac` int(11) NOT NULL,
  `cod_taquilla` int(11) NOT NULL,
  `max_eje_hnac` decimal(10,2) NOT NULL,
  `max_jug_hnac` decimal(10,2) NOT NULL,
  `min_jug_hnac` decimal(10,2) NOT NULL,
  `pre_fijo_hnac` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id_pfijo_hnac`),
  UNIQUE KEY `id_pfijo_hnac` (`id_pfijo_hnac`),
  KEY `fec_carrera_hnac` (`fec_carrera_hnac`),
  KEY `cod_carrera_hnac` (`cod_carrera_hnac`),
  KEY `cod_inscrito_hnac` (`cod_inscrito_hnac`),
  KEY `cod_taquilla` (`cod_taquilla`)
) ENGINE=InnoDB AUTO_INCREMENT=63322 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "producto"
#

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `iva_producto` int(1) NOT NULL,
  `tip_producto` int(1) NOT NULL,
  `nom_producto` text NOT NULL,
  `pre_producto` decimal(10,2) NOT NULL,
  `est_producto` int(1) NOT NULL,
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "quiencierrayabre"
#

CREATE TABLE `quiencierrayabre` (
  `Idquiencierrayabre` int(11) NOT NULL AUTO_INCREMENT,
  `codcarrera` int(11) DEFAULT 0,
  `cerro` int(11) DEFAULT 0,
  `abrio` int(11) DEFAULT 0,
  `fechaquien` date DEFAULT '0000-00-00',
  `tiempo` timestamp NULL DEFAULT current_timestamp(),
  `que` int(11) DEFAULT 0,
  PRIMARY KEY (`Idquiencierrayabre`),
  KEY `CODDATE` (`codcarrera`,`fechaquien`)
) ENGINE=InnoDB AUTO_INCREMENT=2062191 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "referidos"
#

CREATE TABLE `referidos` (
  `id_treferidos` int(11) NOT NULL AUTO_INCREMENT,
  `id_sponsor` int(11) NOT NULL,
  `id_refer` int(11) NOT NULL,
  `fec_refer` date NOT NULL,
  `por_sponsor` decimal(10,2) NOT NULL,
  `est_refer` int(1) NOT NULL,
  PRIMARY KEY (`id_treferidos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "registro_ingreso"
#

CREATE TABLE `registro_ingreso` (
  `id_registro` int(11) NOT NULL AUTO_INCREMENT,
  `fec_registro` date NOT NULL,
  `hor_registro` time NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `num_veces` int(11) NOT NULL,
  PRIMARY KEY (`id_registro`),
  KEY `idx_opt_regingreso_fec_usu` (`fec_registro`,`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=18385 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "registro_tasa"
#

CREATE TABLE `registro_tasa` (
  `id_tasar` int(11) NOT NULL AUTO_INCREMENT,
  `usdabss` decimal(10,4) DEFAULT NULL,
  `copabss` decimal(10,4) DEFAULT NULL,
  `solabss` decimal(10,4) DEFAULT NULL,
  `fecha_tasa` date DEFAULT NULL,
  PRIMARY KEY (`id_tasar`)
) ENGINE=InnoDB AUTO_INCREMENT=863 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "reimpresion"
#

CREATE TABLE `reimpresion` (
  `id_reimpresion` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `fec_reimpresion` date NOT NULL,
  `can_actual` int(11) NOT NULL,
  `tip_programa` int(1) NOT NULL,
  PRIMARY KEY (`id_reimpresion`),
  KEY `id_usuario` (`id_usuario`),
  KEY `fec_reimpresion` (`fec_reimpresion`),
  KEY `tip_programa` (`tip_programa`)
) ENGINE=InnoDB AUTO_INCREMENT=153949 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "resultados_hnac"
#

CREATE TABLE `resultados_hnac` (
  `cod_resultado_hnac` int(11) NOT NULL AUTO_INCREMENT,
  `fec_resultado_hnac` date NOT NULL,
  `cod_carrera_hnac` int(11) NOT NULL,
  `num_caballo_hnac` varchar(11) NOT NULL,
  `div_pago_hnac` decimal(10,2) NOT NULL,
  `cod_tventa_hnac` int(3) NOT NULL,
  `cod_taquilla` int(11) NOT NULL,
  `lin_dividendo` int(2) DEFAULT NULL,
  PRIMARY KEY (`cod_resultado_hnac`),
  KEY `cod_carrera_hnac` (`cod_carrera_hnac`),
  KEY `fec_resultado_hnac` (`fec_resultado_hnac`),
  KEY `cod_tventa_hnac` (`cod_tventa_hnac`),
  KEY `cod_taquilla` (`cod_taquilla`)
) ENGINE=InnoDB AUTO_INCREMENT=24899 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "resultados_lot"
#

CREATE TABLE `resultados_lot` (
  `id_resultado` int(11) NOT NULL AUTO_INCREMENT,
  `id_banca` int(11) NOT NULL,
  `id_loteria` int(11) NOT NULL,
  `fec_resultado` date NOT NULL,
  `num_resultado` varchar(5) NOT NULL,
  `sig_resultado` int(11) NOT NULL,
  PRIMARY KEY (`id_resultado`),
  UNIQUE KEY `cod_resultado` (`id_resultado`),
  KEY `cod_banca` (`id_banca`),
  KEY `cod_loteria` (`id_loteria`),
  KEY `fec_resultado` (`fec_resultado`),
  KEY `num_resultado` (`num_resultado`),
  KEY `sig_resultado` (`sig_resultado`)
) ENGINE=InnoDB AUTO_INCREMENT=3590 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "resultados_oficiales_hnac"
#

CREATE TABLE `resultados_oficiales_hnac` (
  `cod_resultado_hnac` int(11) NOT NULL AUTO_INCREMENT,
  `fec_resultado_hnac` date NOT NULL DEFAULT '0000-00-00',
  `cod_carrera_hnac` int(11) NOT NULL,
  `num_caballo_hnac` varchar(11) NOT NULL,
  `div_pago_hnac` decimal(10,2) NOT NULL,
  `lin_dividendo` int(2) NOT NULL,
  `cod_tventa_hnac` int(3) NOT NULL,
  `fac_div_hnac` int(11) NOT NULL DEFAULT 0,
  `est_empate_hnac` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cod_resultado_hnac`),
  KEY `fec_resultado_hnac` (`fec_resultado_hnac`),
  KEY `cod_carrera_hnac` (`cod_carrera_hnac`),
  KEY `num_caballo_hnac` (`num_caballo_hnac`)
) ENGINE=InnoDB AUTO_INCREMENT=20267 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Structure for table "retirados"
#

CREATE TABLE `retirados` (
  `cod_retirado` int(11) NOT NULL AUTO_INCREMENT,
  `cod_carrera` int(11) NOT NULL,
  `num_rcaballo` int(11) NOT NULL,
  `fec_retirado` timestamp NOT NULL DEFAULT current_timestamp(),
  `quienretiro` varchar(155) DEFAULT NULL,
  PRIMARY KEY (`cod_retirado`),
  KEY `cod_carrera` (`cod_carrera`),
  KEY `num_rcaballo` (`num_rcaballo`),
  KEY `fec_retirado` (`fec_retirado`)
) ENGINE=InnoDB AUTO_INCREMENT=509195 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "signos"
#

CREATE TABLE `signos` (
  `id_signo` int(11) NOT NULL AUTO_INCREMENT,
  `nom_signo` varchar(30) NOT NULL,
  `nom_corto` varchar(5) NOT NULL,
  PRIMARY KEY (`id_signo`),
  UNIQUE KEY `cod_signo` (`id_signo`),
  KEY `cod_signo_2` (`id_signo`),
  KEY `nom_corto` (`nom_corto`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "sorteos"
#

CREATE TABLE `sorteos` (
  `id_sorteo` int(11) NOT NULL AUTO_INCREMENT,
  `nom_sorteo` varchar(30) NOT NULL,
  `hor_sorteo` time NOT NULL,
  `tur_sorteo` varchar(1) NOT NULL,
  `lun` int(1) NOT NULL,
  `mar` int(1) NOT NULL,
  `mie` int(1) NOT NULL,
  `jue` int(1) NOT NULL,
  `vie` int(1) NOT NULL,
  `sab` int(1) NOT NULL,
  `dom` int(1) NOT NULL,
  `ord_sorteo` int(11) NOT NULL,
  `id_grupo_lot` int(11) NOT NULL,
  `est_sorteo` int(1) NOT NULL,
  PRIMARY KEY (`id_sorteo`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "taquilla"
#

CREATE TABLE `taquilla` (
  `cod_taquilla` int(11) NOT NULL AUTO_INCREMENT,
  `nom_taquilla` varchar(30) NOT NULL,
  `tra_codigo` tinyint(1) NOT NULL,
  `nom_representante` varchar(30) DEFAULT '',
  `tel_taquilla` varchar(15) DEFAULT '',
  `tel_taquilla2` varchar(15) DEFAULT '',
  `tel_taquilla3` varchar(15) DEFAULT '',
  `cod_agencia` int(11) NOT NULL,
  `est_taquilla` int(1) NOT NULL DEFAULT 0,
  `taq_vende_ame` int(1) DEFAULT NULL,
  `taq_por_ame` decimal(10,2) DEFAULT NULL,
  `taq_por_ame_tipo` int(2) DEFAULT 0,
  `taq_vende_hnac` int(1) DEFAULT NULL,
  `taq_cob_hnac` decimal(10,2) DEFAULT NULL,
  `taq_cob_hnac_tipo` int(11) DEFAULT 0,
  `taq_vende_parley` int(1) DEFAULT NULL,
  `taq_por_parley` decimal(10,2) DEFAULT NULL,
  `taq_por_parley_tipo` int(2) DEFAULT 0,
  `taq_vende_ani` int(11) DEFAULT 0,
  `taq_por_ani` decimal(10,2) DEFAULT 0.00,
  `taq_por_ani_tipo` int(2) DEFAULT 0,
  `est_taquilla_hnac` int(1) NOT NULL DEFAULT 0,
  `cob_alquiler_hnac_taq` decimal(10,2) NOT NULL DEFAULT 0.00,
  `vid_ame_ta` int(1) DEFAULT 0,
  `cob_video_ame_ta` int(11) DEFAULT 0,
  `vid_hnac_ta` int(1) DEFAULT 0,
  `cob_video_hnac_ta` int(11) DEFAULT 0,
  `efectivoO` int(11) NOT NULL DEFAULT 0,
  `saldoactual` decimal(12,2) DEFAULT 0.00,
  `saldoactualusd` decimal(12,2) DEFAULT 0.00 COMMENT 'modificasa',
  `saldoactualcop` decimal(12,2) DEFAULT 0.00 COMMENT 'modificasa',
  `saldoactualsol` decimal(12,2) DEFAULT 0.00 COMMENT 'modificasa',
  `tipotaquilla` int(11) DEFAULT 0,
  `taq_vende_parl` int(1) DEFAULT 0,
  `alerta_corte_taq` int(1) DEFAULT 0,
  `moneda` int(2) DEFAULT 0,
  `tipo_pago` int(1) DEFAULT 0,
  `actualizado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `pag_codigo` int(1) DEFAULT NULL,
  `especialfuncion1` int(11) DEFAULT 0,
  `reporte_new` int(1) NOT NULL DEFAULT 0,
  `moneda_ame` int(1) NOT NULL DEFAULT -1,
  `moneda_hnac` int(1) NOT NULL DEFAULT -1,
  `moneda_parley` int(1) NOT NULL DEFAULT -1,
  `moneda_ani` int(1) NOT NULL DEFAULT -1,
  `moneda_apos` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cod_taquilla`),
  KEY `cod_banca` (`cod_agencia`),
  KEY `nom_taquilla` (`nom_taquilla`),
  KEY `tipotaquilla` (`tipotaquilla`)
) ENGINE=InnoDB AUTO_INCREMENT=8255 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "taquilla_opc_ame"
#

CREATE TABLE `taquilla_opc_ame` (
  `cod_taopcame` int(11) NOT NULL AUTO_INCREMENT,
  `cod_taquilla` int(11) NOT NULL,
  `por_taquilla` decimal(12,2) DEFAULT NULL,
  `apu_maxgan` decimal(12,2) NOT NULL DEFAULT 0.00,
  `apu_maxpla` decimal(12,2) NOT NULL DEFAULT 0.00,
  `apu_maxsho` decimal(12,2) NOT NULL DEFAULT 0.00,
  `apu_maxexa` decimal(12,2) NOT NULL DEFAULT 0.00,
  `apu_maxtri` decimal(12,2) NOT NULL DEFAULT 0.00,
  `apu_maxsup` decimal(12,2) NOT NULL DEFAULT 0.00,
  `apu_mingan` decimal(12,2) NOT NULL DEFAULT 0.00,
  `apu_minpla` decimal(12,2) NOT NULL DEFAULT 0.00,
  `apu_minsho` decimal(12,2) NOT NULL DEFAULT 0.00,
  `apu_minexa` decimal(12,2) NOT NULL DEFAULT 0.00,
  `apu_mintri` decimal(12,2) NOT NULL DEFAULT 0.00,
  `apu_minsup` decimal(12,2) NOT NULL DEFAULT 0.00,
  `est_venta_ame` int(1) NOT NULL,
  `reg_gan` decimal(12,2) NOT NULL DEFAULT 0.00,
  `reg_pla` int(11) NOT NULL,
  `reg_sho` int(11) NOT NULL,
  `reg_exa` int(11) NOT NULL,
  `reg_tri` int(11) NOT NULL,
  `reg_sup` int(11) NOT NULL,
  `est_gan` int(1) NOT NULL,
  `est_pla` int(1) NOT NULL,
  `est_sho` int(1) NOT NULL,
  `est_exa` int(1) NOT NULL,
  `est_tri` int(1) NOT NULL,
  `est_sup` int(1) NOT NULL,
  `apu_minima` int(11) NOT NULL,
  `max_aganar_gan` int(11) NOT NULL,
  `max_aganar_pla` int(11) NOT NULL,
  `max_aganar_sho` int(11) NOT NULL,
  `max_aganar_exa` int(11) NOT NULL,
  `max_aganar_tri` int(11) NOT NULL,
  `max_aganar_sup` int(11) NOT NULL,
  `mon_maxticket` int(11) NOT NULL,
  `mon_maxejemplar` int(11) NOT NULL,
  `min_ejecarrera` int(11) NOT NULL,
  `pag_codigo` int(1) DEFAULT NULL,
  `tic_caduca` int(2) DEFAULT NULL,
  `anu_regalia` decimal(12,2) NOT NULL DEFAULT 0.00,
  `est_impresion` int(1) NOT NULL DEFAULT 0,
  `tip_ticket` int(1) NOT NULL DEFAULT 0,
  `lar_ticket` int(2) NOT NULL DEFAULT 5,
  `ver_porpagar` int(1) NOT NULL DEFAULT 0,
  `tie_reclamo` int(3) NOT NULL DEFAULT 0,
  `tam_ticket` int(2) DEFAULT 14,
  `newconomonetario` int(11) DEFAULT 0,
  `def_regdiv1` int(1) NOT NULL DEFAULT 0,
  `div_pdes1` decimal(10,2) NOT NULL,
  `div_phas1` decimal(10,2) NOT NULL,
  `pag_pdiv1` decimal(10,2) NOT NULL,
  `opc_ame` int(1) DEFAULT NULL,
  `div_pdes2` decimal(10,2) NOT NULL,
  `div_phas2` decimal(10,2) NOT NULL,
  `pag_pdiv2` decimal(10,2) NOT NULL,
  `opc_ame2` int(1) DEFAULT NULL,
  `redondeo_ame` int(1) DEFAULT 0,
  `hip_bloqueados` mediumtext DEFAULT NULL,
  `limit_ticket_ame` int(1) NOT NULL DEFAULT 0,
  `coletilla_ame` varchar(250) DEFAULT NULL,
  `sino_codtic` int(1) NOT NULL DEFAULT 0,
  `config_varias` varchar(250) DEFAULT NULL,
  `liberar_apuestas` int(1) NOT NULL DEFAULT 0,
  `div_reg_empate` int(1) NOT NULL DEFAULT 1,
  `cuadre_opc` varchar(250) DEFAULT NULL,
  `anu_hip_bloqueados` varchar(350) DEFAULT NULL,
  `mon_maxcarr` int(11) NOT NULL,
  `triple_hipo` mediumtext NOT NULL,
  `div_pdes3` decimal(10,2) DEFAULT NULL,
  `div_phas3` decimal(10,2) DEFAULT NULL,
  `pag_pdiv3` decimal(10,2) DEFAULT NULL,
  `opc_ame3` int(11) DEFAULT NULL,
  `div_pdes4` decimal(10,2) DEFAULT NULL,
  `div_phas4` decimal(10,2) DEFAULT NULL,
  `pag_pdiv4` decimal(10,2) DEFAULT NULL,
  `opc_ame4` int(11) DEFAULT NULL,
  PRIMARY KEY (`cod_taopcame`),
  KEY `cod_taquilla` (`cod_taquilla`)
) ENGINE=InnoDB AUTO_INCREMENT=7243 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='FComment';

#
# Structure for table "taquilla_opc_ani"
#

CREATE TABLE `taquilla_opc_ani` (
  `cod_taqopcani` int(11) NOT NULL AUTO_INCREMENT,
  `cod_taquilla` int(11) NOT NULL DEFAULT 0,
  `apu_min` decimal(12,2) DEFAULT NULL,
  `apu_max` decimal(12,2) DEFAULT 0.00,
  `tope_animalito_todos` decimal(12,2) DEFAULT 0.00,
  `max_ticket_eliminar` int(11) DEFAULT NULL,
  `max_minutos_eliminar` int(11) DEFAULT NULL,
  `cierre_adelantado` int(11) DEFAULT NULL,
  `varios_x_loteria` varchar(600) DEFAULT NULL,
  `opc_cierre` int(1) NOT NULL,
  `tic_caduca` int(11) NOT NULL,
  `coletilla_ani` varchar(250) DEFAULT NULL,
  `largoticketani` int(1) NOT NULL,
  `config_varias` varchar(250) DEFAULT NULL,
  `pro_auto` int(1) NOT NULL DEFAULT 0,
  `pag_codigo_ani` int(1) NOT NULL DEFAULT 0,
  `tie_reclamo_ani` int(11) NOT NULL DEFAULT 0,
  `ticket_nuevo` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cod_taqopcani`),
  KEY `cod_taquilla_ani_opc` (`cod_taquilla`)
) ENGINE=InnoDB AUTO_INCREMENT=1014 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "taquilla_opc_hnac"
#

CREATE TABLE `taquilla_opc_hnac` (
  `cod_taopc_hnac` int(11) NOT NULL AUTO_INCREMENT,
  `cod_taquilla` int(11) NOT NULL,
  `tic_caduca_hnac` int(2) NOT NULL,
  `con_divid_hnac` int(1) NOT NULL,
  `mod_divid_hnac` int(1) NOT NULL,
  `max_jugtic_hnac` decimal(14,2) DEFAULT NULL,
  `min_jugtic_hnac` decimal(10,2) NOT NULL,
  `max_eje_hnac` decimal(14,2) DEFAULT NULL,
  `cab_min_hnac` int(2) NOT NULL,
  `top_pfav_hnac` decimal(10,2) NOT NULL,
  `top_sfav_hnac` decimal(10,2) NOT NULL,
  `top_tfav_hnac` decimal(10,2) NOT NULL,
  `top_dem_hnac` decimal(10,2) NOT NULL,
  `def_rin_regdiv_hnac` int(1) NOT NULL,
  `div_rin_pdes_hnac` decimal(10,2) NOT NULL,
  `div_rin_phas_hnac` decimal(10,2) NOT NULL,
  `opc_rin_pdiv_hnac` int(1) NOT NULL,
  `pag_rin_pdiv_hnac` decimal(10,2) NOT NULL,
  `div_rin_sdes_hnac` decimal(10,2) NOT NULL,
  `div_rin_shas_hnac` decimal(10,2) NOT NULL,
  `opc_rin_sdiv_hnac` int(1) NOT NULL,
  `pag_rin_sdiv_hnac` decimal(10,2) NOT NULL,
  `div_rin_tdes_hnac` decimal(10,2) NOT NULL,
  `div_rin_thas_hnac` decimal(10,2) NOT NULL,
  `opc_rin_tdiv_hnac` int(1) NOT NULL,
  `pag_rin_tdiv_hnac` decimal(10,2) NOT NULL,
  `div_rin_ddes_hnac` decimal(10,2) NOT NULL,
  `div_rin_dhas_hnac` decimal(10,2) NOT NULL,
  `opc_rin_ddiv_hnac` int(1) NOT NULL,
  `pag_rin_ddiv_hnac` decimal(10,2) NOT NULL,
  `div_rin_qdes_hnac` decimal(10,2) NOT NULL,
  `div_rin_qhas_hnac` decimal(10,2) NOT NULL,
  `opc_rin_qdiv_hnac` int(1) NOT NULL,
  `pag_rin_qdiv_hnac` decimal(10,2) NOT NULL,
  `def_val_regdiv_hnac` int(1) NOT NULL,
  `div_val_pdes_hnac` decimal(10,2) NOT NULL,
  `div_val_phas_hnac` decimal(10,2) NOT NULL,
  `opc_val_pdiv_hnac` int(1) NOT NULL,
  `pag_val_pdiv_hnac` decimal(10,2) NOT NULL,
  `div_val_sdes_hnac` decimal(10,2) NOT NULL,
  `div_val_shas_hnac` decimal(10,2) NOT NULL,
  `opc_val_sdiv_hnac` int(1) NOT NULL,
  `pag_val_sdiv_hnac` decimal(10,2) NOT NULL,
  `div_val_tdes_hnac` decimal(10,2) NOT NULL,
  `div_val_thas_hnac` decimal(10,2) NOT NULL,
  `opc_val_tdiv_hnac` int(1) NOT NULL,
  `pag_val_tdiv_hnac` decimal(10,2) NOT NULL,
  `div_val_ddes_hnac` decimal(10,2) NOT NULL,
  `div_val_dhas_hnac` decimal(10,2) NOT NULL,
  `opc_val_ddiv_hnac` int(1) NOT NULL,
  `pag_val_ddiv_hnac` decimal(10,2) NOT NULL,
  `div_val_qdes_hnac` decimal(10,2) NOT NULL,
  `div_val_qhas_hnac` decimal(10,2) NOT NULL,
  `opc_val_qdiv_hnac` int(1) NOT NULL,
  `pag_val_qdiv_hnac` decimal(10,2) NOT NULL,
  `def_san_regdiv_hnac` int(1) NOT NULL,
  `div_san_pdes_hnac` decimal(10,2) NOT NULL,
  `div_san_phas_hnac` decimal(10,2) NOT NULL,
  `opc_san_pdiv_hnac` int(1) NOT NULL,
  `pag_san_pdiv_hnac` decimal(10,2) NOT NULL,
  `div_san_sdes_hnac` decimal(10,2) NOT NULL,
  `div_san_shas_hnac` decimal(10,2) NOT NULL,
  `opc_san_sdiv_hnac` int(1) NOT NULL,
  `pag_san_sdiv_hnac` decimal(10,2) NOT NULL,
  `div_san_tdes_hnac` decimal(10,2) NOT NULL,
  `div_san_thas_hnac` decimal(10,2) NOT NULL,
  `opc_san_tdiv_hnac` int(1) NOT NULL,
  `pag_san_tdiv_hnac` decimal(10,2) NOT NULL,
  `div_san_ddes_hnac` decimal(10,2) NOT NULL,
  `div_san_dhas_hnac` decimal(10,2) NOT NULL,
  `opc_san_ddiv_hnac` int(1) NOT NULL,
  `pag_san_ddiv_hnac` decimal(10,2) NOT NULL,
  `div_san_qdes_hnac` decimal(10,2) NOT NULL,
  `div_san_qhas_hnac` decimal(10,2) NOT NULL,
  `opc_san_qdiv_hnac` int(1) NOT NULL,
  `pag_san_qdiv_hnac` decimal(10,2) NOT NULL,
  `def_ran_regdiv_hnac` int(1) NOT NULL,
  `div_ran_pdes_hnac` decimal(10,2) NOT NULL,
  `div_ran_phas_hnac` decimal(10,2) NOT NULL,
  `opc_ran_pdiv_hnac` int(1) NOT NULL,
  `pag_ran_pdiv_hnac` decimal(10,2) NOT NULL,
  `div_ran_sdes_hnac` decimal(10,2) NOT NULL,
  `div_ran_shas_hnac` decimal(10,2) NOT NULL,
  `opc_ran_sdiv_hnac` int(1) NOT NULL,
  `pag_ran_sdiv_hnac` decimal(10,2) NOT NULL,
  `div_ran_tdes_hnac` decimal(10,2) NOT NULL,
  `div_ran_thas_hnac` decimal(10,2) NOT NULL,
  `opc_ran_tdiv_hnac` int(1) NOT NULL,
  `pag_ran_tdiv_hnac` decimal(10,2) NOT NULL,
  `div_ran_ddes_hnac` decimal(10,2) NOT NULL,
  `div_ran_dhas_hnac` decimal(10,2) NOT NULL,
  `opc_ran_ddiv_hnac` int(1) NOT NULL,
  `pag_ran_ddiv_hnac` decimal(10,2) NOT NULL,
  `div_ran_qdes_hnac` decimal(10,2) NOT NULL,
  `div_ran_qhas_hnac` decimal(10,2) NOT NULL,
  `opc_ran_qdiv_hnac` int(1) NOT NULL,
  `pag_ran_qdiv_hnac` decimal(10,2) NOT NULL,
  `est_gan_hnac` int(1) NOT NULL,
  `est_pla_hnac` int(1) NOT NULL,
  `est_exa_hnac` int(1) NOT NULL,
  `est_tri_hnac` int(1) NOT NULL,
  `est_sup_hnac` int(1) NOT NULL,
  `anc_ticket_hnac` int(1) DEFAULT NULL,
  `lar_ticket_hnac` int(2) NOT NULL DEFAULT 5,
  `ver_porpagar_hnac` int(1) DEFAULT NULL,
  `rin_eje_des1_hnac` int(11) NOT NULL DEFAULT 0,
  `rin_eje_des2_hnac` int(11) NOT NULL DEFAULT 0,
  `rin_eje_des3_hnac` int(11) NOT NULL DEFAULT 0,
  `rin_eje_des4_hnac` int(11) NOT NULL DEFAULT 0,
  `rin_eje_des5_hnac` int(11) NOT NULL DEFAULT 0,
  `rin_eje_has1_hnac` int(11) NOT NULL DEFAULT 0,
  `rin_eje_has2_hnac` int(11) NOT NULL DEFAULT 0,
  `rin_eje_has3_hnac` int(11) NOT NULL DEFAULT 0,
  `rin_eje_has4_hnac` int(11) NOT NULL DEFAULT 0,
  `rin_eje_has5_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_des1_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_des2_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_des3_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_des4_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_des5_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_has1_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_has2_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_has3_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_has4_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_has5_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_des1_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_des2_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_des3_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_des4_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_des5_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_has1_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_has2_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_has3_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_has4_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_has5_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_des1_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_des2_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_des3_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_des4_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_des5_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_has1_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_has2_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_has3_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_has4_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_has5_hnac` int(11) NOT NULL DEFAULT 0,
  `div_rin_6des_hnac` decimal(10,2) NOT NULL,
  `div_rin_6has_hnac` decimal(10,2) NOT NULL,
  `opc_rin_6div_hnac` int(1) NOT NULL,
  `pag_rin_6div_hnac` decimal(10,2) NOT NULL,
  `div_rin_7des_hnac` decimal(10,2) NOT NULL,
  `div_rin_7has_hnac` decimal(10,2) NOT NULL,
  `opc_rin_7div_hnac` int(1) NOT NULL,
  `pag_rin_7div_hnac` decimal(10,2) NOT NULL,
  `div_rin_8des_hnac` decimal(10,2) NOT NULL,
  `div_rin_8has_hnac` decimal(10,2) NOT NULL,
  `opc_rin_8div_hnac` int(1) NOT NULL,
  `pag_rin_8div_hnac` decimal(10,2) NOT NULL,
  `div_val_6des_hnac` decimal(10,2) NOT NULL,
  `div_val_6has_hnac` decimal(10,2) NOT NULL,
  `opc_val_6div_hnac` int(1) NOT NULL,
  `pag_val_6div_hnac` decimal(10,2) NOT NULL,
  `div_val_7des_hnac` decimal(10,2) NOT NULL,
  `div_val_7has_hnac` decimal(10,2) NOT NULL,
  `opc_val_7div_hnac` int(1) NOT NULL,
  `pag_val_7div_hnac` decimal(10,2) NOT NULL,
  `div_val_8des_hnac` decimal(10,2) NOT NULL,
  `div_val_8has_hnac` decimal(10,2) NOT NULL,
  `opc_val_8div_hnac` int(1) NOT NULL,
  `pag_val_8div_hnac` decimal(10,2) NOT NULL,
  `div_san_6des_hnac` decimal(10,2) NOT NULL,
  `div_san_6has_hnac` decimal(10,2) NOT NULL,
  `opc_san_6div_hnac` int(1) NOT NULL,
  `pag_san_6div_hnac` decimal(10,2) NOT NULL,
  `div_san_7des_hnac` decimal(10,2) NOT NULL,
  `div_san_7has_hnac` decimal(10,2) NOT NULL,
  `opc_san_7div_hnac` int(1) NOT NULL,
  `pag_san_7div_hnac` decimal(10,2) NOT NULL,
  `div_san_8des_hnac` decimal(10,2) NOT NULL,
  `div_san_8has_hnac` decimal(10,2) NOT NULL,
  `opc_san_8div_hnac` int(1) NOT NULL,
  `pag_san_8div_hnac` decimal(10,2) NOT NULL,
  `div_ran_6des_hnac` decimal(10,2) NOT NULL,
  `div_ran_6has_hnac` decimal(10,2) NOT NULL,
  `opc_ran_6div_hnac` int(1) NOT NULL,
  `pag_ran_6div_hnac` decimal(10,2) NOT NULL,
  `div_ran_7des_hnac` decimal(10,2) NOT NULL,
  `div_ran_7has_hnac` decimal(10,2) NOT NULL,
  `opc_ran_7div_hnac` int(1) NOT NULL,
  `pag_ran_7div_hnac` decimal(10,2) NOT NULL,
  `div_ran_8des_hnac` decimal(10,2) NOT NULL,
  `div_ran_8has_hnac` decimal(10,2) NOT NULL,
  `opc_ran_8div_hnac` int(1) NOT NULL,
  `pag_ran_8div_hnac` decimal(10,2) NOT NULL,
  `rin_eje_des6_hnac` int(11) NOT NULL DEFAULT 0,
  `rin_eje_des7_hnac` int(11) NOT NULL DEFAULT 0,
  `rin_eje_des8_hnac` int(11) NOT NULL DEFAULT 0,
  `rin_eje_has6_hnac` int(11) NOT NULL DEFAULT 0,
  `rin_eje_has7_hnac` int(11) NOT NULL DEFAULT 0,
  `rin_eje_has8_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_des6_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_des7_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_des8_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_has6_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_has7_hnac` int(11) NOT NULL DEFAULT 0,
  `val_eje_has8_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_des6_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_des7_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_des8_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_has6_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_has7_hnac` int(11) NOT NULL DEFAULT 0,
  `san_eje_has8_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_des6_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_des7_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_des8_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_has6_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_has7_hnac` int(11) NOT NULL DEFAULT 0,
  `ran_eje_has8_hnac` int(11) NOT NULL DEFAULT 0,
  `est_ven_rin_hnac` int(1) NOT NULL DEFAULT 0,
  `est_ven_val_hnac` int(1) NOT NULL DEFAULT 0,
  `est_ven_san_hnac` int(11) NOT NULL DEFAULT 0,
  `est_ven_ran_hnac` int(1) NOT NULL DEFAULT 0,
  `emp_rin_reg1_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_rin_reg2_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_rin_reg3_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_rin_reg4_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_rin_reg5_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_rin_reg6_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_rin_reg7_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_rin_reg8_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_val_reg1_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_val_reg2_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_val_reg3_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_val_reg4_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_val_reg5_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_val_reg6_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_val_reg7_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_val_reg8_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_san_reg1_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_san_reg2_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_san_reg3_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_san_reg4_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_san_reg5_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_san_reg6_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_san_reg7_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_san_reg8_hnac` int(11) NOT NULL DEFAULT 0,
  `est_tope_rin` int(1) NOT NULL,
  `top_pfav_rin_hnac` decimal(10,2) NOT NULL,
  `top_sfav_rin_hnac` decimal(10,2) NOT NULL,
  `top_tfav_rin_hnac` decimal(10,2) NOT NULL,
  `top_dem_rin_hnac` decimal(10,2) NOT NULL,
  `est_tope_ran` int(1) NOT NULL,
  `top_pfav_ran_hnac` decimal(10,2) NOT NULL,
  `top_sfav_ran_hnac` decimal(10,2) NOT NULL,
  `top_tfav_ran_hnac` decimal(10,2) NOT NULL,
  `top_dem_ran_hnac` decimal(10,2) NOT NULL,
  `est_tope_san` int(1) NOT NULL,
  `top_pfav_san_hnac` decimal(10,2) NOT NULL,
  `top_sfav_san_hnac` decimal(10,2) NOT NULL,
  `top_tfav_san_hnac` decimal(10,2) NOT NULL,
  `top_dem_san_hnac` decimal(10,2) NOT NULL,
  `est_tope_val` int(1) NOT NULL,
  `top_pfav_val_hnac` decimal(10,2) NOT NULL,
  `top_sfav_val_hnac` decimal(10,2) NOT NULL,
  `top_tfav_val_hnac` decimal(10,2) NOT NULL,
  `top_dem_val_hnac` decimal(10,2) NOT NULL,
  `emp_ran_reg1_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_ran_reg2_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_ran_reg3_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_ran_reg4_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_ran_reg5_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_ran_reg6_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_ran_reg7_hnac` int(11) NOT NULL DEFAULT 0,
  `emp_ran_reg8_hnac` int(11) NOT NULL DEFAULT 0,
  `pre_fijo_hnac` int(11) NOT NULL DEFAULT 0,
  `tie_venta_hnac` int(11) NOT NULL DEFAULT 0,
  `tip_taq_hnac` int(11) NOT NULL DEFAULT 0,
  `tip_ticket_hnac` int(11) NOT NULL DEFAULT 0,
  `est_ven_macu` int(1) NOT NULL DEFAULT 0,
  `est_ven_rin_macu` int(1) NOT NULL DEFAULT 0,
  `est_ven_val_macu` int(1) NOT NULL DEFAULT 0,
  `est_ven_san_macu` int(1) NOT NULL DEFAULT 0,
  `est_ven_ran_macu` int(1) NOT NULL DEFAULT 0,
  `apu_min_macu` decimal(10,2) NOT NULL DEFAULT 0.00,
  `apu_max_macu` decimal(10,2) NOT NULL DEFAULT 0.00,
  `lim_max_macu` decimal(10,2) NOT NULL DEFAULT 0.00,
  `div_ofi_macu` int(1) NOT NULL DEFAULT 0,
  `mod_div_macu` int(1) NOT NULL DEFAULT 0,
  `apu_cor_macu` int(1) NOT NULL DEFAULT 0,
  `apu_lar_macu` int(1) NOT NULL DEFAULT 0,
  `est_taquilla_hnac` int(1) NOT NULL DEFAULT 0,
  `opc_jornadai_macu` int(1) NOT NULL DEFAULT 0,
  `por_alquiler_macu` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cob_taquilla_hnac` decimal(10,2) DEFAULT NULL,
  `por_alquiler_hanc` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pag_codigo_hnac` int(1) NOT NULL DEFAULT 0,
  `puedecerrar` int(11) DEFAULT 0,
  `newconomonetario` int(11) DEFAULT 0,
  `redondeo_hnac` int(11) DEFAULT 0,
  `limit_ticket` int(1) NOT NULL DEFAULT 0,
  `coletilla_hnac` varchar(250) DEFAULT NULL,
  `sino_codtic` int(1) NOT NULL DEFAULT 0,
  `cuadre_opc_hnac` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`cod_taopc_hnac`),
  KEY `cod_taquilla` (`cod_taquilla`)
) ENGINE=InnoDB AUTO_INCREMENT=3391 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "taquilla_opc_lot"
#

CREATE TABLE `taquilla_opc_lot` (
  `cod_taopclot` int(11) NOT NULL AUTO_INCREMENT,
  `cod_taquilla` int(11) NOT NULL,
  `est_venta_lot` int(1) NOT NULL,
  `est_venta_ani` int(1) NOT NULL,
  `cob_sistema_lot` decimal(10,2) NOT NULL,
  `por_taquilla_lot` decimal(10,2) DEFAULT NULL,
  `por_taquilla_ani` decimal(10,2) NOT NULL,
  `tic_caduca_lot` int(2) NOT NULL,
  `pag_codigo_lot` int(1) NOT NULL,
  `mon_minticket_lot` int(11) NOT NULL,
  `mon_maxticket_lot` int(11) NOT NULL,
  `anc_ticket_lot` int(1) NOT NULL,
  `lar_ticket_lot` int(2) NOT NULL,
  `est_impresion_lot` int(1) NOT NULL,
  `tip_ticket_lot` int(2) NOT NULL,
  `tie_reclamo_lot` int(3) NOT NULL,
  `ver_porpagar_lot` int(1) NOT NULL,
  `ord_turno` int(1) NOT NULL,
  PRIMARY KEY (`cod_taopclot`),
  KEY `cod_taquilla` (`cod_taquilla`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "taquilla_opc_macu"
#

CREATE TABLE `taquilla_opc_macu` (
  `cod_taopcmacu` int(11) NOT NULL AUTO_INCREMENT,
  `cod_taquilla` int(11) NOT NULL,
  `est_ven_rin_macu` int(1) NOT NULL,
  `est_ven_val_macu` int(1) NOT NULL,
  `est_ven_san_macu` int(1) NOT NULL,
  `est_ven_ran_macu` int(1) NOT NULL,
  `apu_min_macu` int(11) NOT NULL,
  `apu_max_macu` int(11) NOT NULL,
  `lim_max_macu` int(11) NOT NULL,
  `div_ofic_macu` int(1) NOT NULL,
  `mod_div_macu` int(1) NOT NULL,
  `opc_jornadai_macu` int(1) NOT NULL,
  PRIMARY KEY (`cod_taopcmacu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "taquilla_opc_parley"
#

CREATE TABLE `taquilla_opc_parley` (
  `cod_taopcparley` int(11) NOT NULL AUTO_INCREMENT,
  `cod_taquilla` int(11) NOT NULL,
  `apu_maxparley` decimal(12,2) NOT NULL DEFAULT 0.00,
  `apu_minparley` decimal(12,2) NOT NULL DEFAULT 0.00,
  `comb_maxparley` int(11) DEFAULT 10,
  `comb_minparley` int(11) DEFAULT 3,
  `comb_hembra` int(11) DEFAULT 3,
  `min_eliminar` int(11) DEFAULT 3,
  `scrollp` int(1) DEFAULT 0,
  `largotikpar` int(2) DEFAULT 0,
  `taptipologro` int(1) DEFAULT 0,
  `tipoticketpar` int(1) DEFAULT 0,
  `cod_clientepar` int(1) DEFAULT 0,
  `monto_apuesta` decimal(12,2) DEFAULT NULL,
  `factor_pago` decimal(12,2) DEFAULT NULL,
  `factor_de_macho` decimal(12,2) DEFAULT 100.00,
  `factor_de_hembra` decimal(12,2) DEFAULT 100.00,
  `beisbol_ml` int(2) NOT NULL DEFAULT 0,
  `beisbol_alta` int(2) NOT NULL DEFAULT 0,
  `beisbol_baja` int(2) NOT NULL DEFAULT 0,
  `beisbol_runline` int(2) NOT NULL DEFAULT 0,
  `beisbol_superl` int(2) NOT NULL DEFAULT 0,
  `beisbol_mj_ml` int(2) NOT NULL DEFAULT 0,
  `beisbol_mj_alta` int(2) NOT NULL DEFAULT 0,
  `beisbol_mj_baja` int(2) NOT NULL DEFAULT 0,
  `beisbol_mj_rl` int(2) NOT NULL DEFAULT 0,
  `beisbol_si` int(2) NOT NULL DEFAULT 0,
  `beisbol_no` int(2) NOT NULL DEFAULT 0,
  `beisbol_anotap` int(2) NOT NULL DEFAULT 0,
  `beisbol_hce` int(2) NOT NULL DEFAULT 0,
  `baloncesto_ml` int(2) NOT NULL DEFAULT 0,
  `baloncesto_alta` int(2) NOT NULL DEFAULT 0,
  `baloncesto_baja` int(2) NOT NULL DEFAULT 0,
  `baloncesto_runline` int(2) NOT NULL DEFAULT 0,
  `baloncesto_mj_ml` int(2) NOT NULL DEFAULT 0,
  `baloncesto_mj_alta` int(2) NOT NULL DEFAULT 0,
  `baloncesto_mj_baja` int(2) NOT NULL DEFAULT 0,
  `baloncesto_mj_rl` int(2) NOT NULL DEFAULT 0,
  `futbol_ml` int(2) NOT NULL DEFAULT 0,
  `futbol_alta` int(2) NOT NULL DEFAULT 0,
  `futbol_baja` int(2) NOT NULL DEFAULT 0,
  `futbol_empate` int(2) NOT NULL DEFAULT 0,
  `futbol_mj_ml` int(2) NOT NULL DEFAULT 0,
  `futbol_mj_alta` int(2) NOT NULL DEFAULT 0,
  `futbol_mj_baja` int(2) NOT NULL DEFAULT 0,
  `futbol_mj_empate` int(2) NOT NULL DEFAULT 0,
  `futbolame_ml` int(2) NOT NULL DEFAULT 0,
  `futbolame_alta` int(2) NOT NULL DEFAULT 0,
  `futbolame_baja` int(2) NOT NULL DEFAULT 0,
  `futbolame_runline` int(2) NOT NULL DEFAULT 0,
  `futbolame_mj_ml` int(2) NOT NULL DEFAULT 0,
  `futbolame_mj_alta` int(2) NOT NULL DEFAULT 0,
  `futbolame_mj_baja` int(2) NOT NULL DEFAULT 0,
  `futbolame_mj_rl` int(2) NOT NULL DEFAULT 0,
  `hockey_ml` int(2) NOT NULL DEFAULT 0,
  `hockey_alta` int(2) NOT NULL DEFAULT 0,
  `hockey_baja` int(2) NOT NULL DEFAULT 0,
  `hockey_runline` int(2) NOT NULL DEFAULT 0,
  `aceeso_maximo_ticket` int(11) NOT NULL,
  `permiso_jugada` int(1) NOT NULL,
  `coletilla_parley` varchar(250) DEFAULT NULL,
  `tic_caduca` int(11) NOT NULL,
  `config_varias` varchar(250) DEFAULT NULL,
  `tie_reclamo_parley` int(11) NOT NULL DEFAULT 0,
  `pag_codigo_parley` int(11) NOT NULL DEFAULT 1,
  `eli_cod_parley` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cod_taopcparley`),
  KEY `cod_taquilla` (`cod_taquilla`)
) ENGINE=InnoDB AUTO_INCREMENT=1432 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

#
# Structure for table "tasadecambio"
#

CREATE TABLE `tasadecambio` (
  `Idtasadecambio` int(11) NOT NULL AUTO_INCREMENT,
  `usdabss` decimal(10,4) DEFAULT 0.0000,
  `copabss` decimal(10,4) DEFAULT 0.0000,
  `solabss` decimal(10,4) DEFAULT 0.0000,
  `apuestaminbs` decimal(10,2) DEFAULT NULL,
  `nacionales` varchar(255) DEFAULT '2',
  PRIMARY KEY (`Idtasadecambio`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ROW_FORMAT=DYNAMIC;

#
# Structure for table "time"
#

CREATE TABLE `time` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `tiempo` decimal(10,5) DEFAULT 0.00000,
  `de` varchar(255) DEFAULT NULL,
  `fechahora` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

#
# Structure for table "uadmin"
#

CREATE TABLE `uadmin` (
  `cod_uadmin` int(11) NOT NULL AUTO_INCREMENT,
  `nom_uadmin` varchar(30) NOT NULL,
  `pas_uadmin` varchar(30) NOT NULL,
  `tip_uadmin` varchar(5) NOT NULL,
  `est_uadmin` int(11) NOT NULL,
  PRIMARY KEY (`cod_uadmin`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "uagencia"
#

CREATE TABLE `uagencia` (
  `cod_uagencia` int(11) NOT NULL AUTO_INCREMENT,
  `cod_agencia` int(11) NOT NULL,
  `nom_uagencia` varchar(30) NOT NULL,
  `pas_uagencia` varchar(30) NOT NULL,
  `tip_uagencia` varchar(5) NOT NULL,
  `est_uagencia` int(11) NOT NULL,
  PRIMARY KEY (`cod_uagencia`),
  KEY `cod_agencia` (`cod_agencia`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "ubanca"
#

CREATE TABLE `ubanca` (
  `cod_ubanca` int(11) NOT NULL AUTO_INCREMENT,
  `cod_banca` int(11) NOT NULL,
  `nom_ubanca` varchar(30) NOT NULL,
  `pas_ubanca` varchar(30) NOT NULL,
  `tip_ubanca` varchar(5) NOT NULL,
  `est_ubanca` int(11) NOT NULL,
  PRIMARY KEY (`cod_ubanca`),
  KEY `cod_banca` (`cod_banca`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "usuario"
#

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nom_usuario` varchar(30) NOT NULL,
  `nom_completo` varchar(40) DEFAULT '',
  `tip_usuario` varchar(5) NOT NULL,
  `cod_taquilla` int(11) NOT NULL,
  `pas_usuario` varchar(20) NOT NULL,
  `est_usuario` int(11) NOT NULL,
  `tic_eliminados` int(2) NOT NULL,
  `cod_barra` int(1) NOT NULL,
  `hor_inicio` time NOT NULL,
  `hor_fin` time NOT NULL,
  `dia_entrada` varchar(13) NOT NULL,
  `niv_acceso` int(1) NOT NULL,
  `ini_programa` int(1) NOT NULL DEFAULT 0,
  `can_reimpresion` int(11) NOT NULL DEFAULT 50,
  `can_reimpresion_hnac` int(11) NOT NULL DEFAULT 50,
  `ZonaHorario` varchar(10) DEFAULT '+6 hour',
  `ImpSI0NO1` int(2) DEFAULT 0,
  `24hr` int(2) NOT NULL DEFAULT 0,
  `corte_pro` datetime DEFAULT NULL,
  `sin_ticket` date NOT NULL,
  `ticket_corto` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_usuario`),
  KEY `cod_taquilla` (`cod_taquilla`),
  KEY `nom_usuario` (`nom_usuario`),
  KEY `tip_usuario` (`tip_usuario`),
  KEY `pas_usuario` (`pas_usuario`),
  KEY `idx_opt_usu_taq_tip_nom` (`cod_taquilla`,`tip_usuario`,`nom_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=10417 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "usuario_taquilla"
#

CREATE TABLE `usuario_taquilla` (
  `id_usu_taq` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `apu_maxgan` decimal(10,2) NOT NULL,
  `apu_maxpla` decimal(10,2) NOT NULL,
  `apu_maxsho` decimal(10,2) NOT NULL,
  `apu_minima` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_usu_taq`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `usuario_taquilla_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "variables"
#

CREATE TABLE `variables` (
  `variablenum` int(11) DEFAULT NULL,
  `variableejec` varchar(50) DEFAULT NULL,
  `variablenom` varchar(50) DEFAULT NULL,
  `variabledat` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# Structure for table "venta"
#

CREATE TABLE `venta` (
  `num_ticket` bigint(5) NOT NULL AUTO_INCREMENT,
  `ticket` bigint(5) NOT NULL DEFAULT 0,
  `ser_venta` varchar(11) NOT NULL,
  `can_ticket` int(11) NOT NULL,
  `cod_taquilla` int(11) NOT NULL,
  `fec_venta` date NOT NULL,
  `hor_venta` time NOT NULL,
  `mon_venta` decimal(12,2) DEFAULT NULL,
  `cod_tventa` int(11) NOT NULL,
  `num_caballo` varchar(11) NOT NULL,
  `cod_carrera` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `est_ticket` int(11) NOT NULL,
  `lin_ticket` int(5) NOT NULL,
  `ip_venta` varchar(16) NOT NULL,
  `fec_pago` date DEFAULT NULL,
  `hor_pago` time DEFAULT NULL,
  `cod_usuario_pago` int(11) DEFAULT NULL,
  `ip_pago` varchar(16) DEFAULT NULL,
  `pag_premio` decimal(14,4) NOT NULL DEFAULT 0.0000,
  `rei_ticket` int(11) NOT NULL DEFAULT 0,
  `est_calculo` int(11) NOT NULL DEFAULT 0,
  `cod_cliente` varchar(15) DEFAULT '',
  `tra_codigo` tinyint(1) NOT NULL,
  `conomonetario` int(11) DEFAULT 0,
  `efectivoO` int(11) DEFAULT 0,
  `pais` varchar(11) DEFAULT NULL,
  `newconomonetario` int(11) DEFAULT 0,
  `ocultar` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`num_ticket`,`fec_venta`),
  KEY `ticket` (`ticket`),
  KEY `ser_venta` (`ser_venta`),
  KEY `fec_venta` (`fec_venta`),
  KEY `cod_tventa` (`cod_tventa`),
  KEY `cod_carrera` (`cod_carrera`),
  KEY `fec_pago` (`fec_pago`),
  KEY `cod_usuario_pago` (`cod_usuario_pago`),
  KEY `est_ticket` (`est_ticket`),
  KEY `cod_ta_fe_fe` (`cod_taquilla`,`fec_venta`,`fec_pago`),
  KEY `id_us_fe_fe` (`id_usuario`,`fec_venta`,`fec_pago`),
  KEY `cod_taquilla` (`cod_taquilla`),
  KEY `id_usuario` (`id_usuario`),
  KEY `est_calculo` (`est_calculo`),
  KEY `a2020a` (`fec_venta`,`est_calculo`,`est_ticket`),
  KEY `usuario_fecha_carrera` (`id_usuario`,`fec_venta`,`cod_carrera`),
  KEY `idx_opt_venta_usu_fec` (`id_usuario`,`fec_venta`,`cod_taquilla`,`num_ticket`),
  KEY `idx_opt_venta_taq_fec` (`cod_taquilla`,`fec_venta`,`num_ticket`)
) ENGINE=InnoDB AUTO_INCREMENT=50375979 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci
 PARTITION BY RANGE  COLUMNS(`fec_venta`)
(PARTITION `p_historico` VALUES LESS THAN ('2026-01-01') ENGINE = InnoDB,
 PARTITION `p2026_01` VALUES LESS THAN ('2026-02-01') ENGINE = InnoDB,
 PARTITION `p2026_02` VALUES LESS THAN ('2026-03-01') ENGINE = InnoDB,
 PARTITION `p2026_03` VALUES LESS THAN ('2026-04-01') ENGINE = InnoDB,
 PARTITION `p2026_04` VALUES LESS THAN ('2026-05-01') ENGINE = InnoDB,
 PARTITION `p2026_05` VALUES LESS THAN ('2026-06-01') ENGINE = InnoDB,
 PARTITION `p2026_06` VALUES LESS THAN ('2026-07-01') ENGINE = InnoDB,
 PARTITION `p2026_07` VALUES LESS THAN ('2026-08-01') ENGINE = InnoDB,
 PARTITION `p2026_08` VALUES LESS THAN ('2026-09-01') ENGINE = InnoDB,
 PARTITION `p2026_09` VALUES LESS THAN ('2026-10-01') ENGINE = InnoDB,
 PARTITION `p2026_10` VALUES LESS THAN ('2026-11-01') ENGINE = InnoDB,
 PARTITION `p2026_11` VALUES LESS THAN ('2026-12-01') ENGINE = InnoDB,
 PARTITION `p2026_12` VALUES LESS THAN ('2027-01-01') ENGINE = InnoDB,
 PARTITION `p_futuro` VALUES LESS THAN (MAXVALUE) ENGINE = InnoDB);

#
# Structure for table "venta_hnac"
#

CREATE TABLE `venta_hnac` (
  `num_ticket_hnac` bigint(11) NOT NULL AUTO_INCREMENT,
  `ticket_hnac` bigint(11) NOT NULL DEFAULT 0,
  `ser_venta_hnac` varchar(11) NOT NULL,
  `num_caballo_hnac` varchar(11) NOT NULL,
  `mon_venta_hnac` decimal(14,5) DEFAULT NULL,
  `can_ticket_hnac` int(5) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fec_venta_hnac` date NOT NULL,
  `hor_venta_hnac` time NOT NULL,
  `ip_venta_hnac` varchar(16) NOT NULL,
  `cod_tventa_hnac` int(3) NOT NULL,
  `cod_carrera_hnac` int(11) NOT NULL,
  `est_ticket_hnac` int(1) NOT NULL,
  `ip_pago_hnac` varchar(16) DEFAULT NULL,
  `cod_usuario_pago_hnac` int(9) NOT NULL DEFAULT 0,
  `hor_pago_hnac` time NOT NULL DEFAULT '00:00:00',
  `fec_pago_hnac` date NOT NULL DEFAULT '0000-00-00',
  `pag_premio_hnac` decimal(14,5) NOT NULL DEFAULT 0.00000,
  `est_calculo_hnac` int(11) NOT NULL DEFAULT 0,
  `rei_ticket_hnac` int(11) NOT NULL DEFAULT 0,
  `lin_ticket_hnac` int(5) NOT NULL DEFAULT 0,
  `conomonetario` int(11) DEFAULT 0,
  `cod_clienten` varchar(15) DEFAULT '',
  `efectivoOn` int(11) DEFAULT 0,
  `special` int(11) NOT NULL,
  `ocultar` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`num_ticket_hnac`,`fec_venta_hnac`),
  KEY `id_usuario` (`id_usuario`),
  KEY `fec_venta_hnac` (`fec_venta_hnac`),
  KEY `est_ticket_hnac` (`est_ticket_hnac`),
  KEY `cod_carrera_hnac` (`cod_carrera_hnac`),
  KEY `cod_tventa_hnac` (`cod_tventa_hnac`),
  KEY `num_ticket_hnac` (`num_ticket_hnac`),
  KEY `fec_pago_hnac` (`fec_pago_hnac`),
  KEY `ticket_hnac` (`ticket_hnac`),
  KEY `ser_venta_hnac` (`ser_venta_hnac`),
  KEY `est_calculo_hnac` (`est_calculo_hnac`),
  KEY `id_us_fe_fe` (`id_usuario`,`fec_venta_hnac`,`fec_pago_hnac`)
) ENGINE=InnoDB AUTO_INCREMENT=3358958 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci
 PARTITION BY RANGE  COLUMNS(`fec_venta_hnac`)
(PARTITION `p_historico` VALUES LESS THAN ('2026-01-01') ENGINE = InnoDB,
 PARTITION `p2026_01` VALUES LESS THAN ('2026-02-01') ENGINE = InnoDB,
 PARTITION `p2026_02` VALUES LESS THAN ('2026-03-01') ENGINE = InnoDB,
 PARTITION `p2026_03` VALUES LESS THAN ('2026-04-01') ENGINE = InnoDB,
 PARTITION `p2026_04` VALUES LESS THAN ('2026-05-01') ENGINE = InnoDB,
 PARTITION `p2026_05` VALUES LESS THAN ('2026-06-01') ENGINE = InnoDB,
 PARTITION `p2026_06` VALUES LESS THAN ('2026-07-01') ENGINE = InnoDB,
 PARTITION `p2026_07` VALUES LESS THAN ('2026-08-01') ENGINE = InnoDB,
 PARTITION `p2026_08` VALUES LESS THAN ('2026-09-01') ENGINE = InnoDB,
 PARTITION `p2026_09` VALUES LESS THAN ('2026-10-01') ENGINE = InnoDB,
 PARTITION `p2026_10` VALUES LESS THAN ('2026-11-01') ENGINE = InnoDB,
 PARTITION `p2026_11` VALUES LESS THAN ('2026-12-01') ENGINE = InnoDB,
 PARTITION `p2026_12` VALUES LESS THAN ('2027-01-01') ENGINE = InnoDB,
 PARTITION `p_futuro` VALUES LESS THAN (MAXVALUE) ENGINE = InnoDB);

#
# Structure for table "venta_lot"
#

CREATE TABLE `venta_lot` (
  `num_ticket_lot` bigint(11) NOT NULL AUTO_INCREMENT,
  `ticket_lot` bigint(11) NOT NULL,
  `num_apuesta_lot` varchar(3) NOT NULL,
  `mon_apuesta_lot` decimal(10,2) NOT NULL,
  `can_ticket_lot` int(5) NOT NULL,
  `rei_ticket_lot` int(1) NOT NULL,
  `id_loteria` int(11) NOT NULL,
  `id_signo` int(11) NOT NULL,
  `fec_venta_lot` date NOT NULL,
  `hor_venta_lot` time NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `est_ticket_lot` tinyint(1) NOT NULL,
  `tip_loteria_lot` tinyint(1) NOT NULL,
  `ser_ticket_lot` bigint(11) NOT NULL,
  `ip_venta_lot` varchar(16) NOT NULL,
  `fec_pago_lot` date NOT NULL,
  `hor_pago_lot` time NOT NULL,
  `cod_usuario_pago_lot` int(11) NOT NULL,
  `ip_pago_lot` varchar(16) NOT NULL,
  `pag_premio_lot` double(10,2) NOT NULL,
  `est_calculo_lot` int(1) NOT NULL,
  `est_impresion_lot` int(1) NOT NULL,
  `lin_ticket_lot` int(5) NOT NULL,
  PRIMARY KEY (`num_ticket_lot`),
  UNIQUE KEY `num_ticket` (`num_ticket_lot`),
  KEY `ticket` (`ticket_lot`),
  KEY `num_apuesta` (`num_apuesta_lot`),
  KEY `id_loteria` (`id_loteria`),
  KEY `id_signo` (`id_signo`),
  KEY `fec_apuesta` (`fec_venta_lot`),
  KEY `hor_apuesta` (`hor_venta_lot`),
  KEY `id_usuario` (`id_usuario`),
  KEY `est_ticket` (`est_ticket_lot`),
  KEY `tip_loteria` (`tip_loteria_lot`),
  KEY `ser_ticket` (`ser_ticket_lot`),
  KEY `fec_pago` (`fec_pago_lot`),
  KEY `usuario_pago` (`cod_usuario_pago_lot`)
) ENGINE=InnoDB AUTO_INCREMENT=38533 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# Structure for table "venta_macu"
#

CREATE TABLE `venta_macu` (
  `num_ticket_macu` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_macu` int(11) NOT NULL,
  `ser_venta_macu` varchar(11) NOT NULL,
  `num_caballo_macu` varchar(40) NOT NULL,
  `mon_venta_macu` decimal(10,2) NOT NULL,
  `can_ticket_macu` int(5) NOT NULL,
  `rei_ticket_macu` int(1) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fec_venta_macu` date NOT NULL,
  `hor_venta_macu` time NOT NULL,
  `ip_venta_macu` varchar(16) NOT NULL,
  `cod_tventa_macu` int(3) NOT NULL,
  `cod_carrera_hnac` bigint(11) NOT NULL,
  `pag_premio_macu` decimal(10,2) NOT NULL,
  `fec_pago_macu` date NOT NULL,
  `hor_pago_macu` time NOT NULL,
  `cod_usuario_pago_macu` int(11) NOT NULL,
  `ip_pago_macu` varchar(16) NOT NULL,
  `est_ticket_macu` int(1) NOT NULL,
  `est_calculo_macu` int(1) NOT NULL,
  PRIMARY KEY (`num_ticket_macu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

#
# Procedure "sp_mantenimiento_particiones_full"
#

CREATE PROCEDURE `sp_mantenimiento_particiones_full`()
BEGIN
    DECLARE v_mes_siguiente DATE;
    DECLARE v_nombre_p_sig VARCHAR(20);
    DECLARE v_limite_p_sig DATE;
    DECLARE v_sql TEXT;

    SET v_mes_siguiente = DATE_ADD(CURRENT_DATE, INTERVAL 1 MONTH);
    SET v_nombre_p_sig = DATE_FORMAT(v_mes_siguiente, 'p%Y_%m');
    SET v_limite_p_sig = DATE_ADD(DATE_FORMAT(v_mes_siguiente, '%Y-%m-01'), INTERVAL 1 MONTH);

    
    SET @tablas_date = 'venta,venta_hnac,ani5_jugadas';
    SET @sep = ',';
    
    WHILE (LOCATE(@sep, @tablas_date) > 0) DO
        SET @tabla = SUBSTRING(@tablas_date, 1, LOCATE(@sep, @tablas_date) - 1);
        SET @tablas_date = SUBSTRING(@tablas_date, LOCATE(@sep, @tablas_date) + 1);
        IF NOT EXISTS (SELECT 1 FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = 'apuestas' AND TABLE_NAME = @tabla AND PARTITION_NAME = v_nombre_p_sig) THEN
            SET v_sql = CONCAT('ALTER TABLE apuestas.', @tabla, ' REORGANIZE PARTITION p_futuro INTO (PARTITION ', v_nombre_p_sig, ' VALUES LESS THAN (''', v_limite_p_sig, '''), PARTITION p_futuro VALUES LESS THAN (MAXVALUE))');
            PREPARE stmt FROM v_sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
        END IF;
    END WHILE;
    
    IF NOT EXISTS (SELECT 1 FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = 'apuestas' AND TABLE_NAME = @tablas_date AND PARTITION_NAME = v_nombre_p_sig) THEN
        SET v_sql = CONCAT('ALTER TABLE apuestas.', @tablas_date, ' REORGANIZE PARTITION p_futuro INTO (PARTITION ', v_nombre_p_sig, ' VALUES LESS THAN (''', v_limite_p_sig, '''), PARTITION p_futuro VALUES LESS THAN (MAXVALUE))');
        PREPARE stmt FROM v_sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
    END IF;

    
    SET @tablas_todays = 'p3logros,p7histolg,p4jugadas';
    WHILE (LOCATE(@sep, @tablas_todays) > 0) DO
        SET @tabla = SUBSTRING(@tablas_todays, 1, LOCATE(@sep, @tablas_todays) - 1);
        SET @tablas_todays = SUBSTRING(@tablas_todays, LOCATE(@sep, @tablas_todays) + 1);
        IF NOT EXISTS (SELECT 1 FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = 'apuestas' AND TABLE_NAME = @tabla AND PARTITION_NAME = v_nombre_p_sig) THEN
            SET v_sql = CONCAT('ALTER TABLE apuestas.', @tabla, ' REORGANIZE PARTITION p_futuro INTO (PARTITION ', v_nombre_p_sig, ' VALUES LESS THAN (TO_DAYS(''', v_limite_p_sig, ''')), PARTITION p_futuro VALUES LESS THAN (MAXVALUE))');
            PREPARE stmt FROM v_sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
        END IF;
    END WHILE;
    
    IF NOT EXISTS (SELECT 1 FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = 'apuestas' AND TABLE_NAME = @tablas_todays AND PARTITION_NAME = v_nombre_p_sig) THEN
        SET v_sql = CONCAT('ALTER TABLE apuestas.', @tablas_todays, ' REORGANIZE PARTITION p_futuro INTO (PARTITION ', v_nombre_p_sig, ' VALUES LESS THAN (TO_DAYS(''', v_limite_p_sig, ''')), PARTITION p_futuro VALUES LESS THAN (MAXVALUE))');
        PREPARE stmt FROM v_sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
    END IF;
END;

#
# Procedure "sp_mantenimiento_particiones_v2"
#

CREATE PROCEDURE `sp_mantenimiento_particiones_v2`()
BEGIN
    DECLARE v_mes_siguiente DATE;
    DECLARE v_nombre_p_sig VARCHAR(20);
    DECLARE v_limite_p_sig DATE;
    DECLARE v_sql TEXT;

    
    SET v_mes_siguiente = DATE_ADD(CURRENT_DATE, INTERVAL 1 MONTH);
    SET v_nombre_p_sig = DATE_FORMAT(v_mes_siguiente, 'p%Y_%m');
    SET v_limite_p_sig = DATE_ADD(DATE_FORMAT(v_mes_siguiente, '%Y-%m-01'), INTERVAL 1 MONTH);

    
    IF NOT EXISTS (SELECT 1 FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = 'apuestas' AND TABLE_NAME = 'venta' AND PARTITION_NAME = v_nombre_p_sig) THEN
        SET v_sql = CONCAT('ALTER TABLE apuestas.venta REORGANIZE PARTITION p_futuro INTO (PARTITION ', v_nombre_p_sig, ' VALUES LESS THAN (''', v_limite_p_sig, '''), PARTITION p_futuro VALUES LESS THAN (MAXVALUE))');
        PREPARE stmt FROM v_sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
    END IF;

    
    SET @tablas_todays = 'ani5_jugadas,p7histolg';
    SET @sep = ',';

    WHILE (LOCATE(@sep, @tablas_todays) > 0) DO
        SET @tabla = SUBSTRING(@tablas_todays, 1, LOCATE(@sep, @tablas_todays) - 1);
        SET @tablas_todays = SUBSTRING(@tablas_todays, LOCATE(@sep, @tablas_todays) + 1);
        
        IF NOT EXISTS (SELECT 1 FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = 'apuestas' AND TABLE_NAME = @tabla AND PARTITION_NAME = v_nombre_p_sig) THEN
            SET v_sql = CONCAT('ALTER TABLE apuestas.', @tabla, ' REORGANIZE PARTITION p_futuro INTO (PARTITION ', v_nombre_p_sig, ' VALUES LESS THAN (TO_DAYS(''', v_limite_p_sig, ''')), PARTITION p_futuro VALUES LESS THAN (MAXVALUE))');
            PREPARE stmt FROM v_sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
        END IF;
    END WHILE;

    
    IF NOT EXISTS (SELECT 1 FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = 'apuestas' AND TABLE_NAME = @tablas_todays AND PARTITION_NAME = v_nombre_p_sig) THEN
        SET v_sql = CONCAT('ALTER TABLE apuestas.', @tablas_todays, ' REORGANIZE PARTITION p_futuro INTO (PARTITION ', v_nombre_p_sig, ' VALUES LESS THAN (TO_DAYS(''', v_limite_p_sig, ''')), PARTITION p_futuro VALUES LESS THAN (MAXVALUE))');
        PREPARE stmt FROM v_sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
    END IF;

END;

#
# Event "evt_mantenimiento_mensual_2026"
#

CREATE EVENT `evt_mantenimiento_mensual_2026` ON SCHEDULE EVERY 1 MONTH STARTS '2026-03-25 03:00:00' ON COMPLETION PRESERVE ENABLE DO CALL sp_mantenimiento_particiones_full();
