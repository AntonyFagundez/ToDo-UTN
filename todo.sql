-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 10-11-2019 a las 01:46:09
-- Versión del servidor: 8.0.15
-- Versión de PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `todo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `description` varchar(120) NOT NULL,
  `user` varchar(40) NOT NULL,
  `priority` varchar(20) NOT NULL,
  `is_finish` tinyint(1) NOT NULL DEFAULT '0',
  `dead_line` date DEFAULT NULL,
  `date_created` date NOT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `task`
--

INSERT INTO `task` (`id`, `title`, `description`, `user`, `priority`, `is_finish`, `dead_line`, `date_created`, `id_user`) VALUES
(61, 'mi primer tarea', 'descripcion de mi primertareaokok', 'Antony', 'Baja', 1, '2019-10-01', '2019-10-26', 61),
(68, 'DAO', 'Como implementar DAO aca jajajajaj', 'Antony', 'Alta', 0, '2019-11-09', '2019-11-01', 68),
(69, 'Estudiar', 'una tarea', 'JhonAntony', 'Media', 0, '2019-11-09', '2019-11-10', 69),
(70, 'OTra', 'buenos', 'JhonAntony', 'Media', 0, '2019-11-11', '2019-11-10', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(40) NOT NULL,
  `first_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `date_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `user`, `password`, `email`, `first_name`, `last_name`) VALUES
(31, 'Antony', '$2y$10$k4lR4VI.ptvKCQWXtyiQcuBvlPmhBRjiYsrNxnNWvwd4J..GYFFJC', 'jhonfagundez@gmail.com', 'Jhon Antony Moises', 'Fagundez Guevara'),
(65, 'JhonAntony', '$2y$10$t74il9cH4aRE2EOxW4aVAe7vNaK5ylCf3.VfK4hdtd9aWxqMctyiu', 'jhon_fagundez@hotmail.com', 'Antony', 'Fagundez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_asigned`
--

CREATE TABLE `user_asigned` (
  `id` int(11) NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user` varchar(40) NOT NULL,
  `mail` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_task` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `user_asigned`
--

INSERT INTO `user_asigned` (`id`, `name`, `user`, `mail`, `id_task`) VALUES
(97, NULL, 'Yo :(', NULL, 68),
(98, NULL, 'Antony', NULL, 61),
(101, NULL, 'JhonAntony', NULL, 69);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_user_2` (`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_asigned`
--
ALTER TABLE `user_asigned`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_asigned_task` (`id_task`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `user_asigned`
--
ALTER TABLE `user_asigned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `user_asigned`
--
ALTER TABLE `user_asigned`
  ADD CONSTRAINT `fk_user_asigned_task` FOREIGN KEY (`id_task`) REFERENCES `task` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
