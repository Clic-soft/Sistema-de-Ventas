CREATE DATABASE IF NOT EXISTS Tienda;
USE Tienda;

CREATE TABLE Usuario
(IdU INT AUTO_INCREMENT PRIMARY KEY,
Nombre VARCHAR(50) NOT NULL,
Apellidos VARCHAR(60) NOT NULL,
Celular VARCHAR(12) NOT NULL,
Tipo VARCHAR(13) NOT NULL,
CHECK(Tipo IN('Administrador','Invitado','Trabajador')),
Email VARCHAR(50) NOT NULL,
Contrase VARCHAR(32) NOT NULL,
Estado VARCHAR(8) NOT NULL DEFAULT 'Activo'
)ENGINE=INNODB;

CREATE TABLE Categoria
(IdC INT AUTO_INCREMENT PRIMARY KEY,
Descripcion VARCHAR(50)NOT NULL,
Estado VARCHAR(8)NOT NULL DEFAULT 'Activo',
UNIQUE KEY(IdC,Estado)
)ENGINE=INNODB;

CREATE TABLE Presentacion
(IdPr INT AUTO_INCREMENT PRIMARY KEY,
Descripcion VARCHAR(50) NOT NULL
)ENGINE=INNODB;

CREATE TABLE Producto
(IdP INT AUTO_INCREMENT PRIMARY KEY,
IdC INT NOT NULL,
FOREIGN KEY(IdC,Estado) REFERENCES Categoria(IdC,Estado) ON UPDATE CASCADE ON DELETE RESTRICT,
IdPr INT,
FOREIGN KEY(IdPr) REFERENCES Presentacion(IdPr),
Descripcion VARCHAR(100) NOT NULL,
UnidMedida VARCHAR(12) NOT NULL,
P_Venta DECIMAL(6,2) NOT NULL,
Stock INT NOT NULL DEFAULT '0',
RutaImagen VARCHAR(250),
Estado VARCHAR(8)NOT NULL DEFAULT 'Activo'
)ENGINE=INNODB;

CREATE TABLE Proveedor
(Ruc CHAR(11) NOT NULL,
RazonSocial VARCHAR(100) NOT NULL,
Direccion VARCHAR(200) NOT NULL,
Telefono VARCHAR(12) NULL,
Email VARCHAR(100) NULL,
Estado VARCHAR(8) NOT NULL DEFAULT 'Activo',
UNIQUE KEY(Ruc,Estado)
)ENGINE=INNODB;

CREATE TABLE Compras
(IdComp INT AUTO_INCREMENT PRIMARY KEY,
Ruc CHAR(11) NOT NULL,
FOREIGN KEY(Ruc,Estado) REFERENCES Proveedor(Ruc,Estado) ON UPDATE CASCADE ON DELETE RESTRICT,
Serie CHAR(3) NOT NULL,
NumComp VARCHAR(7) NOT NULL,
Fecha DATE NOT NULL,
MontoTotal DECIMAL(10,2) NOT NULL,
Estado VARCHAR(8) NOT NULL DEFAULT 'Activo',
UNIQUE KEY(IdComp,Estado)
)ENGINE=INNODB;


CREATE TABLE DetalleCompra
(IdComp INT NOT NULL,
FOREIGN KEY(IdComp,Estado) REFERENCES Compras(IdComp,Estado) ON UPDATE CASCADE ON DELETE RESTRICT,
IdP INT NOT NULL,
FOREIGN KEY(IdP) REFERENCES Producto(IdP),
P_Compra DECIMAL(10,2) NOT NULL,
Cantidad INT NOT NULL,
SubTotal DECIMAL(10,2) NOT NULL,
Igv DECIMAL(10,2) NOT NULL,
Estado VARCHAR(8) NOT NULL DEFAULT 'Activo'
)ENGINE=INNODB;

CREATE TABLE Cliente
(DNIRUC VARCHAR(11) PRIMARY KEY,
TipoCliente VARCHAR(9) NOT NULL,
NombreCliente VARCHAR(100) NOT NULL,
Direccion VARCHAR(100) NOT NULL,
Telefono VARCHAR(12) NULL,
Email VARCHAR(100) NULL
)ENGINE=INNODB;

