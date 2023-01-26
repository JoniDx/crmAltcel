-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-01-2023 a las 16:27:07
-- Versión del servidor: 10.1.48-MariaDB-0ubuntu0.18.04.1
-- Versión de PHP: 7.2.24-0ubuntu0.18.04.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crm`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `users_consult`$$
CREATE DEFINER=`admin`@`localhost` PROCEDURE `users_consult` (IN `name_user` VARCHAR(255))  BEGIN
	SELECT * FROM users WHERE name = name_user COLLATE utf8_unicode_ci;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activations`
--

DROP TABLE IF EXISTS `activations`;
CREATE TABLE `activations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `numbers_id` bigint(20) UNSIGNED NOT NULL,
  `devices_id` bigint(20) UNSIGNED DEFAULT NULL,
  `serial_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `mac_address` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `who_did_id` bigint(20) UNSIGNED NOT NULL,
  `offer_id` bigint(20) UNSIGNED NOT NULL,
  `rate_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dependence_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` double(8,2) NOT NULL,
  `amount_device` float(8,2) DEFAULT NULL,
  `amount_rate` float(8,2) DEFAULT NULL,
  `received_amount_rate` double(8,2) DEFAULT '0.00',
  `received_amount_device` double(8,2) DEFAULT '0.00',
  `date_activation` date NOT NULL,
  `clientson_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lat_hbb` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `lng_hbb` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `payment_status` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT 'activated',
  `expire_date` date DEFAULT NULL,
  `petition_id` bigint(20) UNSIGNED DEFAULT NULL,
  `flag_rate` int(11) DEFAULT '1',
  `rate_subsequent` bigint(20) UNSIGNED DEFAULT NULL,
  `recharges` int(11) NOT NULL DEFAULT '0',
  `dealer_username` varchar(70) DEFAULT NULL,
  `order_id_activation` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `portabilidad` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `allnotifications`
--

DROP TABLE IF EXISTS `allnotifications`;
CREATE TABLE `allnotifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payload` text COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anothercompanies`
--

DROP TABLE IF EXISTS `anothercompanies`;
CREATE TABLE `anothercompanies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paterno` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `materno` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nombres` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `domicilio` text COLLATE utf8_spanish2_ci,
  `cp` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `municipio` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estado` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_spanish2_ci DEFAULT 'pendiente',
  `contacted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `comments` text COLLATE utf8_spanish2_ci,
  `hunted` tinyint(1) NOT NULL DEFAULT '0',
  `taken_by` bigint(20) UNSIGNED DEFAULT NULL,
  `taken_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assignments`
--

DROP TABLE IF EXISTS `assignments`;
CREATE TABLE `assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promoter_id` bigint(20) UNSIGNED NOT NULL,
  `number_id` bigint(20) UNSIGNED DEFAULT NULL,
  `device_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `status` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `changes`
--

DROP TABLE IF EXISTS `changes`;
CREATE TABLE `changes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number_id` bigint(20) UNSIGNED NOT NULL,
  `offer_id` bigint(20) UNSIGNED NOT NULL,
  `rate_id` bigint(20) UNSIGNED NOT NULL,
  `who_did_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` double(8,2) NOT NULL,
  `date` datetime NOT NULL,
  `reason` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'cobro',
  `order_id` varchar(50) DEFAULT NULL,
  `status` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'pendiente',
  `who_consigned` bigint(20) UNSIGNED DEFAULT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `pay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `channels`
--

DROP TABLE IF EXISTS `channels`;
CREATE TABLE `channels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `address` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `ine_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `rfc` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cellphone` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `date_born` date DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `who_did_id` bigint(20) UNSIGNED DEFAULT NULL,
  `interests` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientssons`
--

