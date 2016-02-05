-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-02-2016 a las 00:08:05
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

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`id`, `id_departamento`, `ciudad`) VALUES
(1, 2, 'ABEJORRAL'),
(2, 22, 'ABREGO'),
(3, 2, 'ABRIAQUI'),
(4, 21, 'ACACIAS'),
(5, 13, 'ACANDI'),
(6, 18, 'ACEVEDO'),
(7, 6, 'ACHI'),
(8, 18, 'AGRADO'),
(9, 15, 'AGUA DE DIOS'),
(10, 12, 'AGUACHICA'),
(11, 28, 'AGUADA'),
(12, 8, 'AGUADAS'),
(13, 10, 'AGUAZUL'),
(14, 12, 'AGUSTIN CODAZZI'),
(15, 18, 'AIPE'),
(16, 15, 'ALBAN'),
(17, 23, 'ALBAN'),
(18, 9, 'ALBANIA'),
(19, 19, 'ALBANIA'),
(20, 28, 'ALBANIA'),
(21, 31, 'ALCALA'),
(22, 23, 'ALDANA'),
(23, 2, 'ALEJANDRIA'),
(24, 20, 'ALGARROBO'),
(25, 18, 'ALGECIRAS'),
(26, 11, 'ALMAGUER'),
(27, 7, 'ALMEIDA'),
(28, 30, 'ALPUJARRA'),
(29, 18, 'ALTAMIRA'),
(30, 13, 'ALTO BAUDO'),
(31, 6, 'ALTOS DEL ROSARIO'),
(32, 30, 'ALVARADO'),
(33, 2, 'AMAGA'),
(34, 2, 'AMALFI'),
(35, 30, 'AMBALEMA'),
(36, 15, 'ANAPOIMA'),
(37, 23, 'ANCUYA'),
(38, 31, 'ANDALUCIA'),
(39, 2, 'ANDES'),
(40, 2, 'ANGELOPOLIS'),
(41, 2, 'ANGOSTURA'),
(42, 15, 'ANOLAIMA'),
(43, 2, 'ANORI'),
(44, 8, 'ANSERMA'),
(45, 31, 'ANSERMANUEVO'),
(46, 2, 'ANZA'),
(47, 30, 'ANZOATEGUI'),
(48, 2, 'APARTADO'),
(49, 26, 'APIA'),
(50, 15, 'APULO'),
(51, 7, 'AQUITANIA'),
(52, 20, 'ARACATACA'),
(53, 8, 'ARANZAZU'),
(54, 28, 'ARATOCA'),
(55, 3, 'ARAUCA'),
(56, 3, 'ARAUQUITA'),
(57, 15, 'ARBELAEZ'),
(58, 23, 'ARBOLEDA'),
(59, 22, 'ARBOLEDAS'),
(60, 2, 'ARBOLETES'),
(61, 7, 'ARCABUCO'),
(62, 6, 'ARENAL'),
(63, 2, 'ARGELIA'),
(64, 11, 'ARGELIA'),
(65, 31, 'ARGELIA'),
(66, 20, 'ARIGUANI'),
(67, 6, 'ARJONA'),
(68, 2, 'ARMENIA'),
(69, 25, 'ARMENIA'),
(70, 30, 'ARMERO'),
(71, 6, 'ARROYOHONDO'),
(72, 12, 'ASTREA'),
(73, 30, 'ATACO'),
(74, 13, 'ATRATO'),
(75, 14, 'AYAPEL'),
(76, 13, 'BAGADO'),
(77, 13, 'BAHIA SOLANO'),
(78, 13, 'BAJO BAUDO'),
(79, 11, 'BALBOA'),
(80, 26, 'BALBOA'),
(81, 4, 'BARANOA'),
(82, 18, 'BARAYA'),
(83, 23, 'BARBACOAS'),
(84, 2, 'BARBOSA'),
(85, 28, 'BARBOSA'),
(86, 28, 'BARICHARA'),
(87, 21, 'BARRANCA DE UPIA'),
(88, 28, 'BARRANCABERMEJA'),
(89, 19, 'BARRANCAS'),
(90, 6, 'BARRANCO DE LOBA'),
(91, 16, 'BARRANCO MINAS'),
(92, 4, 'BARRANQUILLA'),
(93, 12, 'BECERRIL'),
(94, 8, 'BELALCAZAR'),
(95, 7, 'BELEN'),
(96, 23, 'BELEN'),
(97, 9, 'BELEN DE LOS ANDAQUIES'),
(98, 26, 'BELEN DE UMBRIA'),
(99, 2, 'BELLO'),
(100, 2, 'BELMIRA'),
(101, 15, 'BELTRAN'),
(102, 7, 'BERBEO'),
(103, 2, 'BETANIA'),
(104, 7, 'BETEITIVA'),
(105, 2, 'BETULIA'),
(106, 28, 'BETULIA'),
(107, 15, 'BITUIMA'),
(108, 7, 'BOAVITA'),
(109, 22, 'BOCHALEMA'),
(110, 5, 'BOGOTA, D.C.'),
(111, 15, 'BOJACA'),
(112, 13, 'BOJAYA'),
(113, 11, 'BOLIVAR'),
(114, 28, 'BOLIVAR'),
(115, 31, 'BOLIVAR'),
(116, 12, 'BOSCONIA'),
(117, 7, 'BOYACA'),
(118, 2, 'BRICEÑO'),
(119, 7, 'BRICEÑO'),
(120, 28, 'BUCARAMANGA'),
(121, 22, 'BUCARASICA'),
(122, 31, 'BUENAVENTURA'),
(123, 7, 'BUENAVISTA'),
(124, 14, 'BUENAVISTA'),
(125, 25, 'BUENAVISTA'),
(126, 29, 'BUENAVISTA'),
(127, 11, 'BUENOS AIRES'),
(128, 23, 'BUESACO'),
(129, 31, 'BUGALAGRANDE'),
(130, 2, 'BURITICA'),
(131, 7, 'BUSBANZA'),
(132, 15, 'CABRERA'),
(133, 28, 'CABRERA'),
(134, 21, 'CABUYARO'),
(135, 16, 'CACAHUAL'),
(136, 2, 'CACERES'),
(137, 15, 'CACHIPAY'),
(138, 22, 'CACHIRA'),
(139, 22, 'CACOTA'),
(140, 2, 'CAICEDO'),
(141, 31, 'CAICEDONIA'),
(142, 29, 'CAIMITO'),
(143, 30, 'CAJAMARCA'),
(144, 11, 'CAJIBIO'),
(145, 15, 'CAJICA'),
(146, 6, 'CALAMAR'),
(147, 17, 'CALAMAR'),
(148, 25, 'CALARCA'),
(149, 2, 'CALDAS'),
(150, 7, 'CALDAS'),
(151, 11, 'CALDONO'),
(152, 31, 'CALI'),
(153, 28, 'CALIFORNIA'),
(154, 31, 'CALIMA'),
(155, 11, 'CALOTO'),
(156, 2, 'CAMPAMENTO'),
(157, 4, 'CAMPO DE LA CRUZ'),
(158, 18, 'CAMPOALEGRE'),
(159, 7, 'CAMPOHERMOSO'),
(160, 14, 'CANALETE'),
(161, 4, 'CANDELARIA'),
(162, 31, 'CANDELARIA'),
(163, 6, 'CANTAGALLO'),
(164, 2, 'CAÑASGORDAS'),
(165, 15, 'CAPARRAPI'),
(166, 28, 'CAPITANEJO'),
(167, 15, 'CAQUEZA'),
(168, 2, 'CARACOLI'),
(169, 2, 'CARAMANTA'),
(170, 28, 'CARCASI'),
(171, 2, 'CAREPA'),
(172, 30, 'CARMEN DE APICALA'),
(173, 15, 'CARMEN DE CARUPA'),
(174, 13, 'CARMEN DEL DARIEN'),
(175, 2, 'CAROLINA'),
(176, 6, 'CARTAGENA'),
(177, 9, 'CARTAGENA DEL CHAIRA'),
(178, 31, 'CARTAGO'),
(179, 32, 'CARURU'),
(180, 30, 'CASABIANCA'),
(181, 21, 'CASTILLA LA NUEVA'),
(182, 2, 'CAUCASIA'),
(183, 28, 'CEPITA'),
(184, 14, 'CERETE'),
(185, 7, 'CERINZA'),
(186, 28, 'CERRITO'),
(187, 20, 'CERRO SAN ANTONIO'),
(188, 13, 'CERTEGUI'),
(189, 23, 'CHACHAGsI'),
(190, 15, 'CHAGUANI'),
(191, 29, 'CHALAN'),
(192, 10, 'CHAMEZA'),
(193, 30, 'CHAPARRAL'),
(194, 28, 'CHARALA'),
(195, 28, 'CHARTA'),
(196, 15, 'CHIA'),
(197, 20, 'CHIBOLO'),
(198, 2, 'CHIGORODO'),
(199, 14, 'CHIMA'),
(200, 28, 'CHIMA'),
(201, 12, 'CHIMICHAGUA'),
(202, 22, 'CHINACOTA'),
(203, 7, 'CHINAVITA'),
(204, 8, 'CHINCHINA'),
(205, 14, 'CHINU'),
(206, 15, 'CHIPAQUE'),
(207, 28, 'CHIPATA'),
(208, 7, 'CHIQUINQUIRA'),
(209, 7, 'CHIQUIZA'),
(210, 12, 'CHIRIGUANA'),
(211, 7, 'CHISCAS'),
(212, 7, 'CHITA'),
(213, 22, 'CHITAGA'),
(214, 7, 'CHITARAQUE'),
(215, 7, 'CHIVATA'),
(216, 7, 'CHIVOR'),
(217, 15, 'CHOACHI'),
(218, 15, 'CHOCONTA'),
(219, 6, 'CICUCO'),
(220, 20, 'CIENAGA'),
(221, 14, 'CIENAGA DE ORO'),
(222, 7, 'CIENEGA'),
(223, 28, 'CIMITARRA'),
(224, 25, 'CIRCASIA'),
(225, 2, 'CISNEROS'),
(226, 2, 'CIUDAD BOLIVAR'),
(227, 6, 'CLEMENCIA'),
(228, 2, 'COCORNA'),
(229, 30, 'COELLO'),
(230, 15, 'COGUA'),
(231, 18, 'COLOMBIA'),
(232, 23, 'COLON'),
(233, 24, 'COLON'),
(234, 29, 'COLOSO'),
(235, 7, 'COMBITA'),
(236, 2, 'CONCEPCION'),
(237, 28, 'CONCEPCION'),
(238, 2, 'CONCORDIA'),
(239, 20, 'CONCORDIA'),
(240, 13, 'CONDOTO'),
(241, 28, 'CONFINES'),
(242, 23, 'CONSACA'),
(243, 23, 'CONTADERO'),
(244, 28, 'CONTRATACION'),
(245, 22, 'CONVENCION'),
(246, 2, 'COPACABANA'),
(247, 7, 'COPER'),
(248, 6, 'CORDOBA'),
(249, 23, 'CORDOBA'),
(250, 25, 'CORDOBA'),
(251, 11, 'CORINTO'),
(252, 28, 'COROMORO'),
(253, 29, 'COROZAL'),
(254, 7, 'CORRALES'),
(255, 15, 'COTA'),
(256, 14, 'COTORRA'),
(257, 7, 'COVARACHIA'),
(258, 29, 'COVEÑAS'),
(259, 30, 'COYAIMA'),
(260, 3, 'CRAVO NORTE'),
(261, 23, 'CUASPUD'),
(262, 7, 'CUBARA'),
(263, 21, 'CUBARRAL'),
(264, 7, 'CUCAITA'),
(265, 15, 'CUCUNUBA'),
(266, 22, 'CUCUTA'),
(267, 22, 'CUCUTILLA'),
(268, 7, 'CUITIVA'),
(269, 21, 'CUMARAL'),
(270, 33, 'CUMARIBO'),
(271, 23, 'CUMBAL'),
(272, 23, 'CUMBITARA'),
(273, 30, 'CUNDAY'),
(274, 9, 'CURILLO'),
(275, 28, 'CURITI'),
(276, 12, 'CURUMANI'),
(277, 2, 'DABEIBA'),
(278, 31, 'DAGUA'),
(279, 19, 'DIBULLA'),
(280, 19, 'DISTRACCION'),
(281, 30, 'DOLORES'),
(282, 2, 'DON MATIAS'),
(283, 26, 'DOSQUEBRADAS'),
(284, 7, 'DUITAMA'),
(285, 22, 'DURANIA'),
(286, 2, 'EBEJICO'),
(287, 31, 'EL AGUILA'),
(288, 2, 'EL BAGRE'),
(289, 20, 'EL BANCO'),
(290, 31, 'EL CAIRO'),
(291, 21, 'EL CALVARIO'),
(292, 13, 'EL CANTON DEL SAN PABLO'),
(293, 22, 'EL CARMEN'),
(294, 13, 'EL CARMEN DE ATRATO'),
(295, 6, 'EL CARMEN DE BOLIVAR'),
(296, 28, 'EL CARMEN DE CHUCURI'),
(297, 2, 'EL CARMEN DE VIBORAL'),
(298, 21, 'EL CASTILLO'),
(299, 31, 'EL CERRITO'),
(300, 23, 'EL CHARCO'),
(301, 7, 'EL COCUY'),
(302, 15, 'EL COLEGIO'),
(303, 12, 'EL COPEY'),
(304, 9, 'EL DONCELLO'),
(305, 21, 'EL DORADO'),
(306, 31, 'EL DOVIO'),
(307, 1, 'EL ENCANTO'),
(308, 7, 'EL ESPINO'),
(309, 28, 'EL GUACAMAYO'),
(310, 6, 'EL GUAMO'),
(311, 13, 'EL LITORAL DEL SAN JUAN'),
(312, 19, 'EL MOLINO'),
(313, 12, 'EL PASO'),
(314, 9, 'EL PAUJIL'),
(315, 23, 'EL PEÑOL'),
(316, 6, 'EL PEÑON'),
(317, 15, 'EL PEÑON'),
(318, 28, 'EL PEÑON'),
(319, 20, 'EL PIÑON'),
(320, 28, 'EL PLAYON'),
(321, 20, 'EL RETEN'),
(322, 17, 'EL RETORNO'),
(323, 29, 'EL ROBLE'),
(324, 15, 'EL ROSAL'),
(325, 23, 'EL ROSARIO'),
(326, 2, 'EL SANTUARIO'),
(327, 23, 'EL TABLON DE GOMEZ'),
(328, 11, 'EL TAMBO'),
(329, 23, 'EL TAMBO'),
(330, 22, 'EL TARRA'),
(331, 22, 'EL ZULIA'),
(332, 18, 'ELIAS'),
(333, 28, 'ENCINO'),
(334, 28, 'ENCISO'),
(335, 2, 'ENTRERRIOS'),
(336, 2, 'ENVIGADO'),
(337, 30, 'ESPINAL'),
(338, 15, 'FACATATIVA'),
(339, 30, 'FALAN'),
(340, 8, 'FILADELFIA'),
(341, 25, 'FILANDIA'),
(342, 7, 'FIRAVITOBA'),
(343, 30, 'FLANDES'),
(344, 9, 'FLORENCIA'),
(345, 11, 'FLORENCIA'),
(346, 7, 'FLORESTA'),
(347, 28, 'FLORIAN'),
(348, 31, 'FLORIDA'),
(349, 28, 'FLORIDABLANCA'),
(350, 15, 'FOMEQUE'),
(351, 19, 'FONSECA'),
(352, 3, 'FORTUL'),
(353, 15, 'FOSCA'),
(354, 23, 'FRANCISCO PIZARRO'),
(355, 2, 'FREDONIA'),
(356, 30, 'FRESNO'),
(357, 2, 'FRONTINO'),
(358, 21, 'FUENTE DE ORO'),
(359, 20, 'FUNDACION'),
(360, 23, 'FUNES'),
(361, 15, 'FUNZA'),
(362, 15, 'FUQUENE'),
(363, 15, 'FUSAGASUGA'),
(364, 15, 'GACHALA'),
(365, 15, 'GACHANCIPA'),
(366, 7, 'GACHANTIVA'),
(367, 15, 'GACHETA'),
(368, 28, 'GALAN'),
(369, 4, 'GALAPA'),
(370, 29, 'GALERAS'),
(371, 15, 'GAMA'),
(372, 12, 'GAMARRA'),
(373, 28, 'GAMBITA'),
(374, 7, 'GAMEZA'),
(375, 7, 'GARAGOA'),
(376, 18, 'GARZON'),
(377, 25, 'GENOVA'),
(378, 18, 'GIGANTE'),
(379, 31, 'GINEBRA'),
(380, 2, 'GIRALDO'),
(381, 15, 'GIRARDOT'),
(382, 2, 'GIRARDOTA'),
(383, 28, 'GIRON'),
(384, 2, 'GOMEZ PLATA'),
(385, 12, 'GONZALEZ'),
(386, 22, 'GRAMALOTE'),
(387, 2, 'GRANADA'),
(388, 15, 'GRANADA'),
(389, 21, 'GRANADA'),
(390, 28, 'GsEPSA'),
(391, 7, 'GsICAN'),
(392, 28, 'GUACA'),
(393, 7, 'GUACAMAYAS'),
(394, 31, 'GUACARI'),
(395, 11, 'GUACHENE'),
(396, 15, 'GUACHETA'),
(397, 23, 'GUACHUCAL'),
(398, 31, 'GUADALAJARA DE BUGA'),
(399, 2, 'GUADALUPE'),
(400, 18, 'GUADALUPE'),
(401, 28, 'GUADALUPE'),
(402, 15, 'GUADUAS'),
(403, 23, 'GUAITARILLA'),
(404, 23, 'GUALMATAN'),
(405, 20, 'GUAMAL'),
(406, 21, 'GUAMAL'),
(407, 30, 'GUAMO'),
(408, 11, 'GUAPI'),
(409, 28, 'GUAPOTA'),
(410, 29, 'GUARANDA'),
(411, 2, 'GUARNE'),
(412, 15, 'GUASCA'),
(413, 2, 'GUATAPE'),
(414, 15, 'GUATAQUI'),
(415, 15, 'GUATAVITA'),
(416, 7, 'GUATEQUE'),
(417, 26, 'GUATICA'),
(418, 28, 'GUAVATA'),
(419, 15, 'GUAYABAL DE SIQUIMA'),
(420, 15, 'GUAYABETAL'),
(421, 7, 'GUAYATA'),
(422, 15, 'GUTIERREZ'),
(423, 22, 'HACARI'),
(424, 6, 'HATILLO DE LOBA'),
(425, 28, 'HATO'),
(426, 10, 'HATO COROZAL'),
(427, 19, 'HATONUEVO'),
(428, 2, 'HELICONIA'),
(429, 22, 'HERRAN'),
(430, 30, 'HERVEO'),
(431, 2, 'HISPANIA'),
(432, 18, 'HOBO'),
(433, 30, 'HONDA'),
(434, 30, 'IBAGUE'),
(435, 30, 'ICONONZO'),
(436, 23, 'ILES'),
(437, 23, 'IMUES'),
(438, 16, 'INIRIDA'),
(439, 11, 'INZA'),
(440, 23, 'IPIALES'),
(441, 18, 'IQUIRA'),
(442, 18, 'ISNOS'),
(443, 13, 'ISTMINA'),
(444, 2, 'ITAGUI'),
(445, 2, 'ITUANGO'),
(446, 7, 'IZA'),
(447, 11, 'JAMBALO'),
(448, 31, 'JAMUNDI'),
(449, 2, 'JARDIN'),
(450, 7, 'JENESANO'),
(451, 2, 'JERICO'),
(452, 7, 'JERICO'),
(453, 15, 'JERUSALEN'),
(454, 28, 'JESUS MARIA'),
(455, 28, 'JORDAN'),
(456, 4, 'JUAN DE ACOSTA'),
(457, 15, 'JUNIN'),
(458, 13, 'JURADO'),
(459, 14, 'LA APARTADA'),
(460, 18, 'LA ARGENTINA'),
(461, 28, 'LA BELLEZA'),
(462, 15, 'LA CALERA'),
(463, 7, 'LA CAPILLA'),
(464, 2, 'LA CEJA'),
(465, 26, 'LA CELIA'),
(466, 1, 'LA CHORRERA'),
(467, 23, 'LA CRUZ'),
(468, 31, 'LA CUMBRE'),
(469, 8, 'LA DORADA'),
(470, 22, 'LA ESPERANZA'),
(471, 2, 'LA ESTRELLA'),
(472, 23, 'LA FLORIDA'),
(473, 12, 'LA GLORIA'),
(474, 16, 'LA GUADALUPE'),
(475, 12, 'LA JAGUA DE IBIRICO'),
(476, 19, 'LA JAGUA DEL PILAR'),
(477, 23, 'LA LLANADA'),
(478, 21, 'LA MACARENA'),
(479, 8, 'LA MERCED'),
(480, 15, 'LA MESA'),
(481, 9, 'LA MONTAÑITA'),
(482, 15, 'LA PALMA'),
(483, 12, 'LA PAZ'),
(484, 28, 'LA PAZ'),
(485, 1, 'LA PEDRERA'),
(486, 15, 'LA PEÑA'),
(487, 2, 'LA PINTADA'),
(488, 18, 'LA PLATA'),
(489, 22, 'LA PLAYA'),
(490, 33, 'LA PRIMAVERA'),
(491, 10, 'LA SALINA'),
(492, 11, 'LA SIERRA'),
(493, 25, 'LA TEBAIDA'),
(494, 23, 'LA TOLA'),
(495, 2, 'LA UNION'),
(496, 23, 'LA UNION'),
(497, 29, 'LA UNION'),
(498, 31, 'LA UNION'),
(499, 7, 'LA UVITA'),
(500, 11, 'LA VEGA'),
(501, 15, 'LA VEGA'),
(502, 7, 'LA VICTORIA'),
(503, 31, 'LA VICTORIA'),
(504, 1, 'LA VICTORIA'),
(505, 26, 'LA VIRGINIA'),
(506, 22, 'LABATECA'),
(507, 7, 'LABRANZAGRANDE'),
(508, 28, 'LANDAZURI'),
(509, 28, 'LEBRIJA'),
(510, 24, 'LEGUIZAMO'),
(511, 23, 'LEIVA'),
(512, 21, 'LEJANIAS'),
(513, 15, 'LENGUAZAQUE'),
(514, 30, 'LERIDA'),
(515, 1, 'LETICIA'),
(516, 30, 'LIBANO'),
(517, 2, 'LIBORINA'),
(518, 23, 'LINARES'),
(519, 13, 'LLORO'),
(520, 11, 'LOPEZ'),
(521, 14, 'LORICA'),
(522, 23, 'LOS ANDES'),
(523, 14, 'LOS CORDOBAS'),
(524, 29, 'LOS PALMITOS'),
(525, 22, 'LOS PATIOS'),
(526, 28, 'LOS SANTOS'),
(527, 22, 'LOURDES'),
(528, 4, 'LURUACO'),
(529, 7, 'MACANAL'),
(530, 28, 'MACARAVITA'),
(531, 2, 'MACEO'),
(532, 15, 'MACHETA'),
(533, 15, 'MADRID'),
(534, 6, 'MAGANGUE'),
(535, 23, 'MAGsI'),
(536, 6, 'MAHATES'),
(537, 19, 'MAICAO'),
(538, 29, 'MAJAGUAL'),
(539, 28, 'MALAGA'),
(540, 4, 'MALAMBO'),
(541, 23, 'MALLAMA'),
(542, 4, 'MANATI'),
(543, 12, 'MANAURE'),
(544, 19, 'MANAURE'),
(545, 10, 'MANI'),
(546, 8, 'MANIZALES'),
(547, 15, 'MANTA'),
(548, 8, 'MANZANARES'),
(549, 21, 'MAPIRIPAN'),
(550, 16, 'MAPIRIPANA'),
(551, 6, 'MARGARITA'),
(552, 6, 'MARIA LA BAJA'),
(553, 2, 'MARINILLA'),
(554, 7, 'MARIPI'),
(555, 30, 'MARIQUITA'),
(556, 8, 'MARMATO'),
(557, 8, 'MARQUETALIA'),
(558, 26, 'MARSELLA'),
(559, 8, 'MARULANDA'),
(560, 28, 'MATANZA'),
(561, 2, 'MEDELLIN'),
(562, 15, 'MEDINA'),
(563, 13, 'MEDIO ATRATO'),
(564, 13, 'MEDIO BAUDO'),
(565, 13, 'MEDIO SAN JUAN'),
(566, 30, 'MELGAR'),
(567, 11, 'MERCADERES'),
(568, 21, 'MESETAS'),
(569, 9, 'MILAN'),
(570, 7, 'MIRAFLORES'),
(571, 17, 'MIRAFLORES'),
(572, 11, 'MIRANDA'),
(573, 1, 'MIRITI - PARANA'),
(574, 26, 'MISTRATO'),
(575, 32, 'MITU'),
(576, 24, 'MOCOA'),
(577, 28, 'MOGOTES'),
(578, 28, 'MOLAGAVITA'),
(579, 14, 'MOMIL'),
(580, 6, 'MOMPOS'),
(581, 7, 'MONGUA'),
(582, 7, 'MONGUI'),
(583, 7, 'MONIQUIRA'),
(584, 2, 'MONTEBELLO'),
(585, 6, 'MONTECRISTO'),
(586, 14, 'MONTELIBANO'),
(587, 25, 'MONTENEGRO'),
(588, 14, 'MONTERIA'),
(589, 10, 'MONTERREY'),
(590, 14, 'MOÑITOS'),
(591, 6, 'MORALES'),
(592, 11, 'MORALES'),
(593, 9, 'MORELIA'),
(594, 16, 'MORICHAL'),
(595, 29, 'MORROA'),
(596, 15, 'MOSQUERA'),
(597, 23, 'MOSQUERA'),
(598, 7, 'MOTAVITA'),
(599, 30, 'MURILLO'),
(600, 2, 'MURINDO'),
(601, 2, 'MUTATA'),
(602, 22, 'MUTISCUA'),
(603, 7, 'MUZO'),
(604, 2, 'NARIÑO'),
(605, 15, 'NARIÑO'),
(606, 23, 'NARIÑO'),
(607, 18, 'NATAGA'),
(608, 30, 'NATAGAIMA'),
(609, 2, 'NECHI'),
(610, 2, 'NECOCLI'),
(611, 8, 'NEIRA'),
(612, 18, 'NEIVA'),
(613, 15, 'NEMOCON'),
(614, 15, 'NILO'),
(615, 15, 'NIMAIMA'),
(616, 7, 'NOBSA'),
(617, 15, 'NOCAIMA'),
(618, 8, 'NORCASIA'),
(619, 6, 'NOROSI'),
(620, 13, 'NOVITA'),
(621, 20, 'NUEVA GRANADA'),
(622, 7, 'NUEVO COLON'),
(623, 10, 'NUNCHIA'),
(624, 13, 'NUQUI'),
(625, 31, 'OBANDO'),
(626, 28, 'OCAMONTE'),
(627, 22, 'OCAÑA'),
(628, 28, 'OIBA'),
(629, 7, 'OICATA'),
(630, 2, 'OLAYA'),
(631, 23, 'OLAYA HERRERA'),
(632, 28, 'ONZAGA'),
(633, 18, 'OPORAPA'),
(634, 24, 'ORITO'),
(635, 10, 'OROCUE'),
(636, 30, 'ORTEGA'),
(637, 23, 'OSPINA'),
(638, 7, 'OTANCHE'),
(639, 29, 'OVEJAS'),
(640, 7, 'PACHAVITA'),
(641, 15, 'PACHO'),
(642, 32, 'PACOA'),
(643, 8, 'PACORA'),
(644, 11, 'PADILLA'),
(645, 7, 'PAEZ'),
(646, 11, 'PAEZ'),
(647, 18, 'PAICOL'),
(648, 12, 'PAILITAS'),
(649, 15, 'PAIME'),
(650, 7, 'PAIPA'),
(651, 7, 'PAJARITO'),
(652, 18, 'PALERMO'),
(653, 8, 'PALESTINA'),
(654, 18, 'PALESTINA'),
(655, 28, 'PALMAR'),
(656, 4, 'PALMAR DE VARELA'),
(657, 28, 'PALMAS DEL SOCORRO'),
(658, 31, 'PALMIRA'),
(659, 29, 'PALMITO'),
(660, 30, 'PALOCABILDO'),
(661, 22, 'PAMPLONA'),
(662, 22, 'PAMPLONITA'),
(663, 16, 'PANA PANA'),
(664, 15, 'PANDI'),
(665, 7, 'PANQUEBA'),
(666, 32, 'PAPUNAUA'),
(667, 28, 'PARAMO'),
(668, 15, 'PARATEBUENO'),
(669, 15, 'PASCA'),
(670, 23, 'PASTO'),
(671, 11, 'PATIA'),
(672, 7, 'PAUNA'),
(673, 7, 'PAYA'),
(674, 10, 'PAZ DE ARIPORO'),
(675, 7, 'PAZ DE RIO'),
(676, 2, 'PEÐOL'),
(677, 20, 'PEDRAZA'),
(678, 12, 'PELAYA'),
(679, 8, 'PENSILVANIA'),
(680, 2, 'PEQUE'),
(681, 26, 'PEREIRA'),
(682, 7, 'PESCA'),
(683, 11, 'PIAMONTE'),
(684, 28, 'PIEDECUESTA'),
(685, 30, 'PIEDRAS'),
(686, 11, 'PIENDAMO'),
(687, 25, 'PIJAO'),
(688, 20, 'PIJIÑO DEL CARMEN'),
(689, 28, 'PINCHOTE'),
(690, 6, 'PINILLOS'),
(691, 4, 'PIOJO'),
(692, 7, 'PISBA'),
(693, 18, 'PITAL'),
(694, 18, 'PITALITO'),
(695, 20, 'PIVIJAY'),
(696, 30, 'PLANADAS'),
(697, 14, 'PLANETA RICA'),
(698, 20, 'PLATO'),
(699, 23, 'POLICARPA'),
(700, 4, 'POLONUEVO'),
(701, 4, 'PONEDERA'),
(702, 11, 'POPAYAN'),
(703, 10, 'PORE'),
(704, 23, 'POTOSI'),
(705, 31, 'PRADERA'),
(706, 30, 'PRADO'),
(707, 23, 'PROVIDENCIA'),
(708, 27, 'PROVIDENCIA'),
(709, 12, 'PUEBLO BELLO'),
(710, 14, 'PUEBLO NUEVO'),
(711, 26, 'PUEBLO RICO'),
(712, 2, 'PUEBLORRICO'),
(713, 20, 'PUEBLOVIEJO'),
(714, 28, 'PUENTE NACIONAL'),
(715, 23, 'PUERRES'),
(716, 1, 'PUERTO ALEGRIA'),
(717, 1, 'PUERTO ARICA'),
(718, 24, 'PUERTO ASIS'),
(719, 2, 'PUERTO BERRIO'),
(720, 7, 'PUERTO BOYACA'),
(721, 24, 'PUERTO CAICEDO'),
(722, 33, 'PUERTO CARREÑO'),
(723, 4, 'PUERTO COLOMBIA'),
(724, 16, 'PUERTO COLOMBIA'),
(725, 21, 'PUERTO CONCORDIA'),
(726, 14, 'PUERTO ESCONDIDO'),
(727, 21, 'PUERTO GAITAN'),
(728, 24, 'PUERTO GUZMAN'),
(729, 14, 'PUERTO LIBERTADOR'),
(730, 21, 'PUERTO LLERAS'),
(731, 21, 'PUERTO LOPEZ'),
(732, 2, 'PUERTO NARE'),
(733, 1, 'PUERTO NARIÑO'),
(734, 28, 'PUERTO PARRA'),
(735, 9, 'PUERTO RICO'),
(736, 21, 'PUERTO RICO'),
(737, 3, 'PUERTO RONDON'),
(738, 15, 'PUERTO SALGAR'),
(739, 22, 'PUERTO SANTANDER'),
(740, 1, 'PUERTO SANTANDER'),
(741, 11, 'PUERTO TEJADA'),
(742, 2, 'PUERTO TRIUNFO'),
(743, 28, 'PUERTO WILCHES'),
(744, 15, 'PULI'),
(745, 23, 'PUPIALES'),
(746, 11, 'PURACE'),
(747, 30, 'PURIFICACION'),
(748, 14, 'PURISIMA'),
(749, 15, 'QUEBRADANEGRA'),
(750, 15, 'QUETAME'),
(751, 13, 'QUIBDO'),
(752, 25, 'QUIMBAYA'),
(753, 26, 'QUINCHIA'),
(754, 7, 'QUIPAMA'),
(755, 15, 'QUIPILE'),
(756, 22, 'RAGONVALIA'),
(757, 7, 'RAMIRIQUI'),
(758, 7, 'RAQUIRA'),
(759, 10, 'RECETOR'),
(760, 6, 'REGIDOR'),
(761, 2, 'REMEDIOS'),
(762, 20, 'REMOLINO'),
(763, 4, 'REPELON'),
(764, 21, 'RESTREPO'),
(765, 31, 'RESTREPO'),
(766, 2, 'RETIRO'),
(767, 15, 'RICAURTE'),
(768, 23, 'RICAURTE'),
(769, 12, 'RIO DE ORO'),
(770, 13, 'RIO IRO'),
(771, 13, 'RIO QUITO'),
(772, 6, 'RIO VIEJO'),
(773, 30, 'RIOBLANCO'),
(774, 31, 'RIOFRIO'),
(775, 19, 'RIOHACHA'),
(776, 2, 'RIONEGRO'),
(777, 28, 'RIONEGRO'),
(778, 8, 'RIOSUCIO'),
(779, 13, 'RIOSUCIO'),
(780, 8, 'RISARALDA'),
(781, 18, 'RIVERA'),
(782, 23, 'ROBERTO PAYAN'),
(783, 31, 'ROLDANILLO'),
(784, 30, 'RONCESVALLES'),
(785, 7, 'RONDON'),
(786, 11, 'ROSAS'),
(787, 30, 'ROVIRA'),
(788, 28, 'SABANA DE TORRES'),
(789, 4, 'SABANAGRANDE'),
(790, 2, 'SABANALARGA'),
(791, 4, 'SABANALARGA'),
(792, 10, 'SABANALARGA'),
(793, 20, 'SABANAS DE SAN ANGEL'),
(794, 2, 'SABANETA'),
(795, 7, 'SABOYA'),
(796, 10, 'SACAMA'),
(797, 7, 'SACHICA'),
(798, 14, 'SAHAGUN'),
(799, 18, 'SALADOBLANCO'),
(800, 8, 'SALAMINA'),
(801, 20, 'SALAMINA'),
(802, 22, 'SALAZAR'),
(803, 30, 'SALDAÑA'),
(804, 25, 'SALENTO'),
(805, 2, 'SALGAR'),
(806, 7, 'SAMACA'),
(807, 8, 'SAMANA'),
(808, 23, 'SAMANIEGO'),
(809, 29, 'SAMPUES'),
(810, 18, 'SAN AGUSTIN'),
(811, 12, 'SAN ALBERTO'),
(812, 28, 'SAN ANDRES'),
(813, 27, 'SAN ANDRES'),
(814, 2, 'SAN ANDRES DE CUERQUIA'),
(815, 23, 'SAN ANDRES DE TUMACO'),
(816, 14, 'SAN ANDRES SOTAVENTO'),
(817, 14, 'SAN ANTERO'),
(818, 30, 'SAN ANTONIO'),
(819, 15, 'SAN ANTONIO DEL TEQUENDAMA'),
(820, 28, 'SAN BENITO'),
(821, 29, 'SAN BENITO ABAD'),
(822, 15, 'SAN BERNARDO'),
(823, 23, 'SAN BERNARDO'),
(824, 14, 'SAN BERNARDO DEL VIENTO'),
(825, 22, 'SAN CALIXTO'),
(826, 2, 'SAN CARLOS'),
(827, 14, 'SAN CARLOS'),
(828, 21, 'SAN CARLOS DE GUAROA'),
(829, 15, 'SAN CAYETANO'),
(830, 22, 'SAN CAYETANO'),
(831, 6, 'SAN CRISTOBAL'),
(832, 12, 'SAN DIEGO'),
(833, 7, 'SAN EDUARDO'),
(834, 6, 'SAN ESTANISLAO'),
(835, 16, 'SAN FELIPE'),
(836, 6, 'SAN FERNANDO'),
(837, 2, 'SAN FRANCISCO'),
(838, 15, 'SAN FRANCISCO'),
(839, 24, 'SAN FRANCISCO'),
(840, 28, 'SAN GIL'),
(841, 6, 'SAN JACINTO'),
(842, 6, 'SAN JACINTO DEL CAUCA'),
(843, 2, 'SAN JERONIMO'),
(844, 28, 'SAN JOAQUIN'),
(845, 8, 'SAN JOSE'),
(846, 2, 'SAN JOSE DE LA MONTAÑA'),
(847, 28, 'SAN JOSE DE MIRANDA'),
(848, 7, 'SAN JOSE DE PARE'),
(849, 9, 'SAN JOSE DEL FRAGUA'),
(850, 17, 'SAN JOSE DEL GUAVIARE'),
(851, 13, 'SAN JOSE DEL PALMAR'),
(852, 21, 'SAN JUAN DE ARAMA'),
(853, 29, 'SAN JUAN DE BETULIA'),
(854, 15, 'SAN JUAN DE RIO SECO'),
(855, 2, 'SAN JUAN DE URABA'),
(856, 19, 'SAN JUAN DEL CESAR'),
(857, 6, 'SAN JUAN NEPOMUCENO'),
(858, 21, 'SAN JUANITO'),
(859, 23, 'SAN LORENZO'),
(860, 2, 'SAN LUIS'),
(861, 30, 'SAN LUIS'),
(862, 7, 'SAN LUIS DE GACENO'),
(863, 10, 'SAN LUIS DE PALENQUE'),
(864, 29, 'SAN LUIS DE SINCE'),
(865, 29, 'SAN MARCOS'),
(866, 12, 'SAN MARTIN'),
(867, 21, 'SAN MARTIN'),
(868, 6, 'SAN MARTIN DE LOBA'),
(869, 7, 'SAN MATEO'),
(870, 28, 'SAN MIGUEL'),
(871, 24, 'SAN MIGUEL'),
(872, 7, 'SAN MIGUEL DE SEMA'),
(873, 29, 'SAN ONOFRE'),
(874, 6, 'SAN PABLO'),
(875, 23, 'SAN PABLO'),
(876, 7, 'SAN PABLO DE BORBUR'),
(877, 2, 'SAN PEDRO'),
(878, 29, 'SAN PEDRO'),
(879, 31, 'SAN PEDRO'),
(880, 23, 'SAN PEDRO DE CARTAGO'),
(881, 2, 'SAN PEDRO DE URABA'),
(882, 14, 'SAN PELAYO'),
(883, 2, 'SAN RAFAEL'),
(884, 2, 'SAN ROQUE'),
(885, 11, 'SAN SEBASTIAN'),
(886, 20, 'SAN SEBASTIAN DE BUENAVISTA'),
(887, 2, 'SAN VICENTE'),
(888, 28, 'SAN VICENTE DE CHUCURI'),
(889, 9, 'SAN VICENTE DEL CAGUAN'),
(890, 20, 'SAN ZENON'),
(891, 23, 'SANDONA'),
(892, 20, 'SANTA ANA'),
(893, 2, 'SANTA BARBARA'),
(894, 23, 'SANTA BARBARA'),
(895, 28, 'SANTA BARBARA'),
(896, 20, 'SANTA BARBARA DE PINTO'),
(897, 6, 'SANTA CATALINA'),
(898, 28, 'SANTA HELENA DEL OPON'),
(899, 30, 'SANTA ISABEL'),
(900, 4, 'SANTA LUCIA'),
(901, 7, 'SANTA MARIA'),
(902, 18, 'SANTA MARIA'),
(903, 20, 'SANTA MARTA'),
(904, 6, 'SANTA ROSA'),
(905, 11, 'SANTA ROSA'),
(906, 26, 'SANTA ROSA DE CABAL'),
(907, 2, 'SANTA ROSA DE OSOS'),
(908, 7, 'SANTA ROSA DE VITERBO'),
(909, 6, 'SANTA ROSA DEL SUR'),
(910, 33, 'SANTA ROSALIA'),
(911, 7, 'SANTA SOFIA'),
(912, 23, 'SANTACRUZ'),
(913, 2, 'SANTAFE DE ANTIOQUIA'),
(914, 7, 'SANTANA'),
(915, 11, 'SANTANDER DE QUILICHAO'),
(916, 22, 'SANTIAGO'),
(917, 24, 'SANTIAGO'),
(918, 29, 'SANTIAGO DE TOLU'),
(919, 2, 'SANTO DOMINGO'),
(920, 4, 'SANTO TOMAS'),
(921, 26, 'SANTUARIO'),
(922, 23, 'SAPUYES'),
(923, 3, 'SARAVENA'),
(924, 22, 'SARDINATA'),
(925, 15, 'SASAIMA'),
(926, 7, 'SATIVANORTE'),
(927, 7, 'SATIVASUR'),
(928, 2, 'SEGOVIA'),
(929, 15, 'SESQUILE'),
(930, 31, 'SEVILLA'),
(931, 7, 'SIACHOQUE'),
(932, 15, 'SIBATE'),
(933, 24, 'SIBUNDOY'),
(934, 22, 'SILOS'),
(935, 15, 'SILVANIA'),
(936, 11, 'SILVIA'),
(937, 28, 'SIMACOTA'),
(938, 15, 'SIMIJACA'),
(939, 6, 'SIMITI'),
(940, 29, 'SINCELEJO'),
(941, 13, 'SIPI'),
(942, 20, 'SITIONUEVO'),
(943, 15, 'SOACHA'),
(944, 7, 'SOATA'),
(945, 7, 'SOCHA'),
(946, 28, 'SOCORRO'),
(947, 7, 'SOCOTA'),
(948, 7, 'SOGAMOSO'),
(949, 9, 'SOLANO'),
(950, 4, 'SOLEDAD'),
(951, 9, 'SOLITA'),
(952, 7, 'SOMONDOCO'),
(953, 2, 'SONSON'),
(954, 2, 'SOPETRAN'),
(955, 6, 'SOPLAVIENTO'),
(956, 15, 'SOPO'),
(957, 7, 'SORA'),
(958, 7, 'SORACA'),
(959, 7, 'SOTAQUIRA'),
(960, 11, 'SOTARA'),
(961, 28, 'SUAITA'),
(962, 4, 'SUAN'),
(963, 11, 'SUAREZ'),
(964, 30, 'SUAREZ'),
(965, 18, 'SUAZA'),
(966, 15, 'SUBACHOQUE'),
(967, 11, 'SUCRE'),
(968, 28, 'SUCRE'),
(969, 29, 'SUCRE'),
(970, 15, 'SUESCA'),
(971, 15, 'SUPATA'),
(972, 8, 'SUPIA'),
(973, 28, 'SURATA'),
(974, 15, 'SUSA'),
(975, 7, 'SUSACON'),
(976, 7, 'SUTAMARCHAN'),
(977, 15, 'SUTATAUSA'),
(978, 7, 'SUTATENZA'),
(979, 15, 'TABIO'),
(980, 13, 'TADO'),
(981, 6, 'TALAIGUA NUEVO'),
(982, 12, 'TAMALAMEQUE'),
(983, 10, 'TAMARA'),
(984, 3, 'TAME'),
(985, 2, 'TAMESIS'),
(986, 23, 'TAMINANGO'),
(987, 23, 'TANGUA'),
(988, 32, 'TARAIRA'),
(989, 1, 'TARAPACA'),
(990, 2, 'TARAZA'),
(991, 18, 'TARQUI'),
(992, 2, 'TARSO'),
(993, 7, 'TASCO'),
(994, 10, 'TAURAMENA'),
(995, 15, 'TAUSA'),
(996, 18, 'TELLO'),
(997, 15, 'TENA'),
(998, 20, 'TENERIFE'),
(999, 15, 'TENJO'),
(1000, 7, 'TENZA'),
(1001, 22, 'TEORAMA'),
(1002, 18, 'TERUEL'),
(1003, 18, 'TESALIA'),
(1004, 15, 'TIBACUY'),
(1005, 7, 'TIBANA'),
(1006, 7, 'TIBASOSA'),
(1007, 15, 'TIBIRITA'),
(1008, 22, 'TIBU'),
(1009, 14, 'TIERRALTA'),
(1010, 18, 'TIMANA'),
(1011, 11, 'TIMBIO'),
(1012, 11, 'TIMBIQUI'),
(1013, 7, 'TINJACA'),
(1014, 7, 'TIPACOQUE'),
(1015, 6, 'TIQUISIO'),
(1016, 2, 'TITIRIBI'),
(1017, 7, 'TOCA'),
(1018, 15, 'TOCAIMA'),
(1019, 15, 'TOCANCIPA'),
(1020, 7, 'TOGsI'),
(1021, 2, 'TOLEDO'),
(1022, 22, 'TOLEDO'),
(1023, 29, 'TOLU VIEJO'),
(1024, 28, 'TONA'),
(1025, 7, 'TOPAGA'),
(1026, 15, 'TOPAIPI'),
(1027, 11, 'TORIBIO'),
(1028, 31, 'TORO'),
(1029, 7, 'TOTA'),
(1030, 11, 'TOTORO'),
(1031, 10, 'TRINIDAD'),
(1032, 31, 'TRUJILLO'),
(1033, 4, 'TUBARA'),
(1034, 31, 'TULUA'),
(1035, 7, 'TUNJA'),
(1036, 7, 'TUNUNGUA'),
(1037, 23, 'TUQUERRES'),
(1038, 6, 'TURBACO'),
(1039, 6, 'TURBANA'),
(1040, 2, 'TURBO'),
(1041, 7, 'TURMEQUE'),
(1042, 7, 'TUTA'),
(1043, 7, 'TUTAZA'),
(1044, 15, 'UBALA'),
(1045, 15, 'UBAQUE'),
(1046, 31, 'ULLOA'),
(1047, 7, 'UMBITA'),
(1048, 15, 'UNE'),
(1049, 13, 'UNGUIA'),
(1050, 13, 'UNION PANAMERICANA'),
(1051, 2, 'URAMITA'),
(1052, 21, 'URIBE'),
(1053, 19, 'URIBIA'),
(1054, 2, 'URRAO'),
(1055, 19, 'URUMITA'),
(1056, 4, 'USIACURI'),
(1057, 15, 'UTICA'),
(1058, 2, 'VALDIVIA'),
(1059, 14, 'VALENCIA'),
(1060, 28, 'VALLE DE SAN JOSE'),
(1061, 30, 'VALLE DE SAN JUAN'),
(1062, 24, 'VALLE DEL GUAMUEZ'),
(1063, 12, 'VALLEDUPAR'),
(1064, 2, 'VALPARAISO'),
(1065, 9, 'VALPARAISO'),
(1066, 2, 'VEGACHI'),
(1067, 28, 'VELEZ'),
(1068, 30, 'VENADILLO'),
(1069, 2, 'VENECIA'),
(1070, 15, 'VENECIA'),
(1071, 7, 'VENTAQUEMADA'),
(1072, 15, 'VERGARA'),
(1073, 31, 'VERSALLES'),
(1074, 28, 'VETAS'),
(1075, 15, 'VIANI'),
(1076, 8, 'VICTORIA'),
(1077, 2, 'VIGIA DEL FUERTE'),
(1078, 31, 'VIJES'),
(1079, 22, 'VILLA CARO'),
(1080, 7, 'VILLA DE LEYVA'),
(1081, 15, 'VILLA DE SAN DIEGO DE UBATE'),
(1082, 22, 'VILLA DEL ROSARIO'),
(1083, 11, 'VILLA RICA'),
(1084, 24, 'VILLAGARZON'),
(1085, 15, 'VILLAGOMEZ'),
(1086, 30, 'VILLAHERMOSA'),
(1087, 8, 'VILLAMARIA'),
(1088, 6, 'VILLANUEVA'),
(1089, 19, 'VILLANUEVA'),
(1090, 28, 'VILLANUEVA'),
(1091, 10, 'VILLANUEVA'),
(1092, 15, 'VILLAPINZON'),
(1093, 30, 'VILLARRICA'),
(1094, 21, 'VILLAVICENCIO'),
(1095, 18, 'VILLAVIEJA'),
(1096, 15, 'VILLETA'),
(1097, 15, 'VIOTA'),
(1098, 7, 'VIRACACHA'),
(1099, 21, 'VISTAHERMOSA'),
(1100, 8, 'VITERBO'),
(1101, 15, 'YACOPI'),
(1102, 23, 'YACUANQUER'),
(1103, 18, 'YAGUARA'),
(1104, 2, 'YALI'),
(1105, 2, 'YARUMAL'),
(1106, 32, 'YAVARATE'),
(1107, 2, 'YOLOMBO'),
(1108, 2, 'YONDO'),
(1109, 10, 'YOPAL'),
(1110, 31, 'YOTOCO'),
(1111, 31, 'YUMBO'),
(1112, 6, 'ZAMBRANO'),
(1113, 28, 'ZAPATOCA'),
(1114, 20, 'ZAPAYAN'),
(1115, 2, 'ZARAGOZA'),
(1116, 31, 'ZARZAL'),
(1117, 7, 'ZETAQUIRA'),
(1118, 15, 'ZIPACON'),
(1119, 15, 'ZIPAQUIRA'),
(1120, 20, 'ZONA BANANERA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `id_tipo_cliente` int(11) NOT NULL,
  `tipo_documento` int(11) NOT NULL,
  `nit` varchar(15) NOT NULL,
  `rucom` varchar(20) NOT NULL,
  `razon_social` varchar(50) NOT NULL,
  `nomcom` varchar(50) NOT NULL,
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

INSERT INTO `clientes` (`id`, `id_tipo_cliente`, `tipo_documento`, `nit`, `rucom`, `razon_social`, `nomcom`, `id_depto`, `id_ciudad`, `telefono1`, `telefono2`, `direccion`, `email`, `estado`) VALUES
(1, 1, 1, '7587549653', '123456', 'Pruebas Sas', 'Alfredo Gonzales', 1, 1, '1234567', '', 'calle falsa 123', 'alfredg@pruebassas.com', 2),
(2, 2, 1, '9876543219', '58763', 'la coquita S.A.C', 'guillermo beltran', 1, 1, '1234578', '9845873', 'clle 44 # 32-65', 'lacoqinfo@gmail.com', 1),
(3, 1, 4, '7589469325', '42678-5548', 'Angel', 'Angel', 0, 0, '7854236', '', 'calle falsa 123', 'angel@outlook.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL,
  `departamento` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `departamento`) VALUES
(1, 'AMAZONAS'),
(2, 'ANTIOQUIA'),
(3, 'ARAUCA'),
(4, 'ATLANTICO'),
(5, 'BOGOTA'),
(6, 'BOLIVAR'),
(7, 'BOYACA'),
(8, 'CALDAS'),
(9, 'CAQUETA'),
(10, 'CASANARE'),
(11, 'CAUCA'),
(12, 'CESAR'),
(13, 'CHOCO'),
(14, 'CORDOBA'),
(15, 'CUNDINAMARCA'),
(16, 'GUAINIA'),
(17, 'GUAVIARE'),
(18, 'HUILA'),
(19, 'LA GUAJIRA'),
(20, 'MAGDALENA'),
(21, 'META'),
(22, 'N. DE SANTANDER'),
(23, 'NARIÑO'),
(24, 'PUTUMAYO'),
(25, 'QUINDIO'),
(26, 'RISARALDA'),
(27, 'SAN ANDRES'),
(28, 'SANTANDER'),
(29, 'SUCRE'),
(30, 'TOLIMA'),
(31, 'VALLE DEL CAUCA'),
(32, 'VAUPES'),
(33, 'VICHADA');

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
  `total_detalle` int(11) NOT NULL,
  `id_remision` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `id_venta`, `id_producto`, `precio`, `cantidad`, `total_detalle`, `id_remision`) VALUES
