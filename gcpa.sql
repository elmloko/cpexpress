-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para gcpa
CREATE DATABASE IF NOT EXISTS `gcpa` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `gcpa`;

-- Volcando estructura para tabla gcpa.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.cache: ~13 rows (aproximadamente)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laravel_cache_josue.manriquez@correos.gob.bo|127.0.0.1', 'i:1;', 1752785601),
	('laravel_cache_josue.manriquez@correos.gob.bo|127.0.0.1:timer', 'i:1752785601;', 1752785601),
	('laravel_cache_laravel:pulse:Laravel\\Pulse\\Livewire\\Cache:all:1_hour', 'a:3:{i:0;O:8:"stdClass":2:{s:4:"hits";s:5:"21.00";s:6:"misses";i:0;}i:1;d:35.3296;i:2;s:19:"2025-07-09 16:27:44";}', 1752078469),
	('laravel_cache_laravel:pulse:Laravel\\Pulse\\Livewire\\Cache:keys:1_hour', 'a:3:{i:0;O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:1:{i:0;O:8:"stdClass":3:{s:3:"key";s:23:"spatie.permission.cache";s:4:"hits";s:5:"21.00";s:6:"misses";i:0;}}s:28:"\0*\0escapeWhenCastingToString";b:0;}i:1;d:7.3351;i:2;s:19:"2025-07-09 16:27:45";}', 1752078470),
	('laravel_cache_laravel:pulse:Laravel\\Pulse\\Livewire\\Exceptions:count:1_hour', 'a:3:{i:0;O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:0:{}s:28:"\0*\0escapeWhenCastingToString";b:0;}i:1;d:3.3023;i:2;s:19:"2025-07-09 16:27:44";}', 1752078469),
	('laravel_cache_laravel:pulse:Laravel\\Pulse\\Livewire\\Queues::1_hour', 'a:3:{i:0;O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:0:{}s:28:"\0*\0escapeWhenCastingToString";b:0;}i:1;d:4.3294;i:2;s:19:"2025-07-09 16:27:44";}', 1752078469),
	('laravel_cache_laravel:pulse:Laravel\\Pulse\\Livewire\\Servers::1_hour', 'a:3:{i:0;O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:0:{}s:28:"\0*\0escapeWhenCastingToString";b:0;}i:1;d:249.8821;i:2;s:19:"2025-07-09 16:27:41";}', 1752078467),
	('laravel_cache_laravel:pulse:Laravel\\Pulse\\Livewire\\SlowQueries:slowest:1_hour', 'a:3:{i:0;O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:0:{}s:28:"\0*\0escapeWhenCastingToString";b:0;}i:1;d:5.6689;i:2;s:19:"2025-07-09 16:27:43";}', 1752078468),
	('laravel_cache_laravel:pulse:Laravel\\Pulse\\Livewire\\SlowRequests:slowest:1_hour', 'a:3:{i:0;O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:0:{}s:28:"\0*\0escapeWhenCastingToString";b:0;}i:1;d:24.5933;i:2;s:19:"2025-07-09 16:27:43";}', 1752078468),
	('laravel_cache_laravel:pulse:Laravel\\Pulse\\Livewire\\Usage:requests:1_hour', 'a:3:{i:0;O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:1:{i:0;O:8:"stdClass":3:{s:3:"key";s:1:"1";s:4:"user";O:8:"stdClass":3:{s:4:"name";s:28:"Marco Antonio Espinoza Rojas";s:5:"extra";s:29:"marco.espinoza@correos.gob.bo";s:6:"avatar";s:97:"https://gravatar.com/avatar/f37a6ca5fae038f24777da3902c897f4d49fd108e665719ec6daaee86cc1079c?d=mp";}s:5:"count";i:78;}}s:28:"\0*\0escapeWhenCastingToString";b:0;}i:1;d:96.2727;i:2;s:19:"2025-07-09 16:27:42";}', 1752078467),
	('laravel_cache_lv:v3.17.1:file:970a4c3d-laravel.log:metadata', 'a:1:{s:4:"type";s:7:"laravel";}', 1752683266),
	('laravel_cache_lv:v3.17.1:file:c3206927-laravel.log:metadata', 'a:1:{s:4:"type";s:7:"laravel";}', 1751985000),
	('laravel_cache_spatie.permission.cache', 'a:3:{s:5:"alias";a:4:{s:1:"a";s:2:"id";s:1:"b";s:4:"name";s:1:"c";s:10:"guard_name";s:1:"r";s:5:"roles";}s:11:"permissions";a:5:{i:0;a:4:{s:1:"a";i:1;s:1:"b";s:9:"tarifario";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:1;a:4:{s:1:"a";i:2;s:1:"b";s:6:"enviar";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:2;a:4:{s:1:"a";i:3;s:1:"b";s:7:"recibir";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:3;a:4:{s:1:"a";i:4;s:1:"b";s:5:"visor";s:1:"c";s:3:"web";s:1:"r";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:4;a:4:{s:1:"a";i:5;s:1:"b";s:8:"usuarios";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}}s:5:"roles";a:3:{i:0;a:3:{s:1:"a";i:1;s:1:"b";s:13:"Administrador";s:1:"c";s:3:"web";}i:1;a:3:{s:1:"a";i:2;s:1:"b";s:7:"Cartero";s:1:"c";s:3:"web";}i:2;a:3:{s:1:"a";i:3;s:1:"b";s:11:"Informacion";s:1:"c";s:3:"web";}}}', 1752871948);

-- Volcando estructura para tabla gcpa.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.cache_locks: ~0 rows (aproximadamente)

