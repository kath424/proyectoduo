-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2017 at 07:53 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=389 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `actividades`
--

INSERT INTO `actividades` (`id`, `tiempo`, `detalles`, `usuarios_id`) VALUES
(253, '2017-08-09 04:16:36', 'Inicio Session?', 3),
(254, '2017-08-09 04:16:36', 'Pagina Inicial?', 3),
(255, '2017-08-09 04:18:17', 'Pagina Inicial?', 3),
(372, '2017-08-09 05:35:59', 'Cursos', 1),
(373, '2017-08-09 05:36:00', 'Cursos', 1),
(374, '2017-08-09 05:36:01', 'Cursos', 1),
(375, '2017-08-09 05:36:14', 'Cursos', 1),
(376, '2017-08-09 05:39:03', 'Cursos', 1),
(377, '2017-08-09 05:39:11', 'Cursos', 1),
(378, '2017-08-09 05:39:22', 'Cursos', 1),
(379, '2017-08-09 05:39:46', 'Cursos', 1),
(380, '2017-08-09 05:40:02', 'Cursos', 1),
(381, '2017-08-09 05:40:09', 'Cursos', 1),
(382, '2017-08-09 05:41:24', 'Inicio Session', 3),
(383, '2017-08-09 05:41:24', 'Pagina Inicial', 3),
(384, '2017-08-09 05:41:28', 'Cursos', 3),
(385, '2017-08-09 05:41:30', 'Cursos', 3),
(386, '2017-08-09 05:41:36', 'Cursos', 3),
(387, '2017-08-09 05:44:41', 'Pagina Inicial', 3),
(388, '2017-08-09 05:48:21', 'Pagina Inicial', 3);

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
  `puede_repetir` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_capitulos_cursos1_idx` (`cursos_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `capitulos`
--

INSERT INTO `capitulos` (`id`, `nombre`, `numero`, `cursos_id`, `pasos`, `puede_repetir`) VALUES
(1, 'Logica Basica', 1, 2, 7, NULL),
(2, 'Logica Intermedia', 2, 2, NULL, NULL),
(3, 'Logica Avanzada', 3, 2, NULL, NULL),
(4, 'Logica Super Avanzada', 4, 2, NULL, NULL),
(5, 'Matematica Basica', NULL, 1, 4, NULL),
(7, 'practica_logica', NULL, 2, NULL, b'1111111111111111111111111111111'),
(8, 'capitulo1', NULL, 10, NULL, b'1111111111111111111111111111111');

-- --------------------------------------------------------

--
-- Table structure for table `cursos`
--

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE IF NOT EXISTS `cursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='guarda los cursos\nejemplos:\nmatematica_1\nlogica_1\netc.....';

--
-- Dumping data for table `cursos`
--

INSERT INTO `cursos` (`id`, `nombre`) VALUES
(1, 'Matematicas'),
(2, 'Logica I'),
(9, 'Desarrollo Web'),
(10, 'Ingles');

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
(2, 2),
(1, 3),
(2, 3),
(9, 4),
(9, 5),
(10, 3),
(10, 4),
(10, 5);

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `preguntas`
--

INSERT INTO `preguntas` (`id`, `capitulos_id`, `pregunta`, `opciones`, `respuesta`) VALUES
(1, 5, '1+1?', '1,2', '2'),
(2, 5, '5*5?', '25,30,50,90', '25'),
(3, 5, '45%5?', '3,4,5,9', '9'),
(4, 5, '569-9', '560,556,443,555', '560'),
(5, 5, '90+203?', '122,345,293', '293'),
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
(21, 2, 'El presidente intenta actuar, pero el juez se lo impide.', 'atomica,molecular', 'molecular'),
(22, 7, 'uno', 'uno,dos', 'uno'),
(23, 7, 'dos', 'uno,dos', 'dos');

-- --------------------------------------------------------

--
-- Table structure for table `preguntas_de_seguridad`
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
-- Dumping data for table `preguntas_de_seguridad`
--

INSERT INTO `preguntas_de_seguridad` (`id`, `pregunta`, `respuesta`, `usuarios_id`) VALUES
(1, 'en que pais naci?', 'venezuela', 3),
(2, 'lenguaje de programacion favorito?', 'php', 3),
(3, 'de donde es adrian(ciudad)?', 'tijuana', 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `tipo_de_usuario`, `usuario`, `clave`, `cedula`, `creado`, `ultimo_logeo`) VALUES
(1, 'admin', 'admin', 'admin', 'administrador', 'clave', NULL, '0000-00-00 00:00:00', '2017-08-09 12:05:39'),
(2, 'maestro', 'maestro', 'maestro', 'maestro', 'clave', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'katherine', 'acosta', 'estudiante', 'katherinelabeibi', 'clave', '12345', '2017-07-28 09:16:29', '2017-08-09 12:41:24'),
(4, 'adrian', 'g', 'estudiante', 'adrianplusplus', 'clave', '13333', '2017-07-28 09:16:29', '2017-08-07 11:53:52'),
(5, 'k', 'k', 'estudiante', 'kk123', 'clave', '14444', '2017-07-28 09:16:29', '2017-08-07 11:53:52');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `fk_actividades_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `capitulos`
--
ALTER TABLE `capitulos`
  ADD CONSTRAINT `fk_capitulos_cursos1` FOREIGN KEY (`cursos_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `cursos_usuarios`
--
ALTER TABLE `cursos_usuarios`
  ADD CONSTRAINT `fk_cursos_estudiantes_cursos1` FOREIGN KEY (`cursos_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cursos_estudiantes_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `estudiante_respuestas`
--
ALTER TABLE `estudiante_respuestas`
  ADD CONSTRAINT `fk_estudiante-respuestas_ejercicios1` FOREIGN KEY (`preguntas_id`) REFERENCES `preguntas` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_estudiante-respuestas_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `fk_ejercicios_capitulos1` FOREIGN KEY (`capitulos_id`) REFERENCES `capitulos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `preguntas_de_seguridad`
--
ALTER TABLE `preguntas_de_seguridad`
  ADD CONSTRAINT `fk_preguntas_de_seguridad_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


--
-- Metadata
--
USE `phpmyadmin`;

--
-- Metadata for table actividades
--

--
-- Metadata for table capitulos
--

--
-- Metadata for table cursos
--

--
-- Metadata for table cursos_usuarios
--

--
-- Metadata for table estudiante_respuestas
--

--
-- Metadata for table preguntas
--

--
-- Metadata for table preguntas_de_seguridad
--

--
-- Metadata for table usuarios
--

--
-- Metadata for database projecto_duo_db
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
