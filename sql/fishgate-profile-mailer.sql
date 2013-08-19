-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2013 at 01:49 PM
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
-- Table structure for table `lists`
--

CREATE TABLE IF NOT EXISTS `lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `file` text NOT NULL,
  `date` text NOT NULL,
  `unix` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lists`
--

INSERT INTO `lists` (`id`, `name`, `file`, `date`, `unix`) VALUES
(1, '123', 'wallpaper-3914.jpg', '19-08-2013', '1376912785');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `quicksendlogs`
--

INSERT INTO `quicksendlogs` (`id`, `email`, `date`, `unix`, `template`, `opened`, `token`, `ip`, `host`) VALUES
(7, 'kyle@fishgate.co.za', '14-08-2013', 1376466665, 'profilemailer.html', 1, '19ca14e7ea6328a42e0eb13d585e4c22', '', ''),
(8, 'tyrone@fishgate.co.za', '14-08-2013', 1376470391, 'profilemailer.html', 1, '4ea06fbc83cdd0a06020c35d50e1e89a', '', ''),
(9, 'john@john.com', '14-08-2013', 1376472594, 'profilemailer.html', 1, '1ff8a7b5dc7a7d1f0ed65aaa29c04b1e', '', ''),
(10, 'jan@fishgate.co.za', '14-08-2013', 1376472614, 'profilemailer.html', 0, '3621f1454cacf995530ea53652ddf8fb', '', ''),
(11, 'tyrone@gishgate.co.za', '14-08-2013', 1376474289, 'profilemailer.html', 0, '2ab56412b1163ee131e1246da0955bd1', '', ''),
(12, 'asd@sasd.asd', '14-08-2013', 1376478643, 'profilemailer.html', 0, '98b297950041a42470269d56260243a1', '', ''),
(13, '123@123.123', '14-08-2013', 1376478750, 'profilemailer.html', 0, 'f7664060cc52bc6f3d620bcedc94a4b6', '', ''),
(14, '123@123.123', '14-08-2013', 1376482788, 'profilemailer.html', 0, 'ab817c9349cf9c4f6877e1894a1faa00', '', ''),
(15, '123@123.123', '15-08-2013', 1376566913, 'profilemailer.html', 0, '8efb100a295c0c690931222ff4467bb8', '', '');

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
