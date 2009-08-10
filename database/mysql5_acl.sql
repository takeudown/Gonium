-- ----------------------------------------------------------------------------
-- Gonium
-- 
-- ACL script for Mysql 5
--
-- $Id$
-- ---------------------------------------------------------------------------


SET FOREIGN_KEY_CHECKS=0;

--
-- Constraints for table `gonium_core_acl_access`
--
ALTER TABLE `gonium_core_acl_access`
  DROP FOREIGN KEY `gonium_core_acl_access_resource_id_fkey`, 
  DROP FOREIGN KEY `gonium_core_acl_access_role_id_fkey`;

--
-- Constraints for table `gonium_core_acl_inheritance`
--
ALTER TABLE `gonium_core_acl_role_inheritance`
  DROP FOREIGN KEY `gonium_core_acl_inheritance_parent_id_fkey` ,
  DROP FOREIGN KEY `gonium_core_acl_inheritance_role_id_fkey`;

DROP TABLE `gonium_core_acl_resource` CASCADE;
DROP TABLE `gonium_core_acl_role_inheritance` CASCADE;
DROP TABLE `gonium_core_acl_role` CASCADE;
DROP TABLE `gonium_core_acl_access` CASCADE;

-- ----------------------------------------------------------------------------

-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 21, 2009 at 03:43 AM
-- Server version: 5.0.75
-- PHP Version: 5.2.6-3ubuntu4.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `gonium_testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `gonium_core_acl_access`
--

CREATE TABLE IF NOT EXISTS `gonium_core_acl_access` (
  `rule_id` int(10) unsigned NOT NULL auto_increment,
  `role_id` varchar(50) default NULL,
  `resource_name` varchar(50) default NULL,
  `privilege` varchar(50) default NULL,
  `allow` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  USING BTREE (`rule_id`),
  UNIQUE KEY `rule_unique` USING BTREE (`role_id`,`resource_name`,`privilege`),
  KEY `gonium_core_acl_access_resource_id_fkey` (`resource_name`,`privilege`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `gonium_core_acl_access`
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
-- Table structure for table `gonium_core_acl_inheritance`
--

CREATE TABLE IF NOT EXISTS `gonium_core_acl_role_inheritance` (
  `inheritance_id` int(11) unsigned NOT NULL auto_increment,
  `role_id` varchar(50) NOT NULL,
  `parent_id` varchar(50) NOT NULL,
  `priority` int(11) NOT NULL default '0',
  PRIMARY KEY  (`inheritance_id`),
  UNIQUE KEY `rule_unique` (`role_id`,`parent_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `gonium_core_acl_inheritance`
--


-- --------------------------------------------------------

--
-- Table structure for table `gonium_core_acl_resources`
--