DROP TABLE IF EXISTS `clientssons`;
CREATE TABLE `clientssons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(90) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `lastname` varchar(90) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `rfc` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `date_born` date DEFAULT NULL,
  `address` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(60) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ine_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cellphone` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `type_person` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `type_person` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `rfc` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `address` text COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contracts`
--

DROP TABLE IF EXISTS `contracts`;
CREATE TABLE `contracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `lastnameP` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `lastnameM` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(60) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `rfc` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `cellphone` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `typePhone` varchar(5) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `street` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `exterior` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `interior` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `colonia` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `municipal` varchar(60) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `state` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `postal_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `marca` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `modelo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `serialNumber` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `deviceQuantity` int(11) NOT NULL,
  `devicePrice` double(8,2) NOT NULL,
  `ratePrice` double(8,2) NOT NULL,
  `product` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `msisdn` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `icc` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `invoiceBool` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `rightsMinBool` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `contractAdhesionBool` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `useInfoFirst` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `useInfoSecond` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `signature` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `activation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `who_did_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datainvoices`
--

DROP TABLE IF EXISTS `datainvoices`;
CREATE TABLE `datainvoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sat_code` bigint(20) NOT NULL,
  `unity_key_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `quantity` bigint(20) NOT NULL,
  `unity` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `unity_value` double(8,2) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `iva` double(8,2) NOT NULL,
  `invoice_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deactivations`
--

DROP TABLE IF EXISTS `deactivations`;
CREATE TABLE `deactivations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `MSISDN` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `effectiveDate` datetime NOT NULL,
  `order_id` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `reason` text COLLATE utf8_spanish2_ci NOT NULL,
  `activation_id` bigint(20) UNSIGNED NOT NULL,
  `who_did_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `amount` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependences`
--

DROP TABLE IF EXISTS `dependences`;
CREATE TABLE `dependences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `user` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devices`
--

DROP TABLE IF EXISTS `devices`;
CREATE TABLE `devices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_partida` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `material` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `no_serie_imei` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'available',
  `price` float(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directories`
--

DROP TABLE IF EXISTS `directories`;
CREATE TABLE `directories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `to_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `observations` text COLLATE utf8_spanish2_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `attended_by` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ethernetpays`
--

DROP TABLE IF EXISTS `ethernetpays`;
CREATE TABLE `ethernetpays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_pay` date NOT NULL,
  `date_pay_limit` date NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `instalation_id` bigint(20) UNSIGNED NOT NULL,
  `reference_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `amount_received` double(8,2) DEFAULT NULL,
  `type_pay` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `folio_pay` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `invoice_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `who_did_id` bigint(20) UNSIGNED DEFAULT NULL,
  `extra` float(8,2) NOT NULL DEFAULT '0.00',
  `status_consigned` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'pendiente',
  `who_consigned` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8_spanish2_ci NOT NULL,
  `queue` text COLLATE utf8_spanish2_ci NOT NULL,
  `payload` longtext COLLATE utf8_spanish2_ci NOT NULL,
  `exception` longtext COLLATE utf8_spanish2_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historics`
--

DROP TABLE IF EXISTS `historics`;
CREATE TABLE `historics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `oldMSISDN` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `date_change` datetime NOT NULL,
  `order_id` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `number_id` bigint(20) UNSIGNED NOT NULL,
  `who_did_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instalations`
--

DROP TABLE IF EXISTS `instalations`;
CREATE TABLE `instalations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_serie_antena` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `mac_address_antena` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `model_antena` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `no_serie_router` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `mac_address_router` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `model_router` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ip_address_antena` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `lat` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `lng` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `pack_id` bigint(20) UNSIGNED NOT NULL,
  `radiobase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `number` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `serial_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `who_did_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `amount_install` double(8,2) DEFAULT NULL,
  `amount_total` double(8,2) DEFAULT NULL,
  `received_amount` double(8,2) DEFAULT '0.00',
  `received_amount_install` double(8,2) DEFAULT '0.00',
  `date_instalation` date NOT NULL,
  `clientson_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_status` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventories`
--

