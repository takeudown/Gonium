-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-05-2009 a las 20:00:26
-- Versión del servidor: 5.1.33
-- Versión de PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `roxyton_testing`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gonium_core_acl_access`
--

CREATE TABLE IF NOT EXISTS `gonium_core_acl_access` (
  `rule_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` varchar(50) DEFAULT NULL,
  `resource_name` varchar(50) DEFAULT NULL,
  `privilege` varchar(50) DEFAULT NULL,
  `allow` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`rule_id`) USING BTREE,
  UNIQUE KEY `rule_unique` (`role_id`,`resource_name`,`privilege`) USING BTREE,
  KEY `gonium_core_acl_access_resource_id_fkey` (`resource_name`,`privilege`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Volcar la base de datos para la tabla `gonium_core_acl_access`
--

INSERT INTO `gonium_core_acl_access` (`rule_id`, `role_id`, `resource_name`, `privilege`, `allow`) VALUES
(8, 'Writers', 'Printer', NULL, 1),
(9, 'Writers', 'TextWritingProggie', NULL, 1),
(10, 'Editors', 'TextWritingProggie', NULL, 1),
(11, 'Admins', NULL, NULL, 1),
(12, 'Editors', 'svn', NULL, 1),
(13, 'Writers', 'svn', NULL, 1),
(14, 'Publishers', 'PhoneBook', NULL, 1),
(15, 'Publishers', 'svn', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gonium_core_acl_inheritance`
--

