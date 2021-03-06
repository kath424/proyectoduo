-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2017 at 01:17 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projecto_duo_db`
--
CREATE DATABASE IF NOT EXISTS `projecto_duo_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `projecto_duo_db`;

-- --------------------------------------------------------

--
-- Table structure for table `actividades`
--

DROP TABLE IF EXISTS `actividades`;
CREATE TABLE IF NOT EXISTS `actividades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tiempo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `detalles` varchar(200) DEFAULT NULL,
  `usuarios_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_actividades_usuarios1_idx` (`usuarios_id`)
) ENGINE=InnoDB AUTO_INCREMENT=292 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `actividades`
--

INSERT INTO `actividades` (`id`, `tiempo`, `detalles`, `usuarios_id`) VALUES
(97, '2017-07-28 14:37:07', 'Capitulo?id=1&curso=logica&capitulo=Logica I&paso=1', 3),
(98, '2017-07-28 14:37:15', 'Cursos?id=2&nombre=logica', 3),
(99, '2017-07-28 14:37:18', 'Cursos?id=2&nombre=logica', 3),
(100, '2017-07-28 14:37:21', 'Cursos?', 3),
(101, '2017-07-28 14:37:22', 'Cursos?id=2&nombre=Logica', 3),
(102, '2017-07-28 14:37:23', 'Capitulo?id=1&curso=Logica&capitulo=Logica I&paso=1', 3),
(103, '2017-07-28 14:38:14', 'Cursos?', 3),
(104, '2017-07-28 14:38:16', 'Cursos?', 3),
(105, '2017-07-28 14:38:42', 'Cursos?id=2&nombre=Logica I', 3),
(106, '2017-07-28 14:38:43', 'Capitulo?id=1&curso=Logica I&capitulo=Logica Basica&paso=1', 3),
(111, '2017-08-10 03:43:59', '', 4),
(112, '2017-08-10 03:44:00', 'Preguntas de Seguridad', 4),
(113, '2017-08-10 03:44:20', 'Pagina Inicial', 4),
(219, '2017-08-13 17:05:30', 'Pagina Inicial', 2),
(220, '2017-08-13 17:05:31', 'Pagina Inicial', 2),
(221, '2017-08-13 17:06:02', 'Pagina Inicial', 2),
(222, '2017-08-13 17:06:05', 'Pagina Inicial', 2),
(223, '2017-08-13 17:06:12', 'Pagina Inicial', 2),
(224, '2017-08-13 17:06:16', 'Pagina Inicial', 2),
(225, '2017-08-13 17:06:19', 'Cursos', 2),
(226, '2017-08-13 17:08:38', 'Inicio Session', 1),
(227, '2017-08-13 17:08:38', 'Pagina Inicial', 1),
(228, '2017-08-13 17:08:39', 'Usuarios', 1),
(229, '2017-08-13 17:09:56', 'Usuarios', 1),
(230, '2017-08-13 17:12:25', 'Usuarios', 1),
(231, '2017-08-13 17:12:26', 'Usuarios', 1),
(232, '2017-08-13 17:23:22', 'Usuarios', 1),
(233, '2017-08-13 17:23:54', 'Usuarios', 1),
(234, '2017-08-13 17:23:57', 'Pagina Inicial', 1),
(235, '2017-08-13 17:23:57', 'Pagina Inicial', 1),
(248, '2017-08-13 18:22:32', 'Inicio Session', 2),
(249, '2017-08-13 18:22:32', 'Pagina Inicial', 2),
(250, '2017-08-13 18:22:34', 'Cursos', 2),
(272, '2017-08-13 21:55:09', 'Preguntas de Seguridad', 14),
(273, '2017-08-13 21:56:12', 'Pagina Inicial', 14),
(274, '2017-08-13 21:56:23', 'Cursos', 14),
(282, '2017-08-13 22:28:06', 'Capitulo', 6),
(283, '2017-08-13 22:28:12', 'Capitulo', 6),
(284, '2017-08-13 22:28:13', 'Evaluacion', 6),
(285, '2017-08-13 22:28:14', 'Evaluacion', 6),
(286, '2017-08-13 22:32:31', 'Evaluacion', 6),
(287, '2017-08-13 22:32:34', 'Evaluacion', 6),
(288, '2017-08-13 22:32:37', 'Evaluacion', 6),
(289, '2017-08-13 22:32:38', 'Evaluacion', 6),
(290, '2017-08-13 22:32:39', 'Evaluacion', 6),
(291, '2017-08-13 22:34:55', 'Evaluacion', 6);

-- --------------------------------------------------------

--
-- Table structure for table `capitulos`
--

DROP TABLE IF EXISTS `capitulos`;
CREATE TABLE IF NOT EXISTS `capitulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `cursos_id` int(11) NOT NULL,
  `pasos` int(11) DEFAULT NULL,
  `puede_repetir` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_capitulos_cursos1_idx` (`cursos_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `capitulos`
