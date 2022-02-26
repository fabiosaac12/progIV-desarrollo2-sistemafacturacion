-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 26, 2022 at 07:17 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistema_facturacion`
--

-- --------------------------------------------------------

--
-- Table structure for table `barcos`
--

DROP TABLE IF EXISTS `barcos`;
CREATE TABLE IF NOT EXISTS `barcos` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `operador` varchar(100) NOT NULL,
  `tripulacion` int(6) NOT NULL,
  `capacidad_kg` int(9) NOT NULL,
  `porcentaje_gastos_operativos` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barcos`
--

INSERT INTO `barcos` (`id`, `nombre`, `codigo`, `operador`, `tripulacion`, `capacidad_kg`, `porcentaje_gastos_operativos`) VALUES
(4, 'El barco verde', '62194238affef', 'Hombre verde', 100, 1000, 0.08),
(5, 'El barco de piratas del caribe', '621a6449c6349', 'Jack Sparrow', 150, 1500, 0.06);

-- --------------------------------------------------------

--
-- Table structure for table `estados_clima`
--

DROP TABLE IF EXISTS `estados_clima`;
CREATE TABLE IF NOT EXISTS `estados_clima` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estados_clima`
--

INSERT INTO `estados_clima` (`id`, `nombre`) VALUES
(0, 'Soleado'),
(1, 'Lluvioso'),
(2, 'Nublado'),
(3, 'Ventoso');

-- --------------------------------------------------------

--
-- Table structure for table `facturas`
--

DROP TABLE IF EXISTS `facturas`;
CREATE TABLE IF NOT EXISTS `facturas` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `id_jornada` mediumint(9) NOT NULL,
  `id_usuario` mediumint(9) NOT NULL,
  `id_barco` mediumint(9) NOT NULL,
  `cantidad_mercancia_kg` int(9) NOT NULL,
  `hora_generacion` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_jornada` (`id_jornada`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_barco` (`id_barco`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `facturas`
--

INSERT INTO `facturas` (`id`, `codigo`, `id_jornada`, `id_usuario`, `id_barco`, `cantidad_mercancia_kg`, `hora_generacion`) VALUES
(5, '6219512060a38', 5, 1, 4, 122, '21:58:00'),
(6, '621951cfa19e6', 5, 1, 4, 800, '18:01:00'),
(8, '621952f1bca93', 5, 1, 4, 900, '18:06:00'),
(9, '6219552b8837e', 5, 1, 4, 130, '18:16:00'),
(10, '62195e2528c11', 5, 1, 4, 550, '18:54:00'),
(11, '621a33a0873d8', 5, 11, 4, 200, '10:05:00'),
(12, '621a43ad69b63', 5, 11, 4, 220, '11:13:00'),
(13, '621a62c0306a1', 7, 1, 4, 200, '13:26:00'),
(14, '621a645104d95', 7, 1, 5, 222, '13:33:00'),
(15, '621a64f7eba6d', 7, 12, 5, 200, '13:35:00'),
(16, '621a763ff22db', 8, 1, 5, 100, '14:49:00'),
(17, '621a7678983ec', 8, 11, 4, 123, '14:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `jornadas`
--

DROP TABLE IF EXISTS `jornadas`;
CREATE TABLE IF NOT EXISTS `jornadas` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_cierre` time NOT NULL,
  `estado_clima` mediumint(1) DEFAULT NULL,
  `precio_mercancia_kg` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `estado_clima` (`estado_clima`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jornadas`
--

INSERT INTO `jornadas` (`id`, `fecha`, `hora_inicio`, `hora_cierre`, `estado_clima`, `precio_mercancia_kg`) VALUES
(5, '2022-02-28', '04:01:00', '16:01:00', 2, 50),
(6, '2022-02-27', '23:36:00', '23:41:00', 2, 10),
(7, '2022-02-25', '13:13:00', '18:10:00', 2, 7),
(8, '2022-02-26', '15:49:00', '20:49:00', 2, 20);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` mediumint(9) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(0, 'Superadministrador'),
(1, 'Administrador'),
(2, 'Cajero');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` mediumint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rol` (`rol`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `cedula`, `direccion`, `telefono`, `correo`, `contrasena`, `rol`) VALUES
(1, 'Fabio Isaac', '29655801', 'La Asuncion', '04165858555', 'fabbbssbs@gmail.com', '$2y$10$frvKhrUdeE6kkjEsc8Ld6u2g1AQW80H86/DD3LK3HxqZKoPAs/hOu', 0),
(11, 'Sebastian Millan', '29655049', 'La Asuncion', '04161919191', 'sebastian@sebastian.com', '$2y$10$frvKhrUdeE6kkjEsc8Ld6u2g1AQW80H86/DD3LK3HxqZKoPAs/hOu', 2),
(12, 'Fabian Bermudez', '29655555', 'Porlamar', '04122222222', 'scacas@csckc.com', '$2y$10$3wBYrXyst/c7TyB0r.bsouYrxPpvQRERjQM0bWL5cyYmX65LK3J3O', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`id_jornada`) REFERENCES `jornadas` (`id`),
  ADD CONSTRAINT `facturas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `facturas_ibfk_3` FOREIGN KEY (`id_barco`) REFERENCES `barcos` (`id`);

--
-- Constraints for table `jornadas`
--
ALTER TABLE `jornadas`
  ADD CONSTRAINT `jornadas_ibfk_1` FOREIGN KEY (`estado_clima`) REFERENCES `estados_clima` (`id`);

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