CREATE TABLE Ventas
(IdV INT AUTO_INCREMENT PRIMARY KEY,
DNIRUC VARCHAR(11) NOT NULL,
FOREIGN KEY(DNIRUC) REFERENCES Cliente(DNIRUC),
Serie CHAR(3) NOT NULL,
NumComp VARCHAR(7) NOT NULL,
Fecha DATE NOT NULL,
TipoDoc VARCHAR(8) NOT NULL,
MontoTotal DECIMAL(10,2) NOT NULL,
Estado VARCHAR(8) NOT NULL DEFAULT 'Activo',
UNIQUE KEY(IdV,Estado)
)ENGINE=INNODB;

CREATE TABLE DetalleVentas
(IdV INT NOT NULL,
FOREIGN KEY(IdV,Estado) REFERENCES Ventas(IdV,Estado) ON UPDATE CASCADE ON DELETE RESTRICT,
IdP INT NOT NULL,
FOREIGN KEY(IdP) REFERENCES Producto(IdP),
P_Venta DECIMAL(10,2) NOT NULL,
Cantidad INT NOT NULL,
SubTotal DECIMAL(10,2) NOT NULL,
Igv DECIMAL(10,2) NOT NULL,
Estado VARCHAR(8) NOT NULL DEFAULT 'Activo'
)ENGINE=INNODB;

DELIMITER$$
CREATE PROCEDURE Reg_Usuario
(RNombre VARCHAR(50),
RApellidos VARCHAR(60),
RCelular VARCHAR(12),
RTipo VARCHAR(13),
REmail VARCHAR(50),
RContrase VARCHAR(32),
OUT Mensaje VARCHAR(100)
)BEGIN
	IF(EXISTS(SELECT * FROM Usuario WHERE Email=REmail))THEN
	SET Mensaje='E-mail no disponible, intente con otro.';
	ELSE
		BEGIN
			IF(EXISTS(SELECT * FROM Usuario WHERE Celular=RCelular))THEN
			SET Mensaje='E-mail no disponible, intente con otro.';
			ELSE 
				BEGIN
					INSERT INTO Usuario(Nombre,Apellidos,Celular,Tipo,Email,Contrase)
					VALUES(RNombre,RApellidos,RCelular,RTipo,REmail,MD5(RContrase));
					SET Mensaje='Datos registrados correctamente.';
				END;
			END IF;
		END;
	END IF;
END$$

DELIMITER$$
CREATE PROCEDURE Act_Usuario
(RIdU INT,
RNombre VARCHAR(50),
RApellidos VARCHAR(60),
RCelular VARCHAR(12),
REmail VARCHAR(50),
OUT Mensaje VARCHAR(100)
)BEGIN
	IF(EXISTS(SELECT * FROM Usuario WHERE Email=REmail AND IdU<>RIdU))THEN
	SET Mensaje='E-mail no disponible, intente con otro.';
	ELSE
		BEGIN
			IF(EXISTS(SELECT * FROM Usuario WHERE Celular=RCelular AND IdU<>RIdU))THEN
			SET Mensaje='Celular no disponible, intente con otro.';
			ELSE 
				BEGIN
					UPDATE Usuario SET Nombre=RNombre,Apellidos=RApellidos,Celular=RCelular,Email=REmail WHERE IdU=RIdU;
					SET Mensaje='Datos actualizados correctamente.';
				END;
			END IF;
		END;
	END IF;
END$$


DELIMITER$$
CREATE PROCEDURE Reg_Cliente
(RDNIRUC VARCHAR(11),
RTipoCliente VARCHAR(9),
RNombreCliente VARCHAR(100),
RDireccion VARCHAR(100),
RTelefono VARCHAR(12),
REmail VARCHAR(100),
OUT Mensaje VARCHAR(100)
)BEGIN
	IF(EXISTS(SELECT * FROM Cliente  WHERE DNIRUC=RDNIRUC))THEN
	SET Mensaje=CONCAT('Este D.N.I. / R.U.C ya existe: ', RDNIRUC);
	ELSE
		BEGIN
			IF(EXISTS(SELECT * FROM Cliente WHERE Email=REmail))THEN
			SET Mensaje=CONCAT('Este E-mail ya existe: ', REmail);
			ELSE
				BEGIN
					INSERT INTO Cliente(DNIRUC,TipoCliente,NombreCliente,Direccion,Telefono,Email) 
					VALUES(RDNIRUC,RTipoCliente,RNombreCliente,RDireccion,RTelefono,REmail);
					SET Mensaje='Registrado correctamente ok.';
				END;
			END IF;
		END;
	END IF;
