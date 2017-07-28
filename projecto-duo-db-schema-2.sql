-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-07-2017 a las 11:35:28
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `projecto_duo_db`
--
CREATE DATABASE IF NOT EXISTS `projecto_duo_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `projecto_duo_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

DROP TABLE IF EXISTS `actividades`;
CREATE TABLE IF NOT EXISTS `actividades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tiempo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `detalles` varchar(200) DEFAULT NULL,
  `usuarios_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_actividades_usuarios1_idx` (`usuarios_id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `actividades`
--

TRUNCATE TABLE `actividades`;
--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `tiempo`, `detalles`, `usuarios_id`) VALUES
(26, '2017-07-28 09:24:12', 'Cursos?id=3&nombre=Ingles', 1),
(27, '2017-07-28 09:24:15', 'Pagina Inicial?', 1),
(28, '2017-07-28 09:24:18', 'Pagina Inicial?', 1),
(29, '2017-07-28 09:24:35', 'Pagina Inicial?', 1),
(37, '2017-07-28 09:25:30', 'Inicio Session?', 1),
(38, '2017-07-28 09:25:30', 'Pagina Inicial?', 1),
(39, '2017-07-28 09:25:32', 'Cursos?', 1),
(40, '2017-07-28 09:25:33', 'Cursos?id=3&nombre=Ingles', 1),
(41, '2017-07-28 09:25:36', 'Cursos?id=3&nombre=Ingles&capitulo_id=6&nombre_capitulo=Verbos Basicos&accion=agregarContenido', 1),
(42, '2017-07-28 09:25:49', 'Cursos?id=3&nombre=Ingles', 1),
(79, '2017-07-28 09:29:27', 'Evaluacion?id=6', 3),
(80, '2017-07-28 09:29:27', 'Pagina Inicial?', 3),
(81, '2017-07-28 09:29:48', 'Evaluacion?id=6', 3),
(82, '2017-07-28 09:29:48', 'Evaluacion?id=6', 3),
(83, '2017-07-28 09:29:51', 'Evaluacion?id=6', 3),
(84, '2017-07-28 09:31:59', 'Pagina Inicial?', 3),
(85, '2017-07-28 09:33:36', 'Evaluacion?id=6', 3),
(86, '2017-07-28 09:33:36', 'Evaluacion?id=6', 3),
(87, '2017-07-28 09:33:38', 'Evaluacion?id=6', 3),
(88, '2017-07-28 09:33:38', 'Pagina Inicial?', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capitulos`
--

DROP TABLE IF EXISTS `capitulos`;
CREATE TABLE IF NOT EXISTS `capitulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `cursos_id` int(11) NOT NULL,
  `pasos` int(11) DEFAULT NULL,
  `puede_repetir` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_capitulos_cursos1_idx` (`cursos_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `capitulos`
--

TRUNCATE TABLE `capitulos`;
--
-- Volcado de datos para la tabla `capitulos`
--

INSERT INTO `capitulos` (`id`, `nombre`, `numero`, `cursos_id`, `pasos`, `puede_repetir`) VALUES
(1, 'Logica Basica', 1, 2, 7, NULL),
(2, 'Logica Intermedia', 2, 2, NULL, NULL),
(3, 'Logica Avanzada', 3, 2, NULL, NULL),
(4, 'Logica Super Avanzada', 4, 2, NULL, NULL),
(5, 'Matematica Basica', NULL, 1, 4, NULL),
(6, 'Verbos Basicos', NULL, 3, 3, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE IF NOT EXISTS `cursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='guarda los cursos\nejemplos:\nmatematica_1\nlogica_1\netc.....';

--
-- Truncar tablas antes de insertar `cursos`
--

TRUNCATE TABLE `cursos`;
--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `nombre`) VALUES
(1, 'matematicas'),
(2, 'logica'),
(3, 'Ingles');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos_usuarios`
--

DROP TABLE IF EXISTS `cursos_usuarios`;
CREATE TABLE IF NOT EXISTS `cursos_usuarios` (
  `cursos_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  KEY `fk_cursos_estudiantes_cursos1_idx` (`cursos_id`),
  KEY `fk_cursos_estudiantes_usuarios1_idx` (`usuarios_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `cursos_usuarios`
--

TRUNCATE TABLE `cursos_usuarios`;
--
-- Volcado de datos para la tabla `cursos_usuarios`
--

INSERT INTO `cursos_usuarios` (`cursos_id`, `usuarios_id`) VALUES
(1, 1),
(2, 1),
(1, 2),
(2, 2),
(1, 3),
(2, 3),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante_respuestas`
--

DROP TABLE IF EXISTS `estudiante_respuestas`;
CREATE TABLE IF NOT EXISTS `estudiante_respuestas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `respuesta` varchar(100) DEFAULT NULL,
  `usuarios_id` int(11) NOT NULL,
  `preguntas_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_estudiante-respuestas_usuarios1_idx` (`usuarios_id`),
  KEY `fk_estudiante-respuestas_ejercicios1_idx` (`preguntas_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `estudiante_respuestas`
--

TRUNCATE TABLE `estudiante_respuestas`;
--
-- Volcado de datos para la tabla `estudiante_respuestas`
--

INSERT INTO `estudiante_respuestas` (`id`, `respuesta`, `usuarios_id`, `preguntas_id`) VALUES
(1, 'Cual es tu comida favorita?', 3, 6),
(2, 'como te llamas?', 3, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

DROP TABLE IF EXISTS `preguntas`;
CREATE TABLE IF NOT EXISTS `preguntas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `capitulos_id` int(11) NOT NULL,
  `pregunta` varchar(256) DEFAULT NULL COMMENT 'que es html?',
  `opciones` varchar(256) DEFAULT NULL COMMENT 'un lenguaje,  una comida, un show de television',
  `respuesta` varchar(45) DEFAULT NULL COMMENT 'un lenguaje',
  PRIMARY KEY (`id`),
  KEY `fk_ejercicios_capitulos1_idx` (`capitulos_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `preguntas`
--

TRUNCATE TABLE `preguntas`;
--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `capitulos_id`, `pregunta`, `opciones`, `respuesta`) VALUES
(1, 5, '1+1?', '1,2', '2'),
(2, 5, '5*5?', '25,30,50,90', '25'),
(3, 5, '45%5?', '3,4,5,9', '9'),
(4, 5, '569-9', '560,556,443,555', '560'),
(5, 5, '90+203?', '122,345,293', '293'),
(6, 6, 'How Are You?', 'Como te llamas?,Cual es tu comida favorita?', 'Como te llamas?'),
(7, 6, 'How Old Are You?', 'que edad tienes?,como te llamas?', 'que edad tienes?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_de_seguridad`
--

DROP TABLE IF EXISTS `preguntas_de_seguridad`;
CREATE TABLE IF NOT EXISTS `preguntas_de_seguridad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pregunta` varchar(45) DEFAULT NULL COMMENT 'como se llama tu mama?',
  `respuesta` varchar(45) DEFAULT NULL COMMENT 'mamita',
  `usuarios_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_preguntas_de_seguridad_usuarios1_idx` (`usuarios_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `preguntas_de_seguridad`
--

TRUNCATE TABLE `preguntas_de_seguridad`;
--
-- Volcado de datos para la tabla `preguntas_de_seguridad`
--

INSERT INTO `preguntas_de_seguridad` (`id`, `pregunta`, `respuesta`, `usuarios_id`) VALUES
(1, 'en que pais naci?', 'venezuela', 3),
(2, 'lenguaje de programacion favorito?', 'php', 3),
(3, 'de donde es adrian(ciudad)?', 'tijuana', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `tipo_de_usuario` varchar(45) DEFAULT 'estudiante' COMMENT 'puede ser\nadministrador\nestudiante\nusuario\n',
  `usuario` varchar(45) DEFAULT NULL,
  `clave` varchar(45) DEFAULT NULL,
  `cedula` varchar(45) DEFAULT NULL,
  `creado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ultimo_logeo` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cedula_UNIQUE` (`cedula`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `usuarios`
--

TRUNCATE TABLE `usuarios`;
--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `tipo_de_usuario`, `usuario`, `clave`, `cedula`, `creado`, `ultimo_logeo`) VALUES
(1, 'admin', 'admin', 'admin', 'administrador', 'clave', NULL, '0000-00-00 00:00:00', '2017-07-28 16:25:30'),
(2, 'maestro', 'maestro', 'maestro', 'maestro', 'clave', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'katherine', 'acosta', 'estudiante', 'katherinelabeibi', 'clave', '12345', '2017-07-28 09:16:29', '2017-07-28 16:33:36');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `fk_actividades_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `capitulos`
--
ALTER TABLE `capitulos`
  ADD CONSTRAINT `fk_capitulos_cursos1` FOREIGN KEY (`cursos_id`) REFERENCES `cursos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cursos_usuarios`
--
ALTER TABLE `cursos_usuarios`
  ADD CONSTRAINT `fk_cursos_estudiantes_cursos1` FOREIGN KEY (`cursos_id`) REFERENCES `cursos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cursos_estudiantes_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `estudiante_respuestas`
--
ALTER TABLE `estudiante_respuestas`
  ADD CONSTRAINT `fk_estudiante-respuestas_ejercicios1` FOREIGN KEY (`preguntas_id`) REFERENCES `preguntas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_estudiante-respuestas_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `fk_ejercicios_capitulos1` FOREIGN KEY (`capitulos_id`) REFERENCES `capitulos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `preguntas_de_seguridad`
--
ALTER TABLE `preguntas_de_seguridad`
  ADD CONSTRAINT `fk_preguntas_de_seguridad_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
