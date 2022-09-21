`knjiga``knjiga``knjiga`/*
SQLyog Community
MySQL - 10.4.11-MariaDB : Database - books
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`books` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `books`;

/*Table structure for table `knjiga` */

DROP TABLE IF EXISTS `knjiga`;

CREATE TABLE `knjiga` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(40) DEFAULT NULL,
  `trajanje` INT(11) DEFAULT NULL,
  `zanr` BIGINT(20) DEFAULT NULL,
  `pisac` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `zanr` (`zanr`),
  KEY `pisac` (`pisac`),
  CONSTRAINT `knjiga_ibfk_1` FOREIGN KEY (`zanr`) REFERENCES `zanr` (`id`),
  CONSTRAINT `knjiga_ibfk_2` FOREIGN KEY (`pisac`) REFERENCES `pisac` (`id`)
) ENGINE=INNODB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `knjiga` */

INSERT  INTO `knjiga`(`id`,`naziv`,`trajanje`,`zanr`,`pisac`) VALUES 
(1,'fads',34,3,2),
(2,'fdsg',345,3,4),
(3,'fsdg',345,1,2);

/*Table structure for table `pisac` */

DROP TABLE IF EXISTS `pisac`;

CREATE TABLE `pisac` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `ime` VARCHAR(30) DEFAULT NULL,
  `prezime` VARCHAR(30) DEFAULT NULL,
  `godina_rodjenja` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `pisac` */

INSERT  INTO `pisac`(`id`,`ime`,`prezime`,`godina_rodjenja`) VALUES 
(2,'Katarina','SVger',2000),
(4,'afds','fads',34);

/*Table structure for table `zanr` */

DROP TABLE IF EXISTS `zanr`;
`knjiga`
CREATE TABLE `zanr` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `zanr` */

INSERT  INTO `zanr`(`id`,`naziv`) VALUES 
(1,'komedija'),
(2,'klasika'),
(3,'romantika');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
`zanr`