DROP TABLE IF EXISTS `inventories`;
CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `number_id` bigint(20) UNSIGNED DEFAULT NULL,
  `device_id` bigint(20) UNSIGNED DEFAULT NULL,
  `who_did_id` bigint(20) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
  `id` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `rfc_emisor` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `name_emisor` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `rfc_recptor` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `name_recptor` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `uso_cfdi` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `date_expedition` datetime NOT NULL,
  `method_payment` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `way_payment` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `iva` double(8,2) NOT NULL,
  `subtotal` double(8,2) NOT NULL,
  `total` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monthly_payments_dayli`
--

DROP TABLE IF EXISTS `monthly_payments_dayli`;
CREATE TABLE `monthly_payments_dayli` (
  `fecha` date DEFAULT NULL,
  `monto` double(8,2) DEFAULT NULL,
  `sim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identifier` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `effectiveDate` datetime DEFAULT NULL,
  `eventType` varchar(30) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `detail` text COLLATE utf8_spanish2_ci,
  `date_notification` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `seen` tinyint(1) NOT NULL,
  `who_attended` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `numbers`
--

DROP TABLE IF EXISTS `numbers`;
CREATE TABLE `numbers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `be_id` varchar(5) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `imsi` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `imsi_rb1` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `imsi_rb2` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `icc_id` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `MSISDN` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `pin` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `puk` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `serie` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `producto` varchar(5) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'available',
  `traffic_outbound` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'activo',
  `traffic_outbound_incoming` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'activo',
  `status_altan` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'activo',
  `status_imei` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'unlocked',
  `ported` int(11) NOT NULL DEFAULT '0',
  `preRegistro` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `numberscompanies`
--

DROP TABLE IF EXISTS `numberscompanies`;
CREATE TABLE `numberscompanies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `date_to_reharge` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `offers`
--

DROP TABLE IF EXISTS `offers`;
CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `offerID` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `product_altan` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `action` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `product` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `recurrency` varchar(5) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `price_s_iva` double(8,2) NOT NULL,
  `price_c_iva` double(8,2) NOT NULL,
  `price_sale` double(8,2) NOT NULL,
  `offerID_second` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `name_second` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `product_altan_second` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `type` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `offerID_excedente` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `convivencia` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `otherpetitions`
--

DROP TABLE IF EXISTS `otherpetitions`;
CREATE TABLE `otherpetitions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `who_did_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `number_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `comment` text COLLATE utf8_spanish2_ci,
  `status` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `who_attended` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `packs`
--

DROP TABLE IF EXISTS `packs`;
CREATE TABLE `packs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `recurrency` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `price_s_iva` float(8,2) DEFAULT NULL,
  `price_install` double(8,2) NOT NULL,
  `service_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `status` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pays`
--

DROP TABLE IF EXISTS `pays`;
CREATE TABLE `pays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_pay` date NOT NULL,
  `date_pay_limit` date NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `activation_id` bigint(20) UNSIGNED NOT NULL,
  `reference_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `amount_received` double(8,2) DEFAULT NULL,
  `type_pay` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `folio_pay` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `invoice_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `who_did_id` bigint(20) UNSIGNED DEFAULT NULL,
  `extra` float(8,2) NOT NULL DEFAULT '0.00',
  `status_consigned` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'pendiente',
  `who_consigned` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `petitions`
--

DROP TABLE IF EXISTS `petitions`;
CREATE TABLE `petitions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `date_sent` datetime NOT NULL,
  `date_activated` datetime DEFAULT NULL,
  `date_received` datetime DEFAULT NULL,
  `who_attended` bigint(20) UNSIGNED DEFAULT NULL,
  `who_received` bigint(20) UNSIGNED DEFAULT NULL,
  `collected_rate` float(8,2) DEFAULT NULL,
  `collected_device` float(8,2) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `product` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `rate_activation` bigint(20) UNSIGNED DEFAULT NULL,
  `rate_secondary` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_way` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `plazo` int(11) DEFAULT NULL,
  `sold_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `number_id` bigint(20) UNSIGNED DEFAULT NULL,
  `device_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date_to_activate` date DEFAULT NULL,
  `lat_hbb` varchar(50) DEFAULT NULL,
  `lng_hbb` varchar(50) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `mac_address` varchar(100) DEFAULT NULL,
  `icc` varchar(50) DEFAULT NULL,
  `imei` varchar(50) DEFAULT NULL,
  `lada` varchar(20) DEFAULT 'SIN CAMBIO DE LADA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `politics`
--

