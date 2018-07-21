CREATE DATABASE ecommerce2; 
USE ecommerce2;

CREATE TABLE clientes (
  id int NOT NULL auto_increment,
  nombre varchar(120) NOT NULL,
  email varchar(100) NOT NULL,
  fecha_registro datetime NOT NULL CURRENT_TIMESTAMP,
  PRIMARY KEY  (id)
);

CREATE TABLE despachos (
  id int NOT NULL auto_increment,
  fecha datetime NOT NULL,
  direccion varchar(200) NOT NULL,
  estado varchar(12),
  PRIMARY KEY  (id)
);

CREATE TABLE productos (
  id int NOT NULL auto_increment,
  nombre varchar(200) NOT NULL,
  descripcion text NULL,
  categoria varchar(15) NOT NULL,
  precio_normal int NOT NULL default '0',
  precio_internet int NULL,
  precio_oferta int NULL,
  stock int NOT NULL default '0',
  image varchar(200) NOT NULL default 'sinimg.jpg',
  fecha_registro datetime NOT NULL CURRENT_TIMESTAMP,
  PRIMARY KEY  (id)
);

CREATE TABLE ventas (
  id int NOT NULL auto_increment,
  fecha datetime NOT NULL,
  monto int NOT NULL,
  medio_pago varchar(50) NOT NULL,
  cliente_id int NOT NULL,
  despacho_id int NOT NULL,
  PRIMARY KEY  (id)
);

CREATE TABLE ventas_detalles (
  id int(11) NOT NULL auto_increment,
  fecha_registro datetime NOT NULL CURRENT_TIMESTAMP,
  cantidad int NOT NULL,
  producto_id int NOT NULL,
  venta_id int NOT NULL,
  PRIMARY KEY  (id)
);