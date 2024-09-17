-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 17-09-2024 a las 20:01:20
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `yobel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companias`
--

DROP TABLE IF EXISTS `companias`;
CREATE TABLE IF NOT EXISTS `companias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `companias`
--

INSERT INTO `companias` (`id`, `nombre`, `direccion`) VALUES
(1, 'YOBEL SCM Ecuador', 'Av. García Moreno KM 15.5 y Panamericana Norte.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

DROP TABLE IF EXISTS `paquetes`;
CREATE TABLE IF NOT EXISTS `paquetes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario_origen` int DEFAULT NULL,
  `id_usuario_destino` int NOT NULL,
  `id_producto` int DEFAULT NULL,
  `id_sucursal_origen` int DEFAULT NULL,
  `id_sucursal_destino` int DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `fecha_envio` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario_origen`),
  KEY `id_producto` (`id_producto`),
  KEY `id_sucursal_origen` (`id_sucursal_origen`),
  KEY `id_sucursal_destino` (`id_sucursal_destino`),
  KEY `id_usuario_destino` (`id_usuario_destino`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `paquetes`
--

INSERT INTO `paquetes` (`id`, `id_usuario_origen`, `id_usuario_destino`, `id_producto`, `id_sucursal_origen`, `id_sucursal_destino`, `estado`, `fecha_envio`) VALUES
(1, 4, 2, 1, 1, 3, 'recibido', '2024-09-17'),
(2, 4, 2, 2, 1, 3, 'enviado', '2024-09-17'),
(3, 4, 2, 3, 2, 4, 'enviado', '2024-09-17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `descripcion`, `peso`) VALUES
(1, 'Televisor 4k', 7.90),
(2, 'Maquinaria', 35.00),
(3, 'Producto elétrico', 20.70);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

DROP TABLE IF EXISTS `sucursales`;
CREATE TABLE IF NOT EXISTS `sucursales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `ciudad` varchar(50) DEFAULT NULL,
  `id_compania` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_compania` (`id_compania`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id`, `nombre`, `direccion`, `ciudad`, `id_compania`) VALUES
(1, 'Q-Sucursal-A', 'Avenida A - Calle A', 'QUITO', 1),
(2, 'Q-Sucursal-B', 'Avenida B - Calle B', 'QUITO', 1),
(3, 'G-Sucursal-A', 'Avenida A - Calle A', 'GUAYAQUIL', 1),
(4, 'G-Sucursal-B', 'Avenida B - Calle B', 'GUAYAQUIL', 1),
(5, 'G-Sucursal-C', 'Avenida C - Calle C', 'GUAYAQUIL', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`) VALUES
(2, 'Destinatario Z', 'destinatarioz@ejemplo.com', '$2y$10$6UVUBOKw2r8iSmJD6YN.Nu2Co.r6n.P219Xmp/Cb/Zvxa6uTNKqRi'),
(4, 'Usuario X', 'usuariox@ejemplo.com', '$2y$10$FSFGM9TVib8pfYwSfeRdTu74lQQzS1cvPNShzVhr0ZObGpK5TdLAe');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD CONSTRAINT `paquetes_ibfk_1` FOREIGN KEY (`id_usuario_origen`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paquetes_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paquetes_ibfk_3` FOREIGN KEY (`id_sucursal_origen`) REFERENCES `sucursales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paquetes_ibfk_4` FOREIGN KEY (`id_sucursal_destino`) REFERENCES `sucursales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paquetes_ibfk_5` FOREIGN KEY (`id_usuario_destino`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD CONSTRAINT `sucursales_ibfk_1` FOREIGN KEY (`id_compania`) REFERENCES `companias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
