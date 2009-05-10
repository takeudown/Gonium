-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.51b-community-nt


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema roxyton_testing
--

CREATE DATABASE IF NOT EXISTS roxyton_testing;
USE roxyton_testing;

--
-- Definition of table `rox_core_acl_access`
--

DROP TABLE IF EXISTS `rox_core_acl_access`;
CREATE TABLE `rox_core_acl_access` (
  `rule_id` int(10) unsigned NOT NULL auto_increment,
  `role_id` varchar(50) default NULL,
  `resource_name` varchar(50) default NULL,
  `privilege` varchar(50) default NULL,
  `allow` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  USING BTREE (`rule_id`),
  UNIQUE KEY `rule_unique` USING BTREE (`role_id`,`resource_name`,`privilege`),
  KEY `rox_core_acl_access_resource_id_fkey` (`resource_name`,`privilege`),
  CONSTRAINT `rox_core_acl_access_resource_id_fkey` FOREIGN KEY (`resource_name`, `privilege`) REFERENCES `rox_core_acl_resources` (`resource_name`, `privilege`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rox_core_acl_access_role_id_fkey` FOREIGN KEY (`role_id`) REFERENCES `rox_core_acl_roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rox_core_acl_access`
--

/*!40000 ALTER TABLE `rox_core_acl_access` DISABLE KEYS */;
INSERT INTO `rox_core_acl_access` (`rule_id`,`role_id`,`resource_name`,`privilege`,`allow`) VALUES 
 (8,'Writers','Printer',NULL,1),
 (9,'Writers','TextWritingProggie',NULL,1),
 (10,'Editors','TextWritingProggie',NULL,1),
 (11,'Admins',NULL,NULL,1),
 (12,'Editors','svn',NULL,1),
 (13,'Writers','svn',NULL,1),
 (14,'Publishers','PhoneBook',NULL,1),
 (15,'Publishers','svn',NULL,1),
 (16,'Publishers','svn','commit',0);
/*!40000 ALTER TABLE `rox_core_acl_access` ENABLE KEYS */;


--
-- Definition of table `rox_core_acl_inheritance`
--

DROP TABLE IF EXISTS `rox_core_acl_inheritance`;
CREATE TABLE `rox_core_acl_inheritance` (
  `inheritance_id` int(11) unsigned NOT NULL auto_increment,
  `role_id` varchar(50) NOT NULL,
  `parent_id` varchar(50) NOT NULL,
  `priority` int(11) NOT NULL default '0',
  PRIMARY KEY  (`inheritance_id`),
  UNIQUE KEY `rule_unique` (`role_id`,`parent_id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `rox_core_acl_inheritance_role_id_fkey` FOREIGN KEY (`role_id`) REFERENCES `rox_core_acl_roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rox_core_acl_inheritance_parent_id_fkey` FOREIGN KEY (`parent_id`) REFERENCES `rox_core_acl_roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rox_core_acl_inheritance`
--

/*!40000 ALTER TABLE `rox_core_acl_inheritance` DISABLE KEYS */;
/*!40000 ALTER TABLE `rox_core_acl_inheritance` ENABLE KEYS */;


--
-- Definition of table `rox_core_acl_resources`
--

DROP TABLE IF EXISTS `rox_core_acl_resources`;
CREATE TABLE `rox_core_acl_resources` (
  `resource_id` int(11) unsigned NOT NULL auto_increment,
  `parent_id` int(11) unsigned default NULL,
  `resource_name` varchar(50) NOT NULL default '',
  `privilege` varchar(50) default NULL,
  `scope` varchar(50) NOT NULL default 'system',
  PRIMARY KEY  (`resource_id`),
  UNIQUE KEY `resource_unique` (`resource_name`,`privilege`),
  KEY `parent_id` (`parent_id`),
  KEY `scope` (`scope`),
  CONSTRAINT `rox_core_acl_resources_parent_id_fkey` FOREIGN KEY (`parent_id`) REFERENCES `rox_core_acl_resources` (`resource_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rox_core_acl_resources`
--

/*!40000 ALTER TABLE `rox_core_acl_resources` DISABLE KEYS */;
INSERT INTO `rox_core_acl_resources` (`resource_id`,`parent_id`,`resource_name`,`privilege`,`scope`) VALUES 
 (1,NULL,'default','','module'),
 (2,NULL,'home','','system'),
 (3,NULL,'mod_blog','','module'),
 (4,NULL,'mod_default','','module'),
 (5,NULL,'mod_tienda','','module'),
 (6,NULL,'PhoneBook','','system'),
 (7,NULL,'Printer','','system'),
 (8,NULL,'svn','checkout','system'),
 (9,NULL,'svn','commit','system'),
 (10,NULL,'svn','update','system'),
 (11,NULL,'TextWritingProggie','','system'),
 (12,2,'bathroom','','system'),
 (13,11,'LaTeX','','system'),
 (14,11,'OOfficeWriter','','system');
/*!40000 ALTER TABLE `rox_core_acl_resources` ENABLE KEYS */;


--
-- Definition of table `rox_core_acl_roles`
--

DROP TABLE IF EXISTS `rox_core_acl_roles`;
CREATE TABLE `rox_core_acl_roles` (
  `role_id` varchar(50) NOT NULL,
  PRIMARY KEY  (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rox_core_acl_roles`
--

/*!40000 ALTER TABLE `rox_core_acl_roles` DISABLE KEYS */;
INSERT INTO `rox_core_acl_roles` (`role_id`) VALUES 
 ('Admins'),
 ('Editors'),
 ('Publishers'),
 ('some.editor@example.org'),
 ('some.publisher@example.org'),
 ('some.writer@example.org'),
 ('uberadmin@example.org'),
 ('Writers');
/*!40000 ALTER TABLE `rox_core_acl_roles` ENABLE KEYS */;


--
-- Definition of table `rox_core_modules`
--

DROP TABLE IF EXISTS `rox_core_modules`;
CREATE TABLE `rox_core_modules` (
  `directory` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `resource_id` int(11) unsigned NOT NULL,
  UNIQUE KEY `resource_id` (`resource_id`),
  CONSTRAINT `rox_core_modules_resource_id_fkey` FOREIGN KEY (`resource_id`) REFERENCES `rox_core_acl_resources` (`resource_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rox_core_modules`
--

/*!40000 ALTER TABLE `rox_core_modules` DISABLE KEYS */;
/*!40000 ALTER TABLE `rox_core_modules` ENABLE KEYS */;


--
-- Definition of table `rox_core_user_profile`
--

DROP TABLE IF EXISTS `rox_core_user_profile`;
CREATE TABLE `rox_core_user_profile` (
  `uid` int(11) unsigned NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `web` varchar(200) NOT NULL,
  UNIQUE KEY `uid` (`uid`),
  CONSTRAINT `rox_core_user_profile_uid_fkey` FOREIGN KEY (`uid`) REFERENCES `rox_core_users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rox_core_user_profile`
--

/*!40000 ALTER TABLE `rox_core_user_profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `rox_core_user_profile` ENABLE KEYS */;


--
-- Definition of table `rox_core_users`
--

DROP TABLE IF EXISTS `rox_core_users`;
CREATE TABLE `rox_core_users` (
  `uid` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` varchar(50) NOT NULL,
  PRIMARY KEY  (`uid`),
  KEY `rox_core_users_role_id_fkey` (`role_id`),
  CONSTRAINT `rox_core_users_role_id_fkey` FOREIGN KEY (`role_id`) REFERENCES `rox_core_acl_roles` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rox_core_users`
--

/*!40000 ALTER TABLE `rox_core_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `rox_core_users` ENABLE KEYS */;


--
-- Definition of table `rox_core_widgets`
--

DROP TABLE IF EXISTS `rox_core_widgets`;
CREATE TABLE `rox_core_widgets` (
  `widget_id` int(11) unsigned NOT NULL auto_increment,
  `resource_id` int(11) unsigned default NULL,
  `title` varchar(60) NOT NULL,
  `rox_block` varchar(60) NOT NULL,
  `rox_position` varchar(30) NOT NULL,
  PRIMARY KEY  (`widget_id`),
  UNIQUE KEY `title` (`title`),
  KEY `rox_core_widgets_resource_id_fkey` (`resource_id`),
  CONSTRAINT `rox_core_widgets_resource_id_fkey` FOREIGN KEY (`resource_id`) REFERENCES `rox_core_acl_resources` (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rox_core_widgets`
--

/*!40000 ALTER TABLE `rox_core_widgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `rox_core_widgets` ENABLE KEYS */;


--
-- Definition of table `rox_mod_blog_comments`
--

DROP TABLE IF EXISTS `rox_mod_blog_comments`;
CREATE TABLE `rox_mod_blog_comments` (
  `comment_id` int(11) unsigned NOT NULL auto_increment,
  `post_id` int(11) unsigned NOT NULL,
  `uid` int(11) unsigned NOT NULL,
  `comment_name` varchar(200) NOT NULL,
  `comment_email` varchar(200) NOT NULL,
  `comment_website` varchar(200) NOT NULL,
  `comment_text` text NOT NULL,
  PRIMARY KEY  (`comment_id`),
  KEY `rox_mod_blog_comments_post_id_fkey` (`post_id`),
  KEY `rox_mod_blog_comments_uid_fkey` (`uid`),
  CONSTRAINT `rox_mod_blog_comments_uid_fkey` FOREIGN KEY (`uid`) REFERENCES `rox_core_users` (`uid`),
  CONSTRAINT `rox_mod_blog_comments_post_id_fkey` FOREIGN KEY (`post_id`) REFERENCES `rox_mod_blog_posts` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rox_mod_blog_comments`
--

/*!40000 ALTER TABLE `rox_mod_blog_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `rox_mod_blog_comments` ENABLE KEYS */;


--
-- Definition of table `rox_mod_blog_posts`
--

DROP TABLE IF EXISTS `rox_mod_blog_posts`;
CREATE TABLE `rox_mod_blog_posts` (
  `post_id` int(11) unsigned NOT NULL auto_increment,
  `post_title` varchar(200) NOT NULL,
  `post_text` text NOT NULL,
  `post_permalink` varchar(200) NOT NULL,
  `uid` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`post_id`),
  KEY `rox_mod_blog_posts_uid_fkey` (`uid`),
  CONSTRAINT `rox_mod_blog_posts_uid_fkey` FOREIGN KEY (`uid`) REFERENCES `rox_core_users` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rox_mod_blog_posts`
--

/*!40000 ALTER TABLE `rox_mod_blog_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `rox_mod_blog_posts` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
