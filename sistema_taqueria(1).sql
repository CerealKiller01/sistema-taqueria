-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 18-05-2023 a las 23:26:02
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_taqueria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos_x_venta`
--

CREATE TABLE `articulos_x_venta` (
  `axv_id` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_producto` decimal(6,2) NOT NULL,
  `total_x_producto` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `carrito_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_productos`
--

CREATE TABLE `categoria_productos` (
  `categoria_producto_id` int(11) NOT NULL,
  `nombre_categoria` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `empleado_id` int(11) NOT NULL,
  `nombre` varchar(70) NOT NULL,
  `apellido_paterno` varchar(30) NOT NULL,
  `apellido_materno` varchar(30) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `rol` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`empleado_id`, `nombre`, `apellido_paterno`, `apellido_materno`, `telefono`, `rol`) VALUES
(8, 'm', 'x', 'r', '123', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `productos_id` int(11) NOT NULL,
  `nombre` varchar(70) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `precio` decimal(5,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_registro_producto` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`productos_id`, `nombre`, `imagen`, `precio`, `cantidad`, `fecha_registro_producto`) VALUES
(1, 'tacos', 'testUno.jpg', 7.00, 0, '2023-05-13 00:34:35'),
(2, 'cemas', 'testDos.jpg', 17.00, 0, '2023-05-13 00:35:23'),
(3, 'fanta', 'testTres.jpg', 17.00, 20, '2023-05-13 00:35:49'),
(4, 'boing', 'testCuatro.jpg', 17.00, 15, '2023-05-13 00:36:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `venta_id` int(11) NOT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `monto` decimal(6,2) NOT NULL,
  `dinero_cliente` decimal(6,2) NOT NULL,
  `cambio` decimal(6,2) NOT NULL,
  `fecha_venta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos_x_venta`
--
ALTER TABLE `articulos_x_venta`
  ADD PRIMARY KEY (`axv_id`),
  ADD KEY `venta_id` (`venta_id`),
  ADD KEY `producto_productos_id` (`producto_id`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`carrito_id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `empleado_carrito_id` (`empleado_id`);

--
-- Indices de la tabla `categoria_productos`
--
ALTER TABLE `categoria_productos`
  ADD PRIMARY KEY (`categoria_producto_id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`empleado_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`productos_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `empleado_id` (`empleado_id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`venta_id`),
  ADD KEY `empleado_ventas_id` (`empleado_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos_x_venta`
--
ALTER TABLE `articulos_x_venta`
  MODIFY `axv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `carrito_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categoria_productos`
--
ALTER TABLE `categoria_productos`
  MODIFY `categoria_producto_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `empleado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `productos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `venta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos_x_venta`
--
ALTER TABLE `articulos_x_venta`
  ADD CONSTRAINT `producto_productos_id` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`productos_id`),
  ADD CONSTRAINT `venta_id` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`venta_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `empleado_carrito_id` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`empleado_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_id` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`productos_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `empleado_id` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`empleado_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `empleado_ventas_id` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`empleado_id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