--

INSERT INTO `capitulos` (`id`, `nombre`, `numero`, `cursos_id`, `pasos`, `puede_repetir`) VALUES
(1, 'Logica Basica', 1, 2, 7, 0),
(2, 'Logica Intermedia', 2, 2, NULL, 0),
(3, 'Logica Avanzada', 3, 2, NULL, 0),
(4, 'Logica Super Avanzada', 4, 2, NULL, 0),
(5, 'Matematica Basica', NULL, 1, 4, 1),
(6, 'Verbos Basicos', NULL, 3, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cursos`
--

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE IF NOT EXISTS `cursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='guarda los cursos\nejemplos:\nmatematica_1\nlogica_1\netc.....';

--
-- Dumping data for table `cursos`
--

INSERT INTO `cursos` (`id`, `nombre`) VALUES
(1, 'Matematicas'),
(2, 'Logica I'),
(3, 'Ingles');

-- --------------------------------------------------------

--
-- Table structure for table `cursos_usuarios`
--

DROP TABLE IF EXISTS `cursos_usuarios`;
CREATE TABLE IF NOT EXISTS `cursos_usuarios` (
  `cursos_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  KEY `fk_cursos_estudiantes_cursos1_idx` (`cursos_id`),
  KEY `fk_cursos_estudiantes_usuarios1_idx` (`usuarios_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cursos_usuarios`
--

INSERT INTO `cursos_usuarios` (`cursos_id`, `usuarios_id`) VALUES
(1, 1),
(2, 1),
(1, 2),
(3, 2),
(1, 3),
(2, 3),
(3, 3),
(1, 4),
(2, 4),
(3, 4),
(1, 6),
(2, 6),
(3, 6),
(2, 2),
(1, 14),
(2, 14),
(3, 14);

-- --------------------------------------------------------

--
-- Table structure for table `estudiante_respuestas`
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
-- Dumping data for table `estudiante_respuestas`
--

INSERT INTO `estudiante_respuestas` (`id`, `respuesta`, `usuarios_id`, `preguntas_id`) VALUES
(1, 'Cual es tu comida favorita?', 3, 6),
(2, 'como te llamas?', 3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `preguntas`
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `preguntas`
--

INSERT INTO `preguntas` (`id`, `capitulos_id`, `pregunta`, `opciones`, `respuesta`) VALUES
(1, 5, '1+1?', '1,2', '2'),
(2, 5, '5*5?', '25,30,50,90', '25'),
(3, 5, '45%5?', '3,4,5,9', '9'),
(4, 5, '569-9', '560,556,443,555', '560'),
(5, 5, '90+203?', '122,345,293', '293'),
(6, 6, 'How Are You?', 'Como te llamas?,Cual es tu comida favorita?', 'Como te llamas?'),
(7, 6, 'How Old Are You?', 'que edad tienes?,como te llamas?', 'que edad tienes?'),
(8, 1, 'Ayudame a salir!', 'atomica,molecular', 'atomica'),
(9, 1, 'Quieres torta?', 'atomica,molecular', 'atomica'),
(10, 1, 'Si puedes contratar expertos, entonces que bien!', 'atomica,molecular', 'atomica'),
(11, 1, 'Ignorar la ley no implica estar exento de cumplirla.', 'atomica,molecular', 'atomica'),
(12, 1, 'O arreglamos este generador, o pasamos la noche sin electricidad.', 'atomica,molecular', 'atomica'),
(13, 1, 'No es verdad que el diez sea un numero impar.', 'atomica,molecular', 'molecular'),
(14, 1, 'Hazme caso. Si no, ¡corre!', 'atomica,molecular', 'molecular'),
(15, 1, 'No sé si eso es verdad.', 'atomica,molecular', 'molecular'),
(16, 1, 'Me pregunto si ya será mediodía.', 'atomica,molecular', 'molecular'),
(17, 1, 'El presidente intenta actuar, pero el juez se lo impide.', 'atomica,molecular', 'molecular'),
(18, 2, 'El presidente intenta actuar, pero el juez se lo impide.', 'atomica,molecular', 'molecular'),
(19, 2, 'El presidente intenta actuar, pero el juez se lo impide.', 'atomica,molecular', 'molecular'),
(20, 2, 'El presidente intenta actuar, pero el juez se lo impide.', 'atomica,molecular', 'molecular'),
(21, 2, 'El presidente intenta actuar, pero el juez se lo impide.', 'atomica,molecular', 'molecular');

-- --------------------------------------------------------

--
-- Table structure for table `preguntas_de_seguridad`
--

DROP TABLE IF EXISTS `preguntas_de_seguridad`;
CREATE TABLE IF NOT EXISTS `preguntas_de_seguridad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pregunta` varchar(45) DEFAULT NULL COMMENT 'como se llama tu mama?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `preguntas_de_seguridad`
--

INSERT INTO `preguntas_de_seguridad` (`id`, `pregunta`) VALUES
(1, '¿En que ciudad naciste?'),
(2, '¿Cual es el nombre de tu mascota favorita?'),
(3, '¿Cual es tu comida favorita?'),
(5, '¿Cual es tu dia feriado favorito?'),
(6, '¿Cual es tu pelicula favorita?'),
(7, '¿Cual es tu deporte favorito?'),
(8, '¿Cual es el nombre de tu madre?');

-- --------------------------------------------------------

--
-- Table structure for table `respuestas_de_seguridad`
--

DROP TABLE IF EXISTS `respuestas_de_seguridad`;
CREATE TABLE IF NOT EXISTS `respuestas_de_seguridad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `preguntas_id` int(11) NOT NULL DEFAULT '0',
  `respuesta` varchar(50) NOT NULL DEFAULT '0',
  `usuarios_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_respuestas_de_seguridad_usuarios1_idx` (`usuarios_id`),
  KEY `fk_respuestas_de_seguridad_preguntas_de_seguridad1_idx` (`preguntas_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `respuestas_de_seguridad`
--

INSERT INTO `respuestas_de_seguridad` (`id`, `preguntas_id`, `respuesta`, `usuarios_id`) VALUES
(6, 1, 'tijuana', 14),
(7, 2, 'firulais', 14),
(8, 6, 'sora no otoshimono 3', 14);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `tipo_de_usuario`, `usuario`, `clave`, `cedula`, `creado`, `ultimo_logeo`) VALUES
(1, 'admin', 'admin', 'admin', 'administrador', 'clave', NULL, '0000-00-00 00:00:00', '2017-08-14 00:08:38'),
(2, 'maestro', 'maestro', 'profesor', 'profesor', 'clave', NULL, '0000-00-00 00:00:00', '2017-08-14 01:22:32'),
(3, 'katherine', 'acosta', 'estudiante', 'katherinelabeibi', 'clave', '12345', '2017-07-28 09:16:29', '2017-07-28 16:33:36'),
(4, 'asdasd', 'asdasd', 'estudiante', 'asd', 'asd', 'asdasd', '2017-08-10 03:43:59', '2017-08-10 10:43:59'),
(6, 'adrian', 'galicia', 'estudiante', 'adrianplusplus', 'vision', '0000', '2017-08-11 02:55:27', '2017-08-14 05:28:14'),
(14, 'kk', 'kk', 'estudiante', 'kk123', 'vision', '1231', '2017-08-13 21:55:09', '2017-08-14 04:55:09');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `fk_actividades_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `capitulos`
--
ALTER TABLE `capitulos`
  ADD CONSTRAINT `fk_capitulos_cursos1` FOREIGN KEY (`cursos_id`) REFERENCES `cursos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `cursos_usuarios`
--
ALTER TABLE `cursos_usuarios`
  ADD CONSTRAINT `fk_cursos_estudiantes_cursos1` FOREIGN KEY (`cursos_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cursos_estudiantes_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `estudiante_respuestas`
--
ALTER TABLE `estudiante_respuestas`
  ADD CONSTRAINT `fk_estudiante-respuestas_ejercicios1` FOREIGN KEY (`preguntas_id`) REFERENCES `preguntas` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_estudiante-respuestas_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `fk_ejercicios_capitulos1` FOREIGN KEY (`capitulos_id`) REFERENCES `capitulos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `respuestas_de_seguridad`
--
ALTER TABLE `respuestas_de_seguridad`
  ADD CONSTRAINT `fk_respuesatas_de_seguridad_preguntas_de_seguridad1` FOREIGN KEY (`preguntas_id`) REFERENCES `preguntas_de_seguridad` (`id`),
  ADD CONSTRAINT `fk_respuestas_de_seguridad_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
