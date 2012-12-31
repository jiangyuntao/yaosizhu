-- --------------------------------------------------------
-- 主机                            :127.0.0.1
-- Server version                :5.5.8 - MySQL Community Server (GPL)
-- Server OS                     :Win32
-- HeidiSQL 版本                   :7.0.0.4244
-- Created                       :2013-01-01 03:38:15
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for yaosizhu
DROP DATABASE IF EXISTS `yaosizhu`;
CREATE DATABASE IF NOT EXISTS `yaosizhu` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `yaosizhu`;


-- Dumping structure for table yaosizhu.channel
DROP TABLE IF EXISTS `channel`;
CREATE TABLE IF NOT EXISTS `channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `deduction` float unsigned NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created` int(10) unsigned NOT NULL,
  `modified` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table yaosizhu.channel: 0 rows
DELETE FROM `channel`;
/*!40000 ALTER TABLE `channel` DISABLE KEYS */;
/*!40000 ALTER TABLE `channel` ENABLE KEYS */;


-- Dumping structure for table yaosizhu.record
DROP TABLE IF EXISTS `record`;
CREATE TABLE IF NOT EXISTS `record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `channel_id` int(10) unsigned NOT NULL,
  `redirected` enum('1','0') NOT NULL DEFAULT '1',
  `timeline` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `channel_id` (`channel_id`,`redirected`,`timeline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='访问记录';

-- Dumping data for table yaosizhu.record: 0 rows
DELETE FROM `record`;
/*!40000 ALTER TABLE `record` DISABLE KEYS */;
/*!40000 ALTER TABLE `record` ENABLE KEYS */;


-- Dumping structure for table yaosizhu.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `password` char(32) NOT NULL,
  `signin_time` int(10) unsigned NOT NULL,
  `signin_ip` varchar(15) NOT NULL,
  `is_admin` enum('0','1') NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL,
  `modified` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table yaosizhu.user: 1 rows
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `password`, `signin_time`, `signin_ip`, `is_admin`, `created`, `modified`) VALUES
	(1, 'admin', '4cc31d3c671aa76c4452472376949223', 1356860632, '127.0.0.1', '1', 1356859027, 1356859222);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
