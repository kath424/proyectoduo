-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.21-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for projecto_duo_db
DROP DATABASE IF EXISTS `projecto_duo_db`;
CREATE DATABASE IF NOT EXISTS `projecto_duo_db` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `projecto_duo_db`;

-- Dumping structure for table projecto_duo_db.capitulos
DROP TABLE IF EXISTS `capitulos`;
CREATE TABLE IF NOT EXISTS `capitulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `cursos_id` int(11) NOT NULL,
  `pasos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_capitulos_cursos1_idx` (`cursos_id`),
  CONSTRAINT `fk_capitulos_cursos1` FOREIGN KEY (`cursos_id`) REFERENCES `cursos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table projecto_duo_db.capitulos: ~4 rows (approximately)
/*!40000 ALTER TABLE `capitulos` DISABLE KEYS */;
INSERT INTO `capitulos` (`id`, `nombre`, `numero`, `cursos_id`, `pasos`) VALUES
	(1, 'Logica Basica', 1, 2, 7),
	(2, 'Logica intermedia', 2, 2, NULL),
	(3, 'Logica Avanzada', 3, 2, NULL),
	(4, 'Logica Super Avanzada', 4, 2, NULL);
/*!40000 ALTER TABLE `capitulos` ENABLE KEYS */;

-- Dumping structure for table projecto_duo_db.cursos
DROP TABLE IF EXISTS `cursos`;
CREATE TABLE IF NOT EXISTS `cursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='guarda los cursos\nejemplos:\nmatematica_1\nlogica_1\netc.....';

-- Dumping data for table projecto_duo_db.cursos: ~2 rows (approximately)
/*!40000 ALTER TABLE `cursos` DISABLE KEYS */;
INSERT INTO `cursos` (`id`, `nombre`) VALUES
	(1, 'Matematicas'),
	(2, 'Logica');
/*!40000 ALTER TABLE `cursos` ENABLE KEYS */;

-- Dumping structure for table projecto_duo_db.cursos_usuarios
DROP TABLE IF EXISTS `cursos_usuarios`;
CREATE TABLE IF NOT EXISTS `cursos_usuarios` (
  `cursos_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  KEY `fk_cursos_estudiantes_cursos1_idx` (`cursos_id`),
  KEY `fk_cursos_estudiantes_usuarios1_idx` (`usuarios_id`),
  CONSTRAINT `fk_cursos_estudiantes_cursos1` FOREIGN KEY (`cursos_id`) REFERENCES `cursos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cursos_estudiantes_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table projecto_duo_db.cursos_usuarios: ~6 rows (approximately)
/*!40000 ALTER TABLE `cursos_usuarios` DISABLE KEYS */;
INSERT INTO `cursos_usuarios` (`cursos_id`, `usuarios_id`) VALUES
	(1, 1),
	(2, 1),
	(1, 2),
	(2, 2),
	(1, 3),
	(2, 3);
/*!40000 ALTER TABLE `cursos_usuarios` ENABLE KEYS */;

-- Dumping structure for table projecto_duo_db.estudiante_respuestas
DROP TABLE IF EXISTS `estudiante_respuestas`;
CREATE TABLE IF NOT EXISTS `estudiante_respuestas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `respuesta` varchar(45) DEFAULT NULL,
  `usuarios_id` int(11) NOT NULL,
  `preguntas_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_estudiante-respuestas_usuarios1_idx` (`usuarios_id`),
  KEY `fk_estudiante-respuestas_ejercicios1_idx` (`preguntas_id`),
  CONSTRAINT `fk_estudiante-respuestas_ejercicios1` FOREIGN KEY (`preguntas_id`) REFERENCES `preguntas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_estudiante-respuestas_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table projecto_duo_db.estudiante_respuestas: ~4 rows (approximately)
/*!40000 ALTER TABLE `estudiante_respuestas` DISABLE KEYS */;
INSERT INTO `estudiante_respuestas` (`id`, `respuesta`, `usuarios_id`, `preguntas_id`) VALUES
	(6, 'molecular', 3, 11),
	(7, 'molecular', 3, 12),
	(8, 'atomica', 3, 13),
	(9, 'atomica', 3, 14);
/*!40000 ALTER TABLE `estudiante_respuestas` ENABLE KEYS */;

-- Dumping structure for table projecto_duo_db.preguntas
DROP TABLE IF EXISTS `preguntas`;
CREATE TABLE IF NOT EXISTS `preguntas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `capitulos_id` int(11) NOT NULL,
  `pregunta` varchar(256) DEFAULT NULL COMMENT 'que es html?',
  `opciones` varchar(256) DEFAULT NULL COMMENT 'un lenguaje,  una comida, un show de television',
  `respuesta` varchar(45) DEFAULT NULL COMMENT 'un lenguaje',
  PRIMARY KEY (`id`),
  KEY `fk_ejercicios_capitulos1_idx` (`capitulos_id`),
  CONSTRAINT `fk_ejercicios_capitulos1` FOREIGN KEY (`capitulos_id`) REFERENCES `capitulos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Dumping data for table projecto_duo_db.preguntas: ~14 rows (approximately)
/*!40000 ALTER TABLE `preguntas` DISABLE KEYS */;
INSERT INTO `preguntas` (`id`, `capitulos_id`, `pregunta`, `opciones`, `respuesta`) VALUES
	(1, 1, 'Ayudame a salir!', 'atomica,molecular', 'atomica'),
	(2, 1, 'Quieres torta?', 'atomica,molecular', 'atomica'),
	(3, 1, 'Si puedes contratar expertos, entonces que bien!', 'atomica,molecular', 'atomica'),
	(4, 1, 'Ignorar la ley no implica estar exento de cumplirla.', 'atomica,molecular', 'atomica'),
	(5, 1, 'O arreglamos este generador, o pasamos la noche sin electricidad.', 'atomica,molecular', 'atomica'),
	(6, 1, 'No es verdad que el diez sea un numero impar.', 'atomica,molecular', 'molecular'),
	(7, 1, 'Hazme caso. Si no, ¡corre!', 'atomica,molecular', 'molecular'),
	(8, 1, 'No sé si eso es verdad.', 'atomica,molecular', 'molecular'),
	(9, 1, 'Me pregunto si ya será mediodía.', 'atomica,molecular', 'molecular'),
	(10, 1, 'El presidente intenta actuar, pero el juez se lo impide.', 'atomica,molecular', 'molecular'),
	(11, 2, 'El presidente intenta actuar, pero el juez se lo impide.', 'atomica,molecular', 'molecular'),
	(12, 2, 'El presidente intenta actuar, pero el juez se lo impide.', 'atomica,molecular', 'molecular'),
	(13, 2, 'El presidente intenta actuar, pero el juez se lo impide.', 'atomica,molecular', 'molecular'),
	(14, 2, 'El presidente intenta actuar, pero el juez se lo impide.', 'atomica,molecular', 'molecular');
/*!40000 ALTER TABLE `preguntas` ENABLE KEYS */;

-- Dumping structure for table projecto_duo_db.preguntas_de_seguridad
DROP TABLE IF EXISTS `preguntas_de_seguridad`;
CREATE TABLE IF NOT EXISTS `preguntas_de_seguridad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pregunta` varchar(45) DEFAULT NULL COMMENT 'como se llama tu mama?',
  `respuesta` varchar(45) DEFAULT NULL COMMENT 'mamita',
  `usuarios_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_preguntas_de_seguridad_usuarios1_idx` (`usuarios_id`),
  CONSTRAINT `fk_preguntas_de_seguridad_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table projecto_duo_db.preguntas_de_seguridad: ~0 rows (approximately)
/*!40000 ALTER TABLE `preguntas_de_seguridad` DISABLE KEYS */;
/*!40000 ALTER TABLE `preguntas_de_seguridad` ENABLE KEYS */;

-- Dumping structure for table projecto_duo_db.usuarios
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
  `actualizado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cedula_UNIQUE` (`cedula`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table projecto_duo_db.usuarios: ~4 rows (approximately)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `tipo_de_usuario`, `usuario`, `clave`, `cedula`, `creado`, `actualizado`) VALUES
	(1, 'admin', 'admin', 'admin', 'administrador', 'clave', NULL, '2017-07-06 02:15:43', '2017-07-06 02:15:43'),
	(2, 'maestro', 'maestro', 'maestro', 'maestro', 'clave', NULL, '2017-07-06 02:15:43', '2017-07-06 02:15:43'),
	(3, 'kath', 'acosta', 'estudiante', 'katherinelabeibi', 'vision', '12343', '2017-07-06 02:16:10', '2017-07-06 02:16:10'),
	(4, 'adrian', 'galicia', 'estudiante', 'adrianplusplus', 'vision', '123234345', '2017-07-06 02:16:35', '2017-07-06 02:16:35');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