DROP TABLE IF EXISTS `politics`;
CREATE TABLE `politics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `porcent` float(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `portabilities`
--

DROP TABLE IF EXISTS `portabilities`;
CREATE TABLE `portabilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `msisdnTransitory` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `icc` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `msisdnPorted` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `imsi` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `approvedDateABD` date DEFAULT NULL,
  `date` date NOT NULL,
  `dida` varchar(20) COLLATE utf8_spanish2_ci DEFAULT 'POR DEFINIR',
  `rida` varchar(5) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `dcr` varchar(20) COLLATE utf8_spanish2_ci DEFAULT 'POR DEFINIR',
  `rcr` varchar(5) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nip` varchar(15) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `order_id` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'pendiente',
  `who_did_it` bigint(20) UNSIGNED DEFAULT NULL,
  `sold_by` bigint(20) UNSIGNED DEFAULT NULL,
  `who_attended` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comments` text COLLATE utf8_spanish2_ci,
  `rate_id` int(11) DEFAULT NULL,
  `import_to_altan` tinyint(1) NOT NULL DEFAULT '0',
  `order_id_import` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `dealer_username` varchar(70) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ABD` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promotions`
--

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `device_quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prospects`
--

DROP TABLE IF EXISTS `prospects`;
CREATE TABLE `prospects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `cp` varchar(6) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchases`
--

DROP TABLE IF EXISTS `purchases`;
CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number_id` bigint(20) UNSIGNED NOT NULL,
  `offer_id` bigint(20) UNSIGNED NOT NULL,
  `rate_id` bigint(20) UNSIGNED NOT NULL,
  `who_did_id` bigint(20) UNSIGNED NOT NULL,
  `amount` float(8,2) NOT NULL,
  `date` datetime NOT NULL,
  `reason` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'cobro',
  `status` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'pendiente',
  `who_consigned` bigint(20) UNSIGNED DEFAULT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `order_id` varchar(50) NOT NULL,
  `order_id_conekta` varchar(50) DEFAULT NULL,
  `order_id_gestor` varchar(100) DEFAULT NULL,
  `gestor` varchar(100) DEFAULT NULL,
  `fee_amount` float(8,2) NOT NULL DEFAULT '0.00',
  `from_system` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchases_dayli`
--

