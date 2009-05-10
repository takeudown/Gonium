-- phpMyAdmin SQL Dump
-- version 2.11.3deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 24-08-2008 a las 17:09:40
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.4-2ubuntu5.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de datos: `roxyton`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rox_acl_access`
--

CREATE TABLE IF NOT EXISTS `rox_acl_access` (
  `role_id` varchar(50) NOT NULL,
  `resource_id` varchar(50) default NULL,
  `privilege` varchar(50) default NULL,
  `allow` tinyint(1) NOT NULL default '0',
  UNIQUE KEY `role_id` (`role_id`,`resource_id`,`privilege`),
  KEY `resource_id` (`resource_id`,`privilege`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `rox_acl_access`
--

INSERT INTO `rox_acl_access` (`role_id`, `resource_id`, `privilege`, `allow`) VALUES
('Writers', 'Printer', NULL, 1),
('Writers', 'TextWritingProggie', NULL, 1),
('Editors', 'TextWritingProggie', NULL, 1),
('Admins', NULL, NULL, 1),
('Editors', 'svn', NULL, 1),
('Writers', 'svn', NULL, 1),
('Publishers', 'PhoneBook', '', 1),
('Publishers', 'svn', '', 1),
('Publishers', 'svn', 'commit', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rox_acl_inheritance`
--

CREATE TABLE IF NOT EXISTS `rox_acl_inheritance` (
  `user_id` int(11) NOT NULL,
  `parent_id` varchar(50) NOT NULL,
  `order` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`parent_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `rox_acl_inheritance`
--

INSERT INTO `rox_acl_inheritance` (`user_id`, `parent_id`, `order`) VALUES
(1, 'Admins', 0),
(2, 'Editors', 0),
(2, 'Writers', 1),
(3, 'Publishers', 0),
(4, 'Writers', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rox_acl_resources`
--

CREATE TABLE IF NOT EXISTS `rox_acl_resources` (
  `resource_id` varchar(50) NOT NULL,
  `parent_id` varchar(50) default NULL,
  `privilege` varchar(50) NOT NULL default '',
  `scope` varchar(50) NOT NULL default 'system',
  PRIMARY KEY  (`resource_id`,`privilege`),
  KEY `parent_id` (`parent_id`),
  KEY `scope` (`scope`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `rox_acl_resources`
--

INSERT INTO `rox_acl_resources` (`resource_id`, `parent_id`, `privilege`, `scope`) VALUES
('bathroom', 'home', '', 'system'),
('default', NULL, '', 'module'),
('home', NULL, '', 'system'),
('LaTeX', 'TextWritingProggie', '', 'system'),
('mod_blog', NULL, '', 'module'),
('mod_default', NULL, '', 'module'),
('mod_tienda', NULL, '', 'module'),
('OOfficeWriter', 'TextWritingProggie', '', 'system'),
('PhoneBook', NULL, '', 'system'),
('Printer', NULL, '', 'system'),
('svn', NULL, 'checkout', 'system'),
('svn', NULL, 'commit', 'system'),
('svn', NULL, 'update', 'system'),
('TextWritingProggie', NULL, '', 'system');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rox_acl_roles`
--

CREATE TABLE IF NOT EXISTS `rox_acl_roles` (
  `role_id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY  (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `rox_acl_roles`
--

INSERT INTO `rox_acl_roles` (`role_id`, `name`) VALUES
('Admins', ''),
('Editors', ''),
('Publishers', ''),
('some.editor@example.org', ''),
('some.publisher@example.org', ''),
('some.writer@example.org', ''),
('uberadmin@example.org', ''),
('Writers', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rox_blocks`
--

CREATE TABLE IF NOT EXISTS `rox_blocks` (
  `title` varchar(60) NOT NULL,
  `rox_block` varchar(60) NOT NULL,
  `rox_position` varchar(30) NOT NULL,
  PRIMARY KEY  (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `rox_blocks`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rox_blog_comments`
--

CREATE TABLE IF NOT EXISTS `rox_blog_comments` (
  `uid` int(11) NOT NULL,
  `comment_name` varchar(200) NOT NULL,
  `comment_email` varchar(200) NOT NULL,
  `comment_website` varchar(200) NOT NULL,
  `comment_text` text NOT NULL,
  KEY `user_comments_fk` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `rox_blog_comments`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rox_blog_posts`
--

CREATE TABLE IF NOT EXISTS `rox_blog_posts` (
  `id` int(11) NOT NULL,
  `post_title` varchar(200) NOT NULL,
  `post_text` text NOT NULL,
  `post_permalink` varchar(200) NOT NULL,
  `uid` int(11) NOT NULL,
  KEY `user` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `rox_blog_posts`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rox_modules`
--

CREATE TABLE IF NOT EXISTS `rox_modules` (
  `directory` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `resource_id` varchar(50) NOT NULL,
  UNIQUE KEY `resource_id` (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `rox_modules`
--

INSERT INTO `rox_modules` (`directory`, `name`, `resource_id`) VALUES
('blog', 'Blog', 'mod_blog'),
('default', 'Default', 'mod_default'),
('tienda', 'Tienda', 'mod_tienda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rox_users`
--

CREATE TABLE IF NOT EXISTS `rox_users` (
  `uid` int(11) NOT NULL auto_increment,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `rox_users`
--

INSERT INTO `rox_users` (`uid`, `username`, `password`) VALUES
(0, 'Anonymous', ''),
(1, 'admin', '320d1a474a0dece4a7fac9136406fd6d63d62ec5'),
(2, 'some.editor', 'a444c6174a11913f69916d4486083e909f2e516f'),
(3, 'some.publisher', 'd791aad38ccd7dc598178e90493f72cd6949881e'),
(4, 'some.writer', 'bf9f2de4daf079aebd44a68261579bde1a09dc52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rox_user_profile`
--

CREATE TABLE IF NOT EXISTS `rox_user_profile` (
  `uid` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `web` varchar(200) NOT NULL,
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `rox_user_profile`
--


--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `rox_acl_access`
--
ALTER TABLE `rox_acl_access`
  ADD CONSTRAINT `rox_acl_access_ibfk_4` FOREIGN KEY (`resource_id`) REFERENCES `rox_acl_resources` (`resource_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rox_acl_access_ibfk_5` FOREIGN KEY (`role_id`) REFERENCES `rox_acl_roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rox_acl_inheritance`
--
ALTER TABLE `rox_acl_inheritance`
  ADD CONSTRAINT `rox_acl_inheritance_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `rox_acl_roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rox_acl_inheritance_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `rox_users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rox_acl_resources`
--
ALTER TABLE `rox_acl_resources`
  ADD CONSTRAINT `rox_acl_resources_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `rox_acl_resources` (`resource_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `rox_blog_comments`
--
ALTER TABLE `rox_blog_comments`
  ADD CONSTRAINT `user_comments_fk` FOREIGN KEY (`uid`) REFERENCES `rox_users` (`uid`);

--
-- Filtros para la tabla `rox_blog_posts`
--
ALTER TABLE `rox_blog_posts`
  ADD CONSTRAINT `users_fk` FOREIGN KEY (`uid`) REFERENCES `rox_users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rox_modules`
--
ALTER TABLE `rox_modules`
  ADD CONSTRAINT `rox_modules_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `rox_acl_resources` (`resource_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rox_user_profile`
--
ALTER TABLE `rox_user_profile`
  ADD CONSTRAINT `rox_user_profile_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `rox_users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;
