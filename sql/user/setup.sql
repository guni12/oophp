--
-- Setup for the article:
-- https://dbwebb.se/kunskap/lagra-innehall-i-databas-for-webbsidor-och-bloggposter-v2
--

--
-- Create the database with a testuser
--
-- CREATE DATABASE IF NOT EXISTS oophp;
-- GRANT ALL ON oophp.* TO user@localhost IDENTIFIED BY "pass";
-- USE oophp;

-- Ensure UTF8 as chacrter encoding within connection.
SET NAMES utf8;

--
-- Create table for Content
--
DROP TABLE IF EXISTS `oophpuser`;
CREATE TABLE `oophpuser`
(
  `userid` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `user` VARCHAR(50),
  `password` CHAR(150) UNIQUE,

  -- MySQL version 5.6 and higher
  `iscreated` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `isupdated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
 
  -- MySQL version 5.5 and lower
  -- `iscreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  -- `isupdated` DATETIME DEFAULT NULL, --  ON UPDATE CURRENT_TIMESTAMP,

  `isdeleted` DATETIME DEFAULT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

INSERT INTO `oophpuser` (`user`, `password`) VALUES
    ("doe", "$2y$10$gHQvYhi4PliMIrbSIFRLI.fpzaV90nsjRYJ5.nqLtYRMctc2VPb.u"),
    ("admin", "$2y$10$MJyxXz9ZeC1OrMGxWSM44.GsIdcYj.hA7SOps.dU7HxYIDUp6BIVu");

SELECT `userid`, `user`, `password`, `iscreated` FROM `oophpuser`;


--
--
--
--   ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
