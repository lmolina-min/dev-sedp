-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-03-2023 a las 19:28:30
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_eval_personal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sc_auditoria`
--

CREATE TABLE `sc_auditoria` (
  `id_auditoria` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `id_datos_usuarios` int(11) DEFAULT NULL,
  `accion` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sc_conex_usuarios`
--

CREATE TABLE `sc_conex_usuarios` (
  `id_conex_usuarios` int(11) NOT NULL,
  `id_datos_usuarios` int(11) DEFAULT NULL,
  `hora_login` datetime DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `navegador` varchar(45) DEFAULT NULL,
  `hora_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sc_datos_usuarios`
--

CREATE TABLE `sc_datos_usuarios` (
  `id_datos_usuarios` int(11) NOT NULL,
  `login` varchar(20) DEFAULT NULL,
  `pass` varchar(15) DEFAULT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `estatus` varchar(45) DEFAULT NULL,
  `id_pregunta` int(11) DEFAULT NULL,
  `respuesta` varchar(45) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `id_perfil` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sc_datos_usuarios`
--

INSERT INTO `sc_datos_usuarios` (`id_datos_usuarios`, `login`, `pass`, `correo`, `estatus`, `id_pregunta`, `respuesta`, `id_empleado`, `id_perfil`) VALUES
(1, 'ncarpio', '123456', 'ncarpio@minerven.com.ve', '1', 1, 'comer', 2, 2),
(2, 'jsalazar', '123456', 'jsalazar@minerven.com.ve', '1', 1, 'pescar', 1, 3),
(3, 'pchaudari', '123456', 'pchaudari@minerven.com.ve', '1', 1, 'beber', 3, 3),
(4, 'varay', '123456', 'varay@minerven.com.ve', '1', 1, 'beber', 7, 4),
(5, 'lmolina', '123456', 'lmolina@minerven.com.ve', '1', 1, 'beber', 5, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sc_menu`
--

CREATE TABLE `sc_menu` (
  `id_menu` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `icon` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sc_menu`
--

INSERT INTO `sc_menu` (`id_menu`, `descripcion`, `icon`) VALUES
(1, 'Inicio', 'user-plus'),
(2, 'Módulo de Evaluación', 'user-plus');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sc_modulos`
--

CREATE TABLE `sc_modulos` (
  `id_modulos` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `url_modulo` varchar(45) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `ver_menu` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sc_modulos`
--

INSERT INTO `sc_modulos` (`id_modulos`, `descripcion`, `nombre`, `url_modulo`, `id_menu`, `ver_menu`) VALUES
(1, 'Inicio', 'inicio', 'principal.php', 1, '1'),
(2, 'Formato de Evaluación', 'Formato de Evaluación', 'formato_evaluacion.php', 2, '1'),
(3, 'Aprobar Evaluación', 'Evaluaciones', 'aprueba_evaluacion.php', 2, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sc_perfiles`
--

CREATE TABLE `sc_perfiles` (
  `id_perfil` int(11) NOT NULL,
  `tipo_perfil` varchar(45) DEFAULT NULL,
  `id_ubi_fisica` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sc_perfiles`
--

INSERT INTO `sc_perfiles` (`id_perfil`, `tipo_perfil`, `id_ubi_fisica`) VALUES
(1, 'root', '1'),
(2, 'user', '1'),
(3, 'Coordinador', '1'),
(4, 'Jefe de Division', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sc_permisos`
--

CREATE TABLE `sc_permisos` (
  `id_permisos` int(11) NOT NULL,
  `id_modulos` int(11) DEFAULT NULL,
  `id_perfil` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sc_permisos`
--

INSERT INTO `sc_permisos` (`id_permisos`, `id_modulos`, `id_perfil`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 1, 2),
(4, 2, 3),
(5, 1, 3),
(6, 1, 4),
(7, 2, 4),
(8, 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sc_preguntas`
--

CREATE TABLE `sc_preguntas` (
  `id_preguntas` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sc_preguntas`
--

INSERT INTO `sc_preguntas` (`id_preguntas`, `descripcion`) VALUES
(0, 'Pasa tiempo favorito?'),
(1, 'Pasa tiempo favorito?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sc_usuarios_online`
--

CREATE TABLE `sc_usuarios_online` (
  `id_user_online` int(11) NOT NULL,
  `id_conex_usuarios` int(11) DEFAULT NULL,
  `tiempo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_cargo`
--

CREATE TABLE `se_cargo` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `se_cargo`
--

INSERT INTO `se_cargo` (`id`, `descripcion`) VALUES
(1, 'COORDINADOR DE SISTEMAS'),
(2, 'ANALISTA I'),
(3, 'ANALISTA II'),
(4, 'ANALISTA III'),
(5, 'COORDINADOR DE SOPORTE TÉCNICO'),
(6, 'INSTRUMENTISTA'),
(7, 'JEFE DE DIVISION '),
(8, 'GERENTE DE TELEMATICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_ccosto`
--

CREATE TABLE `se_ccosto` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_empleado`
--

CREATE TABLE `se_empleado` (
  `id` int(11) NOT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `id_ccosto` int(11) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `id_nomina` int(11) DEFAULT NULL,
  `se_grado_inst_id` int(11) NOT NULL,
  `evaluado_por` int(11) NOT NULL,
  `Estatus_emp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `se_empleado`
--

INSERT INTO `se_empleado` (`id`, `cedula`, `nombre`, `apellido`, `id_cargo`, `id_ccosto`, `fecha_ingreso`, `id_nomina`, `se_grado_inst_id`, `evaluado_por`, `Estatus_emp`) VALUES
(1, 15372919, 'JOSE', 'SALAZAR', 1, 511, '2022-02-01', 2, 1, 8461810, 1),
(2, 18246852, 'NARYOLIS', 'CARPIO', 4, 511, '2010-10-01', 2, 1, 15372919, 1),
(3, 5914885, 'PEDRO', 'CHAUDARI', 5, 512, '2022-02-01', 2, 1, 8461810, 1),
(4, 12121212, 'JESUS', 'PEREZ', 4, 511, '2023-03-01', 1, 2, 15372919, 1),
(5, 13131313, 'LUIS', 'MOLINA', 3, 511, '2023-03-01', 2, 1, 15372919, 1),
(6, 14141414, 'JUAN', 'GARCIA', 6, 511, '2023-03-01', 1, 2, 15372919, 1),
(7, 8461810, 'VICTOR', 'ARAY', 7, 510, '2021-03-01', 3, 1, 11111111, 1),
(8, 11111111, 'JORGE', 'RAMIREZ', 8, 500, '2021-03-02', 3, 1, 2222222, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_evaluacion`
--

CREATE TABLE `se_evaluacion` (
  `id_eval` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `puntaje` int(11) DEFAULT NULL,
  `estatus` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `se_evaluacion`
--

INSERT INTO `se_evaluacion` (`id_eval`, `fecha`, `puntaje`, `estatus`, `id_empleado`) VALUES
(34, '2023-03-14 00:00:00', 16, 1, 5),
(35, '2023-03-14 00:00:00', 13, 1, 1),
(36, '2023-03-14 00:00:00', 12, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_eval_item_factor`
--

CREATE TABLE `se_eval_item_factor` (
  `id_eval_emp` int(11) NOT NULL,
  `id_item_factor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `se_eval_item_factor`
--

INSERT INTO `se_eval_item_factor` (`id_eval_emp`, `id_item_factor`) VALUES
(34, 23),
(34, 26),
(34, 32),
(34, 34),
(34, 38),
(35, 21),
(35, 26),
(35, 29),
(35, 34),
(35, 40),
(36, 21),
(36, 27),
(36, 32),
(36, 35),
(36, 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_factores_eval`
--

CREATE TABLE `se_factores_eval` (
  `id_factor` int(11) NOT NULL,
  `titulo` varchar(500) DEFAULT NULL,
  `subtitulo` varchar(500) NOT NULL,
  `nivel` varchar(100) NOT NULL,
  `id_tipo_nomina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `se_factores_eval`
--

INSERT INTO `se_factores_eval` (`id_factor`, `titulo`, `subtitulo`, `nivel`, `id_tipo_nomina`) VALUES
(3, 'CALIDAD DE TRABAJO', 'Realización del trabajo de forma exacta y precisa', 'PERSONAL OBRERO', 1),
(4, 'CUMPLIMIENTO DE NORMAS', 'Interés y disposición para el cumplimiento de todas las normativas y lineamientos establecidos por la empresa.', 'PERSONAL OBRERO', 1),
(5, 'LEALTAD INSTITUCIONAL Y COOPERACION', 'Honestidad y compromiso con la empresa, sentido de pertenencia', 'PERSONAL OBRERO', 1),
(6, 'INICIATIVA', 'Disposición para afrontar y resolver situaciones difíciles que se le presenten', 'PERSONAL OBRERO', 1),
(7, 'TRABAJO EN EQUIPO', 'Capacidad para relacionarse con el resto de los trabajadores de manera respetuosa, armoniosa y positiva a la hora de programar y ejecutar el trabajo.', 'PERSONAL OBRERO', 1),
(8, 'CALIDAD DE TRABAJO', 'Realización del trabajo de forma exacta y precisa.', 'PERSONAL EMPLEADO', 2),
(9, 'LEALTAD INSTITUCIONAL Y COOPERACION', 'Honestidad y compromiso con la empresa, sentido de pertenencia', 'PERSONAL EMPLEADO', 2),
(10, 'INICIATIVA', 'Disposición para afrontar y resolver situaciones difíciles que se le presenten.', 'PERSONAL EMPLEADO', 2),
(11, 'CAPACIDAD DE ANALISIS', 'Identificación, evaluación y selección de información importante para la resolución de un problema o para el logro de los objetivos.', 'PERSONAL EMPLEADO', 2),
(12, 'TRABAJO EN EQUIPO', 'Capacidad para relacionarse con el resto de los trabajadores de manera respetuosa, armoniosa y positiva a la hora de programar y ejecutar el trabajo.', 'PERSONAL EMPLEADO', 2),
(13, 'RESPONSABILIDAD PARA ASUMIR COMPROMISOS', 'Seguridad personal en las capacidades propias para asumir compromisos, tomar acciones y resolver problemas.', 'PERSONAL DE ALTO NIVEL Y DIRECCION', 3),
(14, 'PLANIFICACIÓN DEL TRABAJO', 'Organización de los recursos técnicos y materiales en una secuencia apropiada pala el logro de los objetivos.', 'PERSONAL DE ALTO NIVEL Y DIRECCION', 3),
(15, 'TOMA DE DECISIONES', 'Facultad para decidir la solución adecuada, entre varias alternativas posibles.', 'PERSONAL DE ALTO NIVEL Y DIRECCION', 3),
(16, 'INICIATIVA', 'Disposición para afrontar y resolver situaciones difíciles que se le presenten.', 'PERSONAL DE ALTO NIVEL Y DIRECCION', 3),
(17, 'CAPACIDAD DE ANALISIS', 'Identificación, evaluación y selección de información importante para la resolución de un problema o para el logro de los objetivos.', 'PERSONAL DE ALTO NIVEL Y DIRECCIÓN', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_grado_inst`
--

CREATE TABLE `se_grado_inst` (
  `id` int(11) NOT NULL,
  `descriocion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `se_grado_inst`
--

INSERT INTO `se_grado_inst` (`id`, `descriocion`) VALUES
(1, 'PROFESIONAL'),
(2, 'BACHILLER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_item_factor`
--

CREATE TABLE `se_item_factor` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(2500) DEFAULT NULL,
  `valor` int(11) DEFAULT NULL,
  `id_factor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `se_item_factor`
--

INSERT INTO `se_item_factor` (`id`, `descripcion`, `valor`, `id_factor`) VALUES
(1, 'Realiza las tareas asignadas con exactitud y precisión. No requiere supervisión y seguimiento.', 4, 3),
(2, 'Comete errores tolerables. Es necesario revisión y supervisión.', 2, 3),
(3, 'Investiga y consulta para evitar errores. Se aplica con precisión. Requiere poco seguimiento.', 3, 3),
(4, 'No alcanza los requerimientos mínimos en la ejecución de las tareas asignadas.', 1, 3),
(5, 'Presta poca atención al cumplimiento de las normas y lineamientos.', 2, 4),
(6, 'Normalmente es disciplinado con el cumplimiento de las normas.', 3, 4),
(7, 'Tiene como regla personal el respeto estricto a las normativas, trata de motivar a los demás al cumplimiento de las mismas.', 4, 4),
(8, 'Es indisciplinado. No tiene interés en cumplir ningún tipo de normas. ', 1, 4),
(9, 'No se adapta con facilidad. No colabora, ni trata de ayudar.', 1, 5),
(10, 'Es entusiasta, colaborador. Se puede confiar en él. Se identifica totalmente con la empresa.', 4, 5),
(11, 'Demuestra poco entusiasmo, interés y es poco colaborador.', 2, 5),
(12, 'Es sincero, objetivo; dispuesto siempre a cooperar.', 3, 5),
(13, 'Tiene iniciativa en la ejecución de sus tareas. A veces sugiere mejoras.', 2, 6),
(14, 'Actúa con iniciativa en situaciones cotidianas. Necesita ayuda y dirección ante nuevas situaciones.', 3, 6),
(15, 'Responde a instrucciones y órdenes precisas.', 1, 6),
(16, 'Evalúa, hace seguimiento y corrige por su propia iniciativa sus acciones sobre la marcha.', 4, 6),
(17, 'Alcanza de manera deficiente y con poca armonía con el equipo de trabajo el logro de objetivos.', 2, 7),
(18, 'Logra encajar en el grupo o equipo de trabajo la mayoría de las veces, alcanzando el objetivo planteado. Es sereno.', 3, 7),
(19, 'Demuestra alta facultad para escuchar, comprender y transmitir el objetivo a lograr por el equipo. Autocontrol a sus emociones en momentos de tensión.', 4, 7),
(20, 'No demuestra interés en trabajar con otros compañeros de trabajo.', 1, 7),
(21, 'Realiza las tareas asignadas con exactitud y precisión. No requiere supervisión y seguimiento.', 4, 8),
(22, 'Comete errores tolerables. Es necesario revisión y supervisión.', 2, 8),
(23, 'Investiga y consulta para evitar errores. Se aplica con precisión. Requiere poco seguimiento.', 3, 8),
(24, 'No alcanza los requerimientos mínimos en la ejecución de las tareas asignadas.', 1, 8),
(25, 'No se adapta con facilidad. No colabora, ni trata de ayudar.', 1, 9),
(26, 'Es entusiasta, colaborador. Se puede confiar en él. Se identifica totalmente con la empresa.', 4, 9),
(27, 'Demuestra poco entusiasmo, interés y es poco colaborador.', 2, 9),
(28, 'Es sincero, objetivo; dispuesto siempre a cooperar.', 3, 9),
(29, 'Tiene iniciativa en la ejecución de sus tareas. A veces sugiere mejoras.', 2, 10),
(30, 'Actúa con iniciativa en situaciones cotidianas. Necesita ayuda y dirección ante nuevas situaciones.', 3, 10),
(31, 'Responde a instrucciones y órdenes precisas.', 1, 10),
(32, 'Evalúa, hace seguimiento y corrige por su propia iniciativa sus acciones sobre la marcha.', 4, 10),
(33, 'Analiza los aspectos de cualquier problema; valora las incidencias del mismo con gran capacidad. Posee mentalidad analítica.', 4, 11),
(34, 'Revisa de vez en cuando los hechos para cerciorarse de las causas del problema; observando solo las opciones evidentes de solución.', 2, 11),
(35, 'Le resulta difícil valorar los hechos y sacar conclusiones básicas. Es lento en su razonamiento.', 1, 11),
(36, 'Resuelve problemas comunes en su trabajo normal, determina sus elementos para aportar soluciones.', 3, 11),
(37, 'Alcanza de manera deficiente y con poca armonía con el equipo de trabajo el logro de objetivos.', 2, 12),
(38, 'Logra encajar en el grupo o equipo de trabajo la mayoría de las veces, alcanzando el objetivo planteado. Es sereno.', 3, 12),
(39, 'Demuestra alta facultad para escuchar, comprender y transmitir el objetivo a lograr por el equipo. Autocontrola sus emociones en momentos de tensión.', 4, 12),
(40, 'No demuestra interés en trabajar con otros compañeros de trabajo.', 1, 12),
(41, 'Siempre asume con responsabilidad, fortaleza y seguridad retos y compromisos. Siempre se responsabiliza de sus acciones sean o no positivas.', 4, 13),
(42, 'A veces asume compromisos y se maneja dentro de las acciones cotidianas y q generan un riesgo bajo.', 2, 13),
(43, 'Acepta compromisos y retos de éxito seguro. Hace énfasis en lo que conoce para decidir aceptar el reto.', 3, 13),
(44, 'No asume ningún tipo de responsabilidad ni compromiso que se mantiene en su zona de confort.', 1, 13),
(45, 'Identifica y reconoce prioridades evidentes; obteniendo resultados en algunas de las metas.', 2, 14),
(46, 'Establece metas, reconoce y organiza el trabajo obteniendo los resultados esperados.', 3, 14),
(47, 'Efectividad en la organización de las metas. Establece prioridades, lo que le permite complementar las actividades en un porcentaje mayor al esperado.', 4, 14),
(48, 'Fija metas de manera desorganizada; lo que dificulta el logro de los objetivos establecidos.', 1, 14),
(49, 'Evade completamente las situaciones difíciles y q requieren soluciones oportunas.', 1, 15),
(50, 'Presenta a tiempo soluciones y actúa con rapidez ante situaciones surgidas en su trabajo.', 4, 15),
(51, 'Posee poca capacidad para decidir y solventar situaciones complejas.', 2, 15),
(52, 'Ofrece soluciones aceptables ante problemas surgidos y actúa, aunque con poca rapidez.', 3, 15),
(53, 'Tiene iniciativa en la ejecución de sus tareas. A veces sugiere mejoras.', 2, 16),
(54, 'Actúa con iniciativa en situaciones cotidianas. Necesita ayuda y dirección ante nuevas situaciones.', 3, 16),
(55, 'Responde a instrucciones y órdenes precisas.', 1, 16),
(56, 'Evalúa, hace seguimiento y corrige por su propia iniciativa sus acciones sobre la marcha.', 4, 16),
(57, 'Analiza los aspectos de cualquier problema; valora las incidencias del mismo con gran capacidad. Posee mentalidad analítica.', 4, 17),
(58, 'Revisa de vez en cuando los hechos para cerciorarse de las causas del problema; observando solo las opciones evidentes de solución.', 2, 17),
(59, 'Le resulta difícil valorar los hechos y sacar conclusiones básicas. Es lento en su razonamiento.', 1, 17),
(60, 'Resuelve problemas comunes en su trabajo normal, determina sus elementos para aportar soluciones.', 3, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_tipo_nomina`
--

CREATE TABLE `se_tipo_nomina` (
  `id_tn` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `se_tipo_nomina`
--

INSERT INTO `se_tipo_nomina` (`id_tn`, `descripcion`) VALUES
(1, 'OBRERO'),
(2, 'EMPLEADO'),
(3, 'ALTO NIVEL Y DIRECCIÓN');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sc_auditoria`
--
ALTER TABLE `sc_auditoria`
  ADD PRIMARY KEY (`id_auditoria`),
  ADD KEY `id_datos_usuarios_au_idx` (`id_datos_usuarios`);

--
-- Indices de la tabla `sc_conex_usuarios`
--
ALTER TABLE `sc_conex_usuarios`
  ADD PRIMARY KEY (`id_conex_usuarios`),
  ADD KEY `id_datos_usuarios_cu_idx` (`id_datos_usuarios`);

--
-- Indices de la tabla `sc_datos_usuarios`
--
ALTER TABLE `sc_datos_usuarios`
  ADD PRIMARY KEY (`id_datos_usuarios`),
  ADD KEY `id_pregu_du_idx` (`id_pregunta`),
  ADD KEY `usuario_empleado` (`id_empleado`),
  ADD KEY `usuario_perfil` (`id_perfil`);

--
-- Indices de la tabla `sc_menu`
--
ALTER TABLE `sc_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `sc_modulos`
--
ALTER TABLE `sc_modulos`
  ADD PRIMARY KEY (`id_modulos`),
  ADD KEY `id_menu_md_idx` (`id_menu`);

--
-- Indices de la tabla `sc_perfiles`
--
ALTER TABLE `sc_perfiles`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `sc_permisos`
--
ALTER TABLE `sc_permisos`
  ADD PRIMARY KEY (`id_permisos`),
  ADD KEY `id_modulos_md_idx` (`id_modulos`),
  ADD KEY `id_perfil_pf_idx` (`id_perfil`);

--
-- Indices de la tabla `sc_preguntas`
--
ALTER TABLE `sc_preguntas`
  ADD PRIMARY KEY (`id_preguntas`);

--
-- Indices de la tabla `sc_usuarios_online`
--
ALTER TABLE `sc_usuarios_online`
  ADD PRIMARY KEY (`id_user_online`),
  ADD KEY `id_usuarios_online_idx` (`id_conex_usuarios`);

--
-- Indices de la tabla `se_cargo`
--
ALTER TABLE `se_cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `se_ccosto`
--
ALTER TABLE `se_ccosto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `se_empleado`
--
ALTER TABLE `se_empleado`
  ADD PRIMARY KEY (`id`,`se_grado_inst_id`),
  ADD KEY `fk_se_empleado_se_cargo_idx` (`id_cargo`),
  ADD KEY `fk_se_empleado_se_ccosto_idx` (`id_ccosto`),
  ADD KEY `fk_se_empleado_se_grado_inst1_idx` (`se_grado_inst_id`),
  ADD KEY `tipo_nominaemp` (`id_nomina`);

--
-- Indices de la tabla `se_evaluacion`
--
ALTER TABLE `se_evaluacion`
  ADD PRIMARY KEY (`id_eval`);

--
-- Indices de la tabla `se_eval_item_factor`
--
ALTER TABLE `se_eval_item_factor`
  ADD KEY `fk_se_eval_item_factor_sc_evaluacion1_idx` (`id_eval_emp`),
  ADD KEY `fk_se_eval_item_factor_sc_item_factor1_idx` (`id_item_factor`);

--
-- Indices de la tabla `se_factores_eval`
--
ALTER TABLE `se_factores_eval`
  ADD PRIMARY KEY (`id_factor`),
  ADD KEY `tipo_nomina` (`id_tipo_nomina`);

--
-- Indices de la tabla `se_grado_inst`
--
ALTER TABLE `se_grado_inst`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `se_item_factor`
--
ALTER TABLE `se_item_factor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sc_item_factor_sc_factores_eval1_idx` (`id_factor`);

--
-- Indices de la tabla `se_tipo_nomina`
--
ALTER TABLE `se_tipo_nomina`
  ADD PRIMARY KEY (`id_tn`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `se_cargo`
--
ALTER TABLE `se_cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `se_ccosto`
--
ALTER TABLE `se_ccosto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `se_empleado`
--
ALTER TABLE `se_empleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `se_evaluacion`
--
ALTER TABLE `se_evaluacion`
  MODIFY `id_eval` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `se_factores_eval`
--
ALTER TABLE `se_factores_eval`
  MODIFY `id_factor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `se_grado_inst`
--
ALTER TABLE `se_grado_inst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `se_item_factor`
--
ALTER TABLE `se_item_factor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `se_tipo_nomina`
--
ALTER TABLE `se_tipo_nomina`
  MODIFY `id_tn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `sc_auditoria`
--
ALTER TABLE `sc_auditoria`
  ADD CONSTRAINT `id_datos_usuarios_au` FOREIGN KEY (`id_datos_usuarios`) REFERENCES `sc_datos_usuarios` (`id_datos_usuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sc_conex_usuarios`
--
ALTER TABLE `sc_conex_usuarios`
  ADD CONSTRAINT `id_datos_usuarios_cu` FOREIGN KEY (`id_datos_usuarios`) REFERENCES `sc_datos_usuarios` (`id_datos_usuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sc_datos_usuarios`
--
ALTER TABLE `sc_datos_usuarios`
  ADD CONSTRAINT `usuario_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `se_empleado` (`id`),
  ADD CONSTRAINT `usuario_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `sc_perfiles` (`id_perfil`);

--
-- Filtros para la tabla `sc_modulos`
--
ALTER TABLE `sc_modulos`
  ADD CONSTRAINT `id_menu_md` FOREIGN KEY (`id_menu`) REFERENCES `sc_menu` (`id_menu`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sc_permisos`
--
ALTER TABLE `sc_permisos`
  ADD CONSTRAINT `id_modulos_md` FOREIGN KEY (`id_modulos`) REFERENCES `sc_modulos` (`id_modulos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_perfil_pf` FOREIGN KEY (`id_perfil`) REFERENCES `sc_perfiles` (`id_perfil`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sc_usuarios_online`
--
ALTER TABLE `sc_usuarios_online`
  ADD CONSTRAINT `id_usuarios_online` FOREIGN KEY (`id_conex_usuarios`) REFERENCES `sc_conex_usuarios` (`id_conex_usuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `se_empleado`
--
ALTER TABLE `se_empleado`
  ADD CONSTRAINT `fk_se_empleado_se_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `se_cargo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_se_empleado_se_ccosto` FOREIGN KEY (`id_ccosto`) REFERENCES `test`.`nivel_org` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_se_empleado_se_grado_inst1` FOREIGN KEY (`se_grado_inst_id`) REFERENCES `se_grado_inst` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tipo_nominaemp` FOREIGN KEY (`id_nomina`) REFERENCES `se_tipo_nomina` (`id_tn`);

--
-- Filtros para la tabla `se_eval_item_factor`
--
ALTER TABLE `se_eval_item_factor`
  ADD CONSTRAINT `fk_eval_empleado` FOREIGN KEY (`id_eval_emp`) REFERENCES `se_evaluacion` (`id_eval`),
  ADD CONSTRAINT `fk_se_eval_item_factor_sc_item_factor1` FOREIGN KEY (`id_item_factor`) REFERENCES `se_item_factor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `se_factores_eval`
--
ALTER TABLE `se_factores_eval`
  ADD CONSTRAINT `tipo_nomina` FOREIGN KEY (`id_tipo_nomina`) REFERENCES `se_tipo_nomina` (`id_tn`);

--
-- Filtros para la tabla `se_item_factor`
--
ALTER TABLE `se_item_factor`
  ADD CONSTRAINT `fk_sc_item_factor_sc_factores_eval1` FOREIGN KEY (`id_factor`) REFERENCES `se_factores_eval` (`id_factor`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
