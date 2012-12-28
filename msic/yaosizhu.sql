-- --------------------------------------------------------
-- 主机                            :localhost
-- Server version                :5.5.16 - MySQL Community Server (GPL)
-- Server OS                     :Win32
-- HeidiSQL 版本                   :7.0.0.4246
-- Created                       :2012-12-28 16:42:05
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table yaosizhu.course_category_copy
DROP TABLE IF EXISTS `course_category_copy`;
CREATE TABLE IF NOT EXISTS `course_category_copy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `sortorder` int(10) unsigned NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `modified` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table yaosizhu.course_category_copy: 0 rows
DELETE FROM `course_category_copy`;
/*!40000 ALTER TABLE `course_category_copy` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_category_copy` ENABLE KEYS */;


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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table yaosizhu.user: 0 rows
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
