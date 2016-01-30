-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-01-2016 a las 01:35:31
-- Versión del servidor: 10.1.9-MariaDB
-- Versión de PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `act_consecutivo` (IN `ract` INT, IN `rpref` VARCHAR(4))  BEGIN
    UPDATE prefijos SET  actual=ract WHERE prefijo=rpref;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Act_Producto` (IN `rid` INT, IN `rproducto` VARCHAR(50), IN `runidad` INT, IN `rprecio` INT, IN `RRutaImagen` TEXT, OUT `Mensaje` VARCHAR(100))  BEGIN
DECLARE sFoto VARCHAR(100);
SET sFoto=(SELECT RutaImagen FROM productos WHERE id=rid);
	IF(RRutaImagen="")THEN
		SET RRutaImagen=sFoto;
	ELSE
		SET RRutaImagen=RRutaImagen;
	END IF;
	
	IF(NOT EXISTS(SELECT*FROM productos WHERE id=rid))THEN
		SET Mensaje='Este producto no existe.';
	ELSE 
		BEGIN 
			IF(rprecio<1)THEN
				SET Mensaje='Precio de venta no válido.';
			ELSE 
				BEGIN
					UPDATE productos SET    producto=rproducto, precio=rprecio, id_und_medida=runidad, RutaImagen=RRutaImagen WHERE id=rid;
					SET Mensaje='El registro se ha actualizado correctamente.';
				END;
			END IF;
		END;
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Act_Usuario` (IN `rid` INT, IN `rusuario` VARCHAR(50), OUT `Mensaje` VARCHAR(100))  BEGIN
	IF(EXISTS(SELECT * FROM usuarios WHERE usuario=rusuario AND id<>rid))THEN
	SET Mensaje='Usuario no disponible, intente con otro.';
	ELSE
		BEGIN
			UPDATE usuarios SET  usuario=rusuario WHERE id=rid;
			SET Mensaje='Datos actualizados correctamente.';
		END;
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Act_Ventasencabezado` (IN `rid` INT, IN `rcliente` INT, IN `rfecha` DATETIME, OUT `Mensaje` VARCHAR(100))  BEGIN
  	UPDATE encabezado_venta SET id_cliente=rcliente, fecha_venta=rfecha WHERE id = rid;
    SET Mensaje='Datos actualizados correctamente.';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Reg_Producto` (IN `rproducto` VARCHAR(50), IN `runidad` INT, IN `rprecio` INT, IN `RRutaImagen` TEXT, OUT `Mensaje` VARCHAR(100))  BEGIN
	IF(EXISTS(SELECT*FROM productos WHERE producto=rproducto))THEN
		SET Mensaje='Este producto ya existe.';
	ELSE 
		BEGIN 
			IF(rprecio<1)THEN
				SET Mensaje='Precio de venta no válido.';
			ELSE 
				BEGIN
					INSERT INTO productos (producto, precio, id_und_medida, RutaImagen) VALUES (rproducto, rprecio, runidad, RRutaImagen);
					SET Mensaje='Registrado correctamente.';
				END;
			END IF;
		END;
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Reg_Usuario` (IN `rusuario` VARCHAR(40), IN `rpass` VARCHAR(40), OUT `Mensaje` VARCHAR(100))  BEGIN
	IF(EXISTS(SELECT * FROM usuarios WHERE usuario=rusuario))THEN
	SET Mensaje='Usuario no disponible, intente con otro.';
	ELSE
    	BEGIN
        	INSERT INTO usuarios(usuario,pass)
            VALUES(rusuario,rpass);
            SET Mensaje='Datos registrados correctamente.';
		END;
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Reg_Ventasencabezado` (IN `rpref` VARCHAR(4), IN `rnum` INT, IN `rcliente` INT, IN `rforma` INT, IN `rfecha` DATETIME, IN `Mensaje` VARCHAR(100))  BEGIN
	IF(EXISTS(SELECT * FROM encabezado_venta WHERE prefijo=rpref and num_prefijo=rnum))THEN
	SET Mensaje='consecutivo no disponible.';
	ELSE
    	BEGIN
        	INSERT INTO encabezado_venta(prefijo,num_prefijo,id_cliente,forma_pago,fecha_venta)
            VALUES(rpref,rnum,rcliente,rforma,rfecha);
            SET Mensaje='Datos registrados correctamente.';
		END;
	END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abonos`
--

CREATE TABLE `abonos` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `fecha_abono` datetime NOT NULL,
  `valor` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `id` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `ciudad` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `id_tipo_cliente` int(11) NOT NULL,
  `nit` varchar(15) NOT NULL,
  `rucom` varchar(20) NOT NULL,
  `razon_social` varchar(50) NOT NULL,
  `rep_legal` varchar(50) NOT NULL,
  `id_depto` int(11) NOT NULL,
  `id_ciudad` int(11) NOT NULL,
  `telefono1` varchar(20) NOT NULL,
  `telefono2` varchar(20) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `email` varchar(40) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT '1:activo, 2:inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `id_tipo_cliente`, `nit`, `rucom`, `razon_social`, `rep_legal`, `id_depto`, `id_ciudad`, `telefono1`, `telefono2`, `direccion`, `email`, `estado`) VALUES
(1, 1, '1234567899', '123456', 'pruebas sas', 'alfredo gonzales', 1, 1, '1234567', '1234567891', 'calle falsa 123', 'alfredg@pruebassas.com', 1),
(2, 2, '9876543219', '58763', 'la coquita S.A.C', 'guillermo beltran', 1, 1, '1234578', '9845873', 'clle 44 # 32-65', 'lacoqinfo@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL,
  `departamento` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total_detalle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `id_venta`, `id_producto`, `precio`, `cantidad`, `total_detalle`) VALUES
(1, 10, 1, 2000, 4, 8000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encabezado_venta`
--

