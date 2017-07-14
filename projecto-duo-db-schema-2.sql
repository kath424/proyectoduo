-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-07-2017 a las 14:26:02
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capitulos`
--

CREATE TABLE `capitulos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `cursos_id` int(11) NOT NULL,
  `pasos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `capitulos`
--

INSERT INTO `capitulos` (`id`, `nombre`, `numero`, `cursos_id`, `pasos`) VALUES
(1, 'Logica Basica', 1, 2, 7),
(2, 'Logica intermedia', 2, 2, NULL),
(3, 'Logica Avanzada', 3, 2, NULL),
(4, 'Logica Super Avanzada', 4, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='guarda los cursos\nejemplos:\nmatematica_1\nlogica_1\netc.....';

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `nombre`) VALUES
(1, 'Matematicas'),
(2, 'Logica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos_usuarios`
--

CREATE TABLE `cursos_usuarios` (
  `cursos_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(2, 4),
(1, 19),
(2, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante_respuestas`
--

CREATE TABLE `estudiante_respuestas` (
  `id` int(11) NOT NULL,
  `respuesta` varchar(45) DEFAULT NULL,
  `usuarios_id` int(11) NOT NULL,
  `preguntas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estudiante_respuestas`
--

INSERT INTO `estudiante_respuestas` (`id`, `respuesta`, `usuarios_id`, `preguntas_id`) VALUES
(42, 'molecular', 3, 1),
(43, 'molecular', 3, 2),
(44, 'atomica', 3, 3),
(45, 'atomica', 3, 4),
(46, 'molecular', 3, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL,
  `capitulos_id` int(11) NOT NULL,
  `pregunta` varchar(256) DEFAULT NULL COMMENT 'que es html?',
  `opciones` varchar(256) DEFAULT NULL COMMENT 'un lenguaje,  una comida, un show de television',
  `respuesta` varchar(45) DEFAULT NULL COMMENT 'un lenguaje'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `preguntas`
--

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_de_seguridad`
--

CREATE TABLE `preguntas_de_seguridad` (
  `id` int(11) NOT NULL,
  `pregunta` varchar(45) DEFAULT NULL COMMENT 'como se llama tu mama?',
  `respuesta` varchar(45) DEFAULT NULL COMMENT 'mamita',
  `usuarios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `preguntas_de_seguridad`
--

INSERT INTO `preguntas_de_seguridad` (`id`, `pregunta`, `respuesta`, `usuarios_id`) VALUES
(1, 'asdasd', 'asdasd', 4),
(2, 'asdasd', 'asdasd', 4),
(3, 'asdasd', 'asdasd', 4),
(4, 'como me llamo?', 'safenet', 19),
(5, 'como me llamo?', 'safenet', 19),
(6, 'como me llamo?', 'safenet', 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `tipo_de_usuario` varchar(45) DEFAULT 'estudiante' COMMENT 'puede ser\nadministrador\nestudiante\nusuario\n',
  `usuario` varchar(45) DEFAULT NULL,
  `clave` varchar(45) DEFAULT NULL,
  `cedula` varchar(45) DEFAULT NULL,
  `creado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `tipo_de_usuario`, `usuario`, `clave`, `cedula`, `creado`, `actualizado`) VALUES
(1, 'admin', 'admin', 'admin', 'administrador', 'clave', NULL, '2017-07-06 07:15:43', '2017-07-06 07:15:43'),
(2, 'maestro', 'maestro', 'maestro', 'maestro', 'clave', NULL, '2017-07-06 07:15:43', '2017-07-06 07:15:43'),
(3, 'kath', 'acosta', 'estudiante', 'katherinelabeibi', 'vision', '12343', '2017-07-06 07:16:10', '2017-07-06 07:16:10'),
(4, 'adrian', 'galicia', 'estudiante', 'adrianplusplus', 'clave', '123234345', '2017-07-06 07:16:35', '2017-07-06 07:16:35'),
(18, 'adrian', 'galicia', 'estudiante', 'adrian++', 'vision', '101010', '2017-07-09 18:49:00', '2017-07-09 18:49:00'),
(19, 'safe', 'net', 'estudiante', 'safenet', 'clave', '999', '2017-07-14 12:19:34', '2017-07-14 12:19:34');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `capitulos`
--
ALTER TABLE `capitulos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_capitulos_cursos1_idx` (`cursos_id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cursos_usuarios`
--
ALTER TABLE `cursos_usuarios`
  ADD KEY `fk_cursos_estudiantes_cursos1_idx` (`cursos_id`),
  ADD KEY `fk_cursos_estudiantes_usuarios1_idx` (`usuarios_id`);

--
-- Indices de la tabla `estudiante_respuestas`
--
ALTER TABLE `estudiante_respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_estudiante-respuestas_usuarios1_idx` (`usuarios_id`),
  ADD KEY `fk_estudiante-respuestas_ejercicios1_idx` (`preguntas_id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ejercicios_capitulos1_idx` (`capitulos_id`);

--
-- Indices de la tabla `preguntas_de_seguridad`
--
ALTER TABLE `preguntas_de_seguridad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_preguntas_de_seguridad_usuarios1_idx` (`usuarios_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula_UNIQUE` (`cedula`),
  ADD UNIQUE KEY `usuario_UNIQUE` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `capitulos`
--
ALTER TABLE `capitulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `estudiante_respuestas`
--
ALTER TABLE `estudiante_respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `preguntas_de_seguridad`
--
ALTER TABLE `preguntas_de_seguridad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Restricciones para tablas volcadas
--

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