-- Volcando estructura para tabla gcpa.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gcpa.empresa: ~10 rows (aproximadamente)
INSERT INTO `empresa` (`id`, `nombre`, `tipo`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(11, 'FUNDACION AYUDA EN ACCION', 'NUEVO', '2025-06-23 17:54:48', '2025-06-23 17:54:48', NULL),
	(12, 'ALDEAS INFANTILES SOS', 'NUEVO', '2025-06-23 18:16:13', '2025-06-23 18:16:13', NULL),
	(13, 'FUNDACION JESUITAS DE BOLIVIA', 'ANTIGUO', '2025-06-23 18:16:33', '2025-07-09 20:24:11', NULL),
	(14, 'WORLD VISION BOLIVIA', 'NUEVO', '2025-06-23 18:17:45', '2025-06-23 18:18:44', NULL),
	(15, 'NACIONAL', 'ANTIGUO', '2025-06-23 18:19:41', '2025-06-23 18:19:41', NULL),
	(16, 'ENCOMIENDA', 'ANTIGUO', '2025-06-25 19:12:59', '2025-06-25 19:12:59', NULL),
	(17, 'COLLECTION SRL', 'ANTIGUO', '2025-07-09 20:16:33', '2025-07-09 20:16:33', NULL),
	(18, 'RIVECO CONSTRUCCIONES SRL', 'ANTIGUO', '2025-07-09 20:16:47', '2025-07-09 20:16:47', NULL),
	(19, 'MESAJE DE PAZ', 'ANTIGUO', '2025-07-09 20:19:12', '2025-07-09 20:19:12', NULL),
	(20, 'FUNDACION JESUITAS DE BOLIVIA', 'ANTIGUO', '2025-07-09 20:21:21', '2025-07-09 20:24:05', '2025-07-09 20:24:05');

-- Volcando estructura para tabla gcpa.eventos
CREATE TABLE IF NOT EXISTS `eventos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `accion` varchar(50) DEFAULT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gcpa.eventos: ~167 rows (aproximadamente)
INSERT INTO `eventos` (`id`, `accion`, `user_id`, `codigo`, `descripcion`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(2, NULL, 'Marco Antonio Espinoza Rojas', 'LH248642596US', 'Paquete Registrado', '2025-06-24 01:34:52', '2025-06-24 01:35:48', '2025-06-24 01:35:48'),
	(3, 'ENCONTRADO', 'Marco Antonio Espinoza Rojas', 'LH248642596US', 'Paquete Registrado', '2025-06-24 01:35:39', '2025-06-24 01:35:39', NULL),
	(4, 'EDICION', 'Marco Antonio Espinoza Rojas', 'LH248642596US', 'Paquete Editado', '2025-06-24 01:41:59', '2025-06-24 01:41:59', NULL),
	(5, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'UY159222305DE', 'Paquete Recibido', '2025-06-24 01:47:39', '2025-06-24 01:47:39', NULL),
	(6, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'UP400250888LU', 'Paquete Recibido', '2025-06-24 01:51:58', '2025-06-24 01:51:58', NULL),
	(7, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'UP400250888LU', 'Paquete Entregado', '2025-06-24 01:52:13', '2025-06-24 01:52:13', NULL),
	(8, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'UY160390561DE', 'Paquete Recibido', '2025-06-24 01:53:11', '2025-06-24 01:53:11', NULL),
	(9, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'LH248642596US', 'Paquete Entregado', '2025-06-24 01:53:20', '2025-06-24 01:53:20', NULL),
	(10, 'ALTA', 'Marco Antonio Espinoza Rojas', 'UP400250888LU', 'Paquete Restaurado a Almacen', '2025-06-24 01:57:18', '2025-06-24 01:57:18', NULL),
	(11, 'ENVIANDO', 'Marco Antonio Espinoza Rojas', 'RB251312246IT', 'Paquete asignado para envio', '2025-06-24 19:40:42', '2025-06-24 19:40:42', NULL),
	(12, 'CREACION', 'Marco Antonio Espinoza Rojas', 'RF322074048ES', 'Paquete Creado', '2025-06-24 19:49:14', '2025-06-24 19:49:14', NULL),
	(13, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RF322074048ES', 'Paquete Editado', '2025-06-24 19:49:25', '2025-06-24 19:49:25', NULL),
	(14, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'RF322074048ES', 'Paquete Recibido', '2025-06-24 19:49:32', '2025-06-24 19:49:32', NULL),
	(15, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RF322074048ES', 'Paquete Editado', '2025-06-24 19:49:44', '2025-06-24 19:49:44', NULL),
	(16, 'ALTA', 'Marco Antonio Espinoza Rojas', 'UP400242643LU', 'Paquete Restaurado a Almacen', '2025-06-24 19:50:06', '2025-06-24 19:50:06', NULL),
	(17, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'UP400250888LU', 'Paquete Entregado', '2025-06-24 19:50:14', '2025-06-24 19:50:14', NULL),
	(18, 'ENVIANDO', 'Marco Antonio Espinoza Rojas', 'RB251312246IT', 'Paquete asignado para envio', '2025-06-24 20:12:21', '2025-06-24 20:12:21', NULL),
	(19, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'RB251312246IT', 'Paquete Despachado a Destinatario', '2025-06-24 20:12:25', '2025-06-24 20:12:25', NULL),
	(20, 'CREACION', 'Marco Antonio Espinoza Rojas', 'UY161815126DE', 'Paquete Creado', '2025-06-25 17:31:43', '2025-06-25 17:31:43', NULL),
	(21, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'UY161815126DE', 'Paquete Recibido', '2025-06-25 17:31:51', '2025-06-25 17:31:51', NULL),
	(22, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'UY160390561DE', 'Paquete Entregado', '2025-06-25 17:32:26', '2025-06-25 17:32:26', NULL),
	(23, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'UP400242643LU', 'Paquete Entregado', '2025-06-25 17:32:26', '2025-06-25 17:32:26', NULL),
	(24, 'ELIMINADO', 'Marco Antonio Espinoza Rojas', 'RB251312246IT', 'Paquete Eliminado', '2025-06-25 17:38:38', '2025-06-25 17:38:38', NULL),
	(25, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RD000196175BO', 'Paquete Editado', '2025-06-25 17:43:10', '2025-06-25 17:43:10', NULL),
	(26, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'RD000196175BO', 'Paquete Recibido', '2025-06-25 17:43:18', '2025-06-25 17:43:18', NULL),
	(27, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'UP400250889LU', 'Paquete Recibido', '2025-06-25 18:41:04', '2025-06-25 18:41:04', NULL),
	(28, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'UY161815126DE', 'Paquete Entregado', '2025-06-25 18:41:16', '2025-06-25 18:41:16', NULL),
	(29, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'UP400250888LU', 'Paquete Recibido', '2025-06-25 18:50:34', '2025-06-25 18:50:34', NULL),
	(30, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'UY159222305DE', 'Paquete Entregado', '2025-06-25 18:50:48', '2025-06-25 18:50:48', NULL),
	(31, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RB251312246IT', 'Paquete Editado', '2025-06-25 20:13:29', '2025-06-25 20:13:29', NULL),
	(32, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UY160984634DE', 'Paquete Despachado a Destinatario', '2025-06-25 20:14:57', '2025-06-25 20:14:57', NULL),
	(33, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984634DE', 'Paquete Editado', '2025-06-25 20:15:20', '2025-06-25 20:15:20', NULL),
	(34, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UY160984634DE', 'Paquete Despachado a Destinatario', '2025-06-25 20:18:07', '2025-06-25 20:18:07', NULL),
	(35, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984634DE', 'Paquete Editado', '2025-06-25 20:18:20', '2025-06-25 20:18:20', NULL),
	(36, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984634DE', 'Paquete Editado', '2025-06-25 20:18:27', '2025-06-25 20:18:27', NULL),
	(37, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984634DE', 'Paquete Editado', '2025-06-25 22:34:32', '2025-06-25 22:34:32', NULL),
	(38, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984634DE', 'Paquete Editado', '2025-06-25 22:34:37', '2025-06-25 22:34:37', NULL),
	(39, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984634DE', 'Paquete Editado', '2025-06-25 22:34:41', '2025-06-25 22:34:41', NULL),
	(40, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984635DE', 'Paquete Editado', '2025-06-25 23:00:17', '2025-06-25 23:00:17', NULL),
	(41, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984635DE', 'Paquete Editado', '2025-06-25 23:16:18', '2025-06-25 23:16:18', NULL),
	(42, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'RD000196175BO', 'Paquete Despachado a Destinatario', '2025-06-25 23:21:09', '2025-06-25 23:21:09', NULL),
	(43, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RD000196175BO', 'Paquete Editado', '2025-06-25 23:22:55', '2025-06-25 23:22:55', NULL),
	(44, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'RD000196175BO', 'Paquete Despachado a Destinatario', '2025-06-25 23:23:00', '2025-06-25 23:23:00', NULL),
	(45, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete Editado', '2025-06-25 23:30:11', '2025-06-25 23:30:11', NULL),
	(46, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete Recibido', '2025-06-25 23:30:31', '2025-06-25 23:30:31', NULL),
	(47, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400250889LU', 'Paquete Editado', '2025-06-25 23:33:28', '2025-06-25 23:33:28', NULL),
	(48, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'UP400250889LU', 'Paquete Recibido', '2025-06-25 23:33:32', '2025-06-25 23:33:32', NULL),
	(49, 'CREACION', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete Creado', '2025-06-25 23:35:36', '2025-06-25 23:35:36', NULL),
	(50, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete Recibido', '2025-06-25 23:35:40', '2025-06-25 23:35:40', NULL),
	(51, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400250889LU', 'Paquete Editado', '2025-06-25 23:40:53', '2025-06-25 23:40:53', NULL),
	(52, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'UP400250889LU', 'Paquete Recibido', '2025-06-25 23:40:57', '2025-06-25 23:40:57', NULL),
	(53, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete Editado', '2025-06-25 23:43:38', '2025-06-25 23:43:38', NULL),
	(54, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete Recibido', '2025-06-25 23:43:45', '2025-06-25 23:43:45', NULL),
	(55, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RD000196175BO', 'Paquete editado y precio recalculado', '2025-06-26 00:12:33', '2025-06-26 00:12:33', NULL),
	(56, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RD000196175BO', 'Paquete editado y precio recalculado', '2025-06-26 00:15:09', '2025-06-26 00:15:09', NULL),
	(57, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RD000196175BO', 'Paquete editado y precio recalculado', '2025-06-26 00:15:26', '2025-06-26 00:15:26', NULL),
	(58, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400250888LU', 'Paquete Editado', '2025-06-26 00:36:14', '2025-06-26 00:36:14', NULL),
	(59, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400250888LU', 'Paquete Editado', '2025-06-26 00:36:22', '2025-06-26 00:36:22', NULL),
	(60, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400250888LU', 'Paquete Editado', '2025-06-26 00:40:32', '2025-06-26 00:40:32', NULL),
	(61, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400250889LU', 'Paquete Editado', '2025-06-26 00:40:48', '2025-06-26 00:40:48', NULL),
	(62, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400250889LU', 'Paquete Editado', '2025-06-26 00:40:52', '2025-06-26 00:40:52', NULL),
	(63, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400250889LU', 'Paquete Editado', '2025-06-26 00:41:01', '2025-06-26 00:41:01', NULL),
	(64, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete Editado', '2025-06-26 00:44:55', '2025-06-26 00:44:55', NULL),
	(65, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete Editado', '2025-06-26 00:45:05', '2025-06-26 00:45:05', NULL),
	(66, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400250888LU', 'Paquete Editado', '2025-06-26 00:45:11', '2025-06-26 00:45:11', NULL),
	(67, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400250888LU', 'Paquete Editado', '2025-06-26 00:49:47', '2025-06-26 00:49:47', NULL),
	(68, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400250888LU', 'Paquete Editado', '2025-06-26 00:49:52', '2025-06-26 00:49:52', NULL),
	(69, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RD000196175BO', 'Paquete Editado', '2025-06-26 00:57:13', '2025-06-26 00:57:13', NULL),
	(70, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RD000196175BO', 'Paquete Editado', '2025-06-26 00:57:17', '2025-06-26 00:57:17', NULL),
	(71, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RD000196175BO', 'Paquete Editado', '2025-06-26 00:57:25', '2025-06-26 00:57:25', NULL),
	(72, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RD000196175BO', 'Paquete editado y precio recalculado', '2025-06-26 00:58:13', '2025-06-26 00:58:13', NULL),
	(73, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160390561DE', 'Paquete editado y precio recalculado', '2025-06-26 01:00:59', '2025-06-26 01:00:59', NULL),
	(74, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160390561DE', 'Paquete editado y precio recalculado', '2025-06-26 01:01:03', '2025-06-26 01:01:03', NULL),
	(75, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160390561DE', 'Paquete editado y precio recalculado', '2025-06-26 01:01:09', '2025-06-26 01:01:09', NULL),
	(76, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160390561DE', 'Paquete editado y precio recalculado', '2025-06-26 01:01:17', '2025-06-26 01:01:17', NULL),
	(77, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984634DE', 'Paquete editado y precio recalculado', '2025-06-26 01:01:36', '2025-06-26 01:01:36', NULL),
	(78, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete editado y precio recalculado', '2025-06-26 01:01:52', '2025-06-26 01:01:52', NULL),
	(79, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete editado y precio recalculado', '2025-06-26 01:02:01', '2025-06-26 01:02:01', NULL),
	(80, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', NULL, 'Se enviaron 12 paquetes', '2025-06-26 18:12:17', '2025-06-26 18:12:17', NULL),
	(81, 'ENVIANDO', '1', 'UY159222305DE', 'Se enviaron 10 paquetes', '2025-06-26 18:21:28', '2025-06-26 18:21:28', NULL),
	(82, 'ENVIANDO', 'Marco Antonio Espinoza Rojas', 'UP644880905CH', 'Paquete asignado para envio', '2025-06-26 18:29:07', '2025-06-26 18:29:07', NULL),
	(83, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP644880905CH', 'Paquete Editado', '2025-06-26 18:29:18', '2025-06-26 18:29:18', NULL),
	(84, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984635DE', 'Paquete Editado', '2025-06-26 18:34:42', '2025-06-26 18:34:42', NULL),
	(85, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UY160984635DE', 'Paquete Despachado a Destinatario', '2025-06-26 18:38:24', '2025-06-26 18:38:24', NULL),
	(86, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY159222305DE', 'Paquete editado y precio recalculado', '2025-06-26 18:47:38', '2025-06-26 18:47:38', NULL),
	(87, 'ENCONTRADO', 'Marco Antonio Espinoza Rojas', 'UR506481043CA', 'Paquete Registrado', '2025-07-09 17:23:52', '2025-07-09 17:23:52', NULL),
	(88, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UP644880905CH', 'Paquete Despachado a Destinatario', '2025-07-09 18:31:47', '2025-07-09 18:31:47', NULL),
	(89, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UP644880905CH', 'Paquete Despachado a Destinatario', '2025-07-09 18:32:10', '2025-07-09 18:32:10', NULL),
	(90, 'ENVIANDO', 'Marco Antonio Espinoza Rojas', 'UF105260739HK', 'Paquete asignado para envio', '2025-07-09 20:07:20', '2025-07-09 20:07:20', NULL),
	(91, 'ENVIANDO', 'Marco Antonio Espinoza Rojas', 'UY162197328DE', 'Paquete asignado para envío', '2025-07-09 23:16:10', '2025-07-09 23:16:10', NULL),
	(92, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY162197328DE', 'Paquete Editado', '2025-07-09 23:16:17', '2025-07-09 23:16:17', NULL),
	(93, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY162197328DE', 'Paquete Editado', '2025-07-10 01:30:09', '2025-07-10 01:30:09', NULL),
	(94, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UF105260739HK', 'Paquete Editado', '2025-07-10 01:31:11', '2025-07-10 01:31:11', NULL),
	(95, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY162197328DE', 'Paquete Editado', '2025-07-10 01:31:14', '2025-07-10 01:31:14', NULL),
	(96, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY162197328DE', 'Paquete Editado', '2025-07-10 01:37:58', '2025-07-10 01:37:58', NULL),
	(97, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UY162197328DE', 'Paquete Despachado', '2025-07-10 01:42:16', '2025-07-10 01:42:16', NULL),
	(98, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UF105260739HK', 'Paquete Editado', '2025-07-10 01:43:03', '2025-07-10 01:43:03', NULL),
	(99, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UF105260739HK', 'Paquete Editado', '2025-07-10 01:43:10', '2025-07-10 01:43:10', NULL),
	(100, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UF105260739HK', 'Paquete Despachado', '2025-07-10 01:43:13', '2025-07-10 01:43:13', NULL),
	(101, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY162197328DE', 'Paquete Editado', '2025-07-10 01:43:53', '2025-07-10 01:43:53', NULL),
	(102, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UF105260739HK', 'Paquete Editado', '2025-07-10 01:44:01', '2025-07-10 01:44:01', NULL),
	(103, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UF105260739HK', 'Paquete Despachado', '2025-07-10 01:44:05', '2025-07-10 01:44:05', NULL),
	(104, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UY162197328DE', 'Paquete Despachado', '2025-07-10 01:44:05', '2025-07-10 01:44:05', NULL),
	(105, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY543233522DE', 'Paquete Editado', '2025-07-10 02:07:03', '2025-07-10 02:07:03', NULL),
	(106, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UY160390561DE', 'Paquete Despachado', '2025-07-10 16:56:57', '2025-07-10 16:56:57', NULL),
	(107, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UY162197328DE', 'Paquete Despachado', '2025-07-10 17:41:21', '2025-07-10 17:41:21', NULL),
	(108, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UF105260739HK', 'Paquete Despachado', '2025-07-10 17:42:40', '2025-07-10 17:42:40', NULL),
	(109, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UP644880905CH', 'Paquete Despachado', '2025-07-10 17:43:33', '2025-07-10 17:43:33', NULL),
	(110, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UY160390561DE', 'Paquete Despachado', '2025-07-10 17:57:41', '2025-07-10 17:57:41', NULL),
	(111, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UY162197328DE', 'Paquete Despachado', '2025-07-10 18:08:39', '2025-07-10 18:08:39', NULL),
	(112, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UP644880905CH', 'Paquete Despachado', '2025-07-10 18:10:59', '2025-07-10 18:10:59', NULL),
	(113, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UF105260739HK', 'Paquete Despachado', '2025-07-10 18:12:15', '2025-07-10 18:12:15', NULL),
	(114, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UY160390561DE', 'Paquete Despachado', '2025-07-10 18:13:30', '2025-07-10 18:13:30', NULL),
	(115, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984635DE', 'Paquete Editado', '2025-07-10 18:26:59', '2025-07-10 18:26:59', NULL),
	(116, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984635DE', 'Paquete Editado', '2025-07-10 18:27:06', '2025-07-10 18:27:06', NULL),
	(117, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984635DE', 'Paquete Editado', '2025-07-10 18:31:10', '2025-07-10 18:31:10', NULL),
	(118, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984634DE', 'Paquete Editado', '2025-07-10 18:31:19', '2025-07-10 18:31:19', NULL),
	(119, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UY160984634DE', 'Paquete Despachado', '2025-07-10 18:31:31', '2025-07-10 18:31:31', NULL),
	(120, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UY160984635DE', 'Paquete Despachado', '2025-07-10 18:31:31', '2025-07-10 18:31:31', NULL),
	(121, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP644880905CH', 'Paquete Editado', '2025-07-10 18:37:10', '2025-07-10 18:37:10', NULL),
	(122, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UY543233522DE', 'Paquete Despachado', '2025-07-10 18:37:56', '2025-07-10 18:37:56', NULL),
	(123, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UY160390561DE', 'Paquete Despachado', '2025-07-10 18:42:52', '2025-07-10 18:42:52', NULL),
	(124, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UP644880905CH', 'Paquete Despachado', '2025-07-10 18:43:21', '2025-07-10 18:43:21', NULL),
	(125, 'ENVIANDO', 'Marco Antonio Espinoza Rojas', 'UR506489033CA', 'Paquete asignado para envío', '2025-07-10 18:57:13', '2025-07-10 18:57:13', NULL),
	(126, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UR506489033CA', 'Paquete Despachado', '2025-07-10 18:57:36', '2025-07-10 18:57:36', NULL),
	(127, 'DESPACHADO', 'Marco Antonio Espinoza Rojas', 'UR506489033CA', 'Paquete Despachado', '2025-07-10 18:58:23', '2025-07-10 18:58:23', NULL),
	(128, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'RF322074048ES', 'Paquete Recibido', '2025-07-10 19:02:23', '2025-07-10 19:02:23', NULL),
	(129, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'UR506489033CA', 'Paquete Recibido', '2025-07-10 19:02:28', '2025-07-10 19:02:28', NULL),
	(130, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'UR506481043CA', 'Paquete Recibido', '2025-07-10 19:10:03', '2025-07-10 19:10:03', NULL),
	(131, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'UR506489033CA', 'Paquete Entregado', '2025-07-10 19:10:46', '2025-07-10 19:10:46', NULL),
	(132, 'CREACION', 'Marco Antonio Espinoza Rojas', 'LH248642596US', 'Paquete Creado', '2025-07-10 19:28:37', '2025-07-10 19:28:37', NULL),
	(133, 'CREACION', 'Marco Antonio Espinoza Rojas', 'UP400165045LU', 'Paquete Creado', '2025-07-10 19:35:33', '2025-07-10 19:35:33', NULL),
	(134, 'CREACION', 'Marco Antonio Espinoza Rojas', 'UP400165045LU', 'Paquete Creado', '2025-07-10 19:36:41', '2025-07-10 19:36:41', NULL),
	(135, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400165045LU', 'Paquete Editado', '2025-07-10 19:36:46', '2025-07-10 19:36:46', NULL),
	(136, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400165045LU', 'Paquete Editado', '2025-07-10 19:36:53', '2025-07-10 19:36:53', NULL),
	(137, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400165045LU', 'Paquete Editado', '2025-07-10 19:36:58', '2025-07-10 19:36:58', NULL),
	(138, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'UP400165045LU', 'Paquete Recibido', '2025-07-10 19:38:26', '2025-07-10 19:38:26', NULL),
	(139, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400165047LU', 'Paquete Editado', '2025-07-10 19:38:32', '2025-07-10 19:38:32', NULL),
	(140, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'UP400165045LU', 'Paquete Entregado', '2025-07-10 19:40:08', '2025-07-10 19:40:08', NULL),
	(141, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete editado y precio recalculado', '2025-07-10 19:52:58', '2025-07-10 19:52:58', NULL),
	(142, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete editado y precio recalculado', '2025-07-10 19:54:22', '2025-07-10 19:54:22', NULL),
	(143, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete editado y precio recalculado', '2025-07-10 19:54:28', '2025-07-10 19:54:28', NULL),
	(144, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RF322074048ES', 'Paquete editado y precio recalculado', '2025-07-10 19:54:48', '2025-07-10 19:54:48', NULL),
	(145, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete Entregado', '2025-07-10 19:55:11', '2025-07-10 19:55:11', NULL),
	(146, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'LH248642596US', 'Paquete Recibido', '2025-07-10 19:57:52', '2025-07-10 19:57:52', NULL),
	(147, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'LH248642596US', 'Paquete Entregado', '2025-07-10 19:59:26', '2025-07-10 19:59:26', NULL),
	(148, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'RF322074048ES', 'Paquete Entregado', '2025-07-10 20:03:38', '2025-07-10 20:03:38', NULL),
	(149, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete Entregado', '2025-07-10 20:04:00', '2025-07-10 20:04:00', NULL),
	(150, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UP400250888LU', 'Paquete editado y precio recalculado', '2025-07-10 20:07:19', '2025-07-10 20:07:19', NULL),
	(151, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'UP400250888LU', 'Paquete Entregado', '2025-07-10 20:07:32', '2025-07-10 20:07:32', NULL),
	(152, 'ALTA', 'Marco Antonio Espinoza Rojas', 'UP400242643LU', 'Paquete Restaurado a Almacen', '2025-07-10 20:08:33', '2025-07-10 20:08:33', NULL),
	(153, 'ALTA', 'Marco Antonio Espinoza Rojas', 'UY161815126DE', 'Paquete Restaurado a Almacen', '2025-07-10 20:08:33', '2025-07-10 20:08:33', NULL),
	(154, 'ALTA', 'Marco Antonio Espinoza Rojas', 'LH248642596US', 'Paquete Restaurado a Almacen', '2025-07-10 20:08:35', '2025-07-10 20:08:35', NULL),
	(155, 'ALTA', 'Marco Antonio Espinoza Rojas', 'UY159222305DE', 'Paquete Restaurado a Almacen', '2025-07-10 20:08:35', '2025-07-10 20:08:35', NULL),
	(156, 'ALTA', 'Marco Antonio Espinoza Rojas', 'UR506489033CA', 'Paquete Restaurado a Almacen', '2025-07-10 20:08:36', '2025-07-10 20:08:36', NULL),
	(157, 'ALTA', 'Marco Antonio Espinoza Rojas', 'UP400165045LU', 'Paquete Restaurado a Almacen', '2025-07-10 20:08:37', '2025-07-10 20:08:37', NULL),
	(158, 'ALTA', 'Marco Antonio Espinoza Rojas', 'UY160984636DE', 'Paquete Restaurado a Almacen', '2025-07-10 20:08:37', '2025-07-10 20:08:37', NULL),
	(159, 'ALTA', 'Marco Antonio Espinoza Rojas', 'LH248642596US', 'Paquete Restaurado a Almacen', '2025-07-10 20:08:38', '2025-07-10 20:08:38', NULL),
	(160, 'ALTA', 'Marco Antonio Espinoza Rojas', 'RF322074048ES', 'Paquete Restaurado a Almacen', '2025-07-10 20:08:39', '2025-07-10 20:08:39', NULL),
	(161, 'EDICION', 'Marco Antonio Espinoza Rojas', 'UY161815126DE', 'Paquete editado y precio recalculado', '2025-07-10 20:09:06', '2025-07-10 20:09:06', NULL),
	(162, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'UY161815126DE', 'Paquete Entregado', '2025-07-10 20:09:10', '2025-07-10 20:09:10', NULL),
	(163, 'EDICION', 'Marco Antonio Espinoza Rojas', 'LH248642596US', 'Paquete editado y precio recalculado', '2025-07-10 20:12:45', '2025-07-10 20:12:45', NULL),
	(164, 'ENTREGADO', 'Marco Antonio Espinoza Rojas', 'LH248642596US', 'Paquete Entregado', '2025-07-10 20:12:48', '2025-07-10 20:12:48', NULL),
	(165, 'RECIBIDO', 'Marco Antonio Espinoza Rojas', 'UP400165047LU', 'Paquete Recibido', '2025-07-10 20:16:06', '2025-07-10 20:16:06', NULL),
	(166, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RF322074048ES', 'Paquete editado y precio recalculado', '2025-07-10 20:16:23', '2025-07-10 20:16:23', NULL),
	(167, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RF322074048ES', 'Paquete editado y precio recalculado', '2025-07-10 20:16:30', '2025-07-10 20:16:30', NULL),
	(168, 'EDICION', 'Marco Antonio Espinoza Rojas', 'RF322074048ES', 'Paquete editado y precio recalculado', '2025-07-10 20:17:29', '2025-07-10 20:17:29', NULL);

-- Volcando estructura para tabla gcpa.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.failed_jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla gcpa.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla gcpa.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.job_batches: ~0 rows (aproximadamente)

-- Volcando estructura para tabla gcpa.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.migrations: ~5 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_06_11_195557_create_permission_tables', 1),
	(5, '2025_06_11_221208_create_pulse_tables', 1);

-- Volcando estructura para tabla gcpa.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.model_has_permissions: ~0 rows (aproximadamente)

-- Volcando estructura para tabla gcpa.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.model_has_roles: ~3 rows (aproximadamente)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(1, 'App\\Models\\User', 3),
	(2, 'App\\Models\\User', 2);

-- Volcando estructura para tabla gcpa.paquetes
CREATE TABLE IF NOT EXISTS `paquetes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) DEFAULT NULL,
  `destinatario` varchar(50) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `cuidad` varchar(50) DEFAULT NULL,
  `peso` float DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `origen` varchar(50) DEFAULT NULL,
  `destino` varchar(50) DEFAULT NULL,
  `user` varchar(50) DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `photo` longtext DEFAULT NULL,
  `certificacion` int(11) DEFAULT NULL,
  `almacenaje` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `grupo` int(11) DEFAULT NULL,
  `pda` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gcpa.paquetes: ~24 rows (aproximadamente)