END$$

DELIMITER$$
CREATE PROCEDURE Act_Cliente
(RDNIRUC VARCHAR(11),
RTipoCliente VARCHAR(9),
RNombreCliente VARCHAR(100),
RDireccion VARCHAR(100),
RTelefono VARCHAR(12),
REmail VARCHAR(100),
OUT Mensaje VARCHAR(100)
)BEGIN
	IF(NOT EXISTS(SELECT * FROM Cliente  WHERE DNIRUC=RDNIRUC))THEN
	SET Mensaje=CONCAT('Este D.N.I. / R.U.C. no existe: ', RDNIRUC);
	ELSE
		BEGIN
			IF(EXISTS(SELECT * FROM Cliente WHERE Email=REmail AND DNIRUC<>RDNIRUC))THEN
			SET Mensaje=CONCAT('Este E-mail ya existe: ', REmail);
			ELSE
				BEGIN
					UPDATE Cliente SET TipoCliente=RTipoCliente,NombreCliente=RNombreCliente,
					Direccion=RDireccion,Telefono=RTelefono,Email=REmail WHERE DNIRUC=RDNIRUC;
					SET Mensaje='Registro actualizado correctamente ok.';
				END;
			END IF;
		END;
	END IF;
END$$

DELIMITER$$
CREATE PROCEDURE Reg_Categoria
(RDescripcion VARCHAR(50),
OUT Mensaje VARCHAR(100)
)BEGIN
	IF(EXISTS(SELECT * FROM Categoria WHERE Descripcion=RDescripcion))THEN
		SET Mensaje='Categoria ya registrada';
		ELSE 
			BEGIN
				INSERT INTO Categoria(Descripcion) VALUES(RDescripcion);
				SET Mensaje="Registrado correctamente";
			END;
	END IF;
END$$

DELIMITER$$
CREATE PROCEDURE Act_Categoria
(RIdC INT,
RDescripcion VARCHAR(50),
OUT Mensaje VARCHAR(100)
)BEGIN
	IF(EXISTS(SELECT * FROM Categoria WHERE Descripcion=RDescripcion AND IdC<>RIdC))THEN
		SET Mensaje='Categoria ya existe';
		ELSE 
			BEGIN
				UPDATE Categoria SET Descripcion=RDescripcion WHERE IdC=RIdC;
				SET Mensaje="El registro se ha actualizado.";
			END;
	END IF;
END$$

DELIMITER$$
CREATE PROCEDURE Reg_Presentacion
(RDescripcion VARCHAR(50),
OUT Mensaje VARCHAR(100)
)BEGIN
	IF(EXISTS(SELECT * FROM Presentacion WHERE Descripcion=RDescripcion))THEN
		SET Mensaje='Presentación ya registrada';
		ELSE 
			BEGIN
				INSERT INTO Presentacion(Descripcion) VALUES(RDescripcion);
				SET Mensaje="Registrado correctamente";
			END;
	END IF;
END$$	
	
	
DELIMITER$$
CREATE PROCEDURE Act_Presentacion
(RIdPr INT,
RDescripcion VARCHAR(50),
OUT Mensaje VARCHAR(100)
)BEGIN
	
	IF (EXISTS(SELECT * FROM Presentacion WHERE IdPr=RIdPr))THEN
		BEGIN
			IF(EXISTS(SELECT * FROM Presentacion WHERE Descripcion=RDescripcion AND IdPr<>RIdPr))THEN
			SET Mensaje='Presentación ya registrada.';
			ELSE
				BEGIN
					UPDATE Presentacion SET Descripcion=RDescripcion WHERE IdPr=RIdPr;
					SET Mensaje='El registro se ha actualizado.';
				END;
			END IF;
		END;
	ELSE
		SET Mensaje='Ésta presentación no existe.';
	END IF;
END$$

