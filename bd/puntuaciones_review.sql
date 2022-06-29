-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-05-2022 a las 16:06:58
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `connecting_people1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuaciones_review`
--

CREATE TABLE `puntuaciones_review` (
  `puntuaciones_review_id` int(11) NOT NULL,
  `puntuaciones_review_aspecto_id` int(11) NOT NULL,
  `puntuaciones_review_puntuacion` int(11) NOT NULL,
  `puntuaciones_review_review_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `puntuaciones_review`
--
ALTER TABLE `puntuaciones_review`
  ADD PRIMARY KEY (`puntuaciones_review_id`),
  ADD KEY `puntuaciones_review_aspecto_id` (`puntuaciones_review_aspecto_id`),
  ADD KEY `puntuaciones_review_review_id` (`puntuaciones_review_review_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `puntuaciones_review`
--
ALTER TABLE `puntuaciones_review`
  MODIFY `puntuaciones_review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `puntuaciones_review`
--
ALTER TABLE `puntuaciones_review`
  ADD CONSTRAINT `puntuaciones_review_ibfk_1` FOREIGN KEY (`puntuaciones_review_id`) REFERENCES `review` (`review_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `puntuaciones_review_ibfk_2` FOREIGN KEY (`puntuaciones_review_aspecto_id`) REFERENCES `aspecto` (`aspecto_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