INSERT INTO `paquetes` (`id`, `codigo`, `destinatario`, `estado`, `cuidad`, `peso`, `precio`, `origen`, `destino`, `user`, `observacion`, `photo`, `certificacion`, `almacenaje`, `cantidad`, `grupo`, `pda`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'UY160984636DE', 'WORLD VISION BOLIVIA', 'INVENTARIO', 'LA PAZ', 0.63, 17.21, NULL, 'local', 'MARCO ANTONIO ESPINOZA ROJAS', 'X', NULL, 1, NULL, 1, NULL, NULL, '2025-06-18 00:44:22', '2025-07-10 20:04:00', '2025-07-10 20:04:00'),
	(2, 'UY160984634DE', 'WORLD VISION BOLIVIA', 'ENVIANDO', 'LA PAZ', 0.63, 9.21, NULL, 'local', 'Marco Antonio Espinoza Rojas', 'X', NULL, 0, 0, 1, 0, NULL, '2025-06-18 00:44:22', '2025-07-10 18:32:04', NULL),
	(3, 'UY160984635DE', 'WORLD VISION BOLIVIA', 'ENVIANDO', 'LA PAZ', 0.63, 24.21, NULL, 'local', 'MARCO ANTONIO ESPINOZA ROJAS', 'X', NULL, 0, 1, 1, 0, NULL, '2025-06-18 00:44:22', '2025-07-10 18:32:05', NULL),
	(4, 'RD000196175BO', 'ALDEAS INFANTILES SOS', 'INVENTARIO', 'LA PAZ', 3.3, 546, NULL, 'euro', 'Marco Antonio Espinoza Rojas', 'API EXTERNA', NULL, 1, NULL, 1, NULL, NULL, '2025-06-20 19:21:51', '2025-06-26 00:58:13', NULL),
	(5, 'UP400250889LU', 'WORLD VISION BOLIVIA', 'ALMACEN', 'LA PAZ', 0.21, 14.21, NULL, 'local', 'Marco Antonio Espinoza Rojas', 'X', NULL, 1, 1, 1, 1, NULL, '2025-06-23 17:42:04', '2025-07-10 20:03:50', NULL),
	(6, 'UP400250888LU', 'ALDEAS INFANTILES SOS', 'INVENTARIO', 'LA PAZ', 2, 8, NULL, 'local', 'Marco Antonio Espinoza Rojas', '', NULL, 0, 0, 1, 0, NULL, '2025-06-23 19:48:27', '2025-07-10 20:07:32', '2025-07-10 20:07:32'),
	(7, 'UY159222305DE', 'WORLD VISION BOLIVIA', 'ALMACEN', 'LA PAZ', 1.17, 0, NULL, 'local', NULL, '', NULL, NULL, NULL, 1, NULL, NULL, '2025-06-23 20:14:00', '2025-07-10 20:08:35', NULL),
	(8, 'UY160390561DE', 'WORLD VISION BOLIVIA', 'DESPACHADO', 'LA PAZ', 0.011, 11.8, NULL, 'local', 'Marco Antonio Espinoza Rojas', '', NULL, 1, NULL, 1, NULL, NULL, '2025-06-23 20:14:35', '2025-07-10 18:42:52', NULL),
	(9, 'UP400242643LU', 'WORLD VISION BOLIVIA', 'ALMACEN', 'LA PAZ', 0.21, 6.21, NULL, 'local', 'Marco Antonio Espinoza Rojas', NULL, NULL, NULL, NULL, 1, NULL, NULL, '2025-06-23 20:18:19', '2025-07-10 20:08:33', NULL),
	(10, 'LH248642596US', 'WORLD VISION BOLIVIA', 'INVENTARIO', 'LA PAZ', 0.5, 6.8, NULL, 'local', 'Marco Antonio Espinoza Rojas', '', NULL, 0, 0, 1, 0, 1741, '2025-06-23 23:07:58', '2025-07-10 20:12:48', '2025-07-10 20:12:48'),
	(12, 'RF322074048ES', 'WORLD VISION BOLIVIA', 'ALMACEN', 'COCHABAMBA', 0.12, 0, NULL, 'local', 'Marco Antonio Espinoza Rojas', '', NULL, 0, 0, 1, 0, NULL, '2025-06-24 19:49:14', '2025-07-10 20:17:29', NULL),
	(13, 'RB251312246IT', 'FUNDACION AYUDA EN ACCION', 'INVENTARIO', 'LA PAZ', 0.45, 108.9, NULL, 'sud', 'Marco Antonio Espinoza Rojas', '', NULL, NULL, NULL, 1, NULL, NULL, '2025-06-24 20:12:21', '2025-06-25 20:13:29', NULL),
	(14, 'UY161815126DE', 'WORLD VISION BOLIVIA', 'INVENTARIO', 'LA PAZ', 0.82, 0, NULL, 'local', 'Marco Antonio Espinoza Rojas', '', NULL, 0, 0, 1, 0, 2441, '2025-06-25 17:31:43', '2025-07-10 20:09:10', '2025-07-10 20:09:10'),
	(15, 'UY160984636DE', 'WORLD VISION BOLIVIA', 'ALMACEN', 'LA PAZ', 0.4, 6.8, NULL, 'local', 'Marco Antonio Espinoza Rojas', '', NULL, 1, 0, 1, 1, 0, '2025-06-25 23:35:36', '2025-07-10 20:08:37', NULL),
	(16, 'UY543233522DE', 'ENCOMIENDA', 'DESPACHADO', 'LA PAZ', 4, 323, NULL, 'sud', 'Marco Antonio Espinoza Rojas', '', NULL, 0, NULL, 12, 0, 2545, '2025-06-26 18:12:17', '2025-07-10 18:37:56', NULL),
	(17, 'UY159222305DE', 'ENCOMIENDA', 'DESPACHADO', 'LA PAZ', 4, 3460, NULL, 'centro', 'Marco Antonio Espinoza Rojas', '', NULL, 1, NULL, 10, NULL, NULL, '2025-06-26 18:21:28', '2025-06-26 18:47:38', NULL),
	(18, 'UP644880905CH', 'FUNDACION AYUDA EN ACCION', 'DESPACHADO', 'LA PAZ', 11, 23, NULL, 'centro', 'Marco Antonio Espinoza Rojas', '', NULL, 1, 1, 1, 1, 2545, '2025-06-26 18:29:07', '2025-07-10 18:43:21', NULL),
	(19, 'UR506481043CA', 'WORLD VISION BOLIVIA', 'RECIBIDO', 'LA PAZ', 0.015, 3.8, NULL, 'local', 'Marco Antonio Espinoza Rojas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-09 17:23:52', '2025-07-10 19:10:03', NULL),
	(20, 'UF105260739HK', 'WORLD VISION BOLIVIA', 'ENVIANDO', 'LA PAZ', 0.256, 14.8, NULL, 'local', 'Marco Antonio Espinoza Rojas', '', NULL, 1, NULL, 11, 0, NULL, '2025-07-09 20:07:20', '2025-07-10 18:32:07', NULL),
	(21, 'UY162197328DE', 'WORLD VISION BOLIVIA', 'ENVIANDO', 'LA PAZ', 0.256, 162.8, NULL, 'local', 'Marco Antonio Espinoza Rojas', '', NULL, 1, NULL, 11, 1, NULL, '2025-07-09 23:16:10', '2025-07-10 18:32:08', NULL),
	(22, 'UR506489033CA', 'WORLD VISION BOLIVIA', 'ALMACEN', 'LA PAZ', 0.65, 17.21, 'CANADA', 'local', 'Marco Antonio Espinoza Rojas', '', NULL, 1, 1, 1, 1, 2441, '2025-07-10 18:57:13', '2025-07-10 20:08:36', NULL),
	(23, 'LH248642596US', 'WORLD VISION BOLIVIA', 'ALMACEN', 'LA PAZ', 1565, 8, 'UNITED STATES', 'local', 'Marco Antonio Espinoza Rojas', '', NULL, 1, 1, NULL, 1, 2545, '2025-07-10 19:28:37', '2025-07-10 20:08:38', NULL),
	(24, 'UP400165047LU', 'WORLD VISION BOLIVIA', 'ALMACEN', 'ORURO', 0.45, 14.8, 'LUXEMBOURG', 'local', 'Marco Antonio Espinoza Rojas', '', NULL, 1, 1, 1, 1, 2441, '2025-07-10 19:35:33', '2025-07-10 20:16:06', NULL),
	(25, 'UP400165045LU', 'WORLD VISION BOLIVIA', 'ALMACEN', 'BENI', 0.65, 17.21, 'LUXEMBOURG', 'local', 'Marco Antonio Espinoza Rojas', '', NULL, 1, 0, 1, 0, 2441, '2025-07-10 19:36:41', '2025-07-10 20:08:37', NULL);

