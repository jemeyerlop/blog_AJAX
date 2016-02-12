-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-05-2015 a las 02:10:05
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bd_blog`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_articulos`
--

CREATE TABLE IF NOT EXISTS `blog_articulos` (
  `articulo_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `articulo_titulo` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `articulo_desc` text COLLATE utf8_spanish2_ci,
  `articulo_cat_id` mediumint(9) NOT NULL,
  `articulo_url` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `articulo_usuario_id_autor` mediumint(9) NOT NULL,
  `articulo_fecha_creacion` datetime NOT NULL,
  `articulo_fecha_modificacion` datetime DEFAULT NULL,
  `articulo_estado` tinyint(4) NOT NULL,
  PRIMARY KEY (`articulo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_categorias`
--

CREATE TABLE IF NOT EXISTS `blog_categorias` (
  `cat_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `cat_nombre` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `cat_fecha_creacion` datetime NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `blog_categorias`
--

INSERT INTO `blog_categorias` (`cat_id`, `cat_nombre`, `cat_fecha_creacion`) VALUES
(1, 'stand_by', '2015-05-17 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_comentarios`
--

CREATE TABLE IF NOT EXISTS `blog_comentarios` (
  `comentario_id` bigint(12) unsigned NOT NULL AUTO_INCREMENT,
  `comentario_usuario_id_autor` mediumint(9) NOT NULL,
  `comentario_articulo_id` mediumint(9) NOT NULL,
  `comentario_texto` text COLLATE utf8_spanish2_ci NOT NULL,
  `comentario_fecha_creacion` datetime NOT NULL,
  PRIMARY KEY (`comentario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_usuarios`
--

CREATE TABLE IF NOT EXISTS `blog_usuarios` (
  `usuario_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `usuario_nombre` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_apellido` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_correo` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_password` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_rol` tinyint(4) NOT NULL,
  `usuario_fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `blog_usuarios`
--

INSERT INTO `blog_usuarios` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_correo`, `usuario_password`, `usuario_rol`, `usuario_fecha_registro`) VALUES
(1, 'juan enrique', 'meyer', 'jemeyerlop@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, '2015-05-04 13:24:46');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