DELIMITER$$
CREATE PROCEDURE Reg_Producto
(RIdC INT,
RIdPr INT,
RDescripcion VARCHAR(100),
RUnidMedida VARCHAR(20),
RP_Venta DECIMAL(6,2),
RStock INT,
RRutaImagen VARCHAR(250),
OUT Mensaje VARCHAR(100)
)BEGIN
	IF(EXISTS(SELECT*FROM Producto WHERE Descripcion=RDescripcion))THEN
	SET Mensaje='Este producto ya existe.';
		ELSE 
		BEGIN 
			IF(RP_Venta<1)THEN
			SET Mensaje='Precio de venta no válido.';
				ELSE 
				BEGIN
					IF(RStock<0)THEN
					SET Mensaje='Stock no válido';
						ELSE 
						BEGIN
							INSERT INTO Producto(IdC,IdPr,Descripcion,UnidMedida,P_Venta,Stock,RutaImagen)
							VALUES(RIdC,RIdPr,RDescripcion,RUnidMedida,RP_Venta,RStock,RRutaImagen);
							SET Mensaje='Registrado correctamente.';
						END;
					END IF;
				END;
			END IF;
		END;
	END IF;
END$$
			

DELIMITER$$				
CREATE PROCEDURE Act_Producto
(RIdP INT,
RIdC INT,
RIdPr INT,
RDescripcion VARCHAR(100),
RUnidMedida VARCHAR(20),
RP_Venta DECIMAL(6,2),
RStock INT,
RRutaImagen VARCHAR(250),
OUT Mensaje VARCHAR(100)
)BEGIN
DECLARE sFoto VARCHAR(100);
SET sFoto=(SELECT RutaImagen FROM Producto WHERE IdP=RIdP);
	IF(RRutaImagen="")THEN
		SET RRutaImagen=sFoto;
	ELSE
		SET RRutaImagen=RRutaImagen;
	END IF;
	
	IF(NOT EXISTS(SELECT*FROM Producto WHERE IdP=RIdP))THEN
	SET Mensaje='Este producto no existe.';
		ELSE 
		BEGIN 
			IF(RP_Venta<1)THEN
			SET Mensaje='Precio de venta no válido.';
				ELSE 
				BEGIN
					IF(RStock<0)THEN
					SET Mensaje='Stock no válido';
						ELSE 
						BEGIN
							UPDATE Producto SET IdC=RIdC,IdPr=RIdPr,Descripcion=RDescripcion,UnidMedida=RUnidMedida,
							P_Venta=RP_Venta,Stock=RStock,RutaImagen=RRutaImagen WHERE IdP=RIdP;
							SET Mensaje='El registro se ha actualizado correctamente.';
						END;
					END IF;
				END;
			END IF;
		END;
	END IF;
END$$		
	
	
DELIMITER$$
CREATE PROCEDURE Reg_Proveedor
(RRuc CHAR(11),
RRazonSocial VARCHAR(100),
RDireccion VARCHAR(200),
RTelefono VARCHAR(12),
REmail VARCHAR(100),
OUT Mensaje VARCHAR(100)
)BEGIN
	IF(EXISTS(SELECT * FROM Proveedor WHERE Ruc=RRuc))THEN
	SET Mensaje=CONCAT('Este ya existe: ', RRuc);
	ELSE
		BEGIN
			IF(EXISTS(SELECT * FROM Proveedor WHERE RazonSocial=RRazonSocial))THEN
			SET Mensaje=CONCAT('Esta razón social ya existe: ', RRazonSocial);
			ELSE
				BEGIN
					IF(EXISTS(SELECT * FROM Proveedor WHERE Email=REmail))THEN
					SET Mensaje=CONCAT('Este e-mail ya existe: ', REmail);
					ELSE
						BEGIN
							INSERT INTO Proveedor(Ruc,RazonSocial,Direccion,Telefono,Email)
							VALUES(RRuc,RRazonSocial,RDireccion,RTelefono,REmail);
							SET Mensaje='Registrado correctamente';
						END;
					END IF;
				END;
			END IF;
		END;
	END IF;
END$$


