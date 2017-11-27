CREATE DATABASE  IF NOT EXISTS `MyDatabase` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci */;
USE `MyDatabase`;
-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: MyDatabase
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  `subcategory_id` int(11) unsigned NOT NULL,
  `title` varchar(60) COLLATE latin1_general_ci NOT NULL,
  `description` varchar(60) COLLATE latin1_general_ci DEFAULT NULL,
  `longdescription` text COLLATE latin1_general_ci,
  `uploaddate` datetime NOT NULL,
  `hash` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `httpmirror` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `hash_UNIQUE` (`hash`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  KEY `fk_files_1_idx` (`subcategory_id`),
  KEY `fk_files_2_idx` (`user_id`),
  KEY `fk_files_3_idx` (`category_id`),
  CONSTRAINT `fk_files_1` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_files_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_files_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `flags`
--

DROP TABLE IF EXISTS `flags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flagType` enum('LIKE','DISLIKE','MODERATED','BANNED') COLLATE latin1_general_ci DEFAULT NULL COMMENT 'LIKE: User like the post\nDISLIKE: User disliked the post\nMODERATED: A moderator has manually checked the file and it can be trusted\nBANNED: The file is against the TOS and should not be shown again',
  `user_id` int(11) unsigned NOT NULL,
  `file_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `one_flag_per_user` (`flagType`,`user_id`,`file_id`),
  KEY `fk_flags_1_idx` (`user_id`),
  KEY `fk_flags_2_idx` (`file_id`),
  CONSTRAINT `fk_flags_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_flags_2` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `subcategories`
--

DROP TABLE IF EXISTS `subcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcategories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `name` varchar(45) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`,`category_id`),
  UNIQUE KEY `id_UNIQUE` (`id`,`category_id`),
  KEY `fk_subcategories_1_idx` (`category_id`),
  CONSTRAINT `fk_subcategories_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `userrole`
--

DROP TABLE IF EXISTS `userrole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userrole` (
  `user_id` int(10) unsigned NOT NULL,
  `role` enum('MODERATOR','ADMIN') COLLATE latin1_general_ci NOT NULL,
  UNIQUE KEY `unique_couple` (`user_id`,`role`),
  KEY `fk_userrole_1_idx` (`user_id`),
  CONSTRAINT `fk_userrole_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(45) COLLATE latin1_general_ci NOT NULL,
  `reg_date` date NOT NULL,
  `username` varchar(45) COLLATE latin1_general_ci NOT NULL,
  `password` char(60) COLLATE latin1_general_ci NOT NULL,
  `tempkey` varchar(120) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'MyDatabase'
--
/*!50003 DROP PROCEDURE IF EXISTS `getFileById` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getFileById`(IN iId INT(11))
BEGIN
		SELECT 
		users.id As `user_id`, 
		users.username as `user_name`, 
		files.title as `file_title`,
		categories.name as `category`,
		subcategories.name as `subcategory`,
		files.uploaddate as `file_upload_date`,
		files.description as `file_short_description`, 
		files.longdescription as `file_long_description`,
		files.hash as `file_hash`,
		files.httpmirror as `file_http_mirror`
		FROM files 
		INNER JOIN users ON user_id = users.id
		INNER JOIN categories ON category_id = categories.id
		INNER JOIN subcategories ON subcategory_id = subcategories.id AND subcategories.category_id = categories.id
        WHERE files.id = iId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `getFlagsByFile` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getFlagsByFile`(IN file_id_in INT(11))
BEGIN
	SELECT 
    `likes`, 
    `dislikes`,
    `moderated`,
    `banned`
    FROM
		(SELECT COUNT(*) AS `likes` FROM flags WHERE flags.file_id = file_id_in AND flags.flagType = 'LIKE') AS `likes`
        ,
        (SELECT COUNT(*) AS `dislikes` FROM flags WHERE flags.file_id = file_id_in AND flags.flagType = 'DISLIKE') AS `dislikes`
        ,
        (SELECT COUNT(*) > 0 AS `moderated` FROM flags WHERE flags.file_id = file_id_in AND flags.flagType = 'MODERATED') AS `moderated`
		,
        (SELECT COUNT(*) > 0 AS `banned` FROM flags WHERE flags.file_id = file_id_in AND flags.flagType = 'BANNED') AS `banned`
	;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `getFlagsByUserAndFile` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getFlagsByUserAndFile`(IN user_id_in INT(11), IN file_id_in INT(11))
BEGIN
	SELECT DISTINCT flagType  
	FROM
	flags
	WHERE
	file_id = file_id_in AND user_id = user_id_in;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `getPostsBySearch` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getPostsBySearch`(IN searchText Text, IN category_id int(11), IN subcategory_id INT(11), IN resultsPerPage INT(11), IN pageNumber INT(11))
BEGIN
	SELECT
		files.id AS `file_id`,
		files.title AS `file_title`,
		files.description AS `file_description`,
		files.hash AS `file_hash`,
		files.httpmirror AS `file_http_mirror`,
		CONCAT("Dans ", categories.name, " > ", subcategories.name) AS `file_breadcrumb`
    FROM 
		files
		INNER JOIN
        categories ON files.category_id = categories.id
        INNER JOIN
        subcategories ON categories.id = subcategories.category_id AND files.subcategory_id = subcategories.id
    WHERE
    INSTR(CONCAT_WS("", title, description), searchText) > 0;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `getUserDataByName` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserDataByName`(IN userName Varchar(45))
BEGIN
	SELECT 
    reg_date,
    email,
    id as `userId`
    From
    users
    Where
    users.username = userName;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `getUserPostsById` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserPostsById`(In userId int(11), In maxRows int(3), in pageNumber Int(11))
BEGIN
	SET @myQuery = '
	SELECT
    description AS `short_desc`,
    title,
    uploaddate AS `upload_date`,
    id AS `file_id`
    FROM 
    files
	WHERE 
    user_id = ';
    
    set @myQuery = CONCAT(@myQuery, userId, " LIMIT ", maxRows%pageNumber, ", ", maxRows);
    
    PREPARE STMT FROM @myQuery;
    
    EXECUTE STMT;
    DEALLOCATE PREPARE STMT;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `getUserRoleById` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserRoleById`(IN user_id_in INT(11))
BEGIN
	SELECT 
    role
    FROM
    userrole
    WHERE
    user_id = user_id_in
    ;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `toggleFlag` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `toggleFlag`(IN flag_type_in ENUM('LIKE', 'DISLIKE', 'MODERATED', 'BANNED'), IN user_id_in INT(11), IN file_id_in INT(11))
BEGIN
	DECLARE is_flag_already_applied INT(11);
    
	#See if the flag is not already applied
	SET is_flag_already_applied = (SELECT id FROM flags WHERE flagType = flag_type_in AND user_id = user_id_in AND file_id = file_id_in LIMIT 1);
    
    IF is_flag_already_applied IS NULL THEN
		#If not in the database then add it
        
        #First we have to check for incompatible flags
        #eg: Like and dislike, can't do both at the same time
        # We recycle the older variable
        IF flag_type_in = 'LIKE' THEN
			#IF the flag to apply is LIKE and user already DISLIKEd
			SET is_flag_already_applied = (SELECT id FROM flags WHERE flagType = 'DISLIKE' AND user_id = user_id_in AND file_id = file_id_in LIMIT 1);
			IF is_flag_already_applied IS NOT NULL THEN
				DELETE FROM flags WHERE ID = is_flag_already_applied;
			END IF;
		ELSEIF flag_type_in = 'DISLIKE' THEN
			#IF the flag to apply is DISLIKE and user already LIKEd
			SET is_flag_already_applied = (SELECT id FROM flags WHERE flagType = 'LIKE' AND user_id = user_id_in AND file_id = file_id_in LIMIT 1);
			IF is_flag_already_applied IS NOT NULL THEN
				DELETE FROM flags WHERE ID = is_flag_already_applied;
			END IF;
        END IF;
        
        #In all cases, we need to insert the new flag
		INSERT INTO flags (flagType, user_id, file_id) VALUES (flag_type_in, user_id_in, file_id_in);
	ELSE
		#Remove the flag
        DELETE FROM flags WHERE ID = is_flag_already_applied LIMIT 1;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-27 22:19:50
