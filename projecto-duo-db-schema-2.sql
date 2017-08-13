-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2017 at 10:34 AM
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
CREATE TABLE `actividades` (
  `id` int(11) NOT NULL,
  `tiempo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `detalles` varchar(200) DEFAULT NULL,
  `usuarios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `actividades`
--

INSERT INTO `actividades` (`id`, `tiempo`, `detalles`, `usuarios_id`) VALUES
(254, '2017-08-11 08:16:22', 'Pagina Inicial', 1),
(255, '2017-08-11 08:17:24', 'Pagina Inicial', 1),
(256, '2017-08-11 08:17:28', 'Usuarios', 1),
(257, '2017-08-11 08:17:53', 'Usuarios', 1),
(258, '2017-08-11 08:18:04', 'Usuarios', 1),
(259, '2017-08-11 08:18:08', 'Usuarios', 1),
(295, '2017-08-11 08:24:08', 'Cursos', 2),
(296, '2017-08-11 08:24:17', 'Cursos', 2),
(311, '2017-08-11 08:25:19', 'Inicio Session', 2),
(312, '2017-08-11 08:25:19', 'Pagina Inicial', 2),
(313, '2017-08-11 08:25:31', 'Cursos', 2),
(314, '2017-08-11 08:25:35', 'Cursos', 2),
(315, '2017-08-11 08:25:39', 'Cursos', 2),
(316, '2017-08-11 08:26:55', 'Cursos', 2),
(317, '2017-08-11 08:27:03', 'Cursos', 2),
(318, '2017-08-11 08:27:20', 'Cursos', 2),
(330, '2017-08-11 08:27:57', 'Evaluacion', 3),
(331, '2017-08-11 08:27:58', 'Pagina Inicial', 3),
(332, '2017-08-11 08:28:05', 'Pagina Inicial', 3),
(333, '2017-08-11 08:28:12', 'Pagina Inicial', 3),
(334, '2017-08-11 08:28:14', 'Cursos', 3),
(335, '2017-08-11 08:28:16', 'Cursos', 3),
(336, '2017-08-11 08:28:18', 'Cursos', 3),
(337, '2017-08-11 08:28:20', 'Cursos', 3),
(338, '2017-08-11 08:28:21', 'Cursos', 3),
(339, '2017-08-11 08:28:24', 'Capitulo', 3),
(340, '2017-08-11 08:31:12', 'Preguntas de Seguridad', 7),
(341, '2017-08-11 08:31:13', 'Pagina Inicial', 7),
(342, '2017-08-11 08:31:17', 'Pagina Inicial', 7),
(343, '2017-08-11 08:31:18', 'Cursos', 7),
(344, '2017-08-11 08:31:20', 'Cursos', 7),
(345, '2017-08-11 08:31:22', 'Cursos', 7),
(346, '2017-08-11 08:31:25', 'Cursos', 7),
(347, '2017-08-11 08:31:33', 'Inicio Session', 7),
(348, '2017-08-11 08:31:33', 'Pagina Inicial', 7),
(351, '2017-08-11 08:32:27', 'Inicio Session', 1),
(352, '2017-08-11 08:32:27', 'Pagina Inicial', 1),
(353, '2017-08-11 08:32:29', 'Usuarios', 1),
(354, '2017-08-11 08:32:39', 'Usuarios', 1);

-- --------------------------------------------------------

--
-- Table structure for table `capitulos`
--

DROP TABLE IF EXISTS `capitulos`;
CREATE TABLE `capitulos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `cursos_id` int(11) NOT NULL,
  `pasos` int(11) DEFAULT NULL,
  `puede_repetir` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `capitulos`
--

INSERT INTO `capitulos` (`id`, `nombre`, `numero`, `cursos_id`, `pasos`, `puede_repetir`) VALUES
(1, 'Logica Basica', 1, 2, 7, 0),
(2, 'Logica Intermedia', 2, 2, NULL, 0),
(3, 'Logica Avanzada', 3, 2, NULL, 0),
(4, 'Logica Super Avanzada', 4, 2, NULL, 0),
(5, 'Matematica Basica', NULL, 1, 4, 1),
(7, 'Verbos Basicos', NULL, 5, 3, NULL),
(8, 'Practica 1', NULL, 5, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cursos`
--

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='guarda los cursos\nejemplos:\nmatematica_1\nlogica_1\netc.....';

--
-- Dumping data for table `cursos`
--

INSERT INTO `cursos` (`id`, `nombre`) VALUES
(1, 'Matematicas'),
(2, 'Logica I'),
(5, 'Ingles');

-- --------------------------------------------------------

--
-- Table structure for table `cursos_usuarios`
--

DROP TABLE IF EXISTS `cursos_usuarios`;
CREATE TABLE `cursos_usuarios` (
  `cursos_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL
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
(5, 3),
(1, 7),
(2, 7),
(5, 7);

-- --------------------------------------------------------

--
-- Table structure for table `estudiante_respuestas`
--

DROP TABLE IF EXISTS `estudiante_respuestas`;
CREATE TABLE `estudiante_respuestas` (
  `id` int(11) NOT NULL,
  `respuesta` varchar(100) DEFAULT NULL,
  `usuarios_id` int(11) NOT NULL,
  `preguntas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `estudiante_respuestas`
--

INSERT INTO `estudiante_respuestas` (`id`, `respuesta`, `usuarios_id`, `preguntas_id`) VALUES
(9, 'atomica', 3, 8),
(13, 'adios', 3, 22),
(14, 'como estas?', 3, 23);

-- --------------------------------------------------------

--
-- Table structure for table `preguntas`
--

DROP TABLE IF EXISTS `preguntas`;
CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL,
  `capitulos_id` int(11) NOT NULL,
  `pregunta` varchar(256) DEFAULT NULL COMMENT 'que es html?',
  `opciones` varchar(256) DEFAULT NULL COMMENT 'un lenguaje,  una comida, un show de television',
  `respuesta` varchar(45) DEFAULT NULL COMMENT 'un lenguaje'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(22, 7, 'Hello?', 'adios,hola', 'hola'),
(23, 7, 'how are you?', 'quien eres?,que te pasa?,como estas?', 'como estas?'),
(24, 8, 'practica', 'si,no', 'si');

-- --------------------------------------------------------

--
-- Table structure for table `preguntas_de_seguridad`
--

DROP TABLE IF EXISTS `preguntas_de_seguridad`;
CREATE TABLE `preguntas_de_seguridad` (
  `id` int(11) NOT NULL,
  `pregunta` varchar(45) DEFAULT NULL COMMENT 'como se llama tu mama?',
  `respuesta` varchar(45) DEFAULT NULL COMMENT 'mamita',
  `usuarios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `preguntas_de_seguridad`
--

INSERT INTO `preguntas_de_seguridad` (`id`, `pregunta`, `respuesta`, `usuarios_id`) VALUES
(1, 'en que pais naci?', 'venezuela', 3),
(2, 'lenguaje de programacion favorito?', 'php', 3),
(3, 'de donde es adrian(ciudad)?', 'tijuana', 3),
(8, 'de donde eres?', 'Mexico', 7);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `tipo_de_usuario` varchar(45) DEFAULT 'estudiante' COMMENT 'puede ser\nadministrador\nestudiante\nusuario\n',
  `usuario` varchar(45) DEFAULT NULL,
  `clave` varchar(45) DEFAULT NULL,
  `cedula` varchar(45) DEFAULT NULL,
  `creado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ultimo_logeo` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `tipo_de_usuario`, `usuario`, `clave`, `cedula`, `creado`, `ultimo_logeo`) VALUES
(1, 'admin', 'admin', 'admin', 'administrador', 'clave', NULL, '0000-00-00 00:00:00', '2017-08-11 15:32:26'),
(2, 'profesor', 'profesor', 'profesor', 'profesor', 'clave', NULL, '0000-00-00 00:00:00', '2017-08-11 15:25:18'),
(3, 'katherine', 'acosta', 'estudiante', 'katherinelabeibi', 'clave', '12345', '2017-07-28 09:16:29', '2017-08-11 15:27:51'),
(7, 'adrian', 'gol', 'estudiante', 'adrianplusplus', 'vision', '0000', '2017-08-11 08:31:12', '2017-08-11 15:31:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_actividades_usuarios1_idx` (`usuarios_id`);

--
-- Indexes for table `capitulos`
--
ALTER TABLE `capitulos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_capitulos_cursos1_idx` (`cursos_id`);

--
-- Indexes for table `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cursos_usuarios`
--
ALTER TABLE `cursos_usuarios`
  ADD KEY `fk_cursos_estudiantes_cursos1_idx` (`cursos_id`),
  ADD KEY `fk_cursos_estudiantes_usuarios1_idx` (`usuarios_id`);

--
-- Indexes for table `estudiante_respuestas`
--
ALTER TABLE `estudiante_respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_estudiante-respuestas_usuarios1_idx` (`usuarios_id`),
  ADD KEY `fk_estudiante-respuestas_ejercicios1_idx` (`preguntas_id`);

--
-- Indexes for table `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ejercicios_capitulos1_idx` (`capitulos_id`);

--
-- Indexes for table `preguntas_de_seguridad`
--
ALTER TABLE `preguntas_de_seguridad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_preguntas_de_seguridad_usuarios1_idx` (`usuarios_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula_UNIQUE` (`cedula`),
  ADD UNIQUE KEY `usuario_UNIQUE` (`usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=355;
--
-- AUTO_INCREMENT for table `capitulos`
--
ALTER TABLE `capitulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `estudiante_respuestas`
--
ALTER TABLE `estudiante_respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `preguntas_de_seguridad`
--
ALTER TABLE `preguntas_de_seguridad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
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
  ADD CONSTRAINT `fk_capitulos_cursos1` FOREIGN KEY (`cursos_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_ejercicios_capitulos1` FOREIGN KEY (`capitulos_id`) REFERENCES `capitulos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `preguntas_de_seguridad`
--
ALTER TABLE `preguntas_de_seguridad`
  ADD CONSTRAINT `fk_preguntas_de_seguridad_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
