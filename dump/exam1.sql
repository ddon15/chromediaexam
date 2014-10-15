-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 15, 2014 at 08:57 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `exam1`
--

-- --------------------------------------------------------

--
-- Table structure for table `userconfirmation`
--

CREATE TABLE IF NOT EXISTS `userconfirmation` (
`id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `confirmed` int(11) NOT NULL,
  `dateSend` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `authCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

--
-- Dumping data for table `userconfirmation`
--

INSERT INTO `userconfirmation` (`id`, `userId`, `confirmed`, `dateSend`, `authCode`) VALUES
(1, 26, 0, '2014-10-10 10:42:03', '54379bdb2fc0b'),
(23, 57, 0, '2014-10-15 08:53:21', '8949e4325ea453a7fcfa5ffb0603fec181b5ab8c'),
(24, 57, 0, '2014-10-15 08:53:56', '31b5937f25cde445e91d86c9a4ff290fc594b228');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `email` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `stat` int(11) NOT NULL,
  `roles` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `salt` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `isActive` int(11) NOT NULL,
  `activationCode` char(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=58 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `lastname`, `firstname`, `stat`, `roles`, `salt`, `isActive`, `activationCode`) VALUES
(10, 'test@test.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w==', 'James', 'Yap2 ', 0, 'ROLE_USER', '', 0, ''),
(44, 'van_van152004@yahoo.com', '4843f05f41b2ced0e3ce116c4c07fdd7fa142fc60e15b912c9c849b475e921d3', 'Donayre', 'Diovannie', 0, 'ROLE_USER', '1377364251543c8a963a5d2', 0, ''),
(45, 'test4@test4.com', 'diovannie', 'test', 'test', 0, 'ROLE_USER', '335480990543c8b06bb894', 0, ''),
(47, 'test3@test3.com', 'E111R/nJdgB1fmeIF/jWX9QZIl8GeuX2ZwBZm7anf0zsDaq1+ceEcIsxYyyGkSemSJUmLEzdGWZYFBJw64zGmA==', 'test', 'test', 1, 'ROLE_USER', '90dbd49ada7b4eea294276cafbd0dec2', 0, ''),
(57, 'diovannie.donayre@chromedia.com', 'ce86debe7799620a9596776045cbfa1dfd98e405e5765ea0df193feaf7f28758', 'Donayre', 'Diovannie', 1, 'ROLE_USER', 'abde8c2d77caef2e814b9099a9167bf7', 0, '75b0a5aae6ff80764ddb8623e82a4f4ddc15be2c');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `userconfirmation`
--
ALTER TABLE `userconfirmation`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `userconfirmation`
--
ALTER TABLE `userconfirmation`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=58;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