(1, 10, 1, 2000, 4, 8000, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `tipo_documento` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `nombres` varchar(60) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `salario_b` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `codigo`, `tipo_documento`, `documento`, `nombres`, `apellidos`, `salario_b`) VALUES
(1, '00145', 2, 1144155366, 'Jorge Andres', 'Ruiz Cordoba', 800000),
(2, '5945', 2, 1144139561, 'Andres Mauricio', 'Pe??a Angel', 800000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encabezado_venta`
--

CREATE TABLE `encabezado_venta` (
  `id` int(11) NOT NULL,
  `prefijo` varchar(4) NOT NULL,
  `num_prefijo` int(11) NOT NULL,
  `pref_co` varchar(4) NOT NULL,
  `num_co` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
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

INSERT INTO `encabezado_venta` (`id`, `prefijo`, `num_prefijo`, `pref_co`, `num_co`, `id_cliente`, `id_empleado`, `fecha_venta`, `forma_pago`, `estado_venta`, `id_placa`, `sub_total_venta`, `descuento_venta`, `iva_venta`, `total_venta`) VALUES
(4, 'FAC', 1, '', 0, 1, 1, '2016-01-29 15:45:24', 1, 1, 1, 0, 0, 0, 0),
(5, 'FAC', 2, '', 0, 1, 1, '2016-01-29 10:00:25', 1, 1, 3, 0, 0, 0, 0),
(6, 'REM', 1, '', 0, 1, 2, '2016-01-29 10:00:31', 2, 1, 7, 0, 0, 0, 0),
(7, 'REM', 2, '', 0, 1, 2, '2016-01-29 10:03:18', 2, 1, 1, 0, 0, 0, 0),
(8, 'REM', 3, '', 0, 2, 2, '2016-01-29 10:03:39', 2, 1, 2, 0, 0, 0, 0),
(9, 'FAC', 3, '', 0, 1, 1, '2016-01-29 10:03:49', 1, 1, 1, 0, 0, 0, 0),
(10, 'FAC', 4, '', 0, 2, 2, '2016-01-29 15:05:31', 1, 1, 2, 0, 0, 0, 0),
(11, 'REM', 5, '', 0, 1, 2, '2016-02-03 21:25:46', 2, 1, 2, 0, 0, 0, 0),
(12, '', 0, '', 0, 3, 2, '2016-02-03 21:30:44', 3, 1, 4, 0, 0, 0, 0),
(13, 'REM', 6, '', 0, 3, 2, '2016-02-03 21:31:07', 3, 1, 4, 0, 0, 0, 0),
(14, 'FAC', 5, '', 0, 1, 1, '2016-02-04 17:27:40', 1, 1, 7, 0, 0, 0, 0),
(15, 'REM', 7, '', 0, 2, 2, '2016-02-04 17:28:50', 2, 1, 4, 0, 0, 0, 0),
(16, 'FAC', 6, 'CO', 2, 2, 2, '2016-02-04 17:31:25', 1, 1, 6, 0, 0, 0, 0),
(17, 'FAC', 7, 'CO', 3, 2, 1, '2016-02-04 17:31:37', 1, 1, 6, 0, 0, 0, 0),
(18, 'REM', 8, 'CO', 2, 2, 2, '2016-02-04 17:31:50', 2, 1, 2, 0, 0, 0, 0),
(19, 'REM', 9, 'CO', 3, 2, 2, '2016-02-04 17:32:04', 2, 1, 2, 0, 0, 0, 0),
(20, 'REM', 10, 'CO', 4, 1, 2, '2016-02-04 17:32:17', 3, 1, 3, 0, 0, 0, 0);

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
(1, 'Factura', 'FAC', 1, 8, 5000),
(2, 'Remision', 'REM', 1, 11, 5000),
(3, 'certificado origen r', 'CO', 1, 4, 1000),
(4, 'certificado origen f', 'CO', 1, 5, 1000),
(5, 'Abono', 'ABO', 1, 1, 1000);

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
(4, '', 'Arena', 2000, 1, NULL),
(5, '', 'Grava', 3000, 1, NULL);

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
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` int(11) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `tipo_documento`) VALUES
(1, 'NIT'),
(2, 'CEDULA'),
(3, 'RUT'),
(4, 'CEDULA EXTRANJERIA');

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
(1, 'adminarenera', 'c9369cbf82de476e1bd18e0c497c4be9', 1),
(2, 'pruebas', 'c9369cbf82de476e1bd18e0c497c4be9', 1);

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
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `id_cliente`, `placa`) VALUES
(1, 1, 'Zzz000'),
(2, 2, 'Zzz000'),
(3, 1, 'Aaa000'),
(4, 2, 'Bbb000'),
(6, 2, 'Aaa000'),
(7, 1, 'Bbb000');

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
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
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
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1121;
--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `encabezado_venta`
--
ALTER TABLE `encabezado_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