CREATE TABLE IF NOT EXISTS `gonium_core_acl_inheritance` (
  `inheritance_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` varchar(50) NOT NULL,
  `parent_id` varchar(50) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`inheritance_id`),
  UNIQUE KEY `rule_unique` (`role_id`,`parent_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `gonium_core_acl_inheritance`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gonium_core_acl_resources`
--

CREATE TABLE IF NOT EXISTS `gonium_core_acl_resources` (
  `resource_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `resource_name` varchar(50) NOT NULL DEFAULT '',
  `privilege` varchar(50) DEFAULT NULL,
  `scope` varchar(50) NOT NULL DEFAULT 'system',
  PRIMARY KEY (`resource_id`),
  UNIQUE KEY `resource_unique` (`resource_name`,`privilege`),
  KEY `parent_id` (`parent_id`),
  KEY `scope` (`scope`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Volcar la base de datos para la tabla `gonium_core_acl_resources`
--

INSERT INTO `gonium_core_acl_resources` (`resource_id`, `parent_id`, `resource_name`, `privilege`, `scope`) VALUES
(1, NULL, 'default', NULL, 'module'),
(2, NULL, 'home', NULL, 'system'),
(3, NULL, 'mod_blog', NULL, 'module'),
(4, NULL, 'mod_default', NULL, 'module'),
(5, NULL, 'mod_tienda', NULL, 'module'),
(6, NULL, 'PhoneBook', NULL, 'system'),
(7, NULL, 'Printer', NULL, 'system'),
(8, NULL, 'svn', 'checkout', 'system'),
(9, NULL, 'svn', 'commit', 'system'),
(10, NULL, 'svn', 'update', 'system'),
(11, NULL, 'TextWritingProggie', NULL, 'system'),
(12, 2, 'bathroom', NULL, 'system'),
(13, 11, 'LaTeX', NULL, 'system'),
(14, 11, 'OOfficeWriter', NULL, 'system'),
(15, NULL, 'a', NULL, 'testing'),
(16, 15, 'b', NULL, 'testing'),
(17, 15, 'b', NULL, 'testing'),
(18, 15, 'c', NULL, 'testing'),
(19, 15, 'd', NULL, 'testing'),
(20, 19, 'e', NULL, 'testing'),
(21, 19, 'f', NULL, 'testing'),
(22, 17, 'g', NULL, 'testing');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gonium_core_acl_roles`
--

CREATE TABLE IF NOT EXISTS `gonium_core_acl_roles` (
  `role_id` varchar(50) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `gonium_core_acl_roles`
--

INSERT INTO `gonium_core_acl_roles` (`role_id`) VALUES
('Admins'),
('Editors'),
('Guest'),
('Publishers'),
('some.editor@example.org'),
('some.publisher@example.org'),
('some.writer@example.org'),
('uberadmin@example.org'),
('Writers');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gonium_core_modules`
--

CREATE TABLE IF NOT EXISTS `gonium_core_modules` (
  `directory` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `resource_id` int(11) unsigned NOT NULL,
  UNIQUE KEY `resource_id` (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `gonium_core_modules`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gonium_core_users`
--

CREATE TABLE IF NOT EXISTS `gonium_core_users` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` varchar(50) NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `gonium_core_users_role_id_fkey` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `gonium_core_users`
--

INSERT INTO `gonium_core_users` (`uid`, `username`, `password`, `role_id`) VALUES
(0, 'Anonymous', '', 'Guest'),
(1, 'admin', '320d1a474a0dece4a7fac9136406fd6d63d62ec5', 'Admins'),
(2, 'some.editor', 'a444c6174a11913f69916d4486083e909f2e516f', 'Editors'),
(3, 'some.publisher', 'd791aad38ccd7dc598178e90493f72cd6949881e', 'Publishers'),
(4, 'some.writer', 'bf9f2de4daf079aebd44a68261579bde1a09dc52', 'Writers');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gonium_core_user_profile`
--

CREATE TABLE IF NOT EXISTS `gonium_core_user_profile` (
  `uid` int(11) unsigned NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `web` varchar(200) NOT NULL,
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `gonium_core_user_profile`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gonium_core_widgets`
--

CREATE TABLE IF NOT EXISTS `gonium_core_widgets` (
  `widget_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `resource_id` int(11) unsigned DEFAULT NULL,
  `title` varchar(60) NOT NULL,
  `gonium_block` varchar(60) NOT NULL,
  `gonium_position` varchar(30) NOT NULL,
  PRIMARY KEY (`widget_id`),
  UNIQUE KEY `title` (`title`),
  KEY `gonium_core_widgets_resource_id_fkey` (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `gonium_core_widgets`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gonium_mod_blog_comments`
--

CREATE TABLE IF NOT EXISTS `gonium_mod_blog_comments` (
  `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) unsigned NOT NULL,
  `uid` int(11) unsigned NOT NULL,
  `comment_name` varchar(200) NOT NULL,
  `comment_email` varchar(200) NOT NULL,
  `comment_website` varchar(200) NOT NULL,
  `comment_text` text NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `gonium_mod_blog_comments_post_id_fkey` (`post_id`),
  KEY `gonium_mod_blog_comments_uid_fkey` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `gonium_mod_blog_comments`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gonium_mod_blog_posts`
--

CREATE TABLE IF NOT EXISTS `gonium_mod_blog_posts` (
  `post_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `post_title` varchar(200) NOT NULL,
  `post_text` text NOT NULL,
  `post_permalink` varchar(200) NOT NULL,
  `uid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `gonium_mod_blog_posts_uid_fkey` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `gonium_mod_blog_posts`
--


--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `gonium_core_acl_access`
--
ALTER TABLE `gonium_core_acl_access`
  ADD CONSTRAINT `gonium_core_acl_access_resource_id_fkey` FOREIGN KEY (`resource_name`, `privilege`) REFERENCES `gonium_core_acl_resources` (`resource_name`, `privilege`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gonium_core_acl_access_role_id_fkey` FOREIGN KEY (`role_id`) REFERENCES `gonium_core_acl_roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gonium_core_acl_inheritance`
--
ALTER TABLE `gonium_core_acl_inheritance`
  ADD CONSTRAINT `gonium_core_acl_inheritance_parent_id_fkey` FOREIGN KEY (`parent_id`) REFERENCES `gonium_core_acl_roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gonium_core_acl_inheritance_role_id_fkey` FOREIGN KEY (`role_id`) REFERENCES `gonium_core_acl_roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gonium_core_acl_resources`
--
ALTER TABLE `gonium_core_acl_resources`
  ADD CONSTRAINT `gonium_core_acl_resources_parent_id_fkey` FOREIGN KEY (`parent_id`) REFERENCES `gonium_core_acl_resources` (`resource_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gonium_core_modules`
--
ALTER TABLE `gonium_core_modules`
  ADD CONSTRAINT `gonium_core_modules_resource_id_fkey` FOREIGN KEY (`resource_id`) REFERENCES `gonium_core_acl_resources` (`resource_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gonium_core_users`
--
ALTER TABLE `gonium_core_users`
  ADD CONSTRAINT `gonium_core_users_role_id_fkey` FOREIGN KEY (`role_id`) REFERENCES `gonium_core_acl_roles` (`role_id`);

--
-- Filtros para la tabla `gonium_core_user_profile`
--
ALTER TABLE `gonium_core_user_profile`
  ADD CONSTRAINT `gonium_core_user_profile_uid_fkey` FOREIGN KEY (`uid`) REFERENCES `gonium_core_users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gonium_core_widgets`
--
ALTER TABLE `gonium_core_widgets`
  ADD CONSTRAINT `gonium_core_widgets_resource_id_fkey` FOREIGN KEY (`resource_id`) REFERENCES `gonium_core_acl_resources` (`resource_id`);

--
-- Filtros para la tabla `gonium_mod_blog_comments`
--
ALTER TABLE `gonium_mod_blog_comments`
  ADD CONSTRAINT `gonium_mod_blog_comments_post_id_fkey` FOREIGN KEY (`post_id`) REFERENCES `gonium_mod_blog_posts` (`post_id`),
  ADD CONSTRAINT `gonium_mod_blog_comments_uid_fkey` FOREIGN KEY (`uid`) REFERENCES `gonium_core_users` (`uid`);

--
-- Filtros para la tabla `gonium_mod_blog_posts`
--
ALTER TABLE `gonium_mod_blog_posts`
  ADD CONSTRAINT `gonium_mod_blog_posts_uid_fkey` FOREIGN KEY (`uid`) REFERENCES `gonium_core_users` (`uid`);
