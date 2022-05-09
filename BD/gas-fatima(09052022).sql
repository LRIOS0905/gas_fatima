-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-05-2022 a las 16:00:06
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gas-fatima`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_USUARIOS` ()  SELECT
	persona.idpersona, 
	persona.identificacion, 
	persona.nombres, 
	persona.apellidos, 
	persona.email_user,
	persona.telefono, 
	persona.rolid, 
	persona.`status`, 
	persona.datecreated, 
	rol.nombrerol
FROM
	persona
	INNER JOIN
	rol
	ON 
		persona.rolid = rol.idrol
		WHERE persona.status!=0$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_PROVEEDOR` (IN `PROVEEDOR` VARCHAR(100))  BEGIN
DECLARE CANTIDAD INT;
SET @CANTIDAD:=(SELECT COUNT(*) FROM proveedores where nombres=PROVEEDOR);
IF @CANTIDAD = 0 THEN
	INSERT INTO proveedores(nombres,telefono,correo,direccion,status) VALUES(NOMBRES,TELEFONO,CORREO, DIRECCION, STATUS);
	SELECT 1;
ELSE
	SELECT 2;
END IF;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `codigo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `marca_id` int(11) NOT NULL,
  `tipo_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `codigo`, `nombre`, `telefono`, `direccion`, `marca_id`, `tipo_id`, `status`, `datecreated`) VALUES
(1, '101', 'Jonathan', 'pendiente', 'Santa Emilia, del tanque de agua, 1/2 cuara al lago, casa celeste, ref#-Señor de los buses.', 1, 1, 1, '2022-05-03 13:43:52'),
(2, '102', 'Idalia Espinoza', 'Pendiente', 'De la escuela Pablo Antonio Cuadra, 1/2 cuadra al sur, casa mamon con rodapie negro, MI.', 1, 1, 1, '2022-05-03 21:39:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp_compras`
--