-- Volcando estructura para tabla gcpa.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla gcpa.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.permissions: ~5 rows (aproximadamente)
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'tarifario', 'web', '2025-06-24 23:06:49', '2025-06-24 23:06:49'),
	(2, 'enviar', 'web', '2025-06-24 23:07:03', '2025-06-24 23:07:03'),
	(3, 'recibir', 'web', '2025-06-24 23:07:12', '2025-06-24 23:07:12'),
	(4, 'visor', 'web', '2025-06-24 23:14:18', '2025-06-24 23:14:18'),
	(5, 'usuarios', 'web', '2025-06-24 23:24:55', '2025-06-24 23:24:55');

-- Volcando estructura para tabla gcpa.peso
CREATE TABLE IF NOT EXISTS `peso` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `max` float DEFAULT NULL,
  `min` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gcpa.peso: ~30 rows (aproximadamente)
INSERT INTO `peso` (`id`, `max`, `min`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(4, 0.02, 0.001, '2025-06-23 17:55:40', '2025-06-23 17:55:40', NULL),
	(5, 0.05, 0.021, '2025-06-23 17:55:54', '2025-06-23 17:55:54', NULL),
	(6, 0.1, 0.051, '2025-06-23 17:56:15', '2025-06-23 18:07:40', NULL),
	(7, 0.25, 0.101, '2025-06-23 17:56:29', '2025-06-23 17:56:29', NULL),
	(8, 0.5, 0.251, '2025-06-23 17:57:13', '2025-06-23 17:57:13', NULL),
	(9, 1, 0.501, '2025-06-23 17:57:26', '2025-06-23 17:57:26', NULL),
	(10, 2, 1.001, '2025-06-23 17:57:39', '2025-06-23 17:57:39', NULL),
	(11, 3, 2.001, '2025-06-23 17:57:47', '2025-06-23 17:57:47', NULL),
	(12, 4, 3.001, '2025-06-23 17:57:54', '2025-06-23 17:57:54', NULL),
	(13, 5, 4.001, '2025-06-23 17:58:05', '2025-06-23 17:58:05', NULL),
	(14, 0.1, 0.021, '2025-06-23 18:21:11', '2025-06-23 18:21:11', NULL),
	(15, 6, 5.001, '2025-06-23 18:24:45', '2025-06-23 18:24:45', NULL),
	(16, 7, 6.001, '2025-06-23 18:24:53', '2025-06-23 18:24:53', NULL),
	(17, 8, 7.001, '2025-06-23 18:25:02', '2025-06-23 18:25:02', NULL),
	(18, 9, 8.001, '2025-06-23 18:25:09', '2025-06-23 18:25:09', NULL),
	(19, 10, 9.001, '2025-06-23 18:25:16', '2025-06-23 18:25:16', NULL),
	(20, 11, 10.001, '2025-06-23 18:25:27', '2025-06-23 18:25:27', NULL),
	(21, 12, 11.001, '2025-06-23 18:25:40', '2025-06-23 18:25:40', NULL),
	(22, 14, 13.001, '2025-06-23 18:25:48', '2025-06-23 18:25:48', NULL),
	(23, 13, 12.001, '2025-06-23 18:25:57', '2025-06-23 18:25:57', NULL),
	(24, 16, 15.001, '2025-06-23 18:26:12', '2025-06-23 18:26:12', NULL),
	(25, 17, 16.001, '2025-06-23 18:26:28', '2025-06-23 18:26:28', NULL),
	(26, 18, 17.001, '2025-06-23 18:26:39', '2025-06-23 18:26:39', NULL),
	(27, 20, 19.001, '2025-06-23 18:26:47', '2025-06-23 18:26:47', NULL),
	(28, 19, 18.001, '2025-06-23 18:27:05', '2025-06-23 18:27:05', NULL),
	(29, 15, 14.001, '2025-06-23 18:33:06', '2025-06-23 18:33:06', NULL),
	(30, 0.03, 0.021, '2025-06-23 18:48:11', '2025-06-23 18:48:11', NULL),
	(31, 0.04, 0.031, '2025-06-23 18:48:35', '2025-06-23 18:48:35', NULL),
	(32, 0.05, 0.041, '2025-06-23 18:48:56', '2025-06-23 18:48:56', NULL),
	(33, 1, 0.001, '2025-06-25 19:15:22', '2025-06-25 19:15:22', NULL);

-- Volcando estructura para tabla gcpa.pulse_aggregates
CREATE TABLE IF NOT EXISTS `pulse_aggregates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bucket` int(10) unsigned NOT NULL,
  `period` mediumint(8) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `key` mediumtext NOT NULL,
  `key_hash` binary(16) GENERATED ALWAYS AS (unhex(md5(`key`))) VIRTUAL,
  `aggregate` varchar(255) NOT NULL,
  `value` decimal(20,2) NOT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pulse_aggregates_bucket_period_type_aggregate_key_hash_unique` (`bucket`,`period`,`type`,`aggregate`,`key_hash`),
  KEY `pulse_aggregates_period_bucket_index` (`period`,`bucket`),
  KEY `pulse_aggregates_type_index` (`type`),
  KEY `pulse_aggregates_period_type_aggregate_bucket_index` (`period`,`type`,`aggregate`,`bucket`)
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.pulse_aggregates: ~112 rows (aproximadamente)
INSERT INTO `pulse_aggregates` (`id`, `bucket`, `period`, `type`, `key`, `aggregate`, `value`, `count`) VALUES
	(1, 1752165420, 60, 'user_request', '1', 'count', 1.00, NULL),
	(2, 1752165360, 360, 'user_request', '1', 'count', 1.00, NULL),
	(3, 1752164640, 1440, 'user_request', '1', 'count', 1.00, NULL),
	(4, 1752156000, 10080, 'user_request', '1', 'count', 1.00, NULL),
	(5, 1752165420, 60, 'cache_hit', 'spatie.permission.cache', 'count', 1.00, NULL),
	(6, 1752165360, 360, 'cache_hit', 'spatie.permission.cache', 'count', 1.00, NULL),
	(7, 1752164640, 1440, 'cache_hit', 'spatie.permission.cache', 'count', 1.00, NULL),
	(8, 1752156000, 10080, 'cache_hit', 'spatie.permission.cache', 'count', 1.00, NULL),
	(9, 1752530220, 60, 'slow_request', '["GET","\\/","Closure"]', 'count', 1.00, NULL),
	(10, 1752530040, 360, 'slow_request', '["GET","\\/","Closure"]', 'count', 1.00, NULL),
	(11, 1752528960, 1440, 'slow_request', '["GET","\\/","Closure"]', 'count', 1.00, NULL),
	(12, 1752528960, 10080, 'slow_request', '["GET","\\/","Closure"]', 'count', 1.00, NULL),
	(13, 1752530220, 60, 'slow_request', '["GET","\\/","Closure"]', 'max', 2355.00, NULL),
	(14, 1752530040, 360, 'slow_request', '["GET","\\/","Closure"]', 'max', 2355.00, NULL),
	(15, 1752528960, 1440, 'slow_request', '["GET","\\/","Closure"]', 'max', 2355.00, NULL),
	(16, 1752528960, 10080, 'slow_request', '["GET","\\/","Closure"]', 'max', 2355.00, NULL),
	(17, 1752530220, 60, 'slow_request', '["GET","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@create"]', 'count', 1.00, NULL),
	(18, 1752530040, 360, 'slow_request', '["GET","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@create"]', 'count', 1.00, NULL),
	(19, 1752528960, 1440, 'slow_request', '["GET","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@create"]', 'count', 1.00, NULL),
	(20, 1752528960, 10080, 'slow_request', '["GET","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@create"]', 'count', 1.00, NULL),
	(21, 1752530220, 60, 'slow_request', '["GET","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@create"]', 'max', 1965.00, NULL),
	(22, 1752530040, 360, 'slow_request', '["GET","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@create"]', 'max', 1965.00, NULL),
	(23, 1752528960, 1440, 'slow_request', '["GET","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@create"]', 'max', 1965.00, NULL),
	(24, 1752528960, 10080, 'slow_request', '["GET","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@create"]', 'max', 1965.00, NULL),
	(25, 1752530220, 60, 'slow_request', '["POST","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@store"]', 'count', 1.00, NULL),
	(26, 1752530040, 360, 'slow_request', '["POST","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@store"]', 'count', 1.00, NULL),
	(27, 1752528960, 1440, 'slow_request', '["POST","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@store"]', 'count', 1.00, NULL),
	(28, 1752528960, 10080, 'slow_request', '["POST","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@store"]', 'count', 1.00, NULL),
	(29, 1752530220, 60, 'slow_user_request', '1', 'count', 2.00, NULL),
	(30, 1752530040, 360, 'slow_user_request', '1', 'count', 3.00, NULL),
	(31, 1752528960, 1440, 'slow_user_request', '1', 'count', 3.00, NULL),
	(32, 1752528960, 10080, 'slow_user_request', '1', 'count', 4.00, NULL),
	(33, 1752530220, 60, 'user_request', '1', 'count', 2.00, NULL),
	(34, 1752530040, 360, 'user_request', '1', 'count', 7.00, NULL),
	(35, 1752528960, 1440, 'user_request', '1', 'count', 7.00, NULL),
	(36, 1752528960, 10080, 'user_request', '1', 'count', 12.00, NULL),
	(37, 1752530220, 60, 'slow_request', '["POST","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@store"]', 'max', 1876.00, NULL),
	(38, 1752530040, 360, 'slow_request', '["POST","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@store"]', 'max', 1876.00, NULL),
	(39, 1752528960, 1440, 'slow_request', '["POST","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@store"]', 'max', 1876.00, NULL),
	(40, 1752528960, 10080, 'slow_request', '["POST","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@store"]', 'max', 1876.00, NULL),
	(41, 1752530220, 60, 'slow_request', '["GET","\\/dashboard","\\\\App\\\\Http\\\\Controllers\\\\DashboardController@index"]', 'count', 1.00, NULL),
	(42, 1752530040, 360, 'slow_request', '["GET","\\/dashboard","\\\\App\\\\Http\\\\Controllers\\\\DashboardController@index"]', 'count', 1.00, NULL),
	(43, 1752528960, 1440, 'slow_request', '["GET","\\/dashboard","\\\\App\\\\Http\\\\Controllers\\\\DashboardController@index"]', 'count', 1.00, NULL),
	(44, 1752528960, 10080, 'slow_request', '["GET","\\/dashboard","\\\\App\\\\Http\\\\Controllers\\\\DashboardController@index"]', 'count', 1.00, NULL),
	(45, 1752530220, 60, 'cache_miss', 'spatie.permission.cache', 'count', 1.00, NULL),
	(46, 1752530040, 360, 'cache_miss', 'spatie.permission.cache', 'count', 1.00, NULL),
	(47, 1752528960, 1440, 'cache_miss', 'spatie.permission.cache', 'count', 1.00, NULL),
	(48, 1752528960, 10080, 'cache_miss', 'spatie.permission.cache', 'count', 1.00, NULL),
	(57, 1752530220, 60, 'slow_request', '["GET","\\/dashboard","\\\\App\\\\Http\\\\Controllers\\\\DashboardController@index"]', 'max', 2995.00, NULL),
	(58, 1752530040, 360, 'slow_request', '["GET","\\/dashboard","\\\\App\\\\Http\\\\Controllers\\\\DashboardController@index"]', 'max', 2995.00, NULL),
	(59, 1752528960, 1440, 'slow_request', '["GET","\\/dashboard","\\\\App\\\\Http\\\\Controllers\\\\DashboardController@index"]', 'max', 2995.00, NULL),
	(60, 1752528960, 10080, 'slow_request', '["GET","\\/dashboard","\\\\App\\\\Http\\\\Controllers\\\\DashboardController@index"]', 'max', 2995.00, NULL),
	(61, 1752530280, 60, 'user_request', '1', 'count', 1.00, NULL),
	(65, 1752530340, 60, 'user_request', '1', 'count', 4.00, NULL),
	(69, 1752530340, 60, 'cache_hit', 'spatie.permission.cache', 'count', 3.00, NULL),
	(70, 1752530040, 360, 'cache_hit', 'spatie.permission.cache', 'count', 3.00, NULL),
	(71, 1752528960, 1440, 'cache_hit', 'spatie.permission.cache', 'count', 3.00, NULL),
	(72, 1752528960, 10080, 'cache_hit', 'spatie.permission.cache', 'count', 6.00, NULL),
	(77, 1752530340, 60, 'slow_request', '["GET","\\/users","App\\\\Http\\\\Controllers\\\\UserController@index"]', 'count', 1.00, NULL),
	(78, 1752530040, 360, 'slow_request', '["GET","\\/users","App\\\\Http\\\\Controllers\\\\UserController@index"]', 'count', 1.00, NULL),
	(79, 1752528960, 1440, 'slow_request', '["GET","\\/users","App\\\\Http\\\\Controllers\\\\UserController@index"]', 'count', 1.00, NULL),
	(80, 1752528960, 10080, 'slow_request', '["GET","\\/users","App\\\\Http\\\\Controllers\\\\UserController@index"]', 'count', 1.00, NULL),
	(81, 1752530340, 60, 'slow_user_request', '1', 'count', 1.00, NULL),
	(93, 1752530340, 60, 'slow_request', '["GET","\\/users","App\\\\Http\\\\Controllers\\\\UserController@index"]', 'max', 1364.00, NULL),
	(94, 1752530040, 360, 'slow_request', '["GET","\\/users","App\\\\Http\\\\Controllers\\\\UserController@index"]', 'max', 1364.00, NULL),
	(95, 1752528960, 1440, 'slow_request', '["GET","\\/users","App\\\\Http\\\\Controllers\\\\UserController@index"]', 'max', 1364.00, NULL),
	(96, 1752528960, 10080, 'slow_request', '["GET","\\/users","App\\\\Http\\\\Controllers\\\\UserController@index"]', 'max', 1364.00, NULL),
	(105, 1752530400, 60, 'slow_request', '["POST","\\/users","App\\\\Http\\\\Controllers\\\\UserController@store"]', 'count', 1.00, NULL),
	(106, 1752530400, 360, 'slow_request', '["POST","\\/users","App\\\\Http\\\\Controllers\\\\UserController@store"]', 'count', 1.00, NULL),
	(107, 1752530400, 1440, 'slow_request', '["POST","\\/users","App\\\\Http\\\\Controllers\\\\UserController@store"]', 'count', 1.00, NULL),
	(108, 1752528960, 10080, 'slow_request', '["POST","\\/users","App\\\\Http\\\\Controllers\\\\UserController@store"]', 'count', 1.00, NULL),
	(109, 1752530400, 60, 'slow_user_request', '1', 'count', 1.00, NULL),
	(110, 1752530400, 360, 'slow_user_request', '1', 'count', 1.00, NULL),
	(111, 1752530400, 1440, 'slow_user_request', '1', 'count', 1.00, NULL),
	(112, 1752530400, 60, 'user_request', '1', 'count', 5.00, NULL),
	(113, 1752530400, 360, 'user_request', '1', 'count', 5.00, NULL),
	(114, 1752530400, 1440, 'user_request', '1', 'count', 5.00, NULL),
	(115, 1752530400, 60, 'exception', '["Spatie\\\\Permission\\\\Exceptions\\\\RoleDoesNotExist","app\\\\Http\\\\Controllers\\\\UserController.php:47"]', 'count', 1.00, NULL),
	(116, 1752530400, 360, 'exception', '["Spatie\\\\Permission\\\\Exceptions\\\\RoleDoesNotExist","app\\\\Http\\\\Controllers\\\\UserController.php:47"]', 'count', 1.00, NULL),
	(117, 1752530400, 1440, 'exception', '["Spatie\\\\Permission\\\\Exceptions\\\\RoleDoesNotExist","app\\\\Http\\\\Controllers\\\\UserController.php:47"]', 'count', 1.00, NULL),
	(118, 1752528960, 10080, 'exception', '["Spatie\\\\Permission\\\\Exceptions\\\\RoleDoesNotExist","app\\\\Http\\\\Controllers\\\\UserController.php:47"]', 'count', 1.00, NULL),
	(121, 1752530400, 60, 'slow_request', '["POST","\\/users","App\\\\Http\\\\Controllers\\\\UserController@store"]', 'max', 5398.00, NULL),
	(122, 1752530400, 360, 'slow_request', '["POST","\\/users","App\\\\Http\\\\Controllers\\\\UserController@store"]', 'max', 5398.00, NULL),
	(123, 1752530400, 1440, 'slow_request', '["POST","\\/users","App\\\\Http\\\\Controllers\\\\UserController@store"]', 'max', 5398.00, NULL),
	(124, 1752528960, 10080, 'slow_request', '["POST","\\/users","App\\\\Http\\\\Controllers\\\\UserController@store"]', 'max', 5398.00, NULL),
	(125, 1752530400, 60, 'exception', '["Spatie\\\\Permission\\\\Exceptions\\\\RoleDoesNotExist","app\\\\Http\\\\Controllers\\\\UserController.php:47"]', 'max', 1752530435.00, NULL),
	(126, 1752530400, 360, 'exception', '["Spatie\\\\Permission\\\\Exceptions\\\\RoleDoesNotExist","app\\\\Http\\\\Controllers\\\\UserController.php:47"]', 'max', 1752530435.00, NULL),
	(127, 1752530400, 1440, 'exception', '["Spatie\\\\Permission\\\\Exceptions\\\\RoleDoesNotExist","app\\\\Http\\\\Controllers\\\\UserController.php:47"]', 'max', 1752530435.00, NULL),
	(128, 1752528960, 10080, 'exception', '["Spatie\\\\Permission\\\\Exceptions\\\\RoleDoesNotExist","app\\\\Http\\\\Controllers\\\\UserController.php:47"]', 'max', 1752530435.00, NULL),
	(129, 1752530400, 60, 'cache_hit', 'spatie.permission.cache', 'count', 3.00, NULL),
	(130, 1752530400, 360, 'cache_hit', 'spatie.permission.cache', 'count', 3.00, NULL),
	(131, 1752530400, 1440, 'cache_hit', 'spatie.permission.cache', 'count', 3.00, NULL),
	(157, 1752785520, 60, 'user_request', '1', 'count', 7.00, NULL),
	(158, 1752785280, 360, 'user_request', '1', 'count', 7.00, NULL),
	(159, 1752785280, 1440, 'user_request', '1', 'count', 7.00, NULL),
	(160, 1752780960, 10080, 'user_request', '1', 'count', 7.00, NULL),
	(161, 1752785520, 60, 'cache_miss', 'spatie.permission.cache', 'count', 1.00, NULL),
	(162, 1752785280, 360, 'cache_miss', 'spatie.permission.cache', 'count', 1.00, NULL),
	(163, 1752785280, 1440, 'cache_miss', 'spatie.permission.cache', 'count', 1.00, NULL),
	(164, 1752780960, 10080, 'cache_miss', 'spatie.permission.cache', 'count', 1.00, NULL),
	(169, 1752785520, 60, 'slow_request', '["POST","\\/users","via \\/livewire\\/update"]', 'count', 1.00, NULL),
	(170, 1752785280, 360, 'slow_request', '["POST","\\/users","via \\/livewire\\/update"]', 'count', 1.00, NULL),
	(171, 1752785280, 1440, 'slow_request', '["POST","\\/users","via \\/livewire\\/update"]', 'count', 1.00, NULL),
	(172, 1752780960, 10080, 'slow_request', '["POST","\\/users","via \\/livewire\\/update"]', 'count', 1.00, NULL),
	(173, 1752785520, 60, 'slow_user_request', '1', 'count', 1.00, NULL),
	(174, 1752785280, 360, 'slow_user_request', '1', 'count', 1.00, NULL),
	(175, 1752785280, 1440, 'slow_user_request', '1', 'count', 1.00, NULL),
	(176, 1752780960, 10080, 'slow_user_request', '1', 'count', 1.00, NULL),
	(177, 1752785520, 60, 'exception', '["Livewire\\\\Exceptions\\\\MethodNotFoundException","vendor\\\\livewire\\\\livewire\\\\src\\\\Mechanisms\\\\HandleComponents\\\\HandleComponents.php:470"]', 'count', 1.00, NULL),
	(178, 1752785280, 360, 'exception', '["Livewire\\\\Exceptions\\\\MethodNotFoundException","vendor\\\\livewire\\\\livewire\\\\src\\\\Mechanisms\\\\HandleComponents\\\\HandleComponents.php:470"]', 'count', 1.00, NULL),
	(179, 1752785280, 1440, 'exception', '["Livewire\\\\Exceptions\\\\MethodNotFoundException","vendor\\\\livewire\\\\livewire\\\\src\\\\Mechanisms\\\\HandleComponents\\\\HandleComponents.php:470"]', 'count', 1.00, NULL),
	(180, 1752780960, 10080, 'exception', '["Livewire\\\\Exceptions\\\\MethodNotFoundException","vendor\\\\livewire\\\\livewire\\\\src\\\\Mechanisms\\\\HandleComponents\\\\HandleComponents.php:470"]', 'count', 1.00, NULL),
	(185, 1752785520, 60, 'slow_request', '["POST","\\/users","via \\/livewire\\/update"]', 'max', 3158.00, NULL),
	(186, 1752785280, 360, 'slow_request', '["POST","\\/users","via \\/livewire\\/update"]', 'max', 3158.00, NULL),
	(187, 1752785280, 1440, 'slow_request', '["POST","\\/users","via \\/livewire\\/update"]', 'max', 3158.00, NULL),
	(188, 1752780960, 10080, 'slow_request', '["POST","\\/users","via \\/livewire\\/update"]', 'max', 3158.00, NULL),
	(189, 1752785520, 60, 'exception', '["Livewire\\\\Exceptions\\\\MethodNotFoundException","vendor\\\\livewire\\\\livewire\\\\src\\\\Mechanisms\\\\HandleComponents\\\\HandleComponents.php:470"]', 'max', 1752785552.00, NULL),
	(190, 1752785280, 360, 'exception', '["Livewire\\\\Exceptions\\\\MethodNotFoundException","vendor\\\\livewire\\\\livewire\\\\src\\\\Mechanisms\\\\HandleComponents\\\\HandleComponents.php:470"]', 'max', 1752785552.00, NULL),
	(191, 1752785280, 1440, 'exception', '["Livewire\\\\Exceptions\\\\MethodNotFoundException","vendor\\\\livewire\\\\livewire\\\\src\\\\Mechanisms\\\\HandleComponents\\\\HandleComponents.php:470"]', 'max', 1752785552.00, NULL),
	(192, 1752780960, 10080, 'exception', '["Livewire\\\\Exceptions\\\\MethodNotFoundException","vendor\\\\livewire\\\\livewire\\\\src\\\\Mechanisms\\\\HandleComponents\\\\HandleComponents.php:470"]', 'max', 1752785552.00, NULL),
	(193, 1752785520, 60, 'cache_hit', 'spatie.permission.cache', 'count', 3.00, NULL),
	(194, 1752785280, 360, 'cache_hit', 'spatie.permission.cache', 'count', 3.00, NULL),
	(195, 1752785280, 1440, 'cache_hit', 'spatie.permission.cache', 'count', 3.00, NULL),
	(196, 1752780960, 10080, 'cache_hit', 'spatie.permission.cache', 'count', 3.00, NULL);

-- Volcando estructura para tabla gcpa.pulse_entries
CREATE TABLE IF NOT EXISTS `pulse_entries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int(10) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `key` mediumtext NOT NULL,
  `key_hash` binary(16) GENERATED ALWAYS AS (unhex(md5(`key`))) VIRTUAL,
  `value` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pulse_entries_timestamp_index` (`timestamp`),
  KEY `pulse_entries_type_index` (`type`),
  KEY `pulse_entries_key_hash_index` (`key_hash`),
  KEY `pulse_entries_timestamp_type_key_hash_value_index` (`timestamp`,`type`,`key_hash`,`value`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.pulse_entries: ~46 rows (aproximadamente)
INSERT INTO `pulse_entries` (`id`, `timestamp`, `type`, `key`, `value`) VALUES
	(1, 1752165455, 'user_request', '1', NULL),
	(2, 1752165455, 'cache_hit', 'spatie.permission.cache', NULL),
	(3, 1752530252, 'slow_request', '["GET","\\/","Closure"]', 2355),
	(4, 1752530254, 'slow_request', '["GET","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@create"]', 1965),
	(5, 1752530267, 'slow_request', '["POST","\\/login","App\\\\Http\\\\Controllers\\\\Auth\\\\AuthenticatedSessionController@store"]', 1876),
	(6, 1752530267, 'slow_user_request', '1', NULL),
	(7, 1752530267, 'user_request', '1', NULL),
	(8, 1752530269, 'slow_request', '["GET","\\/dashboard","\\\\App\\\\Http\\\\Controllers\\\\DashboardController@index"]', 2995),
	(9, 1752530269, 'slow_user_request', '1', NULL),
	(10, 1752530269, 'user_request', '1', NULL),
	(11, 1752530270, 'cache_miss', 'spatie.permission.cache', NULL),
	(12, 1752530288, 'user_request', '1', NULL),
	(13, 1752530346, 'user_request', '1', NULL),
	(14, 1752530347, 'user_request', '1', NULL),
	(15, 1752530347, 'cache_hit', 'spatie.permission.cache', NULL),
	(16, 1752530367, 'slow_request', '["GET","\\/users","App\\\\Http\\\\Controllers\\\\UserController@index"]', 1364),
	(17, 1752530367, 'slow_user_request', '1', NULL),
	(18, 1752530367, 'user_request', '1', NULL),
	(19, 1752530369, 'cache_hit', 'spatie.permission.cache', NULL),
	(20, 1752530372, 'user_request', '1', NULL),
	(21, 1752530372, 'cache_hit', 'spatie.permission.cache', NULL),
	(22, 1752530434, 'slow_request', '["POST","\\/users","App\\\\Http\\\\Controllers\\\\UserController@store"]', 5398),
	(23, 1752530434, 'slow_user_request', '1', NULL),
	(24, 1752530434, 'user_request', '1', NULL),
	(25, 1752530435, 'exception', '["Spatie\\\\Permission\\\\Exceptions\\\\RoleDoesNotExist","app\\\\Http\\\\Controllers\\\\UserController.php:47"]', 1752530435),
	(26, 1752530447, 'user_request', '1', NULL),
	(27, 1752530447, 'cache_hit', 'spatie.permission.cache', NULL),
	(28, 1752530451, 'user_request', '1', NULL),
	(29, 1752530451, 'cache_hit', 'spatie.permission.cache', NULL),
	(30, 1752530458, 'user_request', '1', NULL),
	(31, 1752530459, 'user_request', '1', NULL),
	(32, 1752530459, 'cache_hit', 'spatie.permission.cache', NULL),
	(33, 1752785547, 'user_request', '1', NULL),
	(34, 1752785548, 'user_request', '1', NULL),
	(35, 1752785548, 'cache_miss', 'spatie.permission.cache', NULL),
	(36, 1752785552, 'slow_request', '["POST","\\/users","via \\/livewire\\/update"]', 3158),
	(37, 1752785552, 'slow_user_request', '1', NULL),
	(38, 1752785552, 'user_request', '1', NULL),
	(39, 1752785552, 'exception', '["Livewire\\\\Exceptions\\\\MethodNotFoundException","vendor\\\\livewire\\\\livewire\\\\src\\\\Mechanisms\\\\HandleComponents\\\\HandleComponents.php:470"]', 1752785552),
	(40, 1752785559, 'user_request', '1', NULL),
	(41, 1752785559, 'cache_hit', 'spatie.permission.cache', NULL),
	(42, 1752785562, 'user_request', '1', NULL),
	(43, 1752785562, 'cache_hit', 'spatie.permission.cache', NULL),
	(44, 1752785577, 'user_request', '1', NULL),
	(45, 1752785577, 'user_request', '1', NULL),
	(46, 1752785578, 'cache_hit', 'spatie.permission.cache', NULL);

-- Volcando estructura para tabla gcpa.pulse_values
CREATE TABLE IF NOT EXISTS `pulse_values` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int(10) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `key` mediumtext NOT NULL,
  `key_hash` binary(16) GENERATED ALWAYS AS (unhex(md5(`key`))) VIRTUAL,
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pulse_values_type_key_hash_unique` (`type`,`key_hash`),
  KEY `pulse_values_timestamp_index` (`timestamp`),
  KEY `pulse_values_type_index` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.pulse_values: ~0 rows (aproximadamente)

-- Volcando estructura para tabla gcpa.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.roles: ~3 rows (aproximadamente)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Administrador', 'web', '2025-06-24 23:04:30', '2025-06-24 23:04:30'),
	(2, 'Cartero', 'web', '2025-06-24 23:04:50', '2025-06-24 23:04:50'),
	(3, 'Informacion', 'web', '2025-06-24 23:14:06', '2025-06-24 23:14:06');

-- Volcando estructura para tabla gcpa.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.role_has_permissions: ~9 rows (aproximadamente)
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(2, 2),
	(3, 1),
	(3, 2),
	(4, 1),
	(4, 2),
	(4, 3),
	(5, 1);

-- Volcando estructura para tabla gcpa.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.sessions: ~2 rows (aproximadamente)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('63CgNoSJFHN5KVUfqBG7TKMuU6UzHQcIvoAHF5ah', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSWY3bnpiRmQ1NjR5UWJwYzFRa0g4UGVWTnpQQzR1SFA4cmdVQWR4OCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91c2VycyI7fXM6MTg6ImZsYXNoZXI6OmVudmVsb3BlcyI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1752530459),
	('DYRuorMlE37IFsCMIjDPxrthUJyFs94KnnwOJP0m', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiVlFlcmlqWEpvdkVBMG5IUzdBbURrQklIQTlWQWhVTVBVUzU2cm51OSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvdXNlcnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjE4OiJmbGFzaGVyOjplbnZlbG9wZXMiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1752785578);

-- Volcando estructura para tabla gcpa.tarifario
CREATE TABLE IF NOT EXISTS `tarifario` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `peso` int(11) DEFAULT NULL,
  `empresa` int(11) DEFAULT NULL,
  `local` float DEFAULT NULL,
  `nacional` float DEFAULT NULL,
  `camiri` float DEFAULT NULL,
  `sud` float DEFAULT NULL,
  `norte` float DEFAULT NULL,
  `centro` float DEFAULT NULL,
  `euro` float DEFAULT NULL,
  `asia` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gcpa.tarifario: ~95 rows (aproximadamente)
INSERT INTO `tarifario` (`id`, `peso`, `empresa`, `local`, `nacional`, `camiri`, `sud`, `norte`, `centro`, `euro`, `asia`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(20, 4, 11, NULL, NULL, NULL, 14.8, 20.8, 16.8, 23.8, 26.8, '2025-06-23 18:05:02', '2025-06-23 18:05:02', NULL),
	(21, 5, 11, NULL, NULL, NULL, 26.4, 38.4, 27.6, 40.8, 56.3, '2025-06-23 18:06:38', '2025-06-23 18:06:38', NULL),
	(22, 6, 11, NULL, NULL, NULL, 28.9, 42.9, 32.9, 46.9, 65.9, '2025-06-23 18:07:20', '2025-06-23 18:07:20', NULL),
	(23, 7, 11, NULL, NULL, NULL, 52.6, 83.6, 74.6, 90.6, 155.6, '2025-06-23 18:08:36', '2025-06-23 18:08:36', NULL),
	(24, 8, 11, NULL, NULL, NULL, 108.9, 126.9, 112.9, 136.9, 311.9, '2025-06-23 18:09:09', '2025-06-23 18:09:09', NULL),
	(25, 9, 11, NULL, NULL, NULL, 144.7, 222.7, 169.7, 270.7, 388.7, '2025-06-23 18:09:47', '2025-06-23 18:09:47', NULL),
	(26, 10, 11, NULL, NULL, NULL, 275.9, 312.9, 281.9, 364.9, 582.9, '2025-06-23 18:10:25', '2025-06-23 18:10:25', NULL),
	(27, 11, 11, NULL, NULL, NULL, 290.6, 415.6, 331.6, 472.6, 698.6, '2025-06-23 18:11:14', '2025-06-23 18:11:14', NULL),
	(28, 12, 11, NULL, NULL, NULL, 358.9, 481.9, 408.9, 596.9, 830.9, '2025-06-23 18:11:53', '2025-06-23 18:11:53', NULL),
	(29, 13, 11, NULL, NULL, NULL, 414.8, 535.8, 510.8, 699.8, 970.8, '2025-06-23 18:12:29', '2025-06-23 18:12:29', NULL),
	(30, 4, 15, 1.5, 4, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:20:38', '2025-06-23 18:20:38', NULL),
	(31, 14, 15, 2, 5.5, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:21:31', '2025-06-23 18:21:31', NULL),
	(32, 7, 15, 3.5, 6, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:21:55', '2025-06-23 18:21:55', NULL),
	(33, 8, 15, 4, 7, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:22:16', '2025-06-23 18:22:16', NULL),
	(34, 9, 15, 5, 8, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:22:32', '2025-06-23 18:24:04', NULL),
	(35, 10, 15, 9, 12, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:22:45', '2025-06-23 18:22:45', NULL),
	(36, 11, 15, 11, 16, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:22:59', '2025-06-23 18:22:59', NULL),
	(37, 12, 15, 13, 20, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:23:13', '2025-06-23 18:23:13', NULL),
	(38, 13, 15, 15, 24, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:23:31', '2025-06-23 18:23:31', NULL),
	(39, 15, 15, 21, 32, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:28:18', '2025-06-23 18:28:18', NULL),
	(40, 16, 15, 23, 36, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:28:37', '2025-06-23 18:28:37', NULL),
	(41, 17, 15, 24, 41, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:28:50', '2025-06-23 18:28:50', NULL),
	(42, 18, 15, 26, 45, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:29:07', '2025-06-23 18:29:07', NULL),
	(43, 19, 15, 28, 50, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:29:55', '2025-06-23 18:29:55', NULL),
	(44, 20, 15, 30, 54, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:30:12', '2025-06-23 18:30:12', NULL),
	(45, 21, 15, 32, 59, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:30:25', '2025-06-23 18:30:25', NULL),
	(46, 23, 15, 33, 63, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:30:39', '2025-06-23 18:30:39', NULL),
	(47, 22, 15, 35, 68, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:30:51', '2025-06-23 18:30:51', NULL),
	(48, 29, 15, 37, 72, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:36:54', '2025-06-23 18:36:54', NULL),
	(49, 24, 15, 39, 77, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:37:16', '2025-06-23 18:37:16', NULL),
	(50, 25, 15, 41, 81, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:37:31', '2025-06-23 18:37:31', NULL),
	(51, 26, 15, 42, 86, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:37:45', '2025-06-23 18:37:45', NULL),
	(52, 28, 15, 44, 90, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:37:56', '2025-06-23 18:37:56', NULL),
	(53, 27, 15, 46, 95, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:38:12', '2025-06-23 18:38:12', NULL),
	(54, 4, 12, NULL, NULL, NULL, 14, 19, 15, 22, 24, '2025-06-23 18:39:17', '2025-06-23 18:39:17', NULL),
	(55, 14, 12, NULL, NULL, NULL, 26, 38, 30, 43, 59, '2025-06-23 18:39:51', '2025-06-23 18:39:51', NULL),
	(56, 7, 12, NULL, NULL, NULL, 48, 76, 68, 82, 140, '2025-06-23 18:40:14', '2025-06-23 18:40:14', NULL),
	(57, 8, 12, NULL, NULL, NULL, 99, 104, 101, 124, 281, '2025-06-23 18:41:01', '2025-06-23 18:41:01', NULL),
	(58, 9, 12, NULL, NULL, NULL, 131, 202, 154, 244, 350, '2025-06-23 18:41:40', '2025-06-23 18:41:40', NULL),
	(59, 10, 12, NULL, NULL, NULL, 248, 282, 254, 328, 525, '2025-06-23 18:42:08', '2025-06-23 18:42:08', NULL),
	(60, 11, 12, NULL, NULL, NULL, 262, 374, 299, 426, 630, '2025-06-23 18:42:36', '2025-06-23 18:42:36', NULL),
	(61, 12, 12, NULL, NULL, NULL, 323, 434, 369, 538, 748, '2025-06-23 18:43:04', '2025-06-23 18:43:04', NULL),
	(62, 13, 12, NULL, NULL, NULL, 373, 482, 460, 631, 875, '2025-06-23 18:43:40', '2025-06-23 18:43:40', NULL),
	(63, 4, 13, NULL, NULL, NULL, 13, 18, 14, 21, 23, '2025-06-23 18:44:43', '2025-06-23 18:44:43', NULL),
	(64, 14, 13, NULL, NULL, NULL, 25, 37, 29, 41, 57, '2025-06-23 18:45:04', '2025-06-23 18:45:04', NULL),
	(65, 7, 13, NULL, NULL, NULL, 46, 73, 65, 79, 135, '2025-06-23 18:45:40', '2025-06-23 18:45:40', NULL),
	(66, 8, 13, NULL, NULL, NULL, 95, 100, 97, 119, 270, '2025-06-23 18:46:04', '2025-06-23 18:46:04', NULL),
	(67, 9, 13, NULL, NULL, NULL, 126, 194, 148, 235, 337, '2025-06-23 18:46:25', '2025-06-23 18:46:25', NULL),
	(68, 10, 13, NULL, NULL, NULL, 239, 271, 244, 316, 505, '2025-06-23 18:46:49', '2025-06-23 18:46:49', NULL),
	(69, 4, 14, 3.8, 5.74, 12, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:47:50', '2025-06-23 18:47:50', NULL),
	(70, 30, 14, 4.41, 6.38, 12.63, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:49:50', '2025-06-23 18:49:50', NULL),
	(71, 31, 14, 5, 6.38, 12.63, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:50:11', '2025-06-23 18:50:11', NULL),
	(72, 32, 14, 5, 6.38, 12.63, NULL, NULL, NULL, NULL, NULL, '2025-06-23 18:50:39', '2025-06-23 18:50:39', NULL),
	(73, 6, 14, 5.6, 6.99, 13.24, NULL, NULL, NULL, NULL, NULL, '2025-06-23 19:26:56', '2025-06-23 19:26:56', NULL),
	(74, 7, 14, 6.21, 7.63, 13.88, NULL, NULL, NULL, NULL, NULL, '2025-06-23 19:27:22', '2025-06-23 19:27:22', NULL),
	(75, 8, 14, 6.8, 8.86, 14.5, NULL, NULL, NULL, NULL, NULL, '2025-06-23 19:27:46', '2025-06-23 19:27:46', NULL),
	(76, 9, 14, 9.21, 9.5, 15.11, NULL, NULL, NULL, NULL, NULL, '2025-06-23 19:28:04', '2025-06-25 23:43:30', NULL),
	(77, 33, 16, NULL, NULL, NULL, 203, 232, 207, 290, 316, '2025-06-25 19:14:43', '2025-06-25 19:15:36', NULL),
	(78, 10, 16, NULL, NULL, NULL, 241, 309, 257, 394, 365, '2025-06-25 19:16:04', '2025-06-25 19:16:04', NULL),
	(79, 11, 16, NULL, NULL, NULL, 282, 387, 287, 497, 614, '2025-06-25 19:18:14', '2025-06-25 19:18:14', NULL),
	(80, 12, 16, NULL, NULL, NULL, 323, 464, 338, 601, 764, '2025-06-25 19:18:47', '2025-06-25 19:18:47', NULL),
	(81, 13, 16, NULL, NULL, NULL, 364, 541, 389, 704, 912, '2025-06-25 19:20:26', '2025-06-25 19:20:26', NULL),
	(82, 15, 16, NULL, NULL, NULL, 405, 619, 438, 808, 1062, '2025-06-25 19:20:56', '2025-06-25 19:20:56', NULL),
	(83, 16, 16, NULL, NULL, NULL, 446, 697, 489, 912, 1210, '2025-06-25 19:21:44', '2025-06-25 19:21:44', NULL),
	(84, 17, 16, NULL, NULL, NULL, 486, 775, 540, 1015, 1360, '2025-06-25 19:22:32', '2025-06-25 19:22:32', NULL),
	(85, 18, 16, NULL, NULL, NULL, 528, 852, 590, 1119, 1509, '2025-06-25 19:23:12', '2025-06-25 19:23:12', NULL),
	(86, 19, 16, NULL, NULL, NULL, 568, 930, 641, 1223, 1658, '2025-06-25 19:23:41', '2025-06-25 19:23:41', NULL),
	(87, 20, 16, NULL, NULL, NULL, 609, 1008, 692, 1327, 1807, '2025-06-25 19:24:12', '2025-06-25 19:24:12', NULL),
	(88, 21, 16, NULL, NULL, NULL, 650, 1085, 742, 1431, 1956, '2025-06-25 19:25:05', '2025-06-25 19:25:05', NULL),
	(89, 23, 16, NULL, NULL, NULL, 691, 1163, 793, 1534, 2105, '2025-06-25 19:25:37', '2025-06-25 19:25:37', NULL),
	(90, 22, 16, NULL, NULL, NULL, 731, 1241, 844, 1637, 2255, '2025-06-25 19:26:12', '2025-06-25 19:26:12', NULL),
	(91, 29, 16, NULL, NULL, NULL, 773, 1317, 894, 1741, 2403, '2025-06-25 19:28:02', '2025-06-25 19:28:02', NULL),
	(92, 24, 16, NULL, NULL, NULL, 814, 1395, 944, 1845, 2553, '2025-06-25 19:28:41', '2025-06-25 19:28:41', NULL),
	(93, 25, 16, NULL, NULL, NULL, 854, 1473, 995, 1948, 2702, '2025-06-25 19:29:11', '2025-06-25 19:29:11', NULL),
	(94, 26, 16, NULL, NULL, NULL, 896, 1550, 1046, 2052, 2851, '2025-06-25 19:30:04', '2025-06-25 19:30:04', NULL),
	(95, 28, 16, NULL, NULL, NULL, 936, 1628, 1096, 2156, 3001, '2025-06-25 19:31:18', '2025-06-25 19:31:18', NULL),
	(96, 27, 16, NULL, NULL, NULL, 977, 1706, 1147, 2260, 3149, '2025-06-25 19:31:57', '2025-06-25 19:31:57', NULL),
	(97, 4, 17, NULL, NULL, NULL, 13, 18, 14, 21, 23, '2025-06-23 18:44:43', '2025-06-23 18:44:43', NULL),
	(98, 14, 17, NULL, NULL, NULL, 25, 37, 29, 41, 57, '2025-06-23 18:45:04', '2025-06-23 18:45:04', NULL),
	(99, 7, 17, NULL, NULL, NULL, 46, 73, 65, 79, 135, '2025-06-23 18:45:40', '2025-06-23 18:45:40', NULL),
	(100, 8, 17, NULL, NULL, NULL, 95, 100, 97, 119, 270, '2025-06-23 18:46:04', '2025-06-23 18:46:04', NULL),
	(101, 9, 17, NULL, NULL, NULL, 126, 194, 148, 235, 337, '2025-06-23 18:46:25', '2025-06-23 18:46:25', NULL),
	(102, 10, 17, NULL, NULL, NULL, 239, 271, 244, 316, 505, '2025-06-23 18:46:49', '2025-06-23 18:46:49', NULL),
	(103, 4, 18, NULL, NULL, NULL, 13, 18, 14, 21, 23, '2025-06-23 18:44:43', '2025-06-23 18:44:43', NULL),
	(104, 14, 18, NULL, NULL, NULL, 25, 37, 29, 41, 57, '2025-06-23 18:45:04', '2025-06-23 18:45:04', NULL),
	(105, 7, 18, NULL, NULL, NULL, 46, 73, 65, 79, 135, '2025-06-23 18:45:40', '2025-06-23 18:45:40', NULL),
	(106, 8, 18, NULL, NULL, NULL, 95, 100, 97, 119, 270, '2025-06-23 18:46:04', '2025-06-23 18:46:04', NULL),
	(107, 9, 18, NULL, NULL, NULL, 126, 194, 148, 235, 337, '2025-06-23 18:46:25', '2025-06-23 18:46:25', NULL),
	(108, 10, 18, NULL, NULL, NULL, 239, 271, 244, 316, 505, '2025-06-23 18:46:49', '2025-06-23 18:46:49', NULL),
	(109, 4, 19, NULL, NULL, NULL, 13, 18, 14, 21, 23, '2025-06-23 18:44:43', '2025-06-23 18:44:43', NULL),
	(110, 14, 19, NULL, NULL, NULL, 25, 37, 29, 41, 57, '2025-06-23 18:45:04', '2025-06-23 18:45:04', NULL),
	(111, 7, 19, NULL, NULL, NULL, 46, 73, 65, 79, 135, '2025-06-23 18:45:40', '2025-06-23 18:45:40', NULL),
	(112, 8, 19, NULL, NULL, NULL, 95, 100, 97, 119, 270, '2025-06-23 18:46:04', '2025-06-23 18:46:04', NULL),
	(113, 9, 19, NULL, NULL, NULL, 126, 194, 148, 235, 337, '2025-06-23 18:46:25', '2025-06-23 18:46:25', NULL),
	(114, 10, 19, NULL, NULL, NULL, 239, 271, 244, 316, 505, '2025-06-23 18:46:49', '2025-06-23 18:46:49', NULL);

-- Volcando estructura para tabla gcpa.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `ci` int(11) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gcpa.users: ~3 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `city`, `ci`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Marco Antonio Espinoza Rojas', 'marco.espinoza@correos.gob.bo', 'LA PAZ', 10909669, NULL, '$2y$12$6o996n9VkbL6kW7yTLini.kURmIXU/nSmEfgk8afXS3bt1ntpFjji', NULL, '2025-06-12 18:47:07', '2025-06-23 22:38:38', NULL),
	(2, 'Edgar Javier Gironda Chiri', 'edgar.gironda@correos.gob.bo', 'LA PAZ', 4850032, NULL, '$2y$12$0x2IubG6nEVnZ6mu/OcwnOjPn7HM4OZskYC/bgbJ6sXsxSdCoWf3G', 'cuU880jcQGZH1JkO0ZYoTr04woy54zyFxn9hJ8c9AZs5ZBd5bOmh5nVvwvFv', '2025-06-24 23:13:05', '2025-06-24 23:13:05', NULL),
	(3, 'Josue Manriquez', 'josue.manriquez@correos.gob.bo', 'LA PAZ', 9134479, NULL, '$2y$12$O8NJ3h2Bx0wBvr0.vooFBeZd46jMuFYPrwoEHh28bA9ORJtOaj3/O', NULL, '2025-07-15 02:00:35', '2025-07-15 02:00:59', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
