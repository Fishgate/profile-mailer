-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2013 at 10:03 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fishgate-profile-mailer`
--

-- --------------------------------------------------------

--
-- Table structure for table `quicksendlogs`
--

CREATE TABLE IF NOT EXISTS `quicksendlogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `date` text NOT NULL,
  `unix` int(11) NOT NULL,
  `template` text NOT NULL,
  `opened` tinyint(1) NOT NULL,
  `token` text NOT NULL,
  `ip` text NOT NULL,
  `host` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `quicksendlogs`
--

INSERT INTO `quicksendlogs` (`id`, `email`, `date`, `unix`, `template`, `opened`, `token`, `ip`, `host`) VALUES
(7, 'kyle@fishgate.co.za', '14-08-2013', 1376466665, 'profilemailer.html', 0, '19ca14e7ea6328a42e0eb13d585e4c22', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` text NOT NULL,
  `salt` text NOT NULL,
  `hash` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user`, `salt`, `hash`) VALUES
(1, 'admin', '0537f', 'f778a8ace7b7f14984d79aeb630c9c5a'),
(2, 'kyle', 'salt', 'dsad43dfasfafd');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