CREATE TABLE `detalle_temp_compras` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_temp_compras`
--

INSERT INTO `detalle_temp_compras` (`id`, `id_producto`, `id_usuario`, `precio`, `cantidad`, `sub_total`) VALUES
(195, 1, 1, '420.00', 100, '42000.00'),
(196, 2, 1, '420.00', 100, '42000.00'),
(197, 3, 1, '420.00', 100, '42000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `idmarca` bigint(20) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_swedish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `portada` varchar(100) COLLATE utf8mb4_swedish_ci NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT current_timestamp(),
  `ruta` varchar(255) COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`idmarca`, `nombre`, `descripcion`, `portada`, `datecreated`, `ruta`, `status`) VALUES
(1, 'Tropigas', 'Gas butano de 25 libras', 'img_565f9282bdcd1f30a30137613bf6165c.jpg', '2022-05-01 23:23:11', '', 1),
(2, 'Petrogas', 'Gas butano de 25 libras', 'img_cca5899968a2a38bf35d86288e8e851b.jpg', '2022-05-01 23:23:26', '', 1),
(3, 'Zetagas', 'Gas butano de 25 libras', 'img_f959c59558fb932537cf7c72c810e0fe.jpg', '2022-05-01 23:23:41', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `idmodulo` bigint(20) NOT NULL,
  `titulo` varchar(50) COLLATE utf8mb4_swedish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`idmodulo`, `titulo`, `descripcion`, `status`) VALUES
(1, 'Dashboard', 'Modulo principal ', 1),
(2, 'Usuarios', 'Modulos usuarios', 1),
(3, 'Mantenimiento', 'Módulo correspondiente mantenimento', 1),
(4, 'Clientes', 'Módulo de clientes.', 1),
(5, 'Productos', 'Módulo de productos.', 1),
(6, 'Compras', 'Módulo de compras', 1),
(7, 'Proveedores', 'Módulo proveedores', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `idpermiso` bigint(20) NOT NULL,
  `rolid` bigint(20) NOT NULL,
  `moduloid` bigint(20) NOT NULL,
  `r` int(11) NOT NULL DEFAULT 0,
  `w` int(11) NOT NULL DEFAULT 0,
  `u` int(11) NOT NULL DEFAULT 0,
  `d` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`idpermiso`, `rolid`, `moduloid`, `r`, `w`, `u`, `d`) VALUES
(50, 1, 1, 1, 0, 0, 0),
(51, 1, 2, 1, 1, 1, 1),
(52, 1, 3, 1, 1, 1, 1),
(53, 1, 4, 1, 1, 1, 1),
(54, 1, 5, 1, 1, 1, 1),
(55, 1, 6, 1, 1, 1, 1),
(56, 2, 1, 0, 0, 0, 0),
(57, 2, 2, 1, 1, 1, 1),
(58, 2, 3, 0, 0, 0, 0),
(59, 2, 4, 0, 0, 0, 0),
(60, 2, 5, 0, 0, 0, 0),
(61, 2, 6, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idpersona` bigint(20) NOT NULL,
  `identificacion` varchar(30) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `nombres` varchar(80) COLLATE utf8mb4_swedish_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_swedish_ci NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `email_user` varchar(100) COLLATE utf8mb4_swedish_ci NOT NULL,
  `password` varchar(75) COLLATE utf8mb4_swedish_ci NOT NULL,
  `nit` varchar(20) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `nombrefiscal` varchar(80) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `direccionfiscal` varchar(100) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `token` varchar(100) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `rolid` bigint(20) NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idpersona`, `identificacion`, `nombres`, `apellidos`, `telefono`, `email_user`, `password`, `nit`, `nombrefiscal`, `direccionfiscal`, `token`, `rolid`, `datecreated`, `status`) VALUES
(1, '201-290787-0004L', 'Lenin Vladimir', 'Rios Vasquez', 78129768, 'lenin.rios@securytech.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'NIC2012907870004L', 'Secury Tech Services', 'Esquina de pachelli, 300 vrs. al norte.', '', 1, '2022-01-23 21:01:18', 1),
(2, 'Pendiente', 'Vladimir', 'Rios Vasquez', 78129768, 'vladimir.rios@info.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, NULL, NULL, NULL, 2, '2022-04-25 20:12:45', 1),
(3, '201-090589-0000P', 'Ingrid Vannesa', 'Chavez Matus', 81838396, 'ingrid@info.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, NULL, NULL, NULL, 2, '2022-05-05 23:33:04', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `codigo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `marca_id` int(11) NOT NULL,
  `tipo_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `codigo`, `descripcion`, `precio_compra`, `precio_venta`, `stock`, `marca_id`, `tipo_id`, `status`, `datecreated`) VALUES
(1, '1001', 'Gas butano de 25 libras', '420.00', '440.00', 0, 1, 1, 1, '2022-05-03 19:59:55'),
(2, '1002', 'Gas butano de 25 libras', '420.00', '440.00', 0, 1, 2, 1, '2022-05-03 20:00:11'),
(3, '1003', 'Gas butano de 25 libras', '420.00', '440.00', 0, 2, 1, 1, '2022-05-03 20:00:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombres` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombres`, `telefono`, `correo`, `direccion`, `status`, `datecreated`) VALUES
(1, 'Securytech', '555555', 'securytech@info.com', 'Granada', 1, '2022-05-07 15:32:51'),
(2, 'Polojeans', '888888', 'polo@info.com', 'ffsdsd', 1, '2022-05-07 15:34:35'),
(3, 'CarolMartinez', '77777', 'carlos@info.com', 'dfsfssdf', 1, '2022-05-07 15:35:27'),
(4, 'EscobarInc', '787987', 'lenin.rios@gmail.com', 'sfsdfsd', 1, '2022-05-07 15:36:19'),
(5, 'Securytechs', '7777', 'securytechs@info.com', 'dd', 1, '2022-05-07 15:49:45'),
(6, 'rerere', '9698898', 'lenin.rios@gmail.com', 'fsdfsd', 1, '2022-05-07 15:50:56'),
(7, 'Almacenes el jiron', '787977', 'jiron@info.com', 'Managua', 1, '2022-05-07 16:03:05'),
(8, 'f', 'f', 'ggg@info.com', 'La misma de siempre', 1, '2022-05-07 16:49:05'),
(9, 'Esemismo', '99999999', 'ese@info.com', 'ahi mismoooooo', 2, '2022-05-08 03:13:19'),
(10, 'smartech', '8885587777', 'smartech@info.com', 'Granada, mercado municipal', 1, '2022-05-08 03:23:02'),
(11, 'urbantech', '777777', 'urban@info.com', 'Managua', 1, '2022-05-08 03:23:28'),
(12, 'gdgdgdf', 'gdfgdfgdf', 'lll@info.com', 'fsdfsd', 1, '2022-05-08 05:41:38'),
(13, 'fsdf', 'sfsd', 'zzz@info.com', '123132', 1, '2022-05-08 05:42:36'),
(14, 'asfsa', 'asfsafsassa', 'oopo@info.com', 'fsfsfsd', 1, '2022-05-08 05:49:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` bigint(20) NOT NULL,
  `nombrerol` varchar(50) COLLATE utf8mb4_swedish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `nombrerol`, `descripcion`, `status`) VALUES
