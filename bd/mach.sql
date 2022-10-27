-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-10-2022 a las 18:45:18
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
-- Estructura de tabla para la tabla `mach`
--

DROP TABLE IF EXISTS `mach`;
CREATE TABLE IF NOT EXISTS `mach` (
  `match_id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id_usu1` int(11) NOT NULL,
  `match_id_usu2` int(11) NOT NULL,
  `match_estado_u1` int(11) NOT NULL,
  `match_estado_u2` int(11) NOT NULL,
  `match_fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado_conexion_u1` varchar(14) COLLATE utf8_spanish2_ci NOT NULL,
  `estado_conexion_u2` varchar(14) COLLATE utf8_spanish2_ci NOT NULL,
  `match_deshecho` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`match_id`),
  KEY `match_id_usu1` (`match_id_usu1`,`match_id_usu2`),
  KEY `match_id_usu2` (`match_id_usu2`)
) ENGINE=InnoDB AUTO_INCREMENT=310 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Truncar tablas antes de insertar `mach`
--

TRUNCATE TABLE `mach`;
--
-- Volcado de datos para la tabla `mach`
--

INSERT DELAYED IGNORE INTO `mach` (`match_id`, `match_id_usu1`, `match_id_usu2`, `match_estado_u1`, `match_estado_u2`, `match_fecha`, `estado_conexion_u1`, `estado_conexion_u2`, `match_deshecho`) VALUES
(307, 1, 7, 1, 1, '2022-10-27 14:17:54', 'Conectado', '', 1),
(308, 1, 2, 1, 1, '2022-10-27 14:17:44', 'Conectado', '', 1),
(309, 1, 0, 1, 1, '2022-10-27 14:44:49', 'Conectado', '', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mach`
--
ALTER TABLE `mach`
  ADD CONSTRAINT `mach_ibfk_1` FOREIGN KEY (`match_id_usu1`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mach_ibfk_2` FOREIGN KEY (`match_id_usu2`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
