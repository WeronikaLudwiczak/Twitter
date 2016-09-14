-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 14 Wrz 2016, 20:36
-- Wersja serwera: 5.5.50-0ubuntu0.14.04.1
-- Wersja PHP: 5.5.9-1ubuntu4.19

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `twitter_db`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Comment`
--

CREATE TABLE IF NOT EXISTS `Comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `text` varchar(140) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `tweet_id` (`tweet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `Comment`
--

INSERT INTO `Comment` (`id`, `user_id`, `tweet_id`, `creation_date`, `text`) VALUES
(1, 1, 7, '2016-09-09 23:23:23', 'Gratulacje'),
(2, 1, 7, '2016-09-10 23:20:23', 'Dobra robota'),
(3, 1, 7, '2016-10-10 23:20:23', 'Tak trzymaj');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Messages`
--

CREATE TABLE IF NOT EXISTS `Messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `sender_id` int(11) NOT NULL,
  `addresser_id` int(11) NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `if_read` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `addresser_id` (`addresser_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `Messages`
--

INSERT INTO `Messages` (`id`, `content`, `sender_id`, `addresser_id`, `creation_date`, `if_read`) VALUES
(1, 'Do przodu', 3, 1, '2016-04-05 12:23:45', 1),
(2, 'Trzymam kciuki', 3, 1, '2016-06-04 08:32:15', 0),
(3, 'Hej', 1, 3, '2016-08-04 09:32:15', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Tweets`
--

CREATE TABLE IF NOT EXISTS `Tweets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL,
  `content` varchar(140) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Zrzut danych tabeli `Tweets`
--

INSERT INTO `Tweets` (`id`, `creation_date`, `content`, `user_id`) VALUES
(4, '0000-00-00', 'Pierwszy Tweet', 1),
(5, '0000-00-00', 'Pierwszy Tweet', 1),
(6, '0000-00-00', 'Drugi Tweet', 1),
(7, '2016-04-02', 'Drugi Tweet', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `hashed_password` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `User`
--

INSERT INTO `User` (`id`, `email`, `username`, `hashed_password`) VALUES
(1, 'ala8@makota.com', 'ala', '$2y$10$RhgBe4a.svy59LUiEU02s.n4rHSDrI1QXqyTiYDq8FvmCFKi7nXey'),
(3, 'ted@makota.com', 'ted', '$2y$10$SrLSN/BkdwEk5Gk68AHwqOT4hepTCUiGm9Of8vTQQnyop1pYlH.36');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Comment`
--
ALTER TABLE `Comment`
  ADD CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`),
  ADD CONSTRAINT `Comment_ibfk_2` FOREIGN KEY (`tweet_id`) REFERENCES `Tweets` (`id`);

--
-- Ograniczenia dla tabeli `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `User` (`id`),
  ADD CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`addresser_id`) REFERENCES `User` (`id`);

--
-- Ograniczenia dla tabeli `Tweets`
--
ALTER TABLE `Tweets`
  ADD CONSTRAINT `Tweets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