DROP TABLE IF EXISTS `purchases_dayli`;
CREATE TABLE `purchases_dayli` (
  `ejecutado_por` varchar(511) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `monto` float(8,2) DEFAULT NULL,
  `plan` varchar(255) DEFAULT NULL,
  `sim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `radiobases`
--

DROP TABLE IF EXISTS `radiobases`;
CREATE TABLE `radiobases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `address` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `ip_address` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `lat` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `lng` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rates`
--

DROP TABLE IF EXISTS `rates`;
CREATE TABLE `rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `price_subsequent` double(8,2) DEFAULT NULL,
  `price_list` double(8,2) DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `recurrency` bigint(20) NOT NULL,
  `alta_offer_id` bigint(20) UNSIGNED NOT NULL,
  `stripe_id_product` varchar(255) DEFAULT NULL,
  `altcel_pack_id` bigint(20) DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT 'activo',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'publico',
  `promo_bool` int(11) NOT NULL DEFAULT '0',
  `plazo` int(11) DEFAULT '0',
  `device_price` float(8,2) DEFAULT '0.00',
  `promotion_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recharges`
--

DROP TABLE IF EXISTS `recharges`;
CREATE TABLE `recharges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `number_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rate_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_expiration` date DEFAULT NULL,
  `status` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rechargesbulks`
--

DROP TABLE IF EXISTS `rechargesbulks`;
CREATE TABLE `rechargesbulks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `msisdn` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `effectiveDate` datetime DEFAULT NULL,
  `order_id` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `statusCode` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `number_id` bigint(20) UNSIGNED NOT NULL,
  `offer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `references`
--

DROP TABLE IF EXISTS `references`;
CREATE TABLE `references` (
  `reference_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `reference` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `authorizacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `transaction_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `description` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `error_message` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `order_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `payment_method` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `currency` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `event_date_create` datetime DEFAULT NULL,
  `event_date_complete` datetime DEFAULT NULL,
  `fee_amount` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fee_tax` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fee_currency` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `referencestype_id` bigint(20) UNSIGNED NOT NULL,
  `offer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `channel_id` bigint(20) UNSIGNED DEFAULT NULL,
  `number_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rate_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `device_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pack_id` bigint(20) UNSIGNED DEFAULT NULL,
  `url_card_payment` varchar(500) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `channel_system` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referencestypes`
--

DROP TABLE IF EXISTS `referencestypes`;
CREATE TABLE `referencestypes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rol` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schedules`
--

DROP TABLE IF EXISTS `schedules`;
CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_install_init` datetime NOT NULL,
  `date_install_final` datetime NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `reference_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `lastname` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `cellphone` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `pack_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `who_did_id` bigint(20) UNSIGNED NOT NULL,
  `instalation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shippings`
--

DROP TABLE IF EXISTS `shippings`;
CREATE TABLE `shippings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cp` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `colonia` varchar(60) COLLATE utf8_spanish2_ci DEFAULT 'N/A',
  `tipo_asentamiento` varchar(40) COLLATE utf8_spanish2_ci DEFAULT 'N/A',
  `municipio` varchar(60) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estado` varchar(40) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ciudad` varchar(60) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `pais` varchar(30) COLLATE utf8_spanish2_ci DEFAULT 'MEXICO',
  `no_exterior` varchar(10) COLLATE utf8_spanish2_ci DEFAULT 'N/A',
  `no_interior` varchar(10) COLLATE utf8_spanish2_ci DEFAULT 'N/A',
  `phone_contact` varchar(15) COLLATE utf8_spanish2_ci DEFAULT 'N/A',
  `referencias` text COLLATE utf8_spanish2_ci,
  `recibe` varchar(70) COLLATE utf8_spanish2_ci DEFAULT 'N/A',
  `phone_alternative` varchar(15) COLLATE utf8_spanish2_ci DEFAULT 'N/A',
  `canal` varchar(20) COLLATE utf8_spanish2_ci DEFAULT 'N/A',
  `fecha_entregado` datetime DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'pendiente',
  `icc` varchar(30) COLLATE utf8_spanish2_ci DEFAULT 'N/A',
  `imei` varchar(20) COLLATE utf8_spanish2_ci DEFAULT 'N/A',
  `serial_number` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `mac_address` varchar(30) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `sold_by` bigint(20) UNSIGNED NOT NULL,
  `attended_by` bigint(20) UNSIGNED DEFAULT NULL,
  `to_id` bigint(20) UNSIGNED NOT NULL,
  `zona` varchar(15) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ine_front` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ine_back` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `rate_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rate_price` double(8,2) DEFAULT NULL,
  `device_price` double(8,2) DEFAULT '0.00',
  `shipping_price` double(8,2) DEFAULT NULL,
  `reference_id` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `completed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `attended_at` datetime DEFAULT NULL,
  `comments` text COLLATE utf8_spanish2_ci,
  `observations` text COLLATE utf8_spanish2_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `simexternals`
--

DROP TABLE IF EXISTS `simexternals`;
CREATE TABLE `simexternals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sim_altcel` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `activation_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status_portability`
--

DROP TABLE IF EXISTS `status_portability`;
CREATE TABLE `status_portability` (
  `id` bigint(20) NOT NULL,
  `BE` int(11) DEFAULT NULL,
  `accion` varchar(250) DEFAULT NULL,
  `DN_portado` varchar(10) DEFAULT NULL,
  `IMSI` varchar(20) DEFAULT NULL,
  `date_ABD` date DEFAULT NULL,
  `date_ejecucion` date DEFAULT NULL,
  `RIDA` varchar(5) DEFAULT NULL,
  `RCR` varchar(5) DEFAULT NULL,
  `DIDA` varchar(20) DEFAULT NULL,
  `DCR` varchar(20) DEFAULT NULL,
  `estado` varchar(250) DEFAULT NULL,
  `detalles` varchar(250) DEFAULT NULL,
  `DN_transitorio` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `surplus_reference_payments_dayli`
--

DROP TABLE IF EXISTS `surplus_reference_payments_dayli`;
CREATE TABLE `surplus_reference_payments_dayli` (
  `fecha` datetime DEFAULT NULL,
  `monto` decimal(8,2) DEFAULT NULL,
  `sim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL DEFAULT '3',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `prospect_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dealer_username` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_activos_suspendidos`
--

DROP TABLE IF EXISTS `usuarios_activos_suspendidos`;
CREATE TABLE `usuarios_activos_suspendidos` (
  `contacto` varchar(511) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `servicio` varchar(5) DEFAULT NULL,
  `SIM` varchar(255) DEFAULT NULL,
  `suscriptor` varchar(181) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activations`
--
ALTER TABLE `activations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `allnotifications`
--
ALTER TABLE `allnotifications`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `anothercompanies`
--
ALTER TABLE `anothercompanies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `changes`
--
ALTER TABLE `changes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `channels`
--
ALTER TABLE `channels`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientssons`
--
ALTER TABLE `clientssons`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `datainvoices`
--
ALTER TABLE `datainvoices`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `deactivations`
--
ALTER TABLE `deactivations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dependences`
--
ALTER TABLE `dependences`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `directories`
--
ALTER TABLE `directories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ethernetpays`
--
ALTER TABLE `ethernetpays`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historics`
--
ALTER TABLE `historics`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `instalations`
--
ALTER TABLE `instalations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `numbers`
--
ALTER TABLE `numbers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `packs`
--
ALTER TABLE `packs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `petitions`
--
ALTER TABLE `petitions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `portabilities`
--
ALTER TABLE `portabilities`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prospects`
--
ALTER TABLE `prospects`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `radiobases`
--
ALTER TABLE `radiobases`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recharges`
--
ALTER TABLE `recharges`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rechargesbulks`
--
ALTER TABLE `rechargesbulks`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `references`
--
ALTER TABLE `references`
  ADD PRIMARY KEY (`reference_id`);

--
-- Indices de la tabla `referencestypes`
--
ALTER TABLE `referencestypes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `simexternals`
--
ALTER TABLE `simexternals`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `status_portability`
--
ALTER TABLE `status_portability`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activations`
--
ALTER TABLE `activations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4348;
--
-- AUTO_INCREMENT de la tabla `allnotifications`
--
ALTER TABLE `allnotifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21161;
--
-- AUTO_INCREMENT de la tabla `anothercompanies`
--
ALTER TABLE `anothercompanies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT de la tabla `changes`
--
ALTER TABLE `changes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;
--
-- AUTO_INCREMENT de la tabla `channels`
--
ALTER TABLE `channels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4557;
--
-- AUTO_INCREMENT de la tabla `clientssons`
--
ALTER TABLE `clientssons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=755;
--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `datainvoices`
--
ALTER TABLE `datainvoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `deactivations`
--
ALTER TABLE `deactivations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `dependences`
--
ALTER TABLE `dependences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `devices`
--
ALTER TABLE `devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;
--
-- AUTO_INCREMENT de la tabla `directories`
--
ALTER TABLE `directories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;
--
-- AUTO_INCREMENT de la tabla `ethernetpays`
--
ALTER TABLE `ethernetpays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;
--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `historics`
--
ALTER TABLE `historics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;
--
-- AUTO_INCREMENT de la tabla `instalations`
--
ALTER TABLE `instalations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT de la tabla `numbers`
--
ALTER TABLE `numbers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42916;
--
-- AUTO_INCREMENT de la tabla `pays`
--
ALTER TABLE `pays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=595;
--
-- AUTO_INCREMENT de la tabla `petitions`
--
ALTER TABLE `petitions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=794;
--
-- AUTO_INCREMENT de la tabla `portabilities`
--
ALTER TABLE `portabilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3309;
--
-- AUTO_INCREMENT de la tabla `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `prospects`
--
ALTER TABLE `prospects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de la tabla `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1728;
--
-- AUTO_INCREMENT de la tabla `radiobases`
--
ALTER TABLE `radiobases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `rates`
--
ALTER TABLE `rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
--
-- AUTO_INCREMENT de la tabla `recharges`
--
ALTER TABLE `recharges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `rechargesbulks`
--
ALTER TABLE `rechargesbulks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;
--
-- AUTO_INCREMENT de la tabla `referencestypes`
--
ALTER TABLE `referencestypes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=438;
--
-- AUTO_INCREMENT de la tabla `simexternals`
--
ALTER TABLE `simexternals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `status_portability`
--
ALTER TABLE `status_portability`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3043;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44972;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