CREATE TABLE `encabezado_venta` (
  `id` int(11) NOT NULL,
  `prefijo` varchar(4) NOT NULL,
  `num_prefijo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha_venta` datetime NOT NULL,
  `forma_pago` int(1) NOT NULL COMMENT '1:efectivo, 2:credito',
  `estado_venta` int(1) NOT NULL DEFAULT '1' COMMENT '1:pendiente, 2:finalizado',
  `id_placa` int(11) NOT NULL,
  `sub_total_venta` int(10) NOT NULL,
  `descuento_venta` int(10) NOT NULL,
  `iva_venta` int(10) NOT NULL,
  `total_venta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `encabezado_venta`
--

INSERT INTO `encabezado_venta` (`id`, `prefijo`, `num_prefijo`, `id_cliente`, `fecha_venta`, `forma_pago`, `estado_venta`, `id_placa`, `sub_total_venta`, `descuento_venta`, `iva_venta`, `total_venta`) VALUES
(4, 'FAC', 1, 1, '2016-01-29 15:45:24', 1, 1, 0, 0, 0, 0, 0),
(5, 'FAC', 2, 1, '2016-01-29 10:00:25', 1, 1, 0, 0, 0, 0, 0),
(6, 'REM', 1, 1, '2016-01-29 10:00:31', 2, 1, 0, 0, 0, 0, 0),
(7, 'REM', 2, 1, '2016-01-29 10:03:18', 2, 1, 0, 0, 0, 0, 0),
(8, 'REM', 3, 1, '2016-01-29 10:03:39', 2, 1, 0, 0, 0, 0, 0),
(9, 'FAC', 3, 1, '2016-01-29 10:03:49', 1, 1, 0, 0, 0, 0, 0),
(10, 'FAC', 4, 2, '2016-01-29 15:05:31', 1, 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumos`
--

CREATE TABLE `insumos` (
  `id` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `insumo` varchar(40) NOT NULL,
  `fecha_compra` datetime NOT NULL,
  `vr_unitario` int(10) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `id_und_medida` int(11) NOT NULL,
  `vr_total` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iva`
--

CREATE TABLE `iva` (
  `id` int(11) NOT NULL,
  `concepto` varchar(40) NOT NULL,
  `valor` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `iva`
--

INSERT INTO `iva` (`id`, `concepto`, `valor`) VALUES
(1, 'IVA', 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prefijos`
--

CREATE TABLE `prefijos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `prefijo` varchar(4) NOT NULL,
  `inicial` int(11) NOT NULL,
  `actual` int(11) NOT NULL,
  `final` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `prefijos`
--

INSERT INTO `prefijos` (`id`, `nombre`, `prefijo`, `inicial`, `actual`, `final`) VALUES
(1, 'Factura', 'FAC', 1, 5, 5000),
(2, 'Remision', 'REM', 1, 4, 5000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `referencia` varchar(10) NOT NULL,
  `producto` varchar(30) NOT NULL,
  `precio` int(10) NOT NULL,
  `id_und_medida` int(11) NOT NULL,
  `RutaImagen` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `referencia`, `producto`, `precio`, `id_und_medida`, `RutaImagen`) VALUES
(1, '1', 'arena rocosa', 1000, 2, 'ee6d365a1a85791278c4445ca6879506.jpg'),
(2, '', 'arena roja', 1200, 1, '88216e09b9ae4b15953888fdbafa6a74.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `id_tipo_cliente` int(11) NOT NULL,
  `nit` varchar(15) NOT NULL,
  `razon_social` varchar(40) NOT NULL,
  `rep_legal` varchar(40) NOT NULL,
  `id_depto` int(11) NOT NULL,
  `id_ciudad` int(11) NOT NULL,
  `contacto` varchar(40) NOT NULL,
  `numero_contacto` varchar(20) NOT NULL,
  `email_contacto` varchar(40) NOT NULL,
  `direccion` varchar(40) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT '1:activo, 2:inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_clientes`
--

CREATE TABLE `tipo_clientes` (
  `id` int(11) NOT NULL,
  `tipo_cliente` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_clientes`
--

INSERT INTO `tipo_clientes` (`id`, `tipo_cliente`) VALUES
(1, 'Natural'),
(2, 'Juridico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades_medida`
--

CREATE TABLE `unidades_medida` (
  `id` int(11) NOT NULL,
  `unidad_medida` varchar(30) NOT NULL,
  `Simbolo` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `unidades_medida`
--

INSERT INTO `unidades_medida` (`id`, `unidad_medida`, `Simbolo`) VALUES
(1, 'Metro', 'm'),
(2, 'Centimetro', 'cm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `pass`, `estado`) VALUES
(1, 'adminarenera', '827ccb0eea8a706c4c34a16891f84e7b', 1),
(2, 'pruebas', 'ee2ec3cc66427bb422894495068222a8', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `placa` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abonos`
--
ALTER TABLE `abonos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `encabezado_venta`
--
ALTER TABLE `encabezado_venta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `insumos`
--
ALTER TABLE `insumos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `iva`
--
ALTER TABLE `iva`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prefijos`
--
ALTER TABLE `prefijos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_clientes`
--
ALTER TABLE `tipo_clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidades_medida`
--
ALTER TABLE `unidades_medida`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abonos`
--
ALTER TABLE `abonos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `encabezado_venta`
--
ALTER TABLE `encabezado_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `insumos`
--
ALTER TABLE `insumos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `iva`
--
ALTER TABLE `iva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `prefijos`
--
ALTER TABLE `prefijos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipo_clientes`
--
ALTER TABLE `tipo_clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `unidades_medida`
--
ALTER TABLE `unidades_medida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