(1, 'Administrador', 'Modulo para el administrador del sistema.', 1),
(2, 'Supervisor', 'Rol del Supervisor', 1),
(3, 'Recepcionista', 'Rol correspondiente a Recepcionista.', 1),
(4, 'Vendedor', 'Rol del vendedor', 1),
(5, 'Prueba', 'Rol de Prueba', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `id_tipo` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id_tipo`, `nombre`, `status`, `datecreated`) VALUES
(1, 'Metálico', 1, '2022-05-02 15:41:33'),
(2, 'Aluminio', 1, '2022-05-02 15:41:43');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_listar_usuario`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_listar_usuario` (
`idpersona` bigint(20)
,`identificacion` varchar(30)
,`nombres` varchar(80)
,`apellidos` varchar(100)
,`telefono` bigint(20)
,`email_user` varchar(100)
,`rolid` bigint(20)
,`datecreated` datetime
,`status` int(11)
,`nombrerol` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_ver_proveedores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_ver_proveedores` (
`id_proveedor` int(11)
,`nombres` varchar(150)
,`telefono` varchar(15)
,`correo` varchar(100)
,`status` int(11)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `view_listar_usuario`
--
DROP TABLE IF EXISTS `view_listar_usuario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_listar_usuario`  AS SELECT `persona`.`idpersona` AS `idpersona`, `persona`.`identificacion` AS `identificacion`, `persona`.`nombres` AS `nombres`, `persona`.`apellidos` AS `apellidos`, `persona`.`telefono` AS `telefono`, `persona`.`email_user` AS `email_user`, `persona`.`rolid` AS `rolid`, `persona`.`datecreated` AS `datecreated`, `persona`.`status` AS `status`, `rol`.`nombrerol` AS `nombrerol` FROM (`persona` join `rol` on(`persona`.`rolid` = `rol`.`idrol`)) WHERE `persona`.`status` <> 0 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_ver_proveedores`
--
DROP TABLE IF EXISTS `view_ver_proveedores`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_ver_proveedores`  AS SELECT `proveedores`.`id_proveedor` AS `id_proveedor`, `proveedores`.`nombres` AS `nombres`, `proveedores`.`telefono` AS `telefono`, `proveedores`.`correo` AS `correo`, `proveedores`.`status` AS `status` FROM `proveedores` WHERE `proveedores`.`status` <> 0 ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `detalle_temp_compras`
--
ALTER TABLE `detalle_temp_compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`idmarca`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`idmodulo`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`idpermiso`),
  ADD KEY `rolid` (`rolid`),
  ADD KEY `moduloid` (`moduloid`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`),
  ADD KEY `rolid` (`rolid`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_temp_compras`
--
ALTER TABLE `detalle_temp_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `idmarca` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `idmodulo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idpermiso` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`moduloid`) REFERENCES `modulo` (`idmodulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