DELIMITER$$
CREATE PROCEDURE Act_Proveedor
(RRuc CHAR(11),
RRazonSocial VARCHAR(100),
RDireccion VARCHAR(200),
RTelefono VARCHAR(12),
REmail VARCHAR(100),
OUT Mensaje VARCHAR(100)
)BEGIN
	IF(EXISTS(SELECT * FROM Proveedor WHERE RazonSocial=RRazonSocial AND Ruc<>RRuc))THEN
	SET Mensaje=CONCAT('Esta razón social ya existe: ', RRazonSocial);
	ELSE
		BEGIN
			IF(EXISTS(SELECT * FROM Proveedor WHERE Email=REmail AND Ruc<>RRuc))THEN
			SET Mensaje=CONCAT('Este e-mail ya existe: ', REmail);
			ELSE
				BEGIN
					UPDATE Proveedor SET RazonSocial=RRazonSocial,Direccion=RDireccion,Telefono=RTelefono,
					Email=REmail WHERE Ruc=RRuc;
					SET Mensaje='Registro actualizado correctamente.';
				END;
			END IF;
		END;
	END IF;
END$$

DELIMITER$$
CREATE PROCEDURE  Reg_Compras
(RRuc CHAR(11),
RSerie CHAR(3),
RNumComp VARCHAR(7),
RFecha DATE,
RMontoTotal DECIMAL(10,2),
OUT Mensaje VARCHAR(100)
)BEGIN
	START TRANSACTION;
	IF(EXISTS(SELECT * FROM Compras WHERE Serie=RSerie AND NumComp=RNumComp AND Ruc=RRuc))THEN
	SET Mensaje='Verifique número de comprobante.';
	ELSE
		BEGIN
			INSERT INTO Compras(Ruc,Serie,NumComp,Fecha,MontoTotal) 
			VALUES(RRuc,RSerie,RNumComp,RFecha,RMontoTotal);
			SET Mensaje='Compra generada correctamente.';
			COMMIT;
		END;
	END IF;
END$$


DELIMITER$$
CREATE PROCEDURE Reg_DetalleCompra
(RIdComp INT,
RIdP INT,
RP_Compra DECIMAL(10,2),
RCantidad INT,
RSubTotal DECIMAL(10,2),
RIgv DECIMAL(10,2),
OUT Mensaje VARCHAR(100)
)BEGIN
	DECLARE rStock INT;
	START TRANSACTION;
	SET rStock=(SELECT Stock FROM Producto WHERE IdP=RIdP);
	IF(NOT EXISTS(SELECT * FROM Compras WHERE IdComp=RIdComp))THEN
	SET Mensaje='Ha ocurrido un error al registrar la compra';
	ELSE
		BEGIN
			INSERT INTO DetalleCompra(IdComp,IdP,P_Compra,Cantidad,SubTotal,Igv) 
			VALUES(RIdComp,RIdP,RP_Compra,RCantidad,RSubTotal,RIgv);
			SET Mensaje='Compra generada correctamente.';
			UPDATE Producto SET Stock=rStock+RCantidad WHERE IdP=RIdP; 
			COMMIT;
		END;
	END IF;
END$$


DELIMITER$$
CREATE PROCEDURE Reg_Ventas
(RDNIRUC VARCHAR(11),
RSerie CHAR(3),
RNumComp VARCHAR(7),
RFecha DATE,
RTipoDoc VARCHAR(8),
RMontoTotal DECIMAL(10,2),
OUT Mensaje VARCHAR(100)
)BEGIN
	START TRANSACTION;
	IF(EXISTS(SELECT * FROM Ventas WHERE Serie=RSerie AND NumComp=RNumComp AND DNIRUC=RDNIRUC))THEN
	SET Mensaje='Verifique número de comprobante.';
	ELSE
		BEGIN
			INSERT INTO Ventas(DNIRUC,Serie,NumComp,Fecha,TipoDoc,MontoTotal) 
			VALUES(RDNIRUC,RSerie,RNumComp,RFecha,RTipoDoc,RMontoTotal);
			SET Mensaje='Venta generada correctamente.';
			COMMIT;
		END;
	END IF;
END$$

