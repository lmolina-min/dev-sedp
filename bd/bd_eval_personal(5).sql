-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-05-2023 a las 20:53:04
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
(1, 'ncarpio', '123456', 'ncarpio@minerven.com.ve', '1', 1, 'comer', 2, 100),
(2, 'jsalazar', '123456', 'jsalazar@minerven.com.ve', '1', 1, 'pescar', 1, 5),
(3, 'pchaudari', '123456', 'pchaudari@minerven.com.ve', '1', 1, 'beber', 3, 5),
(4, 'varay', '123456', 'varay@minerven.com.ve', '1', 1, 'beber', 7, 3),
(5, 'lmolina', '123456', 'lmolina@minerven.com.ve', '1', 1, 'beber', 5, 100),
(6, 'jramirez', '123456', 'jramirez@minerven.com.ve', '1', 1, 'beber', 8, 2),
(7, 'slopez', '123456', 'slopez@minerven.com.ve', '1', 1, 'beber', 18, 3),
(8, 'pfernandez', '123456', 'pfernandez@minerven.com.ve', '1', 1, 'beber', 20, 3),
(9, 'fpino', '123456', 'fpino@minerven.com.ve', '1', 1, 'beber', 27, 6),
(10, 'tmercado', '123456', 'tmercado@minerven.com.ve', '1', 1, 'beber', 28, 2),
(11, 'emata', '123456', 'emata@minerven.com.ve', '1', 1, 'beber', 35, 3),
(12, 'rgil', '123456', 'rgil@minerven.com.ve', '1', 1, 'beber', 38, 4),
(13, 'jgonzalez', '123456', 'jgonzalez@minerven.com.ve', '1', 1, 'beber', 37, 5),
(14, 'blopez', '123456', 'blopez@min', '1', 1, 'beber', 45, 5),
(15, 'vbrito', '123456', 'vbrito@min', '1', 1, 'beber', 44, 4),
(16, 'mperez', '123456', 'mperez@min', '1', 1, 'beber', 43, 3),
(17, 'ggeneral', '123456', 'ggeneral@min', '1', 1, 'beber', 47, 100),
(18, 'gruiz', '123456', 'gruiz@min', '1', 1, 'beber', 55, 7),
(19, 'llozada', '123456', 'llozada@min', '1', 1, 'beber', 13, 5),
(20, 'wreina', '123456', 'wreina@min', '1', 1, 'beber', 19, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sc_menu`
--

CREATE TABLE `sc_menu` (
  `id_menu` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `icon` varchar(45) DEFAULT NULL,
  `url_menu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sc_menu`
--

INSERT INTO `sc_menu` (`id_menu`, `descripcion`, `icon`, `url_menu`) VALUES
(1, 'Inicio', 'home', 'principal.php'),
(2, 'Evaluaciones', 'list-check', '#'),
(3, 'Reportes', 'file', '#');

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
(1, 'Inicio', 'inicio', 'principal.php', 1, '0'),
(2, 'Formato', 'Formato', 'formato_evaluacion.php', 2, '1'),
(3, 'Aprobar', 'Aprobar', 'aprueba_evaluacion.php', 2, '1'),
(4, 'Reportes', 'Reportes', 'reportes.php', 3, '1');

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
(1, 'ADMIN', '1'),
(2, 'GERENTE', '1'),
(3, 'JEFE DE DIVISION', '1'),
(4, 'JEFE DEPARTAMENTO', '1'),
(5, 'COORDINADOR', '1'),
(6, 'GERENTE GENERAL DE OPERACIONES', '1'),
(7, 'GTU', '1'),
(100, 'GERENTE GENERAL', '1');

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
(4, 2, 5),
(5, 1, 5),
(6, 1, 3),
(7, 2, 3),
(9, 2, 2),
(11, 1, 6),
(12, 2, 6),
(13, 1, 4),
(14, 2, 4),
(16, 1, 100),
(17, 2, 100),
(18, 1, 7),
(19, 2, 7),
(20, 4, 7),
(21, 4, 2);

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
(8, 'GERENTE DE TELEMATICA'),
(9, 'COORDINADOR DE DESARROLLO'),
(10, 'COORDINADOR DE SEGURIDAD TECNOLOGICA'),
(11, 'COORDINADOR DE TELECOMUNICACIONES'),
(12, 'COORDINADOR DE REDES Y TELEFONÍA'),
(13, 'GERENTE GENERAL DE OPERACIONES'),
(14, 'GERENTE OPERACIONES MINA COLOMBIA'),
(15, 'GERENTE DE EXPLOSIVOS'),
(16, 'GERENTE DE ASEGURAMIENTO DE LA CALIDAD'),
(17, 'GERENTE DE PLANIFICACION, CONTROL Y SEGUIMIENTO DE OPERACIONES'),
(18, 'GERENTE DE ENERGIA ELECTRICA'),
(19, 'GERENTE DE OPERACIONES MINA SOSA MENDEZ-UNION'),
(20, 'ASISTENTE ADMINISTRATIVO'),
(21, 'COORDINADOR'),
(22, 'JEFE DE DEPARTAMENTO'),
(23, 'GERENTE GENERAL');

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
  `Estatus_emp` int(11) NOT NULL,
  `es_evaluador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `se_empleado`
--

INSERT INTO `se_empleado` (`id`, `cedula`, `nombre`, `apellido`, `id_cargo`, `id_ccosto`, `fecha_ingreso`, `id_nomina`, `se_grado_inst_id`, `evaluado_por`, `Estatus_emp`, `es_evaluador`) VALUES
(1, 15372919, 'JOSE', 'SALAZAR', 1, 511, '2022-02-01', 2, 1, 8461810, 1, 1),
(2, 18246852, 'NARYOLIS', 'CARPIO', 4, 511, '2010-10-01', 2, 1, 15372919, 1, 0),
(3, 5914885, 'PEDRO', 'CHAUDARI', 5, 512, '2022-02-01', 2, 1, 8461810, 1, 1),
(4, 12121212, 'JESUS', 'PEREZ', 4, 511, '2023-03-01', 1, 2, 15372919, 1, 0),
(5, 13131313, 'LUIS', 'MOLINA', 3, 511, '2023-03-01', 2, 1, 15372919, 1, 0),
(6, 14141414, 'JUAN', 'GARCIA', 6, 511, '2023-03-01', 1, 2, 15372919, 1, 0),
(7, 8461810, 'VICTOR', 'ARAY', 7, 510, '2021-03-01', 3, 1, 11111111, 1, 1),
(8, 11111111, 'JORGE', 'RAMIREZ', 8, 500, '2021-03-02', 3, 1, 2222222, 1, 1),
(9, 14141414, 'SEBASTIAN', 'MO', 2, 511, '2020-03-04', 2, 1, 15372919, 1, 0),
(10, 15151515, 'ALAIN', 'GIL', 3, 511, '2013-01-09', 2, 1, 15372919, 1, 0),
(11, 16161616, 'ALAN ', 'CASTELLANO', 6, 511, '2023-03-01', 1, 2, 15372919, 1, 0),
(12, 17171717, 'ADRIAN', 'GONZALEZ', 6, 511, '2023-03-02', 1, 2, 15372919, 1, 0),
(13, 18658542, 'LUIS', 'LOZADA', 12, 513, '2021-03-03', 2, 2, 8461810, 1, 1),
(14, 20212021, 'ENRIQUE', 'MORA', 3, 512, '2023-03-08', 2, 1, 5914885, 1, 0),
(15, 23202120, 'MANUEL', 'LOPEZ', 6, 512, '2017-03-15', 1, 2, 5914885, 1, 0),
(16, 25232120, 'MARIA', 'SANCHEZ', 6, 512, '2018-03-14', 1, 2, 5914885, 1, 0),
(17, 26253251, 'JULIA', 'LUNA', 3, 512, '2023-03-20', 2, 1, 5914885, 1, 0),
(18, 3434343, 'SAUL', 'LOPEZ', 7, 520, '2013-03-12', 2, 1, 11111111, 1, 1),
(19, 45454545, 'WILMER', 'REINA', 7, 540, '2013-03-13', 2, 1, 11111111, 1, 1),
(20, 6767675, 'PEDRO', 'FERNANDEZ', 7, 530, '2014-03-18', 2, 1, 11111111, 1, 1),
(21, 9896589, 'ESTEBAN', 'GARCIA', 2, 540, '2023-03-01', 2, 1, 45454545, 1, 0),
(22, 4543234, 'JEREMIAS', 'CARUZO', 3, 521, '2023-03-06', 2, 1, 3652365, 1, 0),
(23, 3652365, 'HECTOR', 'ORTEGA', 9, 521, '2023-03-01', 2, 1, 3434343, 1, 1),
(24, 85425124, 'ADRIAN', 'MORA', 10, 522, '2023-03-01', 2, 1, 3434343, 1, 1),
(25, 5845574, 'MANUEL', 'SEIJAS', 11, 531, '2023-03-01', 2, 1, 6767675, 1, 1),
(26, 3455224, 'MARIA', 'COVA', 12, 532, '2023-03-01', 2, 1, 6767675, 1, 1),
(27, 3333333, 'FRANKLIN', 'PINO', 13, 2000, '2023-03-01', 3, 1, 2222222, 1, 1),
(28, 5232514, 'TOMAS ', 'MERCADO', 14, 2100, '2023-03-01', 3, 1, 3333333, 1, 1),
(29, 8569584, 'RAMON', 'OLIVARES', 15, 2200, '2023-03-01', 3, 1, 3333333, 1, 1),
(30, 3435532, 'DANIEL', 'LARA', 16, 2300, '2023-03-01', 3, 1, 3333333, 1, 1),
(31, 4433356, 'MATHIAS', 'SALAS', 17, 2400, '2023-03-01', 3, 1, 3333333, 1, 1),
(32, 3265851, 'CARLOS', 'FERNANDEZ', 18, 2500, '2023-03-01', 3, 1, 3333333, 1, 1),
(33, 4325633, 'LUISA', 'COLMENARES', 19, 2600, '2023-03-01', 3, 1, 3333333, 1, 1),
(34, 6674446, 'JUANA ', 'COLMENARES', 20, 2101, '2023-03-01', 2, 1, 5232514, 1, 0),
(35, 886557, 'ELIS', 'MATA', 7, 2110, '2023-03-01', 2, 1, 5232514, 1, 1),
(36, 6633356, 'DAVID', 'FERRER', 4, 2110, '2023-03-07', 2, 1, 886557, 1, 0),
(37, 3324563, 'JESUS', 'GONZALEZ', 21, 2111, '2023-03-01', 2, 1, 886557, 1, 1),
(38, 46734346, 'RONALD', 'GIL', 22, 2112, '2023-03-01', 2, 1, 886557, 1, 1),
(39, 899755, 'JOSE', 'MARTINEZ', 4, 2112, '2023-03-01', 2, 1, 46734346, 1, 0),
(40, 5674434, 'JOSEFINA', 'CAMACHO', 20, 2001, '2023-03-01', 2, 1, 3333333, 1, 0),
(41, 5466366, 'MERLIS', 'SACARIAS', 22, 2113, '2023-03-01', 2, 1, 886557, 1, 1),
(42, 56564343, 'MONICA', 'GONZALEZ', 4, 2111, '2023-03-01', 2, 1, 3324563, 1, 0),
(43, 4567335, 'MIGUEL', 'PEREZ', 7, 2120, '2023-03-01', 2, 1, 5232514, 1, 1),
(44, 9970743, 'VICTOR', 'BRITO', 22, 2121, '2023-03-01', 2, 1, 4567335, 1, 1),
(45, 667443, 'BENNY', 'LOPEZ', 21, 2122, '2023-03-01', 2, 1, 9970743, 1, 1),
(46, 5455646, 'LUISA', 'GARCIA', 4, 2122, '2023-03-01', 2, 1, 667443, 1, 0),
(47, 2222222, 'GERENTE', 'GENERAL', 23, 100, '2023-03-01', 3, 1, 0, 1, 1),
(48, 97679664, 'NOEL', 'SIERRA', 7, 2130, '2023-04-10', 2, 1, 5232514, 1, 1),
(49, 85444732, 'MOISES', 'SANTAELLA', 7, 2140, '2023-04-03', 2, 1, 5232514, 1, 1),
(50, 76685454, 'MANUEL', 'FIERRO', 7, 2150, '2023-04-03', 2, 1, 5232514, 1, 1),
(51, 5547346, 'OSCAR', 'QUINTANA', 7, 2160, '2023-04-03', 2, 1, 5232514, 1, 1),
(52, 65465477, 'IRINA', 'PEÑA', 7, 2170, '2023-04-03', 2, 1, 5232514, 1, 1),
(53, 23456424, 'LUZ', 'MORALES', 7, 2180, '2023-04-03', 2, 1, 5232514, 1, 1),
(54, 7547425, 'ISAAC', 'PEREZ', 7, 2190, '2023-04-03', 2, 1, 5232514, 1, 1),
(55, 65674554, 'GENESIS', 'RUIZ', 21, 606, '2023-04-03', 2, 1, 4444444, 1, 1),
(56, 53425234, 'LUISA', 'CACERES', 3, 513, '2023-04-03', 2, 1, 18658542, 1, 0);

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
(34, '2023-03-14 00:00:00', 7, 2, 5),
(35, '2023-03-14 00:00:00', 13, 2, 1),
(36, '2023-03-14 00:00:00', 6, 2, 2),
(37, '2023-03-17 00:00:00', 7, 2, 4),
(38, '2023-03-21 00:00:00', 7, 2, 6),
(39, '2023-03-21 00:00:00', 6, 2, 9),
(40, '2023-03-21 00:00:00', 20, 2, 12),
(50, '2023-03-23 00:00:00', 9, 2, 13),
(51, '2023-03-23 00:00:00', 15, 2, 14),
(52, '2023-03-23 00:00:00', 14, 2, 15),
(53, '2023-03-24 00:00:00', 12, 2, 7),
(55, '2023-03-24 00:00:00', 8, 2, 18),
(56, '2023-03-24 00:00:00', 18, 2, 20),
(59, '2023-03-27 00:00:00', 16, 2, 19),
(60, '2023-03-27 00:00:00', 15, 2, 22),
(61, '2023-03-28 00:00:00', 13, 2, 23),
(62, '2023-03-28 00:00:00', 15, 2, 24),
(63, '2023-03-28 00:00:00', 11, 2, 25),
(64, '2023-03-28 00:00:00', 11, 2, 26),
(65, '2023-03-28 00:00:00', 12, 1, 28),
(66, '2023-03-28 00:00:00', 8, 1, 29),
(67, '2023-03-28 00:00:00', 11, 1, 30),
(68, '2023-03-28 00:00:00', 7, 1, 31),
(69, '2023-03-28 00:00:00', 19, 1, 32),
(70, '2023-03-28 00:00:00', 10, 1, 33),
(71, '2023-03-28 00:00:00', 15, 2, 16),
(72, '2023-03-29 00:00:00', 15, 2, 3),
(73, '2023-03-29 00:00:00', 10, 1, 34),
(74, '2023-03-29 00:00:00', 15, 1, 35),
(75, '2023-03-29 00:00:00', 10, 1, 36),
(77, '2023-03-29 00:00:00', 16, 1, 37),
(78, '2023-03-29 00:00:00', 15, 1, 38),
(79, '2023-03-29 00:00:00', 11, 1, 39),
(80, '2023-03-30 00:00:00', 13, 1, 41),
(81, '2023-03-30 00:00:00', 15, 1, 42),
(82, '2023-03-31 00:00:00', 10, 1, 46),
(83, '2023-03-31 00:00:00', 16, 1, 45),
(84, '2023-03-31 00:00:00', 15, 1, 44),
(85, '2023-03-31 00:00:00', 17, 2, 8),
(86, '2023-03-31 00:00:00', 16, 1, 27),
(87, '2023-04-03 00:00:00', 13, 1, 43),
(88, '2023-04-03 00:00:00', 12, 1, 48),
(89, '2023-04-03 00:00:00', 17, 1, 49),
(90, '2023-04-03 00:00:00', 12, 1, 50),
(91, '2023-04-03 00:00:00', 17, 1, 51),
(92, '2023-04-03 00:00:00', 9, 1, 52),
(93, '2023-04-03 00:00:00', 18, 1, 53),
(94, '2023-04-03 00:00:00', 11, 1, 54),
(97, '2023-04-05 00:00:00', 16, 2, 10),
(98, '2023-04-25 00:00:00', 18, 2, 56),
(99, '2023-04-28 00:00:00', 16, 2, 11),
(100, '2023-04-28 00:00:00', 16, 2, 17),
(103, '2023-05-03 00:00:00', 10, 2, 21);

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
(35, 21),
(35, 26),
(35, 29),
(35, 34),
(35, 40),
(37, 4),
(37, 8),
(37, 9),
(37, 14),
(37, 20),
(39, 24),
(39, 25),
(39, 29),
(39, 35),
(39, 40),
(40, 1),
(40, 7),
(40, 10),
(40, 16),
(40, 19),
(50, 24),
(50, 27),
(50, 32),
(50, 35),
(50, 40),
(51, 21),
(51, 28),
(51, 29),
(51, 33),
(51, 37),
(52, 2),
(52, 6),
(52, 11),
(52, 14),
(52, 19),
(34, 24),
(34, 25),
(34, 30),
(34, 35),
(34, 40),
(38, 2),
(38, 8),
(38, 9),
(38, 15),
(38, 17),
(36, 22),
(36, 25),
(36, 31),
(36, 35),
(36, 40),
(53, 41),
(53, 48),
(53, 52),
(53, 53),
(53, 58),
(55, 22),
(55, 27),
(55, 31),
(55, 35),
(55, 37),
(56, 21),
(56, 26),
(56, 29),
(56, 33),
(56, 39),
(59, 21),
(59, 26),
(59, 31),
(59, 36),
(59, 39),
(60, 24),
(60, 26),
(60, 29),
(60, 33),
(60, 39),
(61, 23),
(61, 27),
(61, 31),
(61, 33),
(61, 38),
(62, 24),
(62, 26),
(62, 30),
(62, 36),
(62, 39),
(63, 24),
(63, 28),
(63, 29),
(63, 34),
(63, 38),
(64, 24),
(64, 26),
(64, 31),
(64, 33),
(64, 40),
(65, 44),
(65, 46),
(65, 52),
(65, 53),
(65, 60),
(67, 42),
(67, 48),
(67, 50),
(67, 53),
(67, 58),
(66, 44),
(66, 46),
(66, 49),
(66, 53),
(66, 59),
(68, 44),
(68, 48),
(68, 49),
(68, 54),
(68, 59),
(69, 41),
(69, 47),
(69, 50),
(69, 54),
(69, 57),
(70, 43),
(70, 45),
(70, 49),
(70, 55),
(70, 60),
(71, 1),
(71, 7),
(71, 9),
(71, 13),
(71, 19),
(72, 23),
(72, 26),
(72, 31),
(72, 33),
(72, 38),
(73, 24),
(73, 26),
(73, 31),
(73, 36),
(73, 40),
(74, 23),
(74, 27),
(74, 32),
(74, 33),
(74, 37),
(75, 24),
(75, 25),
(75, 32),
(75, 36),
(75, 40),
(77, 21),
(77, 27),
(77, 32),
(77, 36),
(77, 38),
(78, 21),
(78, 28),
(78, 30),
(78, 34),
(78, 38),
(79, 22),
(79, 28),
(79, 29),
(79, 35),
(79, 38),
(80, 23),
(80, 27),
(80, 29),
(80, 36),
(80, 38),
(81, 24),
(81, 28),
(81, 30),
(81, 33),
(81, 39),
(82, 24),
(82, 28),
(82, 31),
(82, 33),
(82, 40),
(83, 23),
(83, 26),
(83, 32),
(83, 34),
(83, 38),
(84, 23),
(84, 26),
(84, 29),
(84, 36),
(84, 38),
(85, 41),
(85, 46),
(85, 52),
(85, 56),
(85, 60),
(86, 44),
(86, 47),
(86, 52),
(86, 56),
(86, 57),
(87, 23),
(87, 28),
(87, 29),
(87, 34),
(87, 38),
(88, 21),
(88, 25),
(88, 31),
(88, 36),
(88, 38),
(89, 21),
(89, 28),
(89, 30),
(89, 36),
(89, 39),
(90, 24),
(90, 28),
(90, 30),
(90, 34),
(90, 38),
(91, 21),
(91, 26),
(91, 32),
(91, 34),
(91, 38),
(92, 21),
(92, 25),
(92, 31),
(92, 35),
(92, 37),
(93, 21),
(93, 26),
(93, 29),
(93, 33),
(93, 39),
(94, 24),
(94, 27),
(94, 32),
(94, 34),
(94, 37),
(97, 21),
(97, 28),
(97, 32),
(97, 35),
(97, 39),
(98, 22),
(98, 26),
(98, 32),
(98, 33),
(98, 39),
(99, 3),
(99, 7),
(99, 10),
(99, 13),
(99, 18),
(100, 22),
(100, 28),
(100, 32),
(100, 33),
(100, 38),
(103, 22),
(103, 26),
(103, 29),
(103, 35),
(103, 40);

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
  ADD PRIMARY KEY (`id_eval`),
  ADD KEY `empleado_evaluacion` (`id_empleado`);

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
-- AUTO_INCREMENT de la tabla `sc_datos_usuarios`
--
ALTER TABLE `sc_datos_usuarios`
  MODIFY `id_datos_usuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `se_cargo`
--
ALTER TABLE `se_cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `se_ccosto`
--
ALTER TABLE `se_ccosto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `se_empleado`
--
ALTER TABLE `se_empleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `se_evaluacion`
--
ALTER TABLE `se_evaluacion`
  MODIFY `id_eval` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

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
  ADD CONSTRAINT `AU_DATOS_USUARIOS` FOREIGN KEY (`id_datos_usuarios`) REFERENCES `sc_datos_usuarios` (`id_datos_usuarios`);

--
-- Filtros para la tabla `sc_conex_usuarios`
--
ALTER TABLE `sc_conex_usuarios`
  ADD CONSTRAINT `CONEC_DATOS_USUARIOS` FOREIGN KEY (`id_datos_usuarios`) REFERENCES `sc_datos_usuarios` (`id_datos_usuarios`);

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
  ADD CONSTRAINT `fk_se_empleado_se_ccosto` FOREIGN KEY (`id_ccosto`) REFERENCES `bd_nivel_org`.`nivel_org` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_se_empleado_se_grado_inst1` FOREIGN KEY (`se_grado_inst_id`) REFERENCES `se_grado_inst` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tipo_nominaemp` FOREIGN KEY (`id_nomina`) REFERENCES `se_tipo_nomina` (`id_tn`);

--
-- Filtros para la tabla `se_evaluacion`
--
ALTER TABLE `se_evaluacion`
  ADD CONSTRAINT `empleado_evaluacion` FOREIGN KEY (`id_empleado`) REFERENCES `se_empleado` (`id`);

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