CREATE TABLE IF NOT EXISTS `gonium_core_acl_resource` (
  `resource_id` int(11) unsigned NOT NULL auto_increment,
  `resource_name` varchar(50) default NULL,
  `scope` varchar(50) default NULL,
  `lft` int(11) unsigned NOT NULL,
  `rgt` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`resource_id`),
  UNIQUE KEY `lft` (`lft`),
  UNIQUE KEY `rgt` (`rgt`),
  UNIQUE KEY `resource_name` (`resource_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

--
-- Dumping data for table `gonium_core_acl_resources`
--

INSERT INTO gonium_core_acl_resource (resource_id, resource_name, scope, lft, rgt) VALUES
  (1, 'A', null, 1, 14),
  (2, 'B', null, 2, 7),
  (3, 'C', null, 8, 13),
  (4, 'D', null, 3, 4),
  (5, 'E', null, 5, 6),
  (6, 'F', null, 9, 10),
  (7, 'G', null, 11, 12);

/*
INSERT INTO gonium_core_acl_resource (resource_id, parent_name, resource_name, scope, lft, rgt)
  VALUES(8, null, 'H', null, 11, 12);
*/

-- --------------------------------------------------------

--
-- Table structure for table `gonium_core_acl_roles`
--

CREATE TABLE IF NOT EXISTS `gonium_core_acl_role` (
  `role_id` varchar(50) NOT NULL,
  PRIMARY KEY  (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gonium_core_acl_roles`
--

INSERT INTO `gonium_core_acl_role` (`role_id`) VALUES
('Admins'),
('Editors'),
('Guest'),
('Publishers'),
('some.editor@example.org'),
('some.publisher@example.org'),
('some.writer@example.org'),
('uberadmin@example.org'),
('Writers');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gonium_core_acl_access`
--

ALTER TABLE `gonium_core_acl_access`
  ADD CONSTRAINT `gonium_core_acl_access_resource_id_fkey` FOREIGN KEY (`resource_name`, `privilege`) REFERENCES `gonium_core_acl_resources` (`resource_name`, `privilege`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gonium_core_acl_access_role_id_fkey` FOREIGN KEY (`role_id`) REFERENCES `gonium_core_acl_roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gonium_core_acl_inheritance`
--

ALTER TABLE `gonium_core_acl_role_inheritance`
  ADD CONSTRAINT `gonium_core_acl_inheritance_parent_id_fkey` FOREIGN KEY (`parent_id`) REFERENCES `gonium_core_acl_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gonium_core_acl_inheritance_role_id_fkey` FOREIGN KEY (`role_id`) REFERENCES `gonium_core_acl_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;


/*****************************************************************************/
/* Views */
/*****************************************************************************/
CREATE OR REPLACE VIEW gonium_view_resource AS
SELECT
  node.*,
  trim(concat(
      repeat( '-', (COUNT(parent.resource_name) - 1)),
      ' ',
      node.resource_name
    )) AS tree_name,
  (COUNT(parent.resource_name) - 1) AS depth,
  (node.rgt - node.lft) AS width
    
FROM
  gonium_core_acl_resource AS node
CROSS JOIN
  gonium_core_acl_resource AS parent
WHERE node.lft BETWEEN parent.lft AND parent.rgt
  GROUP BY node.resource_id,
  node.resource_name,
  -- node.parent_name,
  node.scope
ORDER BY node.lft;

CREATE OR REPLACE VIEW gonium_view_resource_parents as
SELECT
  parent.resource_name as parent_name,
  node.*
FROM
  gonium_view_resource AS node
LEFT JOIN
  gonium_view_resource AS parent
    ON(
      parent.lft < node.lft AND node.rgt < parent.rgt AND node.depth = parent.depth+1
    );

/*****************************************************************************/
/* Triggers */
/*****************************************************************************/

/**
 */
/*
DROP TRIGGER gonium_trg_Acl_Resource_Add;

DELIMITER |

CREATE TRIGGER gonium_trg_Acl_Resource_Add BEFORE INSERT ON gonium_core_acl_resource
  FOR EACH ROW BEGIN

    DECLARE parentRight INT;
    SET parentRight = (
    SELECT rgt FROM gonium_core_acl_resource
          ORDER BY rgt DESC
    LIMIT 1
  );

    -- Obtener el valor derecho mas alto

    SET NEW.lft = parentRight+1;
    SET NEW.rgt = parentRight+2;

  END
|

DELIMITER ;
*/


/*****************************************************************************/
/* Functions */
/*****************************************************************************/
/**
 * If resourceName is child of resourceParentName return TRUE (1)
 * In other case, return FALSE (0)
 *
 * @param VARCHAR(50) newResourceName
 */
DELIMITER $$

DROP FUNCTION IF EXISTS `gonium_testing`.`gonium_sp_core_Acl_Resource_isChild`$$
CREATE FUNCTION `gonium_sp_core_Acl_Resource_isChild`(resourceName VARCHAR(50), resourceParentName VARCHAR(50)) RETURNS tinyint(1)
BEGIN

  DECLARE myLeft INT;
  DECLARE myRight INT;
  DECLARE tmpRes VARCHAR(50);

  SELECT lft, rgt INTO myLeft, myRight
  FROM gonium_core_acl_resource
      WHERE resource_name = resourceParentName;

  SELECT res INTO tmpRes FROM (
    SELECT resource_name as res FROM gonium_core_acl_resource
      WHERE myLeft < lft AND rgt < myRight) as childs
    WHERE childs.res = resourceName;

  IF( tmpRes IS NOT NULL ) THEN
    RETURN TRUE;
  ELSE
    RETURN FALSE;
  END IF;

END$$

DELIMITER ;

/*****************************************************************************/
/* Stored Procedures */
/*****************************************************************************/

/**
 * Add Resource left to given resource
 *
 * @param VARCHAR(50) newResourceName
 * @param VARCHAR(50) pivotResourceName
 */
DELIMITER $$

DROP PROCEDURE IF EXISTS `gonium_testing`.`gonium_sp_core_Acl_Resource_AddBefore`$$
CREATE PROCEDURE `gonium_sp_core_Acl_Resource_AddBefore`(newResourceName VARCHAR(50), pivotResourceName VARCHAR(50))
BEGIN
  DECLARE pivot INT;

  START TRANSACTION;

    -- Si el nodo dado es nulo, se agrega una raiz por la izquierda
    IF(pivotResourceName IS NULL) THEN

      -- Obtener el valor derecho mas alto
      SET pivot = (SELECT lft FROM gonium_core_acl_resource
          ORDER BY lft ASC
          LIMIT 1
      );
  
      IF (pivot IS NULL) THEN
      
        -- Si no existe, agregarlo como inicial
        INSERT gonium_core_acl_resource(resource_name, lft, rgt)
          VALUES(newResourceName,  1, 2);
      ELSE
        -- Si existe, agregarlo a la izquierda de todos
    
        UPDATE gonium_core_acl_resource SET rgt = rgt + 2 ORDER BY rgt DESC;
        UPDATE gonium_core_acl_resource SET lft = lft + 2 ORDER BY lft DESC;
    
        INSERT gonium_core_acl_resource(resource_name, lft, rgt)
          VALUES(newResourceName, 1, 2);  
        END IF;

    ELSE
    -- Si no, entonces se agrega un nodo a la izquierda del nodo dado
      SET pivot = (SELECT lft FROM gonium_core_acl_resource
        WHERE resource_name = pivotResourceName
      );
  
      IF (pivot IS NOT NULL) THEN
        SET pivot = pivot;
        UPDATE gonium_core_acl_resource SET rgt = rgt + 2 WHERE rgt >= pivot ORDER BY rgt DESC;
        UPDATE gonium_core_acl_resource SET lft = lft + 2 WHERE lft >= pivot ORDER BY lft DESC;
        
        INSERT gonium_core_acl_resource(resource_name, lft, rgt)
          VALUES(newResourceName, pivot, pivot+1);  
      END IF;
    END IF;
  COMMIT;
END$$

DELIMITER ;

/**
 * Add Resource right to given resource
 *
 * @param VARCHAR(50) newResourceName
 * @param VARCHAR(50) pivotResourceName
 */
DELIMITER $$

DROP PROCEDURE IF EXISTS `gonium_testing`.`gonium_sp_core_Acl_Resource_AddAfter`$$
CREATE PROCEDURE `gonium_sp_core_Acl_Resource_AddAfter`(IN newResourceName VARCHAR(50), IN pivotResourceName VARCHAR(50))
BEGIN

  DECLARE pivot INT;

  START TRANSACTION;

    -- Si el nodo dado es nulo, se agrega una raiz por la derecha
    IF (pivotResourceName IS NULL) THEN
    
  -- Obtener el valor derecho mas alto
  SET pivot = (SELECT rgt FROM gonium_core_acl_resource
    ORDER BY rgt DESC
    LIMIT 1
  );
  
  IF (pivot IS NULL) THEN
    -- Si no existe, agregarlo como inicial
    INSERT gonium_core_acl_resource(resource_name, lft, rgt)
    VALUES(newResourceName,  1, 2);
  ELSE
    -- Si existe, agregarlo a la derecha de todos
    INSERT gonium_core_acl_resource(resource_name, lft, rgt)
    VALUES(newResourceName, pivot+1, pivot+2);  
  END IF;
    ELSE
  -- Si no, entonces se agrega un nodo a la derecha del nodo dado
  SET pivot = (SELECT rgt FROM gonium_core_acl_resource
          WHERE resource_name = pivotResourceName
  );
    
    IF (pivot IS NOT NULL) THEN
      UPDATE gonium_core_acl_resource SET rgt = rgt + 2 WHERE rgt > pivot ORDER BY rgt DESC;
      UPDATE gonium_core_acl_resource SET lft = lft + 2 WHERE lft > pivot ORDER BY lft DESC;
      INSERT gonium_core_acl_resource(resource_name, lft, rgt)
      VALUES(newResourceName, pivot+1, pivot+2);
    END IF;
    END IF;
  COMMIT;
END$$

DELIMITER ;

/**
 * Add Resource as a Child of a given resource
 *
 * @param VARCHAR(50) newResourceName
 * @param VARCHAR(50) newResourceParent
 */
DELIMITER $$

DROP PROCEDURE IF EXISTS `gonium_testing`.`gonium_sp_core_Acl_Resource_AddChild`$$
CREATE PROCEDURE `gonium_sp_core_Acl_Resource_AddChild`(newResourceName VARCHAR(50), newResourceParent VARCHAR(50))
BEGIN
 
  DECLARE pivot INT;

  START TRANSACTION;

  -- Si el nodo dado es nulo, se agrega una raiz por la derecha
  IF (newResourceParent IS NULL) THEN

    CALL gonium_sp_core_Acl_Resource_AddAfter(newResourceName, newResourceParent);

  ELSE

    -- Si no, entonces se agrega un nodo hijo, por la derecha del nodo dado
    SET pivot =(SELECT rgt FROM gonium_core_acl_resource
       WHERE resource_name = newResourceParent
    );

    IF (pivot IS NOT NULL) THEN
      UPDATE gonium_core_acl_resource SET rgt = rgt + 2
      WHERE rgt >= pivot ORDER BY rgt DESC;
        UPDATE gonium_core_acl_resource SET lft = lft + 2
      WHERE lft >= pivot ORDER BY lft DESC;
      INSERT gonium_core_acl_resource(resource_name, lft, rgt)
        VALUES(newResourceName, pivot, pivot+1);
    END IF;
  END IF;
  
  COMMIT;
END$$

DELIMITER ;


/**
 * Delete a Resource (and all its children)
 *
 * @param VARCHAR(50) newResourceName
 */
DELIMITER $$

DROP PROCEDURE IF EXISTS `gonium_testing`.`gonium_sp_core_Acl_Resource_Remove`$$
CREATE PROCEDURE `gonium_sp_core_Acl_Resource_Remove`(resourceName VARCHAR(50))
BEGIN

  DECLARE myLeft INT;
  DECLARE myRight INT;
  DECLARE myWidth INT;

  START TRANSACTION;

  SELECT lft, rgt, (rgt - lft + 1) INTO myLeft, myRight, myWidth
    FROM gonium_core_acl_resource
    WHERE resource_name = resourceName;

  DELETE FROM gonium_core_acl_resource WHERE lft BETWEEN myLeft AND myRight;

  UPDATE gonium_core_acl_resource SET rgt = rgt - myWidth WHERE rgt > myRight;
  UPDATE gonium_core_acl_resource SET lft = lft - myWidth WHERE lft > myRight;

  COMMIT;
END$$

DELIMITER ;

/**
 * Move a Resource as Child of another given Parent Resource
 *
 * @param VARCHAR(50) newResourceName
 */
DELIMITER $$

DROP PROCEDURE IF EXISTS `gonium_testing`.`gonium_sp_core_Acl_Resource_MoveAsChild`$$
CREATE PROCEDURE `gonium_sp_core_Acl_Resource_MoveAsChild`(targetName VARCHAR(50), parentName VARCHAR(50))
proc:BEGIN

  DECLARE targetLeft INT;
  DECLARE targetRight INT;
  DECLARE targetWidth INT;
  DECLARE targetParent VARCHAR(50);

  DECLARE parentLeft INT;
  DECLARE parentRight INT;
  DECLARE parentWidth INT;
  DECLARE isChild BOOLEAN;

  DECLARE diff INT;

  START TRANSACTION;

  SELECT parent_name, lft, rgt, width 
    INTO targetParent, targetLeft, targetRight, targetWidth
    FROM gonium_view_resource_parents AS node
    WHERE node.resource_name = targetName; 

  SELECT lft, rgt, width 
    INTO parentLeft, parentRight, parentWidth
    FROM gonium_view_resource_parents AS node
    WHERE node.resource_name = parentName; 

  -- Probar si ambos nodos existen
  IF( targetWidth IS NULL OR parentWidth IS NULL ) THEN
    -- Si alguno de los 2 no existe, no se puede continuar
    LEAVE proc;
  END IF;

  IF(targetParent = parentName) THEN 
    -- El nuevo padre ya es el padre
    -- select 'El nuevo padre ya es el padre';
    LEAVE proc;
  END IF;

  -- Probar si padre e hijo son el mismo
  IF(targetName = parentName) THEN 
    -- El nodo resourceName no puede ser hijo de si mismo
    LEAVE proc;
  END IF;

  -- Probar si el nuevo padre es hijo del nodo
  SELECT gonium_sp_core_Acl_Resource_isChild(parentName, targetName)
     INTO isChild;

  IF(isChild = 1) THEN 
    -- El nuevo padre no puede ser hijo de resourceName
    -- select 'El nuevo padre no puede ser hijo de resourceName';
    LEAVE proc;
  END IF;

  -- Calcular diferencia entre nodo objetivo y el nuevo padre
  SET diff = parentRight - targetRight;

  UPDATE gonium_core_acl_resource SET rgt = rgt + targetWidth + 1
    WHERE rgt >= parentRight ORDER BY rgt DESC;
  UPDATE gonium_core_acl_resource SET lft = lft + targetWidth + 1
    WHERE lft > parentLeft ORDER BY lft DESC;

  -- Si el nodo objetivo está a la derecha del nodo padre, calcular nuevo left y right      
  IF ( targetLeft > parentLeft ) THEN
    SET targetLeft = targetLeft + targetWidth + 1;
    SET targetRight = targetRight + targetWidth + 1;

    SELECT targetLeft, targetRight;
  END IF;

  -- Mover los el nodo objetivo y sus hijos bajo el nuevo padre
  UPDATE gonium_core_acl_resource SET lft = lft + diff - 1, rgt = rgt + diff - 1
    WHERE (targetLeft <= lft AND rgt <= targetRight) ORDER BY lft DESC;

  -- Ajustar el espacio que queda despues del desplazamiento
  COMMIT;
END$$

DELIMITER ;