DELIMITER$$
CREATE PROCEDURE Reg_DetalleVentas
(RIdV INT,
RIdP INT,
RP_Venta DECIMAL(10,2),
RCantidad INT,
RSubTotal DECIMAL(10,2),
RIgv DECIMAL(10,2),
OUT Mensaje VARCHAR(100)
)BEGIN
	DECLARE rStock INT;
	START TRANSACTION;
	SET rStock=(SELECT Stock FROM Producto WHERE IdP=RIdP);
	IF(NOT EXISTS(SELECT * FROM Ventas WHERE IdV=RIdV))THEN
	SET Mensaje='Ha ocurrido un error al registrar la venta';
	ELSE
		BEGIN
			INSERT INTO DetalleVentas(IdV,IdP,P_Venta,Cantidad,SubTotal,Igv) 
			VALUES(RIdV,RIdP,RP_Venta,RCantidad,RSubTotal,RIgv);
			SET Mensaje='Venta generada correctamente.';
			UPDATE Producto SET Stock=rStock-RCantidad WHERE IdP=RIdP; 
			COMMIT;
		END;
	END IF;
END$$

CREATE VIEW Reporte1
AS
	SELECT DISTINCT(CONCAT(P.Descripcion,' ',Pr.Descripcion,' ', P.UnidMedida))AS 'Descripcion',SUM(DV.Cantidad) AS TotalVentas,V.Fecha 
	FROM Presentacion Pr INNER JOIN Producto P ON Pr.IdPr=P.IdPr 
	INNER JOIN DetalleVentas DV ON P.IdP=DV.IdP 
	INNER JOIN Ventas V ON V.IdV=DV.IdV
	GROUP BY DV.IdP,V.Fecha
	ORDER BY SUM(DV.Cantidad) DESC
	LIMIT 0 , 10;

SELECT * FROM Reporte1 WHERE MONTH(Fecha)=02 AND YEAR(Fecha)=2015;

			
CREATE VIEW IngresosAnual
AS
	SELECT DISTINCT(YEAR(Fecha)) YEAR, SUM(MontoTotal) TotalVentas
	FROM Ventas
	GROUP BY Fecha;

CREATE VIEW EgresosAnual
AS
	SELECT DISTINCT(YEAR(Fecha)) YEAR,SUM(MontoTotal) TotalCompras
	FROM Compras
	GROUP BY Fecha;

SELECT * FROM IngresosAnual JOIN EgresosAnual USING (YEAR);


CREATE VIEW StockMinimo
AS
	SELECT IdP,C.Descripcion AS 'Categoria',CONCAT(P.Descripcion,' ',Pr.Descripcion,' ', P.UnidMedida) AS 'Descripcion',P.P_Venta,P.Stock 
	FROM Presentacion Pr INNER JOIN Producto P ON Pr.IdPr=P.IdPr INNER JOIN Categoria C ON C.IdC=P.IdC
	WHERE P.Stock<=9;


CREATE VIEW Comprobante
AS
	SELECT V.NumComp,V.TipoDoc,D.Cantidad,CONCAT(P.Descripcion,' ',Pr.Descripcion,' ', P.UnidMedida) AS 'Descripcion',
	P.P_Venta,D.Igv,D.SubTotal FROM Ventas V INNER JOIN DetalleVentas D ON V.IdV=D.IdV 
	INNER JOIN Producto P ON P.IdP=D.IdP INNER JOIN Presentacion Pr ON Pr.IdPr=P.IdPr;
	

CREATE VIEW ListadoProductos
AS
	SELECT C.Descripcion AS 'Categoria',P.*,Pr.Descripcion AS 'Presentacion' 
	FROM Categoria C INNER JOIN Producto P ON P.IdC=C.IdC INNER JOIN Presentacion Pr ON Pr.IdPr=P.IdPr;


INSERT INTO Usuario(Nombre,Apellidos,Celular,Tipo,Email,Contrase) 
VALUES('Carlos','Sanchez López','950033141','Administrador','sanchez_lopez@hotmail.com',MD5('12345'));
INSERT INTO Usuario(Nombre,Apellidos,Celular,Tipo,Email,Contrase)  
VALUES('Martin','Silva Requejo','940394042','Trabajador','martin_silva@hotmail.com',MD5('12345'));

SELECT * FROM Usuario;
SELECT * FROM Categoria;
SELECT * FROM Presentacion;
SELECT * FROM Producto;
SELECT * FROM ListadoProductos;
SELECT * FROM Compras;
SELECT * FROM DetalleCompra;
SELECT * FROM Cliente;
SELECT * FROM Proveedor;
SELECT * FROM Ventas;
SELECT * FROM DetalleVentas;



