-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-05-2015 a las 01:54:45
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `blog_articulos`
--

INSERT INTO `blog_articulos` (`articulo_id`, `articulo_titulo`, `articulo_desc`, `articulo_cat_id`, `articulo_url`, `articulo_usuario_id_autor`, `articulo_fecha_creacion`, `articulo_fecha_modificacion`, `articulo_estado`) VALUES
(1, 'art1', '&lt;p&gt;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/p&gt;\r\n&lt;p&gt;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/p&gt;', 3, 'imagen_3333.jpg', 1, '2015-05-17 19:45:13', '2015-05-17 19:57:33', 1),
(2, 'art2', '&lt;p&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).&lt;/p&gt;\r\n&lt;p&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).&lt;/p&gt;', 2, 'imagen_2008.jpg', 1, '2015-05-17 19:50:12', '2015-05-17 19:57:23', 1),
(3, 'art3', '&lt;p&gt;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.&lt;/p&gt;\r\n&lt;p&gt;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.&lt;/p&gt;', 4, 'imagen_5218.jpg', 1, '2015-05-17 19:50:35', '2015-05-17 19:58:23', 1),
(4, 'texto1', '&lt;p&gt;There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn''t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.&lt;/p&gt;\r\n&lt;p&gt;There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn''t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.&lt;/p&gt;', 2, 'imagen_543.jpg', 1, '2015-05-17 19:51:19', '2015-05-17 19:59:21', 1),
(5, 'texto2', '&lt;p&gt;The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &quot;de Finibus Bonorum et Malorum&quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.&lt;/p&gt;\r\n&lt;p&gt;The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &quot;de Finibus Bonorum et Malorum&quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.&lt;/p&gt;', 3, 'imagen_145.jpg', 1, '2015-05-17 19:51:40', '2015-05-17 19:58:12', 1),
(6, 'texto3', '&lt;p&gt;&quot;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;&lt;/p&gt;\r\n&lt;p&gt;&quot;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;&lt;/p&gt;', 2, 'imagen_4018.jpg', 1, '2015-05-17 19:53:08', '2015-05-17 19:58:05', 1),
(7, 'decir1', '&lt;p&gt;&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&quot;&lt;/p&gt;\r\n&lt;p&gt;&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&quot;&lt;/p&gt;', 4, 'imagen_9733.jpg', 1, '2015-05-17 19:53:34', '2015-05-17 19:58:32', 1),
(8, 'decir2', '&lt;p&gt;&quot;But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?&quot;&lt;/p&gt;', 3, 'imagen_3813.jpg', 1, '2015-05-17 19:54:30', '2015-05-17 19:58:40', 1),
(9, 'decir3', '&lt;p&gt;&quot;But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?&quot;&lt;/p&gt;\r\n&lt;p&gt;&quot;At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio&lt;/p&gt;', 4, 'imagen_9122.jpg', 1, '2015-05-17 19:54:52', '2015-05-17 19:58:47', 1),
(10, 'palabras1', '&lt;p&gt;&quot;At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.&quot;&lt;/p&gt;\r\n&lt;p&gt;&quot;At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.&quot;&lt;/p&gt;', 3, 'imagen_1918.jpg', 1, '2015-05-17 19:55:31', '2015-05-17 19:59:01', 1),
(11, 'palabras2', '&lt;p&gt;&quot;At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.&quot;&lt;/p&gt;', 3, 'imagen_9342.jpg', 1, '2015-05-17 19:55:47', '2015-05-17 19:59:07', 1),
(12, 'palabras3', '&lt;p&gt;&quot;On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.&quot;&lt;/p&gt;', 4, 'imagen_2072.jpg', 1, '2015-05-17 19:56:05', '2015-05-17 19:59:14', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_categorias`
--

CREATE TABLE IF NOT EXISTS `blog_categorias` (
  `cat_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `cat_nombre` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `cat_fecha_creacion` datetime NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `blog_categorias`
--

INSERT INTO `blog_categorias` (`cat_id`, `cat_nombre`, `cat_fecha_creacion`) VALUES
(1, 'stand_by', '2015-05-17 00:00:00'),
(2, 'urbanismo', '2015-05-17 19:56:46'),
(3, 'construcción', '2015-05-17 19:56:55'),
(4, 'patrimonio', '2015-05-17 19:57:07');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `blog_comentarios`
--

INSERT INTO `blog_comentarios` (`comentario_id`, `comentario_usuario_id_autor`, `comentario_articulo_id`, `comentario_texto`, `comentario_fecha_creacion`) VALUES
(1, 4, 12, 'e who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. these cases', '2015-05-17 20:36:08'),
(2, 2, 12, 'e who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. these cases', '2015-05-17 20:36:17'),
(3, 1, 12, 'hteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those w', '2015-05-17 20:36:26'),
(4, 1, 12, 'hteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those w', '2015-05-17 20:36:27'),
(5, 3, 12, 'our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. but in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repu', '2015-05-17 20:36:36'),
(6, 3, 12, 'n who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot forese', '2015-05-17 20:36:41'),
(7, 3, 12, 'n who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot forese', '2015-05-17 20:36:50'),
(8, 1, 12, 's of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. the wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or', '2015-05-17 20:36:59'),
(9, 1, 12, 's of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. the wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or', '2015-05-17 20:37:00'),
(10, 2, 12, 'rfectly simple and easy to distinguish. in a free hour, when our power of choice is untrammelled and when nothing prevents o', '2015-05-17 20:37:10'),
(11, 2, 12, 'rfectly simple and easy to distinguish. in a free hour, when our power of choice is untrammelled and when nothing prevents o', '2015-05-17 20:37:11'),
(12, 4, 12, 'e, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. these cases are perfectly s', '2015-05-17 20:37:29'),
(13, 4, 12, 'e, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. these cases are perfectly s', '2015-05-17 20:37:30');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `blog_usuarios`
--

INSERT INTO `blog_usuarios` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_correo`, `usuario_password`, `usuario_rol`, `usuario_fecha_registro`) VALUES
(1, 'juan enrique', 'meyer', 'jemeyerlop@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, '2015-05-04 13:24:46'),
(2, 'carlos', 'soto', 'carlos@puc.cl', '7c4a8d09ca3762af61e59520943dc26494f8941b', 2, '2015-05-17 20:31:42'),
(3, 'vicente', 'letelier', 'vicente@puc.cl', '7c4a8d09ca3762af61e59520943dc26494f8941b', 2, '2015-05-17 20:33:12'),
(4, 'pablo', 'luchinger', 'pablo@hotmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 2, '2015-05-17 20:34:40');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
