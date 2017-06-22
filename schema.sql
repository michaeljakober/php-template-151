-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE hangman;

DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `login` (`Id`, `username`, `email`, `password`, `active`) VALUES
(1,	'michaeljakober',	'michael.jakober2000@gmail.com',	'123456Aa',	1),
(2,	'test1',	'test@test.com',	'123456Aa',	1),
(5,	'test2',	'test2@test.com',	'123456Aa',	1);

DROP TABLE IF EXISTS `word`;
CREATE TABLE `word` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `word` (`Id`, `word`) VALUES
(1,	'Hangman'),
(2,	'Ei'),
(3,	'zu'),
(4,	'Der'),
(5,	'Das'),
(6,	'Haus'),
(7,	'Baum'),
(8,	'Sechs'),
(9,	'Handy'),
(10,	'Alpaka'),
(11,	'Orange'),
(12,	'Tabelle'),
(13,	'Haarband'),
(14,	'Schranke'),
(15,	'Tischbein'),
(16,	'Stuhlbein');

-- 2017-06-18 14:09:06